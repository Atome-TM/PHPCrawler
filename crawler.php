<?php
/*
 *  Function getTabLinks
 *  $site : String - Page to crawl
 *  $options : Array - Link to begin all links
 *  Return an array of page's links
 */
function getTabLinks($site)
{
	//On récupère le contenu HTML du lien
	$file = file_get_contents($site);
	$tab_links = array();

	$pattern = '/href="(.*)"/U'; // Pattern de recherche d'un lien entourer par href=""
	$retour = preg_match_all($pattern, $file, $matches, PREG_PATTERN_ORDER);
	
	foreach($matches[1] as $key => $value)
	{
		if(!preg_match('/(\.js|javascript.*|\.jpg|\.png|.gif|\.css|#.*)$/', $value)) //On ne recupère que les liens n'ayant pas d'extension
		{
			if(strpos($value, "http://") !== false OR strpos($value, "https://") !== false)
			{
				if(strpos($value, $site) !== false)
				{
					$tab_links[] = $value;
				}
			}
			else
			{
				if(strlen($value) > 0)
				{
					$tab_links[] = $site.$value;
				}
			}
		}
		//$where = $where + $matches[1][1];
	}
	$tab_links = array_unique($tab_links);
	return $tab_links;
}

/*
 *  Function crawler
 *  $start : Link of first link to crawl
 *  Return an array of all website's links (using getTabLinks)
 */
function crawler($start, $options  = array())
{
	//Création du tableau de départ
	$tablinks = getTabLinks($start, $options);

	//Boucle tant qu'au moins un nouveau lien a été trouvé, on rescanne le tableau
	$hasNewLink = true;
	while($hasNewLink)
	{
	  $hasNewLink = false;
		foreach($tablinks as $link)
		{
			// On execute la fonction sur chaque lien du tableau et on verifie si chaque lien retourné existe deja ou non
			foreach(getTabLinks($link, $options) as $newlink)
			{
				if(!in_array($newlink, $tablinks))
				{
					$hasNewLink = true;
					$tablinks[] = $newlink;
				}
			}
		}
	}
	$tablinks[] = $start;
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
		if(count($tablinks) > 0) {
			foreach($tablinks AS $link)
			{
				$output .="<url>";
				$output .= '<loc>'.$link.'</loc>';
				$output .="</url>";
			}
		}
		$output .="</urlset>";

		header('Content-Type: text/xml');
		echo $output;
	}
}
?>
