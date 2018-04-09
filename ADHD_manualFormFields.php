<?php
    /** Messy form fields
     * manually defined form fields from original files
     * daniel phillis
     */

    #include ("ADHD_functionsCreate.php");
    #<!-- TITLE -->
    echo '<label for="title" id="modifyEntryLabels">* Title:';

    #if form is submitted
    if(isset($_POST["Submit"])){
        if($_POST["title"]=='') {//check title has not been left blank and warn the user if so
            print("<span style=\"font-size: 11px; color: red;\">Please enter a title.</span>");
        }
        else if(preg_match("/^\\s/",$_POST["title"])){ //check the title data enteredd doesnt start with a space and warn user
            print("<span style=\"font-size: 11px; color: red;\">Cannot start with space.</span>");
        }
    }
?>
    </label>

    <!--TESTING WITH VALUES PRE_INSERT -->
    <INPUT type="text" class="input" name="title" id="title" value="<?php
    #if ($TOGGLE_TEST_DATA) echo 'null';
    #SWITCH
    switch($TEST_DATA){
        case 0:
            echo '';
            break;
        case 1:
            echo 'null';
            break;
        case 2:
            echo '3D Golf';
            break;
    }
    ?>" required>
    <br>

    <!-- YEAR -->
    <!-- VALIDATION: for 4 chars and pattern is number, and re-validate on update -->

    <label for="Year" id="modifyEntryLabels"> Year: </label>
    <INPUT 	type="text" class="input" name="Year" id="Year"
              size="4" value="<?php if($TOGGLE_TEST_DATA) echo '2017'; ?>" maxlength="4" pattern="\d*"
              oninvalid="setCustomValidity('Please enter a number.')"
              onchange="try{setCustomValidity('')}catch(e){}"/><br/>

    <!-- UP TO 5 AUTHORS -->
    <div class="tooltipContainer" onmouseover="show(tooltip00)" onmouseout="hide(tooltip00)">
        <!-- tooltip(00) is defined below -->
        <label for="authGivenFamily" id="modifyEntryLabels"> Number of Authors: <font style="font-size: 11px; color:#DA6200;">(See Note)</font></label>
        <div class ="bigTooltip" id="tooltip00">
            Select how many author(s) this software has, then enter their name(s).
        </div>
    </div>

    <!-- SELECT AUTHOR NUM ROWS -->
    <SELECT class="sel1" id="authInputCount"
            name="authInputCount"
            onChange="ShowMenu(document.getElementById('authInputCount').value, 'divInput', 5);">
        <OPTION value="0">0 </OPTION>
        <OPTION value="1">1 </OPTION>
        <OPTION value="2">2 </OPTION>
        <OPTION value="3">3 </OPTION>
        <OPTION value="4">4 </OPTION>
        <OPTION value="5">5 </OPTION>
    </SELECT><br/>

<?php
        createAuthorFormFieldsForTesting(5);
        #createAuthorFields(5);
?>

    <!-- PUBLISHER -->
    <hr>
    <label for="publisher" id="modifyEntryLabels"> Publisher: </label>
    <INPUT type="text" class="input" name="publisher" id="publisher" size="30" value="<?php
    #if ($TOGGLE_TEST_DATA) echo 'Melbourne House';

        #SWITCH
        switch($TEST_DATA) {
            case 0:
                echo '';
                break;
            case 1:
                echo 'Melbourne House';
                break;
            case 2:
                #made random
                # $r = rand(0,9999);
                # if ($_debug) echo 'rand number = '.$r;
                echo 'NewPublisher';
                # echo $r;
                break;
        }
        ?>">
    <br>

    <!-- SELECT COUNTRY -->
    <label for="country" id="modifyEntryLabels"> Country: </label> <!-- @@@ wrong for parm entered (was publisher) -->
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

    <!-- DESCRIPTION -->
    <label for="description" id="modifyEntryLabels"> Description: </label>
    <TEXTAREA class="textarea" name="description" id="description" rows="1"></TEXTAREA><br/>

    <!-- TOOLTIPS -->
    <div class="tooltipContainer" onmouseover="show(tooltip1)" onmouseout="hide(tooltip1)">

        <!-- NOTES -->

        <label id="modifyEntryLabels" for="notes"> Notes: <font style="font-size: 11px; color:#DA6200;">(See Note)</font></label>
        <div class = "bigTooltip" id= "tooltip1">
            Include information here that doesn't fit elsewhere.
            For example: working copy status, collection title is housed in, the chip for obscure systems, version numbers,
            if you are the author, copyright owner (if known), programming language, emulation availability, credits for photos,
            information on manuals, etc.
        </div>
    </div>
    <TEXTAREA class="textarea" name="notes" rows="7"></TEXTAREA><br/>

    <!-- BIG TOOLTIP FOR NUMBER OF FILES -->

    <div class="tooltipContainer" onmouseover="show(tooltip0)" onmouseout="hide(tooltip0)">

        <!-- NUMBER OF FILES -->

        <label for="filesnum" id="modifyEntryLabels"> Number of Files: <font style="font-size: 11px; color:#DA6200;">(See Note)</font></label>
        <div class = "bigTooltip" id= "tooltip0">
            We only accept images (ending ".jpg",".gif",".png"), plain text (.txt) and pdf files. The files should be less than 2MB.
        </div>
    </div>
    <SELECT class="sel1" id="num" name="filesnum" onChange="ShowMenu(document.getElementById('num').value, 'divFile', 9);">
        <?php
            #Echo 10 options in a drop down menu
            for ($n=0;$n<10;$n++){
                echo '<OPTION value="'.$n.'">'.$n.' </OPTION>';
            }
        ?>
    </SELECT><br/>

    <!-- display 10 upload DIVS -->
    <?php
        createUploadFormFieldsWithLoop();
        #loopUploadFields_test(1); # called from includes/ADHD_functionsCreate.php
        #debug switched to text files
    ?>
    <hr>

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
        <label for="contributorFamily" id="modifyEntryLabels"> * Your Family Name:
            <font style="font-size: 11px; color:#DA6200;">(See Note)</font>

            <!-- CONTRIBUTOR Family NAME -->

            <?php
            # CHECK contributor FAMILY NAME IS FILLED OUT or not (MANDATORY FIELD)
            if (isset($_POST["Submit"])){ //can this be replaced with if($_POST['Submit'])
                IF ($_POST["contributorFamily"] == ''){
                    global $insertionStatus;
                    $insertionStatus = 1; //Flag Error
                    print("<span style=\"font-size: 11px; color: red;\">Please enter your family name.</span>");
                }
            }
            ?>
        </label>
        <div class = "smallTooltip" id= "tooltip2">
            Your name will be kept confidential.
        </div>
    </div>

    <!-- CONTRIBUTOR FAMILY (LAST) NAME FIELD FOR TESTING -->
    <input required type="text" class="input" name="contributorFamily" size="30" value="<?php
    if ($TOGGLE_TEST_DATA) echo 'Phillis'; ?>"
    ><!-- close off input tag -->
    <br>
    <div class="tooltipContainer" onmouseover="show(tooltip3)" onmouseout="hide(tooltip3)">

        <!-- CONTRIBUTOR GIVEN (FIRST) NAME -->

        <label for="contributorGiven" id="modifyEntryLabels">Your Given Name:
            <font style="font-size: 11px; color:#DA6200;">(See Note)</font></label>
        <div class = "smallTooltip" id= "tooltip3">
            Your name will be kept confidential.
        </div>
    </div>

    <!-- CONTRIBUTOR FIRST NAME INPUT-->
    <input  type="text" class="input" name="contributorGiven" size="30" value="<?php
    if ($TOGGLE_TEST_DATA) echo 'daniel'; ?>
            ">

    <br>
    <div class="tooltipContainer" onmouseover="show(tooltip4)" onmouseout="hide(tooltip4)">

        <!-- EMAIL (alternate) ADDRESS this is made for the users email - the normal email field is reserved for detecting spam bots -->

        <label for="altAddress" id="modifyEntryLabels"> * Your email address: <font style="font-size: 11px; color:#DA6200;">(See Note)</font>
            <?php
            #CHECK for EMAIL ADDRESS - A MANDATORY FIELD
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
            ?>
        </label>
        <div class = "smallTooltipEmail" id= "tooltip4">
            Your email address will not be disclosed.
        </div>
    </div>
    <!-- users EMAIL FIELD (spambot emnaiul is below with no label)-->
    <input  required type="email" class="input" name="altAddress" size="30" value="<?php

    # separate test data from structural code
    if ($TOGGLE_TEST_DATA) echo 'daniel.phillis@gmail.com';
    ?>">
    <br>

    <!-- INVISIBLE EMAIL TO PREVENT SPAM BOTS
    (cant be required/mandatory as we need it to be left blank for form validity)-->
    <input type="text" class="captchaemail" name="email" size="30" value="" style="display: none;"> <!-- hidden -->

    <?php
    # IF spambotEMAIL IS NOT BLANK - this indicicate suspicious behaviour
    if (isset($_POST["Submit"])){
        if ($_POST["email"] != ''){//check original code
            $error['email'] = 1;
        } else {
            if (!checkEmail($_POST["email"])) {
                $error['email'] = 1;
            }
        }
    }
    ?>
    <!-- ENTER VERIFICATION CODE -->
    <label for="verifCode" id="modifyEntryLabels"> * Enter Verification Code: </label>
    <input required type="text" id="verifCode" class="securityInput" name="verifCode" style="margin-bottom: 3px;" maxlength="5" >

    <?php
    #echo '<br>';

    if (isset($_POST["Submit"])) {
        $verifCode = $_POST["verifcode"];

        if(md5($verifCode).'8cq3' == $_COOKIE['imgcap']){
            global $captchaStatus;
            unset($_COOKIE['imgcap']);
            $captchaStatus = 0;
        }
        else {
            #CODE doesnt match the image,
            #then later test for the state of the $captureSatatus var
            #or use it as a multiplier

            global $captchaStatus;
            $captchaStatus = 1;
            $captchaStatus = 0; #@@@ override
        }
    }

    global $captchaStatus;
    if($captchaStatus == 1){
        echo '<label id="modifyEntryLabels"> </label>';
        echo '<span style="
            margin-bottom:10px;
            color:red;
            padding:3px;
            width: 209px;
            height: 29px;">';
        echo 'Wrong Verification Code!';
        echo '</span>';
    }
    ?>
    <label id="modifyEntryLabels"> </label>
    <!-- //captcha -->

    <img src="ADHD_captchaContent.php?
            <?php echo rand(0,9999); #must be on the same line ?>"

         alt="verification image, type it in the field above."
         width="215px" height="29"
         align="absbottom"
         style="
            margin-top: 5px;
            border-color:#64a3ba;
            border:1px dashed #64a3ba;
            border-radius: 10px;">

    <br><br><br>
    <label id="modifyEntryLabels"> </label>
    <!-- <div style="display: inline-block;">-->
    <div style="display: inline-block;">
        <table border=0 width = 95%>
            <td width=25% align = "left">
                <INPUT type="submit" id="sButton" name="Submit"
                       value="SUBMIT">
            </td>
            <td></td>
            <td width=25% align = "middle">
                <INPUT type="reset" id="rButton" value="RESET"></td>
        </table>
    </div>

