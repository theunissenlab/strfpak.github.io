<?php
/*** NPC
newaccount.php - sign up for new account
created 2005-12-05 - SVD -ripped off of neurotree newaccount
***/

// global include: connect to db and get important basic info about user prefs
include_once "./npc.php";

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
<TITLE>NPC - test mail</TITLE>
</HEAD>

<?php

$email="svd@umd.edu";
$from="svd@umd.edu";
mail($email,"Neural Prediction Challenge test mail",
     "This is a test email.",
      "From: $from\nX-Mailer: PHP/ . $phpversion()", "-f $from");

echo("<BODY bgcolor=\"$userbg\" text=\"$userfg\"" .
     " link=\"$linkfg\" vlink=\"$vlinkfg\" alink=\"$alinkfg\">");
echo("<P>$siteinfo - sent test email to $email from $from</p>\n");


footer("");
?>
</BODY>
</HTML>
