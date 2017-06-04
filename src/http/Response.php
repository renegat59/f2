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
    private $variables = [];
    private $httpStatus;

    public $exception;

    public function setStatus(int $statusCode): Response
    {
        $this->httpStatus = $statusCode;
        http_response_code($statusCode);
        return $this;
    }

    public function getStatus(): int
    {
        return http_response_code();
    }

    public function addHeader(string $header): Response
    {
        header($header);
        return $this;
    }

    public function render(string $view, array $params): Response
    {
        $template = F2::getConfig('params.template');
        $renderer = new \FTwo\core\Renderer($template, $this->variables);
        $renderer->render($view, $params);
        return $this;
    }

    public function send(string $content, string $contentType = 'text/html'): Response
    {
        $this->addHeader('Content-Type: '.$contentType);
        echo $content;
        return $this;
    }

    /**
     * This function indicates, that the response is done. It basically exits() the code, but we may want to add more
     * functinoality to this in the future.
     */
    public function done()
    {
        $this->httpStatus = $this->httpStatus ?? StatusCode::HTTP_OK;
        exit();
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

    /**
     * Gets the variable that was stored in response
     * @param string $variable Name of the variable
     * @return mixed Variable that was previously stored in the response. If variable is not available returns null.
     */
    public function getVariable(string $variable)
    {
        return $this->variables[$variable] ?? null;
    }
}
