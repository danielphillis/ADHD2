<?php
    $currentPage="Successful Contribution";
?>
<!doctype html>
<!--[if lt IE 7]> <html class="ie6 oldie"> <![endif]-->
<!--[if IE 7]> <html class="ie7 oldie"> <![endif]-->
<!--[if IE 8]> <html class="ie8 oldie"> <![endif]-->
<!--[if gt IE 8]>
<!-->
<html class="">
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modify Entry</title>
    <link href="../css/boilerplate.css" rel="stylesheet" type="text/css">
    <link href="../css/ADHD_layout.css" rel="stylesheet" type="text/css">
    <!--[if lt IE 9]>
	<link href="css/ie_layout.css" rel="stylesheet" type="text/css">
    <![endif]-->
    <!--[if lt IE 8]>
	<![endif]-->
    <script src="../script/jquery-3.2.1.min.js"></script>
    <!-- RECAPTCHA -->
    <!-- <script src='https://www.google.com/recaptcha/api.js'></script> -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
            	
            	<!-- @@@ indexInnerBodyLeft_1 is the main white text box with shadowing
            	- the box we want to scale for this page is mainContentLeftColumn
				(by overriding the css style below) -->

				<!-- Width of search results div element -->
				<div id="innerMainContentLeftColumn"
					style="min-width: 80%;">
				<div id="indexInnerBodyLeft_1" style="
					/* OVERRIDE  to accommodate more text/ search results */
					width: 100%;
					max-width: 1250px; /* was 805 */
					background-color: #FFF; /* white */
					position: relative;
					height: auto;
					/* float: middle; /* changed from left */
					-webkit-box-shadow: 0 1px 35px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
					-moz-box-shadow: 0 1px 35px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
					box-shadow: 0 1px 35px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
				">
                                <!-- DETAILED SEARCH PARAMETERS -->
                                <!-- no  href link specified here therefore this is the detailed search content-->
                <div id="detailed" style="
                    display: block;
                    margin: 25px;
                ">
                <h1 id="headerTitle">
                <a  style="font-size: 15px; font-weight: 550;"
                    href="ADHD_search.php">
                    Search |
                <a  style="font-size: 15px; font-weight: 550;" href="ADHD_searchKeyword.php" ">Keyword Search</a> |
                <a  style="font-size: 15px; font-weight: 550;" href="ADHD_searchTitleList.php" ">Title List</a></h1>
                <p>
                <div id="listContent">
				<h3 id="headerTitle">
                    <p>Successful Contribution</p></h3>
                    <?php
                    
                    global $softwareID, $seqNum;
                    
                        echo '<center>Your contribution was validated as successful<br>';
                        echo 'Both the webmaster and yourself will be emailed a <br>'
                        . 'summary of the Database contribution.<br>';
                        
                        #echo '<a href="ADHD_displayEntry.php?id='.$softwareID.'">View the new Contribution</a>';
                        
                        echo '</center>';
                        #notify web master
                        #notify contributor
                    ?>
                
</p>
<!-- 6 closing div tags -->
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
        <span id="infoFooterCopyright"><?php include("includes/ADHD_copyright.php");
        //File that contains the copyright notice ... the copyright year is incremented automatically ?></span>
    </div>
</div>
    </div>
    <!-- Support for place holders for legacy browsers (DO NOT MOVE) -->
<script src="../script/placeholders.min.js"></script>
</body>
</html>