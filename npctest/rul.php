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
<a class="navitab" href="index.php">Challenge</a><span class="hide"> | </span>
<a class="activenavitab" href="rul.php">Rules</a><span class="hide"> | </span>
<a class="navitab" href="faq.php">FAQ</a><span class="hide"> | </span>
<a class="navitab" href="con.php">Contact</a><span class="hide"> | </span>
</div>

<div id="desc">
</div>
  
<div id="main">
<h3>The rules (such as they are):</h3>

<p>1. This is an academic research project, not a contest in the
traditional sense. There are no prizes for the participants other than
the satisfaction of having contributed to a very difficult scientific
problem.</p>

<p>2. To ensure that we will be able to give each entry serious
consideration, this contest will be limited to those working in
computational neuroscience. For this reason these data will only be
distributed to qualified personnel at academic and research
institutions.</p>

<p>3. To enter the contest, please go back to the <a href="index.php">Challenge</a> 
page and sign up for an account!</p>

<p>4. After your application is accepted you will receive further instructions 
regarding how to obtain the challenge data sets.</p>

<p>5. Computational neural models are being developed and improved
all the time. Therefore, the contest is set up as a rolling project
with no defined end date. Entries will be processed and evaluated as
they are submitted.</p>

<p>6. Results of the prediction challenge will be posted anonymously
and/or in aggregate form. Results of predictions will be posted using
an anonymous nickname. Contestants will remain anonymous.</p>

<p>7. Contestants who submit extremely good predictions may be
contacted by us or by the laboratory that contributed the Challenge
data for further discussion about potential collaborations.</p>

<p>8. Challenge data may <b>not</b> be published without the 
express prior permission of the laboratory that contributed the original 
data (the <b>contributing laboratory</b>).
This restriction is being enforced for the protection of both you and
the contributing laboratory. Obviously, the contributing laboratory has
a vested interest in ensuring that their data are described accurately
and completely; it would be in no one's interest to publish
misinformation about the data themselves or the conditions under which
they were collected. In addition, some of the Challenge data may be
covered by regulations or other restrictions. Because of the complexity
of neural data we believe that the only way that accuracy can be
assured is if the contributing laboratory takes part in any publication
of their data. We leave it to you and the contributing laboratory to
negotiate the terms of publication. The contributing laboratory may
simply require pre-review of the paper, or they may request that you
include citation(s) to relevant paper(s), or in some cases they may
require a co-authorship. To ensure that this rule is followed, we have
intentionally ommitted many details about the data sets. We believe
that Challenge data are unpublishable without these details. Thus, if
you want to publish Challenge data you will need to contact the
contributing laboratory in order to obtain the necessary information.</p>

<p>9. We place no restrictions whatsoever on publication of theoretical
papers that describe a predictive model used in the Neural Prediction
Challenge, but which does <b>not</b> contain data from the Challenge.
Contestants may cite the prediction scores that the model achieves in
the Challenge, as long as this web site is cited and the data set that
was used in prediction is noted.</p>

<p>8. We work for the Regents of the University of California, and we 
therefore must include the following official UC disclaimer:</p>

<p>Copyright 2006, the Regents of the University of California (Regents).
All Rights Reserved. Permission to use, copy, and modify this software
and its documentation for educational, research, and not-for-profit
purposes, without fee and without a signed licensing agreement, is
hereby granted, provided that the above copyright notice, this
paragraph and the following two paragraphs appear in all copies and
modifications. Contact The Office of Technology Licensing, UC Berkeley,
2150 Shattuck Avenue, Suite 510, Berkeley, CA 94720-1620, (510)
643-7201, for commercial licensing opportunities.</p>

<p>IN NO EVENT SHALL REGENTS BE LIABLE TO ANY PARTY FOR DIRECT,
INDIRECT, SPECIAL, INCIDENTAL, OR CONSEQUENTIAL DAMAGES, INCLUDING 
LOST PROFITS, ARISING OUT OF THE USE OF THIS SOFTWARE AND ITS 
DOCUMENTATION, EVEN IF REGENTS HAS BEEN ADVISED OF THE POSSIBILITY 
OF SUCH DAMAGE.</p>

<p>REGENTS SPECIFICALLY DISCLAIMS ANY WARRANTIES, INCLUDING, 
BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY 
AND FITNESS FOR A PARTICULAR PURPOSE. THE SOFTWARE AND 
ACCOMPANYING DOCUMENTATION, IF ANY, PROVIDED HEREUNDER IS 
PROVIDED "AS IS". REGENTS HAS NO OBLIGATION
TO PROVIDE MAINTENANCE, SUPPORT, UPDATES, ENHANCEMENTS, OR
MODIFICATIONS.</p>

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
