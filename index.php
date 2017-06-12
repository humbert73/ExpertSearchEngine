<?php

require_once('Entity/Article.php');
use Entity\Article;

$url = "index.php";
$search = "";

if (isset($_GET["search"])) {
    $search = $_GET["search"];
}


include("Parser.php");
$parser = new Parser('src/outputacm.txt');

$articles = $parser->parse();

include("search.php");
