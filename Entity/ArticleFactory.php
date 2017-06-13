<?php

namespace Entity;

use Parser;
use Article;


class ArticleFactory
{

    private $parser;

    function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    public function getArticles()
    {
        return $this->parser->parseArticles(array());
    }

    public function findMatchingArticles($search)
    {
        $keywords = explode(' ', $search);

        return $this->parser->parseArticles($keywords);
    }
}