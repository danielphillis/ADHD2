<?php
    
    
    
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