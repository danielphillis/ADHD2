<!-- DIV containing the links to the social accounts  -->
<div  id="mobileSocialLinks"
      style ="
        background-color: #2593aa;
        color: black; /* text */
        ">
    <a class="youtube" href="https://www.youtube.com/user/ourdigiheritage" target="_blank">
      <img src="images/mobile/youtubeMobile.png">
    </a>
    <a class="facebook" href="https://www.facebook.com/ourdigitalheritage" target="_blank">
      <img src="images/mobile/facebookMobile.png">
    </a>
    <a class="twitter" href="https://twitter.com/ourdigiheritage" target="_blank">
      <img src="images/mobile/twitterMobile.png">
    </a>

  <?php //include 'includes/socialLinksHeader.php'; ?>
</div>
	
<!-- DIV containing the AHSD [mobile] banner logo 
(currently the same png file as the desktop version) 
and specialised mobile menu  -->

<div  id="mobileLogo"
      style ="
        background-color: #0badde; /* new sky blue*/
        color: black; /* text */
      ">
   	<a href="index.php">
    <img  src="images/logos/digitalHeritageBanner.png" 
          width="100%"
          height="auto"
          align="center"
          alt="Digital Heritage Banner PNG"
          class="headerLogo"/></a> 

</div>

<!-- some comments here are required -->
<?php /* force links to open in a new window */$newWindow = 'target="_blank" ';?>

<div  id="mobileMenu" 
      style ="
        /* background-color: #2593aa; /* old blue */
        background-color: white;
        color: black; /* text */
      ">
	
  <select id="mobileMenuSelect" onchange="window.location.href=this.value;">

<!-- ------------------------------------------------------------------------------------------------ -->
        
      	<!--<option value="#" >MAIN MENU</option>-->
       	<!-- <option value="index.php">Home -->
          
          <?php
            echo '<option value="index.php"';     
            if($currentPage=="HOME") {echo 'selected';}
            echo '>';
            echo 'HOME';
            ?>
        </option>

<!-- ------------------------------------------------------------------------------------------------ -->

<!-- AUSTRALASIAN DIGITAL HERITAGE DATABASE - temporarily down for development -->

        <!-- <option value ="ADHD/ADHD_index.php" -->
            <?php //echo $newWindow;?>

          <?php
            echo '<option value="ADHD/index.php"';
            
            if($currentPage=="ADHD") {
                echo 'selected';
            }?>
          >ADHD
        </option>
        
        
<!-- ------------------------------------------------------------------------------------------------ -->

        <!--COMPUTER ARCHAEOLOGY LAB this opton is alwaysavialable as it is an external site-->

        <option value="http://csem.flinders.edu.au/thegoodstuff/comparch/index.php" 
          <?php 
                echo $newWindow;
                //note double angled bracket
                ?>>
          Comp. Archaeology Lab
          </option>

<!-- ------------------------------------------------------------------------------------------------ -->
        
        <!-- CREATIVE MICRO COMPUTING -->

        <option value="http://creativemicrocomputing.org/"
        <option value="#"
          <?php 
              //if ($currentPage=="HOME") echo "selected"; ?>
              >
              Creative MicroComputing<br>
          </option>

<!-- ------------------------------------------------------------------------------------------------ -->

        <!-- MEMORIES -->
        <option 
          <?php 
              echo 'value="http://creativemicrocomputing.org/memories/ "';
              /*
                echo 'value="#"';
                echo $newWindow;
              */
              ?>>
                  MicroComputing and Memory
                  <br>
                  </option> -->

        <!--  note camelCase is not used in these URL's ! -->
<!-- ------------------------------------------------------------------------------------------------ -->

        <!-- PLAY IT AGAIN (External link therefore always avalable, no if statement required ) -->
        <option <?php
                //echo 'value="http://www.ourdigitalheritage.org/archive/playitagain/"';
                //absolute URL not neccessary
                echo 'value="archive/playitagain/" ';
                echo $newWindow;
                
                ?>>
          Play It Again</option>
        
<!-- ------------------------------------------------------------------------------------------------ -->
    
        <!-- STATE LIB of SOUTH AUSTRAILIA (SLSA) IMAGING PROJECT -->
        <!-- external likn therefore always available -->
        <option value="http://www.tandfonline.com/doi/full/10.1080/13614576.2016.1251849"

          <?php echo $newWindow; ?>>
              SLSA Disc Imaging</option>

<!-- ------------------------------------------------------------------------------------------------ -->

<!-- BEAM -->

        <option <?php 
                  //echo 'value="http://www.ourdigitalheritage.org/hostedArchives/beam/index.html"';
                  echo 'value="hostedArchives/beam/index.html" ';
                  echo $newWindow;
                  ?>>
          Archive: BEAM Software</option>

<!-- ------------------------------------------------------------------------------------------------ -->

<!-- MELBOURNE HOUSE -->

        <option <?php
                //echo 'value="http://www.ourdigitalheritage.org/hostedArchives/melbourneHouse/index.html" '
                echo 'value="hostedArchives/melbourneHouse/index.html" ';
                echo $newWindow;
                //if ($currentPage=="HOME") echo "selected"; 
                ?>>
          Archive: Melbourne House</option>

<!-- ------------------------------------------------------------------------------------------------ -->

<!-- RATBAG GAMES -->

        <option <?php
                  //echo 'value="http://www.ourdigitalheritage.org/hostedArchives/ratbag/index.html"';
                  echo 'value="hostedArchives/ratbag/index.html" ';
                  echo $newWindow;
                  ?>>
          Archive: Ratbag Games</option>

<!-- ------------------------------------------------------------------------------------------------ -->

<!-- OZ SCENE DEMOS -->

        <option 
                <?php
                    //echo 'value="http://www.ourdigitalheritage.org/hostedArchives/ozScene/index.html" ';
                    echo 'value="hostedArchives/ozScene/index.html" ';
                    echo $newWindow;
                    //if ($currentPage=="HOME") echo "selected"; 
                    ?>>
          Archive: OzScene Demos</option>

<!-- ------------------------------------------------------------------------------------------------ -->

<!-- PEOPLE -->

        <option value="people.php" 
          <?php if ($currentPage=="PEOPLE") echo "selected"; 
          ?>>
          <a href="people.php">People</a></option>
        
<!-- ------------------------------------------------------------------------------------------------ -->

<!-- CONTACT -->
<!-- -->
        <option value="#contactUs">Contact Us</option>
        <?php $currentPage="CONTACT" ?>
    </select>

</div>