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
        $keywords = explode(' ', trim($search));
        $articles = $this->parser->parseArticles($keywords);

        return $this->getTenFirstArticlesSortByWeight($articles);
    }

    private function getTenFirstArticlesSortByWeight(array $articles)
    {
        $best_articles_matched = array();
        $index_tab_indiced_by_weight = array();

        foreach ($articles as $article) {
            $weight = $article->getWeight();
            if ($weight > 1) {
                if (isset ($index_tab_indiced_by_weight[$weight])) {
                    $index_tab_indiced_by_weight[$weight] .= ' '.$article->getIndex();
                } else {
                    $index_tab_indiced_by_weight[$weight] = $article->getIndex();
                }
            }
        }

        krsort($index_tab_indiced_by_weight);
        $count = 10;
        $articles_index_array = array();
        foreach ($index_tab_indiced_by_weight as $weight => $articles_index) {
            $articles_index_array_exloded = explode(' ', $articles_index);
            foreach ($articles_index_array_exloded as $article_index) {
                $articles_index_array[] = $article_index;
            }

            if ($count <= count($articles_index_array)) {
                break;
            }
        }

        foreach ($articles_index_array as $key => $article_index) {
            $best_articles_matched[] = $articles[$article_index];
        }

        return $best_articles_matched;
    }
}