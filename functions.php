<?php
/*
 *  Function getTabLinks
 *  $site : String - Page to crawl
 *  $start : String - Link to begin all links
 *  Return an array of page's links
 */
function getTabLinks($site, $start = "")
{
  //On récupère le contenu HTML du lien
	$file = file_get_contents($site);
	$tab_links = array();
	$where = 0;
	$pattern = '/href="(.*)"/U'; // Pattern de recherche d'un lien entourer par href=""
	while(preg_match($pattern, substr($file, $where), $matches, PREG_OFFSET_CAPTURE))
	{
		if(!preg_match('/(\.js|javascript.*|\.jpg|\.png|.gif|\.css|#.*)$/', $matches[1][0])) //On ne recupère que les liens n'ayant pas d'extension
		{
			if(strpos($matches[1][0], "http://") !== false OR strpos($matches[1][0], "https://") !== false)
			{
				if(strpos($matches[1][0], $site) !== false)
				{
					$tab_links[] = $matches[1][0];
				}
			}
			else
			{
				if(strlen($matches[1][0]) > 0) {
					$tab_links[] = $start.$matches[1][0];
				}
			}
		}
		$where = $where + $matches[1][1];
	}
	$tab_links = array_unique($tab_links);
	return $tab_links;
}

/*
 *  Function crawler
 *  $start : Link of first link to crawl
 *  Return an array of all website's links (using getTabLinks)
 */
function crawler($start)
{
	$start = "http://micheledighoffer.fr/";

	//Création du tableau de départ
	$tablinks = getTabLinks($start, $start);

	//Boucle tant qu'au moins un nouveau lien a été trouvé, on rescanne le tableau
	$hasNewLink = true;
	while($hasNewLink)
	{
	  $hasNewLink = false;
		foreach($tablinks as $link)
		{
			// On execute la fonction sur chaque lien du tableau et on verifie si chaque lien retourné existe deja ou non
			foreach(getTabLinks($link, $start) as $newlink)
			{
				if(!in_array($newlink, $tablinks))
				{
					$hasNewLink = true;
					$tablinks[] = $newlink;
				}
			}
		}
	}
	sort($tablinks); // Trie du tableau finale
	return $tablinks;
}

/*
 *  Function outputCrawl
 *  $tablinks : Array - Array return by crawler() function
 *  $format : String - Format of output (only xml for now)
 *  Print the result in $format
 */
function outputCrawl($tablinks, $format = "xml")
{
	if($format == "xml")
	{
		$output = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
		foreach($tablinks AS $link)
		{
			$output .="<url>";
			$output .= '<loc>'.$link.'</loc>';
			$output .="</url>";
		}
		$output .="</urlset>";

		header('Content-Type: text/xml');
		echo $output;
	}
}
?>