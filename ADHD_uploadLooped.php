<?php

/**
stage: Upload - needs to be converted to a function

Disrupt any insertion to the database if for any reasons files were not uploaded to the server
(if is incremented, and thus it is larger than 0)

Shift to PDO statements...

last Edited 13th March 2018 by graduate Daniel Phillis for Flinders University 2017, 2018
 * 
 * confirmed move function handles actual file transfer ?
 * 
 **/

$disruptExecution = 0;
$DEBUG = 1;
$VALIDATE = 1;
$upperLimit = 2097152; /* max file Size in bytes (2MB) */
#count total files uploaded
$uploadsCount = 0;
global $softwareID;
$insertSoftwareID = $softwareID + 1;
$queriedSoftwareID = queryMaxSoftwareIDFromSoftware(0);

echo '<hr><b>';

_msgBox('y', '<br>sid:'.$softwareID.'<br>');
_msgBox('y', '<br>sid to insert: '.$insertSoftwareID.'<br>');
_msgBox('y', '<br>qID: '.$queriedSoftwareID.'<br>');

echo '<hr></b>';

/*
    There are some constraints on what the user may upload
    ie format JPG, JPEG, GIF or PNG and fileSize < 2097152 bytes(2MB)
    (denoted by php var $upperLimit)
    String Operations substr, strrpos

    * Code does the following:
    * Extract the extension form the string, force it to lower case
    (therefore we do not have to test for upper case extensions)
    * check capture security variable (this will change)

echo 'superglobals array';
print_r($_FILES);
echo '<br>';
*/

$basepath = '/Users/daniel/Desktop_test_pic/';
$DEBUG = 0;
if ($DEBUG) msgBox('y', '$softwareID: '.$softwareID);
$insertSoftwareID = SoftwareID + 1;
if ($DEBUG) _msgBox('y', '$insertSoftwareID: '.$insertSoftwareID);

####################################
#handle FILE n (1 to 10) in a loop
# read files fom superglobal $_FILES
####################################

for ($f=0;$f < 10; $f++){
    
    #if ($DEBUG) $DEBUG_STRING .= "DEBUG UPLOAD: index: ".$f."\n";
    $ff = 'uploadedFile';
    if ($f>0) $ff .= ($f-1);
    # code is dependent on this name, messy code is triggered by form field labels not having a zero-index

    if(empty( $_FILES[$ff]) ) {

    } else { #NOT EMPTY : file has been specified in form (correctly?)

        if ($_FILES[$ff]['error'] == 0) { //if the file is present and no file errors are detected
            $uploadsCount += 1;
            #Check if the file is JPEG,GIF or png image or text and its size is less than 2Mb
            $fileName = basename($_FILES[$ff]['name']);
            $ext = substr($fileName, strrpos($fileName, '.') + 1);
            #echo "\n"." ".$ext." ".$_FILES["uploadedFile"]["size"]."\n";
            $ext = strtolower($ext);
            
            if ($captchaStatus != -1) {
                if (($ext == "jpg" ||
                    $ext == "gif" ||
                    $ext == "png" ||
                    $ext == "txt" ||
                    $ext == "pdf") && ($_FILES[$ff]["size"] <= $upperLimit)) { #testfileSize against limit #if the file has a suitable extenstion
                    $dir = dirname(__FILE__) . "/uploads"; # Determine the path to which we want to save this file
                    #$DEBUG_STRING .= "PATH: " . $dir . "\n";

                    # check if the sid subdirectory already exists, if not - then create it
                    if (!is_dir($insertSoftwareID)) {
                        #@mkdir("$dir.'/'.$softwareID", 0775); deprecated
                        $newDir = $dir.'/'.$insertSoftwareID;
                        if (!mkdir($newDir, 0775, true)) {
                                die('Failed to create folder'.$newDir.' (inject:264)...');
                            }
                            #echo 'new dir made using mkdir: '.$newDir.'/'.$fileName.'<br>';
                    }
                    $newFilePathName = $dir . "/" . $softwareID . "/" . $fileName;
                    
                    if (!file_exists($newFilePathName)) {# Check if the file with the same name already exists on the server

                        # Attempt to move the uploaded file to its new destination (php standard lib)
                        if ((move_uploaded_file($_FILES[$ff]['tmp_name'], $newFilePathName))) {
                            $fileSize = $_FILES[$ff]["size"];
                            #count query
                            $uploadCountBeforeInsertion = queryUploadCount(1);
                            #PDO INSERT STATEMENT equivalent
                            $seqNum = 1; #seqNum is always 1 for new software
                            #CRUD OPERATION
                            $fileType = $ext;
                            $ft = $_FILES($ff)['fileType'];
                            
                            echo '$filetpye, $ext: '.$fileType.', '.$ext.'<br>';
                            echo '$_FILES($ff)[\'fileType\']: '.$ft.'<br>';
                            
                            insertUploadedFile($fileName, $fileSize, $ft, $softwareID, $seqNum, $DEBUG);
                            $file_f = null;

                            #VALIDATION should be in a seperate file
                            $uploadCountAfterInsertion = queryUploadCount($DEBUG);

                            if ($VALIDATE) {
                                if ($uploadCountAfterInsertion == ($uploadCountBeforeInsertion + 1)) {
                                    if ($DEBUG) _msgBox('g','uploaded file count has incremented by one');
                                } else { #VALIDATION ERROR
                                    if ($DEBUG) _msgBox('r','VE: VALIDATION ERROR:uploaded files count has not incremented !');
                                }

                                #CRUD: check name of last uploaded fil
                                $lastID = queryMaxFileIDFromUploadedFiles();
                                $lastFileEntry = queryUploadedFileName($lastID, 1);
                                
                                if ($lastFileEntry == $fileName) {
                                    if ($DEBUG){
                                        echo 'filename used in DB insertion operation:<br>' . $fileName . '<br>';
                                        echo 'filename assoc with max fileID: ' . $lastFileEntry . '<br>';
                                        _msgBox('g','<b>FILE successfully inserted</b>');
                                    }
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
                        echo "<span style=\"font-size: 11px; color: red;\">Error: File ";
                        echo $_FILES[$ff]["name"] . " already exists</span><br/><br/>";
                    }
                } else { #error: the file uploaded exceeds the specified file size constraint
                    $disruptExecution++;
                    echo "<span style=\"font-size: 11px; color: red;\">";
                    echo 'Upload Error: Only .jpg,.gif,.png images and text(.txt) under 2MB are accepted for upload.</span><br/><br/>';
                } # end else
            } # end test captcha status
        }# end if file !empty
    }# end else ! empty
}# end loop
echo '</font>';
?>