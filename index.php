<?php

require_once('Entity/Article.php');
require_once('Parser.php');
use Entity\Article;

$url = "index.php";
$search = "";
$parser = new Parser('src/outputacm.txt');

if (isset($_GET['article_id'])) {
    if (isset($_COOKIE["articles"])) {
        $articles = unserialize($_COOKIE["articles"]);
        $article  = $articles[$_GET['article_id']];
    } else {
        $articles = $parser->parse();
    }

    $article  = $articles[$_GET['article_id']];

    include('view/Article.php');
} else {
    if (isset($_GET["search"])) {
        $search = $_GET["search"];
        //TODO: getArticleBySearchRequest()
        $articles = $parser->parse();
    } else {
        $articles = $parser->parse();
    }

//    setcookie("articles", serialize($articles));

    include("search.php");

}


