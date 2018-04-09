<!--
code last augmented by daniel phillis for Flinders University 2017
daniel.phillis@gmail.com
@@@ symbol indicates recent changes, acting as bookmarks

This file provides the search option of looking for a software title by examining
the first char of titles alphabetically, with the list now
divided over 3 inner colunms, rather than simply one long single column

column Height is determined by # of search results divided by 3 and rounded up to the neaarst whole number

the list can contain titles of only one alphabetical character by clicking on
that character....all other titles are hidden from view until the page is
refreshed, or the 'ALL' button is pressed (or if parms in the URL are manipulated directly)
======= ======= =======
|     | |     | |     |
======= ======= =======

in order for the alphabetical filter to work, variables are set from user input ($_GET or $_POST)
and then tested to modify a query.
if the variables ($char1 and $char2) are not set at all , all letters are shown.
If HTML header variables ARE set\, then $char1 and $char2 are the same and we only show that letter.
ie show all titles between M and M (just show titles that start with M)
the action of the form is direct to this same page, hence detection of $_POST['Submit'] is required
-->

<?php
    $currentPage="SEARCH";
    $TOGGLE_TABLE_BORDERS	= 1;
    $TABLE_BORDER_COLOUR	= 'whitesmoke';
    $TOGGLE_LETTERS	        = 0;    #show or hide the letters at the beginning of a letter of the alphabet,
                                        #kind of redundant but works visually
    $DEBUG                      = 0;    #show debug error msgs / notifications / reminders/ warnings
    $UNIT                       = 0;
    
    $displayEntryVersion        = ''; # temp (int) var to allow for easy changes to php file versions
?>


<!doctype html>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]> <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]> <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]> 141111114
<!-->
<html class="">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Search : Title Listing</title>
    <link href="../css/boilerplate.css" rel="stylesheet" type="text/css">
    <link href="../css/ADHD_layout.css" rel="stylesheet" type="text/css">
    <!--[if lt IE 9]>
	<link href="css/ie_layout.css" rel="stylesheet" type="text/css">
    <![endif]-->
    <!--[if lt IE 8]>
	<![endif]-->
</head>

<body>
    <div class="mainWrapper">
		
        <!-- DIV containing the AHSD social links --> 
		<div id="outerSocialLinks">   
			<?php 
				//echo '<b>this value generated in Javascript: '.$char1.'</b><br><br>'; 
				if(!$UNIT) include("includes/ADHD_socialLinksHeader.php"); //File that contains the social links icons above the header section ?>
		</div>
		
		<!-- DIV containing the main navigation menu and the logo -->  
      	<div id="outerHeader">
            <?php if(!$UNIT) include("includes/ADHD_mainNavigationMenu.php"); //File that contains the main navigation menu and the logo ?>
		</div>
      
		<!-- DIV containing the links to the social accounts, AHSD logo and menu in mobile mode -->
        <?php if(!$UNIT) include("includes/ADHD_mobileNavigationHeader.php"); //File that contains the social accounts, AHSD logo and menu in mobile mode ?>
        
        <!-- DIV containing the main content -->  
        <div id="outerMainContent"> 
        	<div id="innerMainContent">
            	
            	<!-- @@@ indexInnerBodyLeft_1 is the main wihte text box with shadowing 
            	- the box we want to scale for this page is mainContentLeftColumn
				(by overriding the css style below) -->
				<!-- Width of search results div element -->
				<div id="innerMainContentLeftColumn" style="min-width: 80%;">
				<div id="indexInnerBodyLeft_1" style="
						/* OVERRIDE  to accommodate more text/ search results */
						width: 100%;
						max-width: 1250px; /* was 805 */
						/* background-color: #FFF; /* white */
						/* position: relative; */
						/* height: auto;
						/*
						padding-left: 1em;
						padding-bottom: 1em;
						*/
						/* float: left; /* changed from left */
						/* -webkit-box-shadow: 0 1px 35px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
						-moz-box-shadow: 0 1px 35px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
						box-shadow: 0 1px 35px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
						*/
						">

				<div id="listDatabaseTitles" border="1" style="
								min-width:	80%;
								margin-left: 0%;
								float: left;								
								">
							<h1 id="headerTitle">
								<a style="
										font-size: 15px; 
										font-weight: 550;" 
									href="ADHD_search.php">Search</a> | 
									<a style="
										font-size: 15px; 
										font-weight: 550;" 
							href="ADHD_searchKeyword.php"
							>Keyword Search</a> | Title List</h1>
							<p>
								<!-- color change here from grey to green from the banner -->
								<div 	id="letter-links"
										style="	color: #64cc39; /* banner 64cc39 green */
												
												/* Recall margin CSS works as such:
													top, bottom, right ,left */

												width: 80%;
												margin: -15px 15% 5% 5%;
												padding-left: 2em;
												">
								<?php 
                                    error_reporting(E_ALL);
                                    #ini_set('display_errors',1);
                                    /* this function will thow a warning for undefined variables -
                                    which is common on this page as we are testing for a $_GET  / $_POST
                                    variable before it is set */

                                    #echo '<i><b>reminder: layout slightly broken</b></i><br>';
                                    #PDO notification
                                    require('../conn/ADHD_DB_CONNECTION_PDO.php');
                                    $conn = connectDB();
                                    $alphabets = array
                                        ("ALL", "0-9","A","B","C","D","E","F","G",
                                        "H","I","J","K","L","M","N","O","P","Q",
                                        "R","S","T","U","V","W","X","Y","Z");
								?>
								<!-- DOWNLOAD EXCEL / CSV -->
								</div> <!-- end of green style -->

								<div id="CSV" style="padding-left: 3em;">
									<a href="includes/ADHD_csvOutput.php">
									<b>Export to CSV</b>
									</a>
									<center><hr>
									<!-- FORM made up of a row of BUTTONS to refine the user's search ie 'ALL', or 'G' -->
									<div id="formLinks" style="
										padding-left: 10em;
										float: center;
									">
										<form>
										<?php
                                            #LOOP OVER ALPHABET ARRAY
											for($i=0; $i < count($alphabets); $i++){ // Same page is default action
												$letter = $alphabets[$i];
												#FORM buttons
												$input = '<input type="submit"';
												$input .= ' method="GET"';
												$input .= ' name="srch"';           #corresponds to php above
												$input .= ' value="'.$letter.'"';   #label on button only
												$input .= '">';
												echo $input;
												echo '</input>';
											}
										?>
										</form>
										</div>
									<hr>
									</div>
								</div>
								</center>
								<!-- title list DIV tag -->
								<?php
									echo '<div id="ch1" style="';
									echo 'padding-left: 3em; ';
									echo 'padding-bottom: 3em; ';
									echo '">';
										
									/*  TEST $_POST or $_GET PARAMETER
									cases 'ALL' and '0-9' tested explicitly and simple queries formed for each case
									case srch= some single letter of the alphabet - query is created dynmaically and 
									parameters substitued ie ':char1' -> 'A'
									handle ALL TITLES (default search) - dont have to deal with $char1 at all until
									parm substitution is required with a PDO prepared statement */
									$parm = '';
                                    $parm = $_POST['srch'];
                                    $parm = $_GET['srch'];

									if (!isset($_POST['srch']) && !isset($_GET['srch']) ) {
                                    #if (!isset($_POST['srch']) ) {

                                    //Nothing searched for -> show all titles
                                    $SQL = "SELECT 	softwareID, sequenceNum, title
                                    FROM software
                                    WHERE sequenceNum = 1 ORDER BY title";
                                    if ($DEBUG){
                                           echo '<span style="color: red;" >';
                                           echo 'DEBUG: $SQL = '.$SQL.'<br>';
                                           echo '</span>';
                                    }
                                        } else {
                                                $input = $parm;
                                                if ($DEBUG){
                                                        echo 'DEBUG: $input: ';
                                                        echo '<span style="color: red;" >'.$input.'<br>';
                                                        echo '</span>';
                                                }
                                    if (!in_array($input, $alphabets)){#Whitelisitng valid inputs
                                                if ($DEBUG){
                                                        echo '<span style="color: red;" >';
                                                        echo 'DEBUG: ERROR ! no valid input found...<br>';
                                                        echo '</span>';
                                                 }
                                                #exit;
                                            }
                                            #special case for 'ALL'
                                            if($input === 'ALL'){
                                                    #simple query to show all titles (this query tested and passed)
                                                    $SQL = "SELECT 	softwareID, sequenceNum, title
                                                    FROM software
                                                    WHERE sequenceNum = 1 ORDER BY title;";
                                                    if ($DEBUG) echo '<br>DEBUG: $SQL = '.$SQL.'<br>';
                                            } else {
                                                #speial case of 0-9 - given its own query
                                                if ($input==='0-9'){ #handle 0-9, nested if
                                                    #this query tested and passed
                                                    $SQL = "SELECT 	softwareID, sequenceNum, title, UPPER(LEFT(title, 1))
                                                    FROM software
                                                    WHERE sequenceNum = 1 
                                                    AND UPPER(LEFT(title, 1)) BETWEEN '0' AND '9'
                                                    ORDER BY title ";
                                                    #if ($DEBUG) echo 'DEBUG: $SQL = '.$SQL.'<br>';
                                                } else { #must be a single aplhabet char
                                                    #Handle search for a specific letter only
                                                    /* Successfully tested query:
                                                            SELECT title, sequenceNum, UPPER(LEFT(title,1))
                                                            FROM software 
                                                            WHERE sequenceNum = 1 AND 
                                                            UPPER(LEFT(title,1)) LIKE 'A'
                                                            ORDER BY title
                                                    */
                                                            if ($input >= 'A' && $input <= 'Z'){ #this query tested and passed

                                                                    $SQL = "SELECT 	softwareID, sequenceNum, title, UPPER(LEFT(title, 1)) 
                                                                        FROM software
                                                                        WHERE sequenceNum = 1 AND
                                                                        UPPER(LEFT(title, 1)) = :input ORDER BY title";
                                                            if ($DEBUG) echo 'DEBUG: $SQL = '.$SQL.'<br>';
                                                        } else {
                                                            if ($DEBUG) echo 'DEBUG: ERROR <br>';#all other cases are unacceptable
                                                            #exit;
                                                        }
                                                }#end of inner else
                                            }#end of outer else
                                        }#end of outermost else

                                        #if ($DEBUG) echo 'DEBUG: SQL = '.$SQL.'<br>';
                                        $stmt = $conn->prepare($SQL);
                                        $stmt->bindValue(':input', $input);
                                        $stmt->execute();
                                        $results = $stmt->fetchAll();
                                        $count = count($results);

                                        #Prepare for division into 3 columns of results
                                        $c = $count;
                                        $colHeight = $c/3;
                                        $colHeight = (ceil($colHeight));

                                        #DEBUG DISPLAY PARMS-----------------------------------------------
                                        /*if($DEBUG){
                                                echo '<hr>';
                                                echo '<span style="color: red;">';
                                                echo 'DEBUG: count: '.$c.'<br>';
                                                echo 'DEEBUG: colHeight: '.$colHeight.'<br>'; //DEBUG
                                                echo '</span>';
                                                echo '<hr>';
                                        }*/
                                        #END DEBUG DISPLAY PARMS-------------------------------------------
                                        ?>
                                        <!-- @@@ Override -->
                                        <div id="list" style="padding-left: 30; padding-bottom: 30;">

                                        <?php
                                        #if the number of rows of the queury is > 0 / positive
                                        if($colHeight > 0){
                                            $currentChar = '';
                                            $i = 0;
                                            #Table 1
                                            #echo '<table border="'.$TOGGLE_TABLE_BORDERS.'" ';
                                            echo '<table ';
                                            echo ' style="
										    
                                            border: '.$TOGGLE_TABLE_BORDERS.'
                                            /* border-color: '.$TABLE_BORDER_COLOUR.'; */
                                            border-color: red;

                                            border-left: none;
                                            border-right: none;
                                            border-top: none;
                                            border-top: display;

                                            padding-bottom: 30;
                                            width: 100%;
                                            ">';
                                        /*
                                        echo '<tc>';
                                        echo '<tr><td width ="10%" height="100%">';
                                        echo '</td>'; #tall and thin
                                        echo '</tr>';
                                        echo '</tc>';
                                        */
                                        #echo '<tc><td>';
                                    echo '<tc>';

                                    echo '<tr><td style="
                                        width: "33%"; /* could be a dynamic % */
                                        padding-bottom: 30;
                                        padding-left: 30;
                                    ">';

                                        # Tabel 2 - a nested table
                                        echo '<table border="'.$TOGGLE_TABLE_BORDERS.'"';
                                        echo ' style ="
                                                border-color: '.$TABLE_BORDER_COLOUR.';
                                                
                                                border-left: none;
                                                border-right: none;
                                                border-top: none;
                                                border-top: display;
                                                border-bottom: display;
                                                
                                                /* border-color: red; */
                                                padding-bottom: 30;
                                                ">';
                                                # PDO: LOOP OVER THE QUERY RESULTS
                                                foreach ($results as $row){
                                                    #if $i is a multiple of the column height specification,
                                                    # make a new column
                                                    #break with back to top
                                                    if($i < 0){ #(never occurs)
                                                        echo '<br>';
                                                        echo '<a href="#">';
                                                        echo 'back to top';
                                                        echo '</a>';
                                                        echo '<br>';
                                                    }

                                                    if($i % $colHeight==0 && $i>0){
                                                        echo '</td></tr></table>';
                                                        echo '</td><td width="33%">';
                                                    #TABLE 3
                                                    echo '<table border="'.$TOGGLE_TABLE_BORDERS.'"';
                                                    echo ' style="
                                                        padding-bottom: 30;
                                                        border-color: '.$TABLE_BORDER_COLOUR.';
                                                        /* border-color: red; */
                                                        /* background-color: whitesmoke; */   
                                                        
                                                        border-top: none;
                                                        border-left: none;
                                                        border-right: none;
                                                        border-bottom: none;   
                                                        ">';
                                                    }
                                                    $i++;
											
                                                    /* 
                                                     if the first character of the current query result
                                                     is NOT the same as the previous query result
                                                     then we are dealing with printing a result from the next 
                                                     letter in the alphabet - therefore create a new header(letter)/marker to show 
                                                     we are dealing with that new letter */

                                                if($row['first_char'] != $currentChar) {
                                                        $currentChar = $row['first_char'];     

                                                        /* header letters toggled ON
                                                           only when displaying entire 
                                                           listing of titles */

                                                        #@@@ GET POST @@DEBUG
                                                        if( $input == null || !isset($input) ){
                                                                echo '<br>';
                                                                echo '<br>';
                                                                echo '<div align="left"';
                                                                #Make a link for the JS
                                                                #echo 'id="'.$currentChar.'"';
                                                                echo '>';

                                                                # DISPLAY A CONVENIENT LINK 'back to top'
                                                                # to take user to the top of the page
                                                                /*
                                                                echo '<a href="#">';
                                                                #echo '<h3>';
                                                                echo '<center';
                                                                echo 'back to top';
                                                                echo '</h3>';
                                                                echo '</a>';
                                                                #end back to top
                                                                */
                                                                echo '</center';
                                                                echo '</div>';

                                                                #use the letter of the alphabet as an ID (uppercase)
                                                                echo '<b id = "'. strtoupper($currentChar) .'">';
                                                                echo strtoupper($currentChar).'</b>';
                                                                echo '</div>';
                                                        }
                                                }
                                                echo '<div id="'.$currentChar.'">';
                                                echo '<tr><td>';
                                                echo '<a ';
                                                echo 'href="ADHD_displayEntry'.$displayEntryVersion.'.php?id='.$row["softwareID"].'">'; #LINK
                                                echo $row["title"];
                                                echo '</a>';
                                                echo '</div>'; //end of JS div

                                                echo '</td></tc>';
                                        }#end for each
                                }

                                echo '</table>';
                                echo '</table>';
                                echo '</table>';
                        ?>
                </div>
                </div>
                <!-- old blog container -
                <div id="innerMainContentRightColumn">
                <div id="indexInnerBodyRight_1">
                <div id="blogContainer">
                <?php
                    #include("includes/ADHD_blog.php"); //File that contains the DIV of the details of the blog entries ?>
                </div>
                <?php
                    #include("includes/ADHD_twitter.php"); //File that contains the DIV of the details of the twitter entries ?>
                </div>
                </div>
                </div> -->
                </div>
            </div>
        </div>
        </div>
								
        <div id="outterFooterContent">
            <div id="innerFooterContent">
                <br><br>
                    <?php include("includes/ADHD_footerIndex.php"); ?>
                </div>
            </div>
						
            <div id="outterFooterDeclarations">
                <div id="innerFooterDeclarations">
                    <span id="infoFooterCopyright"><?php include("includes/ADHD_copyright.php"); //File that contains the copyright notice ... the copyright year is incremented automatically ?></span>
                </div>
            </div>
        </div>
        <!-- Support for place holders for legacy browsers (DO NOT MOVE) -->
    <script src="script/placeholders.min.js"></script>
    <script src="script/jquery.touchSwipe.min.js"></script>
    <script src="script/jquery-fullsizable.min.js"></script>
    <script>

        $('a.fullsizable').fullsizable({
            detach_id: 'wrapper'
        });
        $(document).on('fullsizable:opened', function(){
        $("#jquery-fullsizable").swipe({
            swipeLeft: function(){
                $(document).trigger('fullsizable:next')
            },swipeRight: function(){
                $(document).trigger('fullsizable:prev')
            }, swipeUp: function(){
                $(document).trigger('fullsizable:close')
                }
            });
            });
    </script>
    <script src="script/scale.fix.js"></script>
</body>
</html>