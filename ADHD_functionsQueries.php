<?php

/**
 * UNIT TEST for querySoftwareIDFromTitle
 * 2 passing tests
 * 2 failing tests
 *
 * to do retrieved ID should never be larger than the maximum ID
 * 
 * @return type void
 */

/**
 * queryAll(from)queryAllvSoftwareBy_seqNum_SWID($_view, $_seqNum, $_softwareID, $_debug)
 * 
 * queries all params in the view: vSoftware
 * by providing sequenceNum and softwareID
 * 
 * tested by function :
 * 
 * @param type $_view 
 * @param type $_seqNum 
 * @param type $_softwareID 
 * @global type $conn
 * @return type array of PDO results
 */

FUNCTION queryAllvSoftwareBy_seqNum_SWID($_view, $_seqNum, $_softwareID, $_debug){
    
    if ($_debug) _msgBox ('b', 'FN queryAllvSoftwareBy_seqNum_SWID($_view, $_seqNum, $softwareID) reached...');
    
    global $conn;
    GLOBAL $title, $year, $authorInputCount,
        $authorGivenName,$authorFamilyName,
        $authorGivenName1,  $authorGivenName2,  $authorGivenName3, $authorGivenName4,
        $authorFamilyName1, $authorFamilyName2, $authorFamilyName3, $authorFamilyName4;
    
    GLOBAL $softwareID, $publisher, $country, $hardwareReq, $softwareReq, $description, $notes,
        $contributorFamily, $contributorGiven, $altAddress, $filesNum, $seqNum;
    
    $id = 0;
    $row = '';
    
    $queryAll = "SELECT * FROM vsoftware WHERE softwareID = :id";

    #TOGGLE USE OF VIEW (str_replace didnt work)
    if ($_view == 0){
        #using alternate query 
        _msgBox('o', '<i>View access bypassed, using rebuild query</i>');
        #$queryAll = "SELECT * FROM software WHERE softwareID = :id";
        
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
                ."author_software.authorID = author.authorID))) "
                /*
                 * ."GROUP BY software.softwareID, software.sequenceNum";
                 */  
                ."WHERE software.softwareID = :id "
                ;
    }
    
    if($_view == 1){
        _msgBox('o', '<i>attempting View access </i>');
        #query not modified
    }
    $queryAll .= " AND software.sequenceNum = :sn";
    
    $stmt = $conn->prepare($queryAll);
    $stmt->bindParam(':id', $_softwareID);
    $stmt->bindParam(':sn', $_seqNum);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC); #working
    $stmt = null;
    
    if($results){
        _msgBox ('g', 'Query->successful');
        #print_r($results);
        
    } else {
        _msgBox ('r', 'Query->FAIL');
    }
    
    if($_debug == 2){
        echo 'Query results: $results = <br>';
        echo '-----------------------------------';
        
        while($row == $results){
            echo $row;
            echo '<br>';
        }
    }
    if ($_debug) _msgBox ('g', 'FN queryAllvSoftwareFromID($_seqNum, $softwareID) complete...');
    return $results;
}

/**
 * a different tactic
 * show only one random and then verify all data with separate queries
 * 
 * how to handle records with the same title ?
 */
function queryAllvSoftwareByID_test_simple($_debug){
    if ($_debug) _msgBox('b', 'queryAllvSoftwareByID_test_simple() reached...');
    
    $r = rand(1,1975); #approx range of titles in the DB
    $q = queryAllvSoftwareByID(0,$r,0); #$_debug
    #print_r($q);
    echo '<hr>';
    #dont know why these functions are broken
    #displayArrayAsTable($q);
    #displayDataInTableFromAssocArray($q, 'orange', $_debug);
    
    foreach($q as $k => $v){
        echo $k.': ';
        echo $v;
        if ($v = '' || is_null($v)) echo '<font color="orange">NULL</font>';
        echo '<br>';
        
    }
    #validation either manually or by seperate queries to the same software title
    _msgBox('g', 'queryAllvSoftwareByID_test_simple() complete...');
}

/*
 * queryAllvSoftwareByID_test
 * 
 * this query returns all *non-null* 
 * col names from the table (view) vSoftware
 * 
 * the process:
 * 1. generate n random swID numbers
 * 2. define arrays to hold record attributes
 * 3. query all attributes of view by (random) softwareID
 * 4. store attributes in designated array (why split them ?)
 * 5. verify results with another query to specific swid
 * 6. results should be equal as we should be querying the same information 
 * (via different methods) ? 
 */

FUNCTION queryAllvSoftwareByID_test($_testCount, $_debug){
    
    _msgBox('b', 'queryAllvSoftwareByID_test...');
    
    #$_debug = 0;
    # generate randomIDs between 1 to 1975 (total number of records/
    # current max count of titles in the DB)
    #$max = 1975;
    $max = $_testCount; #upper bound of records to query
    $assertionTally = 0; #if non-zero -> errors have occurred
    
    $randIDs = array();
    
    #view columns
    $v_id       =   array();    #1
    $v_seqNum   =   array();    #2
    $v_title    =   array();    #3
    $v_yr       =   array();    #4
    $v_dn       =   array();    #5
    $v_ns       =   array();    #6
    $v_hw       =   array();    #7
    $v_sw       =   array();    #8
    $v_ll       =   array();    #9
    
    $v_nf       =   array();    #10
    $v_dt       =   array();    #11
    $v_pd       =   array();    #12
    $v_cd       =   array();    #13
    $v_cn       =   array();    #14
    $v_gn       =   array();    #15
    $v_fn       =   array();    #16
    $v_fl       =   array();    #17
    $v_pn       =   array();    #18
    
    #echo 'blank arrays defined<br>...';
    
    #create array of random ID numbers in the range of existing records
    for ($n=0;$n< $max; $n++){
        $r = rand(1,$max);
        $randIDs[]= $r;
    }
    
    #print_r($randIDs);
    
    for($n=0;$n < count($randIDs); $n++){
        $r = $randIDs[$n];
        echo '<hr>';
        #echo 'el:'.$r.'<br>';
    
        #echo '<b>'.$n.' queryAllvSoftwareByID_test</b><br>';
        #Query returns an array
        $q = queryAllvSoftwareByID(0, $r); #function returns all rows of the view vSoftware
     
        $id = $q['softwareID'];     #1
                                    #2 ?sequenceNum not included ?
        $tl = $q['title'];          #3
        $yr = $q['year'];           #4
        $dn = $q['description'];    #5
        $ns = $q['notes'];          #6
        $hw = $q['hardwareReq'];    #7
        $sw = $q['softwareReq'];    #8
        $ll = $q['licenceList'];    #9
        
        $nf = $q['numberOfFiles'];  #10
        $dt = $q['insertedDate'];   #11
        $pd = $q['publisherID'];    #12
        $cd = $q['contributorID'];  #13
        $cn = $q['country'];        #14
        $gn = $q['givenName'];      #15
        $fn = $q['familyName'];     #16
        $fl = $q['fullName'];       #17
        $pn = $q['publisherName'];  #18
        
        #handle blank IDs (no software in the DB should have blank softwareID's...)
        
        if($id=='' || (is_null($id))){ 
            $id = -1;
            #exit;
        }
        #split data into seperate Arrays...add data to array based on attribute/col name
        $v_id[]=$id;        #1
                            #2
        $v_title[]=$tl;     #3
        $v_yr[]=$yr;        #4
        $v_dn[]=$dn;        #5
        $v_ns[]=$ns;        #6
        $v_hw[]=$hw;        #7
        $v_sw[]=$sw;        #8
        $v_ll[]=$ll;        #9

        $v_nf[]=$nf;        #10
        $v_dt[]=$dt;        #11
        $v_pd[]=$pd;        #12
        $v_cd[]=$cd;        #13
        $v_cn[]=$cn;        #14
        $v_gn[]=$gn;        #15
        $v_fn[]=$fn;        #16
        $v_fl[]=$fl;        #17
        $v_pn[]=$pn;        #18
    }
   
    echo '<hr>';
    
    #display all queried data# for debugging
    if(0){
        echo '<b>View Id\'s:</b><br>';
        #print_r($v_id);echo '<br>';#_arPrint($v_id);echo '<br>';
        foreach($v_id as $k){
            echo $k.'<br>';
        }

        echo '<b>View seqNum disabled</b>:<br>';
        #print_r($v_sn);#_arPrint($v_sn);echo '<br>';

        echo '<b>View Title\'s</b>:<br>';
        #print_r($v_title);echo '<br>';#_arPrint($v_title);echo '<br>';
        foreach($v_title as $k){
            echo $k.'<br>';
        }

        echo '<b>View Yr\'s</b>:<br>';
        #print_r($v_yr);echo '<br>';#_arPrint($v_yr);echo '<br>';
        foreach($v_yr as $k){
            echo $k.'<br>';
        }

        echo '<b>View Desc\'s</b>:<br>';
        #print_r($v_dn);echo '<br>';#_arPrint($v_dn);echo '<br>';
        foreach($v_dn as $k){
            echo $k.'<br>';
        }

        echo '<b>View Notes</b>:<br>';
        #print_r($v_ns);echo '<br>';#_arPrint($v_ns);echo '<br>';
        foreach($v_ns as $k){
            echo $k.'<br>';
        }

        echo '<b>View HWReqs\'s</b>:<br>';
        #print_r($v_hw);echo '<br>';#_arPrint($v_hw);echo '<br>';
        foreach($v_hw as $k){
            echo $k.'<br>';
        }

        echo '<b>View SWReqs</b>:<br>';
        #print_r($v_sw);echo '<br>';        #_arPrint($v_sw);echo '<br>';
        foreach($v_sw as $k){
            echo $k.'<br>';
        }

        echo '<b>View LicenceLists</b>:<br>';
        #print_r($v_ll);echo '<br>';#_arPrint($v_ll);echo '<br>';
        foreach($v_ll as $k){
            echo $k.'<br>';
        }

        echo '<b>View numberOfFiles</b>:<br>';
        #print_r($v_nf);echo '<br>';#_arPrint($v_nf);echo '<br>';
        foreach($v_nf as $k){
            echo $k.'<br>';
        }

        echo '<b>View insertionDates</b>:<br>';
        #print_r($v_dt);echo '<br>';#_arPrint($v_dt);echo '<br>';
        foreach($v_dt as $k){
            echo $k.'<br>';
        }

        echo '<b>View PubId\'s</b>:<br>';
        #print_r($v_pd);echo '<br>';#_arPrint($v_pd);echo '<br>';
        foreach($v_pd as $k){
            echo $k.'<br>';
        }

        echo '<b>View ConId\'s</b>:<br>';
        #print_r($v_cd);echo '<br>';#_arPrint($v_cd);echo '<br>';
        foreach($v_cd as $k){
            echo $k.'<br>';
        }

        echo '<b>View Countries</b>:<br>';
        #print_r($v_cn);echo '<br>';#_arPrint($v_cn);echo '<br>';
        foreach($v_cn as $k){
            echo $k.'<br>';
        }

        echo '<b>View Contributor\'s Given Name</b>:<br>';
        #print_r($v_gn);echo '<br>';#_arPrint($v_gn);echo '<br>';
        foreach($v_gn as $k){
            echo $k.'<br>';
        }

        echo '<b>View Contributor\'s Family Name</b>:<br>';
        #print_r($v_fn);echo '<br>';#_arPrint($v_fn);echo '<br>';
        foreach($v_fn as $k){
            echo $k.'<br>';
        }

        echo '<b>View FullNames</b>:<br>';
        #print_r($v_fl);echo '<br>';#_arPrint($v_fl);echo '<br>';
        foreach($v_fl as $k){
            echo $k.'<br>';
        }

        echo '<b>View PubName\'s</b>:<br>';
        #print_r($v_pn);echo '<br>';#_arPrint($v_pn);echo '<br>';
        foreach($v_pn as $k){
            echo $k.'<br>';
        }
}
    echo '<hr>';
    echo 'comparing results...<br>';
    echo '<hr>';
    
    $mismatches = 0;
    $c = 0;
    
    echo 'comparing IDs...<br>';
    #for each element of v_ID (the queried IDs)
    foreach($v_id as $k){
        #skip over bad id's
        if($k != -1){ 
            #echo 'style = "background-color: orange;"';
            $mismatches++;
            $c++;
        } else {
         #compare elements using index    (assertion Tally defined at start of this function
         $assertionTally += _myAssertQ(($v_id[$c]===$randIDs[$c]), 'comparing elements..failed');
        }
        $c++;
    }
    
    #TITLES
    echo '<hr>';
    echo 'comparing titles...<br>';
    $mismatches = 0;
    $c = 0;
    #print_r($v_tl);
    
    foreach($v_title as $k){
        $_title = querySoftwareTitleFromSW($v_id[$c], 0);
        echo 'queried_title:'.$_title.'<br>';
        echo 'stored__title:'.$k.'<br>';
        #echo 'title:'.$v_tk[$c].'<br>';
        
        if($k == ''){ 
            #echo 'style = "background-color: orange;"';
            #$mismatches++;
            $c++;
        } else {
            #compare elements using index   
            $assertionTally += _myAssertQ(($v_title[$c]===$_title), 'comparing title elements..failed');
            
            if($_title === $v_tl[$c]){
                #echo 'title tick #'.$c.'/'.$max.'<br>';
                _msgBox('g', 'tick');
            }
        }
        $c++;
    }
    
    #YR
    echo '<hr>';
    echo 'comparing years...<br>';
    $mismatches = 0;
    $c = 0;
    foreach($v_yr as $k){
        $_yr = queryYearFromSoftware($v_id[$c], 0);
        #echo $_yr;
        #skip over bad titles
        if($k == '0' || $k = '0000'){ 
            #_msgBox('o', 'bad year: '.$k);
            #$mismatches++;
            $c++;
        } else {
            #compare elements (yr from array to yr from new query)using index   
            $assertionTally += _myAssertQ(($v_yr[$c]===$_yr), 'comparing year elements..failed');
        }
        $c++;
    }
    
    ##FINAL ASSERTION TALLY 
    if ($assertionTally!=0){
        _msgBox('red','unit test  for query all vSoftware[atts] failed');
        #exit();
    } else {
        _msgBox('green','<b>unit test  for query all vSoftware[atts] satisfied<b>');
    }
    
    #DISPLAY TABLES
    
    $vColNames = array(
        'softwareID',
        #'sequenceNum',
        #'title',
        'year',
        'description',
        'notes',
        'hardwareReq',
        'softwareReq',
        'licenceList',
        'numberOfFiles',
        'insertedDate',
        'publisherID',
        'contributorID',
        'country',
        'givenName',
        'familyName',
        'fullName',
        'publisherName'
        );
            
    if ($_debug){        
        #myAssertQ($v_id === $randIDs, 'arrays are not the same');
        if (1){
            if ($v_id !== $randIDs) echo 'arrays are not the same...<br>';
            
            echo '<table border="1" ><tr><td>';
            #table 1 in outer table cell1

            #column names
            echo '<table border="1">';
            echo '<th>col name</th>';
            foreach($vColNames as $k){
                echo '<td width = "33%"';
                echo '>';
                echo $k;
                echo '</td></tr>';
            }
            echo '</table>';
            #@@@
            #exit;
            echo '</td><td width = "33%">';
                    
            echo '<table border="1">';
            echo '<th>q-retreivedID</th>';

            foreach($v_id as $k){
                echo '<tr><td width="33%"';
                // table data
                    if($k == -1) echo 'style = "background-color: orange;"';
                    echo '>';
                    echo $k;
                    if($k == -1) echo ' NULL';
                //end table data
                #echo $v_title[$k];
                echo '</td></tr>';
            }
            echo '</table>';

            echo '</td><td>';
            #table 2 in outer table cell2

            echo '<table border="1">';echo '<th>randID values</th>';
            foreach($randIDs as $k2){
                echo '<tr><td width="33%">';
                echo $k2;
                echo '</td></tr>';
            }
            echo '</table>';
            #end of outer table
            echo '</td></tr></table>';
        }
    }
    echo '<hr>';
    
    #validate
}

/**
 * 
 * @global type $conn
 * @return type
 */
function queryAutoIncrementValueContributor(){
    global $conn;
    $_table = 'contributor';
    _msgBox('g', '<hr>fn: queryAutoIncrementValue '.$_table);
    $queryAutoInc = 'SELECT AUTO_INCREMENT 
        FROM INFORMATION_SCHEMA.TABLES 
        WHERE TABLE_SCHEMA = "ourdigital_heritage" 
        AND TABLE_NAME = "contributor"';
    $autoIncValue = $conn->query($queryAutoInc)->fetchColumn();
    echo 'contributor auto-inc value:   ';
    echo $autoIncValue;
    echo '<br>';
    
    _msgBox('g', '<hr>fn: queryAutoIncrementValueContributor() complete...');
    return $autoIncValue;
}

/**
 * convenience function to
 * get the auto-increment value for a specific table
 * in the 'ourdigital_heritage' database
 * 
 * currently used by functions 
 * 1. _resetAutoInc in ADHD_functionsInsert.php
 * 2. insertContributorByNamesAndEmail_test 
 * in ADHD_functionsQueries.php
 * 
 * @param string $_table the table to get the auto_inc value from
 * (in the ourdigital_heritage database)
 * 
 * @return int the auto inc value
 * 
 * VALIDATED manually - but test results not recorded
 * 
 * should be bound to given table name
 */

function querySetAutoIncrementValueContributor($val){
    global $conn;
    
    _msgBox('y', 'querySetAutoIncrementValue to: '.$val);
    $querySetAutoInc = 'ALTER TABLE contributor AUTO_INCREMENT = :ai';
    $stmt = $conn->prepare($querySetAutoInc);
    $stmt->bindParam(':ai',$val);
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    print_r($res);
    exit();
    #echo 'contributor auto-inc value:   ';
    #echo $val;
    #echo '<br>';
    _msgBox('g', 'querySetAutoIncrementValueContributor($val) complete...');
    _msgBox('y', 'but not yet validated...');
}

/**
 * 
 * essentially the same function as above but querying the author table 
 * rather than the contributor table
 * 
 * @global type $conn
 * @return type
 */
function queryAutoIncrementValueAuthor(){
    global $conn;
    _msgBox('y', 'fn: queryAutoIncrementValueAuthor ');
    $queryAutoInc = 'SELECT AUTO_INCREMENT 
        FROM INFORMATION_SCHEMA.TABLES 
        WHERE TABLE_SCHEMA = "ourdigital_heritage" 
        AND TABLE_NAME = "author"';
    
    $autoIncValue = $conn->query($queryAutoInc)->fetchColumn();
    _msgBox('g', 'fn: queryAutoIncrementValueAuthor complete...');
    return $autoIncValue;
}

/**
 * 
 */

function querySetAutoIncrementValueAuthor(){
    global $conn;
    _msgBox('y', 'fn: queryAutoIncrementValueAuthor ');
    $queryAutoInc = 'SELECT AUTO_INCREMENT 
        FROM INFORMATION_SCHEMA.TABLES 
        WHERE TABLE_SCHEMA = "ourdigital_heritage" 
        AND TABLE_NAME = "author"';
    
    $autoIncValue = $conn->query($queryAutoInc)->fetchColumn();
    #echo '$results: ';
    #echo $autoIncValue;
    _msgBox('g', 'fn: queryAutoIncrementValueAuthor complete...');
    return $autoIncValue;
}

/**
 * 
 * queryView
 * 
 * this function is currently used in modifyEntry, displayEntry and functionsQueries (defn)
 *
 * this fn uses the toggle $_view to control using the view vs the reg table (software)
 * (if $_view, rebuild the view
 *  
 * possible workarounds are -
 * 1. drop and recreate the view each time we use it
 * 2 a more elaborate query - essentially re-creating the view
 * 
 * MEM used by $stmt is released (set to null)
 * 
 * error reporting is turned off and back on before the function ends (not ideal)
 * to suppress excessive notifications being rendered into HTML
 * 
 * @global type $conn
 * @param type $_view : use the view or not, 1 will use the new query syntax (JOINS)
 * @param type $_id
 * @param type $_seqNum : if non zero, narrow the query to a specific seqNum
 * @param type $_debug
 * @return type
 */
FUNCTION queryView($_view, $_id, $_seqNum, $_debug){
    
    if ($_debug){
        _msgBox ('b', 'function queryView('.$_view.', '.$_id.', '.$_seqNum.'(optional sqNum), '.$_debug.')<br>');
       #echo '<i>turning error display off<br></i>';
    }
    #error_reporting(0);
    
    global $conn;
    
    $id = 0;
    $row = '';
    
    #DETECT VIEW
    #$qViewExists = '';
    #$stmt = $conn->
    
    #MODIFY QUERY
    $queryAll = "SELECT * FROM vsoftware WHERE softwareID = :id";
    
    if ($_view == 1){ #or use str_replace
        if ($_debug) echo '<i><font color="red">View access not functioning, using rebuild query</i></font><br>';
        /*
        $queryAll = "SELECT software.title, "
                ." software.softwareID, "
                ." software.sequenceNum, "
                ." software.year, "
                ." software.description, "
                ." software.notes, "
                
                ." software.hardwareReq, "
                ." software.softwareReq, "
                ." software.licenceList, "
                ." software.numberOfFiles, "
                
                ." software.insertedDate, "
                ." software.publisherID, "
                ." software.contributorID, "
                ." software.country"
                .', '
                ." publisher.publisherName, "
                ." contributor.givenName, "
                ." contributor.familyName "
                
                ."FROM software, publisher, contributor "
                ."WHERE software.softwareID = :id "
        
                ."AND software.publisherID = publisher.publisherID "
                ."AND software.contributorID = contributor.contributorID"
                ;
        */
        #$queryAll = "DROP TABLE IF EXISTS `vsoftware`";

        /* CREATE 
        ALGORITHM=UNDEFINED
        VIEW `vsoftware`  AS  
        */
        
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
                ."author_software.authorID = author.authorID))) "
                /*
                 * ."GROUP BY software.softwareID, software.sequenceNum";
                 */  
                ."WHERE software.softwareID = :id"
                ;
        
        if($_seqNum > 0) $queryAll.= " AND software.sequenceNum = :sn";
    }
    #YESS !!
    
    #echo '<hr>';echo 'WORKAROUND <hr>';
    if($_debug == 2) echo 'q: '.$queryAll.'<br>';
    
    $stmt = $conn->prepare($queryAll);
    if(!$stmt){ 
        _msgBox ('o', 'view dependent query failed, attempting to recreate the view...');
        
        #RE-CREATE THE VIEW
        /*
        $stmt_rebuild  = 'CREATE VIEW vsoftware AS ';
        #$stmt_rebuild .= '(';
        $stmt_rebuild .= 'SELECT software.softwareID, software.sequenceNum, title, year, ';
        $stmt_rebuild .= 'description, notes, hardwareReq, softwareReq, licenceList, ';
        $stmt_rebuild .= 'numberOfFiles, insertedDate, software.publisherID, ';
        $stmt_rebuild .= 'software.contributorID, country, contributor.givenName, ';
        $stmt_rebuild .= 'contributor.familyName, publisher.publisherName ';
        $stmt_rebuild .= 'FROM ';
        $stmt_rebuild .= 'software, contributor, publisher ';
        $stmt_rebuild .= 'WHERE ';
        $stmt_rebuild .= 'publisher.publisherID = software.publisherID AND';
        $stmt_rebuild .= 'contributor.contributorID = software.contributorID';
        #$stmt_rebuild .= ')';  
        
        $stmt_rebuild = 'CREATE VIEW vsoftware AS ';
        $stmt_rebuild .= '(SELECT * FROM software)';
                
        $stmt = $conn->query($stmt_rebuild);
        if(!$stmt){ 
            _msgBox ('r', 'rebuild query failed...');
        } else {
            _msgBox ('g', 'rebuild query SUCCEEDED: '.$stmt_rebuild);
        }
        
        $res = $stmt->execute();
        
        if ($res){
            _msgBox('g', 'non null results !');
            
        } else {
            _msgBox('r', 'null results !');
        }
        print_r($res);
        */
    }
    
    #BIND (VIEW EXISTS)
    $stmt = $conn->prepare($queryAll);
    $stmt->bindParam(':id', $_id);
    #conditional bind
    if ($_seqNum > 0) $stmt->bindParam(':sn', $_seqNum);
    #$stmt->bindParam(':sn', $_seqNum);
    
    if ($stmt){
        $stmt->execute();
    } else {
        _msgBox('r','query object was FALSE before execution');
        exit();
    }
    
    $results = $stmt->fetch(PDO::FETCH_ASSOC); #working
    $stmt = null; #release memory
    
    /**
    echo 'gettype results:';
    echo gettype($results); #should be an array
    
    echo '<br>';
    if($results){
        echo 'true<br>';
    }else{
        echo 'false<br>';
    }
    */
    
    if(is_null($results) && $_deubg){
        _msgBox('r','null results...view is broken or non existent...');
    }
    
    if ($_debug){
        echo '<i>turning error display back on<br></i>';
    }
    error_reporting(1);
    
    if ($_debug) _msgBox('g','FN queryView() complete...');
    
    return $results;
}

/**
 * queryAll(from)vSoftwareFromID($_id)
 * *ignores sequenceNum
 * 
 * returns all parms from the view 
 * given a softwareID key
 * 
 * @@@to do : free memory by setting statements to null
 * 
 * @param $_view 
 *  if $_view zero the view is assumed to be working and the query is directed to
 *  the view directly
 *  if $_view = 1, the view is re-built with a pre-query bit of SQL 
 *   
 * @param type $_id 
 * @global type $conn
 * @return type array of PDO results
 */

FUNCTION queryAllvSoftwareByID($_rebuildView, $_id, $_debug){
    
    if($_debug) _msgBox('b', 'FN: queryAllvSoftwareByID($_rebuildView, $_id, $_debug) reached...<br>');
    
    global $conn;
    
    GLOBAL $title, $year, $authorInputCount,
        $authorGivenName,$authorFamilyName,
        $authorGivenName1,  $authorGivenName2,  $authorGivenName3, $authorGivenName4,
        $authorFamilyName1, $authorFamilyName2, $authorFamilyName3, $authorFamilyName4,
        $publisher, $country, $hardwareReq, $softwareReq, $description, $notes,
        $contributorFamily, $contributorGiven, $altAddress, $filesNum, $seqNum;
    
    #$_debug = 1;
    #$_rebuildView = 1; #refer to view in queries - no longer required ?
    $id = 0;
    $row = '';
    
    #DROP AND REBUILD VIEW - works
    
    if($_rebuildView == 1){
        
        #rebuildView(1);
        echo 'rebuild view broken ?...exiting';
        exit;
        /**
        $drop = 'DROP TABLE IF EXISTS `vsoftware`';
        $dropstmt = $conn->prepare($drop)->execute(); #DROPPING THE VIEW IS WORKING
        echo '<b>VIEW should be deleted now - check for it<br></b>';
        
        exit();
        
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
        /**
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
        
        /*
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
        #echo '<b>view should have been re-created now - check for it...</b><br>';
        #exit;
        

    } else { #$_reb.view = 0
        $queryView = "SELECT * FROM :v WHERE vsoftware.softwareID = :id";
        $queryView = "SELECT * FROM vsoftware WHERE vsoftware.softwareID = :id";
        
        $v = 'vsoftware';
        
        #if ($_debug) echo 'updated Query: '.$queryView.'<br>';

        /** WORKING EXAMPLE
         * $queryTitleCheck = 'SELECT softwareID FROM software WHERE title LIKE :t '; # "AND sequenceNum = 1";
         $stmt = $conn->prepare($queryTitleCheck);
         #$stmt->bindParam(':t', ('"'.$_title.'"'));
         $stmt->bindParam(':t', $_title);
         $stmt->execute();
         $results = $stmt->fetch(PDO::FETCH_ASSOC);
         */
        
        $stmtv = $conn->prepare($queryView);
        #$stmtv->bindParam(':v', $v);
        #$stmtv = str_replace(' :v ',' vsoftware ',$stmtv);
        
        #echo 'bind ID: '.$_id.'<br>';
        $stmtv->bindParam(':id', $_id);
        
        #$stmtv->execute(array(':v' => $v, ':id' => $_id));
        $stmtv->execute();
        
        #echo '$stmtv: ';
        #print_r($stmtv);
        #echo '<hr>';
        
        #echo gettype($stmtv);
        #if ($stmtv === object) _msgBox ('g', '<b>local</b> access of view is working...'); #and it seems remote as well
        #exit;
        
        $results = $stmtv->fetch(PDO::FETCH_ASSOC); #working
        #print_r($results);
        
        #echo 'remote data:';
        #displayDataInTableFromAssocArray($results, 'blue', 50, 1, 0);
        #exit;
    }
    
    #VALIDATION - test again for table existence
    /**
    $qExist = 'IF OBJECT_ID("ourdigital_heritage.vsoftware", "V") IS NOT NULL
    BEGIN
        PRINT "Table Exists"
    END';

    $stmtVal = $conn->query($qExist)->execute();
    $res = $stmtVal->fetch(PDO::FETCH_ALL);
    
    echo 'results (print_r($res)';
    print_r($res);

    if($res == 'Table Exists'){
          echo 'confirmed table exists<br>';
    } else {
        echo 'broken code <br>';
        exit;
    }
    */
    
    /*
    if($_debug){
        echo 'Query results: $results = <br>';
        echo '-----------------------------------';
        while($row == $results){
            echo $row.'<br>';
        }
        echo 'ID '.$results['softwareID'].'retrieved...function complete<br>';
    }
     *
     */
    return $results;
}
 
/**
 * queryMaxFileIDFromUploadedFiles
 * 
 * returns the id of the most recently uploaded file
 * testing this function has revealed that fileType accepts data 
 * in the form of varChar
 * 
 * @global type $conn
 * @return type int
 */
function queryMaxFileIDFromUploadedFiles(){
    global $conn;
    $queryGetMaxFileID = 'SELECT MAX(fileID) FROM uploadedFiles'; /* note the different PDO data access method 'fetchColumn'  used here */
    $result = $conn->query($queryGetMaxFileID)->fetchColumn();
    return $result;
}

/**
 * queryMaxSoftwareIDFromSoftware, supporting function
 * 
 * simply returns the max softwareID from the software table
 * in preparation for entering new software (in which case the ID will be 
 * incremented for new software to be written tot he DB )
 * 
 * ...using swid as a key
 * 
 * @global type $conn
 * @param type $_debug
 * @return type int
 */
FUNCTION queryMaxSoftwareIDFromSoftware($_debug){
    global $conn;
    $queryGetMaxSID = 'SELECT MAX(softwareID) FROM software'; /* note the different PDO data access method 'fetchColumn'  used here */
    $result = $conn->query($queryGetMaxSID)->fetchColumn();
    return $result;
}

/**
 * querySoftwareIDFromTitle_test
 * 
 * test structure:
 * sw-titles are queried from a set number of random software IDs
 * using the function querySoftwareTitleFromSW
 * titles are stored in array $testTitles()
 * 
 * the function querySoftwareIDsFromTitle
 * to retrieve swID from the title is then used on the array of titles
 * 
 * retrieved Ids (in array $qIDs() )are then compared with initial random IDs 
 * from array $testIDs()
 * 
 * if all IDs match then querySoftwareIDsFromTitle
 * appears to be working correctly
 * 
 * results are stored in a table for debugging and easy viewing
 * @param type $_testCount
 * 
 */
FUNCTION querySoftwareIDFromTitle_test($_testCount){
    _msgBox('b', 'fn: querySoftwareIDFromTitle_tests($_testCount:'.$_testCount.')...');
    _msgBox('white', '<br>querying random titles for their ID\'s...');
    
    $max = $_testCount;
    $testTitles = array();$qTitles = array();
    $testIDs = array();
    $qIDs = array();
    $mergedArrays = array();
    
    $blanks = 0;
    for($n=0;$n < $max;$n++){
        $_id = rand(1,1975);
        $testIDs[]= (int) $_id;
        #$qIDs[$n]= (int) $_id;
        $testTitles[]= querySoftwareTitleFromSW($_id, 0);
    }
    
    #print retrieved titles
    foreach($testTitles as $t){
        if ($t == ''){
            _msgBox('o','blank title found...');
            $blanks++;
        }
        echo 'retrieved title from testTitles array: "'.$t.'"<br>';
        $queriedID = querySoftwareIDsFromTitle($t, 0);
        
        # multi elements
        $count = count(array_values($queriedID));
        #echo '$count: '.$count.'<br>';
        
        if($count > 1){
            #echo 'multiple IDs returned..<br>';
            _msgBox('0', 'multiple IDs returned');
        }
        
        echo '$queriedID: '.$queriedID[0].' : <br>'; 
        $qIDs[]= (int) $queriedID[0];
    }
    #displayArrayAsTable(array_values($testIDs));
    # outer table
    echo '<hr><table border="1">';
    echo '<tr><td>';
    echo '<table border="1">';
    $hds = array('itr','randID');
    for($i=0;$i < count($testIDs); $i++){
        echo '<tr><td>';
        echo $i;
        echo '</td><td>';
        echo $testIDs[$i];
        echo '</td></tr>';
    }
    echo '</table>';
    
    #TABLE 2
    #echo 'count:';
    #echo count($qIDs);
    echo '</td><td>';
    echo '<table border="1">';
    /**
    $hds = array('itr','queriedID');
    #displayTableHeadersFromArray($hds);
     * 
     */
    #foreach(array_values($qIDs) as $el){
    
    for($i=0;$i < count($qIDs);$i++){    
        echo '<tr><td>';
        echo $i;
        echo '</td><td>';
        if ($qIDs[$i] == '') {
            echo '<i>blank</i>';
        } else {
            echo $qIDs[$i];
        }
        echo '</td></tr>';
    }#end loop
    echo '</table>';
    # outer table
    echo '</td></tr></table>';
    
    # array of IDs should be populated #use assertions on each one
    $counter = 0;
    $testSum = 0;
    
    foreach($qIDs as $q){
        $testSum += _myAssertQ(($testIDs[$counter] == $qIDs[$counter]), 'origID did not match queried ID !');
        $counter++;
    }
    #merge array data for display
    /**
    $merged = array_combine(array_values($testTiles), array_values($qTitles));
    #display data in comparison tables
    displayTitleDataInTableFromAssocArray($merged);
    
    $merged = array_combine(array_values($testIDs), array_values($qIDs));
    #display data in comparison tables
    displayTitleDataInTableFromAssocArray($merged);
    */
    
    echo $blanks.' blank titles found out of '.$max.'<br>';
    if ($testSum){#non zero testSum errors were detected
        _msgBox('o','ERRORS, UNIT TEST FAILED for randID vs queriedID');
    } else {
        _msgBox('g','testSum should be zero, 100% success');
        _msgBox('g','$testSum :'.$testSum);
        _msgBox('g','UNIT TESTS PASSED');    
    }
}

/**
 * Return softwareID(s) using its title
 * (from the software table)
 * 
 * if title exists in DB return softwareID else return 0
 * 
 * the challenge is that there are multiple titles with the same name 
 * (ie same title but different publishers)
 * so several IDs may be possibly returned
 * therefore this potentially returns an array of IDs
 * 
 * example software ?
 *
 * @global type $conn
 * @param type $_title
 * @param type $_debug
 * @return type array of ID's (ints)
 */
 
function querySoftwareIDsFromTitle($_title, $_debug){
    
    if($_debug) _msgBox('b','function querySoftwareIDFromTitle('.$_title.',debug)');
    #echo '@@ fetching ID...<br>';
    
    /**
    if(($_title=='' || (!isset($_title))) && $_debug){
        _msgBox('o','title error ?...');
        #_msgBox('o','but DB does contain some blank titles...');
        #_msgBox('o','query would return an array');
        #_msgBox('r','...exiting disabled');
        #exit();
    }    
    */
    
    global $conn;
    #QUERY (NB seq 1 only is an option (disabled))
    $queryTitleCheck = 'SELECT softwareID FROM software WHERE title LIKE :t '; # "AND sequenceNum = 1";
    $stmt = $conn->prepare($queryTitleCheck);
    #$stmt->bindParam(':t', ('"'.$_title.'"'));
    $stmt->bindParam(':t', $_title);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = null; #free memory ? report as extra tasks to do for project completeness
    return $results;
}

/**
 * querySoftwareTitle (used in title validation)
 * from the softwareTable
 * 
 * it was noted some titles in the DB 
 * have no title or a blank/empty title, breaking some unit/function tests
 * 
 * also several entries may have the same softwareID and the same title,
 * they are made unique to the database by inclusion of the sequence number 
 * in the primary key
 * 
 * this function tested by use of function querySoftwareIDFromTitle_test()
 * @param type $_id
 * @`return title string
 */
FUNCTION querySoftwareTitleFromSW($_id, $_debug){
    
    if(is_null($_id)){
        _msgBox('o', 'ERROR: swid "'.$_id.'" provided is null, invalid...');
    }
    
    if($_id > 0){
        global $conn;
        $queryGetTitle = 'SELECT title FROM software WHERE softwareID = :id';
        #$result = $conn->query($queryGetTitle)->fetchColumn(); #this should work as every swID is
        #or *should be* unique to a title
        
        $stmt = $conn->prepare($queryGetTitle);
        $stmt->bindParam(':id', $_id);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if(!is_null(($results))){
            $rT = $results['title']; #retrieved title
            #echo $rT;
        } else {
            _msgBox ('r', 'null Query results');
        }
        
        if($rT==''){ 
            _msgBox ('o', 'warning title was blank');
            #_msgBox ('orange', 'known blank titles have swids: 135,207,366,638,805,1119,1195,1200');
        }
        #if ($_debug) echo '<b>title retrieved: '.$rT.'</b><br>';
        
        return $rT;
    } else {
        _msgBox('o', 'ERROR: swid provided is <= 0, invalid swid, swid must be greater than 0...');
        return '';
    }
}

/**
 * queryContributorID_test
 * simple test against some pre-determined conID's
 * 
 * @param type $_debug
 */

FUNCTION queryContributorID_test($_debug){
    if ($_debug) _msgBox('b', 'T:fn: query ContributorID_test...');
    
    $conTestIDs = array( 1, 3 ,5, 9);
    $conTestIDs = array( 1, 2, 11);
    
    $conNames = array();
    $conQueriedIds = array();
    $name = '';
    
    print_r($conTestIDs);
    
    foreach($conTestIDs as $el){
        echo '$el: ';
        #print_r($el);
        echo $el;
        echo '<br>';
        
        # given name first, then familyName - broken ?
        $name = queryContributorNameFromID(((int) $el), 1);
        echo 'queried name fom ID:'.$name.'<br>';
        if ($name = '' || is_null($name)){
            echo '(blank)';
        } else {
            echo '(string: '.$name.')<br>';
        }
        echo '<br>';
        $conNames[]= $name;
    }
    
    #split name
    $_gn = $name;
    #echo 'Name: ';
    #echo $name;
    #echo '<br>';
    
    #find space
    $s = strpos($_gn, ' ');
    
    #extract givenName
    $_gn = substr($_gn, 0, $s);
    echo 'giveName: ';
    echo $_gn;
    echo '<br>';
    #extract familyName
    $_fn = substr($name, $s, strlen($name));
    echo 'famName: ';
    echo $_fn;
    echo '<br>';
    
    foreach($conNames as $el){
        echo 'name: '.$el;
        $_id = queryContributorIDByName($_gn, $_fn, $_debug);
        $conQueriedIDs[]= $_id;
    }
    
    #compare arrays (ADHD_displayData.php)
    validateArraysAreEqual($conTestIDs, $conQueriedIDs);
    
    if ($_debug) msgBox('g', 'fn: query ContributorID_test complete...');
}


/**
 * get contributorID from table contributor 
 * using the contributor's names
 *
 * tested by function:  insertContributorByNamesAndEmail(a,b,c,debug)
 * in File:             ADHD_functionsInsert.php
 * called by function:
 * called by file: ADHD_functionsInsert.php
 * 
 * return 0 if no contributor email exists
 * or return contributorID 
 * (if contributor email does exist)
 *
 * note local argument used rather than global variable
 * 
 * @return type int (contributorID)
 */
FUNCTION queryContributorIDByName($_gn, $_fn, $_debug){
    
    global $conn;
    if ($_debug) _msgBox('b', '<hr>fn: query ContributorIDByName...');
    
    $local_validation = 1;
    $contributorInsertID = 0;
    # override for testing $_email = "aaa@gmail.com";

    /*
    if( checkEmail($_email)) {
        if ($_debug) $DEBUG_STRING .= "\nemail: ".$_email." : email format validated\n";
    }
    */
    $cID = 0;
    $queryContributorID = 'SELECT contributorID FROM contributor '
            .'WHERE givenName = :gn AND'
            .' familyName = :fn';
    
    $stmt3 = $conn->prepare($queryContributorID);
    $stmt3->bindParam(':gn', $_gn);
    $stmt3->bindParam(':fn', $_fn);
    $stmt3->execute();
    $resultsContributor = $stmt3->fetch(PDO::FETCH_ASSOC);
    $stmt3 = NULL;
    
    if(!$resultsContributor){
        $cID = 0; 
    } else {
        
        $cID = $resultsContributor['contributorID'];
        if ($_debug) echo 'cID results: '.$_gn.' '.$_fn.' => '.$cID.'<br>';
        
        /** VALIDATION
        if ($local_validation) {
            $v_sql = 'SELECT email FROM contributor WHERE contributorID = ' . $contributorID;
            $assert_msg = "comparison FALSE: email from input FORM !== email queried from the returned contributorID...";
            $stmt_v = $conn->prepare($v_sql);
            #$stmt_v ->bindParam(':e', $_email);
            $stmt_v->execute();
            $resultsLocalVal = $stmt_v->fetch(PDO::FETCH_ASSOC);
            $returnedEmail = $resultsLocalVal['email'];

            echo 'form email: ' . $_email . '<br>';
            echo 'returned email' . $returnedEmail . '<br>';

            #assert — Checks if assertion is FALSE
            echo "\nASSET TEST\n";
            assert($returnedEmail === $_email,
                $assert_msg);
            echo "\nAssertion failed...Something went horribly wrong...\n";
        }
        */
    }
    if ($_debug) _msgBox('g', '<hr>fn: query ContributorIDByName complete...');
    if ($_debug) _msgBox('g', '<hr>fn: returning conID '.$cID.'...');
    return $cID;
}

/**
 * queryPublisherID_test()
 * tests the return of 
 * the ID of the publisher given by name
 *
 * returns an integer ID from the DB if publisher
 * exists, or 0 if it doesn't exist in the DB
 * 
 * note there may be several IDs associated to one publisher name - 
 * in which case... ?
 * 
 * @return type int (publisherID)
 */
function queryPublisherID_test(){
    
    #simply run queries versus some known publisher name->ID pairs
    # using an associative array
    
    #173 total publishers
    #testing on 25
    $unqiue = array(24,95);
    $examples = array(
        77 => 'Bolt Software',
        78 => 'Quality Programs',
        80 => 'Trident Technological Systems',
        81 => 'Soft Concepts',
        82 => 'Tawarri',
        
        83 => 'Hudson Soft',
        84 => 'Othello Multivision',
        85 => 'Red Rat Software',
        86 => 'Black Magic Software',
        87 => 'Vision',
        
        88 => 'CRL',
        89 => 'Sherston Software',
        90 => 'Otakou Software',
        91 => 'Codemasters',
        92 => 'Acid Software',
        
        93 => 'Progeni',
        94 => 'ArComPro',
        0 => 'Edu-Kit Productions', #unique case in this set, has 2 publisherID's 
        # associated with this publisherName
        98 => 'Computer Effects',
        99 => 'Typequick Pty Ltd',
        
        100 => 'ICL',
        103 => 'Guildhall Leisure Services Limited',
        104 => 'Halfbrick',
        106 => 'Cosmic Software',
        107 => 'Technosys Research Labs',
        
        108 => 'Richmond Computers User Club',
        109 => 'PRIMUG',
        110 => 'Mytek Computing',
        111 => 'Global Software Network',
        112 => 'Goodison Software'
        );
    
    $testCount = 30;
    $testSum = 0;
    $counter = 0;
    $err = "ERROR on positive test (bool should eval to TRUE):";
    
    #positive tests
    foreach (array_values($examples) as $test ){
        # do test on that name - ie retrieve the ID from the DB 
        # and compare it to what is in the predefined array (taken from the DB)
        
        echo 'testing on publisherName with known pubID: '.$test.'<br>';
        $bool = (queryPublisherID($test, 0) == array_keys($examples)[$counter]);
        $testSum += _myAssertQ($bool,'test err: '.$err);
        $counter++;
    }
    
    #negative tests - redundant - we know these tests will pass
    $err = 'negative test: bool should eval to FALSE ';
    foreach (array_values($examples) as $test ){
        # do test on that name - ie retrieve the ID from the DB 
        # and compare it to what is in the predefined array (taken from the DB)
        
        echo 'testing on publisherName with negative pubID: '.$test.'<br>';
        $bool = (queryPublisherID($test, 0) == rand(-10,0)); # we know this comparison should be false
        $testSum += _myAssertQ(($bool==$false),'test err: '.$err);
        $counter++;
    }
    
    #final conclusion of tests: 0 test sum is 100% success
    if($testSum){
        $pc = ($testCount-$testSum)/$testCount;
        _msgBox('o', 'UNIT TEST failed');
        _msgBox('o', 'with failed # of tests: '.$testSum);
        _msgBox('o', 'with percentage of '.$pc.'%');
    }else{
        _msgBox('g', 'UNIT TEST Passed');

    }
}

/**
 * DEPRECATED FUNCTION
 * queryPublisherIDUsingTableVariable (from publisher or software table)
 * 
 * @global type $conn
 * @param type $_publisher
 * @param type $_debug
 * @return int
 */
/**
FUNCTION _temp_queryPublisherIDUsingTableVariable($_publisher, $_table, $_debug){

    global $conn;
    
    $DEBUG_STRING = lineTXT();
    $queryPublisherID = ("SELECT publisherID FROM :tab WHERE publisherName = :pn");
    $DEBUG_STRING .= "\n".$queryPublisherID."\n";

    #PREP
    $stmt4 = $conn->prepare($queryPublisherID);
    
    #BIND
    $stmt4->bindParam(':tab', $_table);
    $stmt4->bindParam(':pn', $_publisher);
    
    #EXECUTE
    $stmt4->execute();
    $results = $stmt4->fetch(PDO::FETCH_ASSOC);

    if($results){ # GET THE ID
        $publisherID = $results['publisherID'];
        $DEBUG_STRING .= "\nPublisherID from ".$_table." table for \"".$_publisher."\": ".$publisherID." : \n";
    } else {
        $DEBUG_STRING .= "\n No publisher provided ? pub string: " . $_publisher."\n";
        $publisherID = 0;
    }

    #write
    #_writeToFileTXTLocal($DEBUG_STRING);
    return $publisherID;
}
*/

/**
 * queryPublisherID (from the publisher table)
 * 
 * may return... ?
 * @global type $conn
 * @param type $_publisher
 * @param type $_debug
 * @return int
 */
FUNCTION queryPublisherID($_publisher, $_debug){
    
    if ($_debug) _msgBox('b','FN: queryPublisherID{from pubName}(name) reached...');
    
    global $conn;
    $queryPublisherID = ("SELECT publisherID FROM publisher WHERE publisherName = :pn");
    $stmt = $conn->prepare($queryPublisherID);#PREP
    $stmt->bindParam(':pn', $_publisher);#BIND
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);

    if($results){ # GET THE ID
        $publisherID = $results['publisherID'];
        if($_debug){
            _msgBox('y', 'returned data type for publisherID: '.gettype($publisherID));
            _msgBox('y', 'publisher name($publisher): '.$_publisher);
            _msgBox('y', 'pubID returned: '.$publisherID);
        }
    } else {
        if ($_debug) _msgBox('o', 'query \'queryPublisherID\' did not return results ?...');
        $publisherID = 0;
    }
    return $publisherID;
}

/**
 * 
 * supporting function used in unit testing
 * tested manually
 * 
 * @global type $conn
 * @param type $_authid
 * @param type $type of name - family or given
 * @param type $_debug
 * @return string
 */
FUNCTION querygNameFromAuthor($_authID){
    global $conn;
    $querygName = ("SELECT givenName FROM author WHERE authorID = :id");
    
    $stmt = $conn->prepare($querygName);
    $stmt->bindParam(':id', $_authID);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);
    if($results['givenName']){
        return $results['givenName'];
    } else {
        return '';
    }
}

/**
 * 
 * supporting function used in unit testing
 * tested manually
 * 
 * @global type $conn
 * @param type $_authid
 * @param type $type of name - family or given
 * @param type $_debug
 * @return string
*/
FUNCTION queryfNameFromAuthor($_authID){
    global $conn;
    $queryfName = ("SELECT familyName FROM author WHERE authorID = :id");
    $stmt = $conn->prepare($queryfName);
    $stmt->bindParam(':id', $_authID);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);
    return $results['familyName'];
    
}

/**
 * Supporting function used in unit testing
 * 
 * @global type $conn
 * @param type $_id
 * @param type $_debug
 * @return int
 */
FUNCTION queryYearFromSoftware($_id, $_debug){
    global $conn;
    $queryYr = ("SELECT year FROM software WHERE softwareID = :id");
    #PREP
    $stmt = $conn->prepare($queryYr);
    #BIND
    $stmt->bindParam(':id', $_id);
    #EXECUTE
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);

    if($results){ # GET THE yr
        $yr = $results['year'];
    } else {
        $DEBUG_STRING .= "\n No yr provided ? for ID: " . $_id."\n";
        $yr = 0;
    }
    return $yr;
}

/**
 * queryAuthorFullNamesFromViewSoftware_test
 * 
 * test strategy:
 * 1.provide an array of known author names (size 10)
 * including balnk authors
 * 
 * 2. Get author IDs from the author_software Table using a softwareID
 * 3. Add the authorID to an array of IDs
 * 4. query the author's names (and concatenate) from the authorID
 * 5. compare queried results to hardcoded array of fullNames using assertion functions
 * 
 * weaknesses : the test only tests for the first 10 names
 * ideally ALL author names would be tested
 * 
 * hardcoded author names could be retrieved prior to test function being run 
 * and stored in a text file
 * 
 * phpMyadmin can export query Results as a php array !
 * 
 * 
 * 
 * @param type $_swid
 */
function queryAuthorFullNamesFromViewSoftware_test($_testCount, $_debug){
    # query and store authorID from author_software
    
    #swid queries : 0,1,2,3,4,5,6,7,8,9
    #matching author IDs:
    # _,_,8,1,2,3,4,21,_,5
    
    $sample = array(
        '','','Grahame Willis','Andrew Bradfield','Art Computer Software',
        'Bruce Hamon','William Tang','Denise Fricker','','Gregg Barnett'
    );
    
    #defines array $authorData (family name first of all authors)
    include 'ADHD_TEST_authorData.php'; 
    
    echo 'count($authorData): ';
    echo count($authorData);
    echo '<br>';
    
    $ids = array();
    $retFullNames = array();
    
    $queryCount = 10; # the number of author ID queries to make
    #$queryCount = count($authorData);
    
    #but not every author has a record with both names present
            
    for($n =0; $n < $queryCount; $n++){
        $q = queryAuthorIDsFromAuthSoftware($n);
        echo ($q[0]);
        echo '<br>';
        echo ($q[1]);
        echo '<br>';
        
        $ids[]= $q[0]; #like 'push' to array
    }
    
    #query and store author Names from author using authorID
    for($i=0;$i<count($ids);$i++){
            echo $i;
            
            #givenName
            $a = querygNameFromAuthor($ids[$i]);
            $b = queryfNameFromAuthor($ids[$i]);
            $retFullNames[]= ($a.' '.$b);
    }
    
    #validate retrieved names from DB with names in string
    /*
    $viewNames = array();
    for($i=0;$i<count($ids);$i++){
            echo queryAuthorFullNamesFromViewSoftware($ids[$i],0).'<br>';
    }
    */
    
    if(_myAssertQ($sample === $retFullNames, 'VALIDATION FAILED'));
    
    
    # query authorNames from author using authorID
    $_authid = 3;
    #query given name
    $a = querygNameFromAuthor($_authid);
    #query fmaily name
    $b = queryfNameFromAuthor($_authid);
    #query authorName from view (BROKEN
    #echo queryAuthorFullNamesFromViewSoftware(3,0).'<br>';
}

/**
 * queryAuthorFullNamesFromViewSoftwareBySWID()
 * BROKEN ?
 * 
 * SQL query makes use of a join between tables author and author_software
 * to do mem manage, set stmt = null
 * 
 * @param type $SWID
 * @return array of names
 */
function queryAuthorFullNamesFromViewSoftware($_swid, $_debug){

    global $conn;
    if ($_debug) _msgBox('b', 'function queryAuthorFullNamesFromViewSoftwareBySWID($SWID)');
    $_debug_local = 1;
    $queryAuthorNames = 'SELECT CONCAT('
        .'author.givenName, \' \', author.familyName) FROM '
        .'author '
        .'INNER JOIN author_software '
        .'ON author_software.authorID = author.authorID'
        .'WHERE author_software.softwareID = :swid ';
    
    if ($_debug_local){
        echo str_replace(':swid', $_swid, $queryAuthorNames);
        echo '<br>';
    }
    
    #PDO
    $stmtAuthors = $conn->prepare($queryAuthorNames);
    $stmtAuthors->bindParam(':swid', $_swid);
    
    # EXECUTE AND FETCH RESULTS
    $stmtAuthors->execute();
    #$authorIDs = $stmtAuthors->fetch(PDO::FETCH_ASSOC);
    #fetch assoc wont return an array for some reason...not how it works
    
    $authorNames = $stmtAuthors->fetch(PDO::FETCH_ASSOC);
    
    if ($_debug_local){
        echo 'array of author names: <br>';
        print_r($authorNames);
    }
    
    if ($_debug_local) _msgBox ('#ccffcc', 'function...complete');
    #FREE memory
    $stmtAuthors = null;
    return $authorNames;
}

/**
 * queryAuthorIDsFromAuthSoftwareBySWID
 * 
 * (#return all authorIDs 
 * [in an array] associated with a specific softwareTitle)
 * 
 * used by function :
 * queryAuthorFullNamesFromViewSoftware_test()
 * 
 * NB it is possible for an author to work on more than 1 piece of software
 * ie author with authorID 485 is associated with several records
 *
 * 
 * @param type $_n
 * @param type $_title
 * @return type array of authorIDs
 */
FUNCTION queryAuthorIDsFromAuthSoftware($_swid, $_debug){
    global $conn;
    #$_swid = 346;
    if($_debug) echo '$_swid parm to bind: '.$_swid.'<br>';
    if ($_debug) _msgBox ('#ccccff', 'function queryAuthorIDsFromSWID()...');
    
    #QUERY
    $authorsQuery = 'SELECT authorID FROM author_software WHERE softwareID = :swid';
    #$authorsQuery = str_replace(':swid', '346', $authorsQuery);
    if($_debug) echo '$authorsQuery: '.$authorsQuery.'<br>'; 
    #PDO binding
    $stmtAuthors = $conn->prepare($authorsQuery);
    $stmtAuthors->bindParam(':swid', $_swid);
    $stmtAuthors->execute();
    
    $res = $stmtAuthors->fetch(PDO::FETCH_ASSOC);
    if($_debug) echo 'results: ';
    if($_debug) print_r($res);
    $type = gettype($res);
    
    if ($type != (gettype(array('a'))) ){
        if ($_debug){
            _msgBox('o', 'data type needs to be array but instead got type '.$type);
            _msgBox('o', 'converting to/ returning array...');
        }
        
        if ($type === True || $type === False){
            return array('0');
        }
        
    } else {
        if ($_debug) _msgBox('o', '$authorIDs datatype:'.(gettype($res)));   
        return array_values($res);
    }
}

/**
 * 
 * queryAuthorIDFromName (given and family)
 * 
 * used by function ?
 * used by file ADHD_newEntryForm.php
 * 
 * @global type $conn
 * @param type $_givenName
 * @param type $_familyName
 * @param type $_debug
 * @return type int (ID)
 */
#returns an int
FUNCTION queryAuthorIDFromAuthorByName($_givenName, $_familyName, $_debug){
    
    global $conn;
    if ($_debug) _msgBox('b','FN: queryAuthorIDFromAuthorByName() reached...');    
    $gn = $_givenName;
    $fn = $_familyName;
    
    # this base Query is retrieving the authID from a given name
    # the one base query is used multiple times in the loop
    
    #QUERY
    $authIDQuery = (
    "SELECT authorID
         FROM author
         WHERE givenName = :gn
         AND familyName = :fn");
    
    $stmtAuthor_n = $conn->prepare($authIDQuery);
    $stmtAuthor_n->bindParam(':gn', $gn);
    $stmtAuthor_n->bindParam(':fn', $fn);
    # EXECUTE AND FETCH RESULTS
    # if ($_debug) echo 'executing query...<br>';
    $stmtAuthor_n->execute();
    $res_n_authors = $stmtAuthor_n->fetch(PDO::FETCH_ASSOC);
    
    #echo '[fn]$res_n_authors';
    if ($_debug) print_r($res_n_authors);
    echo '<br>';
   
    $authorID = -1;
    if($res_n_authors){
        $authorID = $res_n_authors['authorID'];
    } else {
        #print info
        if ($_debug) echo 'array not resolving to true for conditional<br>   ';
        /*
        if($_debug){
            $DEBUG_STRING .= "\n Query gave empty results.."; # no parentheses here prevented php from rendering
            $DEBUG_STRING .= "\n given: \t\t";
            $DEBUG_STRING .=  $_givenName;
            $DEBUG_STRING .= "\n fam: \t\t";
            $DEBUG_STRING .=  $_familyName;
            $DEBUG_STRING .=  " doesn't exist...needs to be inserted";
        } # endif
        */
        
    }
    $authorID = $res_n_authors['authorID'];
    if ($_debug) _msgBox('g', 'V: queryAuthorIDFromAuthorByName...complete');
    return $authorID;
}

/**
 * getMaxSeqNumForSoftware() (by swid)
 * 
 * this doesn't seem to be updating after an augmented (additional) entry
 * 
 * #should# get the max sequence Number from the DB
 * ($seqNum) for a particular software title using
 * softwareID as a key
 * 
 * returns an int ($max)
 * 
 * this function is not working under php version 7.0.27 as used on the server online (NetRegistry)
 * 
 * a list of abbreviations used in the code and their respective full forms
 * would be useful to have to aid future developers
 */
FUNCTION queryMaxSeqNumFromSoftware($_swid, $_debug){
    $queryMaxSeqNum = 'SELECT MAX(sequenceNum) FROM `software` WHERE `softwareID` = :swid';
    if ($_debug) echo 'softwareID: '.$_swid.'<br>';
    global $conn;
    #if ($_debug) echo 'Current PHP version: '.phpversion();
    echo '<hr>';
    
    //OVERRIDE
    #$queryMaxSeqNum = 'SELECT MAX(sequenceNum) FROM software WHERE softwareID = 1302';
    
    $stmt = $conn->prepare($queryMaxSeqNum);
    $stmt->bindParam(':swid', $_swid);
    $stmt->execute(); #possibly use another fetch method
    $res = $stmt->fetch(PDO::FETCH_ASSOC); #should return a single pair [ name => value]
    #$res = $stmt->fetch(PDO::FETCH_BOTH);
    #$res = $stmt->fetchAll();
    
    $maxSeqNum = $res['MAX(sequenceNum)'];
    if ($_debug) echo '$maxSeqNum: '.$maxSeqNum.'<br>';
    
    $stmt = null;
    $res = null;
    
    if ($_debug){
        echo '<h3>softwareID:'.$_swid.' NOW has : '.$maxSeqNum;
        if($maxSeqNum==1){ #after augmenting - there should be no titles with only 1 entry
            echo ' entry...</h3>';
        } else {
            echo ' entries...</h3>';
        }
        echo '(reverse chronological / newest first)<br>';
        echo '<hr>';
    }
    if ($maxSeqNum < 1){
        # something is very wrong as the number should be higher than 1
        # recall 0 means the software title doesnt exist in the DB at all and 
        # 1 means there is only one unique existing entry in the database for that title
        
        _msgBox('o','queries-> ZERO SEQNUM...something went very wrong with calculating seqNum');
        _msgBox('o','queries-> ZERO SEQNUM...but this works locally ?');
        exit();
    }
    return $maxSeqNum;
    }

 /**
  * queryMaxAuthorID
  * 
  * @return type integer (the max authorID from the author table)
  * (in preparation for new author insertion)
  */
FUNCTION queryMaxAuthorIDFromAuthor($_debug){
    global $conn;
    
    if ($_debug) _msgBox('b', 'querying max authID for auth insertion...');
        
    
    $queryGetMaxAuthorID = 'SELECT MAX(authorID) FROM author';
    /* note the different PDO data access method 'fetchColumn' used here */
    $result = $conn->query($queryGetMaxAuthorID)->fetchColumn();
        
    if ($_debug)  _msgBox('g', 'querying max authID for auth insertion...complete');
    return $result;
}


/**
  * queryMaxContributorIDFromContributor
  * 
  * @return type integer 
  * 
  * (NOT the same as the count of entries in the contributor table)
  * (used in preparation or for verification of new Contributor insertion)
  */
FUNCTION queryMaxContributorIDFromContributor($_debug){
    global $conn;
    if($_debug) _msgBox('b', 'querying max contributorID for contributor insertion...');
  
    $queryGetMaxContribID = 'SELECT MAX(contributorID) FROM contributor';
    /* note the different PDO data access method 'fetchColumn'  used here */
    $result = $conn->query($queryGetMaxContribID)->fetchColumn();
    if ($_debug) _msgBox('g', 'querying max ContribID...complete');
    return $result;
}

/**
  * queryCountContributorEntries (not the same as maxID)
  * !working
 * 
  * @return type integer (the count of entries in the 
  * contributor table)
  * (in preparation or for verification of new Contributor insertion)
  */
FUNCTION queryCountContributorEntries($_debug){
    _msgBox('b', 'fn:count contributor entries reached ...');
    global $conn;
    
    $queryCount = 'SELECT COUNT(contributorID) FROM contributor'; #max != count
    $result = $conn->query($queryCount)->fetchColumn();/* note the different PDO data access method 'fetchColumn'  used here */
    if ($result){
        if ($_debug) _msgBox('g', 'V:queryCount (Contributor) successful');
        if ($_debug) echo '<i>counted '.$result.' entries</i><br>';
        return $result;
        
    } else {
        _msgBox('red', 'E:queryCount (Contributor) is broken ?');
    }
}

/**
 * queryCountSoftwareEntries
 * 
 * should return the count/number of rows in the software table
 * 
 * @global type $conn
 * @param type $_debug
 * @return type
 */
FUNCTION queryCountSoftwareEntries($_debug){
    if ($_debug) _msgBox('b', 'fn:count software entries reached ...');
    global $conn;
    
    $queryCount = 'SELECT COUNT(*) FROM software'; #max != count
    $result = $conn->query($queryCount)->fetchColumn();/* note the different PDO data access method 'fetchColumn'  used here */
    if ($result){
        if ($_debug) _msgBox('g', 'V:queryCount (software(*)) successful');
        if ($_debug) echo 'counted '.$result.' entries<br>';
        return $result;
        
    } else {
        if ($_debug) _msgBox('red', 'E:queryCount (software) is broken ?');
        die();
    }
}
/**
 * queryContributorNameFromContributor($_id)
 * 
 * Returns the contributor’s names (given then family)
 * from the contributor table 
 * via the contributorID key
 * 
 * or return 0 if the names do not exist
 * 
 * @global type $conn
 * @param type $_id
 * @return type string (givenName concat with familyName)
 */
function queryContributorNameFromID($_id, $_debug){
    _msgBox('b', 'fn:queryContributorNameFromID reached...');
    global $conn;
    $queryConName = 'SELECT givenName, familyName FROM contributor WHERE contributorID = :c ';
    $stmt = $conn->prepare($queryConName);
    $stmt->bindParam(':c', $_id);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($_debug && 0){
        echo '<hr>';
        echo 'query $results for name from conID:<br>';
        print_r($results);
        echo '<hr>';
    }
    
    if ($results){
        _msgBox('g', 'queryContributorNameFromContributor() successful');
        #concat
        $fullName = $results['givenName'].' '.$results['familyName'];
        
        echo 'fullName: ';
        echo $fullName;
        echo '<br>';
        
        return $fullName;
        
    } else {
        _msgBox('o', '$results are null ?');
    }
    
    /*
    if (array_values($results)[0] && array_values($results)[1]){
        if ($_debug) _msgBox('g', 'queryContributorNameFromContributor() successful');
        #CONCAT names together
        return array_values($results)[0].' '.array_values($results)[1]; 
    } else {
        _msgBox('red', 'queryContributorNameFromContributor() is broken ? count should be > 0');
    }
    */ 
}

/**
 * queryDelete Entry (only 1 at a time) manually tested as part of the insert tests
 * 
 * optimally several entries *SHOULD* be deleted in one transaction
 * 
 * once entries are deleted the auto-increment number also needs to be updated 
 * so that when a new entry is inserted, the auto-inc number is indeed an increment 
 * of the current maximum ID to give correct sequential numbering
 * (some queries may rely on a proper sequence with no ID numbers missing for their 
 * functionality to work correctly)
 * 
 * function could be validated by searching for those entries just deleted
 * and expecting a null version
 * 
 * @return type int 0 for success, 1 for failure
 */
function queryDeleteContributorEntry($_id){
    
    global $conn;
    
    #VALIDATION now done in parent (calling this function) code
    /*
    $before = queryCountContributorEntries(0);
    echo $before.'<br>';
    */
    _msgBox('y', 'preparing to delete CONTRIBUTOR ENTRY# '.$_id);
    $queryDelete = 'DELETE FROM contributor WHERE contributorID = ":c"';
    $q = str_replace(':c', ((string) $_id), $queryDelete);
    $stmt = prepare($q);
    $stmt->execute();
    
    $after = queryCountContributorEntries(0);
    echo $after.'<br>';
    #VALIDATE
    /**
    if ($before === ($after-1)){
        #SUCCESS
        _msgBox('g', 'queryDeleteContributor() successful');
        return 0;
    } else {
        #ERROR
        _msgBox('o', 'fn: queryDeleteContributorEntry: something is broken, validation failed...');
        return 1;
    }
    */
    return 0;
}

/**
 * queryDeleteContributorEntries_test()
 * 
 * test strategy
 * 
 * queryDeleteContributorEntries already 
 * tested by function
 * insertContributorByNamesAndEmail_test()
 * in file ADHD_functionInsert.php
 * 
 * 
 * get title count
 * create some new entries
 * get new title count
 * delete the new entries
 * get new title count
 * compare to original title count
 * 
 
function queryDeleteContributorEntries_test(){
    # get tile count
    $global $conn;
    $titleCount = queryMaxContributorIDFromContributor(0);
    echo '$titleCount'.$titleCount;
    # Add some entries    
}
*/

/**
 * queryDeleteContributorEntries
 * 
 * Array must be sorted from lowest to highest (max) value
 * @param type $_array
 */

FUNCTION queryDeleteContributorEntries($_array, $_debug){
    #$s = size of $_array;
    
    _msgBox('y', 'fn: preparing to delete MULTIPLE contributor entries# ');
            
    $minVal = $_array[0];
    if ($_debug) echo $minVal.'<br>';
    
    $maxVal = $_array[count($_array)-1];
    if ($_debug) echo $maxVal.'<br>';
    
    $queryDeleteMultiple = 'DELETE FROM :t WHERE contributorID >= :n'
            . 'AND contributorID <= :x'; # DO NOT USE '*' !
    
    $before = queryCountContributorEntries(1);
    
    $queryDeleteMultiple = 'DELETE FROM contributor WHERE contributorID >= :n'
            . 'AND contributorID <= :x'; # DO NOT USE '*' !
    
    $stmt = prepare($queryDeleteMultiple);
    $stmt->bindParam(':n', $minVal);
    $stmt->bindParam(':x', $maxVal);
    $stmt->execute();
    
    #$after = queryCountContributorEntries(1);
    #validation required (count before delete and after delete CRUD)
    $before = 6;
    $after = 10;
    
    
    #echo ('before: '.$before.'<br>');
    #echo 'after: '.$after.'<br>';
    
    if ($before === ($after)+count($_array)){
        _msgBox('g', 'V:validation of deleted entries complete');
        _msgBox('g', 'count entries before and after CRUD');
    } else {
        _msgBox('r', 'E:something went very wrong, before and after CRUD counts failed');
    }
}

/**
 * test function to put queryUploadCount through its paces
 * 
 * test plan:
 * 0. count the uploads
 * 1. upload some known files
 * 2. count uploads again
 * 3. compare upload counts
 * 4. delete newly upload (temp) files 
 * 5. repeat
 * 
 * be aware that php itself can block the functionality of uploading files to the sever for security reasons
 * https://www.w3schools.com/php/php_file_upload.asp
 * 
 * @param type $maxTests
 */

function queryUploadCount_tests($_debug){
    
    _msgBox('b', 'FN: fn queryUploadCount_tests reached...');
    
    global $softwareID;
    
    $testSum = 0;
    
    #TEST FILES (absolute path)
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
    # JPG tests 
    $testFileType = 'jpg';
    $count = count($testFiles);
    
    for($i = 0;$i < $count;$i++){
        $targetFile = $testFilePath.$testFiles[$i];
        if ($_debug) echo $targetFile.'<br>';
        
        $beforeCount = queryUploadCount(0); #NB count was simply get max before, incorrect,
        #now corrected to proper count query
        if ($_debug) echo '#t: count before uploads: '.$beforeCount.'<br>';
        
        #INSERT FILE
        $_fileSize = round((fileSize($targetFile)/1024), 2);#to give us KB to 2 dec places
        if ($_debug) echo '#t: size(KB): '.$_fileSize.'<br>';
        $_fileName = $testFiles[$i];
        if ($_debug) echo '#t: fileName: '.$_fileName.'<br>';
        
        #here softwareId is incremented by 9000 for easy deletetion
        ##( but supposed to be fileID)
        #but upload paths can be easily be deleted by text grep of by date
        
        #insertUploadedFile($targetFile, $_fileSize, $testFileType, (9000 + $i), 1, 1);
        insertUploadedFile($targetFile, $_fileSize, $testFileType, ($softwareID + 1), 1, 1);
        
        $afterCount = queryUploadCount(0);
        if ($_debug) echo '#t: count after uploads: '.$afterCount.'<br>';
        
        $testSum += _myAssertQ($beforeCount == ($afterCount-1), 'counts should not be the same but they are ...');
        #to do validate the new file exits in the database
    }
    
    #validation @@@here
    $failMsg = 'testFileName is not the same as the queried filename';
    $failMsg .= ' of the last fileID in the uploadedFiles table';
    
    for($i = 0;$i < $count;$i++){
        $testFileName = $testFiles[$i];
        $lastID= queryMaxFileIDFromUploadedFiles();
        $lastID-= ($count-1);
        $lastID+= $i;
        $queriedFileName = queryUploadedFileName($lastID,0);
        # @@@
        # remove path from $queriedFileName
        $c = strlen($queriedFileName);
        $trunc = strlen($testFilePath);
        
        $queriedFileName = substr($queriedFileName,$trunc);
        if ($_debug) echo '#t: testFileName:'.$testFileName.'<br>';
        if ($debug) echo '$truncated: '.$queriedFileName.'<br>';
        
        if ($debug) echo '#t: $testFileName:'.$testFileName.'<br>';
        if ($debug) echo '#t: $queriedFileName:'.$queriedFileName.'<br>';
        $testSum += _myAssertQ($testFileName === $queriedFileName, $failMsg);
    }
    #testSum now tests for insertion and validation of file existence after insertion to the database
    if($testSum != 0){
        _msgBox('r', 'UT: UNIT tests failed');
    } else {
        _msgBox('g', 'UT: UNIT TESTS passed !');
    }
    
}

/**
function queryUploadsForFileName($_fileName){
    _msgBox('b', 'function check uploads for filename reached...');
    _msgBox('g', 'function check uploads for filename complete...');   
}
*/

/**
 * Get count of uploaded files (not getMax ID)
 *
 * to help validate a new file being uploaded
 * (if count before insertion == count after insertion then insertion failed)
 * 
 * @reurn type integer
 */
FUNCTION queryUploadCount($_debug){
    global $conn;
    
    $uploadCountSQL = 'SELECT COUNT(fileID) FROM uploadedFiles';
    $count = $conn->query($uploadCountSQL)->fetchColumn();
    return $count;
}

/**
 * 
 * get the uploaded fileName of the last upload from the 
 * uploadedFiles table
 * 
 * NB this function was originally
 * 'queryLastUploadedFileName'
 * to get the *last* uploaded fileName
 * from the uploadedFiles table use the max(file)ID
 * 
 * @global type $conn
 * @param type $_fid
 * @param type $_debug
 * @return type string (fileName)
 */

FUNCTION queryUploadedFileName($_fid, $_debug){
    
    if ($_debug) _msgBox('b', 'function: queryUploadedFileNameFromFileID('
            .$_fid.', $_debug('.$_debug.')');
    
    global $conn;
    $SQL = 'SELECT fileName FROM uploadedFiles WHERE fileID = :fid';
    #PDO
    $stmt = $conn->prepare($SQL);
    $stmt->bindParam(":fid", $_fid);
    $stmt->execute();
    $res = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = null;
    $f = $res['fileName'];
    if($f){
        if ($_debug) _msgBox('g', 'fn: getUploadedFileNameFromFileID() complete...');
        return $f;
    } else {
        _msgBox('r', 'E: error: results did not contain an attribute for \"fileName\"...');
    }
}
?>