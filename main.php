<?php
//Site à crawler
require_once("functions.php");

$website = "http://www.thomasmoreira.com/"; // Website to crawl

$outputTab = crawler($website); // Main function crawler

outputCrawl($outputTab, "xml"); // Get and View XML sitemap
?>