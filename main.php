//Site à crawler
require_once("functions.php");

$start = "http://www.thomasmoreira.fr";

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
print_r($tablinks);

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
