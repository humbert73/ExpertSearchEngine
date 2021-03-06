<?php

require_once('Entity/Article.php');
require_once('Entity/ArticleFactory.php');
require_once('Parser.php');

use Entity\ArticleFactory;
use Entity\Article;

$url             = "index.php";
$search          = "";
$type            = "";
$parser          = new Parser('src/outputacm.txt');
$article_factory = new ArticleFactory($parser);

if(isset($_GET["type"])){
    $type = $_GET["type"];
}

if (isset($_GET["search"])) {
    $search = strtolower($_GET["search"]);
    if($type == "author")
        $articles = $article_factory->findMatchingArticles($search, $type);
    else
        $articles = $article_factory->findMatchingArticles($search);
} else {
    $articles = $article_factory->getArticles();
}

if (isset($_GET['article_id'])) {
    $article  = $articles[$_GET['article_id']];

    include('view/Article.php');
} else {

    include("search.php");
}


