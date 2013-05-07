//Site à crawler
require_once("functions.php");

$racine = "http://www.thomasmoreira.fr";

//Création du tableau de départ
$premier = getTabLinks($racine, $racine);

//Boucle tant qu'au moins un nouveau lien a été trouvé, on rescanne le tableau
$newlien = true;
while($newlien)
{
  $newlien = false;
	foreach($premier as $link)
	{
		// On execute la fonction sur chaque lien du tableau et on verifie si chaque lien retourné existe deja ou non
		foreach(getTabLinks($link, $racine) as $lien)
		{
			if(!in_array($lien, $premier))
			{
				$newlien = true;
				$premier[] = $lien;
			}
		}
	}
}
sort($premier); // Trie du tableau finale
print_r($premier);
