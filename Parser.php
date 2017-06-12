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
    private $articles;
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
        $int = 0;
        $handle = fopen($this->file_path, 'r');

        if ($handle) {
            while (!feof($handle)) {
                $buffer = fgets($handle);

                if ($this->isNewArticle($buffer)) {
                    $int++;
                    $article = $this->getArticle($handle, $buffer);
                    $articles[] = $article;
                }
                if ($int == 100) {
                    break;
                }
            }
            echo '<pre>';
//            var_dump($articles);
            echo '</pre>';
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
        $title = $this->get('title', $buffer);
        $author = null;
        $date = null;
        $conference = null;
        $index = null;
        $num = null;
        $content = null;

        while (!feof($handle)) {
            $buffer = fgets($handle);

            if ($this->is('author', $buffer)) {
                $author = $this->get('author', $buffer);
            } elseif ($this->is('time', $buffer)) {
                $date = $this->get('time', $buffer);
            } elseif ($this->is('conference', $buffer)) {
                $conference = str_replace(array("\n", "\t", "\r"), '', $this->get('conference', $buffer));
            } elseif ($this->is('index', $buffer)) {
                $index = $this->get('index', $buffer);
            } elseif ($this->is('description', $buffer)) {
                $content = str_replace(array("\n", "\t", "\r"), '', $this->get('description', $buffer));
            } else {
                return new Article($title, $date, $conference, $author, $index, $content);
            }
        }

        return false;
    }

    private function is($attribute_type, $buffer) {
        return preg_match($this->attributes[$attribute_type], $buffer);
    }

    private function get($attribute_type, $buffer) {
        return ltrim($buffer, $this->attributes[$attribute_type]);
    }


}