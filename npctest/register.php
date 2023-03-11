<?
/**
 * Register.php
 * 
 * Displays the registration form if the user needs to sign-up,
 * or lets the user know, if he's already logged in, that he
 * can't register another name.
 *
 * Written by: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 19, 2004
 */
include("npc.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<meta name="description" content="The Neural Prediction Challenge">
<meta name="keywords" content="">
<meta name="author" content="J.L. Gallant">
<link rel="stylesheet" type="text/css" href="andreas_mod_svd.css" media="screen,projection" title="andreas02 (screen)">
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

<?php
npcheader(7);
?>

<div id="desc">
</div>
  
<div id="main">

<?
/**
 * The user is already logged in, not allowed to register.
 */
if($session->logged_in){
   echo "<h1>Registered</h1>";
   echo "<p>We're sorry <b>$session->username</b>, but you've already registered. "
       ."<a href=\"index.php\">Main</a>.</p>";
}
/**
 * The user has submitted the registration form and the
 * results have been processed.
 */
else if(isset($_SESSION['regsuccess'])){
   /* Registration was successful */
   if($_SESSION['regsuccess']){
      echo "<h1>Registered!</h1>";
      echo "<p>Thank you <b>".$_SESSION['reguname']."</b>, your information has been added to the database, "
          ."you may now <a href=\"index.php\">log in</a>.</p>";
   }
   /* Registration failed */
   else{
      echo "<h1>Registration Failed</h1>";
      echo "<p>We're sorry, but an error has occurred and your registration for the username <b>".
           $_SESSION['reguname']."</b>, ".
           "could not be completed.<br>Please try again at a later time.</p>";
      echo "<p><a href=\"index.php\">NPC Home</a>.</p>";
   }
   unset($_SESSION['regsuccess']);
   unset($_SESSION['reguname']);
}
/**
 * The user has not filled out the registration form yet.
 * Below is the page with the sign-up form, the names
 * of the input fields are important and should not
 * be changed.
 */
else{
?>

<?
echo("<h3>$siteinfo - Registration</h3>\n");
if($form->num_errors > 0){
   echo "<p><font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(s) found</font></p>";
}
?>
<p>To register for NPC, please fill out the form below.  Aside from your user name, the other information you provide will not be made publicly available without your explicit consent (eg, by checking &quot;show name&quot; below).  We will use it to contact you and to learn about participants in the Challenge.</p>
<p>After completing this form, you will be given limited browsing access to the NPC site.  Once we have verfied your information, we will activate your account for downloading data sets and submitting preditions. This usually takes less than one business day.  Thanks for your patience!</p>

<form action="process.php" method="POST">
<table align="left" border="0" cellspacing="0" cellpadding="3">
<tr><td><b>Username:</b></td><td><input type="text" name="user" SIZE=15 maxlength="30" value="<? echo $form->value("user"); ?>">&nbsp;(Your public nickname)</td><td><? echo $form->error("user"); ?></td></tr>
<tr><td><b>Password:</b></td><td><input type="password" name="pass" SIZE=15 maxlength="30" value="<? echo $form->value("pass"); ?>"></td><td><? echo $form->error("pass"); ?></td></tr>
<tr><td><b>Full name:</b></td><td><input type="text" name="fullname" SIZE=50 maxlength="50" value="<? echo $form->value("fullname"); ?>"></td><td><? echo $form->error("fullname"); ?></td></tr>
<tr><td><b>Institution:</b></td><td><input type="text" name="institution" SIZE=50 maxlength="50" value="<? echo $form->value("institution"); ?>"></td><td><? echo $form->error("institution"); ?></td></tr>
<tr><td valign="top"><b>Advisor:</b></td><td><input type="text" name="advisorname" SIZE=50 maxlength="50" value="<? echo $form->value("advisorname"); ?>"><br>(The director of your lab, if not you.)</td><td><? echo $form->error("advisorname"); ?></td></tr>
<tr><td><b>Show&nbsp;name:</b></td><td><INPUT TYPE=CHECKBOX NAME="pubdetails" value=1
<?
  if (1==$form->value("pubdetails")) {
    echo(" checked");
  }
?>
> (make your full name and institution publicly visible)(<? echo $form->value("pubdetails"); ?>)</td></tr>

<tr><td><b>Email:</b></td><td><input type="text" name="email" SIZE=50 maxlength="50" value="<? echo $form->value("email"); ?>"></td><td><? echo $form->error("email"); ?></td></tr>
<tr><td valign="top"><b>NPC plan:</b></td><td colspan=2>Please *briefly* describe how you intend to use the prediction challenge data. You need not provide details of the algorithms you have in mind but should indicate the computational neuroscience problems that motivate your participation in the challenge.<br><textarea name="plan" rows=5 cols=50><? echo $form->value("plan"); ?></textarea>
</td><td><? echo $form->error("plan"); ?></td></tr>
<tr><td colspan="2" align="center">
<input type="hidden" name="subjoin" value="1">
<input type="submit" value="Join!">&nbsp;<a href="index.php">Cancel</a></td></tr>
</table>
</form>

<p>&nbsp;</p>
<?
}
footer($userid);

?>

</div>
</body></html>
