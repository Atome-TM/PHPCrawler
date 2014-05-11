<?php
//Site à crawler
require_once("crawler.php");

$website = "http://www.thomasmoreira.fr"; // Website to crawl

$outputTab = new PHPCrawler($website); // Create a new class PHPCrawler

// Example 1 : Output inline XML format (By default 'xml', 'I')
$outputTab->outputCrawl();

// Example 2 : Return a PHP array
$return = $outputTab->outputCrawl("array");

// Example 3 : Ceate and redirect to a Sitempa.xml file
$outputTab->outputCrawl("xml", "F"); // Get and Generate the XML sitemap
?>
