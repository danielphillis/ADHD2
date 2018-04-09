<?php
	error_reporting(E_ALL ^  E_NOTICE);
?>


<script type="text/javascript">
	/* Onload script:
   make sure element one is hidden (but what is this element) */
    window.onload = setup;

    function setup() {
        document.getElementById('one').style.display = 'none';
    }

	/* SHOW ELEMENT */
    function show(newItem) {
        var item = document.getElementById(newItem);
        if (item.style.display == 'none') {
            item.style.display = 'block';
        }
        else {
            item.style.display = 'none';
        }
    }
    
    /* */

    function ShowMenu(num, menu, max) {
        //starting at one, loop through until the number chosen by the user
        for (i = 1; i <= num; i++) {
            //add number onto end of menu
            var menu2 = menu + i;
            //change visibility to block, or 'visible'
            document.getElementById(menu2).style.display = 'block';
        }
        //make a number one more than the number that was input
        var num2 = num;
        num2++;
        //hide it if the viewer selects a number lower
        //this will hide every number between the selected number and the maximum
        //ex.  if 3 is selected, hide the <div> cells for 4, 5, and 6
        //loop until max is reached
        while (num2 <= max) {
            var menu3 = menu + num2;
            //hide 
            document.getElementById(menu3).style.display = 'none';
            //add one to loop
            num2 = num2 + 1;
        }
    }

    function show(elem) {
        elem.style.display = "block";
    }

    function hide(elem) {
        elem.style.display = "";
    }
</script>

<?php
        include 'ADHD_newEntryFormStyle.php'; #<!-- CSS overrides only -->
        
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
?>         

<?php
/* @@@ local connection */
	require_once('../conn/ADHD_DB_CONNECTION_PDO.php');
	$conn = connectDB();
	
        #include("./includes/ADHD_functionsCreate.php");
        
        include("ADHD_functionsInsert.php");
        include("ADHD_functionsQueries.php");
        include("ADHD_functionsFormFields.php");
        include 'ADHD_functionsUtilities.php';
        
	$insertionStatus = 0; // Used to log any errors occurred in the insertion operations to the database and halt execution of the insertion operations in the later conditional statements that used this variable
	$fileUploadStatus = 0; // Used to log any errors occurred in the files upload operation to the database and to the server. It halts any execution given there is an error.
	$captchaStatus = 0; // Used to log any whether a wrong value is entered for captcha. It halts any execution if captcha value was wrong.
?>

<?php
	/* Declare some global variables */
	GLOBAL $HTTP_POST_VARS, $printAgain, $error, $saveTitle, $title;
?>

<div style="width:70%; margin: 0 auto;">
    <FORM action="ADHD_newEntry.php" enctype="multipart/form-data" method="POST" class="search">
        
    <!-- TITLE 
    <label for="title" id="modifyEntryLabels">* Title: 
    </label>
    <?php
        //if form is submitted
        /*
        if(isset($_POST["Submit"])){

                if($_POST["title"]=="") {
                        print("<span style=\"font-size: 11px; color: red;\">Please enter a title.</span>");
                }
                else if(preg_match("/^\\s/",$_POST["title"])){
                        print("<span style=\"font-size: 11px; color: red;\">Cannot start with space.</span>");  
                }
        }
        */
    ?>
    
    
    <INPUT type="text" class="input" name="title" id="title" value="" required/><br/> -->
    
    <?php
        $_title = 'randTitle'.( rand(0, 1000));
        field_title($_title);
    ?>
    
    <!-- YEAR 
    <label for="Year" id="modifyEntryLabels"> Year: </label>
    <INPUT type="text" class="input" name="Year" id="Year" size="4" value="" maxlength="4" pattern="\d*" oninvalid="setCustomValidity('Please enter a number.')"
    onchange="try{setCustomValidity('')}catch(e){}"/><br/>
		
    <div class="tooltipContainer" onmouseover="show(tooltip00)" onmouseout="hide(tooltip00)">
        <label for="authGivenFamily" id="modifyEntryLabels"> Number of Authors: <font style="font-size: 11px; color:#DA6200;">(See Note)</font></label>
        <div class = "bigTooltip" id= "tooltip00">
                Select how many author(s) this software has, then enter their name(s).   
        </div>
    </div> -->
    <?php 
    field_year('2018');
    ?>
    
    <!-- SELECT AUTHOR 
    <SELECT class="sel1" id="authGivenFamily" name="authGivenFamily" onChange="ShowMenu(document.getElementById('authGivenFamily').value, 'divInput', 5);">
        <OPTION value="0">0 </OPTION>
        <OPTION value="1">1 </OPTION>
        <OPTION value="2">2 </OPTION>
        <OPTION value="3">3 </OPTION>
        <OPTION value="4">4 </OPTION>
        <OPTION value="5">5 </OPTION>
    </SELECT><br/>
    -->
    
    <?php 
        field_arrayUpTo5Authors();
        /* Create 10 DIV tags in a loop rather than manually repeating them */
        #loopAuthorFields();#broken
        #createUploadFormFieldsWithLoop();
        #createAuthorFormFields(5);
    ?>
    
		
    <!-- PUBLISHER 
    <label for="publisher" id="modifyEntryLabels"> Publisher: </label>
    <INPUT type="text" class="input" name="publisher" id="publisher" size="30" value=""/><br/>
    <label for="publisher" id="modifyEntryLabels"> Country: </label>
    -->
    
    <?php field_publisher('Melbourne House'); #inject value into form field ?>
        
    <!-- SELECT COUNTRY 
    <SELECT class="sel1" name="country">
        <OPTION>Choose a country... </OPTION>
        <OPTION value="Australia">Australia</OPTION>
        <OPTION value="New Zealand">New Zealand</OPTION>
        <OPTION value="Others">Others</OPTION>
    </SELECT><br/>
    -->
    
    <?php field_country('Australia'); ?>
    
    <!-- HARDWARE REQs 
        <label for="hardwareReq" id="modifyEntryLabels"> Hardware Requirements: </label>
        <TEXTAREA class="textarea" name="hardwareReq" id="hardwareReq" rows="1"></TEXTAREA><br/>
    -->
    <?php   
        field_hardwareReqs(); 
        field_softwareReqs();
    ?>

    <!-- SOFTWARE REQs 
        <label for="softwareReq" id="modifyEntryLabels"> Software Requirements: </label> 
        <TEXTAREA class="textarea" name="softwareReq" id="softwareReq" rows="1"></TEXTAREA><br/>
        <label for="description" id="modifyEntryLabels"> Description: </label>
        <TEXTAREA class="textarea" name="description" id="description" rows="1"></TEXTAREA><br/>
    -->
    <?php    
        field_desc(); 
    ?>
    
    <!-- TOOLTIPS -->

    <div class="tooltipContainer" onmouseover="show(tooltip1)" onmouseout="hide(tooltip1)">
        <!--
        <label id="modifyEntryLabels" for="notes"> Notes: <font style="font-size: 11px; color:#DA6200;">(See Note)</font></label>
        -->
        <?php field_notes(); ?>
    
        <div class = "bigTooltip" id="tooltip1">
            Include information here that doesn't fit elsewhere.  For example: working copy status, collection title is housed in, the chip for obscure systems, version numbers, 
            if you are the author, copyright owner (if known), programming language, emulation availability, credits for photos, information on manuals, etc.
        </div>
    </div>

    <!-- BIG TOOLTIP FOR NUMBER OF FILES -->
    <!--
        <TEXTAREA class="textarea" name="notes" rows="7"></TEXTAREA><br/>
    -->
    
    
    <div class="tooltipContainer" onmouseover="show(tooltip0)" onmouseout="hide(tooltip0)">
    <label for="filesnum" id="modifyEntryLabels"> Number of Files: <font style="font-size: 11px; color:#DA6200;">(See Note)</font></label>
    <div class = "bigTooltip" id= "tooltip0">
            We only accept images (ending ".jpg",".gif",".png"), plain text (.txt) and pdf files. The files should be less than 2MB.   
        </div>
    </div>

    <SELECT class="sel1" id="num" name="filesnum" onChange="ShowMenu(document.getElementById('num').value, 'divFile', 9);">
        <?php
            #Echo 10 options in a drop down menu (NB <= used (10 is included))
            for ($n=0;$n<=10;$n++){
                echo '<OPTION value="'.$n.'">'.$n.' </OPTION>';
            }
        ?>
    </SELECT><br/>			
    
    <?php 
        /* 10 manually / explicitly defined div tags for file inputs hidden by default 
        also created with php loop below, serving include file redundant */
        #include ('./includes/ADHD_uploadLooped.php');
    
        formGenerateUploadFields(10);

        //display n upload DIVS using the function defined externally
        #loopUploadFields(10);
        #createAuthorFormFieldsForTesting(10); #from ADHD_finctionsCreate.php
        
    ?>
    
    <!-- CHOOSE A LICENCE 
    <label for="licenceList" id="modifyEntryLabels"> Licence for uploaded content: </label>
    <SELECT class="sel1" name="licenceList">
            <OPTION>Choose a licence... </OPTION>
            <OPTION>GNU General Public License </OPTION>
            <OPTION>Attribution </OPTION>
            <OPTION>Attribution-noncommercial </OPTION>
            <OPTION>Attribution-Share Alike </OPTION>
            <OPTION>Attribution-noncommercial-sharealike </OPTION>
            <OPTION>Public Domain </OPTION>
            <OPTION>Sampling Plus </OPTION>
            <OPTION>Noncommercial Sampling Plus </OPTION>
            <OPTION>Copyright </OPTION>
    </SELECT><br/>
    -->
    <?php 
        field_licence();
    ?>

    <!--
    <div class="tooltipContainer" onmouseover="show(tooltip2)" onmouseout="hide(tooltip2)">
        <label for="contributorFamily" id="modifyEntryLabels"> * Your Family Name: 
        <font style="font-size: 11px; color:#DA6200;">(See Note)</font>

        <?php
                /* CHECK FAMILY NAME IS FILLED OUT (MANDATORY FIELD) 
                IF (ISSET($_POST["Submit"])) {
                        IF ($_POST["contributorFamily"] == "") {
                                global $insertionStatus;
                                $insertionStatus = 1;
                                PRINT("<span style=\"font-size: 11px; color: red;\">Please enter your family name.</span>");
                        }
                }
                */
        ?>
        </label>
        <div class = "smallTooltip" id= "tooltip2">
                Your name will be kept confidential.
        </div>
    </div>
    
    
    <!-- CONTRIBUTOR FAMILY NAME
        <input type="text" class="input" name="contributorFAMILY" size="30" value="" required//><br/>
        <div class="tooltipContainer" onmouseover="show(tooltip3)" onmouseout="hide(tooltip3)">
            <!-- CONTRIBUTOR FIRST NAME 

            <label for="contributorGIVEN" id="modifyEntryLabels">Your Given Name: 
            <font style="font-size: 11px; color:#DA6200;">(See Note)</font></label>
            <div class = "smallTooltip" id= "tooltip3">
                    Your name will be kept confidential.
            </div>
        </div>
        <!-- CONTRIBUTOR GIVEN NAME INPUT
        <input type="text" class="input" name="contributorGiven" size="30" value=""/><br/>
    -->
    
    <?php            
        fields_contributor_test(); #inserets my self as a test contributor
        #fields_contributor();
    ?>
        <!-- email tool tip -->
        <div class="tooltipContainer" onmouseover="show(tooltip4)" onmouseout="hide(tooltip4)">
            
        <!--
        <label for="altAddress" id="modifyEntryLabels"> * Your email address: 
        <font style="font-size: 11px; color:#DA6200;">(See Note)</font>
        -->
        
        <?php
            $inject = 1;
            field_email($inject);
            
            /* CHECK for EMAIL ADDRESS - A MANDATORY FIELD */
            /*
            if (isset($_POST["Submit"])) {
                if ($_POST["altAddress"] == "") {
                    global $insertionStatus;
                    $insertionStatus = 1;
                    //ERROR MESSAGE
                    print("<span style=\"font-size: 11px; color: red;\">Please enter your email address.</span>");
                } else {
                    if (!checkEmail($_POST["altAddress"])) {
                        global $insertionStatus;
                        $insertionStatus = 1;
                        //ERROR MESSAGE
                        print("<span style=\"font-size: 11px; color: red;\">Invalid email address.</span>");
                    }
                }
            }
           */
        ?>
        </label>
            <div class = "smallTooltipEmail" id= "tooltip4">
                Your email address will not be disclosed.
            </div>
        </div>

        <!-- EMAIL
        <input type="email" class="input" name="altAddress" size="30" value="" required/><br/>
        <input type="text" class="captchaemail" name="email" size="30" value=""/> 
        -->
        
        <?php
            
            field_captcaEmail();
        
            /* IF EMAIL IS BLANK - DO NOTHING ? this must be checked somewhere else */
                if (isset($_POST["Submit"])) {
            }
        ?>

        <!-- ENTER VERIFICATION CODE 
            <label for="verifCode" id="modifyEntryLabels"> * Enter Verification Code: </label>
            <input type="text" id="verif_code" class="securityInput" name="verif_code" style="margin-bottom: 3px;" maxlength="5" required/>
        -->
        <?php 
            
            echo '<br>';
            
            field_verifCodeInput();

            if (isset($_POST["Submit"])) {
                $verifCode = $_POST["verifcode"];
                echo 'verifcode: '.$verifCode;
                /*if the code matches the image md5 is obsolete ? */
                if(md5($verifCode).'8cq3' == $_COOKIE['imgcap']){
                    global $captchaStatus;
                    unset($_COOKIE['imgcap']);					
                    $captchaStatus = 0;
                } else {
                    /*CODE doesnt match the image, then later test for 
                     * the state of the $captureSatatus var or use it as a multiplier */ 
                    global $captchaStatus;		
                    $captchaStatus = 1;
                }
            }
        ?>
        <!-- Display the error field - why is this in a seperate block of code ? -->
        <?php 
                global $captchaStatus;
                if($captchaStatus == 1){
        ?>
        <label id="modifyEntryLabels"> </label><!-- no label -->
        <span style="margin-bottom:10px; color:red; padding:3px; width: 209px; height: 29px;">Wrong Verification Code!</span>
        <?php ;}?>

        <label id="modifyEntryLabels"> </label><!-- no label -->
        <img src="ADHD_captchaContent.php?<?php echo rand(0,9999);?>" alt="verification image, type it in the field above." width="215px" height="29" align="absbottom" style="margin-top: 5px; border-color:#64a3ba; border:1px dashed #64a3ba; border-radius: 10px;" /><br/>

        <?php  ?>

        <label id="modifyEntryLabels"> </label>
        <div style="display: inline-block;">
        
            <!--
        <INPUT type="submit" id="searchButton" name="Submit" value="SUBMIT" />
        <INPUT type="reset" id="resetButton" class="button" value="RESET" />  
        -->
        
        <?php
            formButtons(); 
        ?>
        </div>	
	</FORM>
  </div>
<?php
	if (isset($_POST["Submit"])) {
		//check for email field is not empty (bot)
		$error['email'] = false;
		if (!$_POST["email"] == "") {
			$error['email'] = true;
                        
                        #REDIRECT TO SELF - remote
                        /*
			echo '<script type="text/javascript" language="javascript">
				window.open("http://www.ourdigitalheritage.org","_self");
				 </script>'; 
                        */
                        
                        # LOCAL
                        echo '<script type="text/javascript" language="javascript">
				window.open("http://localhost:8080/NBPhp/AHSD/ADHD/ADHD_newEntry.php","_self");
				 </script>';
                        
		} 
		else {
			check_form();
		}
	}

	FUNCTION check_form() {
		GLOBAL $HTTP_POST_VARS, $error, $printAgain, $saveTitle;
		GLOBAL $title, $conn, $softwareID, $insertionStatus;

		array_walk($_POST, create_function('&$val', '$val = trim($val);'));
		//error if "Your Family Name" is empty
		IF ($_POST["contributorFamily"] == "") {
			$error['contributorFamily'] = TRUE;
			$printAgain = TRUE;
		}
		//error if email is empty
		IF ($_POST["altAddress"] == "") {
			$error['emailAddress'] = TRUE;
			$printAgain = TRUE;
		}
		//error if email address is not correct
		IF (!checkemail($_POST["altAddress"])) {
			$error["emailAddress"] = TRUE;
			$printAgain = TRUE;
		}
		//error if year is not numeric
		IF (!is_numeric($_POST["Year"]) && $_POST["Year"] != "") {
			$error['Year'] = TRUE;
			$printAgain = TRUE;
		}

		IF ($printAgain) {
			/* foreach($_POST as $key =>$value){
			  // do something using key and value
			  print $key; print " "; print $value; print "<br>";
			  } */

			ECHO '<center><b><font color="red">Error: You have not completed all the required information!</font></b></center><br>';
		}
		
		ELSE {
			#formAssignVariables();
                        $_debug = 1;
                        $newVars = formStoreData($_debug);
                        
			static $seqnum = 1;
                        
			#global $softwareNumRows;
			#$softwareNumRows = titleExists($title);
			#$softwareNumTempRows = $softwareNumRows;
			
                        #print_r($newVars); works
			
                        formProcessData($newVars, $_debug);
                        
			# IF TITLE IS UNIQUE - executes database operations below
                        
                        $softwareIDArray = querySoftwareIDsFromTitle($title, $_debug);
                        
                        
                        $softwareID = array_keys($softwareIDArray)[0];
                        
                        echo '==>'.$softwareID.'<br>';
                        exit;
                        
                        
			if (        $softwareID == 0 
                                || ($softwareID == NULL)
                                || $softwareID == ''
                            ){
				
                                #NEW ENTRY
				#Author 1
				#queryAuthors();
				queryAuthorFullNamesFromViewSoftware($softwareID, $debug);
                                
				//CONTRIBUTOR
				#$contributorID = $queryContributorID($altAdress);
                                $contributorID = $query;
				$contributorIDTemp = $contributorID;

				//Publisher
				$publisherID = queryPublisherID($publisher);
				$publisherIDTemp = $publisherID;
				
				// Get the ID of last software entry and add 1 to it to insert the new software into the database as the newest entry
				/*$selectMaxID = "SELECT MAX(softwareID) AS maximumID FROM software";
				$recordID = mysqli_query($db_conn, $selectMaxID) or trigger_error("Failed to check software existence!", E_USER_ERROR);
				$rowID = mysqli_fetch_assoc($recordID);
				$sid = $rowID['maximumID'];
				$softwareID = $sid + 1;
				*/
				
				global $captchaStatus; // Halts execution if user's entry for captcha value is wrong
				include 'ADHD_upload.php'; // File Uploads
                                
                                
				global $fileUploadStatus;
				$fileUploadStatus = $disruptExecution; // disruptExecution = this variable is from the upload.php and if file upload is failed (= 1) then insertion operations underneath will not be executed
				
				//TEMP HACK
				If ($fileUploadStatus == 0 && ($captchaStatus == 0) || $captchaStatus == 1) {
				
					//if new author, insert first author
					IF ($authornum_rows == 0) {
						IF (($authorFirstName != "") || ($authorLastName != "")) {
							//insert authors into author table
						}
					}

					//get data from form to insert to software
					$date = date("Y-m-d");
					
					$description = mysqli_real_escape_string($db_conn, $_POST['description']);
					/*
                                            $notes = mysqli_real_escape_string($db_conn, $_POST['notes']);
                                            $hardwareReq = mysqli_real_escape_string($db_conn, $_POST['hardwareReq']);
                                            $softwareReq = mysqli_real_escape_string($db_conn, $_POST['softwareReq']);
					*/

					IF ($_POST['country'] == "Choose a country...") {
						//$country = "Country was not chosen";
						$country = '';
					}
					ELSE {
						//$country = mysqli_real_escape_string($db_conn, $_POST['country']);
						$country = getCountry();
					}
					
					IF ($_POST['licenceList'] == "Choose a licence...") {
						//$licenceList = "Licence was not chosen";
						$licenceList = '';
					} 
					ELSE {
						//$licenceList = mysqli_real_escape_string($db_conn, $_POST['licenceList']);
						$licenceList = getLicencelist();
					}
					
					$emptyTitle = "";
					if ($_POST['publisher'] != "") {
						
					} 
					else {
						//insert into software table
						
					}

					//Insert into author_software, first author
					//Insert into author_software, second author
					//Insert into author_software, third author
					//Insert into author_software, fourth author
					//Insert into author_software, fifth author
					
					// send an acknowledgement email to the contributor
					INCLUDE 'cgi-bin/mail/maildefinitions.php';
					// send an new entry notification email to the web master
					INCLUDE 'cgi-bin/mail/formmail.php';
					//ECHO "<br><h3>Success!Your information has been added.<br/> Thank you! <a href=\"search.php\">Click here to search another item.</h3></a><br/>";
				}
			}
			else {
				// code changed here to accomodate changed requirements to text in JS alert box.
				//daniel pihllis 17/7/17
				echo "<script>
					/*
					if(confirm(\"A record with the same title already exists. Would you like to add more details ?\")){
						window.location = \"ADHD_modifyEntry.php?id=$softwareID\";
					}
					else {
						window.location = \"ADHD_newEntry.php\";
					}
					*/
					</script>";
					
				/*
				 changes - to grammar - daniel phillis
				link removed : <a href = \"modifyEntry.php?id=$softwareID\">
				note that blank strings for URLs inside a HRef TAG will stop the page form displaying
				*/
				print("<br/><center><span style=\"font-size: 12px; background-color: orange; padding: 5px; border-radius: 0px;\">
					A record with the same title already exists.
					<br>
					<a>Continue with new Entry ?</a><br>
					OR 
					<a>Display Current record(s)?</a><br>
					</span></center>");
			}
		}
	}
?>
		
<?php
	global $insertionStatus, $fileUploadStatus, $captchaStatus, $softwareNumRows;
	if (isset($_POST["Submit"])) {
		/*
		  if($insertionStatus == 0) {
			  Header("Location: success.php");
			  exit;
		  }
		  else {
			  echo "<center><span style=\"display: inline-block; font-size: 13px; color: white; background-color: red; border-radius:5px; padding: 5px; margin: 5px 0px 5px 0px;\">
			  Error with submission! Please try again with your entry details!</span></center>";
		  }
		 */
		 
		 // if no errors existed with the entry e.g software year, contributor name and email plus the file uploads were entered and valid
		if ($insertionStatus == 0 && $fileUploadStatus == 0 && $captchaStatus == 0 
                        #&& $softwareNumRows == 0
                        ) {
			
			echo "<script>
				window.location = \"ADHD_insertionSuccess.php\";
			</script>";
			
			echo '<META HTTP-EQUIV="Refresh" Content="0; URL=ADHD_insertionSuccess.php">';
			
			//echo "<h3 id=\"headerTitleH3\" style=\"text-transform: none;\"> Success! Your information has been added. Thank you! <a href=\"search.php\">Click here if you want to search another item.</h3></a><br/>";
			//echo "<h3 id=\"headerTitleH3\" style=\"text-transform: none;\"> Success! Your information has been added. Thank you! <a href=\"search.php\">Click here if you want to search another item.</h3></a><br/>";
		}
	}
?> 