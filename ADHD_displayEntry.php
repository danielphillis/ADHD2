<!-- code last augmented by daniel phillis for Flinders University 2017
email: daniel.phillis@gmail.com
@@@ symbol indicates recent changes, acting as a bookmark
this file is a duplicate of the highest incremented version
-->

<!-- code last augmented by daniel phillis for Flinders University 2017
daniel.phillis@gmail.com
@@@ symbol indicates recent changes
-->
<script type="text/javascript">
    /* Onload script:
   make sure 'element one' is hidden (but what is this element ?) */
    window.onload = setup;

    function setup() {
        document.getElementById('one').style.display = 'none';
        document.getElementById('modForm').style.display = 'none';
    }

    /* SHOW ELEMENT */
    function show(newItem) {
        var item = document.getElementById(newItem);
        if (item.style.display == 'none') {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    }

    /* SHOW MENU used to show or hide form fieds as required */
    function ShowMenu(num, menu, max) {
        /* starting at one, loop through until the number chosen by the user */

        /* document.write('ShowMenu function called'); */

        for (i = 1; i <= num; i++) {

            /* add number onto end of menu */
            var menu2 = menu + i; #ie divInput1
            /* document.write(menu2); */
            /* change visibility to block, or 'visible' */
            document.getElementById(menu2).style.display = 'block';
        }
        /* make a number one more than the number that was input */
        var num2 = num;
        num2++;
        /* hide it if the viewer selects a number lower
        this will hide every number between the selected number and the maximum
        eg.  if 3 is selected, hide the <div> cells for 4, 5, and 6
        loop until max is reached */
        while (num2 <= max) {
            var menu3 = menu + num2;

            document.getElementById(menu3).style.display = 'none';
            /*add one to loop*/
            num2 = num2 + 1;
        }
    }

    /* SHOW ELEMENT (redundant?) */
    function show(elem) {
        elem.style.display = "block";
    }
    /* HIDE ELEMENT (redundant?) */
    function hide(elem) {
        elem.style.display = "";
</script>

<?php
    $currentPage="DISPLAY_ENTRY";
    
    #if js view is 1, a lik is provided to expand search results to show all data 
    #(a functional requirement)
    $jsView = 0;
    $useView = 0;
?>
<!doctype html>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]> <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]> <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]>
<!-->
<html class="">
<!--<![endif]-->

    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Search Records</title>
    <link href="../css/boilerplate.css" rel="stylesheet" type="text/css">
    <link href="../css/ADHD_layout.css" rel="stylesheet" type="text/css">
    <!--[if lt IE 9]>
    <link href="../css/ie_layout.css" rel="stylesheet" type="text/css">
    <![endif]-->
    <!--[if lt IE 8]>
    <![endif]-->
    
    <script src="../script/jquery-3.2.1.min.js">
    </script>
   <script type="text/javascript">

    /** Onload script: make sure element one is hidden */

    window.onload = setup;

    function setup() {
        document.getElementById('one').style.display = 'none';
        document.getElementById('fullTable').style.display = 'none';
    }

    /** SHOW ELEMENT 
     * 
     * newItem must have an element ID
     * */
    
    function show(newItem) {
        var item = document.getElementById(newItem);
        if (item.style.display == 'none') {
            item.style.display = 'block';
        } else {
            item.style.display = 'none';
        }
    }

    /** SHOW MENU */
    function ShowMenu(num, menu, max) {
        //starting at one, loop through until the number chosen by the user
        for (i = 1; i <= num; i++) {
            //add number onto end of menu
            var menu2 = menu + i;
            //change visibility to block, or 'visible'
            document.getElementById(menu2).style.display = 'block';
        }
        //make a number one more than the number that was input
        var num2 = num;
        num2++;
        //hide it if the viewer selects a number lower
        //this will hide every number between the selected number and the maximum
        //ex.  if 3 is selected, hide the <div> cells for 4, 5, and 6
        //loop until max is reached
        while (num2 <= max) {
            var menu3 = menu + num2;
            //hide
            document.getElementById(menu3).style.display = 'none';
            //add one to loop
            num2 = num2 + 1;
        }
    }

</script>
    
</head>
    <body>
    <div class="mainWrapper">
    <!-- DIV containing the AHSD social links -->
    <div id="outerSocialLinks">
        <?php include("includes/ADHD_socialLinksHeader.php"); #File that contains the social links icons above the header section ?>
    </div>

    <!-- DIV containing the main navigation menu and the logo -->
    <div id="outerHeader">
        <?php include("includes/ADHD_mainNavigationMenu.php"); #File that contains the main navigation menu and the logo ?>
    </div>

    <!-- DIV containing the links to the social accounts, AHSD logo and menu in mobile mode -->
    <?php include("includes/ADHD_mobileNavigationHeader.php"); #File that contains the social accounts, AHSD logo and menu in mobile mode ?>

        <!-- DIV containing the main content -->
        <div id="outerMainContent">
        <div id="innerMainContent">
        <!-- @@@ indexInnerBodyLeft_1 is the main white text box with shadowing
        - the box we want to scale for this page is mainContentLeftColumn
        (by overriding the css style below) -->
        <!-- Width of search results div element -->
        <div id="innerMainContentLeftColumn" style="min-width: 80%;">
            <div id="indexInnerBodyLeft_1" style="
                /* OVERRIDE  to accommodate more text/ search results */
                width: 100%;
                max-width: 1250px; /* was 805 */
                background-color: #FFF; /* white */
                position: relative;
                height: auto;
                float: center; /* changed from left */
                -webkit-box-shadow: 0 1px 35px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
                -moz-box-shadow: 0 1px 35px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
                box-shadow: 0 1px 35px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
            ">

            <!-- DETAILED SEARCH PARAMETERS -->
            <!-- no  href link specified here therefore this is the detailed search content-->
                <div id="detailed" style="
                    display: block;
                    margin: 25px;
                ">
                <h1 id="headerTitle">
                <a  style="font-size: 15px; font-weight: 550;"
                    href="ADHD_search.php">
                    Search |
                <a  style="font-size: 15px; font-weight: 550;" href="ADHD_searchKeyword.php" ">Keyword Search</a> |
                <a  style="font-size: 15px; font-weight: 550;" href="ADHD_searchTitleList.php" ">Title List</a></h1>
                <p>
                <div id="listContent">
                <?php
                    /* Apply html special chars function - shorthand convenience function */
                    include ('includes/ADHD_functionsDisplayData.php');
                    include ('includes/ADHD_functionsQueries.php');
                    #include ('includes/ADHD_functionsCreate.php');
                    include ('includes/ADHD_functionsUtilities.php');
                ?>
                    
                <?php
                    global $title, $familyName, $givenName, $publisherName, 
                    $country, $licenceList, $hardwareReq, $softwareReq,
                    $notes, $description, $softwareID;

                    global $DEBUG, $DEBUG_STRING;
                    global $TOGGLE_TABLE_BORDERS,
                           $TOGGLE_TABLE_BORDERS2,
                           $tableBorderColour1,
                           $tableBorderColour2;
                           
                    $TOGGLE_Q_VIEW          = 1;
                    $TOGGLE_TABLE_BORDERS1  = 1;
                    $TOGGLE_TABLE_BORDERS2  = 1;
                    #$tableBorderColour1     = '#0badde'; #light blue
                    #$tableBorderColour2     = '#0badd0'; #teal
                    $tableBorderColour1     = 'whitesmoke'; #offwhite
                    $tableBorderColour2     = 'whitesmoke'; #offwhite
                    $DEBUG                  = 1;
                    $_debug                 = 0;
                    $DEBUG_STRING           = '';
                    
                    $imgWidth               = 140;
                    $imgHeight              = 100;

                    error_reporting(E_ALL);
                    ini_set('display_errors',1);

                    # ---------------- First result (primary) displayed to the users ---------------------------- #

                    require_once('../conn/ADHD_DB_CONNECTION_PDO.php');
                    
                    $conn = connectDB();
                    
                    if(!$conn){
                        # @@@ todo: handle broken connection gracefully
                        echo '<b><br>Sorry, could not establish a DataBase Connection...<br>'
                        . 'please try again later...<br></b>';
                        exit();
                        
                    } else {
                        
                        if ($_debug) _msgBox ('g', 'connection is active...');
                        
                         #if(!is_null($_POST['id'])){
                        $softwareID = $_GET['id'];
                        
                        if(!is_null($softwareID)){
                            #$softwareID = $_GET['id'];
                            
                            /**
                             * id is not defined - the user has browsed to ADHD_displayEntry.php 
                             * without having selected a title from
                             * the set of search results
                             */
                            
                            /* REDIRECT back to search (local only)?
                             * 
                            
                            echo '<script type="text/javascript">
                            window.location = "http://localhost:8080/NBPhp/AHSD/ADHD/ADHD_searchTitleList.php"
                                </script>';
                             
                             */
                            
                            #test: $softwareID = 7;
                            
                        } else {
                            die('<b>displayEntry *id* parm not defined...<b>');
                        }
                        $titleTemp = "";
                        $result = queryView(1, $softwareID, 0, 0);#$use view ?, swID, $_debug
                        
                        $softwareID     = $result['softwareID'];
                        $title          = $result['title'];
                        $year           = $result['year'];
                        
                        if (!$result['publisherName']){
                            if ($_debug) _msgBox('g', 'publisher name not found - possibly '
                                    . 'query is using software table not the view '
                                    . 'vSoftware ?');
                                $publisherName  = '';
                        } else {
                            $publisherName  = $result['publisherName'];
                        }
                        $hardwareReq    = $result['hardwareReq'];
                        $softwareReq    = $result['softwareReq'];
                        $licenceList    = $result['licenceList'];
                        $country        = $result['country'];
                        $description    = $result['description'];
                        $notes          = $result['notes'];
                        
                        if (!$result['givenName']){
                            if ($_debug) _msgBox('g', 'givenName name not found - possibly query is '
                                    . 'using software table not the view vSoftware ?');
                            $givenName = 'Frank';
                        } else {
                            $givenName      = $result['givenName'];
                        }
                        
                        if (!$result['familyName']){
                            if ($_debug) _msgBox('g', 'familyName not found - possibly query is '
                                    . 'using software table not the view vSoftware ?');
                            $givenName = 'Frazetta';
                        } else {
                            $familyName     = $result['familyName'];
                        }

                        #HTML special CHARS function should be deprecated
                        $title          = htmlspecialchars($title);
                        $year           = htmlspecialchars($year);
                        $publisherName  = htmlspecialchars($publisherName);
                        $hardwareReq    = htmlspecialchars($hardwareReq);
                        $softwareReq    = htmlspecialchars($softwareReq);
                        $licenceList    = htmlspecialchars($licenceList);
                        $country        = htmlspecialchars($country);
                        $description    = htmlspecialchars($description);
                        $notes          = htmlspecialchars($notes);
                        $givenName      = htmlspecialchars($givenName);
                        $familyName     = htmlspecialchars($familyName);

                        if(!is_null($title) && !empty($title)){
                            $titleTemp = $title;
                        }
                        $max = queryMaxSeqNumFromSoftware($softwareID, 0);
                        #echo 'max: '.$max.'<br>';
                        $_debug = 1;
                        
                        $res = array();
                        $res_higher = array();
                        
                        # REVERSE CHRONOLOGICAL order shown in loop parms
                        for ($n=$max;$n>0;$n--){
                            #OLD function -> deprecated
                            #$res = queryAllvSoftwareBy_seqNum_SWID($useView, $n, $softwareID, 1);#$_view, $_seqNum, $sid, $_debug
                            
                            #new view
                            $res = queryView($useView, $softwareID, $n, 0);
                            
                            #todo: Check for Identical Entries
                            
                            echo 'Entry #'.$n.' added on '.$res['insertedDate'];
                            echo '<br>';
                            echo '<a href="ADHD_modifyEntry.php?id='.$softwareID.'" style="line-height: 4em;">';

                            #Link engages CSS styling
                            echo '<p>'.$title;
                            if(!is_null($year) && !empty($year)) echo " | ".$year;
                            echo '</a>';
                            
                            #add link to show all data (helps user to decided if additional data is required)
                            
                            # link to 'show all data' (fullset of data rather than simply the title and the year
                            # is temp disabled here
                            if ($jsView || 1){
                                
                                if(0){
                                    echo '<br></font><a href="ADHD_displayEntry.php?id='.$softwareID
                                        .'" onClick="show(fullTable);">';
                                    echo 'Show All Data';
                                    echo '</a>';
                                }
                                
                                ## FULL TABLE OF DATA (JS used to hide / show)
                                echo '<div class="fullTable" onmousedown="show(fullTable)" >';
                                #displayDataInTable(0);
                            
#DETERMINE IF VIEW IS WORKING ##### ##### ##### ##### ##### ##### ##### ##### ##### ? indicates a toggle
                                # FN parms: $_rebuildView?, $swid, $_debug
                                #$titleData = queryAllvSoftwareByID($useView, $softwareID,1); 

                                #$_view==1 will use the workaround query, (joins), swid, $_debug
                                $titleData = queryView(1, $softwareID, $n, 0); 
                                #$keyColor   =   "whitesmoke";
                                displayDataInTableFromAssocArrayCensored($titleData, 'whitesmoke', 40, 1, 1);
                                
                                $fontSize   =   '.3em';
                                $_pc = 40;

                                /**
                                if (!is_array($titleData)){
                                    echo '<font color="red">error: parm $titleData is not an array<br>';
                                    echo '</font>';
                                    echo '$titleData:';
                                    print($titleData);
                                    exit();
                                } else {
                                    #DRAW TABLE
                                    echo '<table border="1" '
                                    .'border-color = '.$keyColor

                                    #Style USE # to toggle activation
                                    .' style="'
                                    .'font-size: 1em;'
                                    .'width: '.$_pc.'%;'
                                    .'">';

                                    #echo '</font>';
                                    #for all keys - put them into a table column alongside corresponding values
                                    #for compaison of $oldData versus $newData
                                    $cellCounter = 0;

                                    foreach($titleData as $key => $value){

                                        #filter
                                        if ($key != 'publisherID'   ||
                                            $key != 'contributorID' 
                                        ){
                                            $cellCounter++;
                                            #INDEX CELL
                                            echo '<tr><td  width="8%" '
                                            .'">';
                                        #DATA
                                            echo $cellCounter
                                            .'</td>';
                                            #### #### #### #### #### #### #### #### #### ####
                                        #KEY CELL
                                            echo '<td  width="'.$_pc.'%" '
                                        #CELL STYLE
                                            .'style="bgColor: ';

                                            if(($cellCounter%2)==0){
                                                echo $keyColor;
                                            } else {
                                              echo 'green';
                                            };
                                            echo '; '
                                            .'">';

                                        #DATA : #key
                                            echo '<font size="'.$fontSize.'">';
                                            echo $key;
                                            if($key=='publisher') echo '(name)'; # for clarity
                                            echo '</font></td>';
                                        #### #### #### #### #### #### #### #### #### #### 
                                            #DATA TYPE: 
                                            echo '<td width="'.(50).'%>';
                                            echo gettype($value);
                                            echo '</td>';
                                        #### #### #### #### #### #### #### #### #### #### 
                                            echo '<td width="'.(50).'%'
                                            #CELL STYLE
                                            .'style="'
                                            #if (($cellCounter%2)==0) echo 'bgColor: red;'; #alternating row colors
                                            .'">';

                                        #DATA: VALUE
                                            echo '<font size="'.$fontSize.'">'.$value.'</font>'.'</td></tr>';
                                            #### #### #### #### #### #### #### #### #### ####     
                                        }
                                    }
                                    echo '</table>';
                                }
                                */
                                
                            echo '<hr>';
                            echo '</div>';
                        }
                        #displayDataInTableFromAssocArray($titleData, 'red', 100/$max, 1, 1);
                    }
                    #END SEQ NUM LOOP
                    /*  ########################################################
                     * NEW QUERY - RETRIEVE UPLOADED FILES
                        Retrieve uploaded files from the DB in relation to the queried software
                        (but only for seqNum 1) (Aliases in sql are optional according
                        to "http:#www.1keydata.com/sql/sql-as.html"
                        and are purely used to make the code more readable ) 
                    */
                    
                    $queryFiles = "SELECT DISTINCT  
                                  up.fileName, 
                                  up.fileType, 
                                  up.fileSize, 
                                  up.softwareID 
                                FROM    uploadedFiles   AS  up, 
                                        software        AS  s 
                                WHERE   up.sequenceNum  = 1 
                                AND     up.softwareID   = s.softwareID 
                                AND     up.softwareID = '".$softwareID."'"; #sql 'AS' not used here (optional) */

                    $stmtFiles = $conn->query($queryFiles); /* or die($db_connection->error.__LINE__);*/
                    $stmtFiles->execute();

                    #GOING THROUGH THE DATA
                    $resultsSize = sizeOf($stmtFiles);

                    echo '<table border="'.$TOGGLE_TABLE_BORDERS2.'" '
                            . 'border-color="'.$tableBorderColour2.'">'; # TABLE 2

                    if($stmtFiles){
                        $filePathImage  = array();   # Save image names with path in an array for later display
                        $filePathDoc    = array();     # Save document names with path in an array for later display
                        $fileTypeDoc    = array();     # Save document types for later display
                        $fileSizeDoc    = array();     # Save document size for later display

                        $imageFlag  = 0; # To display to user whether the attachment is an image (0=no, 1=yes);
                        $docFlag    = 0; # To display to user whether the attachment is a doc (0=no, 1=yes);
                        $indexImage = 0; # Index for image array
                        $indexDoc   = 0; # Index for doc array
                        $kb         = 1024;
                    }

                    while($rowFile = $stmtFiles->fetch(PDO::FETCH_ASSOC)){
                            #Keeping track of which files are images and which files are documents
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
                        if ($imageFlag == 1) displayImgAttachments($filePathImage,1);                       
                        if ($docFlag == 1) displayDocAttachments($filePathDoc,1);
                        echo '</table>'; #END TABLE
                        echo '<br>';

                        #include("includes/ADHD_modifyEntryNewerVersions.php"); @@@ ??
                        #only include the form if user is wishing to augment the entry

                        #MODIFY ENTRY LINK TEMP DISBALED HERE
                        if(0){
                            echo '<a href="ADHD_modifyEntry.php?id='.$softwareID.'" ';
                            echo '">';
                            echo 'Modify Entry</a><br>';
                        }
                        
                        echo '<div id="modForm" class="modForm">';

                        #DIV MOD FORM
                        echo '<div id="modForm" style="display: none;">';
                        include("includes/ADHD_modifyEntryForm.php");
                        echo '</div>';

                        $accordionGenerateOnce = 1;
                        #Increment to prevent more accordion DIVs generation
                    }

                    #Close accordion DIVs only once
                    if ($accordionGenerateOnce == 1) {
                        echo "</div>";
                        echo "</div>";
                    }
                    #echo "<!--daniel phillis 22-11-17-->";
                    #echo "<!--daniel phillis 08-12-17-->";
                    #echo "<!--daniel phillis 11-12-17-->";
                ?>

                </p>
                <!-- 7 closing div tags -->
                </div>
                </div>
                </div>
                </div>
                </div>
                </div>
                </div>
                <div id="outerFooterContent"> <!--style="background-image: draft_images/BGRamp2.jpg;"> -->
                <div id="innerFooterContent">
                <?php include("includes/ADHD_footerIndex.php"); ?>
                </div>
                </div>
                <div id="outerFooterDeclarations">
                <div id="innerFooterDeclarations">
                <span id="infoFooterCopyright"><?php include("includes/ADHD_copyright.php");
                #File that contains the copyright notice ... the copyright year is incremented automatically ?></span>
                </div>
            </div>
        </div>
        <!-- Support for place holders for legacy browsers (DO NOT MOVE) -->
        <script src="../script/placeholders.min.js"></script>
    </body>
    </html>
    <!-- end -->