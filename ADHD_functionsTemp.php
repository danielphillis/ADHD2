<?php

/**
 * NEED TO RETIRE THIS FUNCTION in next version
 * _writeToFileTXTLocal
 * @param type $_debug_string
 * @return type void
 */
function _t_writeToFileTXTLocal($_debug_string){
    $absPath = '/Applications/MAMP/htdocs/repos_SVN/AHSD/ADHD/_unit_test_results/';
    $_file = '_debug_output.txt';
    $debug_file = $absPath.$_file;
    file_put_contents($debug_file, $_debug_string, FILE_APPEND | LOCK_EX);
}

/**
 * Assign form data to php variables
 *
 * camelCase now enforced globally for global variables
 * 
 * #todo if form data is the same as previously defined variables
 * then assign a null value
 * return type void
 */
FUNCTION __temp_storeFormData($_debug) {
    if ($_debug) echo 'function formAssignVariables() reached ...<br>';

    global  $title, 
            $year, 
            $authorInputCount,
           
            $authorGivenName,
            $authorGivenName1,  
            $authorGivenName2,  
            $authorGivenName3, 
            $authorGivenName4,
            
            $authorFamilyName,
            $authorFamilyName1, 
            $authorFamilyName2, 
            $authorFamilyName3, 
            $authorFamilyName4,
           
            $publisher, 
            $country, 
            $hardwareReq, 
            $softwareReq, 
            $description, 
            $notes,
            
            $contributorFamily, 
            $contributorGiven,
            $altAddress, 
            $filesNum, 
            $seqNum;

    $DEBUG_STRING = "";
    #problem
    #static $seqNum = 1; #static keyword is used to ensure the value cannot change in this function

    # Assign HTTP_post variables to php variables and remove html special chars

    if ($_debug) echo "<br>DEBUG:Function: formAssignVariables()<br>";
    $DEBUG_STRING .= "\nDEBUG:Function: formAssignVariables()";
    $DEBUG_STRING .= "\nAssign form field data to global vars...";
    $DEBUG_STRING .= "\n ----- ----- ----- ----- ----\n";

    $tempCounter = 0;

    $DEBUG_STRING .= "\nforeach(\$_POST array as \$row)...";
    
    #ideas / notes
    /* print of data postponed to after assignment
    # to reflect changes ie 'Choose a Country'
    # zero based assignment to match array operations
    
    # check if new value is different to the existing value, and if not, ignore
    # the new value
    
    #only update the global (with the $_POST[] var) if they're different
    
    #todo put variables into an array and loop over them (with the same operation)
    #title
    */
    # manual 'is_empty' tests on globals
    
    #if different to variable set, get again from the form
    if ($title != $_POST['title']){
        $title = $_POST['title'];
    }
    #no else required, title shouldnt change
    
    #year
    /*
    if ($year != $_POST['Year']{
        $year = $_POST['year'];
    }else {
        $year = 'same';
    }
    */
    $year = $_POST['Year'];
    
    #authInputCount (derived not from form but from counting form data on authors)
    /*
    if($authorInputCount != $_POST['authInputCount']){
        $authorInputCount = $_POST['authInputCount'];
    } else {
        $authorInputCount = 0;
    }
    */
     
    #giv0
    if($authorGivenName != $_POST['authorGiven']){
        $authorGivenName = $_POST['authorGiven'];
    } else {
        $authorGivenName = '';#same data as previous seqNum, therefore leave blank
    }
    #fam0
    if($authorFamilyName != $_POST['authorFamily']){
        $authorFamilyName = $_POST['authorFamily'];
    } else {
        $authorFamilyName = '';#same data as previous seqNum, therefore leave blank
    }
    #giv1
    if($authorGivenName1 != $_POST['authorGiven1']){
        $authorGivenName1 = $_POST['authorGiven1'];
    } else {
        $authorGivenName1 = '';#same data as previous seqNum, therefore leave blank
    }
    #fam1
    if($authorFamilyName1 != $_POST['authorFamily1']){
        $authorFamilyName1 = $_POST['authorFamily1'];
    }
    #giv2
    if($authorGivenName2 != $_POST['authorGiven2']){
        $authorGivenName2 = $_POST['authorGiven2'];
    } else {
        $authorGivenName2 = '';#same data as previous seqNum, therefore leave blank
    }
    #fam2
    if($authorFamilyName2  != $_POST['authorFamily2']){
        $authorFamilyName2 = $_POST['authorFamily2'];
    } else {
        $authorFamilyName2 = '';#same data as previous seqNum, therefore leave blank
    }
    #giv3
    if($authorGivenName3 != $_POST['authorGiven3']){
        $authorGivenName3 = $_POST['authorFamily3'];
    } else {
        $authorGivenName3 = '';#same data as previous seqNum, therefore leave blank
    }
    #fam3
    if($authorFamilyName3  = $_POST['authorFamily3']){
        $authorFamilyName3  = $_POST['authorFamily3'];
    } else {
        $authorFamilyName3  = '';#same data as previous seqNum, therefore leave blank
    }
    #giv4
    if($authorGivenName4   = $_POST['authorGiven4']){
        $authorGivenName4  = $_POST['authorGiven4'];
    } else {
        $authorGivenName4  = '';#same data as previous seqNum, therefore leave blank
    }
    #fam4
    if($authorFamilyName4  = $_POST['authorFamily4']){
        $authorFamilyName4  = $_POST['authorFamily4'];
    } else {
        $authorFamilyName4  = '';#same data as previous seqNum, therefore leave blank
    }

    $publisher          = $_POST['publisher'];
    $country            = $_POST['country'];

    if(substr($country,0,3)==='Cho') {
        $country = '';
    }

    /**
    #country override - is this necessary as getCountry FUNCTION also creates empty strings when needed
    if($country = '') {
        echo 'DEBUG:No Country Chosen"<br>changed to empty string<br>';
        $DEBUG_STRING .= "\n DEBUG:No Country Chosen...changed to empty string...";
    }
    */
    
    #assign vars individually
    $hardwareReq        = $_POST['hardwareReq'];
    $softwareReq        = $_POST['softwareReq'];
    $description        = $_POST['description'];
    $notes              = $_POST['notes'];
    $contributorFamily  = $_POST['contributorFamily'];
    $contributorGiven   = $_POST['contributorGiven'];
    $altAddress         = $_POST["altAddress"];
    $filesNum           = $_POST["filesnum"];
    
    #use an array to operate on global variables
    #(array of 22 globals)
    $vars_assoc = array(
        'title'             => $title, 
        'year'              => $year, 
        #'authorInputCount'  => $authorInputCount, 
        
        'authorGivenName'   => $authorGivenName,
        'authorGivenName1'  => $authorGivenName1,
        'authorGivenName2'  => $authorGivenName2,
        'authorGivenName3'  => $authorGivenName3,
        'authorGivenName4'  => $authorGivenName4,
        
        'authorFamilyName'   => $authorFamilyName,
        'authorFamilyName1'  => $authorFamilyName1,
        'authorFamilyName2'  => $authorFamilyName2,
        'authorFamilyName3'  => $authorFamilyName3,
        'authorFamilyName4'  => $authorFamilyName4,
        
        'publisher'         => $publisher,
        #'publisherName'         => $publisherName,
        #'publisherName'         => $publisher,
        
        'authorFamilyName'  => $country,
        'hardwareReq'       => $hardwareReq,
        'softwareReq'       => $softwareReq,
        'description'       => $description,
        'notes'             => $notes,
        
        'contrbutorFamily'  => $contributorFamily,
        'contrbutorGiven'   => $contributorGiven,
        'altAddress'        => $altAddress,
        'filesNum'          => $filesNum        
    );
    
    #array of 22 globals
    $vars = array(
        $title, 
        $year, 
        #$authorInputCount, #not included
        
        $authorGivenName,
        $authorGivenName1,
        $authorGivenName2,
        $authorGivenName3,
        $authorGivenName4,
        
        $authorFamilyName,
        $authorFamilyName1,
        $authorFamilyName2,
        $authorFamilyName3,
        $authorFamilyName4,
        
        $publisher,
        #$publisherName, #was $publisher
        $country,
        #licenceList ?
        $hardwareReq,
        $softwareReq,
        $description,
        $notes,
        
        $contributorFamily,
        $contributorGiven,
        
        $altAddress,
        $filesNum
    );
    
    $n = 0;
    foreach ($vars_assoc as $var){
    #foreach ($vars as $var){
        #print_r($var);
        if ($_debug) echo $n.' ';
        #echo $vars_assoc['title'];
        if ($_debug) echo $var;
        $n++;
        if ($_debug) echo '<br>';
        
        #clean
        $var = cleanTemp($var,$debug=0); #is cleanTemp *really* doing anything useful ?
        $var_assoc[$n] = $var;
        #echo 'replacement done<br>';
    }
    echo '<font color="red">VARS: ';
    print_r($vars);
    echo '</font><br>';
   
    #DEBUG
    
    if ($_debug) _msgBox ('g', '...complete');
    #$DEBUG_STRING .= "\nDEBUG:functionsValidation()";
    #$DEBUG_STRING .= "\n...Complete";
    #spewPostVars();
    #writeToFileTXT($DEBUG_STRING);
}

/**
 * uses "htmlspecialchars" - is this enough ?
 * 
 * also detect numerals and hyphens using strpos
 * @param $_s
 * @return string
 */
FUNCTION _temp_cleanTemp($_s, $_debug){
    $blue = '#b3e6ff';
    $debug = 0;
    if ($_debug) {
        #echo "<br><i>clean_temp function reached...</i><br>";
        _msgBox($blue,'<i>clean_temp function reached...</i>');
    }
    $DEBUG_STRING = "\nclean_temp function reached...";
    
    #$_debug = 0;
    #todo detect hyphens and numerals in the string
    $len = sizeOf($_s);

    if (strpos($_s,'-') !== false && $_debug){
        #echo $_s." function clean_temp ## Hyphen detected !<br>";
        _msgBox ('yellow', ($_s.' function:cleanTemp # Hyphen detected !'));
    }

    for ($i=0;$i < $len;$i++) {
        if ($_debug) echo $_s[$i];
        if ((strpos($_s, $i) !== false) &&($_debug)) {
            #box('red','a');
            echo '<br> function clean_temp ## numeral "'.$i.'" detected !<br>';
            $DEBUG_STRING .= "\n## numeral '".$i."' detected !\n";
        }
    }
    if ($_debug) echo '<br>...complete<br>';

    #writeToFileTXT($DEBUG_STRING);

    return htmlspecialchars($_s, ENT_QUOTES, 'UTF-8');
}

/**
 * 
 * augmentSoftwareEntryByArray()
 * 
 * relies on the fact that SQL can insert data in an arbitrary order as 
 * long as both the paramaters and the values are supplied in the correct 
 * order with respect to each other
 * 
 * seqNum and softwareID for the primary key (composite)
 * and so must be present
 * 
 * softwareID and seqNum are already present when this function is called
 * they are global vars..
 * 
 * the array being passed into the function
 * contains publisher name but the SQL query requires publisherID
 * therefore the ID must be queried (its either existing or generated by incrementing
 * the max existing ID)
 * 
 * if querying an existing publisherID - the publisherName is used to get the ID
 * 
 * @param type $newArray
 * @param type $_debug
 * @return type int for success
 */
FUNCTION _temp_augmentSoftwareEntryByArray($newArray, $_debug){
    #debug
    #$debug_string= '';
    if ($_debug) _msgBox('b','<i>function begin: augmentSoftwareEntryByArray(a,debug)</i>');
    #$debug_string .= "function: augmentSoftwareEntryByArray (not a test)\n";
    
    GLOBAL  $conn;
    
    #ordered globals
    GLOBAL  $softwareID,
            $seqNum, #IMPORTANT
            $title,
            $year, 
            
            $authorGivenName, $authorGivenName1, $authorGivenName2, $authorGivenName3, $authorGivenName4,
            $authorFamilyName, $authorFamilyName1, $authorFamilyName2, $authorFamilyName3, $authorFamilyName4,
            
            $publisher, 
            $country, 
            $hardwareReq, $softwareReq, 
            $licence, 
            #$insertedDate,
            $description, 
            $notes, 
            $contributorFamily, $contributorGiven,
            #fullname
            $altAddress,
            $numberOfFiles;
            #$filesNum; #duplicate

    GLOBAL  $publisherID, $contributorID; # these 2 not tied to bind parms
    #GLOBAL  $authorInputCount; #required ?
    
            #dynamically build query from $_array
            /*
             * notes - 
             * dont insert any blank values...
             * NB this breaks our comparison tables
             */
            
            #bind parm letters
            $bindParms = 'abcdefghijklmnopqrstuvwxyz';
            #explode into array
            /*
            $bindParms = array(
                ':a', ':b', ':c', ':d', ':e', ':f', ':g', ':h', ':i', ':j', ':k', ':l', ':m', 
                ':n', ':o', ':p', ':q', ':r', ':s', ':t', ':u', ':v', ':w', ':x', ':y', ':z'
            );
            */
            
            #$bindParms = str_split($bindParms);
            #$bindParms []= date(Y-m-d); #makes 27 parms in total with date
            #bind parm abbreviations count=26
            
            #27
            $bindParmsABR = array(
                ':sID', ':sqn', ':ttl', ':yr',
                #authors
                ':augn', ':augn1', ':augn2', ':augn3', ':augn4', 
                ':aufn', ':aufn1', ':aufn2', ':aufn3', ':aufn4',    
                ':pID', #publisherID
                ':cnt',':hwr',':swr',
                ':lic',
                #':dte', #insertedDate 
                ':des', ':not', 
                ':cID',
                #':cfn ', ':cgn ', ':cfl ', ':aad ', 
                ':fno',
                ':dte' # date moved to end
            );#fno = nof - needs consistency
            
            #base Query
            $queryAugmentEntry = 'INSERT INTO software (';       
            
            $i = 0;
            
            ##### ##### ##### ##### ##### ##### ##### ##### #####
            /* Concatenate column names to build query
            # but only add those that have data...
            #
            # inserting null valules is acceptable ?
            # all column names are already present in the database
            # are theyre performance gains to be had when inserting nulls
            # versus not inserting thos parms at all ?
            # need to time execution of function
            # array now does not include inserted Date
            */
            // Confirm count of newArray 
            #echo 'newArray size: ';
            #echo count($newArray).'<br>'; #now 28
            //exit();
            
            ##### ##### ##### ##### ##### ##### ##### ##### 
            # Continue building the query with column names
            
            $i = 0;
            foreach($newArray as $key => $val){
                #echo key
                
                #filter out unwanted keys 
                #(contributorFamily, contributorGiven fullName , publisher)
                # there has to be a better way
                
                /**
                 * even though they are required for display they cannot be in 
                 * the query as the table doesn't have those column names / attributes
                 * 
                 * the query will then return FALSE and the PDO binding will fail
                 */
                if ($val!='' && $key!='publisher'){
                    #filter : no empty parms, publisher
                    #BUILD STRING
                    $queryAugmentEntry .= $key;
                    if ($i < (count($newArray)-1) ) $queryAugmentEntry .= ', ';
                }
                $i++;
            }
            
            $i = 0; #counter
            $queryAugmentEntry .= ') VALUES (';
            
            ##### ##### ##### ##### ##### ##### ##### ##### #####
            /* CONCAT BINDPARAMS to build PDO preparation query
            # but only add those that hold data
            # code depends on the order of parms matching between $newVars and $bindParms
            # (not ideal...) should be inmproved
            */
            
            $PDO_executionArray = array();
            
            foreach($newArray as $key => $val){
                if ($val!=''){
                    #echo val
                    #build query
                    $queryAugmentEntry .= $bindParmsABR[$i];
                    #build array of bindParmsfor final execution
                    if ($key != 'publisher'){ 
                        /* surround with quotes
                        if ($key == 'country' || 
                                $key == ''){
                        }*/
                        $PDO_executionArray[]= $val;
                    }
                    #print_r($PDO_executionArray);
                    if ($i < (count($newArray)-1) ) $queryAugmentEntry .= ', ';
                }
                $i++;
            }
            #echo '<br><br>';
            
            /**
             * add current date on the end
             * 
             * recall the oder of the parms in relation to the table columns doesnt matter,
             * only the order of the parms in relation to the binding parms matters
             */
            
            ### AUGMENT QUERY WITH DATE
            #use VAL to locate 'VALUES in query string
            
            $queryAugmentEntry  = str_replace(') VAL', (', insertedDate) VAL'), $queryAugmentEntry);
            #$queryAugmentEntry .= ', :dte'; #already there ?
            $queryAugmentEntry .= ')';
            
            #show query #echo '</b>';
            if ($_debug) _msgBox('cyan',$queryAugmentEntry);
            
            echo $queryAugmentEntry;
            $PDO_executionArray[]= date('Y-m-d');
            echo '<br>';
            print_r($PDO_executionArray);
            
            ##### ##### ##### ##### ##### ##### ##### ##### #####
            #PREP the query
            $stmtAug = $conn->prepare($queryAugmentEntry); #augment is a slightly misleading nomenclature
            
            /*
            $test_query = 'INSERT INTO software 
            (
                softwareID, 
                sequenceNum, 
                title, 
                year, 
                publisherID, 
                country, 
                contributorID, 
                numberOfFiles, 
                insertedDate
            ) VALUES (
                1130, 
                2,
                "Maze Buster",
                1983,
                118,
                "Australia",
                80,
                0,
                2018-01-24
            )';
            */
            
            #TEST WORKS
            #$stmtAug = $conn->prepare($test_query);
            
            if ($_debug==2){
                #print_r($conn);
                echo $queryAugmentEntry.'<br>';
                print_r($conn->prepare($queryAugmentEntry));
                print_r($stmtAug);
            }
            
            #$stmtAug->execute();
            #exit();
            
            ##### ##### ##### ##### ##### ##### ##### ##### #####
            #ACCESS BIND PARMS using ARRAY ??
            $i = 0; #counter to access relevant bind parm from array $bindParms;
            
            #$echoQuery = $queryAugmentEntry;
            #echo $echoQuery.'<br>';
            
            #replace named parms with '?'s
            #$bindParmsABR = $bindParmsABR + array(count($bindParmsABR) => date('Y-m-d'));
            #$bindParmsABR []= date('Y-m-d');
            #$PDO_executionArray []= date('Y-m-d');
            
            /*
            echo '$executionArray:<br>';
            print_r($PDO_executionArray);
            echo '<br>';
            
            exit();
            */
            
            /*
            foreach($bindParmsABR as $k => $v){
                $queryAugmentEntry = str_replace($v, '?', $queryAugmentEntry);
            }
            
            echo $queryAugmentEntry;
            exit();
             */
            
            /*
            $arrayBind = FALSE;
            if ($arrayBind){
                $i = 0;
                foreach($newArray as $key => $val){    
                    #haystack, needle
                    #$s = strpos($queryAugmentEntry, $bindParms[$i]);
                    #echo $s.'<br>';

                    if (TRUE){#if bindParm was found
                        if ($_debug) echo 'binding '.$bindParms[$i].'...<br>';

                        #echo $newArray[$key];
                        #echo '<br>';
                        #echo $val;
                        #echo '<br>';

                        #$stmtAug->bindParam($bindParms[$i], $val);
                        $stmtAug->bindParam('?', $val);
                        #str_replace( ($bindParms[$i].''), $bindParms[$i], $echoQuery);
                        str_replace('?', $bindParms[$i], $echoQuery);

                        # replaces the first '?' found only ?
                    }
                    #debug confim binding order
                    $i++;
                }
            }
            */
            #### #### #### #### #### #### #### #### #### 
            # LOOPED BINDING with EVAL
            # Prepare each command then execute it 
            /**
            $i = 0;
            foreach($newArray as $k => $v){
                #note escaped single quotes
                echo $v.'<br>';
                $bindCmd = '$stmtAug->bindValue("'.$bindParmsABR[$i].'", '.$v.')';
                #echo $bindCmd.'<br>';
                eval($bindCmd);
                $i++;
            }
            */
            $echoQuery = $queryAugmentEntry;
            
            /*
            foreach($newArray as $k => $v){
                str_replace('?', $bindParms[$i], $queryAugmentEntry);
            }
            */
            
            #### #### #### #### #### #### #### #### #### 
            # MANUAL BINDING (uppercaseID)
            
            $stmtAug->bindParam(':sID', $newArray['softwareID']);
            $stmtAug->bindParam(':sqn', $newArray['seqNum']);
            $stmtAug->bindParam(':ttl', $newArray['title']);
            $stmtAug->bindParam(':yr', $newArray['year']);
            
            $stmtAug->bindParam(':augn', $newArray['authGivenName']);
            $stmtAug->bindParam(':augn1', $newArray['authGivenName1']);
            $stmtAug->bindParam(':augn2', $newArray['authGivenName2']);
            $stmtAug->bindParam(':augn3', $newArray['authGivenName3']);
            $stmtAug->bindParam(':augn4', $newArray['authGivenName4']);
            
            $stmtAug->bindParam(':aufn', $newArray['authFamilyName']);
            $stmtAug->bindParam(':aufn1', $newArray['authFamilyName1']);
            $stmtAug->bindParam(':aufn2', $newArray['authFamilyName2']);
            $stmtAug->bindParam(':aufn3', $newArray['authFamilyName3']);
            $stmtAug->bindParam(':aufn4', $newArray['authFamilyName4']);
            #14
            $stmtAug->bindParam(':pub',$newArray['publisher']); #if bind parm is not present nothign happens
            $stmtAug->bindParam(':pID', $publisherID);
            $stmtAug->bindParam(':cnt', $newArray['country']);
            $stmtAug->bindParam(':hwr', $newArray['hardwareReq']);
            $stmtAug->bindParam(':swr', $newArray['softwareReq']);

            $stmtAug->bindParam(':lic', $newArray['licenceList']);
            $stmtAug->bindParam(':des', $newArray['description']);
            $stmtAug->bindParam(':not', $newArray['notes']);
            
            $stmtAug->bindParam(':cfn', $newArray['contributorFamily']);
            $stmtAug->bindParam(':cgn', $newArray['contributorGiven']);
            $stmtAug->bindParam(':aad', $newArray['altAddress']);
            
            $stmtAug->bindParam(':cID', $newArray['contributorID']);
            $stmtAug->bindParam(':nof', $newArray['numberOfFiles']);
            $stmtAug->bindValue(':dte', date('Y-m-d') );
            
            
            $c1 = queryMaxSeqNumFromSoftware($softwareID,0);
            echo 'c1: '.$c1.'<br>';
            
            ##### ##### ##### ##### ##### ##### ##### ##### 
            #VALIDATE
            if ($_debug) _msgBox('g','$queryAugmentEntry with bind parms from array:<br>'.$queryAugmentEntry);
            #if ($_debug) _msgBox('y','$echoQuery:<br>'.$echoQuery);
            
            ##### ##### ##### ##### ##### ##### ##### ##### #####
            # INSERTION QUERY EXECUTE (date must be added before execution)
            /* TEST CASE
            INSERT INTO software 
            (
                softwareID, 
                sequenceNum, 
                title, 
                year, 
                publisherID, 
                country, 
                contributorID, 
                numberOfFiles, 
                insertedDate
            ) VALUES (
                1130, 
                2,
                "Maze Buster",
                1983,
                118,
                "Australia",
                80,
                0,
                2018-01-24
            ) 
             */
            /*
            $stmtAug->execute(array(
                1130,
                2,
                "Maze Buster",
                1983,
                118,
                "Australia",
                80,
                0,
                2018-01-24
            ));
            */
            
            #$stmtAug->execute($PDO_executionArray);
            $stmtAug->execute();
            #check entry/record count again
            $c2 = queryMaxSeqNumFromSoftware($softwareID,1);
            echo 'c2: '.$c2.'<br>';
            #simple validation that c2 = c1++
            validateIncrement($c1, $c2);
            #takes title as a parm to search for and validate existence in the DB
            validateNewTitleExistenceWithMaxSeqNum('Maze Buster', $c2); 
            #validateExistence($newArray['title'], $c2); 
            if ($_debug) _msgbox('#ccffcc','function complete...');
} 

/**
 * augmentSoftwareEntryTest
 * 
 * Augment some entries with identifiable attributes
 * Test for the existence of those attributes in a seperate query
 * Delete all those attributes
 * Capture Results
 * 
 * @param type $_Debug
 */
function _temp_augmentSoftwareEntryTest($_Debug){
    echo '<br>test Augment function entered...<br>';
    #$debug_string= '';
    if ($_debug) _msgBox('b', 'function: augmentSoftwareEntry<b>Test</b><');
    #$debug_string .= "function: augmentSoftwareEntry #test\n";
    
    GLOBAL $conn;
    GLOBAL $title, $year, $softwareID, $licence, $numberOfFiles, $publisherID,
            $contributorID;
    GLOBAL  $authorInputCount,
            $authorGivenName,
            $authorGivenName1,  
            $authorGivenName2,  
            $authorGivenName3, 
            $authorGivenName4,
            $authorFamilyName,
            $authorFamilyName1, 
            $authorFamilyName2, 
            $authorFamilyName3, 
            $authorFamilyName4,
            $contributorFamily, $contributorGiven,
            $publisher, $country, $hardwareReq, $softwareReq, 
            $description, $notes,
            $altAddress, $filesNum;
    GLOBAL $seqNum;
    
    if ($_debug) echo 'softwareID: '.$softwareID.'<br>';
    $debug_string .= "softwareID: ".$softwareID."\n";
    if ($_debug) echo 'sequenceNum: '.$seqNum.'<br>';
    $debug_string .= "sequenceNum: ".$seqNum."\n";
    
    
    $queryAugmentEntry = 'INSERT INTO software ('
        . 'softwareID, '
        . 'sequenceNum, '
        . 'title, '
        . 'year, '
        . 'description, '
        . 'notes, '
        . 'hardwareReq, '
        . 'softwareReq, '
        . 'licenceList, '
        . 'numberOfFiles, '
        . 'insertedDate, '
        . 'publisherID, '
        . 'contributorID, '
        . 'country ';

    $queryAugmentEntry .= ') VALUES (';
        $queryAugmentEntry.=':a, ';
        $queryAugmentEntry.=':b, ';
        $queryAugmentEntry.=':c, ';
        $queryAugmentEntry.=':d, ';
        $queryAugmentEntry.=':e, ';
        $queryAugmentEntry.=':f, ';
        $queryAugmentEntry.=':g, ';
        $queryAugmentEntry.=':h, ';
        $queryAugmentEntry.=':i, ';
        $queryAugmentEntry.=':j, ';
        $queryAugmentEntry.=':k, ';
        $queryAugmentEntry.=':l, ';
        $queryAugmentEntry.=':m, ';
        $queryAugmentEntry.=':n ';
        $queryAugmentEntry.=')';
    echo '$queryAugmentEntry: '.$queryAugmentEntry;
    $insertedDate = '"'.date("Y-m-d").'"';
    $insertionValues = array();#synch the use of the two arrays
    $insertionColumns = array();
    $insertionVars = array();
    
    #a, swID
    if(!is_null($softwareID) && ($softwareID!='')){
        $insertionColumns[]= 'softwareID'; # like x+=10 is same as x = x+10, 
        $insertionValues[]= ':a';
        $insertionVars[]= $softwareID;
    } else {
        $insertionVars[]= null;
    }
    #b, seqNum
    if(!is_null($seqNum) && ($seqNum!='')){
        $insertionColumns[]= 'seqNum'; #note no $ symbol
        $insertionValues[]= ':b';
        $insertionVars[]= $seqNum;
    }
    
    #c,title
    if(!is_null($title) && ($title!='')){
        $insertionColumns[]= 'title'; #note no $ symbol
        $insertionValues[]= ':c';
        $insertionVars[]= $title;
    }
    
    #d,yr
    if(!is_null($year) && ($year!='')){
        $insertionColumns[]= 'year'; #note no $ symbol
        $insertionValues[]= ':d';
        $insertionVars[]= $year;
    }
    
    #e,desc
    if(!is_null($description) && ($description!='')){
        $insertionColumns[]= 'description'; #note no $ symbol
        $insertionValues[]= ':e';
        $insertionVars[]= $description;
    }
        
    #f,notes
    if(!is_null($notes) && ($notes!='')){
        $insertionColumns[]= 'notes'; #note no $ symbol
        $insertionValues[]= ':f';
        $insertionVars[]= $notes;
    }
    
    #g,HWReq
    if(!is_null($hardwareReq) && ($hardwareReq!='')){
        $insertionColumns[]= 'hardwareReq'; #note no $ symbol
        $insertionValues[]= ':g';
        $insertionVars[]= $hardwareReq;
    }
    
    #h,swReq
    if(!is_null($softwareReq) && ($softwareReq!='')){
        $insertionColumns[]= 'softwareReq'; #note no $ symbol
        $insertionValues[]= ':h';
        $insertionVars[]= $description;
    }
    
    #i,licenceList
    if(!is_null($licence) && ($licence!='')){
        $insertionColumns[]= 'licenceList'; #note no $ symbol
        $insertionValues[]= ':i';
        $insertionVars[]= $licence;
    }
    
    #j,numberOfFiles
    if(!is_null($numberOfFiles) && ($numberOfFiles!='')){
        $insertionColumns[]= 'numberOfFiles'; #note no $ symbol
        $insertionValues[]= ':j';
        $insertionVars[]= $numberOfFiles;
    }
    
    #k,insertedDate
    if(!is_null($insertedDate) && ($insertedDate!='')){#always true !
        $insertionColumns[]= 'insertedDate'; #note no $ symbol
        $insertionValues[]= ':k';
        $insertionVars[]= $insertedDate;
    }
    
    #l,publisherID
    if(!is_null($publisherID) && ($publisherID!='')){
        $insertionColumns[]= 'publisherID'; #note no $ symbol
        $insertionValues[]= ':l';
        $insertionVars[]= $publisherID;
    }
    
    #m,contibutorID
    if(!is_null($contributorID) && ($contributorID!='')){
        $insertionColumns[]= 'contibutorID'; #note no $ symbol
        $insertionValues[]= ':m';
        $insertionVars[]= $contributorID;
    }
    
    #n,Country
    if(!is_null($country) && ($country!='')){
        $insertionColumns[]= 'country'; #note no $ symbol
        $insertionValues[]= ':n';
        $insertionVars[]= $country;
    }
    
    #iterate over both arrays to add relevant col names and varaiables
    $size = count($insertionColumns);
    if ($_debug) echo '<hr>';
    ########################################################################################################################
    
    $stmt = $conn->prepare($queryAugmentEntry);
    echo '$stmt: ';
    echo '<br>';
    
    #EXECUTE with array 
    if ($_debug) echo '<br><b>printing data array<br>';
    
    $stmt->bindParam(':a',$softwareID);
    $stmt->bindParam(':b',$seqNum);
    $stmt->bindParam(':c',$title);
    $stmt->bindParam(':d',$year);
    
    $stmt->bindParam(':e',$description);
    $stmt->bindParam(':f',$notes);
    $stmt->bindParam(':g',$hardwareReq);
    $stmt->bindParam(':h',$softwareReq);
    
    $stmt->bindParam(':i',$licenceList);
    $stmt->bindParam(':j',$numberOfFiles);
    $stmt->bindParam(':k',$insertedDate);
    $stmt->bindParam(':l',$publisherID);
    
    $stmt->bindParam(':m',$contributorID);
    $stmt->bindParam(':n',$country);
    #VALIDATE
    $c = queryMaxSeqNumFromSoftware($softwareID,1);
    echo 'seqNum was = '.$c.'<br>';
    $stmt->execute();
    $c = queryMaxSeqNumFromSoftware($softwareID,1);
    echo 'seqNum now = '.$c.'<br>';
    echo 'should have incremented by 1 after execute statement...<br>';
    
    if ($_debug) echo '<font color="green">TEST function complete...</font><br>';
    
    #write DEBUG
    #writeToFileTXT($debug_string);
}

/**
 * 
 * Suppliment function for testing
 * 
 * @param type $_givName
 * @param type $_famName
 * @param type $_debug
 * 
 * @return type void
 */
function _temp_insertToAuthorTableForTest($_givName, $_famName){
    global $conn;
    # INSERT INTO AUTHOR #
    $query = "INSERT INTO author (givenName, familyName) VALUES (:gn, :fn)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':gn', $_givName);
    $stmt->bindParam(':fn', $_famName);
    $stmt->execute();
    #_msgBox('g', 'test insert function complete...');
}

/**
 * Insert Contributor by ID
 *
 * return  0 if failed, returns 1 if successful
 */
#int @@@
function _temp_insertContributor($_debug)
{
    /* insert Contributor
     * As contributorID, familyName, givenName, emailAddress is entered
     * into the following tables: contributor...
     * It seems contributorID needs to be read and incremented manually ?
    */

    global $conn, $altAddress;
    $debug_string = "";

    /* is this needed ? count rows can be dome with select MAX(unique id col) from TABLE...
        when would we want to count all rows ? */

    /* this function throws the error - can not redeclare function already defined in
     * /Applications/MAMP/htdocs/dev/ADHD/includes/ADHD_newEntry_functions.php:522) in
     * FUNCTION countRows($table){
        global $conn,$DEBUG;

        $DEBUG = 1;

        $queryCount = 'SELECT MAX(*) FROM :table';
        $queryCount = str_replace($queryCount, ':table', $table);
        echo 'new query: '.$queryCount.'<br>';
        $resultsCount = $conn->query($queryCount);

        if($DEBUG){
            echo $table.' count results: ';
            echo $resultsCount;
            echo '</b>';
            echo '<br>';
        }
        return $resultsCount;
    }
    */

    # Test for EXISTENCE
    
    $queryContributor = 'SELECT familyName, contributorID FROM contributor WHERE emailAddress = :e';
    $stmtCon = $conn->prepare($queryContributor);
    $stmtCon->bindParam(':e', $altAddress);
    $stmtCon->execute();
    $contributorExists = $stmtCon->fetch(PDO::FETCH_ASSOC);

    $debug_string .= "\nget contributor Family name from email address: \n";
    $debug_string .= $contributorExists;
    $debug_string .= "\n";

    $debug_string .= "$contributorExists\['familyName\'\]: ".$contributorExists['familyName'];
    $debug_string .= "\n";

    IF (!$contributorExists) {# NEW CONTRIBUTOR #

        /* Result of 0 rows indicates there was no contributor in the database already
        (with the email address specified) (zero results returned from a query)
        -  ie a new contributor is being entered */

        $contributorFamily = $_POST['contributorFamily'];
        $contributorFamily = clean($contributorFamily);
        $contributorGiven = $_POST['contributorGiven'];
        $contributorGiven = clean($contributorGiven);

        if ($contributorFamily != '') { #redundant check
            /* if familyName field is not left blank,
            (it cannot be left blank as it is a mandatory field) insert it into the DB
            */

            # insert content into contributor table
            $insertContributorSQL = "INSERT INTO contributor (givenName, familyName, emailAddress)
VALUES (:gn, :fn, :e)";

            #count before insertion
            $count_contrib_SQL = "SELECT COUNT(contributorID) FROM contributor"; //this works as there is only one ID per row
            #id is a primKey
            $resultsCount = $conn->query($count_contrib_SQL)->fetchColumn();
            echo '$resultsCount: ' . $resultsCount . '<br>';
            #$stmt6_count_pre = countRows('contributor');
            $stmt6 = $conn->prepare($insertContributorSQL);
            $stmt6->bindValue(':gn', $contributorGiven);
            $stmt6->bindValue(':fn', $contributorFamily);
            $stmt6->bindValue(':e', $altAddress);
            $stmt6->execute();

            $debug_string .= "\ncontributor ".$contributorFamily ." added, need to validate successful entry...";
            $debug_string .= "\n";
            # Test results with a count of contributors before and after
            /*
            $stmt6_count_post = countRows('contributor');
            if($stmt6_count_pre == $stmt6_count_post){
                echo 'error: rowCount before and after contributor table data insert are identical<br>';
            }

            if($stmt6_count_pre+1 === $stmt6_count_post){
                echo 'pre insert rowCount is one less that post insert row count: insertion successful<br>';
            }
            */
        }
    } ELSE {
        /* contributor (email, and thus givenName, ID) ALREADY EXISTS -> when inserting into software
        table, & use the appropriate contributorID for the existing contributor */
        $debug_string .= "contributor already exists\n";
        $contributorIDInsert = $contributorExists['contributorID'];
        # we already have queried this info - no need for a whole new query
        $debug_string .= "\ncontributorInsertID: " . $contributorIDInsert . "\n";
        $debug_string .= "\n(contributorID required when inserting software into into the DB (software title)...\n";
    }
}

/**
 * queryCountContributor
 * 
 * from contributor table
 * 
 * @global type $conn
 * @return type int
 */
function _temp_queryCountContributor(){
    _msgBox('r', 'function DEPRECATED');
    exit();
    
    global $conn;
    $queryCount = 'SELECT count(contributorID) from contributor';
    $result = $conn->query($queryCount)->fetchColumn();/* note the different PDO data access method 'fetchColumn'  used here */
    if ($result){
        if ($_debug) _msgBox('g', 'queryCountContributor() successful');
        return $result;
    } else {
        _msgBox('red', 'queryCountContributor() is broken ? count should be > 0, line 2138');
        exit();
    }
}

/**
 * 
 * Test strategy:
 * 
 * get a bunch of known titles
 * store their IDs in an array, then loop over the 
 * array of IDs and check the titles
 * 
 * time ?
 * get titles randomly ?
 * edge cases would be better
 * 0,1
 * 1 million
 * 500, 000
 * 
 * test Cases
 * ----------
 * long titles vs
 * short titles shouldn't make a difference
 * what is the maximum - do we have a data dictionary
 * 
 * limitations of data entered must be documented somewhere 
 *
 * * titles with unorthodox characters *
 * titles with spaces
 * titles with under scores
 * titles with ampersands (&)
 * 
 * ## PROBLEM with this strategy is that 
 * there are several titles that have the same name
 * and can only be distinguished from more attributes ie 
 * publisherID or seqNum
 * 
 * @return int 1 is pass, 0 is fail
 * 
 * @param type $_debug
 */
FUNCTION _temp_querySoftwareIDFromTitle_tests_version1_($_debug){
    
    _msgBox('b', 'querySoftwareIDFromTitle_tests('.$_debug.')...');
    
    $max = 100;# queries / samples
    /*
    #test 1 arbitrary titles
    $testTitleArray = array(
        'Castle of Terror'              => 0,
        'Laser Hawk'                    => 0,
        'Sorceror\'s Apprentice'        => 0,
        'Prediction of Hourly Tide Heights'=> 0,
        'Horace Goes Skiing'            => 0,
        'OPM'                           => 0,
        'OPM'                           => 0,
        'The Way of the Exploding Fist' => 0,
        'The Way of the Exploding Fist' => 0,
        'The Hobbit'                    => 0,
        'The Hobbit'                    => 0,
        'Horace and the Spiders'        => 0,
        'Hungry Horace'                 => 0,
        'Kwah!'                         => 0,
        'Roadwars'                      => 0,
        'Zim Sala Bim'                  => 0,
        'Aaargh!'                       => 0,
        'Asterix and the Magic Cauldron' => 0,
        'Barbarian'                     => 0,
        'Bazooka Bill'                  => 0,
        'Bopn Rumble'                   => 0,
        'Bopn Wrestle'                  => 0,
        'Classic Adventure'             => 0,
        'The Dark Tower'                => 0,
        'Doc the Destroyer'             => 0,
        'Dodgy Geezers'                 => 0,
        'Double Dragon'                 => 0,
        'Fellowship of the Ring'        => 0,
        'Fighting Warrior'              => 0,
        'Fist II: The Legend Continues' => 0
    );
    */
    /*
    $testTitleArray_titlesOnly = array(
        'Castle of Terror'              ,
        'Laser Hawk'                    ,
        'Sorceror\'s Apprentice'        ,
        'Prediction of Hourly Tide Heights',
        'Horace Goes Skiing'            ,
        'OPM'                           ,
        'OPM'                           ,
        'The Way of the Exploding Fist' ,
        'The Way of the Exploding Fist' ,
        'The Hobbit'                    ,
        'The Hobbit'                    ,
        'Horace and the Spiders'        ,
        'Hungry Horace'                 ,
        'Kwah!'                         ,
        'Roadwars'                      ,
        'Zim Sala Bim'                  ,
        'Aaargh!'                       ,
        'Asterix and the Magic Cauldron',
        'Barbarian'                     ,
        'Bazooka Bill'                  ,
        'Bopn Rumble'                   ,
        'Bopn Wrestle'                  ,
        'Classic Adventure'             ,
        'The Dark Tower'                ,
        'Doc the Destroyer'             ,
        'Dodgy Geezers'                 ,
        'Double Dragon'                 ,
        'Fellowship of the Ring'        ,
        'Fighting Warrior'              ,
        'Fist II: The Legend Continues'
    );
    */
    #test 1 arrays
    $randTitles = array();
    $randValues = array();
    /* WHITELIST
    $randAssoc = array(
        'Jumpman'           => 867,
        'Simple Programs 2' => 362
        
    );
     * */
    $randAssocArray = array();
    $retrievedIDs = array();
    
    #test2 arrays
    $assoc = array();
    
    echo '<font color="blue">';
    #assuming there are 1975 titles in the database
    $counter = 0;
    
    #print_r($randAssoc);
    $blacklist = array(638,366,1119,1195,207,1200,805,135 );
    
    for($n=0;$n < $max;$n++){
        echo $n.'<br>';
        #black listed ids#$_id;
        #generate random ID
        $_id = rand(1,1975);#echo $n.'<br>';#echo $_id.' ';
        echo 'id: '.$_id.'<br>';
        
        #HANDLE BLANK TITLES FOR TESTING by filtering known blank titles 
        /** currently a blank title cannot be assoc with one ID
         * as several titles in the DB are blank
         * while loop ensures that 
         * 1. ids are not duplicated,
         * (if rand gen id is already pushed onto the $randAssoc array
         * or if its in the black list(blank titles) - then make a new one)
         * 
         * 2. ids are not in the blacklisted array
         * 
         * a black listed array has been created to ensure 
         * that ... ? 
         * 
         * 3. ids are not associated with blank titles
         *  blank titles are not useful for testing
         */
        
        $_title ='';
        $counter = 0;
        while(  (in_array($_id, $blacklist))                     || 
                (in_array($_id, array_values($randAssocArray)))  ||
                ($_title = (querySoftwareTitleFromSW($_id, 0)) == '')
                ){ 
                    #echo 'title: '.$_title.'<br>';
                    $msg = 'rand gen id'.$_id.' was in blacklist, '
                            . 'or retrieved title was blank(:'.$_title.'), making a new one';
                    $msg = 'bad_id#'.$counter.'<br>';
                    #$msg = '';

                    _msgBox('o', $msg);
                    $_id = rand(1,1975);#echo $n.'<br>';#echo $_id.' ';
        }
        $_title = querySoftwareTitleFromSW($_id, 0);
        #echo $_title.'<br>';
        
        #already checked for this case...
        if($_title==''){
            _msgBox('r', 'fn: querySoftwareIDFromTitle_tests: '
                    . 'something very wrong with detecting blank titles '
                    . 'assoc with softwareIDs<br>');
            exit();
        }
        
        $randAssocArray = _assocPush($randAssocArray, $_title, ((string) $_id)); #id pushed as a string
        
        $randTitles[]= $_title;
        $counter++;
    }#end for loop
    echo '</font>';
    
    #echo 'after first loop<br>';
    
    print_r($randAssocArray);
    #displayDataInTableFromAssocArray($randAssoc, 'red', 0);
    #displayTitleDataInTableFromAssocArray($randAssoc);
    
    #$randTitles = array_keys($randAssoc);
    #$randValues = array_values($randAssoc);
    
    echo 'table1: titles(keys) pulled Titles from DB<br>';
    echo '<table border="1"><tr><td>';#outer table
    
        echo '<table border="1">';
        #DISPLAY array keys and associated Values
        foreach($randAssocArray as $k => $v){
            echo '<tr><td>';
            echo $k;
            echo '</td>';
            echo '<td>';
            echo $v;
            echo '</td>';
            echo '</tr>';
        }
        echo '</table>';
    echo '</td>';
    
    #PULL VALUES (swID's) FROM DB USING THE RETRIEVED NAMES
    /* Query results with multiple ids are now concatenated as strings 
     * for testing and strings are compared for validlation
     */
    echo 'PULLED swID\'s FROM DB<br>';
    for($n =0;$n < $max;$n++){
        #echo $n.'<br>';
        $_id_string = '';
        $_title = $randTitles[$n];
        
        #skip blank titles for now
        if ($_title == ''){
            $_id_string = '#';
            _msgBox('o','<br>Articifial id_string \'#\' used...<br>');#make the adjustment in the original ids as well 
            #so the arrays can still match
        } else {
            #nested LOOPS
            foreach(querySoftwareIDsFromTitle($_title, 0) as $_id){# 0 = no verbose output
                #$_id = 9999;
                #echo 'Q-ret id:'.$_id.'<br>';
                $_id_string .= ((string) $_id);   
            }
        }
        $retrievedIDs[]= $_id_string;
    }#end second loop
    
    #print_r($retrievedIDs);
    #exit();
    /**
     * now $retrievedIDs[] is full of ids that should 
     * match the original ids 
     * generated by the random function (bar the proxies)
     */
    $origIDs = array_values($randAssocArray); #get the id's only
    #should inherit the articficial 9999 ID's
    #print_r($origIDs);
    #exit();
        
        echo '<br>Table2: ids(values) pulled from DB<br>';
        echo '...then matched with original random keys<br>';
        echo '<td><table border="1">';
        #DISPLAY keys and values in a bale for comparison
        $counter = 0;
        $mismatches = 0;
        foreach($randAssocArray as $k => $v){
            echo '<tr><td>';
            echo $k; #title
            echo '</font></td>';
            if((string)$origIDs[$counter]!=$retrievedIDs[$counter]){
                $mismatches++;
                echo '<td style="';
                echo 'background-color: orange;';
                echo '">';
            } else {
                echo '<td style="';
                echo 'background-color: #ccffcc;';
                echo '">';
            }
            echo $retrievedIDs[$counter];
            echo '</font></td>';
            echo '</tr>';
            $counter++;
        }
        echo '</table>';
    
    #outer table
    echo '</td></tr></table>';
    
    #@@TEST 1 #compare the two arrays
    #$t1 = myAssertQ(($retrievedIDs === $origIDs), 'ID arrays <br> (rand gen and retrieved from DB)<br>'
     #       . 'do not match ! serious problem');
    
    ECHO '$mismatches: '.$mismatches.'<BR>';
    $PC = 100 - (($mismatches/$counter)*100);
    echo ' out of '.$counter.' queries<br>';
    _msgBox('g', 'match rate = '.round($PC,2).'%');
    /*
     * TEST WITH TIMER (USING PHP MICROTIME FUNCTION)
    #array_merge($testTitleArray, $randTitles);
    #displayDataInSimpleTableFromAssocArray($testTitleArray);
    $rounds     = 1;
    $totalTime  = 0;
    $execTime   = 0;
    
    
    ##### ##### ##### ##### ##### ##### ##### ##### ##### 
    echo 'arrayCount: '.count($testTitleArray);
    echo '<br>';
    
    $totalTime = 0;
    
    $counter = 0;
    foreach ($testTitleArray as $k => $v){
        $timePre = microtime(true);
        $counter+=1;
        $id = querySoftwareIDsFromTitle($k, 0);
        #echo $counter.':'.$id.'<br>';     
        #insert into assoc array retrieved id's
        $assoc[$k] = $id;
        
        $timePost = microtime(true);
        $execTime = $timePost - $timePre;
        $totalTime += $execTime;
    }
    #verify IDs
    $titleResultsArray = array();    
    foreach($assoc as $k => $v){
        $timePre = microtime(true);
        $qTitle = querySoftwareTitleFromSW($v, 0);
        if ($_debug) echo $qTitle.'<br>';
        $titleResultsArray[]= $qTitle;
        
        $timePost = microtime(true);
        $execTime = $timePost - $timePre;
        $totalTime += $execTime;
    }
    
    # compare original array of titles with retrieved titles
    # they should be identical
    _msgBox ('#ccccff', 'comparing results...');
    
    if ($_debug){
        print_r($testTitleArray);
        #print_r($testTitleArraySmall);
        echo '<br>##### ##### ##### ##### ##### ##### ##### ##### <br>';
        print_r($titleResultsArray);
    }
    
    #@@TEST 2 # compare with php comparator
    $t2 = myAssertQ(($titleResultsArray === array_keys($testTitleArray)),'key error');
    
    #OVERALL UNIT TEST RESULT (SUMMED RESULTS OF MULTIPLE TESTS)
    if ($t1+$t2 != 0){            
        _msgBox ('#red', 'queryTitleID UNIT TEST failed !');    
    } else {
        
        _msgBox ('#ccccff', 'queryTitleID verification finished...');
        _msgBox ('#ccffcc', 'queryTitleID UNIT TEST finished !');    
        
        #$TOTAL TIME
        _msgBox('y', ('totalTime: '.(round($totalTime*1000, 3)).'ms') );
        _msgBox('y','<br>for '.(count($testTitleArray)*2).' queries.');
    }
    #displayDataInTable($testResults);
    #displayDataInTableFromAssocArray($assoc, 'whitesmoke',1);
    }
    */
}

/**
 * 
 * inject country data
 * 
 * @param array $variable_assoc_array
 * @return string
 */
function _t_injectTestCountryData($variable_assoc_array){
    $variable_assoc_array['country'] = 'Australia';
    return $variable_assoc_array;   
}


/**
 * INJECT TEST DATA into the country field
 */

function _temp_field_country_inject(){
   GLOBAL $country;

   echo '<label for="country" id="modifyEntryLabels"> Country: </label>';
   echo '<SELECT class="sel1" name="country">';
        
}
    
/**
 * Display Title and Year
 * void
 */
function _temp_displayTitleAndYear(){
    if (!is_null($title) && !empty($title)) {
        $titleTemp = $title;
    }

    #PRINT TITLE AND YEAR of the specific softwareID title
    echo '<h3 id="headerTitle" style=';
    echo 'margin-left: 50px;';
    echo '">';

    if (!is_null($year) && !empty($year)) {
        echo $titleTemp . " | ";
        echo $year;
    } else {
        echo $titleTemp;
    }
    echo '</h3>';
    #echo "<div><p>";
}

/**
 * _t_insertAuthorsToAuthorSoftwareByIDArray_test
 * 
 * IMPORTANT ! 
 * NB this test tests insertion to the author_software table ONLY,
 * not author_software *AND* AUTHOR tables together
 * 
 * @global type $conn
 */
FUNCTION _t_insertAuthorsToAuthorSoftwareByIDArray_test($_debug){
    if($_debug) _msgBox('b', 'insertAuthorsToAuthorSoftwareByIDArray_test...');
    global $conn;
    
    $test_authorIDs = array();
    /*
     * 1 Andrew Bradfield
     * 3 Bruce Hamon
     * 5 Greg Barnett
     * 7 Veronika Megler
     * 9 Henderson Robert * seems names are reversed *email denise on this
     */
    
    #estalblished names for specified IDs\
    /*
    $test_authorNames = [
        'Andrew Bradfield',
        'Bruce Hamon',
        'Greg Barnett',
        'Veronika Megler',
        'Henderson Robert'
    ];
    */
    $test_newAuthors = array();
    $testEntryCount = 25; #@@@ to do shift to function parm
    $ins_gn = '';
    $ins_fn = '';
    
    #insert some fake authors #shift this query to dedicated function
    # get max authID and add an offset for easily identifying test entries
    $q = 'select max(authorID) from author_software';
    $maxID = $conn->query($q)->fetchColumn();
    $origCount = $maxID;
    $offset = 9000;
    $maxID += $offset;
    echo 'initial count '.$maxID.'<br>';
    
    # GENERATE RANDOM AUTHOR NAMES, append to array $test_newAuthors, $test_authorIDs
    for($n=0;$n<$testEntryCount;$n++){
        #echo 'fakeName()'.fakeName().'<br>';
        #$ins_gn = fakeName();
        #$ins_fn = fakeName();
        
        $ins_gn = randAuthName('g');
        $ins_fn = randAuthName('f');
        
        if ($_debug){
            echo 'rand name for insertion: ';
            echo $ins_gn.' '.$ins_fn;
            echo '<br>';
        }
        $test_newAuthors[]= ($ins_gn.' '.$ins_fn);
        
        $maxID++;
        $test_authorIDs[]=$maxID;
        #echo 'authID test array for data insertions ';
    }
    echo 'array of ids<br>';
    # print_r($test_authorIDs);
    # INSERT TO AUTHOR-SOFTWARE
    # SOFTWARE ID HARD CODED FOR INITIAL TESTING
    #insertAuthorsToAuthorSoftwareByIDArray($test_authorIDs, 2, 1);
    
    # VALIDATE by querying last 3 entries in author_software for IDs
    $retrievedIDs =array();
    $maxID = $conn->query($q)->fetchColumn(); #counting on the same table
    $maxID -= $testEntryCount; #roll vlue back to count before insertion of testIDs
    
    for($n = 0;$n<$testEntryCount;$n++){
        $maxID++;
        #echo 'authID'.$maxID.'<br>';
        $retrievedIDs[]=$maxID; #push to array
    }
    # myAssertQ(($retrievedIDs ===  $test_authorIDs),'error compaing arrays of authorIDs');
    
    if($retrievedIDs ===  $test_authorIDs){
        _msgBox('g', 'initial rand names match names pulled from DB');
        _msgBox('green', 'author insertion VALIDATED');
    } else {
        _msgBox('o', 'initial rand names DO NOT match names pulled from DB');
        _msgBox('red', 'author insertion VALIDATION FAILED');
    }
    
    _msgBox('grey', 'cleanup - delete the new test entries');
    /**
     * simple clean - delete all entries with id above 9000 (our offset)
     * ideally shift this to a cleaner function
     */
    $QCleanup = "DELETE FROM author_software WHERE authorID >= :x";
    $stmtDel = $conn->prepare($QCleanup);
    $stmtDel->bindParam(':x', $offset);
    $stmtDel->execute();
    
    _msgBox('o', 'entries with ID > 9000 deleted');
    
    $newMaxID = $conn->query($q)->fetchColumn(); #counting on the same table
    
    #$_debug = 1;
    #feedback
    if($_debug){
        echo '<table width="50%">';
        echo '<tr><td>';
        echo 'MaxID before insertion: ';
        echo '</td><td>';
        echo $origCount;
        echo '</td></tr><tr><td>';
        echo 'Entries inserted: ($testEntryCount): ';
        echo '</td><td>';
        echo $testEntryCount;
        echo '</td></tr><tr><td>';
        echo 'MaxID before deletion(-offset): ';
        echo '</td><td>';
        echo $maxID-$offset;
        echo '</td></tr><tr><td>';
        echo 'NewMaxID after deletion: ';
        echo '</td><td>';
        echo $newMaxID;
        echo '</td></tr>';
        echo '</table>';
        #echo ($newMaxID - $maxID).'entries deleted...<br>';
    }
    
    #VALIDATE DELETION -> author IDs should not exist
    #_msgBox('o', 'auth_soft.author count increment validated only ');
    _msgBox('y', 'function insertAuthSoftware_test complete');
}

/**
 * 
 * displayDataInTableWithChanges
 * 
 * @param type $_debug
 * @param type $changes
 * 
 * @global type $tableBorderToggle1
 * @global type $tableBorderColour1
 * @global type $title
 * @global type $softwareID
 * @global type $year
 * @global type $familyName
 * @global type $givenName
 * @global type $publisherName
 * @global type $country
 * @global type $licenceList
 * @global type $hardwareReq
 * @global type $softwareReq
 * @global type $description
 * @global type $notes
 * 
 */
FUNCTION _temp_displayDataInTableWithChanges($_changes, $_debug){
    
    global $tableBorderToggle1;
    global $tableBorderColour1;
    
    global $title, $softwareID, $year, $familyName, $givenName, $publisherName, $country, $licenceList;
    global $hardwareReq, $softwareReq, $description, $notes;
    
    #global $seqNum;
    if ($_debug) echo 'fn: displayDataInTable...<br>';

    echo '<a href="ADHD_modifyEntry.php?id='.$softwareID.'" style="line-height: 4em;">';

    #Link engages CSS styling
    echo '<p>'.$title;
    if(     !is_null($year) && !empty($year)   &&
            ($year != 0)){ 
        #reflect chanes to year ?
        /**
         * if changes contains 'year', diaply it differently
         */
        echo " | ".$year;
    }
    echo '</a>';

    /** if title is returned from our CRUD op then show it */
    #TABLE OF RESULTS
    echo '<p><table border="' . $tableBorderToggle1 . '" 
        style="
        border-color: ' . $tableBorderColour1 . ';
        border-top: none;
        border-bottom: none;
        border-left: none;
        border-right: none;
        ">';

    #print_r($_changes);
    
    /** we don't need to show title ? as we are already modifying an existing title  */
    if(!is_null($title) && !empty($title)){
      echo '<tr>'
      .'<td width="25%" style="'
      .'font-size: 13;'
      #highligh changed data
      .'">';
      
      if (in_array('title', $_changes)){
          #echo '*';
          echo 'New ';
      }
          
      echo "<b>Title: </b>"
      .'<td width="75%" style="font-size: 13;">'
      .$title
      .'</td></tr>';
    }

    /* if year is returned from CRUD ops then show it */
    if (!is_null($year) && !empty($year)) {
        echo '<tr>';
        echo '<td width="25%" style="font-size: 13;">';
        
        if (in_array('year', $_changes)){
            echo 'new ';
        }
        
        echo "<b>Year: </b>";
        echo '<td width="75%" style="font-size: 13;">';
        echo $year;
        echo '</td></tr>';
    }

    /* if both family name and given name are returned from our CRUD op then show them */
    if (!is_null($familyName) && !empty($familyName) ||
            !is_null($givenName) && !empty($givenName)) {
        $familyNameArr = explode(",", $familyName); //explode is the same as string split in a loop with a delimiter
        $givenNameArr = explode(",", $givenName);

        $fullNameArr = array();
        for ($i = 0; $i < sizeOf($givenNameArr); $i++) {
            $fullNameArr[$i] = $givenNameArr[$i] . " " . $familyNameArr[$i];
        }/* implode: join arr elements with a string, DEALS with multiple authors */

        $fullNameArrTemp = implode(", ", $fullNameArr);
        echo '<tr><td width="25%" style="font-size: 13;">';
        echo "<b>Author(s): </b>";
        echo '<td width="75%" style="font-size: 13;">';
        echo $fullNameArrTemp;
        echo '</td></tr>';
    }

    /* if publisherName is returned from our CRUD op then show it */
    if (!is_null($publisherName) && !empty($publisherName)) {
        echo '<tr><td width="25%" style="font-size: 13;">';
        echo "<b>Publisher: </b>";
        echo '<td width="75%" style="font-size: 13;">';
        
        if (in_array('publisherName', $_changes)){
            echo 'new ';
        }
        
        echo $publisherName;
        echo '</td></tr>';
    }

    /** if country is returned from our CRUD op then show it */
    if (!is_null($country) && !empty($country)) {
        echo '<tr><td width="25%" style="font-size: 13;">';
        echo "<b>Country: </b>";
        echo '<td width="75%" style="font-size: 13;">';
        
        if (in_array('country', $_changes)){
            echo 'new ';
        }
        echo $country;
        echo '</td></tr>';
    }

    /** 
     * handle '...not chosen' case -> 
     * don't display anything instead of displaying '...not chosen'
     * 
     * if licenceList is returned from our CRUD op then show it 
     * and test if LicenceList is != "LicenceList was not chosen"
     * || "licence not chosen"
     * 
     * (shouldn't need both test cases...should only have one bad data form)
     */
    
    if( ($licenceList=='LicenceList was not chosen') || 
        (#$licenceList=='licence was not chosen'
          $licenceList==''
        )){
        
        #todo
        echo '<tr><td width="25%" style="font-size: 13;">';
        if (in_array('licenceList', $_changes)){
            echo 'new ';
        }
        
        echo "<b>Licence: </b>";
            
        #todo change the entry to null or '' (blank string)
    } else {
        #this check only done if data != "not chosen"
        if (!is_null($licenceList) && !empty($licenceList)) {
            echo '<tr><td width="25%" style="font-size: 13;">';
            
            if (in_array('licenceList', $_changes)){
                echo 'new ';
            }
        
            echo "<b>Licence: </b>";
            echo '<td width="75%" style="font-size: 13;">';
            echo $licenceList;
            echo '</td></tr>';
        }
    }

    if (!is_null($hardwareReq) && !empty($hardwareReq)) {
        echo '<tr><td width="25%" style="font-size: 13;">';
        
        if (in_array('hardwareReq', $_changes)){
            echo 'new ';
        }
        
        echo "<b>Hardware Req's: </b>";
        echo '<td width="75%" style="font-size: 13;">';
        echo $hardwareReq;
        echo '</td></tr>';
    }
    
    #handle 'N/A' case -> dont display anything instead of displaying 'N/A'
    IF ($softwareReq == 'N/A'){
        echo '<tr><td width="25%" style="font-size: 13;">';
        if (in_array('softwareReq', $_changes)){
            echo 'new ';
        }
        echo "<b>Software Req's: </b>";
            
    } else {
        if (!is_null($softwareReq) && !empty($softwareReq)) {
            echo '<tr><td width="25%" style="font-size: 13;">';
            
            if (in_array('softwareReq', $_changes)){
                echo 'new ';
            }
        
            echo "<b>Software Req's: </b>";
            echo '<td width="75%" style="font-size: 13;">';
            echo $softwareReq;
            echo '</td></tr>';
        }
    }

    if (!is_null($description) && !empty($description)) {
        echo '<tr><td width="25%" style="font-size: 13;">';
        if (in_array('description', $_changes)){
            echo 'new ';
        }
        echo "<b>Description: </b>";
        echo '<td width="75%" style="font-size: 13;">';
        echo $description . '</td><br>';
        echo '</td></tr>';
    }

    if (!is_null($notes) && !empty($notes)) {
        echo '<tr><td width="25%" style="font-size: 13;">';
        if (in_array('notes', $_changes)){
            echo 'new ';
        }
        echo "<b>Notes: </b>";
        echo '<td width="75%" style="font-size: 13;">';
        echo $notes;
        echo '</td></tr>';
    }
    echo '</table>';
    #echo '</table>';

    if ($_debug) echo 'fn: displayDataInTable($_'
        . 'debug) complete...<br>';
    }
    
    /**
 * $n is the seqNum
 * 
 */
function _temp_displaySoftwareDataInTable_($n, $_debug){
    global $tableBorderToggle1;
    global $tableBorderColour1;
    
    global $title, $softwareID, $year, $familyName, $givenName, $publisherName, $country, $licenceList;
    global $hardwareReq, $softwareReq, $description, $notes;
    
    global $seqNum;
    
    if ($_debug) echo 'fn: displayDataInTable...<br>';
    
    echo '<a href="ADHD_modifyEntry.php?id='.$softwareID.'" style="line-height: 4em;">';

    #Link engages CSS styling
    echo '<p>'.$title;
    if(!is_null($year) && !empty($year)) echo " | ".$year;
    echo '</a>';

    /** if title is returned from our CRUD op then show it */
    #TABLE OF RESULTS
    echo '<p><table border="' . $tableBorderToggle1 . '" 
        style="
        border-color: ' . $tableBorderColour1 . ';
        border-top: none;
        border-bottom: none;
        border-left: none;
        border-right: none;
        ">';

    /** we don't need to show title ? as we are already modifying an existing title  */
    if(!is_null($title) && !empty($title)){
      echo '<tr><td width="25%" style="font-size: 13;';
      
      #highligh changed data
      /*
      if (in_array('title', $changes)){
          echo 'font-color: red';
      }
       */
      #echo 'font-color: red';
      echo '">';
      
      echo "<b>Title: </b>";
      echo '<td width="75%" style="font-size: 13;">';
      echo $title;
      echo '</td></tr>';
    }

    /* if year is returned from CRUD ops then show it */
    if (!is_null($year) && !empty($year)) {
        echo '<tr>';
        echo '<td width="25%" style="font-size: 13;">';
        echo "<b>Year: </b>";
        echo '<td width="75%" style="font-size: 13;">';
        echo $year;
        echo '</td></tr>';
    }

    /* if both family name and given name are returned from our CRUD op then show them */
    if (!is_null($familyName) && !empty($familyName) ||
            !is_null($givenName) && !empty($givenName)) {
        $familyNameArr = explode(",", $familyName); //explode is the same as string split in a loop with a delimiter
        $givenNameArr = explode(",", $givenName);

        $fullNameArr = array();
        for ($i = 0; $i < sizeOf($givenNameArr); $i++) {
            $fullNameArr[$i] = $givenNameArr[$i] . " " . $familyNameArr[$i];
        }/* implode: join arr elements with a string, DEALS with multiple authors */

        $fullNameArrTemp = implode(", ", $fullNameArr);
        echo '<tr><td width="25%" style="font-size: 13;">';
        echo "<b>Author(s): </b>";
        echo '<td width="75%" style="font-size: 13;">';
        echo $fullNameArrTemp;
        echo '</td></tr>';
    } else {
        
        #if somethingisnull then try another seqeunce num
    }

    /* if publisherName is returned from our CRUD op then show it */
    if (!is_null($publisherName) && !empty($publisherName)) {
        echo '<tr><td width="25%" style="font-size: 13;">';
        echo "<b>Publisher: </b>";
        echo '<td width="75%" style="font-size: 13;">';
        echo $publisherName;
        echo '</td></tr>';
    }

    /** if country is returned from our CRUD op then show it */
    if (!is_null($country) && !empty($country)) {
        echo '<tr><td width="25%" style="font-size: 13;">';
        echo "<b>Country: </b>";
        echo '<td width="75%" style="font-size: 13;">';
        echo $country;
        echo '</td></tr>';
    }

    /** if licenceList is returned from our CRUD op then show it */
    if (!is_null($licenceList) && !empty($licenceList)) {
        echo '<tr><td width="25%" style="font-size: 13;">';
        echo "<b>Licence: </b>";
        echo '<td width="75%" style="font-size: 13;">';
        echo $licenceList;
        echo '</td></tr>';
    }

    if (!is_null($hardwareReq) && !empty($hardwareReq)) {
        echo '<tr><td width="25%" style="font-size: 13;">';
        echo "<b>Hardware Req's: </b>";
        echo '<td width="75%" style="font-size: 13;">';
        echo $hardwareReq;
        echo '</td></tr>';
    }

    if (!is_null($softwareReq) && !empty($softwareReq)) {
        echo '<tr><td width="25%" style="font-size: 13;">';
        echo "<b>Software Req's: </b>";
        echo '<td width="75%" style="font-size: 13;">';
        echo $softwareReq;
        echo '</td></tr>';
    }

    if (!is_null($description) && !empty($description)) {
        echo '<tr><td width="25%" style="font-size: 13;">';
        echo "<b>Description: </b>";
        echo '<td width="75%" style="font-size: 13;">';
        echo $description . '</td><br>';
        echo '</td></tr>';
    }

    if (!is_null($notes) && !empty($notes)) {
        echo '<tr><td width="25%" style="font-size: 13;">';
        echo "<b>Notes: </b>";
        echo '<td width="75%" style="font-size: 13;">';
        echo $notes;
        echo '</td></tr>';
    }
    echo '</table>';
    #echo '</table>';

    if ($_debug) echo 'fn: displayDataInTable($_debug) complete...<br>';
}
/**
 * convenience function to add multiple headers
 * to an array and keep code cleaners
 * 
 * simple surrounds PROVIDED ARRAY ELEMENTS WITH HTML TAGS
 * 
 * @param type $_ar
 * @return type void / null
 */
function _temp_displayTableHeadersFromArray($_ar){
    
    foreach($_ar as $hdr){
        echo '<th>';
        echo $hdr;
        echo '</th>';
    }
}

?>

