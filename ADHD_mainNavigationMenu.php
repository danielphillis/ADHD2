<div id="innerHeader" style="background: white;">
    <!-- DIV containing the AHSD logo -->
    <div id="innerHeaderLogo">
        <a href="index.php">
            <img src="../images/ADHD/ADHD_banner.jpg" class="headerLogo"></a>
    </div>
    <!-- DIV containing the ADHD logo and menu (excl. mobile) -->
    <div id="innerHeaderMenu">
        <ul id="links">

            <li><a href="index.php"
                    <?php if ($currentPage=="HOME") echo "style=\"color:#6bb8cb;\""; ?>>
                    HOME</a></li>

            <li><a href="ADHD_newEntry.php"
                    <?php if ($currentPage=="SUBMISSIONS") echo "style=\"color:#6bb8cb;\""; ?>>
                    CONTRIBUTE</a></li>

            <li><a href="ADHD_searchTitleList.php"
                    <?php if ($currentPage=="SEARCH") echo "style=\"color:#6bb8cb;\""; ?>>
                    SEARCH</a></li>

            <li><a href="ADHD_licences.php"
                    <?php if ($currentPage=="LICENCES") echo "style=\"color:#6bb8cb;\""; ?>>
                    LICENSES & IP</a></li>

            <li><a href="ADHD_ourTeam.php"
                    <?php if ($currentPage=="OURTEAM") echo "style=\"color:#6bb8cb;\""; ?>>
                    OUR TEAM</a></li>

            <li><a href="ADHD_faq.php"
                    <?php if ($currentPage=="FAQ") echo "style=\"color:#6bb8cb;\""; ?>>
                    FAQ</a></li>

            <li><a href="#contactUs" style="border: none;" >
                    CONTACT</a></li>

        </ul>

        <!-- Hide navigation for small screens compatible with IE8 and lower -->
        <!--[if lt IE 9]>
        <div id="navTagHide">
        <![endif]-->
        <nav id="mainNavigation">
            <ul>
                <li><a href="#"></a>
                    <ul>
                        <li><a href="index.php"
                                <?php if ($currentPage=="HOME") echo "style=\"color:#6bb8cb;\""; ?>>
                                HOME</a></li>

                        <!-- NEW CODE -->
                        <li><a href="ADHD_list.php"
                                <?php if ($currentPage=="LIST") echo "style=\"color:#6bb8cb;\""; ?>>
                                LIST SOFTWARE</a></li>

                        <li><a href="ADHD_newEntry.php"
                                <?php if ($currentPage=="CONTRIBUTE") echo "style=\"color:#6bb8cb;\""; ?>>
                                CONTRIBUTE</a></li>
                        <li><a href="ADHD_search.php"
                                <?php if ($currentPage=="SEARCH") echo "style=\"color:red\""; ?>>
                                SEARCH</a></li>
                        <li><a href="ADHD_licences.php"
                                <?php if ($currentPage=="LICENCES") echo "style=\"color:#6bb8cb;\""; ?>>
                                IP/LICENSES</a></li>
                        <li><a href="ADHD_ourTeam.php"
                                <?php if ($currentPage=="OURTEAM") echo "style=\"color:#6bb8cb;\""; ?>>
                                OUR TEAM</a></li>
                        <li><a href="ADHD_faq.php"
                                <?php if ($currentPage=="FAQ") echo "style=\"
								color:#6bb8cb;\""; ?>>
                                FAQ</a></li>
                        <li><a href="#contactUs" style="border: none;" >
                                CONTACT US</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!--[if lt IE 9]>
        </div>
        <![endif]-->
    </div>
</div>