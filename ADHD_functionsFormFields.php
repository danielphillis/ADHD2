
<?php
/**
 * form fields for mmodifyEntry.php and newEntry.php (was contribute.php)
 *
 * daniel phillis, Flinders University 2017, 2018
 *
 * there are a number of repetitions in order to display
 * form fields for both 'new Entry / Contribute software'
 * and modifyEntry (modify existing entry) functionality
 *
 * to avoid repeated code, form fields have been shifted
 * into dedicated functions residing a dedicated php fle
 */

/**
 * no title field required as the user is modifying a software title that
 * already exists
 * recall that no data is ever clobbered or overwritten in the DB
 * a new sequence number is made for the same title and new information is associated with that
*/

    /* TOOLTIPS */
    #consider breaking tooltips out to a separate php file for notes and dialogues

    $toolTipNotes = 'Include information here that doesn\'t fit elsewhere.
                    For eg. working copy status, collection title is housed in, the chip for obscure systems, version numbers,
                    if you are the author, copyright owner (if known), programming language, emulation availability,
                    credits for photos, information on manuals, etc.';

    $toolTipNumFiles = 'We only accept images (ending ".jpg",".gif",".png"), plain text (.txt) and pdf files. 
        The files should be less than 2MB.';

    #$toolTipContributorName = 'Your name will be kept confidential.';
    
    /**
     * field Title + warnings for invalid form data
     * @@@( breaking camelCase convention)
     */
    FUNCTION field_title($_title){
        
        echo '<label for="title" id="modifyEntryLabels">* Title:';

        #if form is submitted
        if(isset($_POST["Submit"])){

            if($_POST["title"]=="") {
                #WARNING
                print("<span style=\"font-size: 11px; color: red;\">Please enter a title.</span>");
            }
            else if(preg_match("/^\\s/",$_POST["title"])){
                #WARNING
                print("<span style=\"font-size: 11px; color: red;\">Cannot start with space.</span>");
            }
        }
        echo '</label>';
        echo '<INPUT type="text" class="input" name="title" id="title" value="'.$_title.'" required><br>';
    }

    /**
     * field year
     * #void
     */
    FUNCTION field_year($_year){

        echo '  <label 
                    for =   "Year" 
                    id  =   "modifyEntryLabels"> 
                    Year: 
                </label>';
        #input
        echo '<INPUT 
                    type        =   "text" 
                    class       =   "input" 
                    name        =   "Year" 
                    id          =   "Year" 
                    size        =   "4" 
                    value       =   "'.$_year.'" 
                    maxlength   =   "4" 
                    pattern     =   "\d*"      
                    oninvalid   =   "setCustomValidity(\'Please enter a number.\')"
                    onchange    =   "try{setCustomValidity(\'\')}catch(e){}"><br>';
    }
    
    /**
     * 5 author fields
     * #void
     */
    FUNCTION field_arrayUpTo5Authors(){
        # max no of authors inlistcreateAuthorFieldsForTesting
        $_n = 5;
        
        $toolTipAuthors = 'Select how many author(s) this software has, then enter their name(s).';

        echo '<div class="tooltipContainer" onmouseover="show(tooltip00)" onmouseout="hide(tooltip00)">';

        #label
        echo '<label for="authGivenFamily" id="modifyEntryLabels">';
        #msg
        echo 'Number of Authors:';
        echo '<font style="font-size: 11px; color:#DA6200;">';
        echo '(See Note)';
        echo '</font></label>';

        #toolTip
        echo '<div class ="bigTooltip" id="tooltip00">';
        echo $toolTipAuthors;
        echo '</div>';
        echo '</div>';
        #dropDown
        echo '<SELECT   class="sel1" 
                        id="authInputCount"
                        name="authInputCount"'; 
        ?> 
                        onChange="ShowMenu(document.getElementById('authInputCount').value, 'divInput', 5);>
        
        <?php
        #5 options
    /*  <OPTION value="0">0 </OPTION>
        <OPTION value="1">1 </OPTION>
        <OPTION value="2">2 </OPTION>
        <OPTION value="3">3 </OPTION>
        <OPTION value="4">4 </OPTION>
        <OPTION value="5">5 </OPTION> */

        for($i=0;$i<5;$i++){
            echo '<OPTION value="'.$i.'">'.$i.' </OPTION>';
        }
        echo '</SELECT><br/>';

        createAuthorFormFieldsForTesting(5); #required php file to be loaded...possibly include function in this file...
        #createAuthorFields(5);
        /**
        Create 10 author fields (5 givenName, 5 familyName)
        with a loop rather than repeating code
        (as previously implemented)

        template:
        <DIV id="divInput $n style="display: none;"><hr>
        <label for="authorFamily %n" id="modifyEntryLabels">Author %n Family Name</label>
        <INPUT type="text" class="input" name="authorFamily %n" id="authorFamily size="30" value=""><br>
        <label for="authorFamily %n" id="modifyEntryLabels">Author %n Given Name</label>
        <INPUT type="text" class="input" name="authorGiven %n" id="authorGiven size="30" value=""><br>

         * todo: specify a return type in each function- see php docs formatting
         */
        $n = 0;
        
        for ($n=0;$n<$_n;$n++){
            echo '<DIV id="divInput'.($n+1);
            echo '" style="display: none;">';

            #family(last) name LABEL
            echo '<label for="authorFamilyName';
            if ($n>0) echo $n;
            echo '" id="modifyEntryLabels"> Author '.($n+1);
            echo ' <i>Family</i> Name</label>';
            #family(last) name INPUT FIELD
            echo '<INPUT type="text" class="input" name="authorFamily';
            if ($n>0) echo $n;
            echo '" id="authorFamily'.$n;
            echo '" size="30" value=""><br>';
            #given(first) name LABEL
            echo '<label for="authorGiven';
            if ($n>0) echo $n;
            echo '" id="modifyEntryLabels">Author '.($n+1);
            echo ' <i>Given</i> Name</label>';
            #given(first) name INPUT FIELD
            echo '<INPUT type="text" class="input" name="authorGiven';
            if ($n>0) echo $n;
            echo '" id="authorGiven'.$n;
            echo '" size="30" value=""><br>';
            echo '</DIV>';
        }
    }

    /**
     * Allows injection of test data
     */
    FUNCTION field_publisher($_pub){
        /* label */
        echo '<label for="publisher" id="modifyEntryLabels"> Publisher: </label>';

        /* input */
        echo '<INPUT type="text" class="input" name="publisher" id="publisher" size="30" value="';
        #data form field injection
        #echo $_testData;
        echo $_pub;
        echo '"><br>';
    }

    /**
     * COUNTRY FIELD DROP DOWN USING JS ONCHANGE
     * 
     * order is changed depending on the current value of $country
     * to save the suer time in filling out the form
     */
    function field_country($_country){
        GLOBAL $country;
        #INJECT
        #$country = 'New Zealand';
        
        /* label */
        #echo '$country: '.$country.'<br>';
        
        echo '<label for="country" id="modifyEntryLabels"> Country: </label>';

        /* drop down */
        
        echo '<SELECT class="sel1" name="country">';
        
        if (    $country ==="Australia"){
            echo '<OPTION value="Australia">Australia</OPTION>';
            echo '<OPTION value="New Zealand">New Zealand</OPTION>';
            echo '<OPTION value="Others">Others</OPTION>';
            echo '</SELECT><br>';
            return;
        }
        
        if (    $country === "New Zealand"){
            echo '<OPTION value="New Zealand">New Zealand</OPTION>';
            echo '<OPTION value="Australia">Australia</OPTION>';
            echo '<OPTION value="Others">Others</OPTION>';
            echo '</SELECT><br>';
            return;
        }
        
        if (    $country === "Others"){
            echo '<OPTION value="Others">Others</OPTION>';
            echo '<OPTION value="New Zealand">New Zealand</OPTION>';
            echo '<OPTION value="Australia">Australia</OPTION>';
            echo '</SELECT><br>';
            return;
        } else {
            
            # if all above cases are false then $country must not be set to a legal value
        
            echo '<OPTION>Choose a country... </OPTION>';
            
            echo '<OPTION value="Australia">Australia</OPTION>
                <OPTION value="New Zealand">New Zealand</OPTION>
                <OPTION value="Others">Others</OPTION>
                </SELECT><br>';
        }
    }
    
    /**
     * HW REQ's FIELD
     * now adds in current value of global (its questionable if we want this)
     */
    function field_hardwareReqs(){
        
        global $hardwareReq;
        
        echo '<label for="hardwareReq" id="modifyEntryLabels"> Hardware Requirements: </label>';
        echo '<TEXTAREA class="textarea" name="hardwareReq" id="hardwareReq" rows="1" ';
        echo 'value = "'.$hardwareReq.'"';
        echo '></TEXTAREA><br>';
    }

    /**
     * smart SW REQ's FIELD
     * now adds in current value of global (its questionable if we want this)
     */
    function field_softwareReqs(){
        GLOBAL $softwareReq;
        echo '<label for="softwareReq" id="modifyEntryLabels"> Software Requirements: </label>';
        echo '<TEXTAREA class="textarea" name="softwareReq" id="softwareReq" rows="';
        
        # inject rows based on existing data
        echo '4';
        
        echo '" ';
        echo 'value = "'.$softwareReq.'"';
        echo '></TEXTAREA><br>';
        
    }

    /**
     * smart DESCRIPTION FIELD
     */
    function field_desc(){
        GLOBAL $description;
        #label
        echo '<label for="description" id="modifyEntryLabels"> Description: </label>';
        #TEXT AREA
        echo '<TEXTAREA class="textarea" name="description" id="description" rows="1"';
        echo ' value="';
        #INJECT VALUE
        echo $description.'">';
        echo '</TEXTAREA><br>';

    }

    /**
     * NOTES FIELD w/tooltip assigned to a variable
     */
    function field_notes(){
        GLOBAL $notes;
        
        $toolTipNotes = 'Include information here that doesn\'t fit elsewhere.
            For eg. working copy status, collection title is housed in, the chip for obscure systems, version numbers,
            if you are the author, copyright owner (if known), programming language, emulation availability,
            credits for photos, information on manuals, etc.';

        echo '<div class="tooltipContainer" onmouseover="show(tooltip1)" onmouseout="hide(tooltip1)">';

        #label
        echo '<label id="modifyEntryLabels" for="notes"> Notes:';
        echo '<font style="font-size: 11px; color:#DA6200;">';

        #msg
        echo '(See Note)';
        echo '</font></label>';

        #tooltip
        echo '<div class = "bigTooltip" id= "tooltip1">';
        echo $toolTipNotes;
        echo '</div>';
        echo '</div>';

        #field
        echo '<TEXTAREA class="textarea" name="notes" rows="';
        echo '7';
        echo '" ';
        #INJECT VALUE
        echo 'value="';
        #test
        echo $notes;
        echo '"';
        echo '></TEXTAREA><br>';
    }

    /**
     * User specifies number of files to upload
     * 
     * test data can be injected in
     * 
     */
    function field_arrayUpTo10Files(){
        
        $testBasePath = '/Users/daniel/Desktop/_test_pic/';
        $testFiles = array(
            'board.jpg',    #1
            'bunny.jpg',    #2
            'drawing.jpg',  #3
            'friends.jpg',  #4
            'pipe.jpg',     #5
            'punk.jpg',     #6
            'skull.jpg',    #7
            'victor.jpg',   #8
            'waldo.jpg',    #9
            'zombie.jpg'    #10
        );
        
        /* Tooltip */
        $toolTipNumFiles = 'We only accept images (ending ".jpg",".gif",".png"), 
        plain text (.txt) and pdf files. The files should be less than 2MB. ';

        echo '<div class="tooltipContainer" onmouseover="show(tooltip0)" onmouseout="hide(tooltip0)">';
        echo '<label for="filesnum" id="modifyEntryLabels">';
        echo 'Number of Files:';
        echo '<font style="font-size: 11px; color:#DA6200;">';
        echo '(See Note)';
        echo '</font></label>';

        echo '<div class = "bigTooltip" id= "tooltip0">';
        /* We only accept images (ending ".jpg",".gif",".png"), plain text (.txt) and pdf files.
        The files should be less than 2MB. */

        echo $toolTipNumFiles;
        echo '</div>';
        echo '</div>';
        echo '<SELECT class="sel1" id="num" name="filesnum" 
                onChange="ShowMenu(document.getElementById("num").value, "divFile", 9);">';

        /* LOOP:Create 10 drop down options */
        for ($i=0;$i<9;$i++){
            echo '<OPTION value="'.$testFiles[$i].'">'.$i.'</OPTION>';
        }
        echo '</SELECT><br>';

        /* LOOP: create 10 fields */
        for ($i=0;$i<10;$i++){
            echo '<DIV id="divFile';
            echo ($i+1).'" style="display: none;">';
            echo '<label for="uploadedFile'.$i;
            echo '" id="modifyEntryLabels">Upload File'.($i+1).'</label>';
            #INPUT
            echo '<input type="file" name="uploadedFile'.$i.'" class="file"';
            #####
            #TEST
            #####
            echo ' value = "'.$testBasePath.$testFiles[$i].'"';
            echo '>';
            echo '</DIV>';
        }
}

    /**
     * LICENCE + IP
     */
    function field_licence(){
        echo '<label for="licenceList" id="modifyEntryLabels"> Licence for uploaded content: </label>';
        echo '<SELECT class="sel1" name="licenceList">';
        echo '<OPTION>Choose a licence... </OPTION>';
        echo '<OPTION>GNU General Public License </OPTION>';
        echo '<OPTION>Attribution </OPTION>';
        echo '<OPTION>Attribution-noncommercial </OPTION>';
        echo '<OPTION>Attribution-Share Alike </OPTION>';
        echo '<OPTION>Attribution-noncommercial-sharealike </OPTION>';
        echo '<OPTION>Public Domain </OPTION>';
        echo '<OPTION>Sampling Plus </OPTION>';
        echo '<OPTION>Noncommercial Sampling Plus </OPTION>';
        echo '<OPTION>Copyright </OPTION>';
        echo '</SELECT><br>';
    }

    /** Contributor Family (last) Name and then Given (first) name
     * NB fields is plural as both family and given name fields are created
     */
    function fields_contributor_test(){
        $testContributorFamilyName = 'Phillis';
        $testContributorGivenName = 'Daniel';
        
        $toolTipContributorName = 'Your name will be kept confidential.';
        # familyName #

        # Tooltip
        echo '<div class="tooltipContainer" onmouseover="show(tooltip2)" onmouseout="hide(tooltip2)">';
            #label
            echo '<label for="contributorFamily" id="modifyEntryLabels"> * Your Family Name:';
            echo '<font style="font-size: 11px; color:#DA6200;">(See Note)</font>';
            #warning
            if (isset($_POST["Submit"])) {
                if ($_POST["contributorFamily"] == "") {
                    global $insertionStatus;
                    $insertionStatus = 1;
                    PRINT("<span style=\"font-size: 11px; color: red;\">Please enter your family name.</span>");
                }
            }
            echo '</label>';
            # Sml tooltip
            echo '<div class = "smallTooltip" id= "tooltip2">';
            echo $toolTipContributorName;
            echo '</div>';
        echo '</div>';

        #field
        echo '<input type="text" class="input" name="contributorFamily" size="30" value="'.
                $testContributorFamilyName.'"><br>';

        ## Given Name ##
        echo '<div class="tooltipContainer" onmouseover="show(tooltip3)" onmouseout="hide(tooltip3)">';
            #label
            echo '<label for="contributorGiven" id="modifyEntryLabels">Your Given Name:';
            echo '<font style="font-size: 11px; color:#DA6200;">(See Note)</font></label>';
            #small Tooltip
            echo '<div class = "smallTooltip" id= "tooltip3">';
            #msg
            echo $toolTipContributorName;
            echo '</div>';
        echo '</div>';

        #field
        echo '<input type="text" class="input" name="contributorGiven" size="30" value="'.
                $testContributorGivenName.'"><br>';
    }
    
    /** 
     * fields contributor
     * @global int $insertionStatus
     */
    function fields_contributor(){
        $toolTipContributorName = 'Your name will be kept confidential.';
        # familyName #

        # Tooltip
        echo '<div class="tooltipContainer" onmouseover="show(tooltip2)" onmouseout="hide(tooltip2)">';
            #label
            echo '<label for="contributorFamily" id="modifyEntryLabels"> * Your Family Name:';
            echo '<font style="font-size: 11px; color:#DA6200;">(See Note)</font>';
            #warning
            if (isset($_POST["Submit"])) {
                if ($_POST["contributorFamily"] == "") {
                    global $insertionStatus;
                    $insertionStatus = 1;
                    PRINT("<span style=\"font-size: 11px; color: red;\">Please enter your family name.</span>");
                }
            }
            echo '</label>';
            # Sml tooltip
            echo '<div class = "smallTooltip" id= "tooltip2">';
            echo $toolTipContributorName;
            echo '</div>';
        echo '</div>';

        #field
        echo '<input type="text" class="input" name="contributorFamily" size="30" value=""><br>';

        ## Given Name ##
        echo '<div class="tooltipContainer" onmouseover="show(tooltip3)" onmouseout="hide(tooltip3)">';
            #label
            echo '<label for="contributorGiven" id="modifyEntryLabels">Your Given Name:';
            echo '<font style="font-size: 11px; color:#DA6200;">(See Note)</font></label>';
            #small Tooltip
            echo '<div class = "smallTooltip" id= "tooltip3">';
            #msg
            echo $toolTipContributorName;
            echo '</div>';
        echo '</div>';

        #field
        echo '<input type="text" class="input" name="contributorGiven" size="30" value=""><br>';
    }

    /**
     * field email
     * NB $_inject can be either a non zero int, of a fully formed email address string
     */
    function field_email($_inject){
        echo '<div>';
        $toolTipEmail = 'Your email address will not be disclosed.';

        echo '<div class="tooltipContainer" onmouseover="show(tooltip4)" onmouseout="hide(tooltip4)">';
            #label
            echo '<label for="altAddress" id="modifyEntryLabels"> * Your email address:';
            echo '<font style="font-size: 11px; color:#DA6200;">(See Note)</font>';
            if (isset($_POST["Submit"])) {
                global $insertionStatus;

                if ($_POST["altAddress"] == "") {
                    $insertionStatus = 1;
                    print("<span style=\"font-size: 11px; color: red;\">Please enter your email address.</span>");
                } else {
                    if (!checkEmail($_POST["altAddress"])) {
                        $insertionStatus = 1;
                        print("<span style=\"font-size: 11px; color: red;\">Invalid email address.</span>");
                    }
                }
            }
            echo '</label>';
            #toolTip
            echo '<div class = "smallTooltipEmail" id= "tooltip4">';
                #msg
                echo $toolTipEmail;
            echo '</div>';
        echo '</div>';
        
        #Input FROCED
        echo '<input type="email" class="input" name="altAddress" size="30" ';
        if($_inject){
            echo 'value="daniel.phillis@gmail.com" >';
        } else {
            echo 'value="">';
        }
        echo '<hr>';
        echo '</div>';
    }
    
    /**
     * 
     * Convenience function to validate a supplied email string
     * should be replaced with the function already used rather than duplicating 
     * functions (1st and 2nd local version)
     */
    
    FUNCTION checkEmail($_email_string){
        
        if (!filter_var($_email_string, FILTER_VALIDATE_EMAIL)) {
            return 0;
        }
        return 1; #email validated
    }
    
    /**
     * captcha email (invisible)
     */
    function field_captcaEmail(){
        #no label needed (lable should be invisible for this form field
        echo '<input type="text" class="captchaemail" name="email" size="0" value=""'
        . ' style="display: none;">';
        
        #validate
        if (isset($_POST["Submit"])) {
            if ($_POST["email"] == "") {
                echo 'email is blank...<br>';
            } else {
                if (!checkEmailLocal($_POST["email"])) {
                    echo 'email is badly formatted...<br>';
                }
            }
        }
    }

    /**
     * captcha (human) verification input
    */
    function field_verifCodeInput(){
        #label
        echo '<p>';
        echo '<label for="verifCode" id="modifyEntryLabels">';
        echo '* Enter Verification Code: </label>';

        #input field
        echo '<input required type="text" 
                    id="verifcode" 
                    class="securityInput" 
                    name="verifcode" 
                    maxlength="5"
                    style="margin-bottom: 3px;" >';

        #WARNING
        if (isset($_POST["Submit"])) {
            $verifCode = $_POST["verifcode"];
            /* Checksum
                see google for md5 function:
                '...The md5() function calculates the MD5 hash of a string....' */

            if(md5($verifCode).'8cq3' == $_COOKIE['imgcap']){
                global $captchaStatus;
                unset($_COOKIE['imgcap']);
                $captchaStatus = 0; //no error
            } else {
                #error - md5 hash doesn't match
                global $captchaStatus;
                $captchaStatus = 1;//error
            }
        }

        global $captchaStatus;
        #warning
        if($captchaStatus == 1){ #in error
            #label
            echo '<label id="modifyEntryLabels"> </label>';
            #warning
            echo '<span style="margin-bottom:10px; color:red; padding:3px; width: 209px; height: 29px;">';
            echo 'Wrong Verification Code!';
            echo '</span>';
        }
        echo '<br>';
    }
    
    /**
     * Verification image
     * 
     * todo: explanation of how it works
     */
    function generateVerificationCodeImage(){
        echo '<label id="modifyEntryLabels"> </label>';#no label
		#img
        #echo '<div style="display: inline-block;">';
        echo '<img src="ADHD_captchaContent.php?'.rand(0,9999);
        echo '" alt="verification image, type it in the field above." width="215px" height="29"';
        echo 'align="absbottom" ';
        #echo 'style="margin-top: 5px; border-color:#64a3ba; border:1px dashed #64a3ba; border-radius: 10px;">';
        echo '<br><br><br>';
    }
    
    /**
     * formProcessData (shifted from newEntryForm to simplify and reduce code in 1 file)
     * 
     * if software already exists (title)
     * provide the user with option to augment existing data
     * 
     * otherwise query the existence of (upto 5) 
     * user-provided authors in the form fields
     * 
     * foreach author - if new (non existant in the DB)
     * insert the author to :
     * 1. the author table
     * 2. the author_Software table -> INCOMPLETE
     * 
     * validate..
     * 
     * 
     * 
     * @global type $title
     * @global type $softwareID
     * @global type $contributorID
     * @global type $publisherID
     * @global type $altAddress
     * @global type $country
     * @global type $authorGivenName
     * @global type $authorGivenName1
     * @global type $authorGivenName2
     * @global type $authorGivenName3
     * @global type $authorGivenName4
     * @global type $authorFamilyName
     * @global type $authorFamilyName1
     * @global type $authorFamilyName2
     * @global type $authorFamilyName3
     * @global type $authorFamilyName4
     * @global type $swidForInsertion
     * @global type $captchaStatus
     * @param type $vars
     * @param type $_debug
     */
    
    FUNCTION formProcessData($vars, $_debug){
        
        if ($_debug==2) print_r($vars);
        
        #introduce function
        if ($_debug){
            _msgBox('b', 'FN:formProcessData reached...(shifted from newEntryForm.php');
            _msgBox('b', 'to functionsFormFields.php)');
        }
        
        GLOBAL $title,$softwareID, $contributorID, $publisherID, $altAddress,$country;
        global $numberOfFiles;
        #echo '$vars["country"]'.$vars['country'].'<br>';

        global  $authorGivenName,
                $authorGivenName1,
                $authorGivenName2,
                $authorGivenName3,
                $authorGivenName4,

                $authorFamilyName,
                $authorFamilyName1,
                $authorFamilyName2,
                $authorFamilyName3,
                $authorFamilyName4;
        #code pasted from here                    
        $title = $vars['title'];#but we think this is a new entry - therefore ID should be 0

        #sid should already be in form data array
        #$softwareID = querySoftwareIDsFromTitle($title, $DEBUG);
        if ($_debug){
            if(is_null($softwareID)){
                echo '$softwareID is null...indicates new title being submitted for entry...<br>' ;
            } else {
                echo $softwareID;
            }
            echo '<br>';
        }

        $DEBUG = 1;#$softwareIDTemp = $softwareID;
            
        #REDIRECT TO MODIFY ENTRY IF TITLE ALREADY EXISTS (NOT YET TESTED)
        if ($softwareID > 0){
            #DISPLAY THE TITLE INFORMATION AND PROVIDE A LINK to modify the entry / record
            echo '$softwareID > 0...<br>';
            
            echo '<script>show("formFields")</script>';# Hide the form fields
            echo '<p>Software title ';
            echo '<a href = "ADHD_displayEntry.php?id='.$softwareID.'">'.$title.'</a> already exists...<br>';
            echo '<br>';
            echo '<a href = "ADHD_displayEntry.php?id='.$softwareID.'">';
            echo 'View details for <i>';
            echo $title;
            echo '</i><br><br>';
            echo '</a> or <a href = "ADHD_newEntry.php">make a different contribution ?</a>';
            echo "\nphp file exiting....\n";
            exit;
        }

        #<!-- SOFTWARE DOES NOT YET EXIST, INSERT IT #-->
        #if software ID is null, not set or zero
        #_msgBox('y', 'null or zero id, new title, moving to insert data for new software...');
        #insert $vars to the DB
        #augmentSoftwareEntryByArray($vars, 1);
            
        # 4. Query 5 Authors   
        # should have names in mem already ?
        /* PROCESS
            define arrays of names (given and family) from form fields
            DEBUG: print all names from arrays (test)
            define array of author-ids
            define array of TEMP author-ids (id the author alreadys exists - the queried ID is saved)
            define array of author-count (a title may have more than one author) 
         */

        if ($_debug==2) _msgBox('g','DEBUG: CRUD - retrieve Author IDs from authors in FORM fields:');

        #define arrays to hold all authors (5 authors, 10 names)
        #could also retrieve them from $vars
        $authorGVars = array(
            $authorGivenName,
            $authorGivenName1,
            $authorGivenName2,
            $authorGivenName3,
            $authorGivenName4
        );
            
        # redundant assignments, autor names are already in globals
        $authorGVars = array(
            $vars['authorGivenName'],
            $vars['authorGivenName1'],$vars['authorGivenName2'],
            $vars['authorGivenName3'],$vars['authorGivenName4']);

        $authorFVars = array(
            $vars['authorFamilyName'],
            $vars['authorFamilyName1'],$vars['authorFamilyName2'],
            $vars['authorFamilyName3'],$vars['authorFamilyName4']);

        $authorNo = 5;

        #initialise array of author IDs
        $arrayAuthorIDs = array(0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0);

        if ($_debug == 2) _msgBox('cyan','Inf:$arrayAuthorIDs now empty...');
        # LOOP using the function 'querySingleAuthorIDFromName' ##############################

        /**
         * for each author in the array,
         * query the author ID from the DB and store in $arrayAuthorIDs
         * 
         * if non-existant author, insert the new author
         * into the author table
         */
        for ($n=0;$n < $authorNo;$n++){
            #check if name is valid first, otherwise no point in doing the query
            #reading form array - but need to read from form ?
            $gn = $authorGVars[$n];# setup temp vars for readability
            $fn = $authorFVars[$n];

            # QUERY authorID from name
            if( isset($gn) && isset($fn)){
                #FUNCTION CALL- >populate arrayAuthorIDs
                #echo '<i>handle names: </i>'.$n.'<br>';

                # get authorID if the author exits
                # returns a 0 if author doesnt exist
                $arrayAuthorIDs[$n] = queryAuthorIDFromAuthorByName($gn, $fn, 0);

                if ($arrayAuthorIDs[$n] == 0){
                    if ($_debug==2){
                        echo 'author query returned 0, must be a <br>';
                        echo 'New author: <b><i>'.$gn.' '.$fn.'</b></i><br>';
                        echo '(insert to 1. <i>author</i> and 2. to <i>authror_software</i> <br>tables)<br>';
                    #insert to Author table (author(authorID) is set to auto-increment)
                    }
                    #FUNCTION CALL validated manually
                    # @@@ relies on auto increment...not ideal
                    # should be easy to fix

                    ##### ##### ##### ##### ##### ##### ##### ##### #####
                    # INSERT TO AUTHOR table @@@ function name needs to be resolved
                    ##### ##### ##### ##### ##### ##### ##### ##### #####
                    insertNewAuthorToAuthorTable2($gn,$fn,0); 

                    #increment MAX ID from author table - this will be the id of the
                    #newly entered author, store the new ID in array $arrayAuthorIDs
                    $newAuthorID = queryMaxAuthorIDFromAuthor(0); #$_debug=1
                    $newAuthorID++;# VITAL !!
                    $arrayAuthorIDs[$n] = $newAuthorID; #to allow updated authors to be displayed in the array
                    #echo 'max(newly inserted authorID):'.$newAuthorID.'<br>';
                    if ($_debug) _msgBox('cyan','I4:$arrayAuthorIDs['.$n.'] => '.$newAuthorID.'...');
                }
                #_msgBox('0','I4:reminder: still need to insert authors to <i>author_software </i>table');
            } else {
                if ($_debug) _msgBox('o','something wrong - author names not set ?functionsFormFields[881]');
            }
        }   #end loop
        if ($_debug == 2){
            echo 'AuthorIDs from array:<br>';
            print_r($arrayAuthorIDs);
            _msgBox('cyan','Inf_3:Authors inserted to Author Table...validated ?');
            
        }
        #_msgBox('0','Inf_4:reminder: fn ProcessData: still need to insert authors to <i>author_software </i>table');

        # VALIDATION OF ALL 5 Author ID's in author table - not required - 
        # author id validation in authors table complete immediately after insertion
        # print last 5 authors
        if ($_debug==2) echo '<hr>';
        //if ($_debug==2) displayArrayAsTable(array($authorGVars));
        //if ($_debug==2) displayArrayAsTable(array($authorFVars));
        if ($_debug==2) echo '<hr>';
        
        #INSERT TO authors (from array of IDs) to AUTHOR_SOFTWARE TABLE
        #requires new softwareID
        #CRUD OP: requires author ID and associated softwareID
        #loop over IDs for CRUD create operation (function does looping)
        #if ($_debug) _msgBox('cyan','addressing TABLE author_software');
        
        $softwareID = queryMaxSoftwareIDFromSoftware($_debug);
        if ($_debug) echo '$softwareID: '.$softwareID.'<br>';
                
        insertAuthorsToAuthorSoftwareByIDArray($arrayAuthorIDs, $softwareID, 0);
        
        if ($_debug) _msgBox('cyan','TABLE 2 ADDRESSED');
        
    #5. Contributor
        $altAddress = $vars['altAddress'];
        if ($_debug) _msgBox('cyan','I:5a.conEmail successfully stored: '.$altAddress);
        
        #echo 'contributorID<br>';
        #print_r($vars['contributorID']);
        #ContributorID was not already stored ?
        $contributorID = $vars['contributorID'];
        $contributorIDTemp = $contributorID;
        
        if ($_debug) _msgBox('cyan','I:5b.contID successfully stored: '.$contributorID);

    #6. Publisher
        $publisherID = $vars['publisherID'];
        if ($_debug) _msgBox('cyan','I:6. pubID successfully retrieved: '.$publisherID);

    #7. get SoftwareID of last entry (already done)
        
        # $swidLast = queryMaxSoftwareIDForSeqNum1($DEBUG); # 1 for verbose output

        /*
        #@@@ OVERRIDE - LOCAL QUERY HERE - why is this not in a fn ?
        $queryGetMaxSID = 'SELECT MAX(softwareID) FROM software'; 
        #Note the different PDO data access method 'fetchColumn' used here
        $softwareID = $conn->query($queryGetMaxSID)->fetchColumn();
        */
        #$softwareID_test = queryMaxSoftwareIDFromSoftware(1);
        #echo 'softwareID_test: '.$softwareID_test.'<br>';
        #echo 'softwareID_: '.$softwareID.'<br>';
        
        #Store and Increment for insertion queries
        global $swidForInsertion;
        
        $swidForInsertion = $softwareID + 1;
        if ($_debug) _msgBox('cyan','made it here, softID: '.$softwareID);
        if ($_debug) _msgBox('cyan','made it here, swidInsertion: '.$swidForInsertion);
        
    #8. validate getCoutry method
        # UNIT TEST FUNCTION CALL
        # country is already in the array
        # is everything already in the array ?
        $country = $vars['country'];
        if(is_null($country) || $country=='') $COUNTRY = 'NULL';
        
        if ($_debug) _msgBox('cyan','made it here, country [981]: '.$country);

    #9. query 10 uploads for files contributed by user through the form fields
        #test data is injected with a function (@@@)
        
        global $captchaStatus, $_FILES, $numberOfFiles;
        
        if ($_debug) _msgBox('cyan','made it here, $captureStatus: '.$captchaStatus.'(0 is good, no errors, 1 = ERROR)');
        $upDebug = 1;
        #VERBOSE DEBUG INFO: UPLOAD
        
        #echo 'files:<br>';
        #_msgBox('y','global files:');
        #print_r($_FILES);
        #echo 'ERRORS<br>';
        #displayArrayAsTable($_FILES);
        
        if($upDebug){
            echo '</font><hr>';
            if ($_debug) _msgBox('g','FILE SUMMARY ARRAY:<br>');
            $fileCount = 0;
            /*
            foreach($_FILES as $row){
                $fileCount++;
                $fln = $row['fileName'];
                if($row){
                    _msgBox('o','$fileCount: '.$fileCount.' : '.$fln);
                }else{
                    _msgBox('o','emptyFile...');
                }
                
            }*/
            #store in global
            $numberOfFiles = count($_FILES);
        }#end if updebug
        if ($_debug) _msgBox('y','form processing finished...');
    }
    
    /**
     * RE-CATCHA human / bot verification
     */
    function recaptcha(){
        echo '<div class="g-recaptcha" data-sitekey="6LfAEEAUAAAAAE4tQhmEfh7ry6jroBwfN0ykwpTI"></div>';
    }
    
    /**
     * When your users submit the form where you integrated reCAPTCHA, 
     * you'll get as part of the payload a string with the name "g-recaptcha-response". 
     * In order to check whether Google has verified that user, 
     * send a POST request with these parameters:
     *
     * response (required)	The value of 'g-recaptcha-response'.
     * remoteip	The end user's ip address.
     * 
     * returns TRUE on success
     */
    function reCaptchaRequest(){
        /*
        $reCaptchaURL = 'https://www.google.com/recaptcha/api/siteverify';
        $reCaptchaSecret = '6LfAEEAUAAAAANbk5tQOF3FPb3vGemlqx4V66GI5';
        $reCaptchaResponse = '';
        $remoteIP = '';
        
        $data = array('key1' => $reCaptchaURL, 'key2' => $reCaptchaSecret);
        
        // use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        
        $context  = stream_context_create($options);
        $result = file_get_contents($reCaptchaURL, false, $context);
        
        #if ($result === FALSE) { /* Handle error }
        #var_dump($result);
        
        #if(is_set($_POST('g-recaptcha-response'))) $result = $_POST['g-recaptcha-response'];
        #return $result;
        */
    
    }
    
    /**
     * generate submit and reset buttons
     * void
     */
    function formButtons(){
        echo '</div>';
        #echo '<p>';
        
        /* Submit */
        echo '<table><tr><td>';
        echo '<INPUT type="submit" id="searchButton" name="Submit" value="SUBMIT"
                style="max-width: 100px"
                >';
        echo '</td><td>';
        /* Reset */
        echo '<INPUT type="reset" id="resetButton" class="button" value="RESET"
                style="max-width: 100px"
                >';
        echo '<td>';
        echo '</table>';
        #echo '<br>';
    }

    /**
     * formGenerateUploadFields()
     * 
     * generate fields to allow for users to provide uploads
     * called by ...
     */
    function formGenerateUploadFields_deprecated(){
        
        /**
        stage: Upload
        Disrupt any insertion to the database if for any reasons files were not uploaded to the server
        (if is incremented, and thus it is larger than 0)

        #@@@ todoShift to PDO statements...
        last Edited 6th Dec 2017 by graduate Daniel Phillis for Flinders University 2017
        daniel.phillis@gmail.com
        **/

        _msgBox('b', 'FN: formGenerateUploadFields() reached...');
        
        global $softwareID;
        $insertID = $softwareID;
        $disruptExecution = 0;
        $VALIDATE = 1;
        $upperLimit = 2097152; /* max file Size in bytes (2MB) */
        #count total files uploaded
        $fieldCount = 10;
        $uploadsCount = 0;
        
        $testBasePath = '/Users/daniel/Desktop/_test_pic/';
        echo '$testBasePath: '.$testBasePath.'<br>';
        $DEBUG = 1;
        echo '$softwareID: '.$softwareID.'<br>';
        echo '$insertSoftwareID: '.$insertID.'<br>';
        /**
         handle FILE n (1 to 10) in a loop
         read files from superglobal $_FILES
        */

        for ($f=0;$f < $fieldCount; $f++){
            #pause(1);
            if ($DEBUG) echo '<p>DEBUG UPLOAD: index: '.$f.'<br>';
            $ff = 'uploadedFile';
            echo $ff;
            if ( $DEBUG==2) {
                echo '<br>';
                echo '<i>NB indexing is diff. for labels and iteration</i><br>';
            }
            if ($f>0) $ff .= ($f-1);
            # code is dependent on this name, messy code is triggered by form field labels not having a zero-index

            if(empty( $_FILES[$ff]) ) {
                #echo 'file ' . $f . ' is empty <br>';
                #echo '<hr>';
            } else { #NOT EMPTY : file has been specified in form

                if ($_FILES[$ff]['error'] == 0) { //if the file is present and no file errors are detected
                    $uploadsCount += 1;
                    #slight pause ? #sleep(1);

                    #Check if the file is JPEG,GIF or png image or text and its size is less than 2Mb
                    $fileName = basename($_FILES[$ff]['name']);
                    $ext = substr($fileName, strrpos($fileName, '.') + 1);
                    #echo "\n"." ".$ext." ".$_FILES["uploadedFile"]["size"]."\n";
                    $ext = strtolower($ext);

                    if ($DEBUG==2) {
                        echo '....baseName: ' . $fileName;
                        echo '<br>';
                        echo '....extname: ' . $ext;
                        echo '<br>';
                        echo '....fileSize: ' . $_FILES[$ff]["size"];
                        echo '<br>';
                    }

                    if ($captchaStatus != -1) {
                        if (($ext == "jpg" ||
                                $ext == "gif" ||
                                $ext == "png" ||
                                $ext == "txt" ||
                                $ext == "pdf") && ($_FILES[$ff]["size"] <= $upperLimit)) { #testfileSize against limit #if the file has a suitable extenstion

                            if ($DEBUG) echo 'DEBUG: fileFormat is acceptable<br>';
                            $dir = dirname(__FILE__) . "/uploads"; # Determine the path to which we want to save this file
                            echo '<b>PATH: ' . $dir . '<br></b>';

                            # check if the sid subdirectory already exists, if not - then create it
                            if (!is_dir($softwareID)) {
                                #if ($DEBUG) echo 'DEBUG: destination directory created...<br>';
                                @mkdir("$dir.'/'.$softwareID", 0775);
                                if ($DEBUG) echo 'new dir made: ' . $dir . '/<b>' . $softwareID . '</b><br>';
                            }
                            $newFilePathName = $dir . "/" . $softwareID . "/" . $fileName;
                            if ($DEBUG && (is_file($newFilePathName))) {
                                echo '<br><br>DEBUG: new path.file made: ' . $newFilePathName . '<br>';
                            }

                            if (!file_exists($newFilePathName)) {# Check if the file with the same name already exists on the server

                                # Attempt to move (not copy ?) the uploaded file to its new place
                                if ((move_uploaded_file($_FILES[$ff]['tmp_name'], $newFilePathName))) {
                                    echo '<b><font color="green">File ' . $_FILES[$ff]["name"];
                                    echo " has been uploaded successfully!</b></font>";
                                    $fileSize = $_FILES[$ff]["size"];
                                    echo '<hr>';
                                    #DISPLAY IMAGE
                                    /*
                                    if ($DEBUG){
                                        echo '<img src="uploads/'.$softwareID.'/'.$fileName.'"';
                                        echo ' alt="'.$softwareID.'/'.$fileName.'">';
                                        echo '<br>';
                                    }
                                    */

                                    #count query
                                    $uploadCountBeforeInsertion = queryUploadCount(1);

                                    #PDO INSERT STATEMENT equivalent
                                    if ($DEBUG) {
                                        echo 'func parm test before calling function(insertUploadedFile(a,b,c,d,e,f)):<br>';
                                        echo 'fileName:' . $fileName . '<br>';
                                        echo 'fileSize:' . $fileSize . '<br>';
                                        echo 'fileType:' . $fileType . '<br>';
                                        echo 'softwareID:' . $softwareID . '<br>';
                                        echo 'seqNum:' . $seqNum . '<br>';
                                    }
                                    #seqNum is always 1 for new software ?
                                    $seqNum = 1;
                                    #CRUD OPERATION # NB insertID now used instead of softwareID
                                    insertUploadedFile($fileName, $fileSize, $fileType, $insertID, $seqNum, $DEBUG);
                                    $file_f = null;

                                    #VALIDATION

                                    /* get count before insertion and after insertion and check for increment */
                                    if ($DEBUG && $VALIDATE) {
                                        echo '<h3>CRUD VALIDATION</h3>';
                                        echo '<hr>';
                                    }

                                    $uploadCountAfterInsertion = queryUploadCount($DEBUG);

                                    if ($VALIDATE) {
                                        if ($uploadCountAfterInsertion == ($uploadCountBeforeInsertion + 1)) {
                                            echo "<span style=\"font-size: 13px; color: dodgerblue;\">";
                                            echo '<b>uploaded file count has incremented by one</b><br>';
                                        } else { #VALIDATION ERROR
                                            echo "<span style=\"font-size: 11px; color: red;\">";
                                            echo 'VALIDATION ERROR:uploaded files count has not incremented !<br>';
                                            echo '</span>';
                                        }

                                        #CRUD: check name of last uploaded file
                                        $lastFileEntry = queryUploadedFileName($uploadCountAfterInsertion, $DEBUG);
                                        echo 'last image uploaded:<b> ' . $lastFileEntry;
                                        echo '<br><font color = "green"></b>';

                                        if ($lastFileEntry == $fileName) {
                                            echo 'filename used in DB insertion operation:<br>' . $fileName . '<br>';
                                            echo 'filename assoc with max fileID: ' . $lastFileEntry . '<br>';
                                            echo '<h3>file successfully inserted</h3>';
                                        }
                                    }
                                    if ($DEBUG) echo '<hr>';
                                    if ($DEBUG) echo '$file_f should now be closed and null: <br>';
                                    if ($DEBUG) echo 'DEBUG:UPLOADS: results from executing bindArray: <br>';
                                    #if ($DEBUG) print_r($res_file_f);
                                    if ($DEBUG) {
                                        foreach ($result as $row) {
                                            echo 'ROW: ' . $row;
                                            echo '<br';
                                        }
                                        echo '<br>';
                                    } else { #UPLOAD FAILED
                                        $disruptExecution++;
                                        echo "<span style=\"font-size: 11px; color: red;\">";
                                        echo "Upload Error: A problem occurred during file upload!" . "</span><br/><br/>";
                                    } #if the filename is unique - then add it to the server
                                } else {
                                    if ($DEBUG) echo 'move failed<br>';
                                }
                            } else { #error - a file with the same name already exists
                                $disruptExecution++;
                                #if ($DEBUG)
                                echo "<span style=\"font-size: 11px; color: red;\">Error: File ";
                                echo $_FILES[$ff]["name"] . " already exists</span><br/><br/>";
                            }
                        } else { #error: the file uploaded exceeds the specified file size constraint
                            $disruptExecution++;
                            #if ($DEBUG)
                            echo "<span style=\"font-size: 11px; color: red;\">";
                            echo 'Upload Error: Only .jpg,.gif,.png images and text(.txt) under 2MB are accepted for upload.</span><br/><br/>';
                        } # end else
                    } # end test captcha status
                }# end if file !empty
            }# end else ! empty
        }# end loop
        echo '</font>';
    }
    
    
    /**
     * void
     * convenience function to generate fields in a loop rather than cutting and pasting code
     */
    function formGenerateUploadFields($fieldCount){
        
        /*
         * template
         * 
         * echo "<DIV id=\"divFile1\" style=\"display: none;\">\n";
	 * echo "<label for=\"uploadedFile0\" id=\"modifyEntryLabels\">Upload File</label>";
	 * echo "<input type=\"file\" name=\"uploadedFile0\" class=\"file\">";
	 * echo "</DIV>";
         */
        
        #NB 0 based indexing , not 1 based
        for($n=0;$n <= $fieldCount; $n++){
            echo '<DIV id="divFile'.$n.'" style="display: none;">';
            echo '<label for="uploadedFile'.$n.'" id="modifyEntryLabels">Upload File'.$n.'</label>';
            echo '<input type="file" name="uploadedFile'.$n.'" class="file">';
            echo '</DIV>';
        }
    }
    
    /**
     * call all sub-functions related to building the form for newEntry(contribute) php page
     */
    function formGenerateNewEntryFields(){
        field_title(); #title not required for modifyEntry form ?
        field_year();
        field_arrayUpTo5Authors();             # plural fields
        field_publisher();
        field_country();                        # country
        #field_country_inject();                # country
        field_hardwareReqs();
        field_softwareReqs();
        field_desc();                       # desc
        field_notes();                      # notes
        field_arrayUpTo10Files();        # number of files (plural fields)
        field_licence();                    # licence and IP
        fields_contributor();               # Contributor
        field_email();                      # Email address
        field_captcaEmail();
        
        generateVerificationCodeImage2();    #verification code image containing numerals and letters
        field_verifCodeInput();
        formButtons();
    }

    /**
     * Call all sub-functions related to building the form for modify Entry php page
     */
    function formGenerateModifyEntryFields(){
        #field_title();         #title not required for modifyEntry form ?
        field_year();
        field_arrayUpTo5Authors(); #plural fields
        field_publisher();
        field_country();
        field_hardwareReqs();
        field_softwareReqs();
        field_desc();           #description
        field_notes();          #notes
        field_arrayUpTo10Files();    #number of files (plural fields)
        field_licence();                #licence and IP
        fields_contributor();           #contributor
        field_email();                  #email address
        field_captcaEmail();            # * invisible * email
        field_verifCodeInput();
        generateVerificationCodeImage();#verification code image containing numerals and letters
        formButtons();
    }
    
    /**
    Create 10 author fields (5 givenName, 5 familyName)
    with a loop rather than repeating code 
    (as previously implemented)

    template:
    <DIV id="divInput $n style="display: none;"><hr>
            <label for="authorFamily %n" id="modifyEntryLabels">Author %n Family Name</label>
            <INPUT type="text" class="input" name="authorFamily %n" id="authorFamily size="30" value=""><br>
            <label for="authorFamily %n" id="modifyEntryLabels">Author %n Given Name</label>
            <INPUT type="text" class="input" name="authorGiven %n" id="authorGiven size="30" value=""><br> 

    * todo: DEBUG explanation
    * todo: return type - see php docs formatting
    */
            #void
            FUNCTION createAuthorFormFields($_n){
                    #$DEBUG_STRING = "\nFORM function createAuthor Fields 5";
                    for ($n=0;$n<$_n;$n++){
                            echo '<DIV id="divInput'.($n+1);
                            echo '" style="display: none;">';

                            //family(last) name LABEL
                            echo '<label for="authorFamilyName';
                            if ($n>0) echo $n;
                            echo '" id="modifyEntryLabels"> Author '.($n+1);
                            echo ' <i>Family</i> Name</label>';
                            //family(last) name INPUT FIELD
                            echo '<INPUT type="text" class="input" name="authorFamily';
                            if ($n>0) echo $n;
                            echo '" id="authorFamily'.$n;
                            echo '" size="30" value=""><br>';
                            //given(first) name LABEL
                            echo '<label for="authorGiven';
                            if ($n>0) echo $n;
                            echo '" id="modifyEntryLabels">Author '.($n+1);
                            echo ' <i>Given</i> Name</label>';
                            //given(first) name INPUT FIELD
                            echo '<INPUT type="text" class="input" name="authorGiven';
                            if ($n>0) echo $n;
                            echo '" id="authorGiven'.$n;
                            echo '" size="30" value=""><br>';
                            echo '</DIV>';
                    }
            }

            /**
         * Create author fields with test data authors hardcoded
         * into value params of the fields, injecting test data
         */
            FUNCTION createAuthorFormFieldsForTesting($_n){

                $DEBUG_STRING = "";
                # echo test data ?

                    $testFamilyName1 = 'Bradfield';
                    $testFamilyName2 = 'Willis';
                    $testFamilyName3 = 'Price';
                    $testFamilyName4 = 'Megler';

                    $testGivenName1 = 'Andrew';
                    $testGivenName2 = 'Grahame';
                    $testGivenName3 = 'Simon';
                    $testGivenName4 = 'Veronika';

                    $familyNameArray = array(
                            $testFamilyName1,
                            $testFamilyName2,
                            $testFamilyName3,
                            $testFamilyName4
                    );

                    $givenNameArray = array(
                            $testGivenName1,
                            $testGivenName2,
                            $testGivenName3,
                            $testGivenName4
                    );

                    for ($n=0;$n < $_n;$n++){
                        echo '<DIV id="divInput'.($n+1);
                        echo '" style="display: none;">';

                        #family(last) name LABEL
                        echo '<label for="authorFamilyName';
                        if ($n>0) echo $n;
                        echo '" id="modifyEntryLabels"> Author '.($n+1);
                        echo ' <i>Family</i> Name</label>';

                        #family(last) name INPUT FIELD
                        echo '<INPUT type="text" class="input" name="authorFamily';
                        if ($n>0) echo $n;
                        echo '" id="authorFamily'.$n;
                        echo '" size="30" value="'.$familyNameArray[$n].'"><br>';
                        #given(first) name LABEL
                        echo '<label for="authorGiven';
                        if ($n>0) echo $n;
                        echo '" id="modifyEntryLabels">Author '.($n+1);
                        echo ' <i>Given</i> Name</label>';
                        #given(first) name INPUT FIELD

                        echo '<INPUT type="text" class="input" name="authorGiven';
                        if ($n>0) echo $n;
                        echo '" id="authorGiven'.$n;
                        echo '" size="30" value="'.$givenNameArray[$n].'"><br>';
                        echo '</DIV>';
                    }
            }

            /**
             * Create form fields for input of files to be
             * uploaded during a form submission
             *
             * todo: return type formatting (void)
             */
            FUNCTION createUploadFormFields($_nof, $_debug){
                #$DEBUG_STRING = "";
                global $disruptExecution, $captchaStatus, $softwareID, $conn;
                global $seqNum;

                $disruptExecution = 0;
                $upperLimit = 2097152; /* max file Size in bytes (2MB) */
                $uploadsCount = 0;
                /*
                        There are some constraints on what the user may upload
                        ie format JPG, JPEG, GIF or PNG and fileSize < 2097152 bytes(2MB)
                        (denoted by php var $upperLimit)
                        String Operations substr, strrpos

                        Code does the following:
                        Extract the extension form the string, force it to lower case
                        (therfore we do not have to test for upper case extensions)
                        check capture security variable (this will change)
                */

                #LOOP
                for ($f=0;$f < 10;$f++){
                        if($_debug) echo 'CREATE: 142: DEBUG stage UPLOAD: loop index: '.$f.'<br>';
                        $ff = 'uploadedFile'.$f;
                        if($_debug) echo 'DEBUG: dealing with file: '.$ff.'<br>';
                        if(empty($_FILES[$ff])) echo 'file '.$ff.' is empty <br>';

                        if ((!empty($_FILES[$ff])) && ($_FILES[$ff]['error'] == 0)) { 
                            #if the file is present and no file errors are detected
                            $uploadsCount+=1;

                            #Check if the file is JPEG,GIF or png image or text and its size is less than 2Mb
                            $filename = basename($_FILES[$ff]['name']);
                            $ext = substr($filename, strrpos($filename, '.') + 1);
                            echo "\n"." ".$ext." ".$_FILES["uploadedFile"]["size"]."\n";
                            $ext = strtolower($ext);

                            if ($captchaStatus != -1) {
                            if (($ext == "jpg" || 
                                $ext == "gif" || 
                                $ext == "png" || 
                                $ext == "txt" || 
                                $ext == "pdf") && ($_FILES[$ff]["size"] <= $upperLimit)) {

                            if($_debug) echo 'DEBUG: fileFormat is acceptable<br>';
                            # Determine the path to which we want to save this file
                            $dir = dirname(__FILE__) . "uploads/";
                            # Check if the directory exists, if not - then create it

                            if (!is_dir( $softwareID)) {
                                if($_debug) echo 'DEBUG: destination directory created...<br>';

                                @mkdir("$dir/$softwareID", 0775); //@ -> system commands
                            }
                            $newName = $dir . $softwareID . "/" . $filename;
                            if($_debug) echo 'DEBUG: new fileName made: '.$newName.'<br>';
                            #if($_debug) $DEBUG_STRING .= 'DEBUG: new fileName made: '.$newName.'/n';

                            # Check if the file with the same name is already exists on the server
                            if (!file_exists($newName)) {
                                # Attempt to move the uploaded file to its new place
                                    if ((move_uploaded_file($_FILES[$ff]['tmp_name'], $newName))) {
                                        echo 'upload successful<br>';
                                        $fileSize = $_FILES[$ff]["size"];

                                        # NON PDO
                                        $insertFile_f = "INSERT INTO uploadedFiles (
                                                fileName,
                                                fileSize,
                                                fileType,
                                                softwareID,
                                                sequenceNum) VALUES (?, ?, ?, ?, ?)";

                                        # @@@ PDO equivalent INCOMPLETE
                                        /*
                                        $insertFile_f = "INSERT INTO uploadedFiles (
                                                fileName,
                                                fileSize,
                                                fileType,
                                                softwareID,
                                                sequenceNum) VALUES (:fn, :fs, :ft, :sid, :sqn)";
                                        #"bindArray"
                                        $bindArray = array(	':fn' => $fileName,
                                                                                ':fs'  => $fileSize, 
                                                                                ':ft'  => $filetype, 
                                                                                ':sid' => $softwareID, 
                                                                                ':sqn' => $seqNum);
                                        */

                                        #Prepare the query (mysql_i)
                                        #$file_f = $db_conn->prepare($insertFile_f) or trigger_error("1st Error!", E_USER_ERROR);

                                        $file_f = $conn->prepare($insertFile_f) or trigger_error("1st Error!", E_USER_ERROR);
                                        #$file_f = $conn->prepare($insertFile_f);

                                        #Can not proceed if we can not prepare the query
                                        #recall triple = avoids data type conversions/casting from a comparison of two variables of different data types

                                        if (false === $file_f) {
                                                trigger_error("2nd Error!", E_USER_ERROR);
                                        }

                                        #mySQL_i
                                        #Bind the fields and their parameters to our query in our testing variable $next_step
                                        $file_f->bind_param('sssii', $filename, $fileSize, $ext, $softwareID, $seqNum);


                                        #If $file1 is false then it didn't work and there is no sense of proceeding
                                        if (false === $file_f) {
                                                trigger_error('3rd Error!', E_USER_ERROR);
                                        }

                                        #Place the Execute into a variable and test if it executed or not
                                        #$file_f->execute($bindArray);

                                        $file_f->execute();
                                        $file_f->close(); //set to null for PDO cleanup

                                        if($_debug) {
                                        echo '$file_f should now be closed and null: ';
                                        }

                                #PDO
                                    #$res_file_f = $file_f->fetchAll();

                                    if($_debug) {
                                        #echo 'DEBUG: stage UPLOADS: results from executing bindArray: <br>';
                                        #$DEBUG_STRING .= "DEBUG: stage UPLOADS: results from executing bindArray:\n";
                                        #$DEBUG_STRING .= print_r($res_file_f);
                                    }
                                                            } else {
                                                                    $disruptExecution++;
                                                                    echo "<span style=\"font-size: 11px; color: red;\">" . "Error: A problem occurred during file upload!" . "</span><br/><br/>";
                                                            }
                                                    } else {
                                                            #error - a file with the same name already exists
                                                            $disruptExecution++;
                                                            echo "<span style=\"font-size: 11px; color: red;\">Error: File " . $_FILES[$ff]["name"] . " already exists</span><br/><br/>";
                                                    }
                                            } else {
                                                    #error: the file uploaded exceeds the specified file size constraint
                                                    $disruptExecution++;
                                                    echo "<span style=\"font-size: 11px; color: red;\">Error: Only .jpg,.gif,.png images and text(.txt) under 2MB are accepted for upload.</span><br/><br/>";
                                            }
                                    }
                            }
                    }
            }

            /**
             * Create 10 form fields for users to specify files to be uploaded
             * uses print instead of echo for no reason
             * 
             * recall they are invisible by default until user engages dropdown menu
             * 
             * todo return type format
            */
            #void
            FUNCTION createUploadFormFieldsWithLoop(){

                   _msgBox('b', 'FN: createUploadFormFieldsWithLoop()');

                   $testFilePath = '/Applications/MAMP/htdocs/NBPhp/AHSD/images/test_images/';

                    # GIF tests 
                    # PNG tests
                    # BMP tests
                    # JPG tests 

                    #array of known pre-determined test images located on servers storage
                    $testFiles = array(
                        'board.jpg',    #1
                        'bunny.jpg',    #2
                        'drawing.jpg',  #3
                        'friends.jpg',  #4
                        'pipe.jpg',     #5
                        'punk.jpg',     #6
                        'skull.jpg',    #7
                        'victor.jpg',   #8
                        'waldo.jpg',    #9
                        'zombie.jpg'    #10
                    );

                    for ($n=0;$n < $_numberOfFiles;$n++){
                            echo '<DIV id="divFile';
                            echo $n+1;
                            echo '" style="display: none;">';
                            echo '<hr>';

                            #code is dependent on this name 'uploadedFile_n' where '_n_ is the increment/# of file'
                            echo '<label for="uploadedFile'; 
                            if ($n!=0) echo $n-1; # 'mission critical' indexing
                #echo n;
                            echo '" id="modifyEntryLabels">Upload File</label>';
                            echo '<input type="file" name="uploadedFile';
                            if ($n!=0) echo $n-1; #mission critical indexing
                #echo n;
                            echo '" class="file" ';
                            #TEST DATA
                            #if($TOGGLE_TEST_DATA) echo 'local path to a file for uploading...';
                            #echo 'value = "'.$testFiles[$n].'"';
                            echo '">';
                            echo '</DIV>';
                    }
            }

            /**
             * Create 10 form fields WITH INJECTED TEST DATA
             * 
             * test files are located on the desktop
             * they should be copied to the local server location
             * /Applications/MAMP/
             * 
             * recall the fields are hidden by default and then 'n' fields are displayed 
             * depending on the number chosen by the user with the drop-down menu
             * to do: return type formatting (void)
             */
            FUNCTION createUploadFormFieldsWithLoop_test($_debug){

            global $TOGGLE_TEST_DATA;
            $DEBUG_STRING = "FN: loopUploadFields() (WITH testData);\n";
            if ($_debug) _msgBox('b', $DEBUG_STRING);

            $basepath = '/Users/daniel/Desktop/_test_pic/';
            #if ($_debug) _msgBox('b', $basepath);

            # make a new php file to view separately
            /**
            if ($_debug) {
                #$DEBUG_STRING .= '<b>';
                $DEBUG_STRING .= '*';
                $DEBUG_STRING .= "\n";
                $DEBUG_STRING .= $basepath;
                $DEBUG_STRING .= '*';
                $DEBUG_STRING .= "\n";
            }
            */

            $testFileArray = array(
                $basepath . 'board.jpg',      #file 1
                $basepath . 'bunny.jpg',      #file 2
                $basepath . 'drawing.jpg',    #file 3
                $basepath . 'friends.jpg',    #file 4
                $basepath . 'pipe.jpg',       #file 5

                $basepath . 'punk.jpg',       #file 6
                $basepath . 'skull.jpg',      #file 7
                $basepath . 'victor.jpg',     #file 8
                $basepath . 'waldo.jpg',       #file 9
                $basepath.'zombie.jpg' 	  #file 10
            );

            #print_r($testFileArray);

            #10 create 10 Upload File fields
            for ($n = 0; $n < 9; $n++) {
                echo '<DIV id="divFile';
                echo $n + 1;
                echo '" style="display: none;">';
                echo '<hr>';

                #code is dependent on this name 'uploadedFile_n' where '_n_ is the increment/# of file'
                echo '<label for="uploadedFile' . $n;
                echo '" id="modifyEntryLabels">Upload File</label>';
                echo '<input type="file" name="uploadedFile' . $n; #type is 'file' not 'image' as docs ie PDF may also be uploaded
                echo '" class="file" ';
                # specify a file path
                echo ' value="' . $testFileArray[$n];
                echo '">';
                echo '</DIV>';
            }

            if ($_debug) _msgBox ('g', 'FN: function createUploadFormFieldsWithLoop_test complete...');
        }

?>