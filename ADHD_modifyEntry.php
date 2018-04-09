<!-- code last augmented by daniel phillis for Flinders University 2017
email: daniel.phillis@gmail.com
@@@ symbol indicates recent changes, acting as bookmarks
-->
<script type="text/javascript">

    /** Onload script:
   make sure element one is hidden (but what is this element) */
    window.onload = setup;

    function setup() {
        document.getElementById('one').style.display = 'none';
    }

    /** SHOW ELEMENT */
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

<?php
    $currentPage="MODIFY_ENTRY";
    static $imgWidth       =    140; # image width to display in results
    static $imgHeight      =    100; # image height to display in results
    error_reporting(E_ALL);
    ini_set('display_errors',1);
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
    <title>Modify Entry</title>
    <link href="../css/boilerplate.css" rel="stylesheet" type="text/css">
    <link href="../css/ADHD_layout.css" rel="stylesheet" type="text/css">
    <!--[if lt IE 9]>
	<link href="css/ie_layout.css" rel="stylesheet" type="text/css">
    <![endif]-->
    <!--[if lt IE 8]>
	<![endif]-->
    <script src="../script/jquery-3.2.1.min.js"></script>
    <!-- RECAPTCHA -->
    <!-- <script src='https://www.google.com/recaptcha/api.js'></script> -->
    
    <!-- 
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    -->
    
</head>

<body>
    <div class="mainWrapper">
        
        <div id="outerSocialLinks">   
            <?php include("includes/ADHD_socialLinksHeader.php"); //File that contains the social links icons above the header section ?>
        </div>
        
        <!-- main Nav Menu -->
        <div id="outerHeader">        
            <?php include("includes/ADHD_mainNavigationMenu.php"); //File that contains the main navigation menu and the logo ?>       
        </div>
        
        <?php include("includes/ADHD_mobileNavigationHeader.php"); //File that contains the social accounts, AHSD logo and menu in mobile mode ?>       
        
        <div id="outerMainContent">
            
            <div id="innerMainContent">
                        <!-- Width of search results div element -->
                <div id="innerMainContentLeftColumn" style="min-width: 80%;">
                    
                    <div id="indexInnerBodyLeft_1" style="
                         /* OVERRIDE  to accommodate more text/ search results */
					width: 100%;
					max-width: 1250px; /* was 805 */
					background-color: #FFF; /* white */
					position: relative;
					height: auto;
					/* float: middle; /* changed from left */
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
                        <h3 id="headerTitle"><p>Modify Contribution</p></h3>
                        
                        <?php
                        
                            global $conn;
                            
                            require_once('../conn/ADHD_DB_CONNECTION_PDO.php');
                            $conn = connectDB();
    
                            #include ("includes/ADHD_functionsCreate.php");
                            include ("includes/ADHD_functionsDisplayData.php");
                            include ("includes/ADHD_functionsFormFields.php");
                            include ('includes/ADHD_functionsInsert.php');
                            include ("includes/ADHD_functionsQueries.php");

                            include ('includes/ADHD_functionsUtilities.php');
                            include ('includes/ADHD_functionsValidation.php');
                            
                             /**
                             * checkForm
                             * @param type $_debug
                             */
                            FUNCTION checkForm($_debug){
                                GLOBAL $conn;
                                #GLOBAL $HTTP_POST_VARS;
                                GLOBAL $error; #error array no longer being used 
                                GLOBAL $printAgain, $savetitle;
                                GLOBAL $insertionStatus, $captchaStatus, $fileUploadStatus;    
                                GLOBAL $softwareID, $seqNum; #(updated, incremented)
                                GLOBAL $oldSeqNum,$oldData;

                                global $authorGivenName;
                                global $authorGivenName1;
                                global $authorGivenName2;
                                global $authorGivenName3;
                                global $authorGivenName4;

                                global $authorFamilyName;
                                global $authorFamilyName1;
                                global $authorFamilyName2;
                                global $authorFamilyName3;
                                global $authorFamilyName4;

                                $UNIT_TEST          =   0;
                                $debugChangeTable   =   1;
                                
                                if (formCheckMandatoryFields(0)==0){
                                    #$error['fields'] = 1;
                                    #0 means there is no error
                                    if($_debug){
                                        _msgBox('g','<i>All mandatory form data present...</i>');
                                        _msgBox('o','<i>BUT present != validated...</i>'); #present != validated
                                    }
                                } else {
                                    if($_debug){
                                        _msgBox('o','mandatory from field check failed...');
                                        _msgBox('o','printAgain var set to one '); 
                                    }
                                    $printAgain = 1;
                                }
                                $newData = formStoreData(1);#$_debug=0 
                                
                                $deb = 'contributorID: '.$newData['contributorID'].'<br>';
                                
                                _msgBox('r', $deb);
                                
                                if ($_debug){ 
                                    if(!$captchaStatus){
                                        _msgBox('g','capture status: '.$captchaStatus);
                                    } else {
                                        _msgBox('o','capture status: '.$captchaStatus);
                                    }   
                                    if(!$insertionStatus){
                                        _msgBox('g','insertion status: '.$insertionStatus);
                                    } else {
                                        _msgBox('o','insertion status: '.$insertionStatus);
                                    }
                                    if(!$insertionStatus){
                                        _msgBox('g','fileUpload status: '.$fileUploadStatus);
                                    } else {
                                        _msgBox('o','fileUpload status: '.$fileUploadStatus);
                                    }
                                }
                                if($captchaStatus == 0 && $insertionStatus ==0 && $fileUploadStatus ==0){
                                    $publisherName = $newData['publisher'];
                                    $publisher = $publisherName; 
                                
                                    if($_debug){
                                        echo 'modEntry->oldSeqNum was: '.$oldSeqNum.'<br>';
                                        echo 'modEntry->seqNum currently: '.$seqNum.'<br>';
                                    }

                                    $qseqNum = queryMaxSeqNumFromSoftware($softwareID, 0);
                                    if($_debug) echo 'modEntry->inc->MAX(seqNum) currently: '.$qseqNum.'<br>';
                                    #MAIN INCREMENT
                                    $seqNum = $qseqNum + 1;
                                    if($_debug) echo 'modEntry-> <u>*modified*</u> seqNum now: '.$seqNum.'<br>';

                                    #update tables with new seqNum we can use old insert structure
                                    $newData['sequenceNum'] = $seqNum;

                                    # add inserted date
                                    $newData['insertedDate'] = (string) date("Y-m-d");

                                    if($_debug) compareArraysInTables($oldData, $newData,0); #add cell highlighting
                                    $s1 = queryMaxSeqNumFromSoftware($softwareID,0); #$_debug = 0 (# by swid)
                                    
                                    if ($_debug) echo '$s1(queried seqNum):'.$s1.'<br>';
                                    $_newSeqNum = $newData['sequenceNum'];
                                    
                                    if ($_debug) echo '$_newSeqNum/$newData[\"sequenceNum\"]: '.$_newSeqNum.'<br>';
                                    $seqNum = $_newSeqNum; #increment / update seqNum

                                    augmentSoftwareEntry4($newData, 1);
                                    # add to software_authors table
                                    /** check for newly added authors in form
                                         * insert authors in a loop with the new seqNum and sftwareID
                                     */

                                    #LOOP FOR INSERTION (FOR PRE-EXISTING AUTHOR) needs to be in a loop
                                    if ($_debug){
                                        echo '<h3><hr>Insert 0-5 Authors to author_software<h3></font></h3></b>';
                                        _msgBox('g', 'DEBUG: CRUD - retrieve Author IDs from authors in FORM fields...');
                                    }

                                    /* Determine authorNo - the number of authors to insert into the DB
                                    from the modify entry form (code previously in modifyEntryForm.php) */

                                    #LOCAL arrays to deal with names
                                    $authorGVars = array(
                                        $authorGivenName,
                                        $authorGivenName1,
                                        $authorGivenName2,
                                        $authorGivenName3,
                                        $authorGivenName4
                                    );
                                    $authorFVars = array(
                                        $authorFamilyName,
                                        $authorFamilyName1,
                                        $authorFamilyName2,
                                        $authorFamilyName3,
                                        $authorFamilyName4
                                    );
                                    $authorNo = 5;

                                    $arrayAuthorIDs = array(
                                        0 => 0,
                                        1 => 0,
                                        2 => 0,
                                        3 => 0,
                                        4 => 0
                                    );

                                    $verifTestTally = 0;

                                    #get the IDs from the names
                                    for($n=0;$n < $authorNo; $n++){#loop over array of authors
                                        #insert all relevant authors (for a specific software title) to *author-software table*
                                        if ($_debug) echo '$n: '.$n.'<br>';

                                        $fn = $authorFVars[$n];
                                        $gn = $authorGVars[$n];

                                        #get the IDs from the names (if one is blank then dont enter anything)
                                        if ($gn != '' && $fn !=''){    
                                            $arrayAuthorIDs[$n] = queryAuthorIDFromAuthorByName($gn, $fn, $_debug);
                                        } else {
                                            if($_debug){
                                                echo 'author name (given or family )is empty?<br>';
                                                echo 'author name not yet entered...(for this seqNum)<br>';
                                                echo 'checking for previous seqNum...<br>';
                                                #_msgBox('o','<i>implies we need to check authors for *any/all* seqNums ?...</i>');
                                            }
                                        }
                                        #If there is an existing author -> insert to author_software table, 
                                        if($arrayAuthorIDs[$n] != 0){ 
                                            _msgBox('y', 'W:calling insertAuthorsToAuthorSoftwareByIDArray($_ar, 1)');
                                            insertAuthorsToAuthorSoftwareByIDArray($arrayAuthorIDs[$n], 1); #new signature does away with swid
                                        }
                                        #AUTHOR VERIFICATION - retrieve 5 new authors  
                                    } #end loop
                                    #$m = $n;
                                    #
                                    ### VERIFCATION ###
                                    $verif_debug = 0;
                                    if($verif_debug) _msgBox('g', 'V: verification of author_software entries');
                                    $v_authIDs = queryAuthorIDsFromAuthSoftware($softwareID, 0);

                                    if($_debug) echo count($v_authIDs).' counted<br>';

                                    if($_debug && FALSE){
                                        foreach($v_authIDs as $k => $v){
                                            echo $k.' => '.$v.'<br>';
                                        }
                                        #verify insertion worked
                                        if($verif_debug) _msgBox('o','STILL TO DO : verifying augmenting the entry worked...');
                                    }
                                } #end error check
                            }#END OF FUNCTION

                            if(!$conn){
                                # @@@ todo: handle broken connection gracefully
                                echo '<b><br>Sorry, could not establish a DataBase Connection...<br>'
                                . 'please try again later...php exiting...<br></b>';
                                exit();
                            } else {#problems using http post for unknown reasons
                            
                                #echo 'connected !';
                                $softwareID = $_GET['id'];
                                $oldData = queryView(1, $softwareID , 0 ,1); #rebuild_view, swid, [seqNum (optional)], debug
                                $oldTitle = $oldData['title'];
                                $validateTitle = querySoftwareTitleFromSW($softwareID, 0);
                                
                                if($validateTitle !== $oldTitle){
                                    _msgBox('o','augmented title is different to the existing title...<br>'
                                    . 'does one instance of the title have a typo ?'
                                    . 'or title returning blank when trying to use view with no view access ?');
                                }
                                
                                $qseqNum = queryMaxSeqNumFromSoftware($softwareID, 0);
                                $oldSeqNum  = $qseqNum;
                                $seqNum = $qseqNum;
                                
                                $title          = $oldData['title'];
                                $softwareID     = $oldData['softwareID'];
                                $year           = $oldData['year'];

                                if (!$oldData['publisherName']){
                                    $publisherName = 'NULL';
                                } else {
                                    $publisherName  = $oldData['publisherName'];
                                }

                                $hardwareReq    = $oldData['hardwareReq'];
                                $softwareReq    = $oldData['softwareReq'];
                                $licenceList    = $oldData['licenceList'];
                                $country        = $oldData['country'];
                                $description    = $oldData['description'];
                                $notes          = $oldData['notes'];
                                $givenName      = $oldData['givenName'];  #(contributor)
                                $familyName     = $oldData['familyName']; #(contributor)
                                
                                $authArray = array();
        
                                if(     is_null($authorNo)  ||
                                        $authorNo == 0      ||
                                        $authorNo =='0'     ||
                                        $authorNo == ''     ){
                                    #if($authorNo == 0){
                                    $authorNo = queryAuthorIDsFromAuthSoftware($softwareID, 0); #returns nested array
                                    $type = gettype($authorNo);
                                    if($type !== (gettype(array('a' => 'b'))) && $type !== NULL){
                                        if ($_debug )_msgBox('o','authorNo is not type array but type: '.gettype($authorNo));
                                    }

                                    if(is_null($authorNo)){
                                         if ($_debug == 2) _msgBox('o', 'W: authorNo returned null, no authors entered at all for this software...');
                                    } else {
                                        #ARRAY OF AUTHORS EXISTS #foreach authorID
                                        foreach($authorNo as $k => $v){
                                            $authArray[]= $v['authorID'];
                                            $currentAuthor = $v['authorID'];
                                        }
                                        # @@@ rather than using 2 queries...why not do it in one using a join ?
                                        if ($DEBUG){
                                            echo 'authArray: <br>';
                                            print_r($authArray);
                                            echo '<br>';
                                        }
                                    }
                                }
                                #authorIDs added to $authArray()

                                $oldVarNames = array(
                                    'title'         =>  $title, 
                                    'softwareID'    =>  $softwareID, 
                                    'year'          =>  $year, 
                                    'publisherName' =>  $publisherName, 
                                    'hardwareReq'   =>  $hardwareReq, 
                                    'softwareReq'   =>  $softwareReq, 
                                    'licenceList'   =>  $licenceList, 
                                    'country'       =>  $country,
                                    'description'   =>  $description, 
                                    'notes'         =>  $notes, 
                                    'givenName'     =>  $givenName, 
                                    'familyName'    =>  $familyName
                                );
                                
                                foreach ($oldVarNames as $key => $value){    
                                    #clean
                                    switch($key){
                                        case 'title': 
                                            $title = cleanSimple($title,'title',0);
                                            #write back into array
                                            $oldVarNames['title'] = $title;
                                            break;
                                        case 'softwareID':
                                            $softwareID = cleanNumeric($softwareID,'softwareID',0);
                                            $oldVarNames['softwareID'] = $softwareID;
                                            break;
                                        case 'year':
                                            $year = cleanNumeric($year, 'year',0);
                                            $oldVarNames['year'] = $year;              
                                            break;
                                        case 'publisherName':
                                            $publisherName = cleanSimple($publisherName, 'publisherName',0);
                                            $oldVarNames['publisherName'] = $publisherName;
                                            break;
                                        case 'hardwareReq':
                                            $hardwareReq = cleanComplex($hardwareReq, 'hardwareReq',0);
                                            $oldVarNames['hardwareReq'] = $hardwareReq;
                                            break;
                                        case 'softwareReq':
                                            $softwareReq = cleanComplex($softwareReq, 'softwareReq',0);
                                            $oldVarNames['softwareReq'] = $softwareReq;
                                            break;
                                        case 'licenceList':
                                            $licenceList = whiteListLicence($licenceList, 'licenceList',0);
                                            $oldVarNames['licenceList'] = $licenceList;
                                            break;
                                        case 'country':
                                            $country = whiteListCountry($country,'country',0);
                                            $oldVarNames['country'] = $country;
                                            break;
                                        case 'description':
                                            $description = cleanComplex($description,'description',0);
                                            $oldVarNames['description'] = $description;
                                            break;
                                        case 'notes':
                                            $notes = cleanComplex($notes,'notes',0);
                                            $oldVarNames['notes'] = $notes;
                                            break;
                                        case 'givenName': #(contributor)
                                            $givenName = cleanSimple($givenName,'givenName',0);
                                            $oldVarNames['givenName'] = $givenName;
                                            break;
                                        case 'familyName':
                                            $familyName = cleanSimple($familyName,'familyName',0);
                                            $oldVarNames['familyName'] = $familyName;
                                            break;
                                    }
                                }#end foreach
                                
                                $lightGreen = '#ccffcc';
                                _msgBox($lightGreen, '<b>cleaned / sanitized input:</b>');
                                if($_debug) displayDataInTableFromAssocArray($oldVarNames, $lightGreen, 40, 0);#DISPLAY OLD DATA IN TABLE
                                
                                # DISPLAY UPLOADED FILES
                                displayUploads($softwareID, 0); #from ADHD_displayData.php
                                echo '<hr>';
                                include 'includes/ADHD_newEntryFormStyle.php'; #<!-- CSS overrides only -->

                                $insertionStatus    = 0; # Used to log any errors occurred in the insertion operations to the database and halt execution of the insertion operations in the later conditional statements that used this variable
                                $fileUploadStatus   = 0; # Used to log any errors occurred in the files upload operation to the database and to the server. It halts any execution given there is an error.
                                $captchaStatus      = 0; # Used to log any whether a wrong value is entered for captcha. It halts any execution if captcha value was wrong.
                                GLOBAL $HTTP_POST_VARS, $printAgain, $error, $title, $softwareID;
                                ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### ##### 
                                if (isset($_POST["Submit"])) {     #validate form data / #check form
                                    
                                    echo "===> " . $title.' ('.$softwareID.')<br>';# title already exists
                                    #CHECK SPAM EMAIL then check form data
                                    $error['email'] = false;#spam email has some content that shouldnt be there
                                    if (!$_POST["email"] == "") {
                                        $error['email'] = true;
                                        #online
                                        /*
                                            echo '<script type="text/javascript" language="javascript">
                                                window.open("http://www.ourdigitalheritage.org","_self");
                                                 </script>';
                                         * 
                                         */

                                        #local
                                        echo '<script type="text/javascript" language="javascript">
                                            window.open("http://localhost:8080/NBPhp/AHSD/ADHD/ADHD_modifyEntry.php","_self");
                                            </script>';
                                    } else {
                                        #spam mail check passed-> continue with form
                                        checkForm(1);
                                    }
                                } else { #form not submitted, rollout form fields
                                        echo '<FORM enctype="multipart/form-data" ';
                                        echo 'method="POST" ';
                                        echo 'class="search"';
                                        echo 'action="ADHD_modifyEntry.php?id=';
                                        echo $softwareID;
                                        echo '">';
                                        #FORM FIELDS
                                        field_title($title);
                                        field_year($year);
                                        #field_arrayUpTo5Authors(); #broken function
                                        #@@@ manual implementation:
                                         #<!-- UP TO 5 AUTHORS -->
                                    ?>
                        
            <div class="tooltipContainer" onmouseover="show(tooltip00)" onmouseout="hide(tooltip00)">
                <!-- tooltip(00) is defined below -->
                <label for="authGivenFamily" id="modifyEntryLabels"> Number of Authors: <font style="font-size: 11px; color:#DA6200;">(See Note)</font></label>
                <div class ="bigTooltip" id="tooltip00">
                    Select how many author(s) this software has, then enter their name(s).
                </div>
            </div>
            <!-- SELECT AUTHOR NUM ROWS-->
                <SELECT class="sel1" id="authInputCount"
                        name="authInputCount"
                        onChange="ShowMenu(document.getElementById('authInputCount').value, 'divInput', 5);">
                    <OPTION value="0">0 </OPTION>
                    <OPTION value="1">1 </OPTION>
                    <OPTION value="2">2 </OPTION>
                    <OPTION value="3">3 </OPTION>
                    <OPTION value="4">4 </OPTION>
                    <OPTION value="5">5 </OPTION>
                </SELECT><br/>
                <!-- <div style="width:70%; margin: 0 auto;" id="formFields" > -->
                            
                        
                                    <?php
                                    
                                        createAuthorFormFields(5);
                                        field_publisher($publisherName);
                                        field_country($country);
                                        field_hardwareReqs();
                                        field_softwareReqs();
                                        field_desc();
                                        field_notes();
                                        field_licence();
                                        #@@@fields_contributor();
                                        fields_contributor_test();
                                        field_arrayUpTo10Files();
                                        
                                        $testEmail = 'daniel.phillis@gmail.com'; 
                                        field_email($testEmail);
                                        
                                        field_captcaEmail();#Capture Content
                                        generateVerificationCodeImage();
                                        field_verifCodeInput();
                                        #loopUploadFields_test($_debug); #@@@ why are these functions greyed out ?
                                        #loopUploadFields_test($_debug);#loopUploadFields();
                                        formButtons();
                                        echo "</form>";
                                        echo "</div>";#$accordionGenerateOnce = 1; #Increment to prevent more accordion DIVs generation
                                    
                                }
                                #Close accordion DIVs only once (from legacy code)
                                $accordionGenerateOnce = 1;
                                if($accordionGenerateOnce == 1){
                                    echo "</div>";
                                    echo "</div>";
                                }
                                #END MAIN PHP#
                            } #end test live connection conditio
                            
                        ?>
                        </p> 
                        </div><!-- list content -->
                    </div><!-- detailed -->
                </div> <!-- innerbody left -->
            </div><!-- inner main left -->
        </div><!-- inner main -->
    </div><!-- outer main -->
    
    
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
    
</div><!-- outer main -->

    <!-- Support for place holders for legacy browsers (DO NOT MOVE) -->
    <script src="../script/placeholders.min.js"></script>
    </body>
    </html>
    