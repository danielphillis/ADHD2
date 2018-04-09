<?php 
	$currentPage= "SEARCH_RESULTS";

	//Image thumbnail Width to display
	$imgThumbSizeY = 100; 
	
	//Image thumbnail Height to display
	$imgThumbSizeX = 140; 

	//Allows the display of softwareID and Sequence Number in the search results
	$DEBUG = 0;

	//Alternating table data colours in search results - currently breaks CSS style conventions
	$colouredTableData = 0;

	//showUploadsToggle
	$showUploadsToggle = 1;
	//use asterisks in searchTerm - ie 'frog' becomes '*frog*'...
	$useAsterisk = 0;

?>
<html>
<title>
ADHD Keyword Search Results
</title>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    	<link href="../css/boilerplate.css" rel="stylesheet" type="text/css">
    	<link href="../css/ADHD_layout.css" rel="stylesheet" type="text/css">

    <!--[if lt IE 9]>
	<link href="../css/ie_layout.css" rel="stylesheet" type="text/css">
    <![endif]-->
    <!--[if lt IE 8]>
	<![endif]-->
	
	<script src="../script/jquery-3.2.1.min.js"></script>
</head>

<body>

    <div class="mainWrapper">
        <!-- DIV containing the AHSD social links --> 
		<div id="outerSocialLinks">   
			<?php include("includes/ADHD_socialLinksHeader.php"); //File that contains the social links icons above the header section ?>
		</div>
		
		<!-- DIV containing the main navigation menu and the logo -->  
      	<div id="outerHeader">        
            <?php include("includes/ADHD_mainNavigationMenu.php"); //File that contains the main navigation menu and the logo ?>       
		</div>
      
		<!-- DIV containing the links to the social accounts, AHSD logo and menu in mobile mode -->
		<?php include("includes/ADHD_mobileNavigationHeader.php"); //File that contains the social accounts, AHSD logo and menu in mobile mode ?>       
        
        <!-- DIV containing the main content -->  
        <div id="outerMainContent"> 
        	<div id="innerMainContent">
				<!-- Width of search results div element -->
				<div id="innerMainContentLeftColumn" style="min-width: 80%;">
				<div id="indexInnerBodyLeft_1" style="
						/* OVERRIDE */
						width: 100%;
						max-width: 1250px; /* was 805 */
						background-color: #FFF; /* white */
						position: relative;
						height: auto;
						float: center; /* changed from left */
						-webkit-box-shadow: 0 1px 35px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
						-moz-box-shadow: 0 1px 35px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
						box-shadow: 0 1px 35px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset; ">
					
				<?php
				/* -------------------------------------------------- */
				error_reporting(E_ALL);
				ini_set('display_errors',1);
									
				require_once('../conn/ADHD_DB_CONNECTION_PDO.php');
				$conn = connectDB();
				
				if(isset($_POST["keywordSearch"])){
					$searchTerm = $_POST['keyword'];
					$sort = $_POST['sort'];
					
					//add asterisks to search term ie so searching for 'ski'
					//will pick up 'skiing' in title 'Horace goes Skiing'
					$searchTermStarred = '*'.$searchTerm.'*';

				}
				echo '<div ';
				echo 'style="
					padding-left: 3em;
					font-size: 13px;
					"';
				echo '>';
				//echo '<br>';

				//BASE QUERY
				$sql = 'SELECT * 
						FROM vSoftware 
						WHERE sequenceNum = 1
						AND match (title, description, notes, hardwareReq, softwareReq) against (:s in boolean mode)';
				
				$sql .= ' ORDER BY :o';

				//BIND PARAMS
				$stmt = $conn->prepare($sql);

				/* if useAsetrisk is true or non zero then the binding is different
				and search Term will become ('*' + $searchTerm + '*') */

				if($useAsterisk){
					$stmt->execute(array(
						':s' => $searchTermStarred,
						':o' => $sort
						));
				}else{
					$stmt->execute(array(
					':s' => $searchTerm,
					':o' => $sort
					));
				}
				
				$results = $stmt->fetchAll();
				$count = count($results);

				if(!$count){
					echo 'No results found.<br>';
					echo 'Please ';
					echo '<a href="ADHD_searchKeyword.php">';
					echo 'try again ';
					echo '</a>';
					echo 'with new search terms.';
					echo '<br><br>';

				}else{
					echo '<b>';
					echo $count;
                    echo ' result';
					if($count > 1) echo 's';#handle the plural output '...s'
                    echo ' found for \''.$searchTerm.' \'<br></b>';
					//Search Again
					echo '<a href="ADHD_searchKeyword.php">Keyword Search Again</a>';
					echo '<hr>';
					
					// @@@ SEARCH RESULTS STYLING
					//echo '<div style="padding: 3em;">';
					//echo '<div class="serachResultsContainer">';
					echo '<div ';//echo 'class="headerTitleSearchResults" ';
					echo 'style="
							font-size: 19;"';
					echo '>';
					echo '<table border ="0"><tcol>';
					$n=0;
					
					foreach ($results as $row){
						//Table data stlyisation with alternating colours
						if($colouredTableData){
							if($n%2==0){//alternate rows
								echo '<tr><td>';
							}else{
								echo '<tr><td style="
									background-color: #9bd0ef; //light blue from header
									/* text: 13px; */
									cell-padding 10px;
									">';
							}
						}else{
							//normal table data
							echo '<tr><td>';
						}
                        echo '<p>';

						$softwareID = $row['softwareID'];
						$title 		= $row['title'];
						$year 		= $row['year'];
						$des 		= $row['description'];
							//filter out special characters
							$des 	= htmlspecialchars($des);
							//filter out special characters
							$notes 	= $row['notes'];
							$notes 	= htmlspecialchars($notes);
						
						echo '<a href="ADHD_modifyEntry.php?id='.$softwareID.'">';
						//@@@ new tables
						//echo '<hr>';
                        echo '<table border="1">';

						//Hyperlink title
						if (strlen($title)==0){
							//echo '<h3 style="float: left;">';
							$title = 'untitled';
						}
                        echo '<b>'.$title;echo '</b>';

						//Hyperlink year
						if ($year) {
							echo '<b> | '.$year.'</b>';
						}
						echo '<br><i>Detailed Listing</i>';
						echo '</a>';


						//End Hyperlink generation
						
						//echo '<br>';
                        echo '<tr><td width = "25%">';

						#RETRIEVED DATA
						if($title){

							echo 'Title:';
							echo '</td><td>';
							echo ' &#09; &#09; &#09; '.$title;
                            //echo '<b><br>';
						}else{
							echo '</b>';
							echo 'no Title yet...';
							echo '<br>';
						}
						echo '</b>';
                        echo '</td></tr>';

						if($year) echo '<b><br>';
						echo '<tr><td width=""25%">';
						echo 'Year: &#09; &#09; &#09; </b>';
						echo '</td><td width=""75%">';
						echo $year;
						echo '</td></tr>';
						
						if($des != null){
							echo '<b>';
							//echo '<br>';
                            echo '<tr><td width=""25%">';
							echo 'Description:</b><br>';
                            echo '</td><td width=""75%">';
							echo $des;
							//echo '<br>';
                            echo '</td></tr>';
						}


						//Strip Excessive Whitespace
						$notes = preg_replace('/\s\s+/', ' ', $notes);


						echo '<b>';
						if($notes != null AND (sizeOf($notes)>0)){
							//echo '<br>';
                            echo '<td with="25%">';
							echo 'Notes:';
							echo '</b>';
                            echo '</td><td with=""75%">';
							//echo '<br>';
							echo $notes;
							//echo '<br>';
                            echo '</td></tr>';
						}
                        echo '</p>';
                        echo '<tr><td width="25%">';
						/* -------------------------------------------------- */
						include('includes/ADHD_listUploads.php');

						/* -------------------------------------------------- */
                        echo '</td></tr>';
                        echo '</table>';

                        //echo '<hr>';

						$n++;
						//DIV for search results
                        echo '</div>';



					}//end for each loop
                    //echo '</div>';
                    echo '</tcol></table>';

				}
                echo '</div>';
				/* -------------------------------------------------- */
				?>

		</div>
		</div>
		</div>
		</div>
		</div>
	
		<div id="outerFooterContent">
			<div id="innerFooterContent">
				<?php include("includes/ADHD_footerIndex.php"); ?>
			</div>
		
		</div>
		
		<div id="outerFooterDeclarations">
			<div id="innerFooterDeclarations">
				<span id="infoFooterCopyright"><?php include("includes/ADHD_copyright.php"); 
				//File that contains the copyright notice ... the copyright year is incremented automatically ?></span>
			</div>
		</div>
	</div>
	
	<!-- Support for place holders for legacy browsers (DO NOT MOVE) -->
    <script src="../script/placeholders.min.js"></script>
</body>
</html>