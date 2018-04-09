<?php
if (isset($_POST["submitContact"])) {
	$securityQuestionContact = $_POST["securityQuestionContact"];
				
	if(md5($securityQuestionContact).'5i9p' == $_COOKIE['conmes']){
		error_reporting(-1);
		ini_set('display_errors', 'On');
		set_error_handler("var_dump");

		//if "email" variable is filled out, send email
		if (isset($_POST['emailAddressContact'], $_POST['emailSubjectContact'], $_POST['messageContact'])) {
			//Email information
			$admin_email = "info@ourdigitalheritage.org";
			$subject = strip_tags($_POST['emailSubjectContact']);
			$email = strip_tags($_POST['emailAddressContact']);
			$message = strip_tags($_POST['messageContact']);
			
			//send email
			mail($admin_email, "$subject", $message, "From:" . $email);
			  
			//Email response
			echo "<span style=\"font-size: 12px; color: #CCFFCC;\">Thank you for contacting us!</span>";
		}
		//if "email" variable is not filled out, display the form
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