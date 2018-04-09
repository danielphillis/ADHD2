<div id="followUs"> <!-- was 'externalResources' -->
	
	<!-- <h3 class="footerTitles">EXTERNAL RESOURCES</h3> -->
	<span id="footer">
	</span>
	
</div>
				
<div id="followUs" style="
		background-image: url(../../images/BGColours/BGRamp2.jpg);
	">
	
	<h3 class="footerTitles">FOLLOW US</h3>
		<span id="footer" style="color: black;">
		<?php /** --old text --
			    * You can use the links provided below to try and connect with us on the social networks.
                * We post videos and other content on these networks to keep you updated of our latest findings.
			    */
			?>
            <!-- text not yet included in  an editable file -->
			You can use the social media links provided at the top of the page to connect with us.
            We post videos and other content on these networks to keep you updated of our latest findings.
			<br><br>
		</span>

	<table width="95%" border="0" align="left">
		<tr>
			<td width="12%" height="30px">
			<img 	src="../images/socialMedia/facebookFooterWhite.png" 
					width="25" 
					height="25"/></td>
			<td width="88%">
			<a 	href="https://www.facebook.com/ourdigitalheritage" 
				target="_blank"
				style=" color: black;
						font-weight: normal;
				">
			See Our Facebook TimeLine</a></td>
		</tr>
		<tr>
			<td width="12%" height="30px"><img src="../images/socialMedia/youtubeFooterWhite.png"  
			width="25" height="25"/>
			</td><td>
			<a 	href="https://www.youtube.com/user/ourdigiheritage" 
				target="_blank"
				style=" color: black;
						font-weight: normal;
				">
			Watch our Videos on YouTube</a></td>
		</tr>
		<tr>
			<td width="12%" height="30px"><img src="../images/socialMedia/twitterFooterWhite.png"  
			width="25" height="25"/>
			</td><td>
			<a 	href="https://twitter.com/ourdigiheritage" 
				target="_blank"
				style="	
						color: black;
						font-weight: normal;
				">
				See Our Tweets on Twitter</a></td>
		</tr>
	</table>
	
</div>
			
<div id="contactUs">
	<h3 class="footerTitles">CONTACT US</h3>
	<form name="contactForm" action="ADHD_index.php" method="post" class="contactForm" enctype="multipart/form-data">
		<input type="text" 
		id="emailSubjectContact" 
		class="contactForm" 
		name="emailSubjectContact" 
		placeholder="Enter Your Subject..." 
		maxlength="300" 
		style="color:black;"
		required/>
		
		<input type="email" 
		id=" " class="contactForm" 
		name="emailAddressContact" 
		placeholder="Enter Your Email..." 
		maxlength="150" 
		style="color:black;"
		required/><br/>
		
		<input type="text" 
		id="securityQuestionContact" 
		class="contactForm" 
		name="securityQuestionContact" 
		placeholder="Enter Security Code..." 
		maxlength="5" 
		style="color:black;"
		required/>
		
		<!-- NB that this file is included with one
		from the directory above therefore the includes
		folder must be added to the src path below -->

		<img 	src="ADHD_captcha.php?<?php echo rand(0,9999);?>"
				alt="verification image, type displayed text in the box" 
				width="45" 
				height="29" 
				align="absbottom" 
				style="border-color:#64a3ba; 
						border:1px 
						dashed #64a3ba; 
						border-radius: 10px;">
			<br>
					  
		<textarea 	id="messgaeContact" 
					class="contactForm" 
					name="messgaeContact" 
					placeholder="Enter Your Message..." 
					maxlength="1500" 
					style="color:black;"
					required/>
			
		</textarea><br/>

		<input 	type="submit" 
				value="SUBMIT" 
				id="submitContact" 
				name="submitContact" 
				style="color:white;">
		</form>
	
	<?php
		/** DIV is closed in the index.php to accommodate the captacha error for contact us form ...
         Other pages have a different include footer file that has the ending div tag at the very end of the file */

		if (isset($_POST["submitContact"])) {
			$securityQuestionContact = $_POST["securityQuestionContact"];
						
			if(md5($securityQuestionContact).'5i9p' == $_COOKIE['conmes']){
				error_reporting(-1);
				ini_set('display_errors', 'On');
				set_error_handler("var_dump");

				#if "email" variable is filled out, send email
				if (isset($_POST['emailAddressContact'], $_POST['emailSubjectContact'], $_POST['messageContact'])) {
					#Email information
					$admin_email = "info@ourdigitalheritage.org";
					$subject = strip_tags($_POST['emailSubjectContact']);
					$email = strip_tags($_POST['emailAddressContact']);
					$message = strip_tags($_POST['messageContact']);
					
					#send email
					mail($admin_email, "$subject", $message, "From:" . $email);
					  
					#Email response
					echo "<span style=\"font-size: 12px; color: #CCFFCC;\">Thank you for contacting us!</span>";
				}
				#if "email" variable is not filled out, display the form
				else {
					print("<span style=\"font-size: 12px; color: red;\">Please complete all fields above.</span>");
				}
				unset($_COOKIE['conmes']);					
			}
			else {
				print("<span style=\"font-size: 12px; color: red;\">You have entered a wrong security code above!.</span>");
			}
		}
	?>
