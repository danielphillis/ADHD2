<?php
	$currentPage="OURTEAM";
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
    <title>Our Team</title>
    <link href="../css/boilerplate.css" rel="stylesheet" type="text/css">
    <link href="../css/ADHD_layout.css" rel="stylesheet" type="text/css">
    <!--[if lt IE 9]>
	<link href="css/ie_layout.css" rel="stylesheet" type="text/css">
    <![endif]-->
    <!--[if lt IE 8]>
	<![endif]-->

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
						<h1 id="headerTitle">About the team</h1>
						<p>
							<?php include 'text/adhd_ourTeam.txt' ?>
						</p>
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