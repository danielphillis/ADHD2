<!-- code last augmented by daniel phillis for Flinders University 2017
email: daniel.phillis@gmail.com
@@@ symbol indicates recent changes, acting as bookmarks
@@@Sorting by form parm was not working

-->

<?php
	$currentPage="SEARCH KEYWORD"; //@@@
    
    global $useTables;
    $useTables = 0;
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
    <title>Search by KEYWORD</title>
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
            	
            	<!-- @@@ indexInnerBodyLeft_1 is the main wihte text box with shadowing 

            	- the box we want to scale for this page is mainContentLeftColumn
				(by overriding the css style below) -->

				<!-- Width of search results div element -->
				<div 	id="innerMainContentLeftColumn" 
						style="min-width: 80%;">
				
					<div id="indexInnerBodyLeft_1" style="
						/* OVERRIDE  to accommodate more text/ search results */
						width: 100%;
						max-width: 1250px; /* was 805 */
						background-color: #FFF; /* white */
						position: relative;
						height: auto;
						float: center; /* changed from left */
						-webkit-box-shadow: 0 1px 35px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
						-moz-box-shadow: 0 1px 35px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
						box-shadow: 0 1px 35px rgba(0, 0, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.1) inset;
					}">
						<div id="listDatabaseTitles" 
							style="min-width:	80%;">
						
						<!-- removed 'style="display: none;"' -->

							<h1 id="headerTitle">
								<a style="
										font-size: 15px; 
										font-weight: 550;" 
									href="ADHD_search.php" 
									">Search</a> | Keyword Search</a> | 
							<a 	href="ADHD_searchTitleList.php" 
								style="
										font-size: 15px; 
										font-weight: 550;" >Title List</a>
							</h1>
							<p>	
                                                        <?php include 'text/src_keywordSearch.txt';
                                                        # external text file for describing the
                                                        # functionality of the keyword search
                                                        ?>
                                                    <div style="width:85%; margin: 0 auto;">
						 			
                                                    <!-- FORM don't change the class name -->
                                                    <form 	name="SEARCH_TITLE"
                                                                class="search"
                                                                method="post"
                                                                action="ADHD_searchResultsKeyword.php"> 
                                        <!-- was version 8 -->
                                        <label for="keyword" id="searchLabels"> Search By Keyword: </label>
                                        <input type="text" name="keyword" id="keyword"><br>

                                        <label for="searchopt" id="searchLabels"> Sort the Results By: </label>

                                        <!--  	the form posts 2 global variables - defined by the name attribute 
                                                        1. keyword - (was title of the software to search for)
                                                        @@@ but we really want to be searching for any keyword 

                                                        2. sort - the parm to sort results by
                                                        all options defined below have name = sort

                                                        the var $_POST['sort'] must be referenced in searchResultsKeyword.php file.-->

                                        <select class="sel2" name="sort" id="sort">
                                                <option value="title" class="rad1" name="sort" id="rdltitle" value="title" >Title</option>
                                                <option value="year" class="rad1" name="sort" id="rdlYear" value="year" >Year
                                                </option>
                                                <option value="publisherName" class="rad1" name="sort" id="rdlpublisher" value="publisherName" >Publisher</option>
                                                <option value="country" class="rad1" name="sort" id="rdlcountry" value="country" >Country</option>
                                                <option value="licenceList" class="rad1" name="sort" id="rdllicence" value="licenceList" >Licence</option>
                                                <option value="familyName" class="rad1" name="sort" id="rdlLastName" value="familyName" >Author Family Name</option>
                                        </select><br/><br/> 

                                        <label id="searchLabels"> </label>
                                        <br><br>

                                        <!-- recall the 'name' 
                                                TAG	is what the corresponding php file 
                                                refers to - we test this var to see if 
                                                it is ok to read other specific input values-->

                                        <input 	type="submit" id="searchButton" 
                                                        value="SEARCH"
                                                        name="keywordSearch">
                                        <input type="Reset" id="resetButton" value="RESET">
                                        <br><br>
                                        </form>
                                        <script type='text/javascript'>
                                                /*
                                                function ChooseCountry(data) {
                                                        document.getElementById ("getCountry").value = data.value;
                                                }
                                                */
                                        </script>
                                        </div></div>
                                        </div>
                                        </p>
                                        </div>
                                        </div>
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
				//File that contains the copyright notice ... the copyright year is incremented automatically ?></span>
			</div>
		</div>
	</div>
	
	<!-- Support for place holders for legacy browsers (DO NOT MOVE) -->
    <script src="../script/placeholders.min.js"></script>
</body>
</html>