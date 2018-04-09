<?php


/**
 * displayRecArray
 * 
 * @param type $_recArray
 * void
 */
FUNCTION displayRecArray($_recArray){
    $tempCounter = 0;
    
    # @@@ to do: get depth
    
    foreach($_recArray as $_file){
        _msgBox('y', 'innner index:'.$temp_counter);
        print'<hr>';
        //##########################
        $innerCounter = 0;
        #print_r($_file);
        
        $names = array_keys($_file);
        $nums = array_values($_file);

        
        foreach($_file as $el){
            if($el){
                echo '-';
                echo $names[$innerCounter];
                echo '-';
                echo $el;
                echo $nums[$innerCounter];
                echo '<br>';
            }
            $innerCounter++;
        }
        $tempCounter++;
    }
}


/**
 * displayDocAttachments
 * 
 * Displaying the documents if any of the files in the 
 * switch statement above were documents
 * (true if the $docFlag is set to 1)
 *
 * encapsulated with in a table row
 * return type void
 */
    
FUNCTION displayDocAttachments($_filePathDoc, $_debug){
    echo "<br><b>Document Attachments:</b><br><br>";
    
    if($_debug){ 
        echo 'filePathDoc: ';
        echo $_filePathDoc.'<br>';
    }
        
    $n = sizeOf($_filePathDoc);
    

    for ($i=0; $i < $n; $i++) {
        if(file_exists($_filePathDoc[$i])) {
            echo '<td width="'.(100/$n).'25%">';
            echo "<a href='".$_filePathDoc[$i]."' target='_blank'>View This Document</a> (";
            echo $_filePathDoc[$i];
            echo") (".$_filePathDoc[$i]."kb)<br>";
            echo '</td>';
        }
    }
    echo '</tr>';
}

/**
 * 
 * Retrieve uploaded files from the DB in relation to the queried software 
 *(but only for seqNum 1)

 * (Aliases in sql are optional according to 
 * "http://www.1keydata.com/sql/sql-as.html" and are purely used to make 
 * the code more readable )

 * @param type $_filePathImage
 *
 *
 */
FUNCTION displayImgAttachments_all($_swid){

    global $conn;
    #global $softwareID;

    $tableBorderToggle1 = 1;
    $tableBorderToggle2 = 0;
    #$tableBorderColour1 = 'red';
    $tableBorderColour1 = 'whitesmoke';
    $tableBorderColour2 = 'whitesmoke';
    #$tableBorderColour2 = 'green';

    #@@@ Why is this not inside a query

    $queryFiles = "SELECT DISTINCT up.fileName, 
                  up.fileType, 
                  up.fileSize, 
                  up.softwareID 
            FROM 	uploadedFiles 	AS 	up, 
            software 		AS	s 
            WHERE 	up.sequenceNum 	= 1 
            AND 	up.softwareID 	= s.softwareID 
            AND 	up.softwareID = '".$_swid."'"; #sql 'AS' not used here (optional)

    $stmtFiles = $conn->query($queryFiles); # or die($db_connection->error.__LINE__);
    $stmtFiles->execute();

    #GOING THROUGH THE FILES, DISPLAY IF NEED BE
    $resultsSize = sizeOf($stmtFiles);
    echo '<table border="'.$tableBorderToggle2.'" border color="'.$tableBorderColour2.'">'; # TABLE 2

    if($stmtFiles){
        $filePathImage  = array();   // Save image names with path in an array for later display
        $filePathDoc    = array();     // Save document names with path in an array for later display
        $fileTypeDoc    = array();     // Save document types for later display
        $fileSizeDoc    = array();     // Save document size for later display

        $imageFlag  = 0; // To display to user whether the attachment is an image (0=no, 1=yes);
        $docFlag    = 0; // To display to user whether the attachment is a doc (0=no, 1=yes);
        $indexImage = 0; // Index for image array
        $indexDoc   = 0; // Index for doc array
        $kb         = 1024;
    }
    while ( $rowFile = $stmtFiles->fetch(PDO::FETCH_ASSOC)){ 
    #row file s dynamically assigned and doesnt have to be defined previously

        #Keeping track of which files are images and which files are documents
        switch ($rowFile['fileType']){
                case "gif":
                        $imageFlag = 1;
                        $filePathImage[$indexImage] = "uploads/".$_swid."/".$rowFile['fileName'];
                        $indexImage++;
                        break;
                case "png":
                        $imageFlag = 1;
                        $filePathImage[$indexImage] = "uploads/".$_swid."/".$rowFile['fileName'];
                        $indexImage++;
                        break;	
                case "jpg":
                        $imageFlag = 1;
                        $filePathImage[$indexImage] = "uploads/".$_swid. "/".$rowFile['fileName'];
                        $indexImage++;
                        break;
                case "txt":
                        $docFlag = 1;
                        $filePathDoc[$indexDoc] = "uploads/".$_swid."/".$rowFile['fileName'];
                        $fileTypeDoc[$indexDoc] = $rowFile['fileType'];
                        $fileSizeDoc[$indexDoc] = floor($rowFile['fileSize']/$kb);
                        $indexDoc++;
                        break;
                case "pdf":
                        $docFlag = 1;
                        $filePathDoc[$indexDoc] = "uploads/".$_swid."/".$rowFile['fileName'];
                        $fileTypeDoc[$indexDoc] = $rowFile['fileType'];
                        $fileSizeDoc[$indexDoc] = floor($rowFile['fileSize']/$kb);
                        $indexDoc++;
                        break;	
                }
        }
            /** Displaying the images if any of the files in the switch statement above were images
            (true if the $imageFlag is set to 1) */
    if ($imageFlag == 1) {
        echo '<tr><td width="25%">';//echo '</td></tr>';
        echo "<br/><b>Photo Attachments:</b><br><br>";
        echo '</td>';
        echo '</tr>';

            #INNER TABLE
            /* run over array and display the elements (images) and build links to images */
            $n = sizeOf($filePathImage);

            for ($i=0; $i < $n; $i++) {
                if(file_exists($filePathImage[$i])) {

                echo '<td width="'.(100/$n).'25%">';
                echo "<a href='".$filePathImage[$i]."' 
                    class='fullsizable'><img class='fullsizable' 
                    src='".$filePathImage[$i]."' 
                    width='140' height='100'/></a>";
                echo '</td>';
                }
            }
        echo '<tr>';
    }
    #Displaying the documents if any of the files in the switch statement above were documents 
    #(true if the $docFlag is set to 1)
    
    if ($docFlag == 1) {
        echo "<br><b>Document Attachments:</b><br><br>";

        $n = sizeOf($filePathDoc);

        for ($i=0; $i < $n; $i++) {
            if(file_exists($filePathDoc[$i])) {
                echo '<td width="'.(100/$n).'25%">';
                echo "<a href='".$filePathDoc[$i]."' target='_blank'>View This Document</a> (";
                echo $fileTypeDoc[$i];
                echo") (".$fileSizeDoc[$i]."kb)<br>";
                echo '</td>';
            }
        }
        echo '</tr>';
    }
    echo '</table>'; #END TABLE
}

/**
 * displayImageAttachments
 * 
 * Displaying the images if any of the files in the switch statement above were images
 * (true if the $imageFlag is set to 1)
 *
 * encapsulated in a table row
 * return type void
 */
FUNCTION displayImgAttachments($_filePathImage, $_debug){

    echo '<tr><td width="25%">';#echo '</td></tr>';
    echo '<font size="2">';
    echo "<br/><b>Photo Attachments:</b><br><br>";
    echo '</td>';
    echo '</tr>';

    #INNER TABLE
    /* loop over array and display the elements (images) 
     * and build links to images */
    if($_debug){
        echo '<font color = "blue">';
        #echo '$_filePathImage';
        #print_r($_filePathImage);
        echo '<br>';
    }
    
    $n = sizeOf($_filePathImage);
    
    #if ($_debug) echo 'image count:'.$n.'<br>';
    
    for ($i=0; $i < $n; $i++) {
        
        #this was causing images to not be displayed
        $_filePathImage[$i] = 'includes/'.$_filePathImage[$i];
        
        if($_debug && 0){
            echo '$_filePathImage: '.$i.'<br>';
            echo $_filePathImage[$i].'<br>';
        }
        
        if(file_exists($_filePathImage[$i])){
            echo '<td width="'.(100/$n).'25%">';
            #to aid in debugging syntax
            #echo '<img src= "includes/uploads/10/hobbit1.gif">';
            # escape chars
            echo '<a href="';
            echo $_filePathImage[$i];
            echo '" class="resizable">';
            echo '<img class="fullsizable" src= "'.$_filePathImage[$i];
            echo '" width="140" height="100">';
            echo '</a>';
            echo '</td>';
        }
    }
    echo '<tr>';
}

/**
 * compare 2 tables in a nestING table
 * (nesting two nested tables)
 * 
 * @@@ to do:
 * if the element of the new array differs from the old array
 * the table cell will be highlighted yellow
 * 
 * if the data element is not present in the new array
 * but was present in the old array the placeholder '<-' is added instead of 
 * nothing
 */

function compareArraysInTables($_arr1, $_arr2,$_debug){ 
    echo '<table border="0" style="">'
            #table headers
                .'<th width="50%"><b>'
                .'Old Data'
                .'</b></th><th width="50%"><b>'
                .'New Data'
                .'</b></th><tr><td width="50%">';
    displayDataInTableFromAssocArray($_arr1, 'whitesmoke', 50, $_debug);
    echo '</td>';
    echo '<td width="50%">';
    displayDataInTableFromAssocArray($_arr2, 'whitesmoke', 50, $_debug);
    echo '</td>';
    echo '</table>';
}

/**
 * displayDataInTableFromAssocArray (with optional indecies)
 * no need for test function
 * 
 * (recall assoc arrays have a key => value structure)
 * 
 * publisherID is an internal attribute and filtered out form display
 * 
 * @param type $_assocArray
 * @param type $_cen : internal data is censored / omitted from display
 * (softwareID, sequenceNum, numberOfFiles, publisherID, contributorID)
 * @param type $_debug
 * return type void
 */
function displayDataInTableFromAssocArray($_assocArray, $_color, $_pc, $_indexed, $_debug){
    #table cell color for keys (not values) in assoc array
    $keyColor   =   $_color; #"whitesmoke"
    $fontSize   =   '.3em';
    $_pc = 40;
    
    if (!is_array($_assocArray)){
        #replace
        _msgBox('r','E:error: incoming parm is not an array');
        
        echo 'incoming $_assocArray:';
        print($_assocArray);
        exit();
    } else {
        #empty test
        echo '<table border="1" '
        
        #Style USE # to toggle activation
        .' style="'
        .'font-size: 1em; '
        .'bgcolor: '.$_color.'; '
        .'width: '.$_pc.'%;'
        .'">';
        
        #echo '</font>';
        #for all keys - put them into a table column alongside corresponding values
        #for compaison of $oldData versus $newData
        $cellCounter = 0;
        $cellCounterOffset = 0;
        
        foreach($_assocArray as $key => $value){    
            #filter for censoring diaply of internal data
            
            /*
            if ($key !== 'publisherID'   ||
                $key !== 'contributorID' ||
                $key !== 'softwareID'    ||
                $key !== 'sequenceNum'   ||
                $key !== 'numberOfFiles'
            )*/
            if(0){
                $cellCounter++;
                $cellCounterOffset++;
            } else {
            
                #INDEX CELL
                if($_indexed){
                    echo '<tr><td  width="8%" ';
                    echo 'style="background: '.$_color.';">';
                #DATA
                    echo (($cellCounter - $cellCounterOffset) + 1)
                    #echo '</font>';
                    .'</td>';
                }
                #### #### #### #### #### #### #### #### #### ####
                #KEY CELL
                echo '<td  width="'.$_pc.'%" '
                #CELL STYLE
                /*
                .'style="bgColor: ';
                if(($cellCounter%2)==0){
                    echo $keyColor;
                } else {
                  echo 'green';
                };
                */
                
                #.'border-color: green; '
                #echo 'font-size: .2;';
                .'">';
                
                #DATA : #key
                echo '<font size="'.$fontSize;
                if ($key == 'sequenceNum') echo ' color="green"';
                echo '">';
                
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
                $cellCounter++;
            }
        }
        echo '</table>';
    }
}

function displayDataInTableFromAssocArrayCensored($_assocArray, $_color, $_pc, $_indexed, $_debug){
    
    
    #table cell color for keys (not values) in assoc array
    $keyColor   =   $_color; #"whitesmoke"
    $fontSize   =   '.3em';
    #OVERRIDE siapay of indices / table row numbers in the table
    $_indexed = 0;
    
    echo '<font size=".3em" color="grey"><i>internal data censored</i></font>';
    
    if (!is_array($_assocArray)){
        #replace
        _msgBox('r','E:error: incoming parm is not an array, but type: '.gettype($_assocArray));
        exit();
    } else {
        
        echo '<table border="1" '
        .' style="'
        .'font-size: 1em; '
        .'bgcolor: '.$_color.'; '
        .'width: '.$_pc.'%;'
        .'">';
        $cellCounter = 0;
        
        #array of cencered assoc array keys
        $censored = array('softwareID', 'sequenceNum','numberOfFiles','publisherID','contributorID');
        
        foreach($_assocArray as $key => $value){    
        
            if(!in_array($key, $censored)){
                #INDEX CELL
                #$key is legal to display to user
                    if($_indexed){
                        echo '<tr><td  width="8%" ';
                        echo 'style="background: '.$_color.';">';
                    #DATA
                        echo $cellCounter
                        #echo '</font>';
                        .'</td>';
                    }
                    #### #### #### #### #### #### #### #### #### ####
                #KEY CELL
                    echo '<td  width="'.$_pc.'%">';

                #DATA : #key
                    echo '<font size="'.$fontSize.'">';
                    
                    if(!in_array($key, $censored)){
                        switch($key){
                            case 'title': echo 'Title';
                                break;
                            case 'year': echo 'Year';
                                break;
                            case 'publisherName': echo 'Publisher';
                                break;
                        
                            case 'licenceList': echo 'Licence';
                                break;
                            case 'description': echo 'Description';
                                break;
                            case 'notes': echo 'Notes';
                                break;
                            case 'hardwareReq': echo 'Hardware Requirements';
                                break;
                            case 'softwareReq': echo 'Software Requirements';
                                break;
                            case 'insertedDate': echo 'Inserted Date';
                                break;
                            case 'country': echo 'Country';
                                break;
                        
                        }
                    }
                    
                    
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
            $cellCounter++;
        }
        echo '</table>';
    }
}

/**
 * displayDataInTableFromAssocArray()
 * 
 * display a simple table of only software title and swid's
 */
function displayTitleDataInTableFromAssocArray($_ar){
        echo '<table border="1">';
    foreach($_ar as $k => $v){
        echo '<tr><td>';
        echo $k;
        echo '</td>';
        echo '<td>';
        echo $v;
        echo '</td>';
        echo '</tr>';
    }
    echo '</table>';
}

/**
 * convenience function to display data from an array in a table for easy viewing 
 * @param type $_ar
 */

function displayArrayAsTable($_ar){
    echo '<table border="1">';
    
    foreach($_ar as $el){
        echo $el;
        
        echo '<tr><td>';
        # echo (int) $el;
        echo $el;
        echo '</td></tr>';
    }
    
    echo '<td style="background-color: orange;"> --- </td>';
    
    foreach(array_values($_ar) as $el){
        echo '<tr><td>';
        # echo (int) $el;
        echo $el;
        echo '</td></tr>';
    }
    
    echo '</table>';
}

/**
 *
 * displayDataInTable() used by ADHD_modifyEntry.php
 *
 * NO LOOPING IN THIS FUNCTION
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
 * @param type $_debug
 */
function displayDataInTable($_debug){
    
    global $tableBorderToggle1;
    global $tableBorderColour1;
    
    global $title, $softwareID, $year, $familyName, $givenName, $publisherName, $country, $licenceList;
    global $hardwareReq, $softwareReq, $description, $notes;
    #global $seqNum;
    
    if ($_debug) _msgBox('b','fn: displayDataInTable...<br>');
    
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

    /** we dont need to show title ? 
     * as we are already modifying an existing title  */
    if(!is_null($title) && !empty($title)){
      echo '<tr><td width="25%" style="font-size: 13;">'
      ."<b>Title: </b>"
      .'<td width="75%" style="font-size: 13;">'
      .$title
      .'</td></tr>';
      }

    /* if year is returned from CRUD ops then show it */
    if (!is_null($year) && !empty($year)) {
        echo '<tr>'
        .'<td width="25%" style="font-size: 13;">'
        ."<b>Year: </b>"
        .'<td width="75%" style="font-size: 13;">'
        .$year
        .'</td></tr>';
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
        echo '<tr><td width="25%" style="font-size: 13;">'
        ."<b>Author(s): </b>"
        .'<td width="75%" style="font-size: 13;">'
        .$fullNameArrTemp
        .'</td></tr>';
    }

    /* if publisherName is returned from our CRUD op then show it */
    if (!is_null($publisherName) && !empty($publisherName)) {
        echo '<tr><td width="25%" style="font-size: 13;">'
        ."<b>Publisher: </b>"
        .'<td width="75%" style="font-size: 13;">'
        .$publisherName
        .'</td></tr>';
    }

    /** if country is returned from our CRUD op then show it */
    if (!is_null($country) && !empty($country)) {
        echo '<tr><td width="25%" style="font-size: 13;">'
        ."<b>Country: </b>"
        .'<td width="75%" style="font-size: 13;">'
        .$country.'</td></tr>';
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
        ($licenceList=='')    ){#not the same as null
        
        #todo 
        echo '<tr><td width="25%" style="font-size: 13;">'
        ."<b>Licence: </b>";
            
        #todo change the entry to null or '' (blank string)
    } else {
        #this check only done if data != "not chosen"
        if (!is_null($licenceList) && !empty($licenceList)) {
            echo '<tr><td width="25%" style="font-size: 13;">'
            ."<b>Licence: </b>"
            .'<td width="75%" style="font-size: 13;">'
            .$licenceList
            .'</td></tr>';
        }
    }

    if (!is_null($hardwareReq) && !empty($hardwareReq)) {
        echo '<tr><td width="25%" style="font-size: 13;">'
        ."<b>Hardware Req's: </b>"
        .'<td width="75%" style="font-size: 13;">'
        .$hardwareReq
        .'</td></tr>';
    }
    
    #handle 'N/A' case -> dont display anything instead of displaying 'N/A'
    IF ($softwareReq == 'N/A'){
        echo '<tr><td width="25%" style="font-size: 13;">'
        ."<b>Software Req's: </b>";
            
    } else {
        if (!is_null($softwareReq) && !empty($softwareReq)) {
            echo '<tr><td width="25%" style="font-size: 13;">'
            ."<b>Software Req's: </b>"
            .'<td width="75%" style="font-size: 13;">'
            .$softwareReq
            .'</td></tr>';
        }
    }

    if (!is_null($description) && !empty($description)) {
        echo '<tr><td width="25%" style="font-size: 13;">'
        ."<b>Description: </b>"
        .'<td width="75%" style="font-size: 13;">'
        .$description . '</td><br>'
        .'</td></tr>';
    }

    if (!is_null($notes) && !empty($notes)) {
        echo '<tr><td width="25%" style="font-size: 13;">'
        ."<b>Notes: </b>"
        .'<td width="75%" style="font-size: 13;">'
        .$notes
        .'</td></tr>';
    }
    echo '</table>';

    if ($_debug) echo 'fn: displayDataInTable($_'.'debug) complete...<br>';
}

/**
 * display IMAGES / DOCS / UPLOADS
 * was previously in its own php file (loopUploads)
 * 
 */

function displayUploads($_swid, $_debug){
   global $conn;
    
   $TOGGLE_TABLE_BORDERS = 1;
   $DEBUG = $_debug;

   $fileSQL = 'SELECT
                   up.fileName, 
                   up.fileType, 
                   up.fileSize, 
                   up.softwareID 
           FROM uploadedFiles AS up, software AS s 
           WHERE up.sequenceNum = 1 
           AND up.softwareID = s.softwareID 
           AND up.softwareID = :sid';

   $resFile = $conn->prepare($fileSQL);
   $resFile->bindParam('sid', $_swid);
   $resFile->execute();
   $resArray = $resFile->fetchAll();

   #  GOING THROUGH THE DATA
   if(count($resArray) > 0) {

           $filePathImage 	= array(); #  Save image names with path in an array for later display
           $filePathDoc 	= array(); #  Save document names with path in an array for later display
           $fileTypeDoc 	= array(); #  Save document types for later display
           $fileSizeDoc 	= array(); #  Save document size for later display

           $imageFlag 		= 0; #  To display to user whether the attachment is an image (0=no, 1=yes);
           $docFlag 		= 0; #  To display to user whether the attachment is a doc (0=no, 1=yes);
           $indexImage 	= 0; #  Index for image array
           $indexDoc 		= 0; #  Index for doc array

       # dont need to be looped
       $imgThumbSizeX = 100;
       $imgThumbSizeY = 140;

       #TABULAR FORM
       echo '<table border = "1" 
           style="
               /*border: whitesmoke; */
               /*border: red;*/
               border: whitesmoke;
           ">';
       echo '<tr>';

       foreach($resArray as $rowFile){

           echo '<tr><td width="100%">';
               # Keeping track of which files are images and which files are documents
       $newPath = 'includes/uploads/'.$_swid."/".$rowFile['fileName'];
       $prevPath = $newPath;

       # dont display the same image more than once !

       switch ($rowFile['fileType']){
               case "gif":
                       $imageFlag = 1;
                       $filePathImage[$indexImage] = $newPath;
                       $indexImage++;
                       break;
               case "png":
                       $imageFlag = 1;
                       #$filePathImage[$indexImage] = "uploads/".$_swid."/".$rowFile['fileName'];
                       $filePathImage[$indexImage] = $newPath;
                       $indexImage++;
                       break;	
               case "jpg":
                       $imageFlag = 1; #includes folder added to path below 8/12/17
                       #$filePathImage[$indexImage] = $base.$_swid."/".$rowFile['fileName'];
                       $filePathImage[$indexImage] = $newPath;
                       $indexImage++;
                       break;	
               case "txt":
                       $docFlag = 1;
                       #$filePathDoc[$indexDoc] = "uploads/".$_swid."/".$rowFile['fileName'];
                       $filePathImage[$indexImage] = $newPath;
                       $fileTypeDoc[$indexDoc] = $rowFile['fileType'];
                       $fileSizeDoc[$indexDoc] = floor($rowFile['fileSize']/1000);
                       $indexDoc++;
                       break;
               case "pdf":
                       $docFlag = 1;
                       #$filePathDoc[$indexDoc] = "uploads/".$_swid. "/".$rowFile['fileName'];
                       $filePathDoc[$indexDoc] = $newPath;
                       $fileTypeDoc[$indexDoc] = $rowFile['fileType'];
                       $fileSizeDoc[$indexDoc] = floor($rowFile['fileSize']/1000);
                       $indexDoc++;
                       break;

       }# end switch

       if ($DEBUG) {
           echo 'Path: ';
           echo $filePathImage[$indexImage - 1];
           echo '<br>';
           #echo '@ls *';
           #print_r($res_array());
       }

       # DISPLAY UPLOADED IMAGES
       $imageCount = sizeOf($filePathImage);

       #if($imageFlag == 1 && ($imageCount > 0)){
       if($imageFlag && $imageCount){
           echo "<br><b>Photo Attachments:</b><br><br>";
           echo '<table border="'.$TOGGLE_TABLE_BORDERS.'" 
                   style="
                       border-top: none;
                       border-bottom: none;
                       border-left: none;
                       border-right: none;
                       /*border-color: green;*/
                       border-color: whitesmoke; 
               ">';

           echo '<tr>';
           echo '<tr>';
           # TEST
           # echo 'ImagePath: '.$filePathImage.'<br>';
           # echo 'uploads/10/hobbit1.gif';
           if ($DEBUG) print_r($filePathImage);
           # FOREACH IMAGE
           if ($DEBUG) echo '$imageCount in image folder: '.$imageCount.'<br>';

                       for($i=0; $i < $indexImage; $i++){
                           if($DEBUG) {
                   echo '$i: ' . $i . '<br>';
                   echo '$indexImage: ' . $indexImage . '<br>';
               }
               #REMOVE DUPLICATE IMAGE DISPLAY #($filePathImage[$i] != $filePathImage[$i-1])
                               if( file_exists($filePathImage[$i])){
                       echo '<td>';
                       /** DONT DISPLAUY DUPLICATE IMAGES */
                       if($indexImage < 2) {
                       echo '<a href="' . $filePathImage[$i] . '" class="fullsizable">';
                       #DISLPAY IMAGE
                       echo '<img';
                       echo ' class="fullsizable" src="' . $filePathImage[$i];

                       # image size vars must be gloabls
                       echo '" width="' . $imgThumbSizeX . '"';
                       echo ' height="' . $imgThumbSizeY . '"';
                       echo '>';
                   }
                   echo '</a></td>';
                               }else{
                                       echo 'DEBUG: file path broken<br>';
                               }
                       }#end For loop
                       echo '</td></tr>';
               }

           /** DISPLAY UPLOADED DOCUMENTS
            *  Displaying the documents if any of the files in the switch
            * statement above were documents (true if the $docFlag is set to 1)
            */
           $_debug = 0;

           if ($docFlag == 1) {
                   echo "<br><b>Document Attachments:</b><br>";
                   echo '<br><br>';
                   echo '<tr>';
                   # FOREACH DOCUMENT
                   for ($i=0; $i<sizeOf($filePathDoc); $i++) {
                           echo '<td>';

                            if($_debug){
                               echo 'filePathDoc: ';
                               print_r($filePathDoc);
                            }

                       if(file_exists($filePathDoc[$i])){
                           echo "<a href='" . $filePathDoc[$i];
                           echo "' target='_blank'>View This Document
                           </a> (";
                           echo $fileTypeDoc[$i] . ") (" . $fileSizeDoc[$i] . "kb)<br>";
                       }else{
                           echo 'DEBUG: Doc filePath Broken<br>';
                       }
                       echo '</td>';
                   }
                   echo '</tr>';
           }# end if documents are uploaded
           echo '</td></tr>';
           echo '</table>'; #table dedicated to images
       } # end for each(array)
       
       echo '</hr>';
   }# end if
}
?>