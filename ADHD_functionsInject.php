<?php

/**
 * randAuthName
 * 
 * @param type $type string - specifies family name or given name
 * @return type string - random name
 */
 function randAuthName($type){
    if ($type=='g') $name='randGiv';
    if ($type=='f') $name='randFam';
    $alpha = 'abcdefghijklmnopqrstuvwxyz';
    $ar = str_split($alpha);

    for($n=0;$n<5;$n++){ #prob of duplicate is 1 in 26^5 = approx 12 million

        $name .= $ar[rand(0,25)]; #cannot use +=
    }
    return $name;
 }

/**
 * fakeName
 * 
 * generate a fake
 * name for testing purposes
 * @return string
 */

function _fakeName(){
    $alpha = ['a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p',
        'q','r','s','t','u','v','w','x','y','z'];
    
    $name = '';
            
    for($n = 0;$n<6; $n++){
        $name.=$alpha[rand(1,26)];
    }
    #echo $name;
    return $name;
}

/**
* min size -> 5
* max size -> 100
* 
* @return type an array of randomly picked names
* (picked from data on file)
*/

function randNameArray($_max){

   _msgBox('b', 'fn randNameArray reached...');
   #read file
   $path = '/Applications/MAMP/htdocs/NBPhp/AHSD/ADHD/text/';
   $fileNameMale = "_male_names.txt";
   $fileNameFemale = "_female_names.txt";

   $maleNames = file_get_contents($path.$fileNameMale); #put contents into a string
   $femaleNames = file_get_contents($path.$fileNameFemale);#echo $maleNames;#echo $femaleNames;
   $maxCharCount = 200; #the max number of chars to read
   $all = $maleNames.' '.$femaleNames;
   #$all = substr($all, 0, $maxCharCount);

   #test override        
   #$all = 'one,two,three,four';

   #echo 'all: '.$all.'<br>';
   #$Tok_test = myTokenise(' ', 'Aamir Aaron Abbey Abbie Abbot Abbott Abby Abdel');
   $tok = myTokenise(' ', $all);
   print_r($tok);

   #echo '<br>';
   #_msgBox('y', 'all: '.$all);

   $size = rand(5,$_max);

   for($i=0;$i<$size;$i++){
       #$newName = randAuthName('gn').' '.randAuthName('fn');
       $index = rand(0,count($tok));
       $newName = $tok[$index].' ';
       $index = rand(0,count($tok));
       $newName .= $tok[$index];

       echo $newName;
       $names[]= $newName;
   }

   echo 'name array : <br>';
   print_r($names);

   return $names;
}

/**
     * 
     * injectAuthorData
     * override the author variables into the vars array
     * 
     * @global type $authorGivenName
     * @global type $authorFamilyName
     * @param type $variable_assoc_array
     * @return type array
     */
function injectTestAuthorData($variable_assoc_array, $_debug){
    
    if ($_debug) _msgBox('b','FN: inject TEST authors min 0 max 5');
    
        global $authorGivenName;$authorGivenName1;$authorGivenName2;$authorGivenName3;$authorGivenName4;
        global $authorFamilyName;$authorFamilyName1;$authorFamilyName2;$authorFamilyName3;$authorFamilyName4;
        
        $authorGivenName  = randAuthName('g');# 'g' for giveName
        $authorGivenName1 = randAuthName('g');
        $authorGivenName2 = randAuthName('g');
        $authorGivenName3 = randAuthName('g');
        $authorGivenName4 = randAuthName('g');
        
        $authorFamilyName  = randAuthName('f');# 'f' for familyName
        $authorFamilyName1 = randAuthName('f');
        $authorFamilyName2 = randAuthName('f');
        $authorFamilyName3 = randAuthName('f');
        $authorFamilyName4 = randAuthName('f');

        $variable_assoc_array['authorGivenName'] = $authorGivenName;
        $variable_assoc_array['authorGivenName1'] = $authorGivenName1;
        $variable_assoc_array['authorGivenName2'] = $authorGivenName2;
        $variable_assoc_array['authorGivenName3'] = $authorGivenName3;
        $variable_assoc_array['authorGivenName4'] = $authorGivenName4;
        
        $variable_assoc_array['authorFamilyName'] = $authorFamilyName;
        $variable_assoc_array['authorFamilyName1'] = $authorFamilyName1;
        $variable_assoc_array['authorFamilyName2'] = $authorFamilyName2;
        $variable_assoc_array['authorFamilyName3'] = $authorFamilyName3;
        $variable_assoc_array['authorFamilyName4'] = $authorFamilyName4;
        
        if ($_debug) _msgBox('b','FN: inject rand TEST authors min 0 max 5 complete');
        return $variable_assoc_array;
    }

/**
 * injectTestUploadData2
 * 
 * details:
 * 
 * @global type $softwareID
 * @param type $_vars
 * @param type $_debug
 */
    
function injectTestUploadData2($_debug){
    
    if ($_debug) _msgBox('b', 'injectTestUploadData2 reached ...');
    
    global $softwareID;
    
    $disruptExecution = 0;
    $DEBUG = 1;
    $VALIDATE = 1;
    $upperLimit = 2097152; /* max file Size in bytes (2MB) */
    
    echo '</b>upper limit set: 2MB<br>';
    
    #count total files uploaded
    $uploadsCount = 0;
    
    ##INCREMENT##
    
    global $softwareID, $numberOfFiles;
    $insertSoftwareID = $softwareID + 1;
    $queriedSoftwareID = queryMaxSoftwareIDFromSoftware(0);
    
    echo '<hr>';
    _msgBox('y', 'sid:'.$softwareID.'<br>');
    _msgBox('y', 'sid to insert: '.$insertSoftwareID.'<br>');
    _msgBox('y', 'qID: '.$queriedSoftwareID.'<br>');
    echo '(insertion not actually done yet)<br><hr>';

    #$testFilePath = '/Applications/MAMP/htdocs/NBPhp/AHSD/images/test_images/';
    $basepath = '/Users/daniel/Desktop_test_pic/';
    echo 'base path set: '.$basepath.'<br>';
    
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

    ####################################
    #handle FILE n (1 to 10) in a loop
    # read files fom superglobal $_FILES
    ####################################
    if ($numberOfFiles){
        echo 'looping over '.$numberOfFiles.' files for uploads...<br>';
    } else {
        echo 'numberOfFiles not set from form...<br>exiting...';
        exit();
        
    }
    
    echo 'global files array:<br>';
    
    #displayRecArray($_FILES);
    
    for ($f=0;$f < $numberOfFiles; $f++){

        echo '<b>index: '.$f.'</b><br>';
        $ff = 'uploadedFile';
        if ($f>0) $ff .= ($f-1);
        # code is dependent on this name, messy code is triggered by form field labels not having a zero-index
        
        
        #print_r($_FILES[$f + 1]);
        ##BROKEN functions
        #displayDataInTableFromAssocArray($_FILES, 'green', 100, 1);
        #displayRecArray($_FILES);
        
        
        if(empty( $_FILES[$ff]) ) {
            echo "file " . $f . " is empty / not specified in form...<br>";
        } else { #NOT EMPTY : file has been specified in form (correctly?)

            if ($_FILES[$ff]['error'] == 0) { //if the file is present and no file errors are detected
                $uploadsCount += 1;
                #Check if the file is JPEG,GIF or png image or text and its size is less than 2Mb
                $fileName = basename($_FILES[$ff]['name']);
                $ext = substr($fileName, strrpos($fileName, '.') + 1);
                echo $ext.' '.$_FILES["uploadedFile"]["size"].'<br>';
                $ext = strtolower($ext);

                if ($captchaStatus != -1) {
                    if (($ext == "jpg" ||
                        $ext == "gif" ||
                        $ext == "png" ||
                        $ext == "txt" ||
                        $ext == "pdf") && ($_FILES[$ff]["size"] <= $upperLimit)) { #testfileSize against limit #if the file has a suitable extenstion

                        echo 'DEBUG: fileFormat is acceptable<br>';
                        #note only the extension is tested to determine file type...
                        # is this secure ?
                        $dir = dirname(__FILE__) . "/uploads";  #relative to the current file..
                        
                        #should eval to '/Applications/MAMP/htdocs/NBphp/AHSD/ADHD/uploads/'
                        
# Determine the path to which we want to save this file
                        echo 'current PATH:  '.$dir . '/<br>';

                        # check if the sid subdirectory already exists, if not - then create it
                        # uploads folder has the nsame form the softwareID?
                        
                        #echo '<hr><b>ls '.$dir.'/'.$insertSoftwareID.':</b> '
                        #        .shell_exec('ls '.$dir.'/'.$insertSoftwareID).'<hr>';
                        
                        $newDir = $dir.'/'.$insertSoftwareID;
                        echo 'checking for '.$newDir.'...<br>';
                        
                        if (!is_dir($newDir)){ #basepath already established above
                            echo 'directory '.$newDir.' not found...creating...<br>';
                            
                            if(mkdir($newDir, 0775, true)){
                                if(is_dir($newDir)){
                                    echo 'newly made directory '.$newDir.' found!<br>';
                                }
                            } else {
                                die('Failed to create folder'.$newDir.' (inject:277)...');
                            }
                        }
                        
                        
                        $newFilePathName = $newDir.'/'.$fileName;
                            echo 'DEBUG: new path.file made: ' . $newFilePathName . '<br>';
                        if (!file_exists($newFilePathName)) {# Check if the file with the same name already exists on the server

                            # Attempt to move the uploaded file to its new destination (php standard lib)
                            if ((move_uploaded_file($_FILES[$ff]['tmp_name'], $newFilePathName))) {
                                $fileSize = $_FILES[$ff]["size"];
                                _msgBox('g', '<b>File: '.$_FILES[$ff]["name"]);
                                // _msgBox('g','('.($fileSize/1014).'KB)');
                                _msgBox('g', 'has been uploaded successfully!</b>');
                                
                                $fileType = $ext;
                                
                                echo '$fileType: '.$fileType.'<br>';
                                echo '$ext: '.$ext.'<br>';
                                    
                                #count query
                                $uploadCountBeforeInsertion = queryUploadCount(1);
                                #PDO INSERT STATEMENT equivalent
                                $seqNum = 1; #seqNum is always 1 for new software
                                #CRUD OPERATION
                                insertUploadedFile($fileName, $fileSize, $fileType, $insertSoftwareID, $seqNum, $DEBUG);
                                $file_f = null;

                                #VALIDATION

                                /* get count before insertion and after insertion and check for increment */
                                if ($VALIDATE) echo 'CRUD VALIDATION<br>';
                                $uploadCountAfterInsertion = queryUploadCount(1);
                                if ($VALIDATE){
                                    if ($uploadCountAfterInsertion == ($uploadCountBeforeInsertion + 1)) {
                                        _msgBox('g','uploaded file count has incremented by one');
                                        
                                    } else { #VALIDATION ERROR
                                        _msgBox('r','VALIDATION ERROR:uploaded files count has not incremented !');
                                    }

                                    #CRUD: check name of last uploaded file
                                    #get Max fileID
                                    $lastID = queryMaxFileIDFromUploadedFiles();
                                    echo 'lastID: '.$lastID.'<br>';
                                    
                                    $lastFileEntry = queryUploadedFileName($lastID, 1);
                                    
                                    echo 'last image uploaded: ' . $lastFileEntry.'<br>';
                                    if ($lastFileEntry == $fileName) {
                                        echo 'filename used in CRUD(inject):' . $fileName . '<br>';
                                        echo 'filename assoc with max fileID: ' . $lastFileEntry . '<br>';
                                        echo $fileName.' == '.$lastFileEntry.': TRUE !';
                                        _msgBox('g','<b>file successfully inserted</b>');
                                    }
                                }
                                if ($DEBUG) echo '<hr>';
                                if ($DEBUG) echo '$file_f should now be closed and null: <br>';
                                if ($DEBUG) echo 'DEBUG:UPLOADS: results from executing bindArray: <br>';
                                #if ($DEBUG) print_r($res_file_f);
                                if ($DEBUG){
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
                            _msgBox('r', 'Error: File '.$_FILES[$ff]["name"] . ' already exists<br><br>');
                        }
                    } else { #error: the file uploaded exceeds the specified file size constraint
                        $disruptExecution++;
                        _msgBox('r', 'Upload Error: Only .jpg,.gif,.png images '
                                . 'and text(.txt) under 2MB are accepted for upload.');
                    } # end else
                } # end test captcha status
            }# end if file !empty
        }# end else ! empty
    }# end loop

    /**
    # INCREMNET #
    if ($_debug) _msgBox('r','old swid: '.$softwareID);
    $softwareID = queryMaxSoftwareIDFromSoftware(0);
    _msgBox('r','new swid: '.$softwareID);
    echo 'loop<br>';
    
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
        
        # here fileID is incremented by 9000 for easy deletetion
        # but upload paths can be easily be deleted by text grep of by date
        # softwareId must be incremenrted as it is just before insertion
        
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
        if ($_debug)_msgBox('r', 'Inf: file uploads completed with an error !');
    } else {
        if ($_debug)_msgBox('g', 'Inf: file uploads completed !');
    }
    if ($_debug) displayDataInTableFromAssocArray($_vars, 'blue', 100, 1);
    
    */
}

/** 
 * injectTestUploadData 
 * 
 * 
 * insert the file upload data into the vars array of data variables  
 */
    
function injectTestUploadData($_vars, $_debug){
    #print_r($_vars);
    
    if ($_debug) _msgBox('b', 'injectTestUploadData reached ...');
    
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
    
    # INCREMNET #
    if ($_debug) _msgBox('r','old swid: '.$softwareID);
    $softwareID = queryMaxSoftwareIDFromSoftware(0);
    _msgBox('r','new swid: '.$softwareID);
    echo 'loop<br>';
    
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
        
        # here fileID is incremented by 9000 for easy deletetion
        # but upload paths can be easily be deleted by text grep of by date
        # softwareId must be incremenrted as it is just before insertion
        
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
        if ($_debug)_msgBox('r', 'Inf: file uploads completed with an error !');
    } else {
        if ($_debug)_msgBox('g', 'Inf: file uploads completed !');
    }
    if ($_debug) displayDataInTableFromAssocArray($_vars, 'blue', 100, 1);
    
    #$_vars('nof') = $count;
    #return $_vars;
}

?>

