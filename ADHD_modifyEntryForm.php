<!-- /**

	note: The Database convention for first and last names is now used:
	ie given name for first name and family name for last name
	daniel.phillis@gmail.com

	notes:
	warning defining a function more than once will render the php invalid
	*/
-->
<!-- <script type="text/javascript" src="../../js/tooltip.js" ></script> -->


<?php
# get required functions for form validation and queries etc

include 'ADHD_newEntryFormStyle.php'; #<!-- CSS overrides only -->

#include 'ADHD_functionsCreate.php';
#include 'ADHD_functionsDisplayData.php';
include 'ADHD_functionsInsert.php';
#include 'ADHD_functionsQueries.php'; #now includes unit testing
include 'ADHD_functionsValidation.php'; # was version 3
#include 'includes/_writeToFile.php'; #NB UNDERSCORE PREFIX

global $TOGGLE_TEST_DATA, $DEBUG, $VALIDATE;
global $DEBUG_FILE;

$TOGGLE_TEST_DATA       = 1;
$TEST_DATA              = 1; 
#0 for no data - blank forms #1 for non existing titles #2 for an existing title - '3D Golf'
$DEBUG                  = 1;
$VALIDATE               = 1;
#$DEBUG_STRING           = '';
$displayEntryVersion    = 2;

#also defined in writeToFileTXT.php
$debug_file = '/Applications/MAMP/htdocs/repos_svn/AHSD/ADHD/_unit_test_results/debug_output.txt';

/* @@@ todo local connection 'require_once' changed to 'require' */
#require('../conn/ADHD_DB_CONNECTION_PDO.php');
#$conn = connectDB();

                         # Flags to log errors in DB insertions and halt execution
$insertionStatus    = 0; # Used to log any errors occurred in the insertion operations to the database and halt execution of the insertion operations in the later conditional statements that used this variable
$fileUploadStatus   = 0; # Used to log any errors occurred in the files upload operation to the database and to the server. It halts any execution given there is an error.
$captchaStatus      = 0; # Used to log any whether a wrong value is entered for captcha. It halts any execution if captcha value was wrong.
$softwareNumRows    = 0; # Used to check if a software with the same title is already existed in the database.

# if 0 - it does not exist, if > 0 it does (numRows is how many rows are returned by a
# SELECT title FROM software WHERE title = ? type query)

GLOBAL $HTTP_POST_VARS, $printAgain, $error, $title;

#write
#$DEBUG_STRING .= line();
#writeToFileTXT($DEBUG_STRING);

?>

<div style="width:70%; margin: 0 auto;" id="formFields" >

    <?php
        if (isset($_POST["Submit"])) {
            #clear the debug file
            #debug_clr(); #overwrite all existing txt.

            global $softwareNumRows, $softwareID;
            ## title already exists
            echo "=====>" . $softwareID;
            if ($softwareID > 0){ # was $softwareNumRows
                echo '<span style="font-size: 11px; color: red;">';
                echo 'A software with the same title is already exist. 
                    Would you like to add more details about this software?</span>';
            }
        }
    ?>

    <!-- <FORM action="ADHD_displayEntry2.php" enctype="multipart/form-data" method="POST" class="search"> 
    <FORM action="ADHD_modifyEntry_v03.php" enctype="multipart/form-data" method="POST" class="search">-->
        <FORM action="ADHD_modifyEntry.php" enctype="multipart/form-data" method="POST" class="search">

        <!-- TITLE -->
        <!-- 
        <label for="title" id="modifyEntryLabels">* Title: -->
            <?php
            #if form is submitted
            /*
            if(isset($_POST["Submit"])){
                if($_POST["title"]=='') {//check title has not been left blank and warn the user if so
                    print("<span style=\"font-size: 11px; color: red;\">Please enter a title.</span>");
                }
                else if(preg_match("/^\\s/",$_POST["title"])){ //check the title data entered doesnt start with a space and warn user
                    print("<span style=\"font-size: 11px; color: red;\">Cannot start with space.</span>");
                }
            }
             
            ?>
        </label>
        <!--TESTING WITH VALUES PRE_INSERT -->
        <INPUT type="text" class="input" name="title" id="title" value="<?php
            #if ($TOGGLE_TEST_DATA) echo 'null';
            #SWITCH
            switch($TEST_DATA){
                case 0:
                    echo '';
                    break;
                case 1:
                    echo 'null';
                    break;
                case 2:
                    echo '3D Golf';
                    break;
            }
        ?>" required>
             *
             */
            ?>
        <br>

        <!-- YEAR -->
        <!-- VALIDATION: for 4 chars and pattern is number, and re-validate on update -->

        <label for="Year" id="modifyEntryLabels"> Year: </label>
        <INPUT 	type="text" class="input" name="Year" id="Year"
                  size="4" value="<?php
                                    if($TOGGLE_TEST_DATA){
                                        echo '2018';
                                        #echo 'YYYY';
                                    } ?>"
                  maxlength="4" pattern="\d*"
                  oninvalid="setCustomValidity('Please enter a number.')"
                  onchange="try{setCustomValidity('')}catch(e){}"/><br/>

        <!-- UP TO 5 AUTHORS -->
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
        <?php
        createAuthorFormFieldsForTesting(5);
        #createAuthorFields(5);
        ?>

        <!-- PUBLISHER -->
        <hr>
        <label for="publisher" id="modifyEntryLabels"> Publisher: </label>

        <?php #echo '<b>test data injection ?</b><br>'; ?>

        <INPUT type="text" class="input" name="publisher" id="publisher" size="30" value="<?php
        #if ($TOGGLE_TEST_DATA) echo 'Melbourne House';

        #SWITCH
        switch($TEST_DATA) {
            case 0:
                echo '';
                break;
            case 1:
                echo 'Melbourne House';
                break;
            case 2:
                /** made random */
                # $r = rand(0,9999);
                # if ($_debug) echo 'rand number = '.$r;
                echo 'NewPublisher';
                # echo $r;
                break;
        }
        ?>">
        <br>

        <!-- SELECT COUNTRY -->
        <label for="country" id="modifyEntryLabels"> Country: </label> <!-- @@@ wrong for parm entered (was publisher) -->
        <SELECT class="sel1" name="country">
            <OPTION>Choose a country... </OPTION>
            <OPTION value="Australia">Australia</OPTION>
            <OPTION value="New Zealand">New Zealand</OPTION>
            <OPTION value="Others">Others</OPTION>
        </SELECT><br/>

        <!-- HARDWARE REQs -->
        <label for="hardwareReq" id="modifyEntryLabels"> Hardware Requirements: </label>
        <TEXTAREA class="textarea" name="hardwareReq" id="hardwareReq" rows="1"></TEXTAREA><br/>

        <!-- SOFTWARE REQs -->
        <label for="softwareReq" id="modifyEntryLabels"> Software Requirements: </label>
        <TEXTAREA class="textarea" name="softwareReq" id="softwareReq" rows="1"></TEXTAREA><br/>

        <!-- DESCRIPTION -->
        <label for="description" id="modifyEntryLabels"> Description: </label>
        <TEXTAREA class="textarea" name="description" id="description" rows="1"></TEXTAREA><br/>

        <!-- TOOLTIPS -->
        <div class="tooltipContainer" onmouseover="show(tooltip1)" onmouseout="hide(tooltip1)">

            <!-- NOTES -->

            <label id="modifyEntryLabels" for="notes"> Notes: <font style="font-size: 11px; color:#DA6200;">(See Note)</font></label>
            <div class = "bigTooltip" id= "tooltip1">
                Include information here that doesn't fit elsewhere.
                For example: working copy status, collection title is housed in, the chip for obscure systems, version numbers,
                if you are the author, copyright owner (if known), programming language, emulation availability, credits for photos,
                information on manuals, etc.
            </div>
        </div>
        <TEXTAREA class="textarea" name="notes" rows="7"></TEXTAREA><br/>

        <!-- BIG TOOLTIP FOR NUMBER OF FILES -->

        <div class="tooltipContainer" onmouseover="show(tooltip0)" onmouseout="hide(tooltip0)">

        <!-- NUMBER OF FILES -->

            <label for="filesnum" id="modifyEntryLabels"> Number of Files: <font style="font-size: 11px; color:#DA6200;">(See Note)</font></label>
            <div class = "bigTooltip" id= "tooltip0">
                We only accept images (ending ".jpg",".gif",".png"), plain text (.txt) and pdf files. The files should be less than 2MB.
            </div>
        </div>
        <SELECT class="sel1" id="num" name="filesnum" onChange="ShowMenu(document.getElementById('num').value, 'divFile', 9);">
            <?php
            #Echo 10 options in a drop down menu
            for ($n=0;$n<10;$n++){
                echo '<OPTION value="'.$n.'">'.$n.' </OPTION>';
            }
            ?>
        </SELECT><br/>

        <!-- display 10 upload DIVS -->
        <?php
        createUploadFormFieldsWithLoop();
        #loopUploadFields_test(1); # called from includes/ADHD_functionsCreate.php
        #debug switched to text files
        ?>
        <hr>

        <!-- CHOOSE A LICENCE -->
        <label for="licenceList" id="modifyEntryLabels"> Licence for uploaded content: </label>
        <SELECT class="sel1" name="licenceList">
            <OPTION>Choose a licence... </OPTION>
            <OPTION>GNU General Public License </OPTION>
            <OPTION>Attribution </OPTION>
            <OPTION>Attribution-noncommercial </OPTION>
            <OPTION>Attribution-Share Alike </OPTION>
            <OPTION>Attribution-noncommercial-sharealike </OPTION>
            <OPTION>Public Domain </OPTION>
            <OPTION>Sampling Plus </OPTION>
            <OPTION>Noncommercial Sampling Plus </OPTION>
            <OPTION>Copyright </OPTION>
        </SELECT><br/>
        <div class="tooltipContainer" onmouseover="show(tooltip2)" onmouseout="hide(tooltip2)">
            <label for="contributorFamily" id="modifyEntryLabels"> * Your Family Name:
                <font style="font-size: 11px; color:#DA6200;">(See Note)</font>

                <!-- CONTRIBUTOR Family NAME -->

                <?php
                /* CHECK contributor FAMILY NAME IS FILLED OUT or not (MANDATORY FIELD) */
                if (isset($_POST["Submit"])){ //can this be replaced with if($_POST['Submit'])
                    IF ($_POST["contributorFamily"] == ''){
                        global $insertionStatus;
                        $insertionStatus = 1; //Flag Error
                        print("<span style=\"font-size: 11px; color: red;\">Please enter your family name.</span>");
                    }
                }
                ?>

            </label>
            <div class = "smallTooltip" id= "tooltip2">
                Your name will be kept confidential.
            </div>
        </div>

        <!-- CONTRIBUTOR FAMILY (LAST) NAME FIELD FOR TESTING -->
        <input required type="text" class="input" name="contributorFamily" size="30" value="<?php
        if ($TOGGLE_TEST_DATA) echo 'Phillis'; ?>"
        ><!-- close off input tag -->
        <br>
        <div class="tooltipContainer" onmouseover="show(tooltip3)" onmouseout="hide(tooltip3)">

            <!-- CONTRIBUTOR GIVEN (FIRST) NAME -->

            <label for="contributorGiven" id="modifyEntryLabels">Your Given Name:
                <font style="font-size: 11px; color:#DA6200;">(See Note)</font></label>
            <div class = "smallTooltip" id= "tooltip3">
                Your name will be kept confidential.
            </div>
        </div>

        <!-- CONTRIBUTOR FIRST NAME INPUT-->
        <input  type="text" class="input" name="contributorGiven" size="30" value="<?php
        if ($TOGGLE_TEST_DATA) echo 'daniel'; ?>
				">

        <br>
        <div class="tooltipContainer" onmouseover="show(tooltip4)" onmouseout="hide(tooltip4)">

            <!-- EMAIL (alternate) ADDRESS this is made for the users email - the normal email field is reserved for detecting spam bots -->

            <label for="altAddress" id="modifyEntryLabels"> * Your email address: <font style="font-size: 11px; color:#DA6200;">(See Note)</font>
                <?php
                /* CHECK for EMAIL ADDRESS - A MANDATORY FIELD */
                if (isset($_POST["Submit"])) {
                    if ($_POST["altAddress"] == "") {
                        global $insertionStatus;
                        $insertionStatus = 1;
                        //ERROR MESSAGE
                        print("<span style=\"font-size: 11px; color: red;\">Please enter your email address.</span>");
                    } else {
                        if (!checkEmail($_POST["altAddress"])) {
                            global $insertionStatus;
                            $insertionStatus = 1;
                            //ERROR MESSAGE
                            print("<span style=\"font-size: 11px; color: red;\">Invalid email address.</span>");
                        }
                    }
                }
                ?>
            </label>
            <div class = "smallTooltipEmail" id= "tooltip4">
                Your email address will not be disclosed.
            </div>
        </div>
        <!-- users EMAIL FIELD (spambot emnaiul is below with no label)-->
        <input  required type="email" class="input" name="altAddress" size="30" value="<?php

        /** separate test data from structural code */
        if ($TOGGLE_TEST_DATA) echo 'daniel.phillis@gmail.com';
        ?>">
        <br>

        <!-- INVISIBLE EMAIL TO PREVENT SPAM BOTS
        (cant be required/mandatory as we need it to be left blank for form validity)-->
        <input type="text" class="captchaemail" name="email" size="30" value="" style="display: none;"> <!-- hidden -->

        <?php
        /* IF spambotEMAIL IS NOT BLANK - this indicicate suspicious behaviour */
        if (isset($_POST["Submit"])){
            if ($_POST["email"] != ''){//check original code
                $error['email'] = 1;
            } else {
                if (!checkEmail($_POST["email"])) {
                    $error['email'] = 1;
                }
            }
        }
        ?>
        <!-- ENTER VERIFICATION CODE -->
        <label for="verifCode" id="modifyEntryLabels"> * Enter Verification Code: </label>
        <input required type="text" id="verifCode" class="securityInput" name="verifCode" style="margin-bottom: 3px;" maxlength="5" >

        <?php
        echo '<br>';

        if (isset($_POST["Submit"])) {
            $verifCode = $_POST["verifcode"];

            if(md5($verifCode).'8cq3' == $_COOKIE['imgcap']){
                global $captchaStatus;
                unset($_COOKIE['imgcap']);
                $captchaStatus = 0;
            }
            else {
                /*CODE doesnt match the image,
                then later test for the state of the $captureSatatus var
                or use it as a multiplier
                */
                global $captchaStatus;
                $captchaStatus = 1;
                $captchaStatus = 0; #@@@ override
            }
        }

        global $captchaStatus;
        if($captchaStatus == 1){
            echo '<label id="modifyEntryLabels"> </label>';
            echo '<span style="
                margin-bottom:10px;
                color:red;
                padding:3px;
                width: 209px;
                height: 29px;">';
            echo 'Wrong Verification Code!';
            echo '</span>';
        }
        ?>
        <label id="modifyEntryLabels"> </label>
        <!-- //captcha -->

        <img src="ADHD_captchaContent.php?
        <?php echo rand(0,9999); #must be on the same line ?>"

             alt="verification image, type it in the field above."
             width="215px" height="29"
             align="absbottom"
             style="
				margin-top: 5px;
				border-color:#64a3ba;
				border:1px dashed #64a3ba;
				border-radius: 10px;">

        <br><br><br>

        <!-- -- -- -- -->

        <label id="modifyEntryLabels"> </label>
        <!-- <div style="display: inline-block;">-->
        <div style="display: inline-block;">
            <table border=0 width = 95%>
                <td width=25% align = "left">
                    <INPUT type="submit" id="sButton" name="Submit"
                           value="SUBMIT">
                </td>
                <td></td>
                <td width=25% align = "middle">
                    <INPUT type="reset" id="rButton" value="RESET"></td>
            </table>
        </div>

    </FORM>
</div>

<?php
#echo "<br><b> * functionsValidation3 </b><br>";

FUNCTION _t_querySoftwareTitleFromSW($_id){
    
    return "Laser Hawk";
}

# IF FORM HAS BEEN SUBMITTED...
if (isset($_POST["Submit"])) {
    $_debug = 0;
    
    #echo "<br><b> * form submitted </b><br>";
    #writeToFileTxt("\nFORM submitted\n");

    $error['email'] = false; #check for email field is not empty (bot)
    /* $_POST['email'] is a common form field to be exploited by malware or hackers
        this form field is . It should be left blank - if it is not blank - this indicates
        some suspicious behaviour */

    # IF SPAM email has content, flag an error and reload page fresh - it should remain blank
    if ($_POST['email'] != "") {
        $error['email'] = true;
        /*
        echo '<script type="text/javascript" language="javascript">
            window.open("http://www.ourdigitalheritage.org","_self");
             </script>'; */
        
        #LOCAL VERSION todo: shift to live version

        #$DEBUG_STRING .= "\nERROR: invisible email field populated:".$_POST['email']."\n";
        
        echo '<script type="text/javascript" language="javascript">
			window.open("http://127.0.0.1/repos_svn/AHSD/ADHD/ADHD_newEntry.php","_self");
			</script>';
        
    } else {
        ########################################################
        # SPAM EMAIL FIELD IS CLEAN -> CONTINUE FORM VALIDATION#
        ########################################################

        #include ('ADHD_validateNewEntryForm_v01.php');#checkForm();

        #if ($DEBUG) echo '<p><b>VALIDATING FORM DATA...</b><br><br>';
        if ($DEBUG) _msgBox ('y', '<p><b>VALIDATING FORM DATA...</b>');
        #$DEBUG_STRING .= "\nVALIDATING FORM DATA...\n\n";
        #writeToFileTXT($DEBUG_STRING);

        #1
        #UNIT TEST - watch out for calling functions recursively
        #missing parms will cause a silent php fail ?
        #formCheckMandatoryFields_test(1);

        if(formCheckMandatoryFields($DEBUG)){
            echo '<center><b><font style="color: red;">
                Error: You have not completed all the required information!
                </font></b></center><br>';
        } else {
            #@@@
            _msgBox('g', '@@ checkMandatoryFormField UNIT TEST done<br>');
        }

        #2 Assign php variables from form data -- see includes/ADHD_functionsValidation.php
        formStoreData($DEBUG); #Includes some validation here as well
        $title = querySoftwareTitleFromSW(0);
        echo "$title: ".$title."<br>";
        
        #3
        $DEBUG = 0;
        #FUNCTION CALL

        #UNIT TEST FUNCTION CALL - this function call 
        #doesnt overwrite $title , it uses varable $test_title in place.
        querySoftwareIDFromTitle_test();

        $softwareID = querySoftwareIDsFromTitle($title, $DEBUG);
        $DEBUG = 1;
        $softwareIDTemp = $softwareID;

        #REDIRECT TO MODIFY ENTRY IF TITLE ALREADY EXISTS
        if ($softwareID > 0){
            #DISPLAY THE TITLE INFORMATION AND PROVIDE A LINK to modify the entry / record

            # Hide the form
            echo '<script>show("formFields")</script>';
            echo '<p>Software title ';
            echo '<a href = "ADHD_displayEntry'.$displayEntryVersion.'.php?id='.$softwareID.'">'.$title.'</a> already exists...<br>';
            echo '<br>';
            echo '<a href = "ADHD_displayEntry'.$displayEntryVersion.'.php?id='.$softwareID.'">';
            echo 'View details for <i>';
            echo $title;
            echo '</i><br><br>';
            echo '</a> or <a href = "ADHD_newEntry.php">make a different contribution ?</a>';
            if ($_debug && 0 )echo "<br>php file exiting....\n";
            exit;
        }

        #4 Query Authors
        #should have names in mem already ##################################################
        /* PROCESS
            define arrays of names (given and family) from form fields
            DEBUG: print all names from arrays (test)
            define array of author-ids
            define array of TEMP author-ids (id the author alreadys exists - the queried ID is saved)
            define array of author-count (a title may have more than one author) */

        if ($DEBUG){
            #intead of writing to the HTML page - write to $DEBUG_STRING

            #echo '<p style="font-color: green;">';
            #echo 'DEBUG: CRUD - retrieve Author IDs from authors in FORM fields:';
            $DEBUG_STRING .= "\nDEBUG: CRUD - retrieve Author IDs from authors in FORM fields:\n";
        }

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

        # LOOP using the function 'querySingleAuthorIDFromName' ##############################
        for ($n=0;$n < $authorNo = 5;$n++){
            #check if name is valid first, otherwise no point in doing the query
            #echo '<i>loop iteration: </i>'.$n.'<br>';
            $gn = $authorGVars[$n];# setup temp vars for readability
            $fn = $authorFVars[$n];

            # QUERY
            if($gn && $fn){
                #FUNCTION CALL
                $arrayAuthorIDs[$n] = queryAuthorIDFromAuthorByName($gn,$fn,0);
                if ($arrayAuthorIDs[$n] == 0){
                    #echo 'zero was returned - must be a new author<br>';
                    #$DEBUG_STRING .= "\nzero was returned - must be a new author\n";

                    #insert to Author table (author(authorID) is set to auto-increment)
                    #FUNCTION CALL
                    insertAuthorToAuthorTableByName($gn,$fn,1);
                    $newAuthorID = $getMaxAuthorIDForNewAuthorInsertion(1); #1 is verbose output

                    #echo 'max(newly inserted authorID):'.$newAuthorID.'<br>';
                    #$DEBUG_STRING .= "max(newly inserted authorID):".$newAuthorID."\n";

                    $arrayAuthorIDs[$n] = $newAuthorID;
                    if($DEBUG==2){
                        foreach($arrayAuthorIDs as $row){
                            $DEBUG_STRING .= "\n".$ROW;
                        }
                        $DEBUG_STRING .= "\n";
                    }
                }
            }
        }

        # VALIDATION OF ALL 5 Author ID's
        if ($DEBUG) {
            #$DEBUG_STRING .= line();
            $DEBUG_STRING .= "$authorId\'s in array: ";

            foreach ($arrayAuthorIDs as $row) {
                #echo '[' . $row . '] ';
                $DEBUG_STRING .= "\n";
                $DEBUG_STRING .= "[".$row."]\n";
            }
            #$DEBUG_STRING .= line();
        }

        #5Contributor
        #FUNCTION CALL
        $contributorID = queryContributorIDByName($altAddress,$DEBUG); # 1 for verbose output
        $contributorIDTemp = $contributorID;

        #6 Publisher
        $publisherID = queryPublisherID($publisher, 0); # 1 for verbose output
        $publisherIDTemp = $publisherID;

        #7 get softwareID of last entry
        #FUNCTION CALL
        $swidLast = queryMaxSoftwareIDForSeqNum1($DEBUG); # 1 for verbose output
        $softwareID = $swidLast + 1;

        #8 validate getCoutry method
        if (getCountry_test() == 0){
            echo '<br>getCountry unit test failed!<br>';
            exit;
        }

        #9 query 10 uploads for files contributed by user through the form fields
        global $captureStatus;

        $upDebug = $DEBUG;
        echo 'include ADHD_uplaod_looped.php<br>';
        include 'ADHD_uploadLooped.php'; #PDO implemented

        #VERBOSE DEBUG INFO: UPLOAD
        if($upDebug){
            #$DEBUG_STRING .= "\nFILE SUMMARY ARRAY: \n";
            $fileCount = 0;

            foreach($_FILES as $row){
                $fileCount++;
                #if(!isempty($row['name'])){
                if(1){
                    echo $fileCount.': ';echo $row['name'];echo '<br>';
                    $DEBUG_STRING .= $fileCount.":".$row['name']."\n";
                }else{
                    echo 'emptyFile<br>';
                    $DEBUG_STRING .= "\nempty file";
                }
            }
            #echo '<br>';
            $DEBUG_STRING .= "\n";
        }#end if debug
    }#end else
}#end if form submitted
?>

<!--# INSERT DATA OPERATIONS
    # recall $insertionStatus flags any errors with form data ie missing contributor FamilyName field
    # or missing contributor email address -->

<?php

global $insertionStatus, $fileUploadStatus, $captchaStatus, $softwareNumRows, $softwareID;
global $authorGVars, $authorFVars, $arrayAuthorIDs, $authorNo;

if (isset($_POST["Submit"])) {
    if($insertionStatus != 0) {
        # HANDLE ERROR
        echo "<center><span style=\"display: inline-block; font-size: 13px; color: white; background-color: red; border-radius:5px; padding: 5px; margin: 5px 0px 5px 0px;\">
			  Error with submission! Please try again with your entry details!</span></center>";
    }

    # if no errors existed with the entry e.g software year,
    # contributor name and email plus the file uploads
    # were entered and valid

    if ($insertionStatus == 0 && $fileUploadStatus 	== 0 &&
        $softwareNumRows == 0 && ($captchaStatus 	== 0 )) { #|| $captchaStatus == 1 #use boolean or to override captureStatus test
        #NB there is no point continuing on with CREATE statements if error flags do not pass

        #LOOP FOR INSERTION (FOR PRE-EXISTING AUTHOR) needs to be in a loop
        if ($DEBUG){
            echo '<h3><hr>Insert 0-5 Authors<h3></font></h3></b>';
            $DEBUG_STRING .= "\nInsert 5 Authors\n";
            #$DEBUG_STRING .= line();
        }
        for($n=0;$n < $authorNo; $n++){
            #loop over array of authors
            #insert all relevant authors (for a specific software title) to author-software table
            $gn = $authorGVars[$n];
            $fn = $authorFVars[$n];

            if($arrayAuthorIDs[$n] != 0){ #ie if existing author -> insert to author table, then author-software table
                #new title with existing authors
                # params = authID, givenName, familyName, softwareID, debug_verbose_output (0 or 1)
                #insertAuthorsToAuthorSoftwareByID( $arrayAuthorIDs[$n], $gn, $fn, $swidForInsertion, 1);
                #FUNCTION CALL
                insertAuthorsToAuthorSoftwareByIDArray( $arrayAuthorIDs[$n], 1); #new signature does away with swid
            }
        } #end loop

        /** instead of re-directing to a new page - this code serves to provide feed back on the same page for testing
         * allowing referral to the debug information messages
         */

        if($DEBUG){
            echo "<h3 id=\"headerTitleH3\" style=\"text-transform: none;\">[debug txt] Success! Your information has been added. Thank you!
				<a href=\"./ADHD_newEntry.php\">
				<br>Click here if you want to contribute another item.
				</h3></a><br>";
        } else {
            # REDIRECT
            echo "<script>
                window.location = \"ADHD_contributionSuccess.php\";
            </script>";
            echo '<META HTTP-EQUIV="Refresh" Content="0; URL=ADHD_contributionSuccess.php">';
        }
    }

    # Confirmation of end of file / validation / function calls
    /**
    $DEBUG_STRING .= line();
    $DEBUG_STRING .= "\n## All functions tested...software should be inserted...check php admin ##\n";
    $DEBUG_STRING .= line();
    writeToFileTXT($DEBUG_STRING);
    */
}
?>