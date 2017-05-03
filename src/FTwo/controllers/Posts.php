<?php
/**
 * Controller for Posts
 *
 * @author Mateusz P <bananq@gmail.com>
 */

namespace FTwo\controllers;

use FTwo\core\BaseController;
use FTwo\http\HttpMethod;
use FTwo\http\Request;
use FTwo\http\Response;

class Posts extends BaseController
{

    protected function init()
    {
        $this->addRoute(HttpMethod::GET, 'all', 'getAllPosts');
        $this->addRoute(HttpMethod::POST, 'all', 'postAllPosts');
        $this->addRoute(HttpMethod::GET, 'one', 'getOnePost');
    }

    protected function getAllPosts(Request $req, Response $res)
    {
        echo 'All posts';
    }

    protected function postAllPosts(Request $req, Response $res)
    {
        echo 'All posts posted';
    }

    protected function getOnePost(Request $req, Response $res)
    {
        $id = $req->get('id');
        echo $id;
    }
}
