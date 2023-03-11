<?
/**
 * UserEdit.php
 *
 * This page is for users to edit their account information
 * such as their password, email address, etc. Their
 * usernames can not be edited. When changing their
 * password, they must first confirm their current password.
 *
 * Using code borrowed from: Jpmaster77 a.k.a. The Grandmaster of C++ (GMC)
 * Last Updated: August 26, 2004
 * modified SVD 2006-02-11
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
 * User has submitted form without errors and user's
 * account has been edited successfully.
 */
if(isset($_SESSION['useredit'])){
   unset($_SESSION['useredit']);
   
   echo "<h3>Success!</h3>";
   echo "<p><b>$session->username</b>, your account has been successfully updated. "
       ."<a href=\"status.php\">NPC status page</a>.</p>";
}
else{
?>

<?
/**
 * If user is not logged in, then do not display anything.
 * If user is logged in, then display the form to edit
 * account information, with the current email address
 * already in the field.
 */
if($session->logged_in){
?>

<h3>User Account Edit : <? echo $session->username; ?></h3>
<?
if($form->num_errors > 0){
   echo "<td><font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(s) found</font></td>";
}
?>
<p>
<form action="process.php" method="POST">
<table border="0" cellspacing="0" cellpadding="3">
<tr>
<td>Current Password:</td>
<td><input type="password" name="curpass" size=15 maxlength="30" value="
<?echo $form->value("curpass"); ?>"></td>
<td><? echo $form->error("curpass"); ?></td>
</tr>
<tr>
<td>New Password:</td>
<td><input type="password" name="newpass" size=15 maxlength="30" value="
<? echo $form->value("newpass"); ?>"></td>
<td><? echo $form->error("newpass"); ?></td>
</tr>
<tr>
<td>Full name:</td>
<td><input type="text" name="fullname" size=50 maxlength="50" value="
<?
if($form->value("fullname") == ""){
   echo $session->userinfo['fullname'];
}else{
   echo $form->value("fullname");
}
?>">
</td>
<td><? echo $form->error("fullname"); ?></td>
</tr>
<tr>
<td>Institution:</td>
<td><input type="text" name="institution" size=50 maxlength="50" value="
<?
if($form->value("institution") == ""){
   echo $session->userinfo['institution'];
}else{
   echo $form->value("institution");
}
?>">
</td>
<td><? echo $form->error("institution"); ?></td>
</tr>
<tr>
<td>Advisor name:</td>
<td><input type="text" name="advisorname" size=50 maxlength="50" value="
<?
if($form->value("advisorname") == ""){
   echo $session->userinfo['advisorname'];
}else{
   echo $form->value("advisorname");
}
?>">
</td>
<td><? echo $form->error("advisorname"); ?></td>
</tr>
<tr>
<td>Show name:</td><td><INPUT TYPE=CHECKBOX NAME="pubdetails" value=1
<?
if($form->value("pubdetails") == "" && $session->userinfo['pubdetails']=="1"){
  echo(" checked");
} elseif (1==$form->value("pubdetails")) {
  echo(" checked");
}
?>
> (make your name and institution publicly visible)</td></tr>
<tr>
<td>Email:</td>
<td><input type="text" name="email" size=50 maxlength="50" value="
<?
if($form->value("email") == ""){
   echo $session->userinfo['email'];
}else{
   echo $form->value("email");
}
?>">
</td>
<td><? echo $form->error("email"); ?></td>
</tr>
<td>NPC plan:</td>
<td><textarea name="plan" rows=5 cols=50>
<?
if($form->value("plan") == ""){
   echo $session->userinfo['justification'];
}else{
   echo $form->value("plan");
}
?>
</textarea></td>
<td><? echo $form->error("plan"); ?></td>
</tr>

<tr><td colspan="2" align="right">
<input type="hidden" name="subedit" value="1">
<input type="submit" value="Edit Account"></td></tr>
<tr><td colspan="2" align="left"><a href="status.php">Cancel</a></td></tr>
</table>
</form>
</p>
<?php
}
}
footer($userid);

?>


</div>
</body></html>
