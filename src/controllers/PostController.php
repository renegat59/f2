<?php
/**
 * Controller for Posts
 *
 * @author Mateusz P <bananq@gmail.com>
 */

namespace FTwo\controllers;

use FTwo\core\BaseController;
use FTwo\core\exceptions\HttpException;
use FTwo\core\F2;
use FTwo\http\HttpMethod;
use FTwo\http\Request;
use FTwo\http\Response;
use FTwo\http\StatusCode;

class PostController extends BaseController
{

    protected function init()
    {
        $this->addRoute(HttpMethod::GET, '/allposts', 'getAllPosts')
            ->addRoute(HttpMethod::GET, '/post/:id', 'getOnePost');
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
        $dbConnection->close();
    }

    protected function getOnePost(Request $req, Response $res)
    {
        $postId = $req->get('id');
        $dbConnection = F2::getDb();
        $post = $dbConnection->select('title, content, created, author_id')
            ->from('post')
            ->where('id=:id', [':id'=>$postId])
            ->execute();
        if (empty($post)) {
            throw new HttpException(StatusCode::HTTP_NOT_FOUND, F2::i18n('Post not found'));
        }
        $author = $dbConnection->select('alias')
            ->from('author')
            ->where('id=:id', [':id'=>$post['author_id']]);

        $dbConnection->close();

        $res->render(
                'posts/post',
                [
                    'post'=>$post,
                    'author'=>$author['alias']
                ]
            );
        
    }
}
