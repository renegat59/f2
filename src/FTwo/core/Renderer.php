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
    private $viewVariables = array();
    private $extension = 'php';
    private $currentView;

    /**
     * variable prefix for avoiding conflicts
     */
    const VAR_PREFIX = '_f2';

    public function __construct(string $template, array $viewVariables)
    {
        $this->template = $template;
        $this->viewVariables = $viewVariables;
    }

    public function render(string $view, array $params): Renderer
    {
        $this->currentView = $view;
        $root = $this->getViewPath('root');
        $pageToRender = $this->runIncludes($root);
        $content = $this->insertVariables($pageToRender);
        $variables = array_merge($this->viewVariables, $params);
        $this->renderView($content, $variables);
        return $this;
    }

    /**
     * This function should run recursively the includes in the template and generate one string to render
     */
    private function runIncludes(string $filePath): string
    {
        $fileContent = file_get_contents($filePath);

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
            ],
            $content
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
}
