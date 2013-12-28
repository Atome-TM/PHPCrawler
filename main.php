<?php
//Site à crawler
require_once("crawler.php");

$website = "http://www.thomasmoreira.com"; // Website to crawl

$outputTab = new PHPCrawler($website); // Create a new class PHPCrawler
$outputTab->outputCrawl(); // Get and Generate the XML sitemap
?>
