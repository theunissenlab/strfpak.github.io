<?php
/*** NPC
downloaddata.php - list available files and send requested file.  check for privileges before sending anything, of course.
created 2005-12-06 - SVD
***/

// global include: connect to db and get important basic info about user prefs
include_once "./npc.php";

$datasetid=$_GET['datasetid'];
$fileid=$_GET['fileid'];

if ($fileid) {
  $sql="SELECT * FROM nFiles WHERE id=$fileid";
  $filedata=mysql_query($sql);
  
  if ($frow=mysql_fetch_array($filedata)){
    if ($frow["seclevel"]>$seclevel) {
      $errormsg="ERROR: permission denied";
    } else {
      // content-type depends on the file
      if (""==$frow["contenttype"]) {
        header('Content-type: application/octet-stream');
      } else {
        header('Content-type: '. $frow["contenttype"]);
      }
      // It will be called downloaded.pdf
      header('Content-Disposition: attachment; filename="' . 
             $frow["filename"] . '"');
      
      // load the file and send binary data out to client
      readfile($frow["path"] . $frow["filename"]);
      
      exit();
      
    }
  } else {
    $errormsg="ERROR: file not found";
  }

  
 }
 
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

npcheader(4);
?>

<div id="desc">
</div>
  
<div id="main">

<?php

if (""!=$errormsg) {
  echo("<b><font color=\"#CC0000\">$errormsg</font></b><br>\n");
}
if (""==$datasetid) {
  $datasetid=1;
}
$sql="SELECT * FROM nDataSet WHERE id=$datasetid";
$setdata=mysql_query($sql);
if ($row=mysql_fetch_array($setdata)){
  echo("<h4>Files associated with " . $row["dataname"] ." data set:</h4>");
}

$notavail=0;
$sql="SELECT * FROM nFiles WHERE datasetid=$datasetid AND category='dataset' order by filename";
$filedata=mysql_query($sql);
echo("<table>\n");
while ($frow=mysql_fetch_array($filedata)){
  $fileid=$frow["id"];
  $filename=$frow["filename"];
  echo("<tr><td>&nbsp;&nbsp;&nbsp;</td>\n");
  if ($seclevel>=$frow["seclevel"]) {
    echo("    <td valign=\"top\"><a href=\"downloaddata.php?userid=$userid&sessionid=$sessionid&datasetid=$datasetid&fileid=$fileid\">$filename</a></td>\n");
  } else {
    $notavail=1;
    echo("    <td valign=\"top\"><b>$filename**</b></td>\n");
  }
  echo("    <td>". $frow["comment"] . "</td>\n");
  echo("</tr>");
  
}
if ($notavail) {
  echo("<tr><td colspan=3><b>**</b> These files will be available when your account has been fully activated.</td></tr>\n");
}
echo("</table>\n");

footer($userid);

?>
</div>
</body></html>
