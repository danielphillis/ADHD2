<!-- Latest compiled and minified CSS -->

  <!-- navigation band was black
  now blue #0badde 
  
  * Rather than aligning the bottom of cells or boxes that  make up the navigational
    menus - a CSS property is added to the nav menu as a whole - padding-top to force the 
    text inside the menu boxes down toward alignment with the bottom of the main Digital 
    Heritage logo

  * the PNG version of the logo / main banner is much more 
    economical than the JPG version - possibly due to a efficient color pallette
    so this PNG is used in preference with the width / size controlled by width parm
    in the HTML img tag as a percentage
  -->

  <nav class="navbar navbar-inverse" 
  style="
      background-color: #0badde;
      /* no bacground required here */
    ">

  <!-- Background Color of Menu Bar--><!-- was #2593aa -->
  <div 	class="navbar-header" 
  style="	
      margin: 20;
      color: white;
  ">

  <!--
  <a  class="navbar-brand"
      style="
      background-color: #0baddf; ">
  -->
</div>
            <!-- Main Bannner 
            icluding the image as a list item luckily forces it to bein place in the nav bar
            rather than having to align it manually with CSS or tables
          -->
  <img  src="images/logos/digitalHeritageBanner.png" 
        width="40%"
        align="left"
        alt="Digital Heritage Banner PNG">

<!-- menu -->

<ul class="nav navbar-nav" 
    style="
    color: black;
    padding-top: 50px;
    background-color: #0badde; /* new sky blue */
    font-size: 1.05em;
    "
    .hover{
      color: red;
    }>


        <!-- no drop down required -->
        <li><a  href="index.php" 
          style="
          color: black;
          background-color: #0badde;
          height: 100
          vertical-align: bottom;
          font-weight: normal;
          font-size: 1.05em;
          ">
          HOME</a></li>

          <li class="dropdown">
            <a  class="dropdown-toggle" data-toggle="dropdown" 
            href="#" style="
            color: black;
            background-color: #0badde;
            font-weight: normal;
            font-size: 1.05em;
            ">

            CURRENT PROJECTS
            <span class="caret"></span></a>
            <ul class="dropdown-menu">

              <li>
              <!-- TEMP DOWN FOR DEVELOPMENT
                <a href="ADHD/ADHD_index.php" target="_blank">-->
                <a style ="
                  background-color: white;
                  color: grey; /* text */
                  

                "
                >
                ADH Database<br><i>(Undergoing Maintenance)</i>
              </a>
            </li>

            <li role="presentation" class="divider"></li>

            <li>
              <a href="http://csem.flinders.edu.au/thegoodstuff/comparch/index.php"
              target="_blank" >
              <!-- 
                <a style ="
                  background-color: #0badde;
                  background-color: #FFF; /* White */
                  color: black; /* text */
                ">
              -->
              Computer <br>
              Archaeology Lab
            </a>
          </li>

          <li role="presentation" class="divider"></li>

          <li>
            <!-- link -->
            <?php
              #echo '<a href="http://www.creativemicrocomputing.org" target="_blank">';
              #echo '<a href="#" target="_blank"';
            ?>
            <a style ="
                  background-color: #0badde;
                  background-color: #FFF; /* White */
                  color: grey; /* text */
                ">
            
            <?php
              echo 'Creative<br>Microcomputing<br><i>(Undergoing Maintenance)</i></a>';
              #echo 'Creative<br>Microcomputing</a>';
              ?>
          </li>
        </ul>
      </li>

      <li class="dropdown">
        <a class="dropdown-toggle" 
        data-toggle="dropdown" 
        href="#" 
        target="_blank" 
        style="
        color: black;
        background-color: #0badde;
        font-weight: normal;
        font-size: 1.05em;
        ">
        ARCHIVED PROJECTS
        <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <!-- link temp change with hacking 15/11/17 daniel phillis-->
          <li>
          <!-- <a href="http://creativemicrocomputing.org/memories/"> -->

              <!--<a  href="https://web.archive.org/web/20171114003002/http://creativemicrocomputing.org/memories/"-->
              <a href="https://web.archive.org/web/20170613185743/http://creativemicrocomputing.org/"
              target="_blank"
              style ="
                  background-color: #0badde;
                  background-color: #FFF; /* White */
                  /* color: grey; /* grey for disabled text, black for active text */
                  color: black;
              ">

            <?php 
              /* can simply remove # comment indicator to switch activation */
              
              # echo 'Microcomputing<br>+ Memory<br><i>(Undergoing Maintenance)</i></a>';
              echo 'Microcomputing<br>+ Memory</a>';
            ?>
          </li>

        <li role="presentation" class="divider"></li>

        <li>
        <a  href="http://www.ourdigitalheritage.org/archive/playitagain/" 
          <?php echo 'target="_blank" '; ?>
          style ="
                  background-color: #0badde;
                  background-color: #FFF; /* White */
                  color: black; /* text */
                ">
      Play It Again</a>
    </li>

    <li role="presentation" class="divider"></li>

    <li>
      <!-- link -->
      <a  href="http://www.tandfonline.com/doi/full/10.1080/13614576.2016.1251849"
          target="_blank"
          style ="
                  background-color: #0badde;
                  background-color: #FFF; /* White */
                  color: black; /* text */
                ">
      SLSA Disc<br>Imaging Pilot</a>
      </li>
      </ul>
    </li>
    <li class="dropdown">

    <a  class="dropdown-toggle" 
        data-toggle="dropdown" 
        href="#" 
        style=" 
          color: black;
          background-color: #0badde;
          font-weight: normal;
          font-size: 1.05em;
    ">
    HOSTED ARCHIVES
    <span class="caret"></span></a>
    <ul class="dropdown-menu">
    <li><a href="hostedArchives/beam/index.html" 
            target="_blank"
            style ="
                  background-color: #0badde;
                  background-color: #FFF; /* White */
                  color: black; /* text */
                ">

    Beam Software</a>
    </li>
    
    <li role="presentation" class="divider"></li>

    <li><a href="hostedArchives/melbourneHouse/index.html"
            target="_blank"
            style ="
                  background-color: #0badde;
                  background-color: #FFF; /* White */
                  color: black; /* text */
    ">
    Melbourne House</a>
    </li>
    
    <li role="presentation" class="divider"></li>

    <li><a href="hostedArchives/ratbag/index.html" 
            target="_blank"
            style ="
                  background-color: #0badde;
                  background-color: #FFF; /* White */
                  color: black; /* text */
            ">

     RatBag Games</a>
   </li>
   
   <li role="presentation" class="divider"></li>

   <li><a href="hostedArchives/ozScene/index.html"
   
          target="_blank"
          style ="
                  background-color: #0badde;
                  background-color: #FFF; /* White */
                  color: black;">

    OzScene Demos</a>
  </li>
</ul>

<!-- no drop down required -->
<li><a  href="people.php" 
        style="color: black;
        font-weight: normal;
        font-size: 1.05em;">

  PEOPLE</a></li>
</ul> 
</div>
</nav>