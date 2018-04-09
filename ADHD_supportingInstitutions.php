<?php

	/* 
		supporting institutions, uses PDO bindColumn and fetch(PDO::FETCH_BOUND)
	*/

	error_reporting(E_ALL);
	ini_set('display_errors',1);

	require_once('../conn/ADHD_DB_CONNECTION_PDO.php');
	$conn = connectDB();
	if($conn){

		$u = 'URL';
		$in ='institutionName';

		$query = 'SELECT URL, institutionName FROM credits ORDER BY :o';  
		
		$stmt = $conn->prepare($query);
		//$stmt->bindValue(':u', $u);
		//$stmt->bindValue(':t', 'credits');
		$stmt->bindValue(':o', 'institutionName');
		
		/* $params = [	':u'=>'url'
		 			//,
					//':c'=>'credits',
					//':o'=>'institutionName'
				];*/

		$stmt->execute();  
		$stmt->bindColumn('institutionName', $institutionName); /* */
		$stmt->bindColumn($u, $url);

		echo "<ul id=\"supportingInstitutions\">";

		while ( $row = $stmt->fetch( PDO::FETCH_BOUND )){  
	   		echo '<li><a target="_blank" href="'.$url.'"> '.$institutionName.'</a></li>';
		}
		echo "</ul>";
	}

	//Free the memory
	$stmt = null;
	$conn = null;
?>