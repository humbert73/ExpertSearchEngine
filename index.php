<?php

$url = "index.php";
$search = "";

if (isset($_GET["search"])) {
    $search = $_GET["search"];
}

include("search.php");