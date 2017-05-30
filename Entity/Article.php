<?php



class Article
{
    private $title;
    private $date;
    private $conference;
    private $author;
    private $index;
    private $content;

    function __construct($title, $date, $conference, $author, $index, $content)
    {
        $this->title = $title;
        $this->date = $date;
        $this->conference = $conference;
        $this->author = $author;
        $this->index = $index;
        $this->content = $content;
    }
}