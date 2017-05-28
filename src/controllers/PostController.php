<?php
/**
 * Controller for Posts
 *
 * @author Mateusz P <bananq@gmail.com>
 */

namespace FTwo\controllers;

use FTwo\core\BaseController;
use FTwo\core\F2;
use FTwo\http\HttpMethod;
use FTwo\http\Request;
use FTwo\http\Response;

class PostController extends BaseController
{

    protected function init()
    {
        $this->addRoute(HttpMethod::GET, '/allposts', 'getAllPosts')
            ->addRoute(HttpMethod::POST, '/allposts', 'postAllPosts')
            ->addRoute(HttpMethod::GET, '/post', 'getOnePost');
    }

    protected function getAllPosts(Request $req, Response $res)
    {
        $dbConnection = F2::getDb();

        $posts = $dbConnection->select('id, title')
            ->from('post')
            ->where('published=:published', [':published' => '1'])
            ->orderBy('id desc')
            ->execute();
        var_dump($posts);
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
