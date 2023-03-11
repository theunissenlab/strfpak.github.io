<?php
// global include: connect to db and get important basic info about user prefs
include_once "./npc.php";

$refpage=$_GET['refpage'];
$action=$_GET['action'];
$target=$_GET['target'];
$bkmk=$_GET['bkmk'];

if (3==$action) {
  // don't do anything yet.  confirm delete first.

} elseif (0!=$action && $target>0) {
  
  if (1==$action) {
    // check to make sure user is allowed to do this
    $sql="SELECT userid FROM nPredSet WHERE id=$target";
    $secdata=mysql_query($sql);
    if ($row=mysql_fetch_array($secdata)){
      if ($userid==$row["userid"] || $seclevel>5) {
        $sql="UPDATE nPredSet SET privateflag=1 WHERE id=$target";
        mysql_query($sql);
      }
    }
  } elseif (2==$action) {
    // check to make sure user is allowed to do this
    $sql="SELECT userid FROM nPredSet WHERE id=$target";
    $secdata=mysql_query($sql);
    if ($row=mysql_fetch_array($secdata)){
      if ($userid==$row["userid"] || $seclevel>5) {
        $sql="UPDATE nPredSet SET privateflag=0 WHERE id=$target";
        mysql_query($sql);
      }
    }
  } elseif (4==$action) {
    // check to make sure user is allowed to do this
    $sql="SELECT userid FROM nPredSet WHERE id=$target";
    $secdata=mysql_query($sql);
    if ($row=mysql_fetch_array($secdata)){
      if ($userid==$row["userid"] || $seclevel>5) {
        $sql="UPDATE nPredSet SET deleteflag=1 WHERE id=$target";
        mysql_query($sql);
      }
    }
  }
  
  if (""==$refpage) {
    header("Location: status.php");
    exit;                 /* Make sure that code below does not execute */
  } else {
    
    // update referring url to reflect lastest action
    $turl = $refpage;
    $turl = ereg_replace("&lastaction=[0-9]+","",$turl);
    $turl = ereg_replace("&action=[0-9]+","",$turl);
    $turl = ereg_replace("&target=[0-9]+","",$turl);
    
    if ("" != $bkmk) {
      $bkmk="#" . $bkmk;
    } else {
      $bkmk="";
    }
    if (""==strstr($turl,"?")) {
      $turl=$turl . "?dummy=0";
    }
    
    header("Location: " . $turl . 
           "&action=0&lastaction=$action&target=$target$bkmk");
    exit;                 /* Make sure that code below does not execute */
  }
}
?>
<HTML>
<HEAD>
<TITLE>Confirm</TITLE>
<link rel="stylesheet" type="text/css" href="andreas_mod_svd.css" media="screen,projection" title="andreas02 (screen)">
<link rel="stylesheet" type="text/css" href="print.css" media="print"><title>Neural Prediction</title>
</HEAD>
<BODY bgcolor="#FFFFFF">
<div id="main">
<?php

if (3==$action) {
  $sql="SELECT * FROM nPredSet WHERE id=$target";
  $deldata=mysql_query($sql);
  if ($row=mysql_fetch_array($deldata)){
    
    $dataname=$row["algorithm"] . " ver " . $row["version"];
    
    $delurl="./npcaction.php?refpage=$refpage&action=4&target=$target";
    echo("<p>WARNING: This action cannot be undone.</p>\n");
    echo("<p>Confirm: <a href=\"$delurl\">Delete predictions for algorithm <b>$dataname</b>?</a></p>\n");
  } else {
    echo("<p>ERROR: Prediction set not found.</p>\n");
  }
  echo("<p><a href=\"$refpage\">Cancel</a></p>\n");
} else {
  echo("<p>You shouldn't be here</p>");
}

?>
</div>
</BODY>
</HTML>
