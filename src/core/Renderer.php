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
        return $this;
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

    public function renderContent()
    {
        $this->inc($this->currentView, $this->viewParams);
    }

    public function getVar(string $key): string
    {
        return $this->globalVariables[$key];
    }
}
