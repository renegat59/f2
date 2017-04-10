<?php
/**
 * Controller for Posts
 *
 * @author Mateusz P <bananq@gmail.com>
 */

namespace FTwo\controllers;

class Posts extends \FTwo\core\BaseController
{

    public function all(\FTwo\http\Request $req, \FTwo\http\Response $res)
    {
        echo 'All posts';
    }

    public function one(\FTwo\http\Request $req, \FTwo\http\Response $res)
    {
        $id = $req->get('id');
        echo $id;
    }
}
