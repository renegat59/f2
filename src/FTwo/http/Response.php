<?php

namespace FTwo\http;

use \FTwo\core\F2;

/**
 * Class containing HTTP Response information
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class Response
{
    private $variables = array();

    public function setStatus(int $statusCode): Response
    {
        http_response_code($statusCode);
        return $this;
    }

    public function getStatus(): int
    {
        return http_response_code();
    }

    public function render(string $view, array $params): Response
    {
        $template = F2::getConfig('params.template');
        $renderer = new \FTwo\core\Renderer($template, $this->variables);
        $renderer->render($view, $params);
//        echo $this->getStatus();
        return $this;
    }

    /**
     * Adds a variable to the rendered view;
     * @param string $variable
     * @param string $value
     * @return \FTwo\http\Response
     */
    public function addVariable(string $variable, string $value): Response
    {
        $this->variables[$variable] = $value;
        return $this;
    }
}
