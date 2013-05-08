<?php
//Site à crawler
require_once("crawler.php");

$website = "http://www.myclientisrich.com/"; // Website to crawl

$outputTab = crawler($website); // Main function crawler

outputCrawl($outputTab, "xml"); // Get and View XML sitemap
?>
