
    <?php
    /*
    searchResultsKeyword v08.php
    daniel.phillis@gmail.com
    Flinders University 2017 */

    $currentPage= "SEARCH_RESULTS";

    $GLOBALS['TOGGLE_TABLE_BORDERS_OUTER'] = 1;
    $GLOBALS['TOGGLE_TABLE_BORDERS_INNER'] = 1;
    $COLOURED_TABLE_CELS             = 0; #Alternating table data colours in search results
                                         #- currently breaks CSS style conventions
    $TABLE_CELL_COLOUR               = 'whitesmoke';
    $GLOBALS['TOGGLE_UPLOADS']      = 1;
    $GLOBALS['TOGGLE_WILDCARD']     = 1; #use asterisks in searchTerm - ie 'frog' becomes '%frog%'...
    $imgThumbSizeY                  = 100; # Image thumbnail Width to display
    $imgThumbSizeX                  = 140; # Image thumbnail Height to display
    $DEBUG                          = 0;
    #$modVersion = '03'; #was 06

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
					
					#add asterisks to search term ie so searching for 'ski'
					#will pick up 'skiing' in title 'Horace goes Skiing'
					$searchTermStarred = '%'.$searchTerm.'%';
				}
				echo '<div ';
				echo 'style="
					padding-left: 3em;
					font-size: 13px;
					"';
				echo '>';
				echo '<br>';
                                
				#BASE QUERY
				$sql = 'SELECT * 
                                        FROM vSoftware 
                                        WHERE sequenceNum = 1
                                        AND match (title, description, notes, hardwareReq, softwareReq) against (:s in boolean mode)';
				$sql .= ' ORDER BY :o';

				#BIND PARAMS
				$stmt = $conn->prepare($sql);


				/* if use asterisk/ percentage symbol is true or non zero then the binding is different
				and search Term will become ('*' + $searchTerm + '*') */

                            $stmt->bindParam(':s', $searchTermStarred);
                            $stmt->bindParam(':o', $sort);
                            #print_r($stmt);
                            $stmt->execute();
                                
                            /**
                            if($TOGGLE_ASTERISK){
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
                            */
                            $results = $stmt->fetchAll();

                            #print_r($stmt);
                            #echo '<br>';
                            #print_r($results);

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
                                    #DIV STYLE
                                    echo '<div ';
                                    echo 'id="headerTitleSearchResults" ';
                                    echo '">';
                                    echo $count;
                                    echo ' Result';
                                    if($count > 1) echo 's';# plural output
                                    echo ' Found for \''.$searchTerm.' \'<br>';

                                    #Search Again
                                    echo '<br><a href="ADHD_searchKeyword.php">Keyword Search Again</a>';

                                    # MAIN TABLE
                                    echo '<table border="'.$TOGGLE_TABLE_BORDERS_OUTER.'" 
					    style="
                                            width: 100%;
                                            border-color: whitesmoke;  
                                            border-top: none;
                                            border-bottom: none;
                                            border-left: none;
                                            border-right: none;

                                            font-family: "Raleway";       
                                            ">'; #outermost table - maybe not necessary

                                        $n=0;
					foreach ($results as $row){
						//Table data stlyisation with alternating colours
						if($COLOURED_TABLE_CELS){
							if($n%2==0){//alternate rows
								echo '<tr><td>';
							}else{
								echo '<tr><td style="

									/* background-color: #9bd0ef; #light blue from header */
									/* background-color: #bbe5e8; #light blue from ramp */
								
									background-color: '.$TABLE_CELL_COLOUR.';
									border: 0;
									width: 100%;
									cell-padding 10px;
									">';
							}
							echo '<p>';
						}else{
							//normal table data
							echo '<tr><td>';
							#echo '<p>';
						}
						$softwareID = $row['softwareID'];
						$title 		= $row['title'];
						$year 		= $row['year'];
						$des 		= $row['description'];
                                                #filter out special characters
                                                $des 	= htmlspecialchars($des);
                                                #filter out special characters
                                                $notes 	= $row['notes'];
                                                $notes 	= htmlspecialchars($notes);
			
                        #old version
                        #echo '<a href="ADHD_modifyEntry_v'.$modVersion.'.php?id='.$softwareID.'">';
                        echo '<a href="ADHD_modifyEntry.php?id='.$softwareID.'">';
                        echo '<br>';

                        #Hyperlink title
                        if (strlen($title)==0){
                            $title = 'untitled';
                        }
                        #echo '<font size="2">';
                        ?>

                        <!-- style for search results -->
                        <div id="searchResults" >

                        <?php
                            echo '<b>';
                            echo $title;
                            echo '</b>';

                            #Hyperlink year
                            if ($year) {
                                echo '<b> | '.$year.'</b>';
                            }
                            echo '<br>';
                            #echo '<i> Detailed Listing</i>';
                            echo '</a>';
                            #echo '<br>';
                            //End Hyperlink generation
                            #echo '<p>';
                            echo '<br>';

                            # INNER TABLES
                            //echo '<div style="font-size: 20pt;">'; # table data
                            echo '<table border="' . $TOGGLE_TABLE_BORDERS_INNER . '" 
                            style="
                            border-color: whitesmoke;
                            border-top: none;
                            border-bottom: none;
                            border-left: none;
                            border-right: none;
                        ">';

                        #RETRIEVED DATA
                        echo '<tr><td width="15%">';
                        if($title){
                                echo '<font size="2">';
                                echo '<b>Title:';
                                echo '</b></td><td>';
                                echo '<font size="2">';
                                echo $title;

                        }else{
                                echo '</td><td>';
                                echo '<font size="2">';
                                echo 'no Title yet...';
                        }
                        echo '</td></tr>';
                        echo '</b>';

                        if($year) {
                            echo '<tr><td><b>';
                            echo '<font size="2">';
                            echo 'Year: </b>';
                            echo '</td><td>';
                        }
                        echo '<font size="2">';
                        echo $year;
                        echo '</td></tr></b>';

                        if($des != null){
                            echo '<tr><td>';
                            echo '<b>';
                            echo '<font size="2">';
                            echo 'Description: ';
                            echo '</b>';
                            echo '</td><td>';
                            echo '<font size="2">';
                            echo $des;
                            echo '</td></tr>';
						}

                            #Strip Excessive Whitespace
                            $notes = preg_replace('/\s\s+/', ' ', $notes);
                            echo '<b>';
                            if($notes != null AND (sizeOf($notes)>0) AND $notes !== 'NA'){
                                echo '<tr><td width="15%">';
                                echo '<b>';
                                echo '<font size="2">';
                                echo 'Notes:';
                                echo '</b></td><td>';
                                echo '<font size="2">';
                                echo $notes;
                                echo '</td</tr>';
                            }
                            echo '</font>';
                            echo '</table>'; #endinner table
                            
                            echo '</div>';

                        /* -- UPLOADS ------------------------------------------------ */
                        include('includes/ADHD_listUploads.php');
                        #echo '<hr>';
                        $n++;

                        //DIV for search results
                        echo '</div>';
                        echo '</table>'; #end outer table
                        
                }//end for each loop
                echo '</table>'; #end outer table
            }
            ?>
            </div> <!-- -->
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