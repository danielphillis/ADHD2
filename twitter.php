<?php 
	// Used to determine whether the IE version is legacy 8-, if that's the case and since twitter timeline is not supported in IE 8-, then the DIV for the twitter timeline is not shown on the website
	if(preg_match('/(?i)msie [2-8]/',$_SERVER['HTTP_USER_AGENT'])) {
	}
	else {
		echo "<div id=\"indexInnerBodyRight_2\">".
				"<div id=\"twitterIframe\">".
					"<a class=\"twitter-timeline\" href=\"https://twitter.com/ourdigiheritage\" data-widget-id=\"606719721635864578\">Tweets by @ourdigiheritage</a>".
					"<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id))".
					"{js=d.createElement(s);js.id=id;js.src=p+\"://platform.twitter.com/widgets.js\";fjs.parentNode.insertBefore(js,fjs);}}(document,\"script\",\"twitter-wjs\");</script>".
				"</div>".
			"</div>";
	}
	echo "</div>"; // Closing of innerMainContentRightColumn DIV (this DIV is opened in the blog.php file)
?>
