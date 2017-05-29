<?php

/**
 * Created by PhpStorm.
 * User: moreauhu
 * Date: 29/05/17
 * Time: 10:14
 */
class AuthorFactory
{
    function __construct(AuthorDao $author_dao)
    {
        $this->author_dao = $author_dao;
    }

    public function addAuthor($name) {
        try {
            $this->author_dao->createAuthor($name);
        } catch (Exception $exception) {
            $exception->getMessage();
        }
    }
//    public function findAuthorByArticleId($article_id)
//    {
//
//    }
}