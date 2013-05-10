<?php
//Site à crawler
require_once("crawler.php");

$website = "http://www.micheledighoffer.fr/"; // Website to crawl

$outputTab = getTabLinks($website); // Main function crawler

outputCrawl($outputTab, "xml"); // Get and View XML sitemap
?>