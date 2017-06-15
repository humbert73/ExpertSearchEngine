<?php

namespace Entity;

class Article
{
    private $title;
    private $date;
    private $conference;
    private $authors;
    private $index;
    private $content;
    private $weight;

    function __construct()
    {
        $this->title      = null;
        $this->date       = null;
        $this->conference = null;
        $this->authors    = array();
        $this->index      = null;
        $this->content    = null;
        $this->weihgt     = 1;
    }

    public function setTitle($title)
    {
        $this->title = trim($title);
    }

    public function setDate($date)
    {
        $this->date = trim($date);
    }

    public function setConference($conference)
    {
        $this->conference = trim($conference);
    }

    public function setAuthors($authors)
    {
        $this->authors = $authors;
    }

    public function setIndex($index)
    {
        $this->index = trim($index);
    }

    public function setContent($content)
    {
        $this->content = trim($content);
    }

    public function appliedWeight(array $search_keywords)
    {
        $this->weight = 1;

        if (! empty($search_keywords)) {
            $article_keywords = $this->getKeywords();
            foreach ($article_keywords as $keyword => $keyword_weight) {
                if (in_array(trim($keyword), $search_keywords)) {
                    $this->weight += intval($keyword_weight);
                }
            }
        }
    }

    function getTitle()
    {
        return $this->title;
    }

    function getDate()
    {
        return $this->date;
    }

    function getConference()
    {
        return $this->conference;
    }

    public function getAuthors()
    {
        return $this->authors;
    }

    public function getIndex()
    {
        return $this->index;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function getWeight()
    {
        return $this->weight;
    }

    public function getShortContent()
    {
        if (strlen($this->getContent()) > 300) {
            return substr($this->getContent(), 0, 300);
        } else {
            return $this->getContent();
        }
    }

    public function getKeywords()
    {
        if (strlen($this->getContent()) < 1) {
            return [];
        }

        $tabWeight = [];
        $tabKeys   = explode(' ', preg_replace('/[^a-z]+/i', ' ', strtolower($this->getContent())));
        $tabTitle  = explode(' ', preg_replace('/[^a-z]+/i', ' ', strtolower($this->getTitle())));

        // Ajout de 1 au poids d'un mot à chaque fois qu'il est trouvé dans l'article
        foreach ($tabKeys as $key) {
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
        $totalWords = strlen(preg_replace('/[^a-z]+/i', ' ', strtolower($this->getContent())));
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
            't',
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
            'a',
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
            'e',
            'g',
            'from',
            'these',
            'there',
            'are',
            's',
            'www'
        ];

        // Liste établie avec l'aide de :
        // http://grammar.yourdictionary.com/style-and-usage/list-transition-words.html#bbbsZvDL4ZHMG8yF.99
        return $words;
    }
}