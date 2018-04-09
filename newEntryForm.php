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

    /*
    function show(elem) {
        elem.style.display = "block";
    }
    */

    function hide(elem) {
        elem.style.display = "";
    }
</script>

<style type="text/css">
    .errormessage {
        color:red;
        float:left;
        text-align: left;
        margin-left: 18px;
        border:0px solid;
    }

    .captchaemail{
        display: none;
    }

    .tooltipContainer {
        display: inline;
    }

    .bigTooltip{
        position:absolute;
        margin:5px;
        padding: 15px;
        width:65%;
        height:auto;
        background-color: #718895;
        color: #FFFFFF;
        border:1px solid black;
        border-radius: 10px;
        display:none;
        text-align:justify;
    }

    .smallTooltip{
        position:absolute;
        margin-bottom:0;
        padding: 15px;
        width:40%;
        height:auto;
        background-color: #718895;
        color: #FFFFFF;
        border:1px solid black;
        border-radius: 10px;
        display:none;
        text-align:left;
    }

    .smallTooltipEmail{
        position:absolute;
        margin-bottom:0;
        padding: 15px;
        width:45%;
        height:auto;
        background-color: #718895;
        color: #FFFFFF;
        border:1px solid black;
        border-radius: 10px;
        display:none;
        text-align:left;
    }
</style>


<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	function checkemail($email) {
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			return true;
		} else {
			return false;
		}
	}
?>         

<?php
	require_once('./conn/AHSD_DB_CONNECTION.php');
	$db_conn = connectDB();
	
	$insertionStatus = 0; // Used to log any errors occurred in the insertion operations to the database and halt execution of the insertion operations in the later conditional statements that used this variable
	$fileUploadStatus = 0; // Used to log any errors occurred in the files upload operation to the database and to the server. It halts any execution given there is an error.
	$captchaStatus = 0; // Used to log any whether a wrong value is entered for captcha. It halts any execution if captcha value was wrong.

	/* Used to check if a software with the same title is already existed in the dataabse. */
	$softwarenum_rows = 0;
?>

<?php
	/* Declare some global variables */
	GLOBAL $HTTP_POST_VARS, $print_again, $error, $savetitle, $title;
	//echo '<br>gloabl vars:'.$GLOBALS.'';
?>

<div style="width:70%; margin: 0 auto;">
	<?php /*
		if (isset($_POST["Submit"])) {
			global $softwarenum_rows;
			echo "=====>" . $softwarenum_rows;
			if ($softwarenum_rows > 0) {
				print("<span style=\"font-size: 11px; color: red;\">A software with the same title is already exist. Would you like to add more details about this software?</span>");
			}
		}
	*/ ?>
				
    <FORM action="newEntry.php" enctype="multipart/form-data" method="POST" class="search">
        
        <!-- label TAG :
        The <label> tag defines a label for an <input> element 
        (of a form) -->

        <!-- TITLE -->
        <label for="title" id="modifyEntryLabels">* Title: 
			<?php
				//if form is submitted
				if(isset($_POST["Submit"])){
					
					if($_POST["title"]=="") {
						print("<span style=\"font-size: 11px; color: red;\">Please enter a title.</span>");
					}
					else if(preg_match("/^\\s/",$_POST["title"])){
						print("<span style=\"font-size: 11px; color: red;\">Cannot start with space.</span>");  
					}
				}
			?>
        </label>
        <INPUT type="text" class="input" name="title" id="title" value="" required/><br/>
	
	<!-- YEAR -->

		<label for="Year" id="modifyEntryLabels"> Year: </label>
        <INPUT type="text" class="input" name="Year" id="Year" size="4" value="" maxlength="4" pattern="\d*" oninvalid="setCustomValidity('Please enter a number.')"
    onchange="try{setCustomValidity('')}catch(e){}"/><br/>
		
		<div class="tooltipContainer" onmouseover="show(tooltip00)" onmouseout="hide(tooltip00)">
			<label for="authGivenFamily" id="modifyEntryLabels"> Number of Authors: <font style="font-size: 11px; color:#DA6200;">(See Note)</font></label>
			<div class = "bigTooltip" id= "tooltip00">
				Select how many author(s) this software has, then enter their name(s).   
			</div>
		</div>

		<!-- SELECT AUTHOR -->

		<SELECT class="sel1" id="authGivenFamily" name="authGivenFamily" onChange="ShowMenu(document.getElementById('authGivenFamily').value, 'divInput', 5);">
			<OPTION value="0">0 </OPTION>
			<OPTION value="1">1 </OPTION>
			<OPTION value="2">2 </OPTION>
			<OPTION value="3">3 </OPTION>
			<OPTION value="4">4 </OPTION>
			<OPTION value="5">5 </OPTION>
		</SELECT><br/>

		<DIV id="divInput1" style="display: none;"> 
			<label for="authorlast" id="modifyEntryLabels"> Author Family Name: </label>
			<INPUT type="text" class="input" name="authorlast" id="authorlast" size="30" value=""/><br/>
			
			<label for="authorfirst" id="modifyEntryLabels"> Author Given Name: </label>
			<INPUT type="text" class="input" name="authorfirst" id="authorfirst" size="30" value=""/><br/>
		</DIV>
		
		<DIV id="divInput2" style="display: none;"> 
			<label for="authorlast1" id="modifyEntryLabels"> Author Family Name: </label>
			<INPUT type="text" class="input" name="authorlast1" id="authorlast1" size="30" value=""/><br/>
			
			<label for="authorfirst1" id="modifyEntryLabels"> Author Given Name: </label>
			<INPUT type="text" class="input" name="authorfirst1" id="authorfirst1" size="30" value=""/><br/>
		</DIV>
		
		<DIV id="divInput3" style="display: none;"> 
			<label for="authorlast2" id="modifyEntryLabels"> Author Family Name: </label>
			<INPUT type="text" class="input" name="authorlast2" id="authorlast2" size="30" value=""/><br/>
			
			<label for="authorfirst2" id="modifyEntryLabels"> Author Given Name: </label>
			<INPUT type="text" class="input" name="authorfirst2" id="authorfirst2" size="30" value=""/><br/>
		</DIV>
		
		<DIV id="divInput4" style="display: none;"> 
			<label for="authorlast3" id="modifyEntryLabels"> Author Family Name: </label>
			<INPUT type="text" class="input" name="authorlast3" id="authorlast3" size="30" value=""/><br/>
			
			<label for="authorfirst3" id="modifyEntryLabels"> Author Given Name: </label>
			<INPUT type="text" class="input" name="authorfirst3" id="authorfirst3" size="30" value=""/><br/>
		</DIV>
		
		<DIV id="divInput5" style="display: none;"> 
			<label for="authorlast4" id="modifyEntryLabels"> Author Family Name: </label>
			<INPUT type="text" class="input" name="authorlast4" id="authorlast4" size="30" value=""/><br/>
			
			<label for="authorfirst4" id="modifyEntryLabels"> Author Given Name: </label>
			<INPUT type="text" class="input" name="authorfirst4" id="authorfirst4" size="30" value=""/><br/>
		</DIV>
		
		<!-- PUBLISHER -->

        <label for="publisher" id="modifyEntryLabels"> Publisher: </label>
        <INPUT type="text" class="input" name="publisher" id="publisher" size="30" value=""/><br/>
		<label for="publisher" id="modifyEntryLabels"> Country: </label>
        
        <!-- SELECT COUNTRY -->

        <SELECT class="sel1" name="country">
            <OPTION>Choose a country... </OPTION>
            <OPTION value="Australia">Australia</OPTION>
            <OPTION value="New Zealand">New Zealand</OPTION>
            <OPTION value="Others">Others</OPTION>
        </SELECT><br/>

		<!-- HARDWARE REQs -->

        <label for="hardwareReq" id="modifyEntryLabels"> Hardware Requirements: </label>
        <TEXTAREA class="textarea" name="hardwareReq" id="hardwareReq" rows="1"></TEXTAREA><br/>

		<!-- SOFTWARE REQs -->

		<label for="softwareReq" id="modifyEntryLabels"> Software Requirements: </label> 
		<TEXTAREA class="textarea" name="softwareReq" id="softwareReq" rows="1"></TEXTAREA><br/>
		<label for="description" id="modifyEntryLabels"> Description: </label>
		<TEXTAREA class="textarea" name="description" id="description" rows="1"></TEXTAREA><br/>

		<!-- TOOLTIPS -->
		<div class="tooltipContainer" onmouseover="show(tooltip1)" onmouseout="hide(tooltip1)">
			<label id="modifyEntryLabels" for="notes"> Notes: <font style="font-size: 11px; color:#DA6200;">(See Note)</font></label>
			<div class = "bigTooltip" id= "tooltip1">
				Include information here that doesn't fit elsewhere.  For example: working copy status, collection title is housed in, the chip for obscure systems, version numbers, 
				if you are the author, copyright owner (if known), programming language, emulation availability, credits for photos, information on manuals, etc.
			</div>
		</div>

		<!-- BIG TOOLTIP FOR NUMBER OF FILES -->

		<TEXTAREA class="textarea" name="notes" rows="7"></TEXTAREA><br/>
		<div class="tooltipContainer" onmouseover="show(tooltip0)" onmouseout="hide(tooltip0)">
			<label for="filesnum" id="modifyEntryLabels"> Number of Files: <font style="font-size: 11px; color:#DA6200;">(See Note)</font></label>
			<div class = "bigTooltip" id= "tooltip0">
				We only accept images (ending ".jpg",".gif",".png"), plain text (.txt) and pdf files. The files should be less than 2MB.   
			</div>
		</div>
		<SELECT class="sel1" id="num" name="filesnum" onChange="ShowMenu(document.getElementById('num').value, 'divFile', 9);">
			<OPTION value="0">0 </OPTION>
			<OPTION value="1">1 </OPTION>
			<OPTION value="2">2 </OPTION>
			<OPTION value="3">3 </OPTION>
			<OPTION value="4">4 </OPTION>
			<OPTION value="5">5 </OPTION>
			<OPTION value="6">6 </OPTION>
			<OPTION value="7">7 </OPTION>
			<OPTION value="8">8 </OPTION>
			<OPTION value="9">9 </OPTION>
		</SELECT><br/>

		<DIV id="divFile1" style="display: none;"> 
			<label for="uploadedFile0" id="modifyEntryLabels">Upload File</label>
			<input type="file" name="uploadedFile0" class="file"/>
		</DIV>

		<DIV id="divFile2"  style="display: none;"> 
			<label for="uploadedFile1" id="modifyEntryLabels">Upload File</label>
			<input type="file" name="uploadedFile1" class="file"/>
		</DIV>

		<DIV id="divFile3"  style="display: none;"> 
			<label for="uploadedFile2" id="modifyEntryLabels">Upload File</label>
			<input type="file" name="uploadedFile2" class="file"/>
		</DIV>

		<DIV id="divFile4" style="display: none;">
			<label for="uploadedFile3" id="modifyEntryLabels">Upload File</label>
			<input type="file" name="uploadedFile3" class="file"/>
		</DIV>

		<DIV id="divFile5"  style="display: none;">
			<label for="uploadedFile4" id="modifyEntryLabels">Upload File</label>
			<input type="file" name="uploadedFile4" class="file"/>
		</DIV>

		<DIV id="divFile6"  style="display: none;">
			<label for="uploadedFile5" id="modifyEntryLabels">Upload File</label>
			<input type="file" name="uploadedFile5" class="file"/>
		</DIV>

		<DIV id="divFile7" style="display: none;"> 
			<label for="uploadedFile6" id="modifyEntryLabels">Upload File</label>
			<input type="file" name="uploadedFile6" class="file"/>
		</DIV>

		<DIV id="divFile8"  style="display: none;">
			<label for="uploadedFile7" id="modifyEntryLabels">Upload File</label>
			<input type="file" name="uploadedFile7" class="file"/>
		</DIV>

		<DIV id="divFile9"  style="display: none;">
			<label for="uploadedFile8" id="modifyEntryLabels">Upload File</label>
			<input type="file" name="uploadedFile8" class="file"/>
		</DIV>

		<!-- CHOOSE A LICENCE -->
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
		<div class="tooltipContainer" onmouseover="show(tooltip2)" onmouseout="hide(tooltip2)">
			<label for="contributorlast" id="modifyEntryLabels"> * Your Family Name: 
			<font style="font-size: 11px; color:#DA6200;">(See Note)</font>
	
			<?php
				/* CHECK FAMILY NAME IS FILLED OUT (MANDATORY FIELD) */
				IF (ISSET($_POST["Submit"])) {
					IF ($_POST["contributorFamily"] == "") {
						global $insertionStatus;
						$insertionStatus = 1;
						PRINT("<span style=\"font-size: 11px; color: red;\">Please enter your family name.</span>");
					}
				}
			?>
			</label>
			<div class = "smallTooltip" id= "tooltip2">
				Your name will be kept confidential.
			</div>
		</div>
		
		<!-- CONTRIBUTOR LAST NAME -->

		<input type="text" class="input" name="contributorlast" size="30" value="" required//><br/>

		<div class="tooltipContainer" onmouseover="show(tooltip3)" onmouseout="hide(tooltip3)">
			
			<!-- CONTRIBUTOR FIRST NAME -->

			<label for="contributorfirst" id="modifyEntryLabels">Your Given Name: 
			<font style="font-size: 11px; color:#DA6200;">(See Note)</font></label>
			<div class = "smallTooltip" id= "tooltip3">
				Your name will be kept confidential.
			</div>
		</div>

		<!-- CONTRIBUTOR FIRST NAME INPUT-->
		
		<input type="text" class="input" name="contributorfirst" size="30" value=""/><br/>

		<div class="tooltipContainer" onmouseover="show(tooltip4)" onmouseout="hide(tooltip4)">
			<label for="altAddress" id="modifyEntryLabels"> * Your email address: <font style="font-size: 11px; color:#DA6200;">(See Note)</font>
				<?php
					/*
						CHECK for EMAIL ADDRESS - A MANDATORY FIELD
					*/
					if (isset($_POST["Submit"])) {
						if ($_POST["altAddress"] == "") {
							global $insertionStatus;
							$insertionStatus = 1;
							//ERROR MESSAGE
							print("<span style=\"font-size: 11px; color: red;\">Please enter your email address.</span>");
						} else {
							if (!checkemail($_POST["altAddress"])) {
								global $insertionStatus;
								$insertionStatus = 1;
								//ERROR MESSAGE
								print("<span style=\"font-size: 11px; color: red;\">Invalid email address.</span>");
							}
						}
					}
				?>
			</label>
			<div class = "smallTooltipEmail" id= "tooltip4">
				Your email address will not be disclosed.
			</div>
		</div>

		<!-- EMAIL -->
		
		<input type="email" class="input" name="altAddress" size="30" value="" required/><br/>
		<input type="text" class="captchaemail" name="email" size="30" value=""/>
        <?php
        	/* IF EMAIL IS BLANK - DO NOTHING ? this must be checked somewhere else */
			if (isset($_POST["Submit"])) {

				/*
				REDUNDANT CODE ?
				if ($_POST["email"] == "") {
					
				} 
				else {
					if (!checkemail($_POST["email"])) {
						
					}
				}
			*/
			}
        ?>

        <!-- ENTER VERIFICATION CODE -->

		<label for="verif_code" id="modifyEntryLabels"> * Enter Verification Code: </label>
		<input type="text" id="verif_code" class="securityInput" name="verif_code" style="margin-bottom: 3px;" maxlength="5" required/>
		<?php 
			if (isset($_POST["Submit"])) {
				$verif_code = $_POST["verif_code"];
				echo 'verif_code:'.$verif_code;

				/*if the code matches the image
				md5 is obsolete ? */

				if(md5($verif_code).'8cq3' == $_COOKIE['imgcap']){
					global $captchaStatus;
					unset($_COOKIE['imgcap']);					
					$captchaStatus = 0;
				}
				else {
					/*CODE doesnt match the image,
					then later test for the state of the $captureSatatus var
					or use it as a multiplier
					*/ 
					global $captchaStatus;		
					$captchaStatus = 1;
				}
			}
		?>
		
		<!-- Display the error field - why is this in a separate block of code ? -->
		<?php 
			global $captchaStatus;
			if($captchaStatus == 1){
		?>
		
		<label id="modifyEntryLabels"> </label>
		<span style="margin-bottom:10px; color:red; padding:3px; width: 209px; height: 29px;">Wrong Verification Code!</span>
		<?php ;}?>
		
		<label id="modifyEntryLabels"> </label>
		<img src="captcha_content.php?<?php echo rand(0,9999);?>" alt="verification image, type it in the field above." width="215px" height="29" align="absbottom" style="margin-top: 5px; border-color:#64a3ba; border:1px dashed #64a3ba; border-radius: 10px;" /><br/>
		
		<br/><br/>
		
		<label id="modifyEntryLabels"> </label>
		<div style="display: inline-block;">
			<INPUT type="submit" id="searchButton" name="Submit" value="SUBMIT" />
			<INPUT type="reset" id="resetButton" class="button" value="RESET" />  
		</div>		
	 
	</FORM>
  </div>
<?php
	if (isset($_POST["Submit"])) {
		//check for email field is not empty (bot)
		$error['email'] = false;
		if (!$_POST["email"] == "") {
			$error['email'] = true;
			echo '<script type="text/javascript" language="javascript">
				window.open("http://www.ourdigitalheritage.org","_self");
				 </script>';
		} 
		else {
			check_form();
		}
	}

        #function check form moved to validation.php
	FUNCTION check_form() {
		GLOBAL $HTTP_POST_VARS, $error, $print_again, $savetitle;
		GLOBAL $db_conn, $softwareID, $insertionStatus;

		array_walk($_POST, create_function('&$val', '$val = trim($val);'));
		//error if "Your Family Name" is empty
		IF ($_POST["contributorFamily"] == "") {
			$error['contributorFamily'] = TRUE;
			$print_again = TRUE;
		}
		//error if email is empty
		IF ($_POST["altAddress"] == "") {
			$error['emailAddress'] = TRUE;
			$print_again = TRUE;
		}
		//error if email address is not correct
		IF (!checkemail($_POST["altAddress"])) {
			$error["emailAddress"] = TRUE;
			$print_again = TRUE;
		}
		//error if year is not numeric
		IF (!is_numeric($_POST["Year"]) && $_POST["Year"] != "") {
			$error['Year'] = TRUE;
			$print_again = TRUE;
		}

		IF ($print_again) {
			/* foreach($_POST as $key =>$value){
			  // do something using key and value
			  print $key; print " "; print $value; print "<br>";
			  } */

			//ECHO '<center><b><font color="red">Error: You have not completed all the required information!</font></b></center><br>';
		}
		
		ELSE {
			$title = mysqli_real_escape_string($db_conn, $_POST['title']);
			$year = mysqli_real_escape_string($db_conn, $_POST['Year']);
			$authorFirstName = mysqli_real_escape_string($db_conn, $_POST["authorfirst"]);
			$authorLastName = mysqli_real_escape_string($db_conn, $_POST['authorlast']);
			$authorFirstName_1 = mysqli_real_escape_string($db_conn, $_POST["authorfirst1"]);
			$authorLastName_1 = mysqli_real_escape_string($db_conn, $_POST['authorlast1']);
			$authorFirstName_2 = mysqli_real_escape_string($db_conn, $_POST["authorfirst2"]);
			$authorLastName_2 = mysqli_real_escape_string($db_conn, $_POST['authorlast2']);
			$authorFirstName_3 = mysqli_real_escape_string($db_conn, $_POST["authorfirst3"]);
			$authorLastName_3 = mysqli_real_escape_string($db_conn, $_POST['authorlast3']);
			$authorFirstName_4 = mysqli_real_escape_string($db_conn, $_POST["authorfirst4"]);
			$authorLastName_4 = mysqli_real_escape_string($db_conn, $_POST['authorlast4']);
			$publisher = mysqli_real_escape_string($db_conn, $_POST['publisher']);
			$country = mysqli_real_escape_string($db_conn, $_POST['country']);
			$hardwareReq = mysqli_real_escape_string($db_conn, $_POST['hardwareReq']);
			$softwareReq = mysqli_real_escape_string($db_conn, $_POST['softwareReq']);
			$description = mysqli_real_escape_string($db_conn, $_POST['description']);
			$notes = mysqli_real_escape_string($db_conn, $_POST['notes']);
			$contributorFamily = mysqli_real_escape_string($db_conn, $_POST['contributorFamily']);
			$contributorGiven = mysqli_real_escape_string($db_conn, $_POST['contributorGiven']);
			$altAddress = mysqli_real_escape_string($db_conn, $_POST["altAddress"]);
			$filesnum = mysqli_real_escape_string($db_conn, $_POST["filesnum"]);
			static $seqnum = 1;

			
			// check if software had been inserted before
			$varTitleCheck = ("SELECT softwareID FROM software WHERE title = ?");

			//Prepare the query
			$stmt1 = $db_conn->prepare($varTitleCheck) or trigger_error("1st Error! Unable to check software title!", E_USER_ERROR);

			//Can not proceed if we can not prepare the query
			if (false === $stmt1) {
				trigger_error("2nd Error! Unable to check software title!", E_USER_ERROR);
			}
			//Bind the fields and their parameters to our query in our testing variable $next_step
			$stmt1->bind_param('s', $title);
			
			//If $stmt1 is false then it didn't work and there is no sense of proceeding
			if (false === $stmt1) {
				trigger_error('3rd Error! Unable to check software title!', E_USER_ERROR);
			}

			//Place the Execute into a variable and test if it executed or not
			$stmt1->execute();

			//If $stmt1 is false then it didn't work and there is no sense of proceeding 
			if (false === $stmt1) {
				trigger_error("4th Error! Unable to check software title!", E_USER_ERROR);
			}

			//Bind the results
			$stmt1->bind_result($softwareID);

			//If $stmt1 is false then it didn't work and there is no sense of proceeding 
			if (false === $stmt1) {
				trigger_error("5th Error! Unable to check software title!", E_USER_ERROR);
			}
			$stmt1->store_result();
			$stmt1->fetch();
			$softwareIDTemp = $softwareID;

			global $softwarenum_rows;
			$softwarenum_rows = $stmt1->num_rows;
			
			$softwarenumTemp_rows = $softwarenum_rows;
			
			
			// IF TITLE IS UNIQUE - executes database operations below
			if ($softwarenum_rows == 0) {
				
				// author 1
				$varDisplayAuthor = ("SELECT authorID FROM author WHERE givenName = ? AND familyName = ?");

				//Prepare the query
				$stmt2 = $db_conn->prepare($varDisplayAuthor) or trigger_error("1st Error! Unable to fetch author name!", E_USER_ERROR);

				//Can not proceed if we can not prepare the query
				if (false === $stmt2) {
					trigger_error("2nd Error! Unable to fetch author name!", E_USER_ERROR);
				}
				//Bind the fields and their parameters to our query in our testing variable $next_step
				$stmt2->bind_param('ss', $authorFirstName, $authorLastName);

				//If $stmt2 is false then it didn't work and there is no sense of proceeding
				if (false === $stmt2) {
					trigger_error('3rd Error! Unable to fetch author name!', E_USER_ERROR);
				}

				//Place the Execute into a variable and test if it executed or not
				$stmt2->execute();

				//If $stmt2 is false then it didn't work and there is no sense of proceeding 
				if (false === $stmt2) {
					trigger_error("4th Error! Unable to fetch author name!", E_USER_ERROR);
				}

				//Bind the results
				$stmt2->bind_result($authorID);

				//If $stmt2 is false then it didn't work and there is no sense of proceeding 
				if (false === $stmt2) {
					trigger_error("5th Error! Unable to fetch author name!", E_USER_ERROR);
				}
				$stmt2->store_result();
				$stmt2->fetch();
				$authorIDTemp = $authorID;
				$authornum_rows = $stmt2->num_rows;
				
				
				// author 2
				$varDisplayAuthor_1 = ("SELECT authorID FROM author WHERE givenName = ? AND familyName = ?");

				//Prepare the query
				$stmt2_1 = $db_conn->prepare($varDisplayAuthor_1) or trigger_error("1st Error! Unable to fetch author name!", E_USER_ERROR);

				//Can not proceed if we can not prepare the query
				if (false === $stmt2_1) {
					trigger_error("2nd Error! Unable to fetch author name!", E_USER_ERROR);
				}
				//Bind the fields and their parameters to our query in our testing variable $next_step
				$stmt2_1->bind_param('ss', $authorFirstName_1, $authorLastName_1);

				//If $stmt2_1 is false then it didn't work and there is no sense of proceeding
				if (false === $stmt2_1) {
					trigger_error('3rd Error! Unable to fetch author name!', E_USER_ERROR);
				}

				//Place the Execute into a variable and test if it executed or not
				$stmt2_1->execute();

				//If $stmt2_1 is false then it didn't work and there is no sense of proceeding 
				if (false === $stmt2_1) {
					trigger_error("4th Error! Unable to fetch author name!", E_USER_ERROR);
				}

				//Bind the results
				$stmt2_1->bind_result($authorID);

				//If $stmt2_1 is false then it didn't work and there is no sense of proceeding 
				if (false === $stmt2_1) {
					trigger_error("5th Error! Unable to fetch author name!", E_USER_ERROR);
				}
				$stmt2_1->store_result();
				$stmt2_1->fetch();
				$authorIDTemp_1 = $authorID;
				$authornum_rows_1 = $stmt2_1->num_rows;
				
				
				// author 3
				$varDisplayAuthor_2 = ("SELECT authorID FROM author WHERE givenName = ? AND familyName = ?");

				//Prepare the query
				$stmt2_2 = $db_conn->prepare($varDisplayAuthor_2) or trigger_error("1st Error! Unable to fetch author name!", E_USER_ERROR);

				//Can not proceed if we can not prepare the query
				if (false === $stmt2_2) {
					trigger_error("2nd Error! Unable to fetch author name!", E_USER_ERROR);
				}
				//Bind the fields and their parameters to our query in our testing variable $next_step
				$stmt2_2->bind_param('ss', $authorFirstName_2, $authorLastName_2);

				//If $stmt2_2 is false then it didn't work and there is no sense of proceeding
				if (false === $stmt2_2) {
					trigger_error('3rd Error! Unable to fetch author name!', E_USER_ERROR);
				}

				//Place the Execute into a variable and test if it executed or not
				$stmt2_2->execute();

				//If $stmt2_2 is false then it didn't work and there is no sense of proceeding 
				if (false === $stmt2_2) {
					trigger_error("4th Error! Unable to fetch author name!", E_USER_ERROR);
				}

				//Bind the results
				$stmt2_2->bind_result($authorID);

				//If $stmt2_2 is false then it didn't work and there is no sense of proceeding 
				if (false === $stmt2_2) {
					trigger_error("5th Error! Unable to fetch author name!", E_USER_ERROR);
				}
				$stmt2_2->store_result();
				$stmt2_2->fetch();
				$authorIDTemp_2 = $authorID;				
				$authornum_rows_2 = $stmt2_2->num_rows;
				

				// author 4
				$varDisplayAuthor_3 = ("SELECT authorID FROM author WHERE givenName = ? AND familyName = ?");

				//Prepare the query
				$stmt2_3 = $db_conn->prepare($varDisplayAuthor_3) or trigger_error("1st Error! Unable to fetch author name!", E_USER_ERROR);

				//Can not proceed if we can not prepare the query
				if (false === $stmt2_3) {
					trigger_error("2nd Error! Unable to fetch author name!", E_USER_ERROR);
				}
				//Bind the fields and their parameters to our query in our testing variable $next_step
				$stmt2_3->bind_param('ss', $authorFirstName_3, $authorLastName_3);

				//If $stmt2_3 is false then it didn't work and there is no sense of proceeding
				if (false === $stmt2_3) {
					trigger_error('3rd Error! Unable to fetch author name!', E_USER_ERROR);
				}

				//Place the Execute into a variable and test if it executed or not
				$stmt2_3->execute();

				//If $stmt2_3 is false then it didn't work and there is no sense of proceeding 
				if (false === $stmt2_3) {
					trigger_error("4th Error! Unable to fetch author name!", E_USER_ERROR);
				}

				//Bind the results
				$stmt2_3->bind_result($authorID);

				//If $stmt2_3 is false then it didn't work and there is no sense of proceeding 
				if (false === $stmt2_3) {
					trigger_error("5th Error! Unable to fetch author name!", E_USER_ERROR);
				}
				$stmt2_3->store_result();
				$stmt2_3->fetch();
				$authorIDTemp_3 = $authorID;
				$authornum_rows_3 = $stmt2_3->num_rows;				
				
				
				// author 5
				$varDisplayAuthor_4 = ("SELECT authorID FROM author WHERE givenName = ? AND familyName = ?");

				//Prepare the query
				$stmt2_4 = $db_conn->prepare($varDisplayAuthor_4) or trigger_error("1st Error! Unable to fetch author name!", E_USER_ERROR);

				//Can not proceed if we can not prepare the query
				if (false === $stmt2_4) {
					trigger_error("2nd Error! Unable to fetch author name!", E_USER_ERROR);
				}
				//Bind the fields and their parameters to our query in our testing variable $next_step
				$stmt2_4->bind_param('ss', $authorFirstName_4, $authorLastName_4);

				//If $stmt2_4 is false then it didn't work and there is no sense of proceeding
				if (false === $stmt2_4) {
					trigger_error('3rd Error! Unable to fetch author name!', E_USER_ERROR);
				}

				//Place the Execute into a variable and test if it executed or not
				$stmt2_4->execute();

				//If $stmt2_4 is false then it didn't work and there is no sense of proceeding 
				if (false === $stmt2_4) {
					trigger_error("4th Error! Unable to fetch author name!", E_USER_ERROR);
				}

				//Bind the results
				$stmt2_4->bind_result($authorID);

				//If $stmt2_4 is false then it didn't work and there is no sense of proceeding 
				if (false === $stmt2_4) {
					trigger_error("5th Error! Unable to fetch author name!", E_USER_ERROR);
				}
				$stmt2_4->store_result();
				$stmt2_4->fetch();
				$authorIDTemp_4 = $authorID;
				$authornum_rows_4 = $stmt2_4->num_rows;
				

				// contributor
				$varDisplayContributor = ("SELECT contributorID FROM contributor WHERE emailAddress = ?");

				//Prepare the query
				$stmt3 = $db_conn->prepare($varDisplayContributor) or trigger_error("1st Error! Unable to fetch contributor!", E_USER_ERROR);

				//Can not proceed if we can not prepare the query
				if (false === $stmt3) {
					trigger_error("2nd Error! Unable to fetch contributor!", E_USER_ERROR);
				}
				//Bind the fields and their parameters to our query in our testing variable $next_step
				$stmt3->bind_param('s', $altAddress);

				//If $stmt3 is false then it didn't work and there is no sense of proceeding
				if (false === $stmt3) {
					trigger_error('3rd Error! Unable to fetch contributor!', E_USER_ERROR);
				}

				//Place the Execute into a variable and test if it executed or not
				$stmt3->execute();

				//If $stmt3 is false then it didn't work and there is no sense of proceeding 
				if (false === $stmt3) {
					trigger_error("4th Error! Unable to fetch contributor!", E_USER_ERROR);
				}

				//Bind the results
				$stmt3->bind_result($contributorID);

				//If $stmt3 is false then it didn't work and there is no sense of proceeding 
				if (false === $stmt3) {
					trigger_error("5th Error! Unable to fetch contributor!", E_USER_ERROR);
				}
				$stmt3->store_result();
				$stmt3->fetch();
				$contributorIDTemp = $contributorID;
				$contributornum_rows = $stmt3->num_rows;

				
				// publisher
				$varDisplayPublisher = ("SELECT publisherID FROM publisher WHERE publisherName = ?");

				//Prepare the query
				$stmt4 = $db_conn->prepare($varDisplayPublisher) or trigger_error("1st Error! Unable to fetch publisher name!", E_USER_ERROR);

				//Can not proceed if we can not prepare the query
				if (false === $stmt4) {
					trigger_error("2nd Error! Unable to fetch publisher name!", E_USER_ERROR);
				}
				//Bind the fields and their parameters to our query in our testing variable $next_step
				$stmt4->bind_param('s', $publisher);

				//If $stmt4 is false then it didn't work and there is no sense of proceeding
				if (false === $stmt4) {
					trigger_error('3rd Error! Unable to fetch publisher name!', E_USER_ERROR);
				}

				//Place the Execute into a variable and test if it executed or not
				$stmt4->execute();

				//If $stmt4 is false then it didn't work and there is no sense of proceeding 
				if (false === $stmt4) {
					trigger_error("4th Error! Unable to fetch publisher name!", E_USER_ERROR);
				}

				//Bind the results
				$stmt4->bind_result($publisherID);

				//If $stmt4 is false then it didn't work and there is no sense of proceeding 
				if (false === $stmt4) {
					trigger_error("5th Error! Unable to fetch publisher name!", E_USER_ERROR);
				}
				$stmt4->store_result();
				$stmt4->fetch();
				$publisherIDTemp = $publisherID;
				$publishernum_rows = $stmt4->num_rows;
    
	
				// Get the ID of last software entry and add 1 to it to insert the new software into the database as the newest entry
				$selectMaxID = "SELECT MAX(softwareID) AS maximumID FROM software";
				$recordID = mysqli_query($db_conn, $selectMaxID) or trigger_error("Failed to check software existence!", E_USER_ERROR);
				$rowID = mysqli_fetch_assoc($recordID);
				$sid = $rowID['maximumID'];
				$softwareID = $sid + 1;
	
				
				global $captchaStatus; // Halts execution if user's entry for captcha value is wrong
				INCLUDE 'upload.php'; // File Uploads
				global $fileUploadStatus;
				$fileUploadStatus = $disruptExecution; // disruptExecution = this variable is from the upload.php and if file upload is failed (= 1) then insertion operations underneath will not be executed
				
				If ($fileUploadStatus == 0 && $captchaStatus == 0) {
				
					//if new author, insert first author
					IF ($authornum_rows == 0) {
						IF (($authorFirstName != "") || ($authorLastName != "")) {
							//insert into author table

							$insertAuthor = ("INSERT INTO author (givenName,familyName) VALUES (?, ?)");

							//Prepare the query
							$stmt5 = $db_conn->prepare($insertAuthor) or trigger_error("1st Error! Failed to insert author!", E_USER_ERROR);

							//Can not proceed if we can not prepare the query
							if (false === $stmt5) {
								trigger_error("2nd Error! Failed to insert author!", E_USER_ERROR);
							}
							//Bind the fields and their parameters to our query in our testing variable $next_step
							$stmt5->bind_param('ss', $authorFirstName, $authorLastName);

							//If $stmt5 is false then it didn't work and there is no sense of proceeding
							if (false === $stmt5) {
								trigger_error('3rd Error! Failed to insert author!', E_USER_ERROR);
							}

							//Place the Execute into a variable and test if it executed or not
							$stmt5->execute();

							$authoridInsert = mysqli_insert_id($db_conn);
						}
					}
					ELSE {
						$authoridInsert = $authorIDTemp;
					}
					
					
					//if new author, insert second author
					IF ($authornum_rows_1 == 0) {
						IF (($authorFirstName_1 != "") || ($authorLastName_1 != "")) {
							//insert into author table

							$insertAuthor_1 = ("INSERT INTO author (givenName,familyName) VALUES (?, ?)");

							//Prepare the query
							$stmt5_1 = $db_conn->prepare($insertAuthor_1) or trigger_error("1st Error! Failed to insert second author!", E_USER_ERROR);

							//Can not proceed if we can not prepare the query
							if (false === $stmt5_1) {
								trigger_error("2nd Error! Failed to insert second author!", E_USER_ERROR);
							}
							//Bind the fields and their parameters to our query in our testing variable $next_step
							$stmt5_1->bind_param('ss', $authorFirstName_1, $authorLastName_1);

							//If $stmt5_1 is false then it didn't work and there is no sense of proceeding
							if (false === $stmt5_1) {
								trigger_error('3rd Error! Failed to insert second author!', E_USER_ERROR);
							}

							//Place the Execute into a variable and test if it executed or not
							$stmt5_1->execute();

							$authoridInsert_1 = mysqli_insert_id($db_conn);
						}
					}
					ELSE {
						$authoridInsert_1 = $authorIDTemp_1;
					}
					
					
					//if new author, insert third author
					IF ($authornum_rows_2 == 0) {
						IF (($authorFirstName_2 != "") || ($authorLastName_2 != "")) {
							//insert into author table

							$insertAuthor_2 = ("INSERT INTO author (givenName,familyName) VALUES (?, ?)");

							//Prepare the query
							$stmt5_2 = $db_conn->prepare($insertAuthor_2) or trigger_error("1st Error! Failed to insert third author!", E_USER_ERROR);

							//Can not proceed if we can not prepare the query
							if (false === $stmt5_2) {
								trigger_error("2nd Error! Failed to insert third author!", E_USER_ERROR);
							}
							//Bind the fields and their parameters to our query in our testing variable $next_step
							$stmt5_2->bind_param('ss', $authorFirstName_2, $authorLastName_2);

							//If $stmt5_2 is false then it didn't work and there is no sense of proceeding
							if (false === $stmt5_2) {
								trigger_error('3rd Error! Failed to insert third author!', E_USER_ERROR);
							}

							//Place the Execute into a variable and test if it executed or not
							$stmt5_2->execute();

							$authoridInsert_2 = mysqli_insert_id($db_conn);
						}
					}
					ELSE {
						$authoridInsert_2 = $authorIDTemp_2;
					}
						
						
					//if new author, insert fourth author
					IF ($authornum_rows_3 == 0) {
						IF (($authorFirstName_3 != "") || ($authorLastName_3 != "")) {
							//insert into author table

							$insertAuthor_3 = ("INSERT INTO author (givenName,familyName) VALUES (?, ?)");

							//Prepare the query
							$stmt5_3 = $db_conn->prepare($insertAuthor_3) or trigger_error("1st Error! Failed to insert fourth author!", E_USER_ERROR);

							//Can not proceed if we can not prepare the query
							if (false === $stmt5_3) {
								trigger_error("2nd Error! Failed to insert fourth author!", E_USER_ERROR);
							}
							//Bind the fields and their parameters to our query in our testing variable $next_step
							$stmt5_3->bind_param('ss', $authorFirstName_3, $authorLastName_3);

							//If $stmt5_3 is false then it didn't work and there is no sense of proceeding
							if (false === $stmt5_3) {
								trigger_error('3rd Error! Failed to insert fourth author!', E_USER_ERROR);
							}

							//Place the Execute into a variable and test if it executed or not
							$stmt5_3->execute();

							$authoridInsert_3 = mysqli_insert_id($db_conn);
						}
					}
					ELSE {
						$authoridInsert_3 = $authorIDTemp_3;
					}						
						
						
					//if new author, insert fifth author
					IF ($authornum_rows_4 == 0) {
						IF (($authorFirstName_4 != "") || ($authorLastName_4 != "")) {
							//insert into author table

							$insertAuthor_4 = ("INSERT INTO author (givenName,familyName) VALUES (?, ?)");

							//Prepare the query
							$stmt5_4 = $db_conn->prepare($insertAuthor_4) or trigger_error("1st Error! Failed to insert fourth author!", E_USER_ERROR);

							//Can not proceed if we can not prepare the query
							if (false === $stmt5_4) {
								trigger_error("2nd Error! Failed to insert fourth author!", E_USER_ERROR);
							}
							//Bind the fields and their parameters to our query in our testing variable $next_step
							$stmt5_4->bind_param('ss', $authorFirstName_4, $authorLastName_4);

							//If $stmt5_4 is false then it didn't work and there is no sense of proceeding
							if (false === $stmt5_4) {
								trigger_error('3rd Error! Failed to insert fourth author!', E_USER_ERROR);
							}

							//Place the Execute into a variable and test if it executed or not
							$stmt5_4->execute();

							$authoridInsert_4 = mysqli_insert_id($db_conn);
						}
					}
					ELSE {
						$authoridInsert_4 = $authorIDTemp_4;
					}
					

					//if new contributer
					IF ($contributornum_rows == 0) {
						IF ($contributorFamily != "") {
							//insert into contributor table			
							$insertContributor = "INSERT INTO contributor (givenName, familyName, emailAddress) VALUES (?, ?, ?)";

							//Prepare the query
							$stmt6 = $db_conn->prepare($insertContributor) or trigger_error("1st Error! Failed to insert contributor", E_USER_ERROR);

							//Can not proceed if we can not prepare the query
							if (false === $stmt6) {
								trigger_error("2nd Error! Failed to insert contributor", E_USER_ERROR);
							}
							//Bind the fields and their parameters to our query in our testing variable $next_step
							$stmt6->bind_param('sss', $contributorGiven, $contributorFamily, $altAddress);

							//If $stmt6 is false then it didn't work and there is no sense of proceeding
							if (false === $stmt6) {
								trigger_error('3rd Error! Failed to insert contributor!', E_USER_ERROR);
							}

							//Place the Execute into a variable and test if it executed or not
							$stmt6->execute();
							$contributoridInsert = mysqli_insert_id($db_conn);
						}
					}
					ELSE { //if contributor already exists
						$contributoridInsert = $contributorIDTemp;
					}

					//if new publisher
					IF ($publishernum_rows == 0) {
						IF ($publisher != "") {

							//insert into publisher table
							$insertPublisher = "INSERT INTO publisher (publisherName) VALUES (?)";

							//Prepare the query
							$stmt7 = $db_conn->prepare($insertPublisher) or trigger_error("1st Error! Failed to insert publisher!", E_USER_ERROR);

							//Can not proceed if we can not prepare the query
							if (false === $stmt7) {
								trigger_error("2nd Error! Failed to insert publisher!", E_USER_ERROR);
							}
							//Bind the fields and their parameters to our query in our testing variable $next_step
							$stmt7->bind_param('s', $publisher);

							//If $stmt7 is false then it didn't work and there is no sense of proceeding
							if (false === $stmt7) {
								trigger_error('3rd Error! Failed to insert publisher!', E_USER_ERROR);
							}

							//Place the Execute into a variable and test if it executed or not
							$stmt7->execute();
							$publisheridInsert = mysqli_insert_id($db_conn);
						}
					} 
					ELSE { //if publisher already exists
						$publisheridInsert = $publisherIDTemp;
					}

					//get data from form to insert to software
					$date = date("Y-m-d");
					$description = mysqli_real_escape_string($db_conn, $_POST['description']);
					$notes = mysqli_real_escape_string($db_conn, $_POST['notes']);
					$hardwareReq = mysqli_real_escape_string($db_conn, $_POST['hardwareReq']);
					$softwareReq = mysqli_real_escape_string($db_conn, $_POST['softwareReq']);
					
					IF ($_POST['country'] == "Choose a country...") {
						$country = "Country was not chosen";
					}
					ELSE {
						$country = mysqli_real_escape_string($db_conn, $_POST['country']);
					}
					
					IF ($_POST['licenceList'] == "Choose a licence...") {
						$licencelist = "Licence was not chosen";
					} 
					ELSE {
						$licencelist = mysqli_real_escape_string($db_conn, $_POST['licenceList']);
					}
					
					$emptyTitle = "";
					if ($_POST['publisher'] != "") {
						/*
						  $stmt2->close();
						  $stmt3->close();
						  $stmt4->close();
						  $stmt5->close();
						  $stmt6->close();
						  $stmt7->close();
						  $stmt8->close(); */

						//insert into software table
						$inserIntoPublisher_1 = "INSERT INTO software (softwareID, sequenceNum, title, year, description, notes, hardwareReq, softwareReq, licenceList, numberOfFiles, insertedDate, publisherID, contributorID, country)
						VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

						//INSERT INTO software (softwareID, sequenceNum, year, description, notes, hardwareReq, softwareReq, licenceList, numberOfFiles, insertedDate, contributorID, country)
						//VALUES (637, 7, 1996, 'NONE', 'NIL', 'INTEL', 'UNIX', 'NONE', 0, '2015-07-17', 5, 'Australia');
						//Prepare the query
						$stmt9 = $db_conn->prepare($inserIntoPublisher_1) or trigger_error("1st Error! Failed to insert software!", E_USER_ERROR);

						//Can not proceed if we can not prepare the query
						if (false === $stmt9) {
							trigger_error("2nd Error! Failed to insert software!", E_USER_ERROR);
						}

						//Bind the fields and their parameters to our query in our testing variable $next_step
						$stmt9->bind_param('iisisssssisiis', $softwareID, $seqnum, $title, $year, $description, $notes, $hardwareReq, $softwareReq, $licencelist, $filesnum, $date, $publisheridInsert, $contributoridInsert, $country);

						//If $stmt9 is false then it didn't work and there is no sense of proceeding
						if (false === $stmt9) {
							trigger_error('3rd Error! Failed to insert software!', E_USER_ERROR);
						}

						//Place the Execute into a variable and test if it executed or not
						$stmt9->execute();

						if (false === $stmt9) {
							trigger_error('4th Error! Failed to insert software!', E_USER_ERROR);
						}
					} 
					else {
						//insert into software table
						$inserIntoPublisher_2 = "INSERT INTO software (softwareID, sequenceNum, title, year, description, notes, hardwareReq, softwareReq, licenceList, numberOfFiles, insertedDate, contributorID, country)
						VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

						//Prepare the query
						$stmt10 = $db_conn->prepare($inserIntoPublisher_2) or trigger_error("1st Error! Failed to insert software!", E_USER_ERROR);

						//Can not proceed if we can not prepare the query
						if (false === $stmt10) {
							trigger_error("2nd Error! Failed to insert software!", E_USER_ERROR);
						}
						//Bind the fields and their parameters to our query in our testing variable $next_step
						$stmt10->bind_param('iisisssssisis', $softwareID, $seqnum, $title, $year, $description, $notes, $hardwareReq, $softwareReq, $licencelist, $filesnum, $date, $contributoridInsert, $country);

						//If $stmt10 is false then it didn't work and there is no sense of proceeding
						if (false === $stmt10) {
							trigger_error('3rd Error! Failed to insert software!', E_USER_ERROR);
						}

						//Place the Execute into a variable and test if it executed or not
						$stmt10->execute();

						if (false === $stmt10) {
							trigger_error('4th Error! Failed to insert software!', E_USER_ERROR);
						}
					}

					//Insert into author_software, first author
					if (($_POST['authorfirst'] != "") || ($_POST['authorlast'] != "")) {
						$inserIntoContributor = "INSERT INTO author_software (authorID, softwareID, sequenceNum) VALUES (?, ?, ?)";

						//Prepare the query
						$stmt11 = $db_conn->prepare($inserIntoContributor) or trigger_error("1st Error! Failed to insert author and software!", E_USER_ERROR);

						//Can not proceed if we can not prepare the query
						if (false === $stmt11) {
							trigger_error("2nd Error! Failed to insert author and software!", E_USER_ERROR);
						}
						//Bind the fields and their parameters to our query in our testing variable $next_step
						$stmt11->bind_param('iii', $authoridInsert, $softwareID, $seqnum);

						//If $stmt11 is false then it didn't work and there is no sense of proceeding
						if (false === $stmt11) {
							trigger_error('3rd Error! Failed to insert author and software!', E_USER_ERROR);
						}

						//Place the Execute into a variable and test if it executed or not
						$stmt11->execute();
					}
					
					
					//Insert into author_software, second author
					if (($_POST['authorfirst1'] != "") || ($_POST['authorlast1'] != "")) {
						$inserIntoContributor_1 = "INSERT INTO author_software (authorID, softwareID, sequenceNum) VALUES (?, ?, ?)";

						//Prepare the query
						$stmt11_1 = $db_conn->prepare($inserIntoContributor_1) or trigger_error("1st Error! Failed to insert second author and software!", E_USER_ERROR);

						//Can not proceed if we can not prepare the query
						if (false === $stmt11_1) {
							trigger_error("2nd Error! Failed to insert second author and software!", E_USER_ERROR);
						}
						//Bind the fields and their parameters to our query in our testing variable $next_step
						$stmt11_1->bind_param('iii', $authoridInsert_1, $softwareID, $seqnum);

						//If $stmt11_1 is false then it didn't work and there is no sense of proceeding
						if (false === $stmt11_1) {
							trigger_error('3rd Error! Failed to insert second author and software!', E_USER_ERROR);
						}

						//Place the Execute into a variable and test if it executed or not
						$stmt11_1->execute();
					}
					
										
					//Insert into author_software, third author
					if (($_POST['authorfirst2'] != "") || ($_POST['authorlast2'] != "")) {
						$inserIntoContributor_2 = "INSERT INTO author_software (authorID, softwareID, sequenceNum) VALUES (?, ?, ?)";

						//Prepare the query
						$stmt11_2 = $db_conn->prepare($inserIntoContributor_2) or trigger_error("1st Error! Failed to insert third author and software!", E_USER_ERROR);

						//Can not proceed if we can not prepare the query
						if (false === $stmt11_2) {
							trigger_error("2nd Error! Failed to insert third author and software!", E_USER_ERROR);
						}
						//Bind the fields and their parameters to our query in our testing variable $next_step
						$stmt11_2->bind_param('iii', $authoridInsert_2, $softwareID, $seqnum);

						//If $stmt11_2 is false then it didn't work and there is no sense of proceeding
						if (false === $stmt11_2) {
							trigger_error('3rd Error! Failed to insert third author and software!', E_USER_ERROR);
						}

						//Place the Execute into a variable and test if it executed or not
						$stmt11_2->execute();
					}
					
										
					//Insert into author_software, fourth author
					if (($_POST['authorfirst3'] != "") || ($_POST['authorlast3'] != "")) {
						$inserIntoContributor_3 = "INSERT INTO author_software (authorID, softwareID, sequenceNum) VALUES (?, ?, ?)";

						//Prepare the query
						$stmt11_3 = $db_conn->prepare($inserIntoContributor_3) or trigger_error("1st Error! Failed to insert fourth author and software!", E_USER_ERROR);

						//Can not proceed if we can not prepare the query
						if (false === $stmt11_3) {
							trigger_error("2nd Error! Failed to insert fourth author and software!", E_USER_ERROR);
						}
						//Bind the fields and their parameters to our query in our testing variable $next_step
						$stmt11_3->bind_param('iii', $authoridInsert_3, $softwareID, $seqnum);

						//If $stmt11_3 is false then it didn't work and there is no sense of proceeding
						if (false === $stmt11_3) {
							trigger_error('3rd Error! Failed to insert fourth author and software!', E_USER_ERROR);
						}

						//Place the Execute into a variable and test if it executed or not
						$stmt11_3->execute();
					}
										
										
					//Insert into author_software, fifth author
					if (($_POST['authorfirst4'] != "") || ($_POST['authorlast4'] != "")) {
						$inserIntoContributor_4 = "INSERT INTO author_software (authorID, softwareID, sequenceNum) VALUES (?, ?, ?)";

						//Prepare the query
						$stmt11_4 = $db_conn->prepare($inserIntoContributor_4) or trigger_error("1st Error! Failed to insert fifth author and software!", E_USER_ERROR);

						//Can not proceed if we can not prepare the query
						if (false === $stmt11_4) {
							trigger_error("2nd Error! Failed to insert fifth author and software!", E_USER_ERROR);
						}
						//Bind the fields and their parameters to our query in our testing variable $next_step
						$stmt11_4->bind_param('iii', $authoridInsert_4, $softwareID, $seqnum);

						//If $stmt11_4 is false then it didn't work and there is no sense of proceeding
						if (false === $stmt11_4) {
							trigger_error('3rd Error! Failed to insert fifth author and software!', E_USER_ERROR);
						}

						//Place the Execute into a variable and test if it executed or not
						$stmt11_4->execute();
					}
					
					
					// send an acknowledgement email to the contributor
					// INCLUDE 'cgi-bin/mail/maildefinitions.php';
					// send an new entry notification email to the web master
					// INCLUDE 'cgi-bin/mail/formmail.php';
					//ECHO "<br><h3>Success!Your information has been added.<br/> Thank you! <a href=\"search.php\">Click here to search another item.</h3></a><br/>";
				}
			}
			else {
				// code changed here to accomodate changed requirements to text in JS alert box.
				//daniel pihllis 17/7/17
				echo "<script>

					if(confirm(\"A record with the same title already exists. Would you like to add more details about this submission?\")){
						window.location = \"modifyEntry.php?id=$softwareID\";
					}
					else {
						window.location = \"newEntry.php\";
					}
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
	global $insertionStatus, $fileUploadStatus, $captchaStatus, $softwarenum_rows;
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
		if ($insertionStatus == 0 && $fileUploadStatus == 0 && $captchaStatus == 0 && $softwarenum_rows == 0) {
			
			echo "<script>
				window.location = \"insertionSuccess.php\";
			</script>";
			
			echo '<META HTTP-EQUIV="Refresh" Content="0; URL=insertionSuccess.php">';
			
			//echo "<h3 id=\"headerTitleH3\" style=\"text-transform: none;\"> Success! Your information has been added. Thank you! <a href=\"search.php\">Click here if you want to search another item.</h3></a><br/>";
			//echo "<h3 id=\"headerTitleH3\" style=\"text-transform: none;\"> Success! Your information has been added. Thank you! <a href=\"search.php\">Click here if you want to search another item.</h3></a><br/>";
		}
	}
?>  
		
