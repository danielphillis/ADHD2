<?php
	error_reporting(E_ALL);
	ini_set('display_errors',1);

	// ---------------- First result (primary) displayed to the users ---------------------------- //
	
	require_once('./conn/AHSD_DB_CONNECTION.php');
	$db_connection = connectDB();
	
	$softwareIDSql = mysqli_real_escape_string($db_connection, strip_tags($_GET['id']));
	$softwareID = htmlspecialchars($softwareIDSql, ENT_QUOTES, 'UTF-8');

	$varDisplayInitialRecord = ("SELECT * FROM vSoftware WHERE sequenceNum != 1 AND softwareID = ?");
							
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
	$stmt1->bind_result(	$softwareID, 
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
	
	
	$stmt1Temp = array();
	$stmt1Counter = 0;
	if(!$stmt1->error) {
		while($stmt1->fetch()) {	   
			//$stmt1Temp = compact("title", "year", "familyName", "givenName", "publisherName", "country", "licenceList", "hardwareReq", "softwareReq", "description", "notes");
			$stmt1Temp['sequenceNum'.$stmt1Counter] = $sequenceNum;
			$stmt1Temp['title'.$stmt1Counter] = $title;
			$stmt1Temp['year'.$stmt1Counter] = $year;
			$stmt1Temp['familyName'.$stmt1Counter] = $familyName;
			$stmt1Temp['givenName'.$stmt1Counter] = $givenName;
			$stmt1Temp['publisherName'.$stmt1Counter] = $publisherName;
			$stmt1Temp['country'.$stmt1Counter] = $country;
			$stmt1Temp['licenceList'.$stmt1Counter] = $licenceList;
			$stmt1Temp['hardwareReq'.$stmt1Counter] = $hardwareReq;
			$stmt1Temp['softwareReq'.$stmt1Counter] = $softwareReq;
			$stmt1Temp['description'.$stmt1Counter] = $description;
			$stmt1Temp['notes'.$stmt1Counter] = $notes;
			$stmt1Counter++;
			
			//echo "<br/><br/>" . $familyName . "<br/><br/>";
		}
		//var_dump($stmt1Temp);
		$stmt1->free_result(); //free_result() -> frees the memory
		$stmt1->close(); 
	}
	
	if ($stmt1Counter > 0) {
		echo "<span style = \"color: #D18E1B;\">Other records of this software:</span>";
	}
	
	$stmt1CounterPrint = 0;
	while ($stmt1CounterPrint < $stmt1Counter) {
		
		echo "<div><p>";
	   
		if(!is_null($stmt1Temp['title'.$stmt1CounterPrint]) && !empty($stmt1Temp['title'.$stmt1CounterPrint])){
		   echo "<b>Title: </b>" . htmlspecialchars($stmt1Temp['title'.$stmt1CounterPrint], ENT_QUOTES, 'UTF-8') . "<br/><br/>";
		}
		
		if(!is_null($stmt1Temp['year'.$stmt1CounterPrint]) && !empty($stmt1Temp['year'.$stmt1CounterPrint])){
			echo "<b>Year: </b>" . htmlspecialchars($stmt1Temp['year'.$stmt1CounterPrint], ENT_QUOTES, 'UTF-8') . "<br/><br/>";
		}
	   
		if(!is_null($stmt1Temp['familyName'.$stmt1CounterPrint]) && !empty($stmt1Temp['familyName'.$stmt1CounterPrint]) || !is_null($stmt1Temp['givenName'.$stmt1CounterPrint]) && !empty($stmt1Temp['givenName'.$stmt1CounterPrint])){
			$familyNameArr = explode(",",$stmt1Temp['familyName'.$stmt1CounterPrint]);
			$givenNameArr = explode(",",$stmt1Temp['givenName'.$stmt1CounterPrint]);
	
			$fullNameArr = array();
			for ($i=0; $i<sizeOf($givenNameArr); $i++) {
				$fullNameArr[$i] = $givenNameArr[$i] . " " . $familyNameArr[$i];
			}
			$fullNameArrTemp = implode(", ", $fullNameArr);
			echo "<b>Author(s): </b>" . htmlspecialchars($fullNameArrTemp, ENT_QUOTES, 'UTF-8') . "<br/><br/>";
		}
	   
		if(!is_null($stmt1Temp['publisherName'.$stmt1CounterPrint]) && !empty($stmt1Temp['publisherName'.$stmt1CounterPrint])){
			echo "<b>Publisher: </b>" . htmlspecialchars($stmt1Temp['publisherName'.$stmt1CounterPrint], ENT_QUOTES, 'UTF-8') . "<br/><br/>";
		}
	   
		if(!is_null($stmt1Temp['country'.$stmt1CounterPrint]) && !empty($stmt1Temp['country'.$stmt1CounterPrint])){
			echo "<b>Country: </b>" . htmlspecialchars($stmt1Temp['country'.$stmt1CounterPrint], ENT_QUOTES, 'UTF-8') . "<br/><br/>";
		}
	   
		if(!is_null($stmt1Temp['licenceList'.$stmt1CounterPrint]) && !empty($stmt1Temp['licenceList'.$stmt1CounterPrint])){
			echo "<b>Licence: </b>" . htmlspecialchars($stmt1Temp['licenceList'.$stmt1CounterPrint], ENT_QUOTES, 'UTF-8') . "<br/><br/>";
		}

		if(!is_null($stmt1Temp['hardwareReq'.$stmt1CounterPrint]) && !empty($stmt1Temp['hardwareReq'.$stmt1CounterPrint])){
			echo "<b>Hardware Requirement: </b>" . htmlspecialchars($stmt1Temp['hardwareReq'.$stmt1CounterPrint], ENT_QUOTES, 'UTF-8') . "<br/><br/>";
		}
	   
		if(!is_null($stmt1Temp['softwareReq'.$stmt1CounterPrint]) && !empty($stmt1Temp['softwareReq'.$stmt1CounterPrint])){
			echo "<b>Software Requirement: </b>" . htmlspecialchars($stmt1Temp['softwareReq'.$stmt1CounterPrint], ENT_QUOTES, 'UTF-8') . "<br/><br/>";
		}	
	   
		if(!is_null($stmt1Temp['description'.$stmt1CounterPrint]) && !empty($stmt1Temp['description'.$stmt1CounterPrint])){
			echo "<b>Description: </b>" . htmlspecialchars($stmt1Temp['description'.$stmt1CounterPrint], ENT_QUOTES, 'UTF-8') . "<br/><br/>";
		}
	   
		if(!is_null($stmt1Temp['notes'.$stmt1CounterPrint]) && !empty($stmt1Temp['notes'.$stmt1CounterPrint])){
			echo "<b>Notes: </b>" . htmlspecialchars($stmt1Temp['notes'.$stmt1CounterPrint], ENT_QUOTES, 'UTF-8') . "<br/><br/>";
		}
		
		// Used to identify whether the new version of the softwareID has had files uploaded with (don;t show files that for the older entries of the same softwareID and only display for the corresponding sequenceNum)
	   $sequenceNumTemp = $stmt1Temp['sequenceNum'.$stmt1CounterPrint];
	   	   
		//$fileSQL = "SELECT up.fileName, up.fileType, up.softwareID FROM uploadedFiles up, software s WHERE up.softwareID = s.softwareID AND up.softwareID = '".$row['softwareID']."'";
		$fileSQL = "SELECT DISTINCT 	up.fileName, 
										up.fileType, 
										up.fileSize, 
										up.softwareID 
					FROM 	uploadedFiles 	up, 
							software 		s 

					WHERE 	up.sequenceNum = '".$sequenceNumTemp."' 
					AND up.softwareID = s.softwareID 
					AND up.softwareID = '".$softwareID."'";

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
		
			while($rowFile = $resultFile->fetch_assoc()) {
				
				// Keeping tarck of which files are images and which files are documents
				switch ($rowFile['fileType']){
					case "gif":
						$imageFlag = 1;
						$filePathImage[$indexImage] = "uploads/" . $softwareID .  "/" . $rowFile['fileName'];
						$indexImage++;
						break;
					case "png":
						$imageFlag = 1;
						$filePathImage[$indexImage] = "uploads/" . $softwareID .  "/" . $rowFile['fileName'];
						$indexImage++;
						break;	
					case "jpg":
						$imageFlag = 1;
						$filePathImage[$indexImage] = "uploads/" . $softwareID .  "/" . $rowFile['fileName'];
						$indexImage++;
						break;	
					case "txt":
						$docFlag = 1;
						$filePathDoc[$indexDoc] = "uploads/" . $softwareID .  "/" . $rowFile['fileName'];
						$fileTypeDoc[$indexDoc] = $rowFile['fileType'];
						$fileSizeDoc[$indexDoc] = floor($rowFile['fileSize']/1000);
						$indexDoc++;
						break;
					case "pdf":
						$docFlag = 1;
						$filePathDoc[$indexDoc] = "uploads/" . $softwareID .  "/" . $rowFile['fileName'];
						$fileTypeDoc[$indexDoc] = $rowFile['fileType'];
						$fileSizeDoc[$indexDoc] = floor($rowFile['fileSize']/1000);
						$indexDoc++;
						break;	
				}
			}
		
			/* 
				Displaying the images if any of the files in the switch statement above were images 
				(true if the $imageFlag is set to 1)
			*/

			if ($imageFlag == 1) {
				echo "<br/><b>Photo Attachments:</b> <br/>";
				
				for ($i=0; $i<sizeOf($filePathImage); $i++) {
					if(file_exists($filePathImage[$i])) {
						echo "<a href='".$filePathImage[$i]."' class='fullsizable'><img class='fullsizable' src='".$filePathImage[$i]."' width='140' height='100'/></a>";
					}
				}
			}	
		
		/*	Displaying the documents if any of the files in the switch statement above were documents 
			(true if the $docFlag is set to 1)
		*/
			if ($docFlag == 1) {
				echo "<br/><b>Document Attachments:</b> <br/><br/>";

				for ($i=0; $i<sizeOf($filePathDoc); $i++) {
					if(file_exists($filePathDoc[$i])) {
						echo "> <a href='" . $filePathDoc[$i] . "' target='_blank'>View This Document</a> (" . $fileTypeDoc[$i] . ") (" . $fileSizeDoc[$i] . "kb)<br/>";
					}
				}
			}	
		}
		echo "</p></div>";
		
		echo "<hr>";
		
		$stmt1CounterPrint++;
	}
	$resultFile->close();
	echo "<!--17-10-15-->";
?>	
