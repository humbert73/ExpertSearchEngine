<?php

namespace Entity;

use Parser;


class ArticleFactory
{

    private $parser;

    function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    public function getArticles()
    {
        return $this->parser->parseArticles();
    }

    public function findMatchingArticles($search)
    {
        return $this->getArticles();
    }
}