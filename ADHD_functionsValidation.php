<?php
/* todo 
 * test for specialchars manually
 * decide on protocol for upper case function keyword versus lowercase function keyword
 * 
 * daniel phillis
 * daniel.phillis@gmail.com 
 * 2018
 *  */

/**
 * checkEmail redundant duplicate
 * 
 * Validate a user supplied email address
 * how valid is this method of validation?
 * @string email
 * @return boolean
 */
FUNCTION _temp_checkEmail_dupliucate($_email) {
    if (filter_var($_email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}

/**
 * checkSpamEmail
 * 
 * @return type int (1 for success)
 */
function checkSpamEmail(){

   # IF SPAM email has content, flag an error and reload page fresh - it should remain blank
   if ($_POST['email'] != "") {
       $error['email'] = true;
       /*
       echo '<script type="text/javascript" language="javascript">
           window.open("http://www.ourdigitalheritage.org","_self");
            </script>'; */
       #LOCAL VERSION todo: shift to live version

       $DEBUG_STRING .= "\nERROR: invisible email field populated:".$_POST['email']."\n";

       echo '<script type="text/javascript" language="javascript">
                       window.open("http://127.0.0.1/repos_svn/AHSD/ADHD/ADHD_newEntry.php","_self");
                       </script>';
   }
   return 1;
}

/**
 * validateAugment - needs work
 
 * deprecated tests:
 * pass the old sequence num(before query augment execution)
 * get the max seqNum after the execution
 * test for sequence increment
 * 
 * test for existence of both the title and new seqNum together
 * if both and only both tests pass then overall function passes (return 1)
 *  
 * almost any data may have been changed when updating the entry (except softwareID)
 *
 * @@@ to do - make return digit consistent with assertion functions
 * ie 0 for success and 1 for fail
 * 
 * new tests: test every attribute entered, against ?
 * if all attributes are identical then we know the augment has failed
 * (there is no point to adding an identical entry)
 * 
 * @global type $title
 * @param type $_c1
 * @param type $_swid
 * @return int
 */
function validateAugment($_s1, $_swid, $_debug){
    global $title;
    if ($_debug) _msgBox ('b', 'validateAugment reached...(calls validate increment...)');
    if ($_debug) echo '$_s1: '.$_s1.'<br>';
    
    $s2 = queryMaxSeqNumFromSoftware($_swid,0); #$_debug = 0
    
    ##NEW FUNCTION - no id provided
    #$s2 = queryCountSoftwareEntries(0);
    
    if ($_debug) echo '$s2(new max seqNum): '.$s2.'<br>';
    #simple temp validation that c2 = c1++
    
    # needs to be a validation of title AND seqNum
    if ($_debug) echo 'calling validate increment: '.$_s1.', '.$s2.'<br>';
    
    if(validateIncrement($_s1, $s2, 1)){
        if ($_debug) _msgBox('g','FN: AUGMENT SOFTWARE ENTRY SUCCESS...');
            return 1;
    } else {
        _msgBox('r','FN: AUGMENT SOFTWARE ENTRY FAIL...rollback required ?');
        return 0;
    }
}

/**
 * convenience *placeholder* function for insertion query validation
 * 
 * perhaps a better test would be to retrieve *All* seqNums 
 * for a given title
 * and ensure they are indeed incremental
 * 
 * @param type $_a pre increment
 * @param type $_b post increment
 */
function validateIncrement($_a, $_b, $_debug){
    if ($_debug) _msgBox ('b', 'validateIncrement(a,b) reached...');
    #if( ($_a + 1) == ($_b)){
    /*
    $_a = (int) $_a;
    $_b = (int) $_b;
    
    #echo $_a + $_b;
    $c = 2;
    if(1){
        echo 'a: '.$_a.'<br>';
        echo 'b: '.$_b.'<br>';
    }
    
    #catch the case that seqNum is treated as a string ?
    if(gettype($_a)=='integer' && gettype($_b)=='integer'){
        #unoptimised code ! :( 
        _msgBox('g', 'data types are correctly integer');        
    } else {
        _msgBox('o', 'data types are not integer');        
        exit;
    }
    */
    if($_a < $_b && ($_a+1 === $_b) ){
        if ($_debug) _msgBox ('g','<b>INCREMENT VALIDATED</b>');
        return 1;
    } else {
        if ($_debug) _msgBox('o', 'E:validate increment FAILED');
    }
    return 0;    
}

/**
 * VALIDATE INSERTION
 * 
 * an array of values from processing the form is 
 * passed in
 * 
 * queries are made and query results are compared to
 * the array
 */
function validateInsertion($_assoc_array){
    _msgBox('b', 'FN: VALIDATE (assoc_array)INSERTION reached...');
    $a = $_assoc_array;
    
    #echo 'a (fn parm array):<br>';
    #print_r($a);
    
    #$b = array();
    
    #displayDataInTableFromAssocArray($a, 'red', 50, 0);
    echo '<hr>';
    $_id = $a['softwareID'];
    #echo 'using ID: '.$_id.'<br>';
    
    $b = queryAllvSoftwareByID(0, $_id , 0);
    #displayDataInTableFromAssocArray($b, 'orange', 50, 0);
    #echo 'b (q results):<br>';
    #print_r($b);
    
    #compareArraysInTables($a, $b, 1);
    #exit();
    #foreach el in array
    
    #if element is in both arrays then its a verified datainsertion to the database
    # should data type sbe the same as well ?
    #data may be cast to another tpye for insertion using mySQL
    
    $testTally = 0;
    $loopCounter = 0;
    
    foreach($a as $k => $v){
        #casting to allow matches between string and int
        /**
        if($k=='year'){
            $bv = (int) ($b[((string)$k)]); #cast to int
        } else {
            $bv = $b[((string)$k)];
        }
        */
        
        $bv = $b[((string)$k)];
        
        echo 'validating from array A(passed): '.$v.'<br>';
        echo 'validating from array Q(queried): '.$bv.'<br>';
        #if data vale from a matched data value in b (called with attribute name) then its a match/hit
        $testTally += _myAssertQ($bv==$v,'elements do not match !');
    }
    #CONCLUSION
    if($testTally != 0){
        _msgBox('o','ASSERTION FAIL');
        exit();
    } else {
        _msgBox('g','VALIDATE INSERT SUCCEEDED !! :)');
        return 1;
    }
}

/**
 * convenience *placeholder* function for insertion query validation
 * @param type $_a pre increment
 * @param type $_b post increment
 */
function _validateIncrement($_a, $_b){
    if( ($_a + 1) == ($_b)){
        _msgBox('g','validation->valIncrement:seqNum increment validated');
        return 1;
    } else {
        _msgBox('o','validation->valIncrement:seqNum increment invalid');
    }
    return 0;
}

/**
 * validateArraysAreEqual
 * 
 * supporting function to aid in unit testing
 * compares:
 * 1. length of arrays are equal
 * 2.each element of two arrays is equal using _myAssert function
 * 
 * @param type $_array1
 * @param type $array2
 * 
 * @return type int 
 * returns 0 on success and 1 on failure
 * like a unit test
 */
function validateArraysAreEqual($_array1, $array2){
    
    if(count($array1) != count($array2)){
        $ret = 1; #error
        _msgBox('r', 'arrays are not of equal length !');
        return $ret;
    } else {
        _msgBox('g', 'arrays are of equal length...');
        
        #validate elements
        $counter = 0;
        
        echo '<table border="1">';
        
        $testSum = 0;
        foreach ($array1 as $el){
            /*
            if($el !== $array2[$counter]){ # == infers type checking as well
                _msgBox('r', 'ERROR: array element A['.$counter.'] != B['.$counter.'');
            */  
           $testSum += _myAssertQ(($el === $array2[$counter]), (
                   'ERROR: array element A['.$counter.'] != B['.$counter.']<br>'));
            $counter++;
        }
        
        if($testSum != 0){
            _msgBox('o', 'ERROR: array comparison failed !');
        } else {
            _msgBox('g', ': array comparison succeeded.');
        }
    }
    
}

/**
 * validateTitleExistence of data (title, seqNum)in the DB
 * @param type $_title
 * @param type $_seqNum
 * @return int
 */
function validateNewTitleExistenceWithMaxSeqNum($_title, $_seqNum){

    $_debug = 1;

    if ($_debug) echo 'title: '.$_title;

    #remove excess quotes from $_title
    if (substr($_title, 0, 1) === '"'){ 
        echo 'quotes found<br>';
        $l = (strlen($_title))-2; # -2 to trim the ending quote
        $_title = substr($_title, 1, $l);
        echo  'quotes removed<br>'.'new title: '.$_title.'<br>';
    }

    $id = querySoftwareIDsFromTitle($_title,0);
    print_r($id);
    exit();
    
    $maxSN = queryMaxSeqNumFromSoftware($id,1);

    $titleCheck = querySoftwareTitleFromSW($id,1);

    #echo 'title exists'.$_title.'<br>';
    $check1 = 0;
    $check2 = 0;

    if ($_seqNum === $maxSN){
        echo 'seqNum checks out<br>';
        $check1 = 1;
    }

    if ($titleCheck === $_title){
        echo 'title checks out<br>';
        $check2 = 1;
    }

    if ($check1 && $check2){
        if ($_debug){
            _msgBox('g', 'V:both title and maxSeqNum check out'); #lightgreen
            _msgBox('g', 'V:augmented title existence validated !');
        }
        return 1;
    } else {
        if ($_debug){
            _msgBox('red','E:existence invalid...record not found');
        }
        exit;
        /*
        #todo encapsulate this code in its own page
        echo '<hr>'
        .'<p>'
        #TO DO CSS STYLING TO BE APPLIED HERE
        .'</i>you have changed the title, '
        .'are you sure you dont want to contribute a<br>';
        #### #### #### #### #### #### #### #### 
        
        echo '<a href = "../../ADHD_newEntry.php">'
        .'<b>New Entry</a> ?</b><hr>';
        #### #### #### #### #### #### #### #### 
        #takes user to form again
        
        echo '$id type: '.gettype($id).'<br>';
        
        echo '<p>continue with<br>'
        .'<a href = "ADHD_modifyEntry.php?id='.$id.'">'
        .'<b>Modify Entry</a> ?</b><hr>';
        #exit();
        return 0;
         **/
    }
}

/**
 * TEST
 *
 * test class paired with function below (formCheckMandatoryFields(a,debug))
 *
 * @@@ summary of Tests
 * a family name with hyphens (should pass)
 *
 * a family name with a leading or trailing hyphen should fail
 * a family name with underscores should fail
 * a family name containing numerals should fail
 * a family name containing other special characters should fail
 * 
 * use box instead of tables here
 */
function formCheckMandatoryFields_test($_debug){
    #debug info
    $white = "#FFFFFF";
    
    _msgBox($white, '@@ Unit TESTING @@ formCheckMandatory(form)Fields\n');
    echo '<table border = "1" bgcolor="#ffebcd">';
    echo "<th><br><b> * Unit TESTING * formCheckMandatory(form)Fields</b><br></th>";
    $DEBUG_STRING = "\n\n @@ Unit TESTING @@ formCheckMandatory(form)Fields\n";

    $testsum    =   0;
    $_debug     =   0;
    $fail       =   1;
    $pass       =   0;

    #EXPECT TO FAIL TESTS:
    echo '<tr><td>'
    .'<br><b><u>Assertions...</u></b><br>'
    .'</td></tr>'
    .'<tr><td>';
    #FAIL (expecting an error) #Assertion1 - #FAIL (expecting an error)
    $_POST['contributorFamily'] = ""; # we know this should fail
    $testsum += customAssert((formCheckMandatoryFields($_debug) === $fail),
            'assertion1 surname is blank failed'); #1 is an error
    if ($testsum) box('red','FAIL');
    echo '</td></tr>'.'<td><tr>';
    
    #FAIL (expecting an error) #Assertion2 - surname contains mixed digits and numerals - predict fail
    $_POST['contributorFamily'] = "mixOfLettersAnd01234Numbers";
    $testsum += customAssert((formCheckMandatoryFields($_debug) === $fail),
            'assertion2 surname comprised of mixed digits failed'); #1 is an error
    if ($testsum)  box('red','FAIL');
    echo '</td></tr>'.'<td><tr>';
    
    #FAIL (expecting an error) #Assertion3 - surname contains underscore - predict fail
    $_POST['contributorFamily'] = "mix_Of_Letters_and_underscores";
    $testsum += customAssert((formCheckMandatoryFields($_debug) === $fail),
            'assertion3 surname contains underscore failed'); #1 is an error
    if ($testsum) box('red','FAIL');
    
    echo '</td></tr>'.'<td><tr>';
    
    #FAIL (expecting an error) #Assertion4 - surname is only a digit (as a string)
    $_POST['contributorFamily'] = "7";
    $testsum += customAssert((formCheckMandatoryFields($_debug) == $fail),
            'assertion4 surname is a digit failed'); #1 is an error
    if ($testsum) box('red','FAIL');
    
    echo '</td></tr>'.'<td><tr>';
    
    #PASS TESTS #Assertion5 (formCheckMandatoryFields should return 0 for a positive)
    $_POST['contributorFamily'] = "Surname";
    $testsum += customAssert((formCheckMandatoryFields($_debug) === $pass),
            'assertion5 normal input surname failed'); #return of 1 ($printAgain)
    if ($testsum) box('red','FAIL');
    
    echo '</td></tr>'.'<td><tr>';
    
    #Assertion6 All lower case - should still pass
    $_POST['contributorFamily'] = "surname";
    $testsum += customAssert((formCheckMandatoryFields($_debug) === $pass),
            'assertion6 all lowercase surname failed'); #return of 1 ($printAgain)
    if ($testsum) echo box('red','FAIL');
    
    echo '</td></tr>'.'<td><tr>';
    
    #Assertion7 HyphenatedName - should still pass
    $_POST['contributorFamily'] = "Phillis-Hughes";
    if ($testsum) box('red','FAIL');
    $testsum += customAssert((formCheckMandatoryFields($_debug) === $pass),
            'assertion7 Hyphenated Surname failed'); #return of 1 ($printAgain)
    
    #Indicates an Error
    echo '</td></tr>';
    
    $_debug = 1;

    echo '<td><tr>';
    
    if($testsum){
        $DEBUG_STRING .= "\nformCheckMandatoryFields_test FUNCTION / UNIT TEST FAILED\n";
        echo "testsum: " . $testsum ."<br><br>";
        _msgBox('red', 'UNIT TEST (formCheckMandatoryFields) FAILED !');
    } else {
        $DEBUG_STRING .= "\nformCheckMandatoryFields_test FUNCTION / UNIT TEST PASSED\n";
        _msgBox('g', 'formCheckMandatoryFields_test FUNCTION / UNIT TEST PASSED !'); #lightGreen
    }
    echo '</td></tr>'.'</table>';

    #write
    #writeToFileTXT($DEBUG_STRING);
}

/**
 * Check mandatory fields in the contribute (add new Entry) form
 *
 * flag $print{Form}Again if any mand. form fields are
 * missing OR if $YEAR is not a number or blank
 * 
 * this is one possible function to include data sanitation, in fact year is 
 * already being checked to contain numerals
 * 
 * @return type INT
 */
FUNCTION formCheckMandatoryFields($_debug){
    #$DEBUG TRACE MSG
    if ($_debug) _msgBox('b', "<i>formCheckMandatoryFields() reached..</i>");
    
    global $printAgain, $error;
    $printAgain = FALSE;
    
    #echo 'email: '.$_POST['altAddress'].'<br>';
    #Error if "Your Family Name" is empty
    IF ($_POST["contributorFamily"] == "") {
        echo "fam name field was empty<br>";#displayed to user
        $error['contributorFamily'] = TRUE;
        $printAgain = TRUE;
    }
    
    #explain regular expression here
    if(preg_match('~[0-9]~', $_POST["contributorFamily"]) ||
        strpos($_POST["contributorFamily"],'_')){
        #has numbers
        echo "fam name field contains numerals<br>";
        $error['contributorFamily'] = TRUE;
        $printAgain = TRUE;
    }

    #Error if email is empty
    IF ($_POST["altAddress"] == "") {
        _msgBox('r','email field was empty');
        echo "email is mandatory<br>";
        $error['emailAddress'] = TRUE;
        $printAgain = TRUE;
    }
    
    #Error if email address is not correct
    IF (!checkemail($_POST["altAddress"])) {
        echo "email format is invalid <br>";
        $error["emailAddress"] = TRUE;
        $printAgain = TRUE;
    }
    #Error if year is not numeric
    IF (isset($_POST['Year']) && !is_numeric($_POST["Year"])) {
        echo "year not numeric";
        $error['Year'] = TRUE;
        $printAgain = TRUE;
    }

    if ($_debug){
        _msgBox('g', '...function checkMandatoryFormFields complete');
    }
    
    /*
    if ($printAgain){
        return 1;
    } else {
        return 0;
    }
     * */
    
    return $printAgain;
}

/**
* formStoreData also does VALIDATION
* 
* includes queryPublisherID(pubName, $_debug);
* 
* and will *soon* prevent SQL injection
*  
* calls unit test 'formAssignVariables_test'
* 
* these are the new variables from the form data
* they should be kept seperate fromt he old data queried from the DB so as
* to determine what changes have been made in between sequence Numbers / augmentations 
* returns $newData - an array of validated form data
*/

/**
 * GET COUNTRY returns the string of the country from the form field
 *
 * more detail, returns a string
 * @return int
 */
FUNCTION getCountry_test(){
    $testsum = 0;
    $fail = 1;
    $pass = 0;

    echo "<font color=\"green\"> @@ UNIT TESTS for getCountry...broken and removed</font><br>";

    #test1 Country = 'Australia'
    #PASS
    $_POST['country'] = 'Australia';
    echo 'test: '.getCountry(1);

    $testsum += customAssert((getCountry(1) == 'Australia' ),"fail message for getCountry('Oz')");

    #test2 Country = 'New Zealand'
    #PASS
    $_POST['country'] = 'New Zealand';
    $testsum += customAssert((getCountry(1) == 'New Zealand'),"fail message for getCountry('NZ')");

    #test3 Country = 'Others'
    #PASS
    $_POST['country'] = 'Others';
    $testsum += customAssert((getCountry(1) == 'Others'),"fail message for getCountry('Others')");

    #test4 Country = ''
    #PASS
    $_POST['country'] = '';
    $testsum += customAssert((getCountry(1) == ''),"fail message for getCountry('<blank>')");

    #test4 Country = 'Botswana'
    #FAIL
    $_POST['country'] = 'Botswana';
    $testsum += customAssert(((getCountry(1) == 'Botswana') === FALSE),"fail message for getCountry('Botswana')");

    if($testsum > 0){ #count of failed tests - should be 0 to pass the functions's unit test
        #echo '<b><font color="red"><b> @@ UNIT TEST for getCountry FAILED<br></b>';
        _msgBox('red','UNIT TEST for getCountry() FAILED!');
        return 0;
    } else {
        #echo '<b><font color="#b3e6ff">@@ UNIT TEST for getCountry SUCCEEDED<br></b>';
        _msgBox('g','UNIT TEST for getCountry() SUCCEEDED !'); #lightGreen
        return 1;
    }
}

/**
 * getCountry
 * 
 * a dedicated function to ensure the default value is not entered as data
 * 
 * @global type $country
 * @param type $_debug
 * @return string
 */
FUNCTION getCountry($_debug){
    global $country;
    #$DEBUG_STRING = line();
    #cannot call unit tests from here as they call this function (recursive call)
    $country = cleanTemp($_POST['country'], END_QUOTES,"UTF-8");

    IF ($country == "Choose a country...") {
        #$country = "country not chosen"; #we don't what this string in the DB
        $country = "";
        #echo 'country not chosen, data will be an empty string<br>';
        $DEBUG_STRING .= "\n country not chosen, data will be an empty string \n";
    }

    $country = cleanTemp($_POST['country'], END_QUOTES,"UTF-8");

    #WHITELIST COUNTRY
    if ($country != 'Australia'    ||
        $country != 'New Zealand'  ||
        $country != 'Others'       ||
        $country != ''
    ){
        #echo 'country whitelisting failed...<br>';
        _msgBox('red','country whitelisting failed...');
        $DEBUG_STRING .= "\n !! whitelisting 'country' failed...\n";
        $country = "fail"; #string type retained
    }
    echo "country = ".$country."<br>";
    $DEBUG_STRING .= "\ncountry = ".$country."\n";
    #write
    #writeToFileTXT($DEBUG_STRING);
    return $country;
}

/**
 * Get Licence from the form field
 * 
 * @return int
 */
FUNCTION getLicenceList_test(){
    $DEBUG_STRING = "";

    #WHITELIST
    $whiteList = array(
       '',
       'Choose a licence',
       'GNU General Public License',
       'Attribution',
       'Attribution-noncommercial',
       'Attribution-Share Alike',
       'Attribution-noncommercial-sharealike',
       'Public Domain',
       'Sampling Plus',
       'Noncommercial Sampling Plus',
       'Copyright'
    );

    if(!in_array($_POST['licencelist'],$whiteList)){
        #throw error
        echo 'getCountry threw error<br>';
        $DEBUG_STRING .= "getCountry threw error\n";
        return 1;
    } else {
        return 0;
    }
}

/**
 * Unit test function above
 * @global type $licenceList
 * @param type $_debug
 * @return string
 */
FUNCTION getLicenceList($_debug){
        global $licenceList;
        #$DEBUG_STRING = "";

        $licenceList = cleanTemp($licenceList, END_QUOTES,"UTF-8");

        #UNIT TEST
        if (getLicenceList_test()) {

            IF ($_POST['licenceList'] == "Choose a licence...") {
                # $licencelist = "licencelist not chosen";
                $licenceList = "";
                if ($_debug) {
                    #$DEBUG_STRING .= "\nlicence not chosen, data will be an empty string";# we dont want this string in the DB
                }
            } ELSE { #5

                if ($_debug) {
                    #echo 'licence specified = '.$licenceList.'<br>';
                    #$DEBUG_STRING .= "\nlicence specified = " . $licenceList;
                }
            }
        }
        return $licenceList;
    }
    
/**
 * cleanNumeric (#new clean functions)
 * from https://www.w3schools.com/php/php_filter.asp
 * @param type $_string
 * @return type string - but should be int ?
 */
function cleanNumeric($_string, $parm, $_debug){
    $blue = '#b3e6ff';
    #detect empty string
    if ($_string=='' && ($_debug==1)){
        echo '<font color="red">blank string detected in function cleanNumeric($_string)<br>';
        echo 'on parm '.$parm.'<br>';
        echo '</font><br>';
        
    }
    
    if ($_debug){ 
        _msgBox($blue,'function cleanNumeric reached ');
        echo 'on string '.$_string.'</font><br>';
    }
        
    #Trim and remove whitespaces (hex is U+0020)
    $outString = trim($_string, "\t\n\r\0"); #$t = trim($_string, \t\n\r\0\x0B
    
    /** cannot use this here as this function handles both date and softwareID
    if (count($outString)!=4) {
        echo '<font color = "red">';
        echo 'date format incorrect: wrong count of chars (should be 4)';
        echo '</font><br>';
        exit();
    } 
    */
    
    #remove HTML Tags
    #sanitisation != validation !
    $outString = filter_var($outString, FILTER_SANITIZE_STRING);
    
    $outString = (int) $outString;
    if ($_debug) echo 'data type converted to integer instead of string<br>';
    
    if (filter_var($outString, FILTER_VALIDATE_INT) === 0 ||
        !filter_var($outString, FILTER_VALIDATE_INT) === false) {

        if ($_debug) echo("Integer is valid<br>");
        if ($_debug) echo '<font color="green">function complete ...</font><br>';
        return $outString;
    } else {
        if ($_debug) echo '<font color = "red">Integer is not valid</font><br';
        exit();
    }
    #use regexp for chars ?
}

/**
* cleanSimple - alpha numeric chars and spaces allowed
* but only punctualtion allowed is '.' and '-'
* 
* https://stackoverflow.com/questions/3126072/what-are-the-best-php-input-sanitizing-functions
* 
* "UTF-8 All the Way through"
* https://stackoverflow.com/questions/279170/utf-8-all-the-way-through
* 
 * BB control flow for this function is modified compared to those above
* @param type $_string
* @return type
*/
function cleanSimple($_string, $parm, $_debug){
   /**
   $whiteChars = 'abcdefghijklmnopqrstuvwxyz';
   $whiteChars .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
   $whiteChars .= '0123456789';
   $whiteChars .= ' -.';
   */
    
    if ($_string=='' && $_debug){
        _msgBox('o','empty string detected on parm<b> '.$parm);
    }
    #use regexp for chars
    if (!preg_match('/^[A-Za-z0-9 -.]*$/', $_string)) {
        if ($_debug) _msgBox('red','String Validation Failed...');
        exit();
        #need to actually handle instances of illegal chars
    }#else
    return $_string;
}

/**
* special chars allowed  are ".,-\"" (quotes allowed)
* @param type $_string
*/
function cleanComplex($_string, $parm, $_debug){
   
   if($_string != '' || (!is_null($_string))){
        if($_debug){    
            _msgBox('b','function cleanComplex('.$_string.') reached...');
        }
        #explicit test for a ' or `
        
        $strA = str_split($_string);
        #illegal chars that will stop execution
        #( have removed " and ' and : and ; and ( and ) and ? and , and .
        #these are treated as legal)
        $haystack = str_split("`@#$%^&*+=~<>[]{}|\/");
                
        #check each individual char for illegal character
        foreach($strA as $el){
            if (in_array($el, $haystack)){
                #DEBUG
                if ($el != 'N/A'){
                    _msgBox('o', ('illegal char "'.$el.'" detected in string<br><i>'.$_string.'</i>'));
                }
                #exit();
            }
        }
        if ($_debug) _msgBox('green','function cleanComplex($_string, $parm, $_debug) complete...');
        #_msgBox('g','function cleanComplex('.$_string.') complete...');
        return $_string;
        
        #the dot is is used as regexp syntax therefore to be treated as a literal it must be escaped /.
        # todo properly explain this regExp
        /*
        if(preg_match('/^[A-Za-z0-9 -"]*$/', $_string)) {
            echo '<font color="green">';
            echo 'function complete...';
            echo '</font><br>';
            return $_string;

        } else {
            echo '<font color = "red">';
            echo 'String Validation Failed...on <i>'.$_string;
            echo '</i><br></font>';

            #need to actually handle instances of illegal chars

            exit();
        }
        */
    } else {
        if ($_debug) _msgBox('o','blank string on parm <b>'.$parm.' </b>detected...');
        return NULL;
    }
}

/*
* whiteListCountry
* 
* is this redundant ? - as the only input is 
* controlled by a drop down list anyways
* 
* return $_string
*/
function whiteListCountry($_string, $_debug){
   $_string = trim($_string);
   
   if($_string=="Choose a country...") $_string = '';
   
   if ($_string == 'Australia'    ||
       $_string == 'New Zealand'  ||
       $_string == 'Others'       ||
       $_string == ''    
   ){
       return $_string;
   } else {
       _msgBox('red', ('fn:whiteListCountry->Validation failed for country: '.$_string));
   }
}

/**
* whiteListLicence
* 
 * #NB spelling of License versus licence or lisense
 * 
* @param type $_string
* @return type string: $_string
*/
function whiteListLicence($_string, $_debug){
   $_string = trim($_string);
   
   if($_string=="Choose a licence...") $_string = '';
   
   #boolean logic -> if string != any of these options
   #test still passes if last option is omitted
   if ( $_string == 'GNU General Public License'    ||
        $_string == 'Attribution'                   ||
        $_string == 'Attribution-noncommercial'     ||
        $_string == 'Attribution-Share Alike'       ||
        $_string == 'Attribution-noncommercial-sharealike' ||
        $_string == 'Public Domain'                 ||
        $_string == 'Sampling Plus'                 ||
        $_string == 'Noncommercial Sampling Plus'   ||
        $_string == 'Copyright'                     ||
        $_string == ''                              ||
        $_string == 'Licence was not chosen'
   ){
       return $_string;
   } else {
       if($_debug) _msgBox('r',('val->whiteListLicence->Validation failed for licence: '.$_string));
       #exit();
   }
}

/**
* cleanEmail
* from
* https://www.w3schools.com/php/php_filter.asp
* 
* @param type $_email
* @return type string
*/
function cleanEmail($_email){
       $outEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

       #Validate e-mail
       if (filter_var($outEmail, FILTER_VALIDATE_EMAIL) === false) {
           _msgBox('red',($email.' is not a valid email address'));
           exit();
       } else {
           #echo $email.' is a valid email address';
           _msgBox('g',($email.' <i>IS</i> a valid email address'));
           return $outEmail;
       }
   }

?>