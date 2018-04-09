<!-- 
#echo '<a href="ADHD_modifyEntry_v'.$modVersion.'.php?id='.$softwareID.'">';
#echo '<a href="ADHD_modifyEntry_v06.php?id='.$softwareID.'">';
-->

<!-- code last augmented by daniel phillis for Flinders University 2017
8/12/2017
unit tests are turned on by setting the variable UNIT_TEST
-->

<?php
	$currentPage="SEARCH";
?>

<?php 
	$GLOBALS['UNIT_TEST'] = 0;
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
    <title>Search</title>
    <link href="../css/boilerplate.css" rel="stylesheet" type="text/css">
    <link href="../css/ADHD_layout.css" rel="stylesheet" type="text/css">
    <!--[if lt IE 9]>
	<link href="css/ie_layout.css" rel="stylesheet" type="text/css">
    <![endif]-->
    <!--[if lt IE 8]>
	<![endif]-->
	
    <script src="../script/jquery-3.2.1.min.js"></script>
</head>

<body>
    <div class="mainWrapper">
        <!-- DIV containing the AHSD social links --> 
        <div id="outerSocialLinks">   
                <?php #File that contains the social links icons above the header section 
                    include("includes/ADHD_socialLinksHeader.php"); 
                ?>
        </div>
        <!-- DIV containing the main navigation menu and the logo -->  
      	<div id="outerHeader">
            <?php 
                #File that contains the main navigation menu and the logo 
                include("includes/ADHD_mainNavigationMenu.php"); 
            ?>       
        </div>
        <!-- DIV containing the links to the social accounts, AHSD logo and menu in mobile mode -->
        <?php #File that contains the social accounts, AHSD logo and menu in mobile mode 
              include("includes/ADHD_mobileNavigationHeader.php"); ?>
        
        <!-- DIV containing the main content -->  
        <div id="outerMainContent"> 
        	<div id="innerMainContent">
            	<!-- @@@ indexInnerBodyLeft_1 is the main wihte text box with shadowing
            	- the box we want to scale for this page is mainContentLeftColumn
				(by overriding the css style below) -->

				<!-- Width of search results div element -->

                <div 	id="innerMainContentLeftColumn"
						style="
							/* min-width: 80%; */ "
					>
					<div id="indexInnerBodyLeft_1" style="
						/* OVERRIDE  to accommodate more text/ search results */
						width: 100%;
						/* max-width: 1250px; /* was 805 */
						background-color: #FFF; /* white */
						position: relative;
						height: auto;
						/*
						padding-left: 30;
						padding-bottom: 30;
						*/
						float: center; /* changed from left */
						
						-webkit-box-shadow: 0 1px 35px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
						-moz-box-shadow: 0 1px 35px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
						box-shadow: 0 1px 35px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
					">
						<!-- DETAILED SEARCH -->
						<!-- no href link specified here therefore this is the detailed search content-->
						<div id="detailed" style="display: block;">
							<h1 id="headerTitle">
							Search | 
							<a 	style="font-size: 15px; font-weight: 550;" 
								href="ADHD_searchKeyword.php" ">Keyword Search</a> | 
								<a 	style="font-size: 15px; font-weight: 550;" 
								href="ADHD_searchTitleList.php" ">Title List</a></h1>
							<p>
								<?php include 'text/src_search.txt'; ?>

								<div style="width:85%; margin: 0 auto;">

									<form 	name="search" 
											class="search" 
											method="post" 
											action="ADHD_searchResults.php">

										<?php 
                                                                                    if($UNIT_TEST){
                                                                                            include('./test/test_search_v01.php');
                                                                                    }
										?>

										<label for="title" id="searchLabels"> Enter the Title: </label>
										<input type="text" name="title" id="title" /><br/>
										
										<label for="year" id="searchLabels"> Enter the Year: </label>
										<input type="number" name="year" size="4" /><br/>
										
										<label for="authorFamilyName" id="searchLabels"> 
										Author's Family Name: </label>
										<input type="text" name="authorFamilyName" size="30" /><br/>
										
										<label for="authorGivenName" id="searchLabels"> 
										Author's Given Name: </label>
										<input type="text" name="authorGivenName" size="30" /><br/>
										
										<label for="publisherName" id="searchLabels"> Enter the Publisher: </label>
										<input type="text" name="publisherName" size="30" /><br/>
										
										<label for="country" id="searchLabels"> Select the Country: </label>
										<select name="country" 
												id="country" 
												onchange="ChooseCountry(this)">
											<option value="All" selected="selected">All</option>
											<option value="Australia">Australia</option>
											<option value="New Zealand">New Zealand</option>
											<option value="Others">Others</option>

										<br>
										<input 	type="hidden" 
												name="getCountry" 
												id="getCountry" 
												value="All" readonly>
										<br>
										<label for="searchopt" id="searchLabels"> Select Search Option:</label>
										<select name="searchopt" id="searchopt" >
											<!-- order reversed to create a default value -->
											<option>Any Field Matches</option>
											<option>All Fields Match</option>
											
										</select>
										<br>


										<!-- SORTING -->
										<label for="searchopt" id="searchLabels"> Sort the Results By: 
										</label>
										<select class="sel2" name="sort" id="sort" >
											<option value="title" class="rad1" name="sort" 
													id="rdltitle">
												Title
											</option>
											<option value="year" class="rad1" name="sort" 
													id="rdlYear">
												Year
											</option>
											<option value="publisherName" class="rad1" name="sort" 
													id="rdlpublisher">
												Publisher
											</option>
											<option value="country" class="rad1" name="sort" 
													id="rdlcountry">
												Country
											</option>
											<option value="licenceList" class="rad1" name="sort" 
													id="rdllicence">
												Licence
											</option>
											<option value="familyName" class="rad1" name="sort" 
													id="rdlLastName">
												Author Family Name
											</option>
										</select><br><br>

										<label id="searchLabels"> </label>
										<!-- no label for the submit button ? -->
										<input 	type="submit" 
												id="searchButton" 
												value="SEARCH"
												name="search"> 
										&nbsp;&nbsp; 
										<input type="reset" id="resetButton" value="RESET">
									</form>
									
									<script type='text/javascript'>
										/* called with onchange event handler */
										function ChooseCountry(data) {
											document.getElementById ("getCountry").value = data.value;
										}
									</script>
								</div>
							</p>
						</div>
					</div>
				</div>
				
				<!-- @@@ removed from this page so as to fit in more search columns 
				therefore need to widen the percentage in layout.css (but havnt yet worked out how to widen the element )-->

				<?php #include("includes/ADHD_blog.php"); //File that contains the DIV of the details of the blog entries ?>
				<?php #include("includes/ADHD_twitter.php"); //File that contains the DIV of the details of the twitter entries ?>
				
			</div>
		</div>
	
		<div id="outerFooterContent"> <!--style="
			background-image: draft_images/BGRamp2.jpg;
		"> -->
			<div id="innerFooterContent">
				<?php include("includes/ADHD_footerIndex.php"); ?>
			</div>
		
		</div>
		
		<div id="outerFooterDeclarations">
			<div id="innerFooterDeclarations">
				<span id="infoFooterCopyright"><?php include("includes/ADHD_copyright.php"); 
				//File that contains the copyright notice ... the copyright year is incremented automatically 
				?></span>
			</div>
		</div>
	</div>
	
	<!-- Support for place holders for legacy browsers (DO NOT MOVE) -->
    <script src="../script/placeholders.min.js"></script>
</body>
</html>