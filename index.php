<?php

require_once('Entity/Article.php');

$url = "index.php";
$search = "";

if (isset($_GET["search"])) {
    $search = $_GET["search"];
}

$article = new Article('Dude, You Can Do It! How to Build a Sweeet PC', 2007, '', ['Michael Schrenk', 'Michael Shrenk'], 7, 'Whether you\'re frustrated with current PC offerings (and their inflated prices) or are simply looking for a cool project to take on, building a computer from the ground up using off-the-shelf parts can offer significant advantages. In these pages, computer dudes Darrel Wayne Creacy and Carlito Vicencio outline those advantages and then show you how to build the computer of your dreams. The pair begins by explaining what components make up a PC and what you need to think about when selecting those components, before helping you determine your needs and suggesting various configurations to fit those uses. Breaking the process down into its simplest terms, the authors provide component lists for a number of different PC setups: for students, home users, multimedia/home-theater enthusiasts, high-end graphic/video/audio producers, and more. Using plain language and plenty of visual and instructional aids--photos, illustrations, diagrams, step-by-step directions, and more--the authors ensure that even someone (like you!) who knows nothing about technology can build the perfect PC! On a more personal note, the authors are donating a percentage of their income from this book to the Breast Cancer Research Foundationï¾to thank all the women in their lives who have supported them and battled the disease. For more information about BCRF, please visit http://www.bcrfcure.org/');


include("search.php");
include("Parser.php");

$parser = new Parser('outputacm.txt');

$articles = $parser->parse();