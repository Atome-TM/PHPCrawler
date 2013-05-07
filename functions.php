function getTabLinks($site, $racine = "")
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
					$tab_links[] = $racine.$matches[1][0];
				}
			}
		}
		$where = $where + $matches[1][1];
	}
	$tab_links = array_unique($tab_links);
	return $tab_links;
}
