<?php

namespace Entity;
require_once("ArticleFactory.php");

class Article
{
    private $title;
    private $date;
    private $conference;
    private $authors;
    private $index;
    private $content;
    private $weight;
    private $_factory;

    function __construct($factory)
    {
        $this->title      = null;
        $this->date       = null;
        $this->conference = null;
        $this->authors    = array();
        $this->index      = null;
        $this->content    = null;
        $this->weihgt     = 1;

        $this->_factory = $factory;
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
            $article_keywords = $this->_factory->getKeywords($this);
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
}