PHPCrawler
==========

Script de Crawl en PHP dans le but de créer un sitemap personnalisé.

Cette petite classe, va vous permettre de générer par exemple le sitemap de votre site.

A l'aide d'une tâche cron, vous pourriez ensuite automatiser la génération de votre sitemap afin qu'il soit tout le temps à jour.


Ce script est à votre disposition, il permet plus généralement de crawler un site web.


Créer par Thomas Moreira (www.thomasmoreira.fr)


PHP Crawler (English)
=======


This script will crawl all pages in the directory to create a custom sitemap. 

Using a cron job, you could automate the generation of your sitemap so that it is updated periodically, or run it yourself manually when you have made a change.


To Use
======

On line 5 of main.php change the domain to your own. If you want to test on your localhost enter local host and the port number instead.

```
$website = "http://www.thomasmoreira.fr"; // Change this to your domain

```
Add crawler.php and main.php to the root directory - then open main.php to run the crawler.

The sitemap.xml will output to the root as normal, so you can access the sitemap with http://yoursitedomain.com/sitemap.xml and submit this to your chosen search engine.