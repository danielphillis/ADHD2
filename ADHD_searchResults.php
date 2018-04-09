<?php
    /**
     * SEARCH_RESULTS.PHP
     * daniel.phillis@gmail.com
     * for Flinders University 2017
     * 8/12/2017
     */

    $currentPage= "SEARCH_RESULTS";
    $GLOBALS['TOGGLE_TABLE_BORDERS']        = 1; # debug tables
    $GLOBALS['TOGGLE_MODIFY_ENTRY_ICON']    = 0; # toggle graphic icon for editing the entry
    /** shows uploads in search results - NB also creates layout bug when many results are returned */
    $GLOBALS['TOGGLE_UPLOADS']              = 1; #should only be off for rapid testing
    $GLOBALS['TABULAR_RESULTS']             = 1; # show results in tables
    $GLOBALS['DEBUG']                       = 0;
    $GLOBALS['UNIT']                        = 0; # show unit tests
    $GLOBALS['fields'] = ('');
    $GLOBALS[$imgThumbSizeX]= 140*1;  # image thumbnail Width to display
    $GLOBALS[$imgThumbSizeY] = 100*1; # image thumbnail Height to display
    #global $modVersion = '06';

?>
<html>
<title>
ADHD Search Results
</title>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
     
    	<link href="../css/boilerplate.css" rel="stylesheet" type="text/css">
    	<link href="../css/ADHD_layout.css" rel="stylesheet" type="text/css">

	    <!--[if lt IE 9]>
		<link href="css/ie_layout.css" rel="stylesheet" type="text/css">
	    <![endif]-->
	    <!--[if lt IE 8]>
		<![endif]-->
	
	<script src="../script/jquery-3.2.1.min.js"></script>
</head>

<body>
    <div class="mainWrapper">
        <!-- DIV containing the AHSD social links --> 
		<div id="outerSocialLinks">   
			<?php if(!$UNIT) include("includes/ADHD_socialLinksHeader.php"); # File that contains the social links icons above the header section ?>
		</div>
		
		<!-- DIV containing the main navigation menu and the logo -->  
      	<div id="outerHeader">        
            <?php if(!$UNIT) include("includes/ADHD_mainNavigationMenu.php"); # File that contains the main navigation menu and the logo ?>       
		</div>
      
		<!-- DIV containing the links to the social accounts, AHSD logo and menu in mobile mode -->
		<?php if(!$UNIT) include("includes/ADHD_mobileNavigationHeader.php"); # File that contains the social accounts, AHSD logo and menu in mobile mode ?>       
        
        <!-- DIV containing the main content -->  
        <div id="outerMainContent"> 
        	<div id="innerMainContent">

				<!-- Width of search results div element -->
				<div id="innerMainContentLeftColumn" style="min-width: 80%;">

				<div id="indexInnerBodyLeft_1" style="
						/* OVERRIDE */
						width: 100%;
						padding-left:30;
						/* illegal values reported */
						padding-bottom:30;
						max-width: 1250px; /* was 805 */
						position: relative;
						/*
						background-color: #FFF; #  white 
						height: auto;
						float: center; #  changed from left
						*/
						-webkit-box-shadow: 0 1px 35px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
						-moz-box-shadow: 0 1px 35px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
						box-shadow: 0 1px 35px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
				">
                    <?php

                                FUNCTION clean_searchResults($_term){
                                    $_term = htmlspecialchars($_term, ENT_QUOTES,'UTF-8');
                                    return $_term;
                                }
                                
                                FUNCTION clean($_term){
                                    $_term = htmlspecialchars($_term, ENT_QUOTES,'UTF-8');
                                    return $_term;
                                }


                                error_reporting(E_ALL);
                                ini_set('display_errors',1);
                                require('../conn/ADHD_DB_CONNECTION_PDO.php');
                                $conn = connectDB();
                                $fields = array();

                                if($UNIT) include('test/test_searchResults_v01.php');
                                #make var names consistent over files
                                if ($DEBUG) print_r($_POST);
                                if(isset($_POST['search'])){# (SUBMIT BUTTON)
                                    #test $_POST Variables
                                    if ($DEBUG) echo 'DEBUG: <font color="red" global $_POST vars:';
                                    if ($DEBUG) echo 'DEBUG: searchTerm: '.$_POST['title'].'<br>';

                                    #search TERM
                                    #$title = $_POST['title'];
                                    #$searchTerm = $title;

                                    if ($DEBUG) echo 'Search_options (any/all): '.$_POST['searchopt'].'<br>';

                                    #SEARCH OPTIONS / TYPE
                                    $srchopt = $_POST['searchopt'];
                                    $srchopt = clean($srchopt);
                                    /* filter input (with htmlspecialchars) /*
                                    $year               = clean($year);
                                    $authorFamilyName   = clean($authorFamilyName);
                                    $authorGivenName    = clean($authorGivenName);
                                    $publisherName      = clean($publisherGivenName);
                                    $country            = clean($country);
                                    $sort               = clean($sort);
                                    */
                                    $srchopt = substr($srchopt,0,3);

                                    #SORT TYPE
                                    $sort = $_POST['sort'];

                                    # TITLE - test if set
                                    if(isset($_POST['title']) && $_POST['title']!= null){
                                        $searchTerm = clean($_POST['title']);
                                        $title = $searchTerm;
                                        # add to the PDO array that is used in PDO binding with the mySQL query
                                        $fields += [':title' => $title];
                                    }

                                    # GET SORTING PARAM - whiteListing viable values
                                    $columns = array( 'title', 'year', 'publisherName', # the possible parms to sort by
                                        'country', 'licenceList', 'AuthorFamilyName' );
                                    if(in_array($sort, $columns)) {
                                        $sortSql = strip_tags($_POST['sort']);
                                        /** strip tags : http://php.net/manual/en/function.strip-tags.php
                                         * uses the same tag stripping state machine as the fgetss() function.
                                         */
                                        #$sort = htmlspecialchars($sortSql, ENT_QUOTES, 'UTF-8'); # redundant ?
                                    } else {
                                        $sort = 'title';#default sort
                                    }

                                    $fields += [':sort' => $sort];
                                    $boolean = 'AND';

                                    $sql = 'SELECT * 
                                        FROM vSoftware 
                                        WHERE sequenceNum = 1 ';
                                    $sql .= ' AND title = :title';

                                    /** IS HTIS TRUE ??
                                     * note left parentheses added to enforce an order of precedence in the query
                                     * ie select * where sqeNum = 1 AND title = '3D Golf'
                                     * is not equivalent to
                                     * select * where sqeNum = 1 AND (title = '3D Golf')
                                    */

                                    # ADD YEAR TO QUERY and parm array ----------------------------------------------
                                    if(isset($_POST['year']) && ($_POST['year'] != '') && ($_POST['year'] != null)){
                                        $year = $_POST['year'];
                                        $sql .= ' :bool year = :year'; #':bool' is replaced with simple string replace
                                        $fields += [':year' => $year];
                                    }

                                    # ADD authorFamilyName TO QUERY and array --------------------------------------
                                    if($_POST['authorFamilyName']!=null && $_POST['authorFamilyName']!=''){
                                        $authorFamilyName = $_POST['authorFamilyName'];
                                        # echo 'authorFamilyName: '.$authorFamilyName.'<br>';
                                        $sql .= ' :bool familyName = :authorFamilyName';
                                        /**  NB the DB table attribute is 'familyName ' not author FamilyName */
                                        $fields += [':authorFamilyName' => $authorFamilyName];# where :parm is the param to be bound with $parm
                                    }

                                    # ADD authorGivenName TO QUERY ---------------------------------------------------
                                    if($_POST['authorGivenName']!=null && $_POST['authorGivenName']!=''){
                                        $authorGivenName = $_POST['authorGivenName'];
                                        $sql .= ' :bool givenName = :authorGivenName'; # NB DB table attribute name = givenName - not authorGivenName
                                        $fields += [':authorGivenName' => $authorGivenName];
                                    }

                                    # ADD publisherName TO QUERY and array-------------------------------------------
                                    if($_POST['publisherName']!=null && $_POST['publisherName']!=''){
                                        $publisherName = $_POST['publisherName']; # redundant assignment ?
                                        $sql .= ' :bool publisherName = :publisherName';
                                        $fields += [':publisherName' => $publisherName];
                                    }

                                    # ADD COUNTRY TO QUERY and array-------------------------------------------
                                    if( $_POST['country']!=null && $_POST['country']!='' && $_POST['country']!='All' ){
                                        #we dont add country to the query if it is set to 'all', as it is not narrowing the search
                                        #if($country!=null && $country!=''){
                                        $country = $_POST['country'];
                                        #if ($DEBUG) echo 'DEBUG: <font color="red" country: '.$country.'<br>';
                                        $sql .= ' :bool country = :country';
                                        $fields += [':country' => $country];
                                    }

                                    # Replace :bool substrings ----------------------------------------
                                    if($srchopt=='All'){
                                        $sql = str_replace(":bool","\nAND",$sql); #AND
                                    }else{
                                        $sql = str_replace(":bool","\nOR",$sql); #OR
                                    }

                                    #finalise query
                                    #$sql .= ' ) ORDER BY :sort'; # closing parentheses added
                                    $sql .= ' ORDER BY :sort';

                                    # PDO PREPARE->EXECUTE->FETCH
                                    $stmt1 = $conn->prepare($sql);
                                    # PDO
                                    if($DEBUG){
                                        echo 'query: ';
                                        echo $sql.'<br>';
                                        echo 'param fields: ';
                                        # FIELDS
                                        print_r($fields);
                                    }
                                    $stmt1->execute($fields);

                                    if(!$stmt1){
                                        echo '<h3 id="headerTitleSearchNoResults">';
                                        echo '<a href="ADHD_searchKeyword.php">';
                                        echo 'No Results found!<br><br>Try again with new search criterion.</a></h3>';
                                        echo '</table>';

                                    }else{
                                        ##########################
                                        # POSITIVE SEARCH RESULT #
                                        ##########################
                                        /** using sizeOf() function is regarded as bad practice?:
                                         * http://php.net/manual/en/function.sizeof.php
                                         */

                                        $res = $stmt1->fetchAll();
                                        $count = count($res);
                                        # if ($DEBUG)echo 'DEBUG: <font color="red" result array size: '.$count.'<br>';

                                        # DISPLAY HIT COUNT FROM SEARCH
                                        echo '<div id="headerTitleSearchNoResults">';
                                        echo '<br>';
                                        echo '<font color = "black">';
                                        echo $count;
                                        echo ' result';
                                        if($count != 1) echo 's';# handle plural case
                                        echo ' found...<br>';# space between words must be on this line
                                        echo '</div>';

                                        # LINK to search again
                                        #echo '<br>';
                                        echo '<a href="ADHD_search.php" style="
                                                font-size: 1.5em;
                                                /*font-family: Raleway;*/
                                                ">
                                                Search Again...<a>';

                                        # set up OUTER TABLE
                                        echo '<br>';
                                        #echo '<hr>';
                                        echo '<table border="'.($TOGGLE_TABLE_BORDERS * 1).'" ';
                                        echo 'style="';
                                        echo 'border-color:   whitesmoke;
                                              border-width:     0px;
                                              border-top:       none;
                                              border-bottom: 	none;
                                              border-left: 	none;
                                              border-right: 	none;
                                        ';
                                        echo '">';

                                        # BIND RESULTS with a FOREACH statement
                                        $n= 0;
                                        foreach($res as $row){
                                            echo '<tr><td>';
                                            echo '<p>';

                                            # SETUP VARIABLES
                                            $softwareID 	= clean($row['softwareID'] );
                                            $title 			= clean($row['title'] );
                                            $year 			= clean($row['year'] );
                                            $familyName 	= clean($row['familyName'] );
                                            $givenName 		= clean($row['givenName'] );
                                            $country 		= clean($row['country'] );
                                            $publisherName 	= clean($row['publisherName'] );
                                            $licenceList 	= clean($row['licenceList'] );
                                            $softwareReq 	= clean($row['softwareReq'] );
                                            $hardwareReq 	= clean($row['hardwareReq'] );
                                            $description 	= clean($row['description'] );
                                            $notes 			= clean($row['notes'] );
                                            $titleTemp = '';

                                            /** Display a LINK made up of TITLE and YEAR */
                                            if(!empty($title) && !is_null($title)){
                                                $titleTemp = $title;
                                            }
                                            echo '<h3 style="
                                                font-size: 1.17em;
                                                font-weight: bold; 
                                                ">';
                                            echo '<a href="ADHD_modifyEntry.php?id='.$softwareID;
                                            echo '">';
                                            echo $titleTemp;
                                            if(!empty($year)) echo ' | '.$year;
                                            echo '</a>';echo '</h3>';

                                            /** Display SEARCH RESULTS */
                                            echo '<div id="listContent">';
                                            if(!$TABULAR_RESULTS) {
                                                # TITLE
                                                if (!is_null($title) && !empty($title)) {
                                                    echo "<b>Title: </b>" . $title . '<br>';
                                                }

                                                # year
                                                if (!is_null($year) && !empty($year)) {
                                                    echo "<b>Year: </b>" . $year . '<br>';
                                                }

                                                # familyName
                                                if ($familyName != '') {
                                                    if ($givenName != '') {
                                                        $familyNameArr = explode(",", $familyName);
                                                        # print_r($familyNameArr);

                                                        $givenNameArr = explode(",", $givenName);
                                                        $fullNameArr = array();

                                                        for ($i = 0; $i < sizeOf($givenNameArr); $i++) {
                                                            $fullNameArr[$i] = $givenNameArr[$i];
                                                            $fullNameArr[$i] .= " ";
                                                            $fullNameArr[$i] .= $familyNameArr[$i];
                                                        }
                                                        $fullNameArrTemp = implode(", ", $fullNameArr);

                                                        echo "<b>Author(s): </b>" . $fullNameArrTemp;
                                                        echo '<br>';
                                                    }
                                                }
                                                # publisherName
                                                if (!is_null($publisherName) &&
                                                    !empty($publisherName)) {
                                                    echo "<b>Publisher: </b>" . $publisherName . '<br>';
                                                }
                                                # country
                                                if (!is_null($country) && !empty($country)) {
                                                    echo "<b>Country: </b>" . $country;
                                                    echo '<br>';
                                                }
                                                # License List
                                                if (!is_null($licenceList) && !empty($licenceList)) {
                                                    echo "<b>Licence: </b>" . $licenceList;
                                                    echo '<br>';
                                                }
                                                # Hardware Requirements
                                                if (!is_null($hardwareReq) && !empty($hardwareReq)) {
                                                    echo "<b>Hardware Requirements: </b><br>" . $hardwareReq;
                                                    echo '<br>';
                                                }
                                                # Software Requirements
                                                if (!is_null($softwareReq) && !empty($softwareReq)) {
                                                    echo "<b>Software Requirements: </b><br>";
                                                    echo $softwareReq;
                                                    echo '<br>';
                                                    echo '<br>';
                                                }
                                                # Description
                                                if (!is_null($description) && !empty($description)) {
                                                    echo "<b>Description: </b>" . $description;
                                                    echo '<br>';
                                                    echo '<br>';
                                                }
                                                # Notes
                                                if (!is_null($notes) && !empty($notes)) {
                                                    echo "<b>Notes: </b>" . $notes;
                                                }
                                                echo '</td></tr>';
                                            } else {
                                                # TABULAR RESULTS = TRUE
                                                echo '<table border = '.$TOGGLE_TABLE_BORDERS.'
                                                        style="
                                                            border-color:   whitesmoke;
                                                            font-family:    "Raleway";
                                                            font-size:      12;
                                                            border-width:   0px;
                                                            ]\border-top:   none;
                                                            border-bottom: 	none;
                                                            border-left: 	none;
                                                            border-right: 	none;
                                                            
                                                        " width = "100%">';
                                                #TITLE
                                                if (!is_null($title) && !empty($title)) {
                                                    echo '<tr width=""30%"><td>';
                                                    echo '<font size="2px">';
                                                    echo "<b>Title: </b>";
                                                    echo '</td><td>';
                                                    echo '<font size="2px">';
                                                    echo $title;
                                                    echo '</td></tr>';
                                                }
                                                #YEAR
                                                if (!is_null($year) && !empty($year)) {
                                                    echo '<tr><td>';
                                                    echo '<font size="2px">';
                                                    echo '<b>Year: </b>';
                                                    echo '</td><td>';
                                                    echo '<font size="2px">';
                                                    echo $year.'</td></tr>';
                                                }
                                                # MULTIPLE AUTHORS
                                                if ($familyName != '') {
                                                    if ($givenName != '') {
                                                        $familyNameArr = explode(",", $familyName);
                                                        $givenNameArr = explode(",", $givenName);

                                                        $fullNameArr = array();
                                                        for ($i = 0; $i < sizeOf($givenNameArr); $i++) {
                                                            $fullNameArr[$i] = $givenNameArr[$i];
                                                            $fullNameArr[$i] .= " ";
                                                            $fullNameArr[$i] .= $familyNameArr[$i];
                                                        }
                                                        $fullNameArrTemp = implode(", ", $fullNameArr);

                                                        echo '<tr width=""30%"><td>';
                                                        echo '<font size="2px">';
                                                        echo '<b>Author(s): </b>';
                                                        echo '</td><td>';
                                                        echo '<font size="2px">';
                                                        echo $fullNameArrTemp;
                                                        echo '</td></tr>';
                                                    }
                                                }
                                                # publisherName
                                                if (!is_null($publisherName) &&
                                                    !empty($publisherName)) {
                                                    echo '<tr><td>';
                                                    echo '<font size="2px">';
                                                    echo '<b>Publisher: </b>' . '</td><td>';
                                                    echo '<font size="2px">';
                                                    echo $publisherName;
                                                    echo '</td></tr>';
                                                }
                                                # country
                                                if (!is_null($country) && !empty($country)) {
                                                    echo '<tr><td>';
                                                    echo '<font size="2px">';
                                                    echo '<b>Country: </b></td>';
                                                    echo '<td>';
                                                    echo '<font size="2px">';
                                                    echo $country;
                                                    echo '</td></tr>';
                                                }
                                                # License List
                                                if (!is_null($licenceList) && !empty($licenceList)) {
                                                    echo '<tr><td>';
                                                    echo '<font size="2px">';
                                                    echo "<b>Licence: </b>";
                                                    echo '</td><td>';
                                                    echo '<font size="2px">';
                                                    echo $licenceList;
                                                    echo '</td></tr>';
                                                }
                                                # Hardware Requirements
                                                if (!is_null($hardwareReq) && !empty($hardwareReq)) {
                                                    echo '<tr><td>';
                                                    echo '<font size="2px">';
                                                    echo "<b>Hardware Requirements: </b>";
                                                    echo '</td><td>';
                                                    echo '<font size="2px">';
                                                    echo $hardwareReq;
                                                    echo '</td></tr>';
                                                }
                                                # Software Requirements
                                                if (!is_null($softwareReq) && !empty($softwareReq)) {
                                                    echo '<tr><td>';
                                                    echo '<font size="2px">';
                                                    echo "<b>Software Requirements: </b>";
                                                    echo '</td><td>';
                                                    echo '<font size="2px">';
                                                    echo $softwareReq;
                                                    #echo '<br>';
                                                    echo '</td></tr>';
                                                }
                                                # Description
                                                if (!is_null($description) && !empty($description)) {
                                                    echo '<tr><td>';
                                                    echo '<font size="2px">';
                                                    echo "<b>Description: </b>";
                                                    echo '</td><td>';
                                                    echo '<font size="2px">';
                                                    echo $description;
                                                    echo '<br>';
                                                    echo '</td></tr>';
                                                }
                                                # Notes
                                                if (!is_null($notes) && !empty($notes)) {
                                                    echo '<tr><td>';
                                                    echo '<font size="2px">';
                                                    echo '<b>Notes: </b>';
                                                    # font Override to make the text more readable
                                                    echo '</td><td stlye = "
                                                        font-family: Raleway;">';
                                                    echo '<font size="2px">';
                                                    echo $notes;
                                                    echo '</td></tr>';
                                                }
                                            }
                                            echo '</td></tr>'; #final row for images

                                            echo '</div>'; # end of list content style

                                            # ------------------------------------------------------------------------------------
                                            if($TOGGLE_UPLOADS) {
                                                /** LIST UPLOADS ------------------------------------------------- */
                                                include('includes/ADHD_listUploads.php');#indentation caused by included file above
                                                echo '</tr></table>';
                                                echo '</table>';
                                                /** ------------------------------------------------- */
                                                $n++;
                                                if ($DEBUG) echo 'DEBUG: <font color="red" $n(query result iteration): ' . $n . '<br>';
                                                echo '<a href="ADHD_modifyEntry.php?id=' . $softwareID . '">';

                                                #toggle icon for moodify entry
                                                if ($TOGGLE_MODIFY_ENTRY_ICON) {
                                                    echo '<img src="../images/ADHD/ADHD_modifyEntry.png" width="30" height="30">';
                                                }
                                                echo ' <span style = "color: #d18e1b;">';
                                                echo 'You can modify this entry if you know more information about it.</span></a>';
                                            } #end if toggle uploads
                                        } #end foreach

                                        echo '</table>';
                                        echo '</div>';
                                    } #end else
                                    echo '</table>';
                                } #end if posted
                                echo '</div>';
                            ?>
                    </div> <!-- #inner body left1 -->
                </div> <!-- #inner mainleft -->
            </div> <!-- #inner mainContent -->
        </div> <!-- #outer main Content -->

    <div id="outerFooterContent">
    <div id="innerFooterContent">
        <?php include("includes/ADHD_footerIndex.php"); ?>
    </div>
    </div><!-- # outer footer content -->
    <div id="outerFooterDeclarations">
			<div id="innerFooterDeclarations">
				<span id="infoFooterCopyright"><?php include("includes/ADHD_copyright.php"); 
					/** File that contains the copyright notice ...
					the copyright year is incremented automatically */
				?></span>
			</div><!-- # inner footer -->
		</div><!-- # outer footer -->
	</div><!-- # main wrapper -->
	<!-- Support for place holders for legacy browsers (DO NOT MOVE) -->
    <script src="../script/placeholders.min.js"></script>
</body>
</html>