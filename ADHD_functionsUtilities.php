<?php

function rebuildView($_debug){
    global $conn;
    
    _msgBox('b', 'FN rebuildView reached...');
    
    $testQuery = 'select :t, softwareID FROM vsoftware';
    $stmt = $conn->prepare($testQuery);
    echo 'stmt<br>';
    #print_r($stmt);
    
    #echo 'bindValue<br>';
    $t = 'title';
    #$stmt->bindParam(':t', $t);
    $stmt->execute(array(':t' => $t));
    
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $q2 = 'SELECT title FROM vsoftware';
    $stmt = $conn->query($q2)->execute();
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    print_r($res);
    
    /**
    echo gettype($stmt).'<br>';
    echo count($stmt);
    print_r($stmt);
    exit();
    */
    
    print_r($res);
    exit;
    
    #if ($stmt)
    #detect if view exists
    if($v){
        _msgBox('o', 'view already exists...not rebuilding');
    }
    
    #Drop view if exists
    $drop = "DROP VIEW IF EXISTS vsoftware";
    $dropstmt = $conn->prepare($drop)->execute(); #DROPPING THE VIEW IS WORKING
    
    echo '<b>VIEW should be deleted now - check for it<br></b>';
    #echo 'exiting...<br>';
    #exit;

    #Validate no view with a query
    $qval = 'SELECT :t FROM vsoftware';
    $stmt = $conn->prepare($qval);
    $stmt->bindValue(':t','Laser Hawk');
    $res = $stmt->execute();
    print_r($res);

    if (!is_null($res)){
        _msgBox('r','query on non-existant table was not null...somethig is wrong, exiting...');
        exit();
    }

    echo 're-creating view(WorkAround)<br>';

    #RE_CREATE THE VIEW
    $queryAll = "SELECT software.softwareID,"
                ."software.sequenceNum,"
                ."software.title,"
                ."software.year,"
                ."software.description,"
                ."software.notes,"
                ."software.hardwareReq,"
                ."software.softwareReq,"
                ."software.licenceList,"
                ."software.numberOfFiles,"
                ."software.insertedDate,"
                ."software.publisherID,"
                ."software.contributorID,"
                ."software.country"
                .","
                /*
                ."GROUP_CONCAT(author.givenName separator ',') "
                ."AS givenName,"
                ."GROUP_CONCAT(author.familyName separator ',') "
                ."AS familyName,"
                ."GROUP_CONCAT(author.givenName,' ',author.familyName separator ',') "
                ."AS fullName,"
                */
                ."publisher.publisherName "
                ."AS publisherName "
                
                ."FROM ("
                ."((software LEFT JOIN publisher on(("
                ."software.publisherID = publisher.publisherID))"
                .")"
                ." left join author_software on(("
                ."software.softwareID = author_software.softwareID)))"
                ." left join author on(("
                ."author_software.authorID = author.authorID))) ";
                /*
                 * ."GROUP BY software.softwareID, software.sequenceNum";
                 */
    
    echo 're-creating view(WorkAround)<br>';

        #note upperacse 'S'
        /** this works
         * CREATE VIEW vsoftware AS
        (SELECT software.softwareID, software.sequenceNum, title, year, description, notes, hardwareReq, softwareReq, 
        licenceList, numberOfFiles, InsertedDate, software.publisherID, software.contributorID, 
        country, contributor.givenName, contributor.familyName, publisher.publisherName
        FROM software, contributor, publisher
        WHERE publisher.publisherID = software.publisherID AND
        software.contributorID = contributor.contributorID)
         */
        
        #RE_CREATE THE VIEW
        
        $queryAll = 'CREATE VIEW vsoftware AS ';
        $queryAll.= '(';
        $queryAll.= 'SELECT software.softwareID, software.sequenceNum, title, year, ';
        $queryAll.= 'description, notes, hardwareReq, softwareReq, licenceList, ';
        $queryAll.= 'numberOfFiles, insertedDate, software.publisherID, ';
        $queryAll.= 'software.contributorID, country, contributor.givenName, ';
        $queryAll.= 'contributor.familyName, publisher.publisherName ';
        $queryAll.= 'FROM ';
        $queryAll.= 'software, contributor, publisher ';
        $queryAll.= 'WHERE ';
        $queryAll.= 'publisher.publisherID = software.publisherID AND';
        $queryAll.= 'contributor.contributorID = software.contributorID';
        $queryAll.= ')';

        
    $stmt = $conn->prepare($queryAll);
    $res = $stmt->execute();

    #VALIDATE

    /**
    if($stmt){
        echo '$stmt->';
        print_r($stmt);
        $stmt->execute();
        #print_r($stmt);
        echo '<b>view should have been re-created now - check for it...</b><br>';
    } else {
        echo 'stmt was false...something wrong...<br>';
        print_r($stmt);
    }
    */
    echo '<b>view should have been re-created now - check for it...</b><br>';
    
    _msgBox('g', 'FN rebuildView() (in)complete...');
    
    #exit;
}
/**
 * 
 * BOX
 * (consider renaming this function to messageBox or similar)
 * 
 * simple convenience function for 
 * coloured debugging messages
 * (in tables)
 * 
 * @param type $_color
 * @param type $_string
 */
function _msgBox($_color, $_string){
    
    if ($_color==='y') $_color = 'yellow';
    if ($_color==='o') $_color = 'orange';
    if ($_color==='r') $_color = 'red';
    if ($_color==='b') $_color = '#ccccff';
    if ($_color==='g') $_color = '#ccffcc';
    if ($_color==='p') $_color = '#e699ff'; # light purple
    
    echo '<table style="background-color: '.$_color.'">'
    #.' font-size: .2em;'
    
    .'<tr><td><i>'
    .'<font size = "2">'
    .$_string
    .'</i>'
    .'</font>'
    .'</tr></td>'
    .'</table>';
}

/** 
 * MYAssertQ (in query file) function
 *
 * to do : free memory by setting statements to null
 * that returns an int for testing
 *
 * assertion will succeed if boolean is true
 *  
 * @return type integer (0 for success, pass test)
 * by returning an int - we can add multiple tests and treat 
 * 0 as overall success
 */
function _myAssertQ($_boolean, $_stringMessage){
    $redPink = "#ff6699";
    $lightGreen = "#ccffcc";
    #_msgBox('b','function myAssertQ...');
    if ($_boolean){
        #TRUE
        #_msgBox($lightGreen, 'BOOL Assertion satisfied');
        return 0; # opposite of intuitive vlaue true = 1
        /* allows adding of multiple tests */
    } else {
        _msgBox($redPink, $_stringMessage);#FALSE
        return 1;
    }
}

/**
 * spewPostVars
 * 
 * void
 */
FUNCTION _spewPostVars(){
    # UPDATED RESULTS
    #echo '<font style="font: regular;">';
    echo 'function: display Post Vars<br>';
    echo 'Updated Results:<br>';
    
    foreach($_POST as $row){
        if ($_debug) echo "* ";
        $DEBUG_STRING .= "\n* ";
        echo $tempCounter." ".$row."<br>";
        $DEBUG_STRING .= $tempCounter." ".$row;
        $tempCounter++;
    }
}

/**
 * supporting
 * _arPrint
 * 
 * simple listing of the elements in a the given array
 * @param type $_ar
 */
function _arPrint($_ar){
    echo '<i>count: '.count($_ar).'<br>';
    foreach ($_ar as $k){
        echo $k.'<br>';
    }
    echo '</i>';
}

/**
 * supporting function used bu fn : '...'
 * _arPush
 * 
 * allows pushing elements to an assoc array
 * @param type $_array
 * @param type $a
 * @param type $b
 * @return type
 */
function _assocPush($_array, $k, $v){
    $end = array($k => $v);
    $_array = array_merge($_array, $end);
    return $_array;
}

/**
  * * convenience function to push to an Assoc array
  * 
  * @param array $array
  * @param type $key
  * @param type $value
  * @return type
  */
function assocArrayPush($array, $key, $value, $_debug){
    
    if ($_debug) _msgBox('b','assocArrayPush reached');
    
    $temp = array($key => $value);
    #$array[$key] = $value;
    #push
    #$array[]= $temp;
    $array = $array + $temp;
    
    if($_debug){
        echo 'print_r<br>';
        print_r($array);
        echo '<br>-------------<br>';
    }
    
    if ($_debug) _msgBox('g','assocArrayPush complete');
    
    return $array;
}

/**
 * _setAutoInc value on a specific table
 * 
 * set the auto inc value for a table to the specified int
 */
function _setAutoInc($_val, $_table){
    global $conn;
    
    _msgBox('b', '(re)setAutoInc ('.$_val.', '.$_table.')');
    _msgBox('b', 'after injecting test data (which modifies the auto_inc value)');
    
    #$oldIncValue = queryAutoIncrementValue($_table);
    #echo '$oldIncValue'.$oldIncValue.'<br>';
    #_msgBox('y', 'exiting reset auto-inc prematurely...');
    #_msgBox('b', 'get max, reset auto Inc using ALTER TABLE');
    #get max
    
    $q = 'ALTER TABLE :t AUTO_INCREMENT= :m';
    $stmt = prepare($q);
    $stmt->bindParam(':t',$_table);
    $stmt->bindParam(':m',$_val);
    $res = $stmt->execute();
    
    #VALIDATE
    _msgBox('y', 'Validating...');
    
    #_msgBox('g', '_resetAutoInc ('.$_table.' ,'.$_val.' complete...');
    #return int to indicate success or not
}

/**
 * 
 * convenience function to reset the autoIncrement value for a table
 * in order to maintain sequential entries
 * 
 * called by function query autoIncrementValue in ADHD_functionsQueries.php
 * 
 * @global type $conn
 * @param type $_table
 * @reutn type int 1 if validated, 0 if failed to validate
 */
function _resetAutoInc($_table){
    
    global $conn;
    
    _msgBox('b', '_resetAutoInc '.$_table);
    
    $oldIncValue = queryAutoIncrementValueContributor($_table);
    echo '$oldIncValue'.$oldIncValue.'<br>';
    
    _msgBox('y', 'exiting reset auto-inc prematurely...');
    
    if ($oldIncValue != queryCountContributorIDs()){
            _msgBox('y','warning: auto incrememnt value (old) does not match count for CONTRIBUTOR table...');
    }
    
    _msgBox('b', 'get max, reset auto Inc using ALTER TABLE');
    #get max
    $max = queryMaxContributorIDFromContributor(0);
    $q = 'ALTER TABLE :t AUTO_INCREMENT= :m';
    $stmt = prepare($q);
    $stmt->bindParam(':t',$_table);
    $stmt->bindParam(':m',$max);
    $res = $stmt->execute();
    
    #VALIDATE
    _msgBox('g', '_resetAutoInc '.$_table. ' complete...');
}

/**
 * 
 * convenience function to replace confusing php strTok function
 * 
 * unicopde chars were a problem for a while
 * https://stackoverflow.com/questions/6058394/unicode-character-in-php-string
 * 
 * @param type $_delim
 * @param type $_string
 * @return array of strings / words
 */
function myTokenise($_delim, $_string){
        #_msgBox('o', 'fn myTokenise reached...');
        $_array = array();
        $currentWord='';
        $counter = 0;
        #bruteForce loop
        for($i=0;$i <= strlen($_string);$i++){
            $c = substr($_string, $i,1);
            if(     $c === $_delim      || 
                    #$c == "\u{002E}"    || 
                    #$c == "\u002E"      || 
                    $c == "\n"          ||
                    $c == "\n\r"        ||
                    ($i==strlen($_string))
                ){
                #match -> add word to array -> reset currentword
                _msgBox('g', '_');
                $_array[]= $currentWord;
                $counter++;
                $currentWord = '';
            } else {
                #no match -> build word
                $currentWord .= $c;
                #echo $currentWord;
                #echo '<br>';
            }
        }
        if (0){
            echo 'Array:<br>';
            echo 'counter: ';
            echo $counter;
            echo '<br>';

            echo 'arrayCount: ';
            echo count($_array);

            echo '<br>';
            print_r($_array);
            _msgBox('y', 'fn myTokenise exiting...');
        }
        _msgBox('g', 'fn myTokenise complete...');
        
        return $_array;
    }
    
    /**
     * cleanOutEmptyElements
     * 
     * @param type $_array
     * @reutn type array
     */
    function cleanOutEmptyElements($_array){
        #clean empty elements
        _msgBox('b','fn: cleanOutEmptyElements reached...');
        
        $counter = 1; # not zero based for display purposes
        
        $clean = array();
        
        foreach($_array as $k => $v){
            echo '['.$counter.'] <br>';

            if(gettype($v) === gettype('string') && ($v !== "")){
                echo '<b>string</b> "'.$v.'" detected<br>';
                $clean = assocArrayPush($clean, $k, $v, 0);

                if(gettype($v) === gettype(5)){
                    echo '<b>int</b> '.$v.' detected<br>';
                    $clean = assocArrayPush($clean, $k, $v, 0);
                }

            } else {
                echo '<br>';
            }

            if(gettype($v) === NULL){
                echo '<b>NULL</b> "'.$v.'" detected<br>';
            }
            $counter++;
        }

        echo '<hr>';
        echo 'merged array: $merge: <br>';
            displayDataInTableFromAssocArray($_array, 'yellow', 100, 1, 0);
        echo '<hr><b>Merge Count: '.count($_array).'</b><hr>';

        echo '<hr>';
        echo 'cleaned array:<b> $clean: </b><br>';
            displayDataInTableFromAssocArray($clean, 'green', 100, 1, 0);
        echo '<hr><b>Clean Count: '.count($clean).'</b><hr>';

        _msgBox('g','fn: cleanOutEmptyElements complete (returning cleaned array)...');
        
        return $clean;
    }
    
    
?>

