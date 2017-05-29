<?php

class AuthorDao
{
    private $sanitize;

    function __construct(Sanitize $sanitize)
    {
        $this->sanitize = $sanitize;
    }

    public function createAuthor($name)
    {

//        $name = $this->sanitize->stringify($name);
//
//        $sql = "INSERT INTO author VALUES $name";

//        $sql->
//        return null; //TODO
    }
}