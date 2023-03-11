<?php
/*** NPC
showlog.php - dump log for one data set evaluation.
created 2006-02-11 - SVD
***/

// global include: connect to db and get important basic info about user prefs
include_once "./npc.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<meta name="description" content="The Neural Prediction Challenge">
<meta name="keywords" content="">
<meta name="author" content="J.L. Gallant">
<link rel="stylesheet" type="text/css" href="andreas_mod_svd.css" media="screen,projection" title="andreas02 (screen)">
<link rel="stylesheet" type="text/css" href="print.css" media="print"><title>Confirm</title></head>

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
npcheader(6);  // "my submissions"
?>

<div id="desc">
</div>
  
<div id="main">

<?php

$predsetid=$_GET['predsetid'];
$refpage=$_GET['refpage'];

if ($predsetid) {
  $sql="SELECT * FROM nPredSet WHERE id=$predsetid";
  $predsetdata=mysql_query($sql);
  
  if ($row=mysql_fetch_array($predsetdata)){
    if ($row["userid"]==$userid || $seclevel>2) {
      
      // load the file and send binary data out to client
      if (""!=$row["logfile"]) {
        $array_of_lines   = file($row["path"] . $row["logfile"]);
        echo("<h4>Validation log for ". $row["userid"] . " / " . 
             $row["algorithm"] . " v" . $row["version"] . "</h4>\n");
        echo("<tt>");
        foreach ($array_of_lines as $line_num => $line) {
          echo $line . "<br>\n";
        }
        echo("</tt>\n");
        
      } else {
        $errormsg="ERROR: file not found.";
      }
      
    } else {
      $errormsg="ERROR: permission denied";
    }
  } else {
    $errormsg="ERROR: file not found";
  }

  
}

if (""!=$errormsg) {
  echo("<p><br><b><font color=\"#CC0000\">$errormsg</font></b></p>\n");
}

echo("<p><a href=\"$refpage\">Go back</a>.</p>\n");

footer($userid);

?>
</body>
</html>
