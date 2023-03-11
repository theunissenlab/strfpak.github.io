<?php
/*** NPC
uploadpreds.php - process a submitted prediction
created 2005-12-06 - SVD
***/

// global include: connect to db and get important basic info about user prefs
include_once "./npc.php";

if ("GET"==$_SERVER['REQUEST_METHOD']) {
  // if just entering the page, parameters will appear in GET
  $datasetid=$_GET['datasetid'];
  $justuploaded=$_GET['justuploaded'];
  $errormsg=$_GET['errormsg'];
} elseif ("POST"==$_SERVER['REQUEST_METHOD']) {
  // if its actually a submission, they'll show up in POST
  $datasetid=$_POST['datasetid'];
  $justuploaded=$_POST['justuploaded'];
  $errormsg=$_POST['errormsg'];
  $submitting=$_POST['submitting'];
  $algorithm=$_POST['algorithm'];
  $version=$_POST['version'];
  $comments=$_POST['comments'];
  $privateflag=$_POST['privateflag'];
}

if ($seclevel>1 && ""==$_FILES['userfile']['name'] && $submitting) {
  $errormsg="ERROR: No file received";
} elseif ($seclevel>1 && ""!=$_FILES['userfile']['name']) {
  $errormsg="";
  
  if (!file_exists($predroot . "$userid")){
    mkdir($predroot . "$userid");
    chmod($predroot . "$userid", 0777);
  }
  $sql="SELECT max(id) as maxid FROM nPredSet";
  $oldpreddata=mysql_query($sql);
  if ($row=mysql_fetch_array($oldpreddata)){
    $nextrow=$row["maxid"]+1;
  } else {
    $nextrow=1;
  }
  $predpath=$predroot . $userid . "/";
  $predfile=sprintf("%s.%03d.%03d.pred.mat",$userid,$datasetid,$nextrow);
  
  $uploadfile=$predpath . $predfile;
  if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    
    $sql="SELECT count(id) as prevcount FROM nPredSet".
      " WHERE algorithm=\"".$algorithm . "\"".
      " AND datasetid=\"" . $datasetid . "\"";
      " AND userid=\"" . $userid . "\"";
    $versiondata=mysql_query($sql);
    if ($vrow=mysql_fetch_array($versiondata)){
      $thisver=$vrow["prevcount"]+1;
    } else {
      $thisver=1;
    }
    
    $formdata=array();
    $formdata["datasetid"]=$datasetid;
    $formdata["userid"]=$userid;
    $formdata["path"]=$predpath;
    $formdata["predfile"]=$predfile;
    $formdata["algorithm"]=$algorithm;
    //$formdata["version"]=$version;
    $formdata["version"]=$thisver;
    $formdata["comments"]=$comments;
    //$formdata["privateflag"]=$privateflag*1.0;
    $formdata["privateflag"]=0;
    $formdata["addedby"]=$userid;
    $formdata["addeddate"]=date("Y-m-d H:i:s");
    
    // actually save/update the data
    $predid=savedata("nPredSet",-1,$formdata);

    if (!is_numeric($predid)){
      $errormsg=$predid;
      $predid=-1;
      
    } else {
      // inserted ok

      // mark previous submissions private
      $sql="UPDATE nPredSet SET privateflag=1 WHERE algorithm=\"".
        $algorithm . "\" AND userid=\"" . $userid . "\" AND version<$version";
      mysql_query($sql);
      
      $errormsg="Prediction file received for processing ($predid).";
      header("Location: $refpage?errormsg=$errormsg&justuploaded=1&datasetid=$datasetid");
      exit;
    }
    
  } else {
    $errormsg="ERROR: File not received" . $_FILES['userfile']['tmp_name'];
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

if (""!=$_FILES['userfile']['name']) {
  echo 'Here is some debugging info:<br>\n';
  print_r($_FILES);
  echo '<br>\n';
}

if (""!=$errormsg) {
  echo("<b><font color=\"#CC0000\">$errormsg</font></b><br>\n");
}

if (1==$justuploaded) {

  echo("<p><a href=\"status.php?showdata=preds&datasetid=$datasetid\">See results.</a></p>\n");


} else {
?>
<h4>Submit predictions</h4>

   <?if ($seclevel<2) { ?>

 <p>Your account currently does not have permission to submit predictions, but should be active soon.  Please e-mail <?echo $admin_email;?> if you have any questions.</p> 

 <? } else { ?>

<p>Complete the fields below to make a submission.  
Please spend a moment of thought on these descriptors.  
They are designed to help you and other users organized your results.  
Each submission is tagged with an algorithm name (a short string) and a brief description.  
Repeated submissions for the same algorithm will automatically be given incremented version numbers, and only the latest version of each algorithm will be displayed publically.  
After validation is complete (with/without errors, etc), you can toggle the privacy status of your submissions if you would like to make an earlier version public.</p>

<p><b>TECHNICAL DETAILS:</b> Your predictions will be evaluated by an automated system. This system
requires strict adherence to the specifications in the README file
included with each data set. Typically, all predictions must be submitted in a Matlab-readable file, in a structure called <tt>prediction</tt>. Each entry <tt>n</tt> in the prediction structure should be defined as follows:<br><br>
<tt>prediction(n).cellid - alphanumeric string identifier for the neuron<br>
prediction(n).response - T_val x 1 vector, where T_val matches the length of the prediction data set, binned at the approprate sampling frequency.</tt><br><br>
Please double-check the specifications in the README file before submitting. Any errors will be reported in a log file to help you debug your problem.</p>
<p>Thanks for your submission to the NPC. And good luck!</p>


<?php
  // The data encoding type, enctype, MUST be specified as below
  echo("<form enctype=\"multipart/form-data\" action=\"uploadpreds.php\" method=\"POST\">");
  //MAX_FILE_SIZE must precede the file input field 
  echo("<input type=\"hidden\" name=\"userid\" value=\"$userid\" />\n");
  echo("<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"$sessionid\" />\n");
  echo("<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"1000000\" />\n");
  echo("<input type=\"hidden\" name=\"submitting\" value=\"1\" />\n");
  echo("<input type=\"hidden\" name=\"version\" value=\"0\" />\n");
  echo("<input type=\"hidden\" name=\"private\" value=\"0\" />\n");
  //Name of input element determines name in $_FILES array
  
  echo("<table>\n");
  echo("<tr><td>Data set:</td><td><select name=\"datasetid\" $ustr1>");
  $setdata=mysql_query("SELECT DISTINCT id,dataname" .
                       " FROM nDataSet ORDER BY id");
  while ( $row = mysql_fetch_array($setdata) ) {
    if ($datasetid == $row["id"]) {
      $sel=" selected";
    } else {
      $sel="";
    }
    echo(" <option value=" . $row["id"] . "$sel>" . $row["dataname"] . "</option>");
  }
  echo(" </select></td>\n");
  echo("<td></td></tr>\n");
  
  echo("<td>Algorithm:</td><td><INPUT TYPE=TEXT SIZE=10 NAME=\"algorithm\" value=\"$algorithm\"> (e.g., &quot;superSTRF&quot;)</td></tr>\n");
  //echo("<td>Version:</td><td><INPUT TYPE=TEXT SIZE=10 NAME=\"version\" value=\"$version\"> (e.g., &quot;1.1&quot;)</td></tr>\n");
  echo("<tr><td>Notes:</td><td colspan=3><textarea NAME=\"comments\" rows=5 cols=60>$comments</textarea><br>(e.g., &quot;The idea for this algorithm came to me after drinking five beers on a beach in Delaware.&quot;)</td></tr>\n");
  //echo("<tr><td>Private:</td><td><INPUT TYPE=CHECKBOX NAME=\"privateflag\" value=1");
  //if (1==$privateflag) {
  //  echo(" checked");
  //}
  //echo("></td>\n");
  echo("<tr><td>Send this file:</td><td><input name=\"userfile\" type=\"file\" /></td></tr>\n");
  echo("<tr><td></td><td><input type=\"submit\" value=\"Submit Prediction\" />");
  echo(" <a href=\"status.php?userid=$userid&$sessionid=$sessionid\">Cancel</a>");
  echo("</td></tr>\n");
  echo("</table>\n");
  echo("</form>\n");
}

} // close else associated with security check

footer($userid);

?>
</div>
</body></html>
