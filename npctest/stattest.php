<?php

// global include: connect to db and get important basic info about user pref
include_once "./npc.php";

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

<?php

$refpage=rawurlencode($_SERVER['REQUEST_URI']);

// figure out what to display
$showdata=$_GET['showdata'];
$datasetid=$_GET['datasetid'];
$showuser=$_GET['showuser'];
$mypredsetid=$_GET['mypredsetid'];
//$=$_GET[''];

if (!$showdata) {
  $sql="SELECT id FROM nPredSet WHERE userid=\"$userid\"";
  $preddata=mysql_query($sql);
  if (mysql_num_rows($preddata)>00) {
    $showdata="preds";
  } elseif (isset($datasetid)) {
    $showdata="files";
  } else {
    $showdata="setlist";
  }
}
if (!isset($showuser)) {
  $showuser=$userid;
}

npcheader();

if ("setlist"==$showdata) {
  ?>
<p><B>Data sets</b><BR>
Following is a list of all the data sets  
currently available for use in the Neural Prediction Challenge.</p>
<?php
} elseif ("preds"==$showdata) {
  ?>
<p><B>Prediction results</b><BR>
Each row in the following table(s) summarize the performance of a single submission to the Neural Prediction Challenge. Click on &quot;details&quot; to view performance for individual cells.</p>

<?php
  
} elseif ("files"==$showdata) {
   ?>
<p><B>Prediction details</b><BR>
Each row in the following table shows the accuracy of predictions by an algorithm for individual cells in the data set.  &quot;Overall best CC&quot; indicates the performance of the current best algorithm for that cell.</p>
<?php
 }



if (isset($datasetid)){
  $sds=" AND nDataSet.id=$datasetid";
} else {
  $sds="";
}

$sql="SELECT nDataSet.*,count(nDataFile.id) FROM nDataSet,nDataFile".
  " WHERE nDataSet.id=nDataFile.datasetid $sds".
  " GROUP BY nDataSet.id ORDER BY id";
$setdata=mysql_query($sql);

while ($row=mysql_fetch_array($setdata)){
  $dsid=$row["id"];
  echo("<b>$dsid. " . $row["dataname"] . "</b>");
  echo(" - <a href=\"status.php?showdata=files&datasetid=$dsid\">List cells</a>\n");
  echo(" - <a href=\"status.php?showdata=preds&datasetid=$dsid&showuser=%\">All predictions</a>\n");
  echo(" - <a href=\"status.php?showdata=preds&datasetid=$dsid\">My predictions</a>\n");
  echo(" - <a href=\"downloaddata.php?datasetid=$dsid\">Download data set</a>\n");
  echo(" - <a href=\"uploadpreds.php?datasetid=$dsid\">Submit prediction!</a>\n");
  echo("<br>\n");
  
  if ("setlist"==$showdata) {
    echo("<table>\n");
    printf("<tr><td>&nbsp;&nbsp;&nbsp;</td><td>System:</td><td>%s</td></tr>\n",
           $row["system"]);
    printf("<tr><td></td><td valign=top>Description:&nbsp;</td><td>%s</td></tr>\n",$row["comments"]);
    printf("<tr><td></td><td>Added by:</td><td>%s</td></tr>\n",$row["addedby"]);
    echo("</table>\n");
    
  } elseif ("preds"==$showdata) {
    
    $sql="SELECT *,date_format(addeddate,'%Y-%m-%d %H:%i') as addeddate1".
      " FROM nPredSet".
      " WHERE datasetid=$dsid" .
      " AND (userid=\"$userid\" OR not(privateflag OR errorflag))".
      " AND userid like \"$showuser\"" .
      " ORDER BY id DESC";
    //echo("$sql<br>");
    $preddata=mysql_query($sql);
    echo("<table cellspacing=0 cellpadding=1>\n");
    echo("<tr><td>&nbsp;&nbsp;&nbsp;</td>\n");
    echo("    <td colspan=5>Summary of ");
    if ("%"==$showuser) {
      echo("all");
    } else {
      echo("<b>$showuser</b>'s");
    } 
    echo(" predictions for this data set:</td>\n");
    echo("<tr><td>&nbsp;&nbsp;&nbsp;</td>\n");
    echo("    <td bgcolor=\"#DDDDDD\"><b>User&nbsp;&nbsp;</b></td>\n");
    echo("    <td bgcolor=\"#DDDDDD\"><b>Submit date/time&nbsp;&nbsp;</b></td>\n");
    echo("    <td bgcolor=\"#DDDDDD\"><b>Algorithm&nbsp;&nbsp;</b></td>\n");
    echo("    <td bgcolor=\"#DDDDDD\"><b>Ver&nbsp;&nbsp;</b></td>\n");
    echo("    <td bgcolor=\"#DDDDDD\"><b>Eval date/time&nbsp;&nbsp;</b></td>\n");
    echo("    <td bgcolor=\"#DDDDDD\"><b>Mean CC&nbsp;&nbsp;</b></td>\n");
    echo("    <td bgcolor=\"#DDDDDD\"><b>&nbsp;&nbsp;</b></td>\n");
    echo("</tr>");
    while ($frow=mysql_fetch_array($preddata)){
      if (0!=$frow["errorflag"]) {
        $ff="<font color=\"#770000\">";
      } elseif (1==$frow["privateflag"]) {
        $ff="<font color=\"#77777\">";
      } else {
        $ff="";
      } 
      echo("<tr><td></td>\n");
      echo("    <td>$ff". $frow["userid"] . "&nbsp;&nbsp;</td>\n");
      echo("    <td>$ff". $frow["addeddate1"] . "</td>\n");
      echo("    <td>$ff". $frow["algorithm"] . "</td>\n");
      echo("    <td>$ff". $frow["version"] . "</td>\n");
      if (""==$frow["evaltime"]) {
        echo("    <td>$ff*pending*</td>\n");
      } else {
        echo("    <td>$ff". substr($frow["evaltime"],0,16) . "&nbsp;&nbsp;</td>\n");
      }
      echo("    <td>$ff". sprintf("%.3f",$frow["predxc"]) . "</td>\n");
      
      echo("    <td>$ff");
      echo("<a href=\"status.php?showdata=files&datasetid=$dsid&mypredsetid=".
           $frow["id"] . "\">details</a>\n");
      
      if ($seclevel>5 || $frow["userid"]==$userid) {
        if (1==$frow["privateflag"]) {
          echo("- <a href=\"npcaction.php?refpage=$refpage&action=2&target=".
               $frow["id"]."\">make public</a>");
        } else {
          echo("- <a href=\"npcaction.php?refpage=$refpage&action=1&target=".
               $frow["id"]."\">make private</a>");
        }
        echo(" - <a href=\"showlog.php?predsetid=" . $frow["id"] .
             "&refpage=$refpage\">log</a>");
        if (0!=$frow["errorflag"]) {
          echo(" <b>(ERROR)</b>");
        }
      }
      echo("</td>\n");
      echo("</tr>");
    }
    echo("</table>\n");
  } elseif ("files"==$showdata) {
    
    if (!isset($mypredsetid)){
      $sql="SELECT id FROM nPredSet WHERE userid like \"$showuser\"".
        " AND (userid=\"$userid\" OR not(privateflag))".
        " AND datasetid=$dsid ORDER BY predxc DESC";
      $preddata=mysql_query($sql);
      $prow=mysql_fetch_array($preddata);
      $mypredsetid=$prow["id"];
      if (""==$mypredsetid){
        $mypredsetid=-1;
      }
      $sbest=" best";
    } else {
      $sql="SELECT * FROM nPredSet WHERE id=$mypredsetid";
      $preddata=mysql_query($sql);
      $prow=mysql_fetch_array($preddata);
      echo("<table cellspacing=0 cellpadding=1>\n");
      printf("<tr><td>Algorithm:&nbsp;</td><td><b>%s v%.1f</b></td></tr>\n",
             $prow["algorithm"],$prow["version"]);
      printf("<tr><td>User:</td><td>%s</td></tr>\n",$prow["userid"]);
      printf("<tr><td>Notes:</td><td>%s</td</tr>\n",
             stringfilt($prow["comments"]));
      if (""==$prow["evaltime"]) {
        echo("<tr><td>Eval'd on:</td><td><b>*pending*</b></td>\n");
      } else {
        printf("<tr><td>Eval'd on:</td><td>%s (%s)</td></tr>\n",
               $prow["evaltime"],stringfilt($prow["results"]));
      }
      echo("</table>\n");
      $sbest="";
    }
    
    $sql="SELECT id FROM nPredSet WHERE privateflag=0".
      " AND datasetid=$dsid ORDER BY predxc DESC";
    $preddata=mysql_query($sql);
    $prow=mysql_fetch_array($preddata);
    $globalbestid=$prow["id"];
    if (""==$globalbestid) {
      $globalbestid=0;
    }
    
    $sql="SELECT nDataFile.*,nPred.predxc as mybest,".
      " nP2.predxc as globalbest".
      " FROM (nDataFile LEFT JOIN nPred".
      " ON nDataFile.id=nPred.datafileid AND nPred.predsetid=$mypredsetid)".
      " LEFT JOIN nPred nP2".
      " ON nDataFile.id=nP2.datafileid AND nP2.predsetid=$globalbestid".
      " WHERE nDataFile.datasetid=$dsid" .
      " ORDER BY nDataFile.cellid";
    //echo("$sql<br>");
    $filedata=mysql_query($sql);
    
    echo("<table cellspacing=0 cellpadding=1>\n");
    echo("<tr><td>&nbsp;&nbsp;&nbsp;</td>\n");
    echo("    <td bgcolor=\"#DDDDDD\"><b>Cell ID&nbsp;&nbsp;</b></td>\n");
    //echo("    <td bgcolor=\"#DDDDDD\"><b>X&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>\n");
    //echo("    <td bgcolor=\"#DDDDDD\"><b>Y&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>\n");
    //echo("    <td bgcolor=\"#DDDDDD\"><b>T (binsize)&nbsp;&nbsp;</b></td>\n");
    //echo("    <td bgcolor=\"#DDDDDD\"><b>RF size</b>&nbsp;&nbsp;</td>\n");
    echo("    <td bgcolor=\"#DDDDDD\"><b>My$sbest CC</b>&nbsp;&nbsp;</td>\n");
    echo("    <td bgcolor=\"#DDDDDD\"><b>Overall Best CC</b></td>\n");
    
    echo("</tr>");
    while ($frow=mysql_fetch_array($filedata)){
      echo("<tr><td></td>\n");
      echo("    <td>". $frow["cellid"] . "&nbsp;</td>\n");
      //echo("    <td>". $frow["stimx"] . "&nbsp;</td>\n");
      //echo("    <td>". $frow["stimy"] . "&nbsp;</td>\n");
      //echo("    <td>". $frow["stimt"]);
      //echo(" (". $frow["binsize"] . ")&nbsp;</td>\n");
      //echo("    <td>". $frow["crfdiameter"] . "</td>\n");
      if (""==$frow["mybest"]) {
        echo("    <td>N.A.</td>\n");
      } else {
        echo("    <td>". sprintf("%.3f",$frow["mybest"]) . "</td>\n");
      }
      echo("    <td>". sprintf("%.3f",$frow["globalbest"]) . "</td>\n");
      echo("</tr>");
    }
    echo("</table>\n");
  }
  
  // done with this fileset
  echo("<br>\n");
}
  

//    echo("$sql<br>");

footer($userid);

?>

</div>

<div id="footer">
Copyright © 2005 UC Regents; modified from a design by Andreas Viklund.
</div>

</div>
</body></html>
