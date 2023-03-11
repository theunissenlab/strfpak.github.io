<?php
/*** NPC
account.php - user account settings
created 2005-12-06 - SVD
***/

// global include: connect to db and get important basic info about user prefs
include_once "./npc.php";

if (!isset($action)) {
  // default= no action
  $action=0;
}

if (1==$action) {
  // deactivate this account
  $sql="UPDATE gUserPrefs SET bad=1-bad WHERE id=$uid";
  mysql_query($sql);
}

$errormsg="";

// test to see if parameters have been entered correctly
if (2==$action && (""==$newpasswd || ""==$newuserid)) {
  $errormsg="ERROR: You must enter a user id and password.";
  $action=0;
}
if (2==$action && ($newpasswd!=$newpasswd2)) {
  $errormsg="ERROR: Passwords do not match.";
  $action=0;
}
if (2==$action && 0==$pid && (""==$fullname)) {
  $errormsg="ERROR: You must enter your name in the field provided.";
  $action=0;
}
if (2==$action && 0==$pid && (""==$email)) {
  $errormsg="ERROR: You must enter your email address in the field provided.";
  $action=0;
}
if (2==$action) {
  $sql="SELECT * FROM gUserPrefs WHERE userid=\"$userid\"";
  $userdata=mysql_query($sql);
  if (mysql_num_rows($userdata)>0) {
    $errormsg="ERROR: Account already exists with the requested userid.";
    $action=0;
  }
}

//$action=0;

// ok, passed the tests. now save posted info to people
if (2==$action) {
  $crypt_passwd=crypt($passwd,'NPCsecret');
   // create a new entry in the user table
  $sql="INSERT INTO gUserPrefs" .
    " (userid,password,fullname,institution,seclevel,email,justification)".
    " VALUES (\"" . tidystr($userid) . "\",\"" . 
    tidystr($crypt_passwd) . "\",\"" . tidystr($fullname) . "\",\"" . 
    tidystr($institution) . "\",1,\"" . tidystr($email) ."\",\"" . 
    tidystr($justification) . "\")";
  
  $result=mysql_query($sql);
  $uid=mysql_insert_id();
  
  if (mysql_errno()>0) {
    echo mysql_errno().": ".mysql_error()."<BR>";
    echo("$sql $result");
  } elseif (""!=$email) {
    $from="svd@umd.edu";
    mail($email,"Welcome to to the Neural Prediction Challenge!", 
         "$fullname-\n\n" .
         "Thanks for registering with the Neural Prediction Challenge!".
         " We look forward to your submissions.\n\n" .
         "This information is necessary for logging in:\n\n" .
         " userid: $userid\n password: $passwd\n\n" .
         "Please contact us at npc@xxx.edu if you have questions or comments.\n",
         "From: $from\nX-Mailer: PHP/ . $phpversion()", "-f $from");
  }
}





?>
<HTML>
<HEAD>
<style type="text/css">
<!--
A{text-decoration:none}
A:visited {text-decoration: none}
A:active {text-decoration: none}
A:hover {color: #AA0000; text-decoration: underline}
-->
</style>
<TITLE>NPC - Account settings</TITLE>
</HEAD>

<?php

if (!isset($showuser)) {
  $showuser=$userid;
}

echo("<BODY bgcolor=\"$userbg\" text=\"$userfg\"" .
     " link=\"$linkfg\" vlink=\"$vlinkfg\" alink=\"$alinkfg\">\n");

npcheader();




footer($userid);

?>
