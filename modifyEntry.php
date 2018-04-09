<?php

	$imgWidth = 140;
	$imgHeight = 100;

	error_reporting(E_ALL);
	ini_set('display_errors',1);

	// ---------------- First result (primary) displayed to the users ---------------------------- //
	
	require_once('./conn/AHSD_DB_CONNECTION.php');
	$db_connection = connectDB();
	
	$softwareIDSql = mysqli_real_escape_string($db_connection, strip_tags($_GET['id']));
	$softwareID = htmlspecialchars($softwareIDSql, ENT_QUOTES, 'UTF-8');

	$varDisplayInitialRecord = ("SELECT * FROM vSoftware WHERE sequenceNum = 1 AND softwareID = ?");
							
	//Prepare the query
	$stmt1 = $db_connection->prepare($varDisplayInitialRecord) or trigger_error("1st Error!");

	//Can not proceed if we can not prepare the query
	if(false===$stmt1){
		trigger_error("2nd Error!");
	}   
	//Bind the fields and their parameters to our query in our testing variable $next_step
	$stmt1->bind_param('i', $softwareID);

	//If $stmt1 is false then it didn't work and there is no sense of proceeding
	if(false===$stmt1){
		trigger_error('3rd Error!');
	}   

	//Place the Execute into a variable and test if it executed or not
	$stmt1->execute();
							
	//If $stmt1 is false then it didn't work and there is no sense of proceeding 
	if(false===$stmt1){
		trigger_error("4th Error!");    
	}
							
	//Bind the results
	$stmt1->bind_result(
				$softwareID, 
				$sequenceNum, 
				$title, 
				$year, 
				$description, 
				$notes, 
				$hardwareReq, 
				$softwareReq, 
				$licenceList, 
				$numberOfFiles, 
				$insertedDate, 
				$publisherID, 
				$contributorID, 
				$country, 
				$givenName, 
				$familyName, 
				$fullName, 
				$publisherName);
						
	//If $stmt1 is false then it didn't work and there is no sense of proceeding 
	if(false===$stmt1){
		trigger_error("5th Error!");    
	}
	
	$stmt1->fetch();
	
if(!$stmt1->error) {
	$accordionGenerateOnce = 0; // Used for restricting the number of accordion DIVs generated in the below loop
	
	//while($stmt1->fetch()) {	   
		$titleTemp = "";
	   
		// To generate the accordion DIV only once
		if ($accordionGenerateOnce == 0) {
			echo "<div id=\"accordionHolder\">";
			echo "<div id=\"accordion\">";
		}

		if(!is_null($title) && !empty($title)){
			$titleTemp = $title;
		}

		if(!is_null($year) && !empty($year)){
			echo "<h3>" . htmlspecialchars($titleTemp, ENT_QUOTES, 'UTF-8') . " | " . htmlspecialchars($year, ENT_QUOTES, 'UTF-8') . "</h3>";
		}else {
			echo "<h3>" . htmlspecialchars($titleTemp, ENT_QUOTES, 'UTF-8') . "</h3>";
		}
	    
	    echo "<div><p>";
	    /* if title is returned from our CRUD op then show it */
		
		if(!is_null($title) && !empty($title)){
		   echo "<b>Title: </b>" . htmlspecialchars($title, ENT_QUOTES, 'UTF-8') . "<br/><br/>";
		}

		/* if year is returned from our CRUD op then show it */
		if(!is_null($year) && !empty($year)){
			echo "<b>Year: </b>" . htmlspecialchars($year, ENT_QUOTES, 'UTF-8') . "<br/><br/>";
		}
		/* if both family name and given name are returned from our CRUD op then show them */
		if(!is_null($familyName) && !empty($familyName) || 
			!is_null($givenName) && !empty($givenName)){
			$familyNameArr = explode(",",$familyName); 
			//explode is the same as spling split in a loop with a delimiter
			$givenNameArr = explode(",",$givenName);
	
			$fullNameArr = array();
			for ($i=0; $i<sizeOf($givenNameArr); $i++) {
				$fullNameArr[$i] = $givenNameArr[$i] . " " . $familyNameArr[$i];
			}
			/* implode: join arr elements with a string 
			DEALS with multiple authors */
			
			$fullNameArrTemp = implode(", ", $fullNameArr);
			 echo "<b>Author(s): </b>" . htmlspecialchars($fullNameArrTemp, ENT_QUOTES, 'UTF-8') . "<br/><br/>";
		}

	    /* if pubname is returned from our CRUD op then show it */
		if(!is_null($publisherName) && !empty($publisherName)){
			echo "<b>Publisher: </b>" . htmlspecialchars($publisherName, ENT_QUOTES, 'UTF-8') . "<br/><br/>";
		}
	    
	    /* if country is returned from our CRUD op then show it */
		if(!is_null($country) && !empty($country)){
			echo "<b>Country: </b>" . htmlspecialchars($country, ENT_QUOTES, 'UTF-8') . "<br/><br/>";
		}
	    /* if licenceList is returned from our CRUD op then show it */
		if(!is_null($licenceList) && !empty($licenceList)){
			echo "<b>Licence: </b>" . htmlspecialchars($licenceList, ENT_QUOTES, 'UTF-8') . "<br/><br/>";
		}

		if(!is_null($hardwareReq) && !empty($hardwareReq)){
			echo "<b>Hardware Requirement: </b>" . htmlspecialchars($hardwareReq, ENT_QUOTES, 'UTF-8') . "<br/><br/>";
		}
	   
		if(!is_null($softwareReq) && !empty($softwareReq)){
			echo "<b>Software Requirement: </b>" . htmlspecialchars($softwareReq, ENT_QUOTES, 'UTF-8') . "<br/><br/>";
		}	
	   
		if(!is_null($description) && !empty($description)){
			echo "<b>Description: </b>" . htmlspecialchars($description, ENT_QUOTES, 'UTF-8') . "<br/><br/>";
		}
	   
		if(!is_null($notes) && !empty($notes)){
			echo "<b>Notes: </b>" . htmlspecialchars($notes, ENT_QUOTES, 'UTF-8') . "<br/><br/>";
		}
		/*  couldnt find an explanation for store_result() ? */
		$stmt1->store_result();
		$stmt1->close(); 
	   
		//$fileSQL = "SELECT up.fileName, up.fileType, up.softwareID FROM uploadedFiles up, software s WHERE up.softwareID = s.softwareID AND up.softwareID = '".$row['softwareID']."'";

		/* 	NEW QUERY - RETRIEVE UPLOADDED FILES 
			Retrieve uploaded files from the DB in relation to the queried software 
			(but only for seqNum 1)

			Aliases in sql are optional according to "http://www.1keydata.com/sql/sql-as.html"
			and are purely used to make the code more readable
		*/
		$fileSQL = "SELECT DISTINCT	up.fileName, 
									up.fileType, 
									up.fileSize, 
									up.softwareID 
					FROM 	uploadedFiles 	AS 	up, 
							software 		AS	s 
					WHERE 	up.sequenceNum 	= 1 
					AND 	up.softwareID 	= s.softwareID 
					AND 	up.softwareID = '".$softwareID."'"; //sql 'AS' not used here (optional ?)

		$resultFile = $db_connection->query($fileSQL) or die($db_connection->error.__LINE__);

		// GOING THROUGH THE DATA
		if($resultFile->num_rows > 0) {
		
			$filePathImage = array(); // Save image names with path in an array for later display
			$filePathDoc = array(); // Save document names with path in an array for later display
			$fileTypeDoc = array(); // Save document types for later display
			$fileSizeDoc = array(); // Save document size for later display

			$imageFlag = 0; // To display to user whether the attachment is an image (0=no, 1=yes);
			$docFlag = 0; // To display to user whether the attachment is a doc (0=no, 1=yes);			
			$indexImage = 0; // Index for image array
			$indexDoc = 0; // Index for doc array
			
			$kb = 1024;

			while($rowFile = $resultFile->fetch_assoc()){
				
				// Keeping track of which files are images and which files are documents
				switch ($rowFile['fileType']){
					case "gif":
						$imageFlag = 1;
						$filePathImage[$indexImage] = "uploads/".$softwareID."/".$rowFile['fileName'];
						$indexImage++;
						break;
					case "png":
						$imageFlag = 1;
						$filePathImage[$indexImage] = "uploads/".$softwareID."/".$rowFile['fileName'];
						$indexImage++;
						break;	
					case "jpg":
						$imageFlag = 1;
						$filePathImage[$indexImage] = "uploads/".$softwareID. "/".$rowFile['fileName'];
						$indexImage++;
						break;
					case "txt":
						$docFlag = 1;
						$filePathDoc[$indexDoc] = "uploads/".$softwareID."/".$rowFile['fileName'];
						$fileTypeDoc[$indexDoc] = $rowFile['fileType'];
						$fileSizeDoc[$indexDoc] = floor($rowFile['fileSize']/$kb);
						$indexDoc++;
						break;
					case "pdf":
						$docFlag = 1;
						$filePathDoc[$indexDoc] = "uploads/".$softwareID."/".$rowFile['fileName'];
						$fileTypeDoc[$indexDoc] = $rowFile['fileType'];
						$fileSizeDoc[$indexDoc] = floor($rowFile['fileSize']/$kb);
						$indexDoc++;
						break;	
				}
			}
		
			/* 	Displaying the images if any of the files in the switch statement above were images 
				(true if the $imageFlag is set to 1) */

			if ($imageFlag == 1) {
				echo "<br/><b>Photo Attachments:</b> <br/>";

				/* run over array and display the elements (images) and build links to images */

				for ($i=0; $i<sizeOf($filePathImage); $i++) {
					if(file_exists($filePathImage[$i])) {
						if ($_debug){
                                                    echo 	"<a href='".$filePathImage[$i]."' 
								class='fullsizable'><img class='fullsizable' 
								src='".$filePathImage[$i]."' 
								width='".$imgWidth."' 
								height='".$imgHeight."'/></a>";
                                                }
					}
				}
			}
			/* 	
				Displaying the documents if any of the files in the switch statement above were documents 
				(true if the $docFlag is set to 1)
			*/

			if ($docFlag == 1) {
				echo "<br><b>Document Attachments:</b><br><br>";

				for ($i=0; $i<sizeOf($filePathDoc); $i++) {
					if(file_exists($filePathDoc[$i])) {
						echo "> <a href='" . $filePathDoc[$i]."' target='_blank'>View This Document</a> (".$fileTypeDoc[$i].") (".$fileSizeDoc[$i]."kb)<br>";
					}
				}
			}	
		}
		echo "<hr>";

		include("includes/modify_entry_newer_versions.php");
		include("includes/modify_entry_form.php");
		
		echo "</p></div>";
		$accordionGenerateOnce = 1;  // Increment to prevent more accordion DIVs generation
	}
	// Close accordion DIVs only once
	if ($accordionGenerateOnce == 1) {
		echo "</div>";
		echo "</div>";
	}

echo "<!--17-10-15-->";
//$resultFile->close();

?>	
