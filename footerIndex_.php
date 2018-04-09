<div id="externalResources">
	
	<!-- <h3 class="footerTitles">EXTERNAL RESOURCES</h3> -->
	<span id="footer">
	</span>
	
</div>
				
<div id="followUs" style="
		background-image: url(../images/BGColours/BGRamp3.jpg);
	">
	
	<h3 class="footerTitles">FOLLOW US</h3>
		<span id="footer" style="color: black;">
		<?php /* --old text --
			You can use the links provided below to try and connect with us on the social networks. We post videos and other content on these networks to keep you updated of our latest findings. 
			*/
			?>
			You can use the social media links provided at the top of the page to connect with us. We post videos and other content on these networks to keep you updated of our latest findings. 
			<br/><br/>
		</span>

	<table width="95%" border="0" align="left">
		<tr>
			<td width="12%" height="30px"><img src="images/socialMedia/facebookFooterWhite.png" 
			width="25" height="25"/></td>
			<td width="88%">
			<a 	href="https://www.facebook.com/ourdigitalheritage" 
				target="_blank"
				style="color: black;">
			See Our Facebook TimeLine</a></td>
		</tr>
		<tr>
			<td width="12%" height="30px"><img src="images/socialMedia/youtubeFooterWhite.png"  
			width="25" height="25"/>
			</td><td>
			<a 	href="https://www.youtube.com/user/ourdigiheritage" 
				target="_blank"
				style="color: black;">Watch our Videos on YouTube</a></td>
		</tr>
		<tr>
			<td width="12%" height="30px"><img src="images/socialMedia/twitterFooterWhite.png"  
			width="25" height="25"/>
			</td><td>
			<a 	href="https://twitter.com/ourdigiheritage" 
				target="_blank"
				style="color: black;">See Our Tweets on Twitter</a></td>
		</tr>
	</table>
	
</div>
			
<div id="contactUs">
	<h3 class="footerTitles">CONTACT US</h3>
	<form name="contactForm" action="index.php" method="post" class="contactForm" enctype="multipart/form-data">
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

		<img 	src="captcha.php?<?php echo rand(0,9999);?>" 
				alt="verification image, type the displayed text in the box" 
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
		//DIV is closed in the index.php to accommodate the captacha error for contact us form ... Other pages have a different include footer file that has the ending div tag at the very end of the file
	?>
