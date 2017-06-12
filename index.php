<?php

$url = "index.php";
$search = "";

if (isset($_GET["search"])) {
    $search = $_GET["search"];
}

include("search.php");
include("Parser.php");

$parser = new Parser('outputacm.txt');

$articles = $parser->parse();