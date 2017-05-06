<?php

namespace FTwo\controllers;

use FTwo\core\BaseController;
use FTwo\http\Request;
use FTwo\http\Response;

/**
 * Error controller
 *
 * @author Mateusz P <bananq@gmail.com>
 */
class ErrorController extends BaseController
{

    protected function init()
    {

    }

    public function serveHttpError(Request $request, Response $response)
    {
        $exception = $response->exception;
        if (null !== $exception) {
            $errorCode = $exception->getCode();
            $response->setStatus($errorCode)
                ->render('errors/error',
                    [
                    'code' => $errorCode,
                    'errorMessage' => $exception->getMessage()
            ]);
        }
    }

    public function serveOtherError(Request $request, Response $response)
    {
        $exception = $response->exception;
        if (F2::getEnvironment()->isDev()) {
            var_dump($exception->getTrace());
            throw $exception;
        } else {
            $errorCode = $exception->getCode();
            //TODO: we have to log here
            $response->setStatus($errorCode)
                ->render('errors/error',
                    [
                    'code' => \FTwo\http\StatusCode::HTTP_INTERNAL_SERVER_ERROR,
                    'errorMessage' => $exception->getMessage()
            ]);
        }
    }
}
