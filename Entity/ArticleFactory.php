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
        $index_tab_indiced_by_weight = $this->getIndexArticlesByWeight($articles);
        $articles_index_array = $this->getArticlesIndexOrderByDescendentWeight($index_tab_indiced_by_weight);

        return $this->getMatchingArticlesByIndex($articles, $articles_index_array);
    }

    private function getIndexArticlesByWeight(array $articles)
    {
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

        return $index_tab_indiced_by_weight;
    }

    private function getArticlesIndexOrderByDescendentWeight(array $index_tab_indiced_by_weight)
    {
        $articles_index_array = array();

        foreach ($index_tab_indiced_by_weight as $weight => $articles_index) {
            $articles_index_array_exloded = explode(' ', $articles_index);
            foreach ($articles_index_array_exloded as $article_index) {
                $articles_index_array[] = $article_index;
            }
        }

        return $articles_index_array;
    }

    private function getMatchingArticlesByIndex(array $articles, array $articles_index_array)
    {
        $best_articles_matched = array();

        foreach ($articles_index_array as $key => $article_index) {
            $best_articles_matched[] = $articles[$article_index];
        }

        return $best_articles_matched;
    }
}