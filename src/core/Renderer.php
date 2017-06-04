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
        //tODO: wywala sie tu
        return $this->globalVariables[$key];
    }
}
