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

    public function getKeywords($article){
        if (strlen($article->getContent()) < 1) {
            return [];
        }

        $tabWeight = [];
        $tabKeys   = explode(' ', preg_replace('/[^a-z]+/i', ' ', strtolower($article->getContent())));
        $tabTitle  = explode(' ', preg_replace('/[^a-z]+/i', ' ', strtolower($article->getTitle())));

        // Ajout de 1 au poids d'un mot à chaque fois qu'il est trouvé dans l'article
        foreach ($tabKeys as $key) {
            // Retrait des mots à une lettre
            if(strlen($key) > 1){
                if (array_key_exists($key, $tabWeight)) {
                    $tabWeight[$key]++;
                } else {
                    $is_sim = false;
                    foreach ($tabWeight as $tw => $v) {
                        // Si le mot n'est pas présent mais qu'un mot très similaire existe, on lui ajoute 1
                        // Permet de gérer le cas des mots au singulier/pluriel
                        similar_text($tw, $key, $sim);
                        if ($sim > 90) {
                            $tabWeight[$tw]++;
                            $is_sim = true;
                        }
                    }

                    // Si le mot n'est pas présent et aucun mot n'est très similaire
                    // On ajoute une entrée pour ce mot
                    if (!$is_sim) {
                        $tabWeight[$key] = 1;
                    }
                }
            }
        }

        // Ajout de 2 au poids des mots trouvés dans le titre : mots plus importants
        // Mais seulement 1 si c'est la première fois qu'on les retrouve (ils sont dans le titre mais ne sont pas répétés dans l'article...
        foreach ($tabTitle as $key) {
            if (array_key_exists($key, $tabWeight)) {
                $tabWeight[$key] += 2;
            } else {
                $tabWeight[$key] = 1;
            }
        }

        $transitionWords = $this->getTransitionWords();


        // Tri par nombre d'apparitions
        arsort($tabWeight);
        $tabValues = [];
        $tabFinal  = [];

        foreach ($tabWeight as $key => $value) {
            if (!in_array($key, $transitionWords) && $value > 1) {
                $tabValues[$key] = $value;
            }
        }


        // Harmonisation des poids : poids du mot dans le texte selon la longueur du texte
        $totalWords = strlen(preg_replace('/[^a-z]+/i', ' ', strtolower($article->getContent())));
        foreach ($tabValues as $key => $value) {
            $calc = ($value * 1000) / $totalWords;
            if ($calc > 1) {
                $tabFinal[$key] = $calc;
            }
        }

        return $tabFinal;
    }

    private function getTransitionWords()
    {
        $words = [
            'therefore',
            'however',
            'moreover',
            'lastly',
            'next',
            'also',
            'furthermore',
            'in',
            'by',
            'those',
            'about',
            'their',
            'what',
            'the',
            'and',
            'or',
            'more',
            'less',
            'to',
            'at',
            'new',
            'have',
            'has',
            'can',
            'set',
            '',
            'you',
            'your',
            're',
            'on',
            'll',
            'just',
            'too',
            'when',
            'where',
            'who',
            'how',
            'let',
            'is',
            'was',
            'will',
            'be',
            'make',
            'of',
            'similarly',
            'likewise',
            'accordingly',
            'hence',
            'consequently',
            'as',
            'an',
            'result',
            'thereby',
            'otherwise',
            'subsequently',
            'thus',
            'so',
            'then',
            'wherefore',
            'generally',
            'ordinarily',
            'usually',
            'for',
            'the',
            'most',
            'part',
            'such',
            'example',
            'this',
            'that',
            'all',
            'use',
            'with',
            'used',
            'it',
            'we',
            'he',
            'she',
            'they',
            'one',
            'from',
            'these',
            'there',
            'are',
            'www',
            'co',
            'uk',
            'com'
        ];

        // Liste établie avec l'aide de :
        // http://grammar.yourdictionary.com/style-and-usage/list-transition-words.html#bbbsZvDL4ZHMG8yF.99
        return $words;
    }
}