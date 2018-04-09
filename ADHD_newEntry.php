<?php
    /* 
    ADHD_newEntry.php
    daniel.phillis@gmail.com Flinders Univeristy 5 March 2018
    */

    $currentPage = "CONTRIBUTE";
    $unit = 0;
    global $construction;
    $construction = 1;
    
    //set $test to zero to disbale inclusion of unit tests - 
    //unit tests should be seperate to this file any ways
	
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
    <title>Australasian Digital Heritage Database - Contribute New Entry</title>
    <link href="../css/boilerplate.css" rel="stylesheet" type="text/css">
    <link href="../css/ADHD_layout.css" rel="stylesheet" type="text/css">
    <!--[if lt IE 9]>
	<link href="css/ie_layout.css" rel="stylesheet" type="text/css">
    <![endif]-->
    <!--[if lt IE 8]>
	<![endif]-->
</head>

<div class="mainWrapper">
        <!-- DIV containing the ADHD social links -->  
		<div id="outerSocialLinks">   
			<?php include("includes/ADHD_socialLinksHeader.php"); //File that contains the social links icons above the header section ?>
		</div>
		<!-- DIV containing the main navigation menu and the logo -->  
      	<div id="outerHeader">        
            <?php include("includes/ADHD_mainNavigationMenu.php"); //File that contains the main navigation menu and the logo ?>       
		</div>
		<!-- DIV containing the links to the social accounts, ADHD logo and menu in mobile mode -->
		<?php include("includes/ADHD_mobileNavigationHeader.php"); 
		//File that contains the social accounts, ADHD logo and menu in mobile mode ?>     
        
        <!-- DIV containing the main content -->  
        <div id="outerMainContent"> 
        	<div id="innerMainContent">
				<div id="innerMainContentLeftColumn">
					<div id="indexInnerBodyLeft_1" style="
						/* OVERRIDE  to accommodate more text/ search results */
								width: 100%;
								max-width: 1250px; /* was 805 */
								/* min-height: 1250; */
								background-color: white;
								/* position: relative; */
								height: auto;

								float: left; /* changed from left */
								-webkit-box-shadow: 0 1px 35px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
								-moz-box-shadow: 0 1px 35px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
								box-shadow: 0 1px 35px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
								">

					<h1 id="headerTitle">MAKE A CONTRIBUTION</h1>
						<!--
							&rarr; Please enter as much as information you know about the software, then click Submit.<br/>
							&rarr; If you are uploading files, please nominate their intellectual property status.<br/>
							&rarr; Only fields marked with an asterisk ( * ) are required.
							@@@ -->
                                                        <?php 
                                                            global $construction;
                                                        
                                                            if (!$construction){
                                                                include("includes/ADHD_newEntryForm4.php");
                                                            } else {
                                                                include("underConstruction.php");
                                                            }
                                                        ?>	
						</p>
					</div>  
				</div>
				<div id="innerMainContentRightColumn">
				<div id="indexInnerBodyRight_1">
				<div id="blogContainer">
				<?php //include("includes/ADHD_blog.php"); 
						echo 'blog feed temp disabled in code for speed<br>';
				?>

				</div>
				<?php //include("includes/ADHD_twitter.php");
						echo 'twitter feed temp disabled in code<br>';?>
			
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
		</div>
		<div id="outerFooterDeclarations">
			<div id="innerFooterDeclarations"
			style="
				background-color: black;
			">
				<span id="infoFooterCopyright">
				<?php include("includes/ADHD_copyright.php"); 
				//File that contains the copyright notice ... the copyright year is incremented automatically ?>
				</span>
			</div>
		</div>
	</div>
	<!-- Support for place holders for legacy browsers (DO NOT MOVE) -->
    <script src="../script/placeholders.min.js"></script>
	<script src="../script/jquery.touchSwipe.min.js"></script>
	<script src="../script/jquery-fullsizable.min.js"></script>
	<script>
		$('a.fullsizable').fullsizable({
		  detach_id: 'wrapper'
		});

		$(document).on('fullsizable:opened', function(){
		  $("#jquery-fullsizable").swipe({
			swipeLeft: function(){
			  $(document).trigger('fullsizable:next')
			},
			swipeRight: function(){
			  $(document).trigger('fullsizable:prev')
			},
			swipeUp: function(){
			  $(document).trigger('fullsizable:close')
			}
		  });
		});
	</script>
	<script src="../script/scale.fix.js"></script>
</body>
</html>
