<?php

require_once('Entity/Article.php');
use Entity\Article;

/**
 * Created by PhpStorm.
 * User: moreauhu
 * Date: 12/06/17
 * Time: 09:00
 */


class Parser
{
    private $file_path;
    private $attributes;

    public function __construct($file_path)
    {
        $this->file_path  = $file_path;
        $this->attributes = array(
            'title'       => '/^#\*/',
            'author'      => '/^#@/',
            'time'        => '/^#t/',
            'conference'  => '/^#c/',
            'index'       => '/^#index/',
            'num'         => '/^#%/',
            'description' => '/^#!/'
        );
    }

    public function parse()
    {
        $articles = array();
        $article_number = 0;
        $handle = fopen($this->file_path, 'r');

        if ($handle) {
            while (!feof($handle)) {
                $buffer = fgets($handle);

                if ($this->isNewArticle($buffer)) {
                    $article_number++;
                    $article = $this->getArticle($handle, $buffer);

                    if ($article == null) {
                        fclose($handle);

                        return $articles;
                    } else {
                        $articles[] = $article;
                    }

                    if ($article_number == 3690) {
                        break;
                    }
                }
            }

            fclose($handle);
        }

        return $articles;
    }

    private function isNewArticle($buffer)
    {
        return preg_match($this->attributes['title'], $buffer);
    }

    private function getArticle($handle, $buffer)
    {
        $article = new Article();
        $article->setTitle($this->get('title', $buffer));

        while (!feof($handle)) {
            $buffer = fgets($handle);

            if ($this->is('author', $buffer)) {
                $authors = array();
                $authors = explode(',', $this->get('author', $buffer));
                $article->setAuthors($authors);
            } elseif ($this->is('time', $buffer)) {
                $article->setDate($this->get('time', $buffer));
            } elseif ($this->is('conference', $buffer)) {
                $article->setConference($this->get('conference', $buffer));
            } elseif ($this->is('index', $buffer)) {
                $article->setIndex($this->get('index', $buffer));
            } elseif ($this->is('description', $buffer)) {
                $article->setContent($this->get('description', $buffer));
            } else {
                return $article;
            }
        }

        return null;
    }

    private function is($attribute_type, $buffer) {
        return preg_match($this->attributes[$attribute_type], $buffer);
    }

    private function get($attribute_type, $buffer) {
        return ltrim($buffer, $this->attributes[$attribute_type]);
    }


}