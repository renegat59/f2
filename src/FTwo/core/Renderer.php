<?php

namespace FTwo\core;

/**
 * Description of Renderer
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class Renderer
{
    private $template = 'default';
    private $globalVariables = array();
    private $extension = 'php';
    private $currentView;
    private $viewParams = array();

    /**
     * variable prefix for avoiding conflicts
     */
    const VAR_PREFIX = '_f2';

    public function __construct(string $template, array $globalVariables)
    {
        $this->template = $template;
        $this->globalVariables = $globalVariables;
    }

    public function render(string $view, array $params): Renderer
    {
        $this->currentView = $view;
        $this->viewParams = $params;
        $this->inc('root');
//        $pageToRender = $this->runIncludes($root);
//        $content = $this->insertVariables($pageToRender);
//        $variables = array_merge($this->globalVariables, $params);
//        $this->renderView($content, $variables);
        return $this;
    }

    /**
     * This function should run recursively the includes in the template and generate one string to render
     */
    private function runIncludes(string $filePath): string
    {
        $fileContent = file_get_contents($filePath);
        eval($fileContent);
        $insertedContent = preg_replace_callback_array([
            '/(\{\{include\((?P<view>.*?)\)\}\})/' => function ($match) {
                //runs the include
                return $this->runIncludes($this->getViewPath($match['view']));
            },
            '/(\{\{renderContent\(\)\}\})/' => function () {
                //runs the include on the main conent of the page
                return $this->runIncludes($this->getViewPath($this->currentView));
            }
            ], $fileContent);
        return $insertedContent;
    }

    protected function includeView($file)
    {
        require $this->getViewPath($file);
    }

    /**
     * Includes the view with the passed params
     */
    protected function inc(string $view, array $vars = array())
    {
        $viewPath = $this->getViewPath($view);
        extract($vars);
        require($viewPath);
    }

    private function renderView(string $_content, array $_variables): string
    {
        extract($_variables, EXTR_PREFIX_ALL, self::VAR_PREFIX);
        eval("?>$_content");
    }

    private function insertVariables(string $content): string
    {
        $phpContent = preg_replace_callback_array(
            [
            '/(\{\{=(?P<var>.*?)\}\})/' => function ($match) {
                //replaces simple variable:
                $var = $match['var'];
                return '<?php echo $_f2_'.$var.'; ?>';
            }
            ], $content
        );
        return $phpContent;
    }

    private function getViewPath($view): string
    {
        return F2::getPath('templates'.
                DIRECTORY_SEPARATOR.$this->template.
                DIRECTORY_SEPARATOR.$view).
            '.'.$this->extension;
    }

    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    public function renderContent(): string
    {
        $this->inc(
            $this->currentView, $this->viewParams
        );
    }

    public function getVar(string $key): string
    {
        return $this->globalVariables[$key];
    }
}
