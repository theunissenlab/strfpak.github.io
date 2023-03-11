<?php
/*** NPC
newaccount.php - sign up for new account
created 2005-12-05 - SVD -ripped off of neurotree newaccount
***/

$newaccount=1;

// global include: connect to db and get important basic info about user prefs
include_once "./npc.php";

if (1==$action) {
  // "delete" this account
  //$sql="UPDATE gUserPrefs SET bad=1-bad WHERE id=$uid";
  //mysql_query($sql);
}

$errormsg="";

// test to see if parameters have been entered correctly
if (2==$action && (""==$passwd || ""==$userid)) {
  $errormsg="ERROR: You must enter a user id and password.";
  $action=0;
}
if (2==$action && ($passwd!=$passwd2)) {
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
<TITLE>NPC - New Account</TITLE>
</HEAD>

<?php
echo("<BODY bgcolor=\"$userbg\" text=\"$userfg\"" .
     " link=\"$linkfg\" vlink=\"$vlinkfg\" alink=\"$alinkfg\">");
echo("<P>$siteinfo - New account sign-up</p>\n");

if ($uid>0) {
  echo("<p><b>Account created successfully!</b><br></p>\n");
  echo("<p>\n");
  echo("<b>Usage policy:</b> Please don't do anything stupid \n");
  echo("like waste a lot of our bandwidth and cpu power.</p>\n");
  echo("<p>\n");
  echo("Remember this info. To log in, you must know:<br>\n");
  echo("&nbsp;&nbsp;&nbsp;&nbsp;userid: $userid<br>\n");
  echo("&nbsp;&nbsp;&nbsp;&nbsp;password: ********<br>\n");
  echo("</p>\n");
  echo("<p>\n");
  echo("<a href=\"status.php?userid=$userid&passwd=$passwd&showdata=files\">");
  echo("On to the challenge!</a>");
  echo("</p>\n");
  
  footer($userid);
  exit;
}

if (""!=$errormsg) {
  echo("<p><b><font color=\"#CC0000\">$errormsg</font></b></p>\n");
}

// print out some basic instructions
echo("<table>\n");
echo("<tr><td><b>Instructions</b></td></tr>\n");
echo("<tr><td>Enter your information (completely) below. Questions?");
echo(" <a href=\"faq.php?userid=guest&passwd=guest\">See our FAQ</a>.");
echo("</td></tr>\n");
echo("<tr><td>&nbsp;</td></tr>\n");
echo("</table>\n");

echo("<FORM ACTION=\"newaccount.php\" METHOD=POST>\n");
echo("<input type=\"hidden\" name=\"action\" value=2>\n");  // do the edit
echo("<table>\n");
echo("<tr><td colspan=2><b>Account info</b></td></tr>\n");
echo("<tr><td>Login ID:</td><td><INPUT TYPE=TEXT NAME=\"userid\" VALUE=\"$userid\"></td></tr>\n");
echo("<tr><td>Password:</td><td colspan=2><INPUT TYPE=PASSWORD NAME=\"passwd\" VALUE=\"\"> (Warning: transmitted without encryption.)</td></tr>\n");
echo("<tr><td>Re-enter:</td><td><INPUT TYPE=PASSWORD NAME=\"passwd2\" VALUE=\"\"></td></tr>\n");
echo("<tr><td>Full name:</td><td><INPUT TYPE=TEXT SIZE=40 NAME=\"fullname\" value=\"$fullname\">");
 echo("</td></tr>\n");
echo("<tr><td>Institution:</td><td><INPUT TYPE=TEXT SIZE=40 NAME=\"institution\" value=\"$institution\">");
 echo("</td><td>(Where you work)</td></tr>\n");
echo("<tr><td>E-mail:</td><td><INPUT TYPE=TEXT SIZE=40 NAME=\"email\" VALUE=\"$email\"></td>\n");
echo("<td>(Your e-mail will not be distributed or made public. It's only for us to contact you about your account.)</td></tr>\n");
 echo("<tr><td>NPC plans:</td><td><textarea NAME=\"justification\" rows=5 cols=50>$justification</textarea></td>\n");
echo("<td>(Tell us briefly about why you're interested in NPC and what you plan to do with the data.)</td></tr>\n");



 echo("<tr><td></td><td><INPUT TYPE=SUBMIT NAME=\"Submit\" VALUE=\"Submit\">");
 echo(" <a href=\"index.php?userid=guest&passwd=guest\">Cancel</a>");
 
 echo("</td></tr>\n");
echo("</table>\n");
echo("</FORM>\n");

footer("");
?>
</BODY>
</HTML>
