<?php
	$currentPage="FAQ";
?>

<!doctype html>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]> <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]> <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]> 141111114
<!-->
<html class="">
<!--<![endif]-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Frequently Asked Questions</title>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link href="../css/boilerplate.css" rel="stylesheet" type="text/css">
    <link href="../css/ADHD_layout.css" rel="stylesheet" type="text/css">
    <!--[if lt IE 9]>
	<link href="../css/ie_layout.css" rel="stylesheet" type="text/css">
    <![endif]-->
    <!--[if lt IE 8]>
	<![endif]-->
		
	<script src="././script/jquery-1.10.2.js"></script>
	<script src="././script/jquery-ui.js"></script>

	<link rel="stylesheet" href="/">
	<script>
		$(function() {
			var icons = {
			  header: "ui-icon-circle-arrow-e",
			  activeHeader: "ui-icon-circle-arrow-s"
			};
			$( "#accordion" ).accordion({
			  icons: icons
			});
			$( "#toggle" ).button().click(function() {
			  if ( $( "#accordion" ).accordion( "option", "icons" ) ) {
				$( "#accordion" ).accordion( "option", "icons", null );
			  } else {
				$( "#accordion" ).accordion( "option", "icons", icons );
			  }
			});
		});
	</script>
</head>

<body>
    <div class="mainWrapper">
	
        <!-- DIV containing the AHSD social links -->  
		<div id="outerSocialLinks">   
			<?php include("includes/ADHD_socialLinksHeader.php"); //File that contains the social links icons above the header section ?>
		</div>
		
		<!-- DIV containing the main navigation menu and the logo -->  
      	<div id="outerHeader">        
            <?php include("includes/ADHD_mainNavigationMenu.php"); //File that contains the main navigation menu and the logo ?>       
		</div>
      
		<!-- DIV containing the links to the social accounts, AHSD logo and menu in mobile mode -->
		<?php include("includes/ADHD_mobileNavigationHeader.php"); //File that contains the social accounts, AHSD logo and menu in mobile mode ?>       
        <!-- DIV containing the main content -->  
        <div id="outerMainContent"> 
			<div id="innerMainContent">
				<div id="innerMainContentLeftColumn">
					<div id="indexInnerBodyLeft_1">
						<h1 id="headerTitle">Frequently Asked Questions</h1>
							<div id="accordionHolder">
								<div id="accordion">
								
									<h3>Why are you doing this?</h3>
									<div>
										<p>
											<?php include "text/faq_whyAreYouDoingThis.txt"; ?>
										</p>
									</div>
									
									<h3>Who cares about early software?</h3>
									<div>
										<p>
											<?php include "text/faq_whoCares.txt"; ?>
											<!-- 
											We do! And lots of other people do too. Software - even from the 1980s and 1990s - is at risk. It is deteriorating. Already some of it does not work. We don't want this material to be lost forever.
											<br/><br/>
											Early software matters. Increasingly it is recognised as part of our digital heritage.
											-->
										</p>
									</div>
									
									<h3>So what can I do to help?</h3>
									<div>
										<p>
										<?php include "text/faq_soWhatCanIDoToHelp.txt"; ?>

										<!-- example text pulled from external file

											This database is compiled by the public, that is, you.  
											<br/><br/>
											Share what you know with the wider community, by entering it in our web form. We have kept it simple. Just enter as much or as little as you know or can remember. There is room to tell us more in the description and notes fields.
											<br/><br/>
											You can upload files that you own, such as screenshots or cover art, and even source code if you have this.  If you are uploading files, please nominate their IP status. We have incorporated a way for you to complete a licence for any content that you own, so that it's clear what your intentions are regarding its use, etc.
											<br/><br/>
											Provide a way that we can get back in touch with you, such as an e-mail address, in case we need to clarify anything.
											-->
										</p>
									</div>
									
									<h3>"But what I know is not very important"</h3>
									<div>
										<p>
											<?php include "text/faq_butWhatIKnowIsNotVeryImportant.txt"; ?>
										</p>
									</div>
									
									<h3>How else can I help?</h3>
									<div>
										<p>
											<?php include 'text/faq_howElseCanIHelp.txt'; ?>
										</p>
									</div>
									
									<h3>How did this project start?</h3>
									<div>
										<p>
											<?php include "text/faq_howDidThisProjectStart.txt"; ?>
										</p>
									</div>
									
									<h3>What are your plans for this project's further development?</h3>
									<div>
										<p>
											<?php include "text/faq_whatAreYourPlans.txt"; ?>
										</p>
									</div>
									
									<h3>Why is licensing important?</h3>
									<div>
										<p>
											<?php include "text/faq_whyIsLicensingImportant.txt" ?>
										</p>
									</div>
																	
									<h3>Stay in touch</h3>
									<div>
										<p>
											<?php include "text/faq_stayInTouch.txt"; ?>"
										</p>
									</div>
																									
									<h3>Privacy notice</h3>
									<div>
										<p>
											<?php include "text/faq_privacyNotice.txt"; ?>
										</p>
									</div>
									
								</div>
							</div>
						<br/><br/>
					</div>
				</div>
				<div id="innerMainContentRightColumn">
				<div id="indexInnerBodyRight_1">
				<div id="blogContainer">

				<?php include("includes/ADHD_blog.php"); //File that contains the DIV of the details of the blog entries ?>
				</div>
				<?php include("includes/ADHD_twitter.php"); //File that contains the DIV of the details of the twitter entries ?>
				</div>
				</div>
				</div>
				</div>
			</div>
		</div>
	
		<div id="outerFooterContent">
			<div id="innerFooterContent">
				<?php include("includes/ADHD_footerIndex.php"); ?>
			</div>
		
		</div>
		
		<div id="outerFooterDeclarations">
			<div id="innerFooterDeclarations">
				<span id="infoFooterCopyright"><?php include("includes/ADHD_copyright.php"); //File that contains the copyright notice ... the copyright year is incremented automatically ?></span>
			</div>
		</div>
	
	</div>
	
	<!-- Support for place holders for legacy browsers (DO NOT MOVE) -->
    <script src="../script/placeholders.min.js"></script>
</body>
</html>
