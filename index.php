<?php

$url = "index.php";

if (isset($_GET["search"])) {
    $search = $_GET["search"];
}

include("search.php");