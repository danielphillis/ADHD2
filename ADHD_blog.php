<?php
	/**
     * code augmented by daniel phillis for Flinders University 2017
	 * daniel.phillis@gmail.com
     */


	#turn off warnings
	error_reporting(E_ALL ^  E_NOTICE);
	/* high-level control for blog display */
	/* URL ised in links to link to the blog directly */
	$url = 'https://blogs.flinders.edu.au/digital-heritage/feed/'; 
	
	/* toggle the use of bluletPoints on displayed blog entries */
	$bulletPointToggle = 1; 
	
	/* size in Pixels of the bullet Points (only used if displayed with toggle variable above) */
	$pointSize = 15;
	
	/* toggles whether or not the blog entries are displayed in a table - !experimental code! */ 
	$isInTable = 1; 
	$tableBorder = 0;

	/* controls the number of blog entries to display in the blogContainer DIV */
	$entryCount = 4; 
	/*------------------------------------*/

	echo '<h3 id="headerTitle">';
	#echo 'style="vertical-align: middle;"';
	#echo '>';
	echo '<a href="'.$url.'">';

	/* blogger image icon */
	/*
	echo '<img src="../images/icons/blogger.png" 
			width ="25" 
			height="25" 
			align ="center" 
			vert-align="middle" 
			alt="blogger icon">'; */
	
	echo '</a>';
	echo 'BLOG ENTRIES</h3><p>';
	
	/* do not need to look at header when dealing with XML ? */
	if (!$array = get_headers($url)){
			#exit;
	} /* see 'apache_request_headers' in the php documentation for detail */
	$string = $array[0];
	if(!strpos($string,"200")){ 
		#CONNECTION IS INVALID
		/*  if '200' is not at position zero ie the first 'word' in the response 
			then a successful request has NOT been made, as a successful request will start with '200'
			see 'https://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html' for details */
		
		# strpos — Find the position of the first occurrence of a substring in a string

		echo '<br>invalid URL:'.$string;
		echo 'Our apologies, but there are currently no entries available for display.';

	}else{ 
		/** CONNECTION IS VALID
		 *  therefore check to see if the URL to the ADHD blog on the Flinders website
			exists (must change the URL if the blog page is relocated). */


		$contents = file_get_contents($url);

		/** there are several ways to parse xml on from a file or URL
			1. string manipulation method (omitted here)

			2. JSON -> PHP ARRAY
				$json = json_encode($xml);
				$array = json_decode($json,TRUE);
				display error count and messages
				echo json_last_error(); # 4 (JSON_ERROR_SYNTAX)
				echo json_last_error_msg(); # unexpected character

				print_r($array);

			3. what seems like the simplest method: SIMPLE XML (used below)

			$xml = simplexml_load_string($contents) or die("Error: Cannot create object");
			if($xml === false) {
				echo "Failed loading XML: ";
    			foreach(libxml_get_errors() as $error) {
        			echo "<br>", $error->message;
    			}
			}else{
				echo $xml->version . '<br>';
			}
		*/

		$items = new simpleXMLElement($contents) or die("Error: Cannot create object");
		libxml_use_internal_errors(true);	

		/** display the last $entryCount (4) entries */
		
		if($isInTable){

			/** use a table to display the blog entries */

			echo '<table border="'.$tableBorder.'" style="
				padding-left: 15px;"
				padding-right: 15px;"
				>';

			for($j=0;$j<$entryCount;$j++){
				
				/* Extract Title */
				echo '<b>';
				echo '<td>';
				
				/* blogger image */
				echo '<img src="../images/icons/bulletPointSkyBlue.png"'.
					' width ="'.$pointSize.'"'.'height="'.$pointSize.'" alt="blogger icon">';
				echo '&nbsp;';
				echo '</td><td>';

				/* Create Link */
				echo '<a href="';
				echo $items->channel[0]->item[$j]->link;
				echo '" target="_blank">';

				/* Echo TITLE */
				echo $items->channel[0]->item[$j]->title;
				echo '</b>';
				
				/* Close Link */
				echo '</a>';
				echo '<br>';

				/* Extract date */
				#echo '<div id="blogDate" >';
				$date = $items->channel[0]->item[$j]->pubDate;
				$date = substr($date, 0, -15); /* -15 removes time and time zone info */
				echo $date;
				echo '<br>';
				echo '</div>';
				echo '</td><tr><td></td><td>';

				/* Extract Author */
				#echo '<div id="blogEntryByWho">';
				$auth = $items->channel[0]->item[$j]->creator;
				if (strlen($auth)){
					echo ' by: '.$auth.'<br>';
				}
				echo '<br>';
				echo '</div>'; /* end of blog entry details*/
				echo '</td></tr>';
			}
			echo '</td></table>';
		
		}else{ /* do not use a table to format the display the blog entries */

			for($j=0;$j<$entryCount;$j++){
		
				/* Create Link */
				echo '<a href="';
				echo $items->channel[0]->item[$j]->link;
				echo '" target="_blank">';

				/* blogger image */
				echo '<img src="../images/icons/bulletPointSkyBlue.png"'.
					' width ="'.$pointSize.'"'.'height="'.$pointSize.'" alt="blogger icon">';
				echo '&nbsp;';
				
				/* title */
				echo $items->channel[0]->item[$j]->title;
				echo '</b>';
				
				/* Close Link */
				echo '</a>';
				echo '<br>';

				/* Extract Author */
				#echo '<div id="blogEntryByWho">';
				$auth = $items->channel[0]->item[$j]->creator;
				if (strlen($auth)){
					echo ' by: '.$auth.'<br>';
				}else{
					#null
				}

				/* Extract Date */
				$date = $items->channel[0]->item[$j]->pubDate;
				$date = substr($date, 0, -15); /* -15 removes time and time zone info */
				echo '&nbsp;';
				echo '&nbsp;';
				echo '<i>';
				echo $date;
				echo '</i>';
				echo '<br><br>';
			}
		}#end else
	}
	echo '</div>'; /* end the right column_1 (blogs)*/
?>