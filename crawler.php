<?php 

class PHPCrawler
{
	private $format;		// Format of output
	private $tab_links;		// Array of initial links
	private $tablinks;		// Array of all links
	private $site;			// Url of the racine
	private $output;		// Content of output

	function __construct($site)
	{
		$this->format = "xml";		// Default format : XML
		$this->tab_links = array();	
		$this->tablinks = array();	
		$this->site = $site;
		$this->crawler();
	}


	function setFormat($format) {
		if(empty($format)) {
			throw new Exception("You must choose a format! (xml ou array)");
			
		}
		$this->format = $format;
	}

	/*
	 *  Function getTabLinks
	 *  $site : String - Page to crawl
	 *  $options : Array - Link to begin all links
	 *  Return an array of page's links
	 */
	function getTabLinks($site = false, $options = array())
	{
		//On récupère le contenu HTML du lien
		if($site === false)
			$file = file_get_contents($this->site);
		else
			$file = file_get_contents($site);

		$pattern = '/href="(.*)"/U'; // Pattern search for links surround by href = ""
		$retour = preg_match_all($pattern, $file, $matches, PREG_PATTERN_ORDER);
		
		foreach($matches[1] as $key => $value)
		{
			if(!preg_match('/(\.js|mailto.*|tel:*|javascript.*|\.jpg|\.png|\.gif|\.css|#.*)/', $value)) //Retireves only the links with no filetype extension - so will exclude scripts, images etc. 
			{
				if(strpos($value, "http://") !== false OR strpos($value, "https://") !== false)
				{
					if(strpos($value, $site) !== false)
					{
						$this->tab_links[] = $value;
					}
				}
				else
				{
					if(strlen($value) > 1)
					{
						$this->tab_links[] = $this->site.$value;
					}
				}
			}
			//$where = $where + $matches[1][1];
		}

		$this->tab_links = array_unique($this->tab_links);
		return $this->tab_links;
	}

	/*
	 *  Function crawler
	 *  $start : First link to crawl
	 *  Return an array of all website's links (using getTabLinks)
	 */
	function crawler($options = array())
	{	
		//Create the table
		$this->tablinks = $this->getTabLinks($this->site);

		//Loop through until a new link is found, then rescan the table
		$hasNewLink = true;
		while($hasNewLink)
		{
			$hasNewLink = false;
			foreach($this->tablinks as $link)
			{
				//Execute the function on each link of the table and check if each returned link already exists or not
				foreach($this->getTabLinks($link) as $newlink)
				{
					if(!in_array($newlink, $this->tablinks))
					{
						$hasNewLink = true;
						$this->tablinks[] = $newlink;
					}
				}
			}
		}
		$this->tablinks[] = $this->site;
		sort($this->tablinks); // Sorts the final table.
		return $this->tablinks;
	}

	/*
	 *  Function outputCrawl
	 *  $tablinks : Array - Array return by crawler() function
	 *  $format : String - Format of output (only xml for now)
	 *  Print the result in $format
	 */
	function outputCrawl($format = "xml", $type = "I")
	{

		$this->setFormat($format);

		if($this->format == "xml")
		{
			$this->output = "<urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'>\n";
			if(count($this->tablinks) > 0) {
				foreach($this->tablinks as $link)
				{
					$this->output .="\t<url>\n";
					$this->output .= "\t\t<loc>".$link."</loc>\n";
					$this->output .="\t</url>\n";
				}
			}
			$this->output .="</urlset>";

			if($type == "I") {
				header('Content-Type: text/xml');
				echo $this->output;
			} else if ($type == "F") {



				$file = fopen("sitemap.xml", "w+");
				fwrite($file, $this->output);
				fclose($file);

				header("Location: /sitemap.xml");

			}

		} else if ($this->format == "array") {
			return $this->tablinks;
		}
	}
}
?>
