<?php

/**
 * lower case function keyword defines minor convenience functions,
 * or temporary test functions. 
 * 
 * Uppercase 'FUNCTION' keyword defines more CORE functionality.
 * 
 * code augmented by Daniel Phillis Computer Science graduate, Flinders University 2017-2018
 */

/**
* in this case can simply test if supplied authID is less than the max
* assuming all auto increments are sequential and correct
*/ 
function _checkAuthorExists_test(){
        #checks if author exits in author_software
        #but not yet if it is assigned to the correct softwareID
        _msgBox('b', 'checkAuthorExists_test()...');
        $_msg = 'UNIT TEST check auth exists FAILED';
                
        $testTally = 0;
        
        #POSITIVE TESTS
        $test1 = _myAssertQ(( checkAuthorIDExistsInAuthorSoftware(3,0)===3),$_msg); # $_debug
        
        #NEGATIVE TESTS #known non existent authID
        $test2 = _myAssertQ(( checkAuthorIDExistsInAuthorSoftware(-1,0)===0),$_msg);
        $test3 = _myAssertQ(( checkAuthorIDExistsInAuthorSoftware(1000000,0)===0),$_msg);
        
        if ($test1 + test2 + $test3 == 0){
            #SUCCESS
            _msgBox('green','check autor exists UNIT test PASSED');
        } else {
            #FAILURE
            _msgBox('red','check autor exists UNIT test FAILED');
        }
        
        _msgBox('g', 'checkAuthorExists_test()...complete');
}

FUNCTION formStoreData($_debug){
    $blue = '#b3e6ff';
    
    if ($_debug) _msgBox($blue, 'function formStoreData($_debug) reached...');
    #'old' data is needed for comparisons, if new data is no different - then it need not be inserted
    global $title, $year, $softwareID, $seqNum;
    
    # todo formAssignVariables_test_empty();
    # static $seqNum = 1; #static keyword is used to ensure the value cannot change in this function
    # Assign HTTP_post variables to php variables and remove html special chars ??
    
    # zero based assignment to match array operations
    # all vars changed to new - removes the need for globals
    
        /*
         * although normally the title would not change
         * when augmenting an entry this case allows for fixing of typos
         * and spelling mistakes by the users
         */
        
    #if $new_title != '' && $new_title != $title && newTitle != NULL    
    # @ todo use a LOOP and array
    #$new_seqNum = $seqNum + 1; #this has already been done - modify after the array has been returned
    
    $new_title = $title;
    $new_year  = '';
    
    if ($_POST['title'] !== $title){
        $new_title = $_POST['title'];
    }#esle blank value is retained
    
    #NB capital Y - where is this coming from ?
    if ($_POST['Year'] !== $year){
        $new_year = $_POST['Year'];
    } else{ 
        #blank value is retained
        $new_year = '';
    }
    #$new_authorInputCount   = $_POST['authInputCount'];

    $new_authorGivenName    = $_POST['authorGiven'];
    $new_authorGivenName1   = $_POST['authorGiven1'];
    $new_authorGivenName2   = $_POST['authorGiven2'];
    $new_authorGivenName3   = $_POST['authorGiven3'];
    $new_authorGivenName4   = $_POST['authorGiven4'];

    $new_authorFamilyName   = $_POST['authorFamily'];
    $new_authorFamilyName1  = $_POST['authorFamily1'];
    $new_authorFamilyName2  = $_POST['authorFamily2'];
    $new_authorFamilyName3  = $_POST['authorFamily3'];
    $new_authorFamilyName4  = $_POST['authorFamily4'];

    # Recall we need to insert publisherID not publisherName in the software table
    # therefore the ID must be resolved before insert query execution
    $new_publisher          = $_POST['publisher'];
    $new_country            = $_POST['country'];
    
    #SANITATION / DATA CHECK (removes strings 'Choose a Country' from entering the DB')
    if(substr($new_country,0,3)==='Cho') {
        $new_country = '';
    }
    $new_hardwareReq        = $_POST['hardwareReq'];
    $new_softwareReq        = $_POST['softwareReq'];
    $new_description        = $_POST['description'];

    $new_notes              = $_POST['notes'];
    $new_contributorFamily  = $_POST['contributorFamily'];
    $new_contributorGiven   = $_POST['contributorGiven'];

    $new_altAddress         = $_POST["altAddress"];
    $new_filesNum           = $_POST["filesnum"];
    $new_licenceList        = $_POST["licenceList"];
    
    #SANITATION / DATA CHECK (removes strings 'Choose a Licence' from entering the DB')
    if(substr($new_licenceList,0,3)==='Cho') {
        $new_licenceList = '';
    }

    /**
     * return ARRAY of the new Variables...
     * (previously data was stored in globals through-out all php pages)
     * in order to help achieve desired order of attributes -
     * (the user oriented form creates one order, but the DB has another Order or attributes) 
     * 
     * array can be manipulated after the body of it has been formed (below)
     * 
     * RE-ORDER to match $oldData
     * NB inserted date is omitted, as it is not required here, it can be appended
     * anytime prior to DB insertion (Create Op in CRUD Ops)
     * 
     * PROBLEM - still using publisher and publisherName to hold the same data
     * publisher must be changed to publisherID for SQL insertion query to work
     */
    
    #get publisherID (returns 0 if publisher name is non-existent)
    
    $new_publisherID = queryPublisherID($new_publisher, 0);
    
    
    if($new_publisherID==0){
        #publisher doesnt yet exist - make a new one (ID is auto-increment)
        if ($_debug) _msgBox('y','publisher doesnt yet exist - making a new one...');
        $new_publisherID = insertPublisherByName($new_publisher, 1);
    }
    #_msgBox('y', 'made it here: validation.php, newPubID: '.$new_publisherID);
    
    ###### ##### ##### ##### ##### ##### ##### ##### ##### #####  #####
    # Resolve contributorID (returns 0 if contributor doesnt exist)
    ####### ##### ##### ##### ##### ##### ##### ##### ##### ##### #####
    # if inserting a new contributor, id is auto inc
    
    if ($_debug) echo 'resolving conID...<br>';
    $new_contributorID = queryContributorIDByName($new_contributorGiven, $new_contributorFamily, 0); 
    #Broken Signature?
    
    # if contributorID != 0, nonzero ID means contributor was already in the DB (already assignd a non zero int)
    if ($new_contributorID==0){
        echo 'contributor "'.$new_contributorGiven.' '.$new_contributorFamily.
                '" not found...<b>inserting</b> "'.
                $_gn.' '.$_fn.'"...<br>';
        $new_contributorID = insertContributorByNamesAndEmail(
                $new_contributorGiven, 
                $new_contributorFamily, 
                $new_altAddress, 0);
        #echo '$new_contributorID: '.$new_contributorID;
    }
    
    #### #### #### #### #### #### #### #### #### #### #### #### #### #### 
    # VALIDATE newly inserted contributor or exiting contributor exists
    # #### #### #### #### #### #### #### #### #### #### #### #### #### ####
    # SHIFT TO DEDICATED FUNCTION ?
    #### #### #### #### #### #### #### #### #### #### #### #### #### #### 
    if($_debug) _msgbox('b','Inf: val->validating contributor existence...');
    $qID = queryMaxContributorIDFromContributor(0);
    _myAssertQ(($new_contributorID===($qID)), 'E: ERROR: newconID != last inserted conID');
    
    #_msgBox('y', 'made it here: newContributorID '.$new_contributorID);
    #_msgBox('y', 'made it here: queriedLastContributorID '.$qID);
    
    #BUILD ASSOCAITIVE ARRAY TO BE RETURNED to ADHD_newEntryFORM.php
    $newVars = array(
    # we know sid has not changed 
    # (modifyEntry cannot change sid, only sequenceNumber for the same swid)
    # blank indicates it hasnt changed for debug purposes
    # even though it is blank here
    # when we need it for insertion we can use the global variable
        
        'softwareID'    =>  $softwareID,
        'sequenceNum'   =>  $seqNum, #already incremented
        'title'         =>  $new_title,
        #'year' =>  1942, #changes take effect here
        'year'                  =>  $new_year,
        
        'authorGivenName'       =>  $new_authorGivenName,
        'authorGivenName1'      =>  $new_authorGivenName1,
        'authorGivenName2'      =>  $new_authorGivenName2,
        'authorGivenName3'      =>  $new_authorGivenName3,
        'authorGivenName4'      =>  $new_authorGivenName4,

        'authorFamilyName'      =>  $new_authorFamilyName,
        'authorFamilyName1'     =>  $new_authorFamilyName1,
        'authorFamilyName2'     =>  $new_authorFamilyName2,
        'authorFamilyName3'     =>  $new_authorFamilyName3,
        'authorFamilyName4'     =>  $new_authorFamilyName4,
         #14
        'publisher'     =>  $new_publisher,
        'publisherID'   =>  $new_publisherID, #new
        'country'       =>  $new_country,

        'hardwareReq'   =>  $new_hardwareReq,
        'softwareReq'   =>  $new_softwareReq,
        'licenceList'   =>  $new_licenceList,
        #'insertedDate'         =>  date('Y-m-d'),
        #20
        'description'   =>  $new_description,
        'notes'         =>  $new_notes,
        
    #contributorID is needed for insertion Query
        #and generated from names, names can be removed from this array as they are now stored in the 
        #contributor table and can be retrieved with contributorID
        #(extra query)
        
        'contributorID' =>  $new_contributorID,
        #'contributorFamily'    =>  $new_contributorFamily,
        #'contributorGiven'     =>  $new_contributorGiven,
        #'fullName'             =>  ($new_contributorGiven.' '.$new_contributorFamily),
        'altAddress'    =>  $new_altAddress,
        'numberOfFiles' =>  $new_filesNum # dont use filesNum
        #25
    );
    
    #DEBUG
    if ($_debug) _msgBox('g','function formAssignNewVariables($_debug)...complete');
    if ($_debug) _msgBox('g','returning $newVars with form data...');
    echo '<hr>';
    #(after returning, swid and seq num will be corrected ? why ?)
    return $newVars;
}

/**
 * _checkAuthorIDExists from author_software Table
 * simple check is incoming ID < max ID - then it exists ?
 * vs
 * explicit check
 * 
 * @param type $_authID
 * @return type = int, 0 for niull results form query
 */
function checkAuthorIDExistsInAuthorSoftware($_authID, $_debug){
    global $conn;
    
    if ($_debug) _msgBox('b', 'checkAuthorExists()');
    
    #template SELECT authorID FROM author_software WHERE softwareID = 3
    $queryCheckAuthorSoftwareForAuthorID = "SELECT authorID FROM author_software WHERE authorID = :a";
    $stmt = $conn->prepare($queryCheckAuthorSoftwareForAuthorID);
    $stmt->bindParam(':a', $_authID);
    
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if(is_null($res['authorID'])){
        return 0;
    }else{
        #echo $res['authorID'];
        #echo '<br>';
        return $res['authorID'];
    }
}

/**
 * 
 * this function has 2 parts:
 * 1.
 * Insert a filePath / fileName to the database
 * also check for correct image type and
 * fileSize
 * 
 * 2.
 * the actual copying of files as well to the uploads folder !!
 * see old function for this code
 */
FUNCTION insertUploadedFile($_fileName, $_fileSize, $_fileType, $_sid, $_seqNum, $_debug){
    
    if ($_debug) _msgBox('b', 'fn: insertUploadedFile reached... ');
    
    global $conn;
    
    
    #if ($_debug) $debug_string .= "<font color = \"blue\">* CRUD INSERTION</font>*\n";
    $insertFileSQL = "INSERT INTO uploadedFiles (
                            fileName,
                            fileSize,
                            fileType,
                            softwareID,
                            sequenceNum) VALUES (:fn, :fs, :ft, :sid, :sqn)";
    /* (the fileID attribute is set to auto-increment) */

    #PDO BIND ARRAY
    $bindArray = array(
        ':fn' => $_fileName,
        ':fs' => $_fileSize,
        #':ft' => '"'.$_fileType.'"', #datatype is varChar
        ':ft' => $_fileType, #datatype is varChar
        ':sid' => $_sid,
        ':sqn' => $_seqNum);

    #PDO PREPARE
    $file_f = $conn->prepare($insertFileSQL);
    # or trigger_error("1st Error!", E_USER_ERROR);
    /*
     Can not proceed if we can not prepare the query
     recall triple equals sign avoids data type conversions/casting
     from a comparison of two variables of different data types
    */
    #PDO EXECUTE #Place the Execute statement into a variable and test if it executed or not
    $file_f->execute($bindArray);
    #if ($_debug) $debug_string .= 'debug: storing results...<br>';
    #PDO FETCH
    $result = $file_f->fetch(PDO::FETCH_ASSOC);
    if($_debug) _msgBox('g', 'fn: insertUploadedFile complete... ');
}

/**
 * INSERT PUBLISHER INTO PUBLISHER TABLE
 *  (if they don't already exist)
 *
 *  Existence already checked for with function
 *  'queryPublisherID'
 *  (returns int 0 if fails 
 *  returns PID if succeeds)
 * 
 * publisherID is autoincremetd
 * 
 * should return the new publisherID if *BOTH* insert query succeeds
 * 2 insert queries in the same function reduces # of connections to the DB
 *
 * @global type $conn
 * @param type $_publisher
 * @param type $_debug
 * @return int
 */
FUNCTION insertPublisherByName($_publisher, $_debug){

    #_msgBox('g', 'inserting publisher disabled...'.$_publisher);
    _msgBox('p', 'inserting publisher...'.$_publisher);
    
    global $conn;
    
    # Get the max publisherID (before insertion / CREATE operation)
    $qMaxPublisherID = 'SELECT MAX(publisherID) FROM publisher';
    $oldMaxPub = $conn->query($qMaxPublisherID)->fetchColumn();
    _msgBox('b','oldMaxPub: '.$oldMaxPub);
    
    /* INSERT (WARNING!! assumes data is already validated!) */
    
    #DATA INSERTION IS IN TWO TABLES - publisher and software
    #but we are not doing both tables in this function only 
    #the easy one -> insertion to publisher
    
    #1. publisher -> publisherName does not exist - insert it
    $newMaxPub = 0;
    
    #(publisherID : auto-Increment in this table)
    $queryInsertPublisher = "INSERT INTO publisher (publisherName) VALUES (:pn)";
    $res = $conn->prepare($queryInsertPublisher);
    $res->bindParam(':pn', $_publisher);
    $res->execute();

    $qMaxPublisherID = 'SELECT MAX(publisherID) FROM publisher';
    $newMaxPub = $conn->query($qMaxPublisherID)->fetchColumn();
    _msgBox('b','newMaxPub: '.$newMaxPub);

    # get the max publisherID (after insertion / CREATE operation
    $publisherID = $newMaxPub;
    
    #VALIDATE: do comparison : should be in its own validation function
    echo '</font>';
    
    if ($oldMaxPub = ($newMaxPub - 1)) {
        if ($_debug){ 
            _msgBox('g', ('$oldMax('.$oldMaxPub.') is confirmed to be one less than $newMax('
            .$newMaxPub.')(as to be expected)'.'new max publisherID = '.$newMaxPub));
            
            _msgBox('g', ('$publisherID'.$publisherID));
        }
        
    #VERIFY 
    #software table insertions (queryPublisher queries publisher table not software Table)
        $publisher = $_publisher; #echo $publisher;
        $verifyInPublisherTable = queryPublisherID($publisher, $_debug);
        echo $verifyInPublisherTable;
        
        /*
        if ($verifyInPublisherTable == $newMaxPub){
           _msgBox('g', 'insertion into Publisher Table verfied...<br>');
        } else {
            _msgBox('o', 'insertion into Publisher Table verfied...');
        }
         */
        
        _myAssertQ(($verifyInPublisherTable == $newMaxPub), 'V:insertion into Publisher Table failed...');
        #validate pid's'
        $publisherID = $newMaxPub;
    } else {
        $publisherID = 0;
    }
    
    return $publisherID;
}

/**
 * INSERT PUBLISHER INTO *software* TABLE
 *  (if they don't already exist)
 *
 * existence already checked for with function
 *  'queryPublisherID'
 *  returns int 0 if fails or 1 if succeeds
 * 
 * should return the new publisherID if *BOTH* insert query succeeds
 * 2 insert queries in the same function reduces # of connections to the DB
 *
 * @global type $conn
 * @param type $_publisher
 * @param type $pubID
 * @param type $_debug
 * @return int
 */
FUNCTION insertPublisherIDToSoftware($softwareID, $seqNum, $_publisher, $_debug){

    global $conn, $softwareID, $seqNum;
    $debug_string = '';

    _msgBox('b','insertPublisherIDToSoftware');
    
    if ($_debug) {
        echo '<font color="blue"><br>';
        $debug_string .= " ** \n";
        #$debug_string .= line();

        $debug_string .= 'FUNCTION call: insertPublisher into Software...\n';
        $debug_string .= 'FUNCTION call: inserting: `' . $_publisher . '\n';
        
    }
    
/* INSERT (WARNING!! assumes data is already validated!) */
    #get id via query rather than via max
    $pid = queryPublisherID($_publisher, 0);
            
    #DATA INSERTION IS IN TWO TABLES - publisher and software
    #2. software
    $queryInsertPublisher = 'INSERT INTO software (softwareID, sequenceNum, publisherID)'; 
    $queryInsertPublisher .= ' VALUES (';
    $queryInsertPublisher .= ':swid, ';
    $queryInsertPublisher .= ':sn, ';
    $queryInsertPublisher .= ':pid';
    $queryInsertPublisher .= ')';
    if ($_debug) echo 'query: '.$queryInsertPublisher .'<br>';
    echo 'preparing...<br>';
    $res = $conn->prepare($queryInsertPublisher);
    echo 'binding...<br>';
    $res->bindParam(':swid', $softwareID);
    $res->bindParam(':sn', $seqNum);
    $res->bindParam(':pid', $pid);
    
    $res->execute();
    if($_debug){
        echo 'executed...<br>';

        #verify software table insertions
        echo 'verifying...(todo: check software ID entry for title)<br>';
        #verify should be in validation.php
        #id = 
        echo 'querying publisher from ID: '.$pid.'<br>';
        #$val = queryAllvSoftwareByID($pid);
        #$pubVal = $val['publisher'];
        echo 'validation query not yet completed...<br>';

        _msgBox('b','insertPublisherIDToSoftware...complete');
        #write(append mode)
        #writeToFileTXT($debug_string);  
    }
    return $publisherID;
}

/**
 *  BROKEN Insert Authors to the author table
 *
 *  checks first to see if the author exists at all in the author table or not
 *  if so - the author id is returned
 *  and the author is not entered (this would create a duplicate entry - redundant data)
 * 
 *  if not zero is returned
 *  (not author software table)
 *  returns the authorID
 * 
 *  authorID on the author table is set with auto inc
 *  so getting the id is equivalent to using the
 *  function 'getMaxAuthorIDForNewAuthorInsertion()''
 */
#int @@@

FUNCTION insertNewAuthorToAuthorTable2($_givName, $_famName, $_debug){
    global $conn;
    
    # _msgBox("#ccccff",'insertNewAuthorToAuthorTable(a,b,debug)...');
    if ($_debug==2) _msgBox("p",'insertNewAuthorToAuthorTable(a,b,debug)...');
    # CHECK IF AUTHOR ID ALREADY EXISTS
    /*
    $queryCheckForAuthor = "SELECT authorID FROM author WHERE givenName = :gn AND familyName :fn)";
    $stmt = $conn->prepare($queryCheckForAuthor);
    $stmt->bindParam(':gn', $_givName);
    $stmt->bindParam(':fn', $_famName);
    $check = $stmt->execute()->fetch(PDO::FETCH_ASSOC);
    
    print_r($check);
    */
    #check already done...
    
    # INSERT INTO AUTHOR (auto-increment)#
    $queryInsertIntoAuthor = "INSERT INTO author (givenName, familyName) VALUES (:gn, :fn)";
    
    if (($_givName != "") || ($_famName != "")) {
        /*
        if ($_debug==2) {
            $debug_string .= "preparing SQL...\n";
            $debug_string .= 'INSERT INTO <b>author</b> (givenName, familyName) VALUES (:gn, :fn)';
            $debug_string .= "\n";
        }
         */
        $stmt = $conn->prepare($queryInsertIntoAuthor);

        #BIND
        #if ($_debug==2) $debug_string .= "binding parms in query...\n";
        
        $stmt->bindParam(':gn', $_givName);
        $stmt->bindParam(':fn', $_famName);
        #if ($_debug==2) $debug_string .= "executing query...\n";
        $stmt->execute();

        #VALIDATE # by querying by author name to get the new ID
        # and return the ID

        #if ($_debug==2) $debug_string .= 'validating:fetching results(auto inc id)...<br>';

        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        
        /*
        if ($_debug){
            #$debug_string .= "printing results...\n";
            foreach($results as $row) {
                #$debug_string .= $row."\n";
                #$debug_string .= "\n";
            }
        }# end if
        */
        
        #VALIDATE # by querying author';'s ID and comparing to maxID - they should be the same
        $returnedID = queryAuthorIDFromAuthorByName($_givName, $_famName, 0);
        if ($_debug==2) echo $returnedID.'<br>';
        $maxID = queryMaxAuthorIDFromAuthor(0);
        if ($_debug==2) echo $maxID.'<br>';
        
        if($returnedID===$maxID){
            if ($_debug) _msgBox('y', 'author insertion validated !');
        } else {
            if ($_debug == 2) {
                _msgBox('o', 'author insertion NOT validated !');
                _msgBox('o', 'returnedID != maxID...');
                _msgBox('o', 'possibly maxID is not true ?');
            }
        }
        
    }#end if
    if ($_debug == 2) _msgBox('g', 'function insertNewAuthorToAuthorTable complete+ validated...');
}#end fn

/**
 * insertAuthorsToAuthorSoftwareByID
 * 
 * @global type $conn
 * @global type $seqNum
 * @param type $_authID
 * @param type $_gn
 * @param type $_fn
 * @param type $_swID (must be incremented in anticipation)
 * @param type $_debug
 * 
 * @return type = ?
 * 
 * Insert Author to *author-software* table by authorID
 * (but only if they do not already exist for that softwareID)
 * 
 * increment from MAX softwareID query does not happen here ?
 * but in calling function
 * 
 * technically it is possible that one author could work on (author) 
 * more than one piece of software
 * 
 * and with known softwareID (declared as global)
 * todo return an int to validate insertion took place

 */
#void (but verbose debug output)
FUNCTION insertAuthorsToAuthorSoftwareByIDArray($_authIDArray, $_swid, $_debug){
    if ($_debug) _msgBox('p','FN: insertAuthorsToAuthorSoftwareByID*Array*()...');
    #echo '...by Array -> ids to insert:<br>';
    if ($_debug) echo '#...for softwareID -> '.$_swid.' + 1<br>';
    $_swid+=1;
    global $conn;
    global $seqNum; #(should already be incremented)
    if(count($_authIDArray)==0) _msgBox ('orange', '# authID[] passed in was empty');
    #loop over array
    ### CHECK FIRST if IDs existing  - from array
    $counter = 0;
    for($n=0; $n < count($_authIDArray);$n++){
        $aIDInsert = $_authIDArray[$n];
        
        if (!$_swid){
            _msgBox('r', '# $_swid is null/missing !');
            exit();
        }
        
        $exists = checkAuthorIDExistsInAuthorSoftware($aIDInsert,0);
        if(!$exists){
            if($_debug) _msgBox('pink','# author not in DB table (auth_software), proceeding with INSERTION#<b>'.($n+1).' of '
                    .count($_authIDArray).'</b>');
            $queryInsertIntoAuthorSoftware = "INSERT INTO author_software "
                    . "(authorID, softwareID, sequenceNum) VALUES (:a, :s, :seq)";
            $stmtIns = $conn->prepare($queryInsertIntoAuthorSoftware);
            
            if($_debug) echo '# authID to insert to auth_soft... '.$aIDInsert.'<br>';
            #BIND
            $stmtIns->bindParam(':a', $aIDInsert);
            if($_debug) echo '# auth parm bound<br>';
            if($_debug) echo '# swid to insert to authSoft..: '.$_swid.'<br>';
            #BIND
            
            $stmtIns->bindParam(':s', $_swid); #vital increment !!
            if($_debug) echo '# swid parm bound<br>';
            
            #@@@seqNum is only incremented if we are augmenting the software
            #(in this case we know the title is new)
            #get correct sequence number (must know the softwareID, and decrement the swid)
            #$seqNum = queryMaxSeqNumFromSoftware($_swid, 0);
            
            $seqNum = 1; # we know we are inserting a new title
            if($_debug) echo '# seqNum to insert to authSoft..: '.$seqNum;
            #BIND
            $stmtIns->bindParam(':seq', $seqNum); # @@@ not sure how seqNum is set at this stage
            $stmtIns->execute(); #no fetching required for an insert
            if($_debug) _msgBox('y', '# INSERTION (authorID# <b>'.$aIDInsert.', </b>swID#<b> '.$_swid.'</b>) DONE..');
            
        } else {
            _msgBox('o', '# authorID '.$exists.' already exists in the author_software table');
            _msgBox('o', '# authorID insertion not required'); 
        }
    }
    
    /**
    foreach($_authIDArray as $aIDInsert){
        #echo 'attempting check author id to author_software: '.$aIDInsert.'<br>';
        $exists = checkAuthorIDExists($aIDInsert);
        #function was tested (returns 0 is doesnt exist)
        if($exists==0){
            #only insert if not in the table already
            echo 'author does not  exist...proceeding with insertion...<br>';echo 'authInsertionByArray#'.$counter.'<br>';
            #INSERT - if software exists , increment seqNum
            $queryInsertIntoAuthorSoftware = "INSERT INTO author_software "
                    . "(authorID, softwareID, sequenceNum) VALUES (:a, :s, :seq)";
            
            if ($_debug) {
                $debug_string .= "Q:";
                $debug_string .= $queryInsertIntoAuthor ."\n";
                $debug_string .= "\nif software is new seqNum = 1>";
            }
            
            
            $stmtIns = $conn->prepare($queryInsertIntoAuthorSoftware);
            echo 'id to insert to auth_soft... '.$aIDInsert.'<br>';
            
            echo 'swid to insert to authSoft..: '.$_swid;
            $stmtIns->bindParam(':a', $aIDInsert);
            #$stmtIns->bindParam(':s', $_swid);
            $stmtIns->bindValue(':s', 2);
            
            echo 'seqNum to insert to authSoft..: '.$seqNum;
            $stmtIns->bindParam(':seq', $seqNum); # @@@ not sure how seqNum is set at this stage
            
            $stmtIns->execute(); #no fetching required for an insert
            _msgBox('y', 'INSERTION DONE..');
            
        } else {
            _msgBox('o', 'authorID '.$exists.' already exists in the author_software table');
        }
        $counter++;
     
    
    
    #VALIDATE by getting the most recent authorIDs and comparing them to the table
    /**
    #getMax
    $qMaxID="SELECT MAX(authorID) FROM author";
    $max = $conn->query($qMaxID)->fetchColumn();
    #$max++;
    $max -= count($_authIDArray);
    echo '$max'.$max.'<br>';
    
    $counter = 0;
    foreach($_authIDArray as $aIDValidate){
        _msgBox('y','VALIDATING author insertion to author_software');
        
        #$fullName = queryAuthorFullNamesFromViewSoftware($_swid, $_debug);
        #echo 'full name retrieved from view: '.$fullName.'<br>';
        
        $valID = $max + $counter + 9000;
        echo '$valiID: '.$valID.'<br>';
        echo 'orig ID: ';
        echo $_authIDArray[$counter];
        
        #compairsion 
        if ($valID === ($_authIDArray[$counter])+9000){

            _msgBox('g', 'test insertion '.$counter.' validated !');

        } else {
            _msgBox('o', 'test insertion '.$counter.' VALIDTION FAIL !');
        }
        /*
        $validateSQL = 'SELECT * FROM author_softwareWHERE authorID = :id';
        #$debug_string .= line();
        $debug_string .= "\nValidation sql = ".$validateSQL;
        $stmtVal = $conn->prepare($validateSQL);
        $stmtVal->bindParam(':id', $aIDValidate);
        $stmtVal->execute();

        $results = $stmtVal->fetch(PDO::FETCH_ASSOC);
        if($_debug==2 && $results){
            foreach($results as $row){
                $debug_string .= "\n";
                $debug_string .= $row;
            }
        }else{
            if ($_debug){
                #echo 'something went horribly wrong !<br>';
                $debug_string .= "\nsomething went horribly wrong !";
            }
        }

        $gn_val = $results['givenName'];
        $gn_val = trim($gn_val); #trim whitespace
        $fn_val = $results['familyName'];
        $fn_val = trim($fn_val); #trim whitespace

        if ($_debug) {
            $debug_string .= "\ngivenName: " . $gn_val;
            $debug_string .= "\ngn: ".$_gn;
            $debug_string .= "\nfamily name: ".$fn_val;
            $debug_string .= "\nfn: ".$_fn;

        if($gn_val === $_gn && $local_validate){
                $debug_string .= "\ngiven names match !\n";
                $debug_string .= "\n* (comparing passed names and names returned from DB) *\n";
            }
            if($fn_val === $_fn && $local_validate){
                $debug_string .= "\nfamily names match !";
                $debug_string .= "\n(comparing passed names and names returned from DB)";
            }
        }        
        if ( ($gn_val == $_gn) && ($fn_val == $_fn) && $_debug){
            $debug_string .= "\n### AUTHOR ".$gn_val." ".$fn_val." INSERTION VALIDATED ### \n";
        }
        */
        #$counter++;
    #}
    
    if ($_debug) _msgBox('g','function insertAuthorsToAuthorSoftwareByID complete...'); #lightGreen
}

/**
 *  insertContributorByNamesAndEmail_test
 * 
 * tested manually  insertion is working...
 */ 
FUNCTION insertContributorByNamesAndEmail_test(){

    _msgBox('pink','T:insertContributorByNamesAndEmail_test reached...');
    
    #get corpus of names
    #see ../text/_male_names.txt
    #and ../text/_female_names.txt
    
    $oldAutoInc = queryAutoIncrementValueContributor('contributor');
    
    #known names
    
    #unknown Names
    $names = array(
        'James Brown',
        'Harry Potter',
        'David Bowie',
        'Crocodile Dundee'
        );
    
    #illegal syntax
    $bad_names = array(
        'James_Brown',  # will fail - resulting in a blank name due to undescore
        'Harry-Styles', # will fail - resulting in a blank name due to hyphen
        '1Jane Fonda',  # wont fail but should - need to check detection of numerals used in names
        'Jane Fonda77', # wont fail but should - need to check detection of numerals used in names
        'J@ne Fonda77'  # wont fail but should - need to check detection of other symbols used in names
    );
    
    /**
     * Randomly add names to an array of random length
     */
    
    #$names = randNameArray(100);
    #$names = $bad_names;
    
    #all alphabetic chars, does not a good test make
    $isps = array('iinet','dodo','internode','optus');
    
    #get initial count
    
    # @@@ BROKEN
    $initialCount = queryCountContributorEntries(0);
    echo '$initialCount(contIDs): '.$initialCount.'<br>';
    
    $oldMax = queryMaxContributorIDFromContributor(0);
    
    for($n=0;$n < count($names);$n++){
        $givFam = explode(" ", $names[$n]);       
        if ($debug){ 
            
            echo 'given: ';
            echo $givFam[0].'<br>';
            echo 'family: ';
            echo $givFam[1].'<br>';
        }
        $email = $givFam[0].'.'.$givFam[1].'@optus.com.au';
        echo 'inserting'.$_givFam[0].' '.$_givFam[1].','.$_email.'<br>';
        insertContributorByNamesAndEmail($givFam[0], $givFam[1], $_email, 0); #tested manually
    }
    
    #verification method:
    #get names and email of the last n inserted 
    #contrbitor IDs and match with the initial array
    
    _msgBox('g', 'I:Validation');
    #get max contributorID (there should exist a generic function to get the max id or max int from any table)
    
    /* warning !! a simple count will not always work as contributor IDs are not sequential
     * we need to get Max IDs and possibly detect missing IDs from a sequential list
     */
    $newMax = queryMaxContributorIDFromContributor(0);
    if ($debug) {
        echo 'oldMax: ';echo $oldMax;
        echo '<br>';
        echo 'newMax: ';echo $newMax;
        echo '<br>';
    }
    $diff = $newMax - $oldMax;
    _msgBox('g', 'I:<b>'.$diff.' new entries added / detected..</b><br>');
    
    $returnedNames = array();
    
    # return new entries and compare returned bames are added into the array
    # in the same order
    /**
     * this wont work if the new IDs entered
     * are not sequential to the previously entered contributors
     */
    $id_list = array();
    
    /**
     * when adding retrieved names to our validation array we needed to take into consideration
     * the fact that the form submission has also entered a name for that current submission
     * and thus an offset of one is needed
     */
    
    $hdrs = array('loop itr','contID','Names');      
    for ($n = ($newMax-count($names)); $n < $newMax;$n++){
        if ($debug) echo $n.'<br>';
        $id_list[] = $n+1;#offset -see note above
        $contrib = queryContributorNameFromID($n+1); #offset -see note above
        $returnedNames[]=$contrib;
    }
    
    #TABLES
    if (1) {
        echo '<table border = "1">';
        echo '<tr><td width = "50%">';
            #displayTitleDataInTableFromAssocArray($names);
            #displayDataInTable($names);
        
        #TABLE 1
            echo '<table border="1">';
            #displayTableHeadersFromArray($hdrs);

            echo '<tr>';
            for($i=0;$i<count($names);$i++){ #original order

                echo '<tr><td>';
                echo $i;
                echo '</td><td>';
                # newMax needs to be offset by the count of new contrbutors
                # already entered to display the correct contributorID
                # *AND* offset by the current contributor in this test case (+1)
                echo $newMax -count($names) + $i + 1; 
                echo '</td><td>';
                echo $names[$i];
                echo '</td></tr>';
            }
            echo '</tr>';
            echo '</table>';
        echo '</td><td width= "50%">';
            echo '<table border="1">';
            #displayTableHeadersFromArray($hdrs);
            echo '<tr>';
            for($i=0;$i < count($returnedNames);$i++){
                //col A
                echo '<tr><td>';
                echo $i;
                echo '</td><td>';
                //col B
                echo $id_list[$i];
                echo '</td><td>';
                //col C
                echo $returnedNames[$i];
                echo '</td></tr>';
            }
            echo '</tr>';
            echo '</table>';
        echo '</td></tr>';
        echo '<table>';
    }
    
    #compare arrays in tables (a balnk entry in a new table does not mean that data has
    #been lost, only that new data has not been added - there is no data subtraction or clobbering)
    
    $testSumArray = 0;
    $testSumArray += _myAssertQ($returnedNames === $names,'error comparing arrays');
    
    $before = queryCountContributorEntries(1);
    echo $before.'<br>';
    
    if ($_debug) _msgBox('y', 'W:preparing to delete new test entries...');
    
    #DELETE new test entries (one at a time - non optimal)
    
    $testSumDelete = 0;
    for ($n = $oldMax; $n >= $newMax;$n++){ 
        echo $n.'<br>';
        $testSumDelete += queryDeleteContributorEntry($n); #id (fn returns 0 for success)
        echo $testSumDelete;
    }
    
    $after = queryCountContributorEntries(1);
    echo $after.'<br>';
    
    if($before !== ($after + count($names))){
        _msgBox ('r', 'E:test data CRUD(Deletion) failed');
        exit();
    }
    
    if($testSumDelete != 0){ 
        _msgBox ('r', 'E:test data CRUD(Deletion) failed');
        exit();
    } else {
        _msgBox ('g', 'V:test data CRUD(Deletion) succeeded !!');
    }
    
    
    #DELETE new test entries all in one transaction (currently broken)
    
    $killList = array(); #cant use count as a parm in the loop as it may differ to maxID
    for ($n = $oldAutoInc; $n <= $newMax;$n++){ 
        #echo 'ID: ';
        #echo $n.'<br>';
        $killList[]= $n;
    }
    if ($_debug){
        echo 'killList array :<br>';
        print_r($killList);
    }
    
    #queryDeleteContributorEntries($killList);
    
    # RESET AUTO INCREMENT NUMBER BASED ON old MAX (+1)
    #_resetAutoInc('contributor');
    #_setAutoInc('contributor', $oldMax + 1); # count != max as some ids are missing in the sequence
    
    #get last entry (after deletion - should return a real entry not a dummy test entry)
    $max = queryMaxContributorIDFromContributor(0);
    echo queryContributorNameFromID($max).'<br>';
    _msgBox('y', 'made it here');
    
    #Check count again
    $finalCount = queryCountContributorEntries(0);
    if ($debug){
        echo '$initialCount: '.$initialCount;
        echo '<br>';

        echo '$finalCount: '.$finalCount;
        echo '<br>';
    }
    $testSumArray += _myAssertQ(($finalCount === $initialCount + count($names)),'error comparing entry counts');
    
    if($testSumArray==0){
        _msgBox('g','V:fn: insertContributorByNamesAndEmail: Both / all tests passed');
    } else {
        _msgBox('red','E: fn: insertContributorByNamesAndEmail: a test failed in sum of multiple tests...');
    }
    
    return;
}

/**
 * insertContributorByNamesAndEmail
 * 
 * need to *optionally* test if contributor exits first or not
 * to avoid duplicate entries
 * (with function )
 * 
 * conID is auto-incremented
 * (during testing auto-increment may need to be reset manually)
 * via phpMyadmin 
 * trying to avoid the use of globals here...
 * 
 * used by validation function: formStoreData
 * (ADHD_functionValidation.php)
 * 
 * contributor not found...inserting a new one...
 * @param type $_gn
 * @param type $_fn
 * @param type $_email
 
 * * @param type $_test
 * 
 * @param type $_debug
 * 
 * @return type int (contributorID)
 */
FUNCTION insertContributorByNamesAndEmail($_gn, $_fn, $_email, $_debug){
    global $conn;
    
    if($_debug) _msgBox('p', 'FN:insertContributorByNamesAndEmail reached* ...');
    
    $existingID = queryContributorIDByName($_gn, $_fn, 1);
    
    if($existingID){
        _msgBox('o', 'W:cont already exists wtih name: <b>'.($_gn.' '.$_fn).'</b>');
        return $existingID;
    }#else
    #insert content into contributor table
    $insertContributorSQL = "INSERT INTO contributor (givenName, familyName, emailAddress) VALUES (:gn, :fn, :e)";
    
    #echo 'query: '.$insertContributorSQL;
    #echo '<br>';
    #count before insertion (recall max is not the same as count)
    
    echo 'count contributors...<br>';
    $c1 = queryCountContributorEntries(0);
    #$c1 =10;
    #echo $c1.'<br>';
    if ($_debug) echo 'Contributor count: '.$c1.'<br>';
    
    #$stmt_count_pre = countRows('contributor');
    $stmt = $conn->prepare($insertContributorSQL);
    #$stmt->bindValue(':gn', $_gn);
    #$stmt->bindValue(':fn', $_fn);
    #$stmt->bindValue(':e', $_email);
    $stmt->execute(array(
        ':gn' => $_gn,
        ':fn' => $_fn,
        ':e' => $_email
        ));
    
    #verify with existing queries (queryContributorID)
    #new id should be = to count of contributor table
    if($_debug) echo 'verifying contributor ID...<br>';
    #count after insertion
    $s2 = queryCountContributorEntries(0);
    if ($_debug) echo 'NEW Contributor count: '.$c2.'<br>';
    $validateStatus = 0;
    if(validateIncrement($s1, $s2)){
        #echo 'contributor count increment verified...<br>';
        _msgBox('g', 'V:count test passed for insert new contributor(functionsInsert.php) !');
        $validateStatus = 1;
        
    } else {
        _msgBox('o', 'E:count test failed for insert new contributor(functionsInsert.php) !');
    }
    
    ##### ##### ##### ##### ##### ##### ##### ##### 
    $new_ID = queryContributorIDByName($_gn, $_fn, 0);
    if($new_ID != 0){ 
        if($_debug){
            _msgBox($green, 'V:insertContributorByNamesAndEmail complete...');
            _msgBox($green, 'V:returning new contributorID...');
        }
        return $new_ID;
        
    } else {
        _msgBox('o', 'E: something went horribly wrong !'
                .'queryContributorID = 0, contributor does not exist...');
    }
    
    if($_debug && $validateStatus) _msgBox('g', 'V:insertContributorByNamesAndEmail complete...');
    
}

/**
 * test insertNewSoftwareEntryByArray_test()
 * 
 */
function insertNewSoftwareEntryByArray_test(){
    
    # include external data ? 
    # how to write the external data ? Data-Farming
    # when to Delete the test data - at the end seems most efficient (use function)
     
    # this insert function validates only that the title is in the database at the end of the function
    
    #LOOP over deifferent tests
    # what needs to be tested ?
    # some / all data / mandatory data
    # data format
    # data types
    
    #template for data entry
    /**
     * :sid' => 'softwareID',   #1
        ':sqn' => 'sequenceNum',  #2
        ':tle' => 'title',        #3
        ':yr'  =>  'year',        #4
        ':des' => 'description',  #5
        ':not' => 'notes',        #6
        ':hwr' => 'hardwareReq',  #7
        ':swr' => 'softwareReq',  #8
        ':lls' => 'licenceList',  #9
        ':nof' => 'numberOfFiles',#10 
        ':ins' => 'insertedDate', #11
        ':pid' => 'publisherID',  #12
        ':cid' => 'contributorID',#13 
        ':cty' => 'country'       #14
     */
    
    for($n = 0; $n < count($testData);$n++){
        insertNewSoftwareEntryByArray($testData[$n],0);
    }
    
    #validate last title
    #validate last year
    #validate last seqNum
    #validate last desc
    #validate last notes
    #validate last hardwareReq
    #validate last softwareReq
    #validate last licenceList
    #validate last numberOfFiles
    #validate last insertedDate
    #validate last publisherID
    #validate last contributorID
    #validate last country
    
    # a better test would test several tables *AND* the relationships between the entries
    # make sure all data is going to where it should be
    
    #ie an entry will test authors, software, author_software, contributor, publisher
    # NB credits table is not used at all...

}

/**
 * insertNewSoftwareEntryByArray
 * 
 * @global type $conn
 * @param type $_data
 * @param type $_debug
 *
 * basic insert
 * 
 * uses the order of attributes expected
 * tests each value for null
 * if not null, add the attribute and add the value
 * 
 * template: (NB THE QUERY SYNTAX DOESNT USE 'BACKTICKS')
 * INSERT INTO `software`(`softwareID`, 
 * `sequenceNum`, `title`, `year`, `description`, `notes`, 
 * `hardwareReq`, `softwareReq`, `licenceList`, `numberOfFiles`, 
 * `insertedDate`, `publisherID`, `contributorID`, `country`) 
 * VALUES 
 * ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],
 * [value-8],[value-9],[value-10],[value-11],[value-12],[value-13],[value-14])
 *
 * call validation queries ie validate country query
 * 
 * @param type $data
 * @param type $_debug
 */
FUNCTION insertNewSoftwareEntryByArray($_data, $_debug){
    if ($_debug) _msgBox('g', 'FN: insertNewSoftwareEntryByArray($_data, $_debug)');
    
    global $conn;
    
    $bind_atts = array(
        ':sid' => 'softwareID',   #1
        ':sqn' => 'sequenceNum',  #2
        ':tle' => 'title',        #3
        ':yr'  => 'year',         #4
        ':des' => 'description',  #5
        ':not' => 'notes',        #6
        ':hwr' => 'hardwareReq',  #7
        ':swr' => 'softwareReq',  #8
        ':lls' => 'licenceList',  #9
        ':nof' => 'numberOfFiles',#10 
        ':ins' => 'insertedDate', #11
        ':pid' => 'publisherID',  #12
        ':cid' => 'contributorID',#13 
        ':cty' => 'country'       #14
    );
    
    $q = 'INSERT INTO software (';
    $values = array(); #blank array to hold values given corresponding acceptable attribute names
    $usedAtts = array();
    #ATTRIBUTE NAMES
    foreach($_data as $k => $v){
        $pref = substr($k,0,6);
        #FILTER / validate attribute name before appending to query
        if($pref != 'author'     &&
            $k != 'publisher'    &&
            $k != 'altAddress'   &&
            $v != ''
        ){
            $q.= $k;
            $q.= ', ';
            $usedAtts[]=$k; # removes unwanted data
            $values[]=$v;
        }
    }

    $q.='insertedDate';
    $q.=') VALUES (';
    
    #ADD PDO PARMS
    #foreach PDO bind parm in $bindAtts assoc array
    
    #Cater for proper date encapsulation
    #SURROUND WITH QUOTES no longer used
    $insertedDate = (string) date('Y-m-d');
    
    foreach((array_keys($bind_atts)) as $bindParam){
        $attName = $bind_atts[$bindParam];
        if (in_array($attName, $usedAtts)){
            $q.= $bindParam;
            $q.= ', '; #final comma is ok as there is still one more value to append (insertedDate)
        }
    }
    $q.= $insertedDate;
    $q.= ')';
    
    if ($_debug) echo '<hr><b>'.$q.'</b><hr>';
    
    #mergeArrays into an assoc
    $merge = array_combine($usedAtts, $values);
    $stmt = $conn->prepare($q);
    #BINDING via associative array directly not workign for some reason
    #$res = $stmt->execute($merge);
    # @@@ to do: VALIDATE
    
    #########
    #BINDING via each parm in a loop (foreach)
    if($_debug){
        echo 'binding parms...<br>';
        
    }
    #########
    $counter = 0;
    foreach($bind_atts as $k => $v){ #k is bind parm, v is att name
        echo $counter+1; #sihft form zero-based index to 1-based for diplay purposes only
        if(in_array($v, $usedAtts) && ($values[$counter]!='')){
            echo ': binding parm: '.$k.' with val: '.$values[$counter].'<br>';
            #$stmt->bindValue((string) $k, (string) $values[$counter]);
            $stmt->bindValue( ((string) $k), (string) $values[$counter]);
            $counter++; #position here is critical
        } else {
            echo '<br>';
        }
    }
    $stmt->execute();
    
    if ($_debug) print_r($merge);
    if ($_debug) echo '### VALIDATION ###<br>';
    if(validateInsertion($merge)){
        if ($_debug) _msgBox('g', 'FN: VALIDATE INSERTION complete...');
    }
}  

/**
 * augmentSoftwareEntry_test
 * 
 * pick some random titles / IDs
 * augment the entries with known data
 * test the existence of the new augmented entries
 * delete all test entries
 * 
 */
function augmentSoftwareEntry_test(){
    
    echo '<h2>TESTING augment </h2>';
    
    global $conn;
    $testIDs = array(3,5,7);
    #Get max seqNums ($maxSNs)
    $maxSNs = array();
    $counter = 0;
    
    foreach($testIDs as $ID){
        echo $counter.'<br>';
        
        $maxSNs[]= queryMaxSeqNumFromSoftware($ID, 0);
        
        $counter++;
    }
    
    echo $maxSNs[0].'<br>';
    echo $maxSNs[1].'<br>';
    echo $maxSNs[2].'<br>';
    
    #example
    $results = queryAllvSoftwareByID($testIDs[1]);
    
    #augment notes param
    $results['notes'] = 'augmentedData_'.rand(1,100000);
    print_r($results);
    _msgBox('g', 'simple augmentation test done');
}

/**
 * augmentSoftwareBind - MANUAL BIND
 * 
 * binds parms manually (as oppossed to iterating over an array)
 * using values held in global variables
 * 
 * @global type $softwareID
 * @global type $sequenceNum
 * @global type $title
 * @global type $year
 * @global type $description
 * @global type $notes
 * @global type $licenceList
 * @global type $numberOfFiles
 * @global type $hardwareReq
 * @global type $softwareReq
 * @global type $publisherID
 * @global type $contributorID
 * @global type $country
 * @param type $_pdo_stmt
 * @param type $_query
 * @return type
 */

function _t_augmentSoftwareBindManually($_pdo_stmt, $_query, $_debug){
    
    if ($_debug) _msgBox('b', 'function: <b>augmentSoftwareBind (manual)</b>');
    
    GLOBAL $softwareID, $seqNum, $title, $year,
            $description, $notes, $licenceList, $numberOfFiles,
            $hardwareReq, $softwareReq, $publisherID, $contributorID,
            $country;
    
    $insertedDate = (string) date("Y-m-d");
    
    $spos = strpos($_query, ':a');
    if ($spos){
        #if ($_debug) echo 'binding :a ...<br>';
        $_pdo_stmt->bindParam(':a',$softwareID);
    }
    $spos = strpos($_query, ':b');
    if ($spos){
        #if ($_debug) echo 'binding :b ...<br>';
        $_pdo_stmt->bindParam(':b',$seqNum); #may need to be updated
    }
    $spos = strpos($_query, ':c');
    if ($spos){
        #if ($_debug) echo 'binding :c ...<br>';
        $_pdo_stmt->bindParam(':c',$title);
    }
    $spos = strpos($_query, ':d');
    if ($spos){
        #if ($_debug) echo 'binding :d ...<br>';
        $_pdo_stmt->bindParam(':d',$year);
    }
    $spos = strpos($_query, ':e');
    if ($spos){
        #if ($_debug) echo 'binding :e ...<br>';
        $_pdo_stmt->bindParam(':e',$description);
    }
    $spos = strpos($_query, ':f');
    if ($spos){
        #if ($_debug) echo 'binding :f ...<br>';
        $_pdo_stmt->bindParam(':f',$notes);
    }
    $spos = strpos($_query, ':g');
    if ($spos){
        #if ($_debug) echo 'binding :g ...<br>';
        $_pdo_stmt->bindParam(':g',$hardwareReq);
    }
    $spos = strpos($_query, ':h');
    if ($spos){
        #if ($_debug) echo 'binding :h ...<br>';
        $_pdo_stmt->bindParam(':h',$softwareReq);
    }
    $spos = strpos($_query, ':i');
    if ($spos){
        #if ($_debug) echo 'binding :i ...<br>';
        $_pdo_stmt->bindParam(':i',$licenceList);
    }
    $spos = strpos($_query, ':j');
    if ($spos){
        #if ($_debug) echo 'binding :j ...<br>';
        $_pdo_stmt->bindParam(':j',$numberOfFiles);
    }
    $spos = strpos($_query, ':k');
    #DEBUG echo 'date to be inserted (todays date)'.$insertedDate.'<br>';
    if ($spos){
        #if ($_debug) echo 'binding :k ...<br>';
        $_pdo_stmt->bindParam(':k',$insertedDate);
    }
    $spos = strpos($_query, ':l');
    if ($spos){
        #if ($_debug) echo 'binding :l ...<br>';
        $_pdo_stmt->bindParam(':l',$publisherID);
    }
    $spos = strpos($_query, ':m');
    if ($spos){
        #if ($_debug) echo 'binding :m ...<br>';
        $_pdo_stmt->bindParam(':m',$contributorID);
    }
    $spos = strpos($_query, ':n');
    if ($spos){
        #if ($_debug) echo 'binding :n ...<br>';
        $_pdo_stmt->bindParam(':n',$country);
    }
    
    _msgBox('g', 'function complete, returning stmtAug:');
    #print_r($_pdo_stmt);
    
    return $_pdo_stmt;
}

/**
 * augmentSoftwareUpdateGlobals
 * 
 * void 
 * 
 * @global type $softwareID
 * @global type $sequenceNum
 * @global type $title
 * @global type $year
 * @global type $description
 * @global type $notes
 * @global type $licenceList
 * @global type $numberOfFiles
 * @global type $hardwareReq
 * @global type $softwareReq
 * @global type $publisherID
 * @global type $contributorID
 * @global type $country
 * @param type $_newData
 */
function augmentSoftwareUpdateGlobals($_newData, $_debug){
    
    if ($_debug) _msgBox('b', 'function: <b>augmentSoftwareUpdateGlobals (manual)</b>');
    
    GLOBAL $softwareID, $sequenceNum, $title, $year,
            $description, $notes, $licenceList, $numberOfFiles,
            $hardwareReq, $softwareReq, $publisherID, $contributorID,
            $country;
    
    if($_newData['softwareID']){
        $softwareID = $_newData['softwareID'];
    }
    if($_newData['sequenceNum']){
        $softwareID = $_newData['sequenceNum'];
    }
    if($_newData['title']){
        $title = $_newData['title'];
    }
    if($_newData['year']){
        $year = $_newData['year'];
    }
    if($_newData['description']){
        $description = $_newData['description'];
    }
    if($_newData['notes']){
        $notes = $_newData['notes'];
    }
    if($_newData['hardwareReq']){
        $hardwareReq = $_newData['hardwareReq'];
    }
    if($_newData['softwareReq']){
        $softwareReq = $_newData['softwareReq'];
    }
    if($_newData['licenceList']){
        $licenceList = $_newData['licenceList'];
    }
    if($_newData['numberOfFiles']){
        $numberOfFiles = $_newData['numberOfFiles'];
    }
    /**
    if($_newData['insertedDate']){
        $insertedDate = $_newData['insertedDate'];
    }*/
    if($_newData['publisherID']){
        $publisherID = $_newData['publisherID'];
    }
    if($_newData['contributorID']){
        $contributorID = $_newData['contributorID'];
    }
    if($_newData['country']){
        $country = $_newData['country'];
    }
    _msgBox('g', 'function complete, globals updated:');
}

/**
 * augmentSoftwareBuildBindArrays
 * 
 * @param type $_newData
 * @param type $insertionColumns
 * @param type $insertionValues
 * @param type $insertionBindVars
 * @param type $_debug
 * @return array (recursive)
 */
function augmentSoftwareBuildBindArrays($_newData, 
                                        $insertionColumns, 
                                        $insertionValues, 
                                        $insertionBindVars,
                                        $_debug){
    
    if ($_debug) _msgBox('b', 'function augmentSoftwareBuildBindArrays reached , return 3 arrays...');
    
    #$returnArray = array();
    
    echo 'Arrays before<br>';
    echo '<hr>';
    echo '$insertionColumns';
    print_r($insertionColumns);
    echo '<br>$insertionValues';
    print_r($insertionValues);
    echo '<br>$insertionBindVars';
    print_r($insertionBindVars);
    echo '<hr>';
    
    #a,swID,(int) how could sid be null at all if we are augmenting an entry ?
    if(!is_null($_newData['softwareID']) && ($_newData['softwareID']!='')){
        $insertionColumns[]= 'softwareID';
        $insertionBindVars[]= ':a';
        $insertionValues[]= $_newData['softwareID'];
    } 

    #b,seqNum,(int) # seqNum cannot be 1 now as we are augmenting an existing software title
    if(!is_null($_newData['sequenceNum']) && ($_newData['sequenceNum']!='') && $_newData['sequenceNum']>1){
        $insertionColumns[]= 'sequenceNum'; #note no $ symbol
        $insertionBindVars[]= ':b';
        $insertionValues[]= $_newData['sequenceNum'];
    }
    
    #c,title,(string)
    if(!is_null($_newData['title']) && ($_newData['title']!='')){
        $insertionColumns[]= 'title'; #note no $ symbol
        $insertionBindVars[]= ':c';
        $insertionValues[]= $_newData['title'];
    }
    
    #d,yr,(date)
    if(!is_null($_newData['year']) && ($_newData['year']!='')){
        $insertionColumns[]= 'year'; #note no $ symbol
        $insertionBindVars[]= ':d';
        $insertionValues[]= $_newData['year'];
    }
    
    #e,description,(string)
    if(!is_null($_newData['description']) && ($_newData['description']!='')){
        $insertionColumns[]= 'description'; #note no $ symbol
        $insertionBindVars[]= ':e';
        $insertionValues[]= $_newData['description'];
    }

    #f,notes,(string)
    if(!is_null($_newData['notes']) && ($_newData['notes']!='')){
        $insertionColumns[]= 'notes'; #note no $ symbol
        $insertionBindVars[]= ':f';
        $insertionValues[]= $_newData['notes'];
    }
    
    #g,HWReq,(string)
    if(!is_null($_newData['hardwareReq']) && ($_newData['hardwareReq']!='')){
        $insertionColumns[]= 'hardwareReq'; #note no $ symbol
        $insertionBindVars[]= ':g';
        $insertionValues[]= $_newData['hardwareReq'];
    }
    
    #h,swReq,(string)
    if(!is_null($_newData['softwareReq']) && ($_newData['softwareReq']!='')){
        $insertionColumns[]= 'softwareReq'; #note no $ symbol
        $insertionBindVars[]= ':h';
        $insertionValues[]= $_newData['softwareReq'];
    }
    
    #i,licenceList,(string)
    if(!is_null($_newData['licenceList']) && ($_newData['licenceList']!='')){
        $insertionColumns[]= 'licenceList'; #note no $ symbol
        $insertionBindVars[]= ':i';
        $insertionValues[]= $_newData['licence'];
    }
    
    #j,numberOfFiles,(int)
    if(!is_null($_newData['numberOfFiles']) && ($_newData['numberOfFiles']!='')){
        $insertionColumns[]= 'numberOfFiles'; #note no $ symbol
        $insertionBindVars[]= ':j';
        $insertionValues[]= $_newData['numberOfFiles'];
    }
    
    #k,insertedDate,(int)
    if(!is_null($_newData['insertedDate']) && ($_newData['insertedDate']!='')){#always true !
        $insertionColumns[]= 'insertedDate'; #note no $ symbol
        $insertionBindVars[]= ':k';
        $insertionValues[]= $_newData['insertedDate'];
    }
    
    #l,publisherID,(int)
    if(!is_null($_newData['publisherID']) && ($_newData['publisherID']!='')){
        $insertionColumns[]= 'publisherID'; #note no $ symbol
        $insertionBindVars[]= ':l';
        $insertionValues[]= $_newData['publisherID'];
    }
    
    #m,contibutorID,(int)
    if(!is_null($_newData['contributorID']) && ($_newData['contributorID']!='')){
        $insertionColumns[]= 'contibutorID'; #note no $ symbol
        $insertionBindVars[]= ':m';
        $insertionValues[]= $_newData['contributorID'];
    }
    
    #n,Country,(string)
    if(!is_null($_newData['country']) && ($_newData['country']!='')){
        $insertionColumns[]= 'country'; #note no $ symbol
        $insertionBindVars[]= ':n';
        $insertionValues[]= $_newData['country'];
        
    }
    
    if ($_debug){
        echo 'Arrays After:<br>';
        echo '<hr>';
        echo '$insertionColumns<br>';
        print_r($insertionColumns);
        
        echo '<br>$insertionValues<br>';
        print_r($insertionValues);
        
        echo '<br>$insertionBindVars<br>';
        print_r($insertionBindVars);
        echo '<hr>';
    }
    
    _msgBox('g','FN: function complete, returning $returnArray (recursive array of 3 bind arrays)');
    
    # return recrusive array of 3 arrays
    $returnArray = array($insertionColumns, $insertionBindVars, $insertionValues);
    return $returnArray;
}

/** 
 * augmentSoftwareEntry()
 * 
 * when not passing an array, the function to augment data in the DB
 * must rely on global variables
 * 
 * to insert *augmented* data into the database Entry
 * ##the old data must have been obtained first##
 * it needs to be inserted into both / several tables:
 *
 * IMPORTANT
 * this function inserts *globals* with seqNum *ALREADY* incremented
 * 
 * so globals are updated first, no data to be inserted is passed 
 * as function parms...not ideal, passing in an array seems cleaner
 * 
 * * software AND 
 * author-software 
 * 
 * NB if global seqNum has already been incremented, 
 * there is no point in passing it as a function parm
 * 
 */

FUNCTION _t_augmentSoftwareEntry($_newData, $_debug){ #softwareID should be a parm for more 'security' ?
    if ($_debug) _msgBox('b', 'function: <b>augmentSoftwareEntry</b>');
    
    if (!$_newData){
        die('something went horribly wrong with incoming array $_newData...');
    } else {
        if ($_debug){
            print_r($_newData);
        }
    }
    
    $conn = connectDB();
    #var_dump($conn);
    
    GLOBAL $title, $year, $softwareID, $licence, $numberOfFiles, $publisherID,
            $contributorID;
    
    GLOBAL $seqNum;
            
    GLOBAL  $authorGivenName,
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
            $altAddress,
            
            $publisher, $country, $hardwareReq, $softwareReq, 
            $description, $notes,
            $filesNum;
    
    ###### Validate maxSeqNum for that softwareID # moved to be external to this function...
    echo 'seqNum was: '.$seqNum.'<br>';
    #Q
    $s1 = queryMaxSeqNumFromSoftware($softwareID,0); #$_debug = 0 (# by swid)
    echo '$s1(queried seqNum):'.$s1.'<br>';
    #new seqNum
    $_newSeqNum = $_newData['sequenceNum'];
    echo '$_newSeqNum: '.$_newSeqNum.'<br>';
    $seqNum = $_newSeqNum; #increment / update seqNum
    
    
    #Form basis for QUERY (for software table)
    $queryAugmentEntry = 'INSERT INTO software ('
        . 'softwareID, '
        . 'sequenceNum, ' #already incremented in modifyEntry.php
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
        $queryAugmentEntry.=':a, '; #softwareID
        $queryAugmentEntry.=':b, '; #sequenceNum
        $queryAugmentEntry.=':c, '; #title
        $queryAugmentEntry.=':d, '; #year

        $queryAugmentEntry.=':e, '; #description
        $queryAugmentEntry.=':f, '; #notes
        $queryAugmentEntry.=':g, '; #hardwareReq
        $queryAugmentEntry.=':h, '; #softwareReq
        
        $queryAugmentEntry.=':i, '; #licenceList
        $queryAugmentEntry.=':j, '; #
        $queryAugmentEntry.=':k, '; #
        $queryAugmentEntry.=':l, '; #

        $queryAugmentEntry.=':m, '; #
        $queryAugmentEntry.=':n '; #$queryAugmentEntry.=' '; # no comma for last element
        $queryAugmentEntry.=')';# and no colon required
    
    # we only want to add *new* data, and not duplicate data
    # (when comparing multiple entries on the same software title)
    
    ################################################
    ### @@@ to do: TEST FOR DUPLICATE DATA
    # need to run over all variables intended for insertion
    # and compare with values from previous seqNum
    ################################################
    
    $queryAugmentEntry_built = 'INSERT INTO software (';
    $echoQuery = $queryAugmentEntry_built;
    
    # the col names in the DB table are appended to the query
    # (for data insertion)
    # 2 versions of the var are made for both cases (strreplace doesnt like surrounding quotes)
    
    # date should already be taken care of now for display in tables
    # currently appended to end - but ideally should be located after
    # numberOfFiles to match old Data order
    # possibly make a function of split, insert and rejoin arrays after a specific key
    # 
    # $insertedDate = (string) date("Y-m-d");
    # echo '$insertedDate: '.$insertedDate.'<br>';
    echo 'insertedDate: '.$_newData['insertedDate'].'<br>';
    
    $insertionValues = array();#synch the use of the two arrays
    $insertionColumns = array();
    $insertionBindVars = array();
    
    # at one stage order was jumbled and broken
    # easiest execution method for large number of bind parms is with an associative array
    ## BUILD ARRAYS TO USE TO BUILD QUERY
    
    # a,swID,(int) 
    # NB
    # how could sid be null at all if we are augmenting an entry ?
    # sid cannot change if we are aumenting either
    
    #Acid test a
    if($softwareID !== $_newData['softwareID']){
        die('something went horribly wrong with $_newData[\'softwareID\']');
    }
    
    if(!is_null($softwareID) && ($softwareID!='')){
        #array_push($tables, $softwareID); #uses more overhead (using a function)
        $insertionColumns[]= 'softwareID'; 
        $insertionValues[]= ':a';
        $insertionBindVars[]= $softwareID;
    } 
    
    #Acid test b
    if($seqNum !== $_newData['sequenceNum']){
        die('something went horribly wrong with $_newData[\'sequenceNum\']');
    }
    # b,seqNum,(int) # seqNum cannot be 1 now as we are augmenting an existing software title
    if(!is_null($seqNum) && ($seqNum!='') && $seqNum>1){
        $insertionColumns[]= 'sequenceNum'; #note no $ symbol
        $insertionValues[]= ':b';
        $insertionBindVars[]= $seqNum;
    }
    
    #Acid test c
    if($title !== $_newData['title']){
        die('something went horribly wrong with $_newData[\'title\']');
    }
    #$title = $_newData['title'];
    # c,title,(string)
    if(!is_null($title) && ($title!='')){
        $insertionColumns[]= 'title'; #note no $ symbol
        $insertionValues[]= ':c';
        $insertionBindVars[]= $title;
    }
    
    #Acid test d
    if($year !== $_newData['year']){
        #die('something went horribly wrong with $_newData[\'year\']');
        _msgBox('y','yr global ($year) was not equal to new form data $_newData[\'year\'], equalising now...');
        $year = $_newData['year'];
    }
    # d,yr,(date)
    if(!is_null($year) && ($year!='')){
        $insertionColumns[]= 'year'; #note no $ symbol
        $insertionValues[]= ':d';
        $insertionBindVars[]= $year;
    }
    
    #Acid test e
    if($description !== $_newData['description']){
        #die('something went horribly wrong with $_newData[\'year\']');
        _msgBox('y','global $description was not equal to new form data $_newData[\'description\'], equalising now...');
        $description = $_newData['description'];
    }
    # e,description,(string)
    # NB use of surround with Quotes
    if(!is_null($description) && ($description!='')){
        $insertionColumns[]= 'description'; #note no $ symbol
        $insertionValues[]= ':e';
        #$insertionVars[]= surroundWithQuotes($description,0);
        $insertionBindVars[]= $description;
    }
    
    #Acid test f
    if($notes !== $_newData['notes']){
        #die('something went horribly wrong with $_newData[\'year\']');
        _msgBox('y','global notes was not equal to new form data $_newData[\'notes\'], equalising now...');
        $notes = '"'.$notes.'"';
        $notes = $_newData['notes'];
    }
    # f,notes,(string)
    # NB use of surround with Quotes
    
    # test if they are equal do not add them again ?
    if(!is_null($notes) && ($notes!='')){
        $insertionColumns[]= 'notes'; #note no $ symbol
        $insertionValues[]= ':f';
        #$insertionVars[]= surroundWithQuotes($notes,0);
        _msgBox('o', '$notes: '.$notes);
        $insertionBindVars[]= $notes;
    }
    
    #Acid test g
    if($hardwareReq !== $_newData['hardwareReq']){
        #die('something went horribly wrong with $_newData[\'year\']');
        _msgBox('y','global $hardwareReq was not equal to new form data $_newData[\'hardwareReq\'], equalising now...');
        $hardwareReq = $_newData['hardwareReq'];
    }
    # g,HWReq,(string)
    if(!is_null($hardwareReq) && ($hardwareReq!='')){
        $insertionColumns[]= 'hardwareReq'; #note no $ symbol
        $insertionValues[]= ':g';
        $insertionBindVars[]= $hardwareReq;
    }
    
    #Acid test h
    if($softwareReq !== $_newData['softwareReq']){
        _msgBox('y','global $softwareReq was not equal to new form data $_newData[\'softwareReq\'], equalising now...');
        $softwareReq = $_newData['softwareReq'];
    }
    # h,swReq,(string)
    if(!is_null($softwareReq) && ($softwareReq!='')){
        $insertionColumns[]= 'softwareReq'; #note no $ symbol
        $insertionValues[]= ':h';
        $insertionBindVars[]= $softwareReq;
    }
     #Acid test i
    if($licence !== $_newData['licenceList']){
        _msgBox('y','global licence was not equal to new form data $_newData[\'licence\'], equalising now...');
        $softwareReq = $_newData['licenceList'];
    }
    # i,licenceList,(string)
    if(!is_null($licence) && ($licence!='')){
        $insertionColumns[]= 'licenceList'; #note no $ symbol
        $insertionValues[]= ':i';
        $insertionBindVars[]= $licence;
    }
    #Acid test j
    if($numberOfFiles !== $_newData['numberOfFiles']){
        _msgBox('y','global $numberOfFiles was not equal to new form data $_newData[\'numberOfFiles\'], equalising now...');
        $softwareReq = $_newData['numberOfFiles'];
    }
    # j,numberOfFiles,(int)
    if(!is_null($numberOfFiles) && ($numberOfFiles!='')){
        $insertionColumns[]= 'numberOfFiles'; #note no $ symbol
        $insertionValues[]= ':j';
        $insertionBindVars[]= $numberOfFiles;
    }
     #Acid test j inserted Date will not be present in the array of form data - it is added seperately
    #special case of setting the data
    $insertedDate = (string) date("Y-m-d");
    $_newData['insertedDate'] = $insertedDate;
    $insertionColumns[]= 'insertedDate'; #note no $ symbol
    $insertionValues[]= ':k';
    $insertionBindVars[]= $insertedDate;
    
    
    #Acid test l
    if($publisherID !== $_newData['publisherID']){
        _msgBox('y','global $publisherID was not equal to new form data $_newData[\'publisherID\'], equalising now...');
        $publisherID = $_newData['publisherID'];
    }
    # l,publisherID,(int)
    if(!is_null($publisherID) && ($publisherID!='')){
        $insertionColumns[]= 'publisherID'; #note no $ symbol
        $insertionValues[]= ':l';
        $insertionBindVars[]= $publisherID;
    }
    
    #Acid test m
    if($contributorID !== $_newData['contributorID']){
        _msgBox('y','global $contributorID was not equal to new form data $_newData[\'contributorID\'], equalising now...');
        $contributorID = $_newData['contributorID'];
    }
    # m,contibutorID,(int)
    if(!is_null($contributorID) && ($contributorID!='')){
        $insertionColumns[]= 'contibutorID'; #note no $ symbol
        $insertionValues[]= ':m';
        $insertionBindVars[]= $contributorID;
    }
    
    #Acid test n
    if($country !== $_newData['country']){
        _msgBox('y','global $country was not equal to new form data $_newData[\'country\'], equalising now...');
        $country = $_newData['country'];
    }
    # n,Country,(string)
    if(!is_null($country) && ($country!='')){
        $insertionColumns[]= 'country'; #note no $ symbol
        $insertionValues[]= ':n';
        $insertionBindVars[]= $country;
    }
    # iterate over both arrays to add relevant col names and varaiables
    $size = count($insertionColumns);
 
   /**LOOP OVER ARARYS, inserting columns #2
    * size-1 excludes the last entry (added explicitly / manually) to omit final comma
    * alternatively could search for and truncate the final comma afterwards
    */
    #////////////////////////////////////////////////////////////
    #LOOP1
    for($i=0;$i<($size-1);$i++){ 
        #if ($_debug == 2) echo ($i+1).': ';
        #$queryAugmentEntry_built.= '['.$i.']';
        $queryAugmentEntry_built.= '`';
        $queryAugmentEntry_built    .= $insertionColumns[$i];
        $queryAugmentEntry_built.= '`';
        
        #$echoQuery.= '['.$i.']';
        $echoQuery .= '`';
        $echoQuery                  .= $insertionColumns[$i];
        $echoQuery .= '`';
        #comma
        $queryAugmentEntry_built.= ', ';
        #$queryAugmentEntry_built.= '<br>';
        $echoQuery .= ', ';
        $echoQuery .= '<br>';
        #if ($_debug == 2) echo $insertionColumns[$i].' added to query columns...<br>';
    }
    
    #Singleton case added
    #echo 'print_r($insertionColumns):';
    #print_r($insertionColumns);
    $queryAugmentEntry_built.= '`';
    $queryAugmentEntry_built.= $insertionColumns[$size-1];#the last entry cannot be followed by a comma
    $queryAugmentEntry_built.= '`';
    
    $echoQuery .= '`';
    $echoQuery .= $insertionColumns[$size-1];
    $echoQuery .= '`';
    
    if ($_debug){
        echo $size.': ';
        echo $insertionColumns[$size-1].' added to query columns...<br>';
        echo '<hr>';
    }
    
    #////////////////////////////////////////////////////////////
    $queryAugmentEntry_built.= ') VALUES ( ';
    $echoQuery.= ')<br> VALUES ( ';
    
    if ($_debug==2){
        echo 'qbuilt:<br>';
        _msgBox('g',$queryAugmentEntry_built);

        echo 'eQ:<br>';
        _msgBox('y',$echoQuery);
    }
    
    $bindArray = array();#loop to add insertion values
    
    #LOOP2
    for($i=0;$i<($size-1);$i++){ #-1 excludes the last entry
        #if ($_debug == 2) echo ($i+1+$size).': ';
        $queryAugmentEntry_built.= $insertionValues[$i];
        $queryAugmentEntry_built.= ', ';
        $echoQuery      .= $insertionValues[$i];
        $echoQuery      .= ', ';
        if ($_debug == 2) echo $insertionValues[$i].' added to query bind-values...<br>';
    }
    #Singleton Case
    
    if ($_debug == 2) echo ($size*2).': ';
    if ($_debug == 2) echo $insertionValues[$size-1].' added to query bind-values...<br>';
    
    $queryAugmentEntry_built.= $insertionValues[$size-1];#last entry cannot be followed by a comma
    $queryAugmentEntry_built.= ')';
    
    $echoQuery .= $insertionValues[$size-1];
    $echoQuery .= ')';
    
    #CLOSED QUERY#////////////////////////////////////////////////////////////
    
    if ($_debug) echo '<hr>';
    #NB no comma here (last element in a list), and a trialing semi-colon will break the query 
    
    if ($_debug==2){
        $echoQuery2 = $queryAugmentEntry_built;
        _msgBox('y', '$echoQuery:<br>'.$echoQuery);
        #_msgBox('g', '$queryAugmentEntry_built:<br>'.$echoQuery2);
        
        $echoQuery = str_replace(':a', $softwareID.'<br>',   $echoQuery); #01
        $echoQuery = str_replace(':b', $_newSeqNum.'<br>',       $echoQuery); #02
        $echoQuery = str_replace(':c', $title.'<br>',        $echoQuery); #03
        $echoQuery = str_replace(':d', $year.'<br>',         $echoQuery); #04
        
        $echoQuery = str_replace(':e', '\''.$description.'\''.'<br>',  $echoQuery); #05
        $echoQuery = str_replace(':f', $notes.'<br>',        $echoQuery); #06
        $echoQuery = str_replace(':g', $hardwareReq.'<br>',  $echoQuery); #07
        if ($softwareReq != ' ') $echoQuery = str_replace(':h', $softwareReq.' ',  $echoQuery); #08
        
        $echoQuery = str_replace(':i', $licence.'<br>',      $echoQuery); #09
        $echoQuery = str_replace(':j', $numberOfFiles.'<br>',$echoQuery); #10
        $echoQuery = str_replace(':k', $insertedDate, $echoQuery); #11
        if ($publisherID!=' ') $echoQuery = str_replace(':l', $publisherID.' ',  $echoQuery); #12
        
        if ($contributorID!=' ') $echoQuery = str_replace(':m', $contributorID.' ',$echoQuery); #13
        $echoQuery = str_replace(':n', $country.' ',       $echoQuery); #14 (no comma)
    }
    
    $lightGreen = '#ccffcc';
    _msgBox('y', $echoQuery);
    echo '<hr>';
    if ($_debug) _msgBox($lightGreen,'final Augment Query:');
    _msgBox('g', $queryAugmentEntry_built);
    echo '<hr>';
    var_dump($conn);
    
    #PREPARE THEN BIND
    $stmtAug = $conn->prepare($queryAugmentEntry_built);
    ########################################################
    # MANUAL BINDING
    ########################################################
    /**
     * should be tidied up to 
     * a) be executed in a loop but cannot get looped binding to work
     * b) executed from an assoc-array of bind params
     * c) 'spos' is used purely to detect if a substring is present or not
     */
    #echo 'augmentQuery still working(2544)...<hr>';
    
    ########################################################
    #$stmtAug->bindParam('a',$softwareID);
    #$stmtAug->bindParam('b',$seqNum); #may need to be updated
    #$stmtAug->bindParam('c',$title);
    #$stmtAug->bindParam('d',$year);
    #$stmtAug->bindParam('e',$description);
    #$stmtAug->bindParam('f',$notes);
    #$stmtAug->bindParam('g',$hardwareReq);
    #$stmtAug->bindParam('h',$softwareReq);
    #$stmtAug->bindParam('i',$licenceList);
    #$stmtAug->bindParam('j',$numberOfFiles);
    #$stmtAug->bindParam('k',$insertedDate);
    #$stmtAug->bindParam('l',$publisherID);
    #$stmtAug->bindParam('m',$contributorID);
    #$stmtAug->bindParam('n',$country);
    
    $stmtAug->bindValue('a',1933);
    $stmtAug->bindValue('b',3);
    $stmtAug->bindValue('c','Stopwatch Timer');
    $stmtAug->bindValue('d',1982);
    $stmtAug->bindValue('e','cool');
    $stmtAug->bindValue('k',((string) date("Y-m-d")));
    $stmtAug->bindValue('l',207);
    $stmtAug->bindValue('m',82);
    $stmtAug->bindValue('n','Australia');
    
    #DEBUG
    echo 'StmtAug type : '.gettype($stmtAug).' ';
    if ($stmtAug){
        echo 'true';
    } else {
        echo 'false';
    }
    echo '<br>';
    echo '<br>';
    
    if ($_debug) echo '(fn:augment->validation)seqNum was = '.$s1.'<br>';
    ########################################################
    $stmtAug->execute();
    echo 'stmt executed...<br>';
    
    ########################################################
    ##VALIDATION (check this function again)
    ########################################################
    if(validateAugment($s1, $softwareID, 1)){ #3rd parm is for $_debug
        if ($_debug) _msgBox('g','FN: AUGMENT SOFTWARE ENTRY complete...');
    } else {
        _msgBox('o','seqNum increment validation fail');
    }
}

/**
 * new version of the augment method based of the insert new Entry method
 * 
 * @global type $conn
 * @param type $_newData
 * @param type $_debug
 */
function _t_augmentSoftwareEntry2($_newData, $_debug){
    
    if ($_debug) _msgBox('b', 'FN: augmentSoftwareEntry2 (ByArray) ($_data, $_debug)');
    
    global $conn;
    
    # all possible data attributes to be used in an insert statement (order doesnt matter
    # in a query as long as names and values correspond)
    $placeHolders = array(
        ':sid' => 'softwareID',   #1
        ':sqn' => 'sequenceNum',  #2
        ':tle' => 'title',        #3
        ':yr'  => 'year',         #4
        ':des' => 'description',  #5
        ':not' => 'notes',        #6
        ':hwr' => 'hardwareReq',  #7
        ':swr' => 'softwareReq',  #8
        ':lls' => 'licenceList',  #9
        ':nof' => 'numberOfFiles',#10 
        ':ins' => 'insertedDate', #11
        ':pid' => 'publisherID',  #12
        ':cid' => 'contributorID',#13 
        ':cty' => 'country'       #14
    );
    
    $q = 'INSERT INTO software (';
    $values = array(); #blank array to hold values given corresponding acceptable attribute names
    $usedAtts = array();
    # LOOP 1 ATTRIBUTE NAMES (defines order or values entered in, thus order of placeHolder->value bindings)
    $counter=0;
    foreach(array_keys($_newData) as $data){
        $pref = substr($data,0,6);
        #FILTER / validate attribute name before appending to query
        if($pref != 'author'     &&
            $data != 'publisher'    &&
            $data != 'altAddress'   &&
            $data != 'insertedDate' && #skip date for now - append at the end
            $data != ''
        ){
            #$data = '"'.$data.'"';
            $usedAtts[]= $data; #auto conversion to string
            $q.= $data;
            $q.= ', ';
        }
    }
    $q.='insertedDate';
    $q.=') VALUES (';
    
    #ADD PDO placeholders
    
    $dt = '"'.date("Y-m-d").'"';
    
    # foreach loop defines order of atts used - must have the same order as beginning of query
    # LOOP 2 VALUES
    foreach($usedAtts as $data){ #bindParm is the abreviated bind parameter ie :sid
        
        #GET INDEX
        #iterate placeHolder array to find position of $data (attribute name)
        $index = 0;
        while($data != array_values($placeHolders)[$index]){
            #echo $index.'...<br>';
            $index+=1;
        }
        $ph  = array_keys($placeHolders)[$index];
        #echo $ph.'<br>';
        $q.= $ph;
        $q.= ', '; #final comma is ok as there is still one more special case of date
        #$_newData[$data] = '"'.$_newData[$data].'"';
        $values[]= $_newData[$data]; #add value to values
    }
    echo '$insertedDate: '.$dt.'<br>';
    
    #$insertedDate = '"'.$dt.'"';
    $q.= $dt;
    $q.= ')';
    
    echo '$q:<br>'.$q.'<br>';
    #END OF QUERY BUILD
    
    if ($_debug) echo '<hr><b>'.$q.'</b><hr>';
    #mergeArrays into an assoc
    echo 'merging arrays...<br>';
        #print arrays
        echo '<table border ="1">';
        echo '<tr>';
        echo '<td>';
        #array, colour, precentage of screen width, indexed (binary value), $_debug
        displayDataInTableFromAssocArray($usedAtts, 'blue', 50, 0, 0);
        echo '</td>';
    
        echo '<td>';
        #array, colour, precentage of screen width, indexed (binary value), $_debug
        displayDataInTableFromAssocArray($values, 'blue', 50, 0, 0);
        echo '</td>';
    echo '</tr>';
    echo '</table>';
    $merge = array_combine($usedAtts, $values);
    
    #Append date to the end of the mered array
    #$merge = assocArrayPush($merge, 'insertedDate', $dt ,1); #dont forget ot reassign to modify the array
    
    #$clean = array();
    #displayDataInTableFromAssocArray($clean, 'blue', 100, 1, 0);
    
    #$clean = cleanEmptyElements($merge);
    
    #test query works
    /*
    $q = 'select * from software WHERE softwareID = 10';
    echo '<hr>test query: '.$q.'<br>';
    
    $stmt = $conn->prepare($q);
    #var_dump($conn);
    $stmt->bindValue(':s','10');
    $stmt->execute();
    $res=$stmt->fetch(PDO::FETCH_ASSOC);
    print_r($res);
    
    echo 'test<hr>';
    #displayDataInTableFromAssocArray($res, 'blue', 100, 0);
    exit;
    */
    $stmt = $conn->prepare($q);
    #print_r($stmt);
    
    $stmt->execute($merge);
    echo '<br>';
    if ($_debug) print_r($merge);
    if ($_debug) echo '### VALIDATION ###<br>';
    
    #this validate augment function is n0t working
    #its comparing two sets of data - but we know that they the elements will not
    # be equal inherently anyway
    
    $softwareID = $merge['softwareID'];
    $_s1 = $merge['sequenceNum'];
    
    if(validateAugment($_s1, $softwareID, 1)){
        if ($_debug) _msgBox('g', 'FN: VALIDATE INSERTION complete...');
    }
}
    
    
    /*
     * at this stage validation should confirm that there is n+1 entries
     * with this same softwareID
     * 
     */

    /**
     * 
     * augmentSoftwareEntry3
     * 
     * @global type $conn
     * @param type $_newData
     * @param type $_debug
     */
    function augmentSoftwareEntry3( $_newData , $_debug){
    
    if ($_debug) _msgBox('b', 'FN: augmentSoftwareEntry3 reached... ($_data, $_debug)');
    global $conn;
    
    #confirm connection
    echo '<hr>';
        if($conn){
            _msgBox('g', '#confirmed connection object exists');
        } else {
            _msgBox('r', '#confirm connection failed: ');
        }
        echo $conn.'<br>';
        
    echo '<hr>';
    
    #_msgBox('r', '#confirm connection: '.$conn);
    #print_r($conn);
    echo '<hr>';
    
    global $oldSeqNum;
    
    $placeHolders = array(
        ':sid' => 'softwareID',   #1
        ':sqn' => 'sequenceNum',  #2
        ':tle' => 'title',        #3
        ':yr'  => 'year',         #4
        ':des' => 'description',  #5
        ':not' => 'notes',        #6
        ':hwr' => 'hardwareReq',  #7
        ':swr' => 'softwareReq',  #8
        ':lls' => 'licenceList',  #9
        ':nof' => 'numberOfFiles',#10 
        ':ins' => 'insertedDate', #11
        ':pid' => 'publisherID',  #12
        ':cid' => 'contributorID',#13 
        ':cty' => 'country'       #14
    );
    
    $values = array(); #blank array to hold values given corresponding acceptable attribute names
    $usedAtts = array();
    $counter=0;
    $q = 'INSERT INTO software (';
    # LOOP 1 ATTRIBUTE NAMES (defines order or values entered in, thus order of placeHolder->value bindings)
    
    foreach(array_keys($_newData) as $data){
        #echo '$counter'.$counter.'<br>';    
        $pref = substr($data,0,6);
        #FILTER / validate attribute name before appending to query
        if($pref != 'author'     &&
            $data != 'publisher'    &&
            $data != 'altAddress'   &&
            $data != 'insertedDate' && #skip date for now - append at the end
            $data != ''
        ){
            #$data = '"'.$data.'"';
            $usedAtts[]= $data; #auto conversion to string
            $q.= $data;
            $q.= ', ';
        }
        $counter++;
    }
    $q.='insertedDate';
    $q.=') VALUES (';
    
    $dt = '"'.date("Y-m-d").'"';
    # LOOP 2 VALUES
    foreach($usedAtts as $data){ #bindParm is the abreviated bind parameter ie :sid
        $index = 0;
        while($data != array_values($placeHolders)[$index]){
            #echo '$data != '.array_values($placeHolders)[$index];
            $index+=1;
        }
        $ph  = array_keys($placeHolders)[$index];
        $q.= $ph;
        $q.= ', '; #final comma is ok as there is still one more special case of date
        #$_newData[$data] = '"'.$_newData[$data].'"';
        $values[]= $_newData[$data]; #add value to values
    }
    
    if ($_debeug) echo '$insertedDate: '.$dt.'<br>';
    $q.= $dt;
    $q.= ')';
    if ($_debeug) echo '$q:<br>'.$q.'<br>';
    #END OF QUERY BUILD
    
    if ($_debug) echo '<hr><b>'.$q.'</b><hr>';
    if ($_debeug){
        echo 'merging arrays...<br>';
        #print arrays
        echo '<table border ="1">';
        echo '<tr>';
        echo '<td>';
        #array, colour, precentage of screen width, indexed (binary value), $_debug
        displayDataInTableFromAssocArray($usedAtts, 'blue', 50, 0, 0);
        echo '</td>';echo '<td>';
        displayDataInTableFromAssocArray($values, 'blue', 50, 0, 0);
        echo '</td>';
        echo '</tr>';
        echo '</table>';
    }
    
    $merge = array_combine($usedAtts, $values);
    
    # a simple Test query works
    echo '<hr>test';
    $qt = 'select * from software WHERE software.softwareID = 10';
    echo '<hr>test query: '.$qt.'<br>';
    
    $stmt = $conn->prepare($qt);
    #var_dump($conn);
    $stmt->bindValue(':s','10');
    $stmt->execute();
    $res=$stmt->fetch(PDO::FETCH_ASSOC);
    print_r($res);
    
    echo '<hr>';
    displayDataInTableFromAssocArray($res, 'blue', 100, 0);
    #exit;
    
    
    $stmt = $conn->prepare($q);
    
    echo 'stmt:<hr>';
    print_r($stmt);
    echo 'stmt:<hr>';
    
    #EXECUTE USING ARRAY not working for some reason
    #$stmt->execute($merge);
    
    #TEMP ASSIGNMENT
    $a = $merge['softwareID'];
    $b = $merge['sequenceNum'];
    $c = $merge['title'];
    $d = $merge['year'];
    $e = $merge['description'];
    $f = $merge['notes'];
    $g = $merge['hardwareReq'];
    $h = $merge['softwareReq'];
    $i = $merge['licenceList'];
    $j = $merge['numberOfFiles'];
    #$k = (string) date("Y-m-d");
    $l = $merge['publisherID'];
    $m = $merge['contributorID'];
    $n = $merge['country'];
    
    #are there any new parms that I need to worry about or is it this fixed set ?
    
    #get old count of software entries for validation
    #$oldCount = queryCountSoftwareEntries(0);
            
    # BIND MANUALLY (dont need to use ':')
    $stmt->bindParam('sid',$a);
    $stmt->bindParam('sqn',$b);
    $stmt->bindParam('tle',$c);
    $stmt->bindParam('yr', $d);
    $stmt->bindParam('des',$e);
    $stmt->bindParam('not',$f);
    $stmt->bindParam('hwr',$g);
    $stmt->bindParam('swr',$h);
    $stmt->bindParam('lls',$i);
    $stmt->bindParam('nof',$j);
    #$stmt->bindParam('ins',$k); # not required
    $stmt->bindParam('pid',$l);
    $stmt->bindParam('cid',$m);
    $stmt->bindParam('cty',$n);
    
    $stmt->execute();
    
    echo '<hr>';
    #if ($_debug) print_r($merge);
    if ($_debug) echo '<br>### VALIDATION ###<br>';
    
    
    /*
    $softwareID = $merge['softwareID'];
    #$_s1 = $merge['sequenceNum']; #already updated
    
    $_s1 = $oldSeqNum;
    $newCount = queryCountSoftwareEntries(0);
    
    #update global
    $softwareID = $a;
    
    echo 'oldSeqNum: '.$oldSeqNum.'<br>';
    
    if(validateAugment($oldCount, $softwareID, 1)){
        if ($_debug) _msgBox('g', 'FN: VALIDATE INSERTION complete...');
        
        #REDIRECT TO SUCCESS page #this function requires the 'PECL' functions to be installed
        echo ' <script>window.location = "./ADHD_success.php";</script>';
    }
    /*
     * at this stage validation should confirm that there is n+1 entries
     * with this same softwareID
     * 
     */

}
    /**
     * 
     * augment version 4 - attempt to work around remote server binding problem
     * @global type $conn
     * @param type $_newData
     * @param type $_debug
     */
    function augmentSoftwareEntry4($_newData, $_debug){
        if ($_debug) _msgBox('b', 'FN: augmentSoftwareEntry4 reached... ($_data, $_debug)');
        
        global $conn;
        
        #assumes data sanitation first
        $q = 'INSERT INTO software (';
        $values = array();
        
        if ($_newData['softwareID']){
            
            $q.= 'softwareID';
            $q.=',';
            $values[]=$_newData['softwareID'];
        }
        if ($_newData['sequenceNum']){
            
            $q.= 'sequenceNum';
            $q.=',';
            $values[]=$_newData['sequenceNum'];
        }
        if ($_newData['title']){
            
            $q.= 'title';
            $q.=',';
            $values[]=$_newData['title'];
        }
        if ($_newData['year']){
            
            $q.= 'year';
            $q.=',';
            $values[]=$_newData['year'];
        }
        if ($_newData['publisher']){
            
            $q.= 'publisher';
            $q.=',';
            $values[]=$_newData['publisher'];
        }
        if ($_newData['publisherID']){
            
            $q.= 'publisherID';
            $q.=',';
            $values[]=$_newData['publisherID'];
        }
        if ($_newData['country']){
            
            $q.= 'country';
            $q.=',';
            $values[]=$_newData['country'];
        }
        if ($_newData['hardwareReq']){
            
            $q.= 'hardwareReq';
            $q.=',';
            $values[]=$_newData['hardwareReq'];
        }
        if ($_newData['softwareReq']){
            
            $q.= 'softwareReq';
            $q.=',';
            $values[]=$_newData['softwareReq'];
        }
        if ($_newData['licenceList']){
            
            $q.= 'licenceList';
            $q.=',';
            $values[]=$_newData['licenceList'];
        }
        if ($_newData['description']){
            
            $q.= 'description';
            $q.=',';
            $_newData['description'];
        }
        if ($_newData['notes']){
            
            $q.= 'notes';
            $q.=',';
            $values[]=$_newData['notes'];
        }
        if ($_newData['contributorID']){
            
            $q.= 'contributorID';
            $q.=',';
            $values[]=$_newData['contributorID'];
        }
        if ($_newData['altAddress']){
            
            $q.= 'altAddress';
            $q.=',';
            $values[]= $_newData['altAddress'];

        }
        if ($_newData['numberOfFiles']){
            
            $q.= 'numberOfFiles';
            $q.=',';
            $values[]=$_newData['numberOfFiles'];
        }
        /*
        if ($_newData['insertedDate']){
            #$q.= 'software.';
            $q.= 'insertedDate';
            #$q.=',';
            $values[]= '"'.date("Y-m-d").'"';
        }
        */
        
        $q .= ') VALUES ( ';
        
        #LOOP over VALUES
        foreach($values as $v){
            $q.= $v;
            $q.= ',';
        }
        
        #add final inserted date
        $q .= ':indt';
        $q .= ')';
        
        $insertedDate = date("Y-m-d");
        $q = str_replace(':indt', $insertedDate, $q);
        
        $stmt = $conn->prepare($q);
        print_r($stmt);
        
        if($stmt){
            $stmt->bindParam(':indt', $insertedDate);
        } else {
            echo '$stmt is a boolean -> binding will fail<br>';
            echo 'getttype on $stmt->: '.gettype($stmt).'<br>';
            echo 'value: '.$stmt.'<br>';
        }
        
        $stmt->execute();
        
        #Validation Required
    }
    
?>
