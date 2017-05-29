<?php



class Author
{
    private $id;
    private $name;

    function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
}