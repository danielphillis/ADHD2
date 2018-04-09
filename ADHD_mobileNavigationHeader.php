<!-- DIV containing the links to the social accounts  -->
<div id="mobileSocialLinks">
   	<a class="youtube" href=""></a>
	<a class="facebook" href=""></a>
	<a class="twitter" href=""></a>
</div>
	
<!-- DIV containing the AHSD mobile logo and menu  -->
<div id="mobileLogo">
   	<a href="ADHD_index.php"><img src="images/mobile/mq2.jpg" class="headerLogo"/></a> 
</div>
           
<div id="mobileMenu">
	<select id="mobileMenuSelect" onchange="window.location.href=this.value;">
      	<!-- <option value="#">MAIN MENU</option> -->
       	
        <option value="index.php" <?php if ($currentPage=="HOME") echo "selected"; ?>>HOME</option>
        
        <option value="ADHD_newEntry.php" <?php if ($currentPage=="CONTRIBUTE") echo "selected"; ?>>CONTRIBUTE</option>
        
        <option value="ADHD_searchTitleList.php" <?php if ($currentPage=="SEARCH") echo "selected"; ?>>SEARCH</option>
        
        <option value="ADHD_licences.php" <?php if ($currentPage=="LICENCES") echo "selected"; ?>>LICENSES & IP</option>
        
        <option value="ADHD_faq.php" <?php if ($currentPage=="FAQ") echo "selected"; ?>>FAQ</option>
        
        <!-- ORDER CHANGED -->
        <option value="ADHD_ourTeam.php" <?php if ($currentPage=="OUR TEAM") echo "selected"; ?>>OUR TEAM</option>
        
        <option value="#contactUs">CONTACT US</option>
    </select>

</div>