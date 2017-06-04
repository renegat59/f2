<?php

namespace FTwo\controllers;

use FTwo\core\BaseController;
use FTwo\core\F2;
use FTwo\http\Request;
use FTwo\http\Response;
use FTwo\http\StatusCode;

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
                ->render(
                    'errors/error',
                    [
                        'code' => $errorCode,
                        'errorMessage' => $exception->getMessage()
                    ]
                );
        }
    }

    public function serveOtherError(Request $request, Response $response)
    {
        $exception = $response->exception;
        if (F2::getEnvironment()->isDev()) {
            echo $exception->getMessage();
            echo "\r\n--------\r\n";
            echo $exception->getTraceAsString();
            throw $exception;
        }
        $errorCode = $exception->getCode();
        //TODO: we have to log here
        $response->setStatus($errorCode)
            ->render(
                'errors/error',
                [
                    'code' => StatusCode::HTTP_INTERNAL_SERVER_ERROR,
                    'errorMessage' => F2::i18n($exception->getMessage())
                ]
            );
    }

    private function printStackTrace()
    {
    }
}
