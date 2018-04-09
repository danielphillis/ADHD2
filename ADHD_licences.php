<?php
	$currentPage="LICENCES";
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
    <title>IP/Licences</title>
	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link href="../css/boilerplate.css" rel="stylesheet" type="text/css">
    <link href="../css/ADHD_layout.css" rel="stylesheet" type="text/css">
    <!--[if lt IE 9]>
	<link href="css/ie_layout.css" rel="stylesheet" type="text/css">
    <![endif]-->
    <!--[if lt IE 8]>
	<![endif]-->
		
	<script src="./js/jquery-1.10.2.js"></script>
	<script src="./js/jquery-ui.js"></script>
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
						<h1 id="headerTitle">IP/Licences</h1>
							<div id="accordionHolder">
								<div id="accordion">
								
									<h3>Why is licencing important?</h3>
									<div>
										<p>
											<?php include "text/lic_whyIsLicensingImportant.txt";?>
											<br>
										</p>
									</div>
									
									<h3>If you are uploading assets like images or sounds</h3>
									<div>
										<p align="left">
											<?php include "text/lic_ifYouAreUploadingImages.txt";?>
										</p>
									</div>
									
									<h3>Different Creative Commons Licences and Choosing one to suit you</h3>
									<div>
										<p>
										    <?php include "text/lic_differentLicenses.txt";?>
										</p>
									</div>
									
									<h3>The GPL: A Licence specifically for Software</h3>
									<div>
										<p>
											 <?php include "text/lic_GPL.txt";?>
										</p>
									</div>
									
									<h3>Public Domain</h3>
									<div>
										<p>
											<?php include "text/lic_publicDomainNames.txt"; ?>
										</p>
									</div>
									
									<h3>And if you don't like any of these options?</h3>
									<div>
										<p>
										<?php include "text/lic_andIfYouDontLike.txt"; ?>
										</p>
									</div>
									
									<h3>Once you have selected a licence</h3>
									<div>
										<p>
										<?php include "text/lic_onceYouHaveSelectedALicence.txt"; ?>
										</p>
									</div>
									<br/><br/>
								</div>
							</div>
						<br/><br/>
					</div>
				</div>
				<div id="innerMainContentRightColumn">
					<div id="indexInnerBodyRight_1">
						<div id="blogContainer">
						<?php include("includes/ADHD_blog.php"); 
						//File that contains the DIV of the details of the blog entries ?>
						</div>
						<!-- <div id ="twitterContainer"> -->
							<!-- //the twitter php file doesnt have a starting div tag ? -->
							<?php include("includes/ADHD_twitter.php"); 
							//File that contains the DIV of the details of the twitter entries ?>
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
