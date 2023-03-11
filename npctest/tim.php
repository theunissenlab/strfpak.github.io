<?php

// global include: connect to db and get important basic info about user prefs
include_once "./npc.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<meta name="description" content="The Neural Prediction Challenge">
<meta name="keywords" content="">
<meta name="author" content="root">
<link rel="stylesheet" type="text/css" href="andreas02.css" media="screen,projection" title="andreas02 (screen)">
<link rel="stylesheet" type="text/css" href="print.css" media="print"><title>Neural Prediction</title></head>

<body>
<div id="toptabs">
<p>Sites:
<a class="toptab" href="http://strfpak.berkeley.edu/">STRFPak</a><span class="hide"> | </span>
<a class="activetoptab" href="index.php">Challenge</a><span class="hide"> | </span>
</p></div>

<div id="container">
<div id="logo">
</div>

<div id="navitabs">
<h2 class="hide">Site menu:</h2>
<a class="navitab" href="index.php">Challenge</a><span class="hide"> | </span>
<a class="navitab" href="rul.php">Rules</a><span class="hide"> | </span>
<a class="activenavitab" href="tim.php">Data</a><span class="hide"> | </span>
<a class="navitab" href="faq.php">FAQ</a><span class="hide"> | </span>
<a class="navitab" href="con.php">Contact</a><span class="hide"> | </span>
</div>

<div id="desc">
</div>
  
<div id="main">
<h3>Data Distribution and Timeline</h3>

<p>Please read the <a href="rul.php">contest rules</a> before proceeding further. To enter the contest (and acquire the data), please see the <a href="con.php">contact</a> page.

</p><p>We will start to distribute data on <b>December 1, 2005</b>. If you <a href="con.php">email us</a> before then we will add your name to the list and will contact you when the data are available.</p>

<p>Predictions will be evaluated continuously as they are submitted.</p>

</div>

<div id="sidebar">

<?php

if (""==$userid) {
   echo("<h4>Log in here</h4>\n");
   if (""!=$errormsg) {
     echo("<p><b><font color=\"#CC0000\">$errormsg</font></b></p>\n");
   }
   echo("<p>\n");
   echo("<FORM ACTION=\"status.php\" METHOD=POST>\n");
   echo("User ID:<br>\n");
   echo("<INPUT TYPE=TEXT size=12 NAME=\"userid\"><br>\n");
   echo("Password:<br>\n");
   echo("<INPUT TYPE=PASSWORD size=12 NAME=\"passwd\"><br>\n");
   echo("<INPUT TYPE=SUBMIT VALUE=\"GO\">\n");
   echo("</FORM>\n");
   echo("</p>\n");
   echo("<p><a href=\"newaccount.php\">Sign up for an account</a></p>\n");
} else {
   echo("<h4>Logged in as $userid</h4>\n");
   echo("<p><a href=\"status.php\">Go to data!</a></p>\n");
   echo("<p><a href=\"index.php?logout=1\">Log out</a></p>\n");
}
?>

<hr>
<h4>News:</h4>
<p>The new web server is up! After you join the challenge you can download
datasets and submit your predictions directly!</p>
<hr>

<h4>Links out:</h4>
<a class="sidelink" href="http://www.neurotree.org/">Neurotree</a><span class="hide"> | </span>
</p>

<br>
<p>This project is supported by the NIH Human Brain Project.</p>

<br>
<p>Site v. 2.0 (March 20, 2006)</p>

</div>
    
<div id="footer">
Copyright 2006 UC Regents.
</div>

</div>
</body></html>
