<?php

/*** NPC
npc.php - global include file that connects to db and sets up a few 
          commonly useful function for neurodb. hacked from neuro.php3
created 2005-12-05 - SVD
***/

// define some useful functions
function parsetimestamp ($timestamp) {

   $year=substr($timestamp,0,4);
   $month=substr($timestamp,4,2);
   $day=substr($timestamp,6,2);
   
   return $month . "-" . $day . "-" . $year;
}
function parsetimestamplong ($timestamp) {

   $year=substr($timestamp,0,4);
   $month=substr($timestamp,4,2);
   $day=substr($timestamp,6,2);
   $hour=substr($timestamp,8,2);
   $min=substr($timestamp,10,2);

   return $month . "-" . $day . " " . $hour . ":" . $min;
}
function sec2hrs ($sec) {
  
  if ($sec<0) {
    return "0:00:00";
  } else {
    $ss=floor($sec % 60);
    $mm=(floor($sec/60) % 60);
    $hh=floor($sec/3600);
    
    return sprintf("%d:%02d:%02d",$hh,$mm,$ss);
  }
}
function stringfilt($s) {
   
   $temp=explode(chr(10),$s);
   $temp=implode("<br>",$temp);
   $temp=explode(chr(9),$temp);
   $temp=implode("&nbsp&nbsp&nbsp;",$temp);
   //$temp=explode(" ",$temp);
   //$temp=implode("&nbsp;",$temp);
   
   return $temp;
}

function checkpwd($userid,$passwd) {
  
  $refpage=getenv("SCRIPT_NAME");
  $sql="SELECT * FROM gUserPrefs WHERE userid=\"$userid\"";
  $userdata=mysql_query($sql);
  if (""!=$userid && mysql_num_rows($userdata) > 0) {
    $row = mysql_fetch_array($userdata);
    $realpw=$row["password"];
    if ($passwd==$realpw) {
      // ok, password checks out
      $seclevel=$row["seclevel"];
      
    } elseif (crypt($passwd,'NPCsecret')==$realpw) {
      //want to reload with encrypted pw in url
      $refpage=getenv("SCRIPT_NAME");
      $fullname=$row["fullname"];
      if ($userid!="jlg" && $userid!="david" && $userid!="guest") {
        mail("svd@umd.edu", $userid . " just logged in", 
             $userid . " ($fullname) just logged in to NPC");
      }
      $sql="UPDATE gUserPrefs set logincount=logincount+1,lastlogin=now()".
        " WHERE userid=\"$userid\"";
      mysql_query($sql);
      header("Location: $refpage?userid=$userid&sessionid=$realpw");
      exit;
    } else {
      header("Location: index.php?logout=1&errormsg=Bad+userid+or+password");
      exit;
    }
    
  } else {
    header("Location: index.php?logout=1&errormsg=Bad+userid+or+password");
    exit;
  }
  
  return $seclevel;
}

function npcheader($extraline="") {
  
  GLOBAL $siteinfo;
  GLOBAL $userid;
  GLOBAL $sessionid;
  GLOBAL $seclevel;
  if (0) {
    echo("<a href=\"index.php\">$siteinfo</a>");
    echo(" - <a href=\"faq.php\">FAQ</a>\n");
    echo(" - <a href=\"status.php?showdata=setlist\">Data sets</a>");
    echo(" - <a href=\"status.php?showdata=preds\">My submissions</a>");
    echo(" - <a href=\"useredit.php\">My account</a>");
    if ($seclevel>=9) {
      echo(" - <a href=\"admin/admin.php\">Admin</a>");
    }
    echo("<br>\n");
    
    echo($extraline . "\n");
    
    echo("<HR ALIGN=CENTER SIZE=1 WIDTH=100% NOSHADE>\n");
  } else {
    $a=Array("navitab","navitab","navitab","navitab","navitab","navitab","navitab","navitab","navitab");
    if (""!=$extraline) {
      $a[$extraline]="activenavitab";
    }
    
    echo("<div id=\"navitabs\">\n");
    echo("<h2 class=\"hide\">Site menu:</h2>\n");
    echo("<a class=\"" . $a[0] ."\" href=\"index.php\">Challenge</a><span class=\"hide\"> | </span>\n");
    echo("<a class=\"" . $a[1] ."\" href=\"rul.php\">Rules</a><span class=\"hide\"> | </span>\n");
    echo("<a class=\"" . $a[2] ."\" href=\"faq.php\">FAQ</a><span class=\"hide\"> | </span>\n");
    echo("<a class=\"" . $a[3] ."\" href=\"con.php\">Contact</a><span class=\"hide\"> | </span>\n");
    echo("<a class=\"" . $a[4] ."\" href=\"status.php?showdata=setlist\">Data</a><span class=\"hide\"> | </span>\n");
    echo("<a class=\"" . $a[5] ."\" href=\"status.php?showdata=preds&showuser=%\">Scoreboard</a><span class=\"hide\"> | </span>\n");
    echo("<a class=\"" . $a[6] ."\" href=\"status.php?showdata=preds\">My submissions</a><span class=\"hide\"> | </span>\n");
    if ($seclevel>0) {
      echo("<a class=\"" . $a[7] ."\" href=\"useredit.php\">Account</a><span class=\"hide\"> | </span>\n");
    }
    if ($seclevel>=9) {
      echo("<a class=\"" . $a[8] ."\" href=\"admin/admin.php\">Admin</a><span class=\"hide\"> | </span>\n");
    }
    
    echo("</div>\n");
  }
}

function footer($userid="",$extraline="") {
  
  GLOBAL $fullname;
  GLOBAL $seclevel;
  
  echo("\n<HR ALIGN=CENTER SIZE=1 WIDTH=100% NOSHADE>\n<p>");
  echo($extraline . "\n");
  
  if (""==$userid || "guest"==$userid || "Guest"==$userid) {
    echo("<em>Not logged in.</em> <a href=\"index.php\">Log in</a>");
    echo("&nbsp;-&nbsp;<a href=\"register.php\">Create an account</a>");
  } else {
    echo("<em>Currently logged in as</em> $userid ($fullname).</em>");
    echo " <a href=\"process.php\">Log out</a>\n";
  }

  if ($seclevel>=9) {
    $sql="SELECT *,TIME_TO_SEC(NOW())-TIME_TO_SEC(lasttick) as sec_ago FROM nDaemon";
    $globaldata=mysql_query($sql);
    $row=mysql_fetch_array($globaldata);
    if (120<$row["sec_ago"]) {
      echo("<br><b>NOTICE!  Last tick on queue daemon host " .
           $row["host"] . " was " . $row["sec_ago"] .
           " seconds ago (" . $row["lasttick"] . "!)</b>");

      //$sql="UPDATE nDaemon set lasttick=now()";
      //mysql_query($sql);
      
      //echo("<BR>ATTEMPTING RESTART!!!!<BR><BR>");
      //echo("exec(\"killall matlab\");<BR>");
      //exec("killall matlab");
      
      //echo("exec(\"/home/svd/bin/npcdaemon &\")<BR>");
      //exec("/home/svd/bin/npcdaemon &");
      
      //echo("DONE");

    } else {
      echo("<br><em>Queue daemon host:</em> " . $row["host"] .
           "  <em>Last tick:</em> " . $row["sec_ago"] . " sec (" . 
           $row["lasttick"] . ")");
    }
  }
  echo("</p>\n");
  //print_r($_SESSION);
?>
</div>

<div id="footer">
Copyright © 2005 UC Regents.
</div>
<?php
}

function savedata($tablename,$id,$formdata) {
  
  // check to see if gDataRaw entry exists yet
  $sql="SELECT * FROM $tablename WHERE id=$id";
  $rawfiledata = mysql_query($sql);
  $rawfilerows=mysql_num_rows($rawfiledata);
  
  $tabledata=mysql_query("DESCRIBE $tablename");
  
  if (0==$rawfilerows) {
    // entry doesn't exist yet. create a new one
    $sqlfields="INSERT INTO $tablename (";
    $sqldata=" VALUES (";
    
    while ($trow=mysql_fetch_array($tabledata)) {
      $key=$trow["Field"];
      $type=$trow["Type"];
      if (isset($formdata[$key]) && !is_array($formdata[$key])) {
        $data=$formdata[$key];
        $sqlfields=$sqlfields . $key . ", ";
        if (strstr($type,"double")) {
          $sqldata=$sqldata . floatval($data) . ", ";
        } elseif (strstr($type,"int")) {
          $sqldata=$sqldata . intval($data) . ", ";
        } else {
          $sqldata=$sqldata . "\"" .tidystr($data) . "\", ";
        }
      }
    }
    $sqlfields=$sqlfields . "info)";
    $sqldata=$sqldata . "\"" . $siteinfo. "\")";
    $sql=$sqlfields . $sqldata;
    
    //echo $sql . "<br>";
    $result=mysql_query($sql);
    $id=mysql_insert_id();
  } else {
    // tablename entry does exist.  update with posted values
    
    $sql="UPDATE $tablename SET ";
    
    while ($trow=mysql_fetch_array($tabledata)) {
      $key=$trow["Field"];
      $type=$trow["Type"];
      if (isset($formdata[$key]) && !is_array($formdata[$key])) {
        $data=$formdata[$key];
        $sql=$sql . $key . "=";
        if (strstr($type,"double")) {
          $sql=$sql . floatval($data) . ", ";
        } elseif (strstr($type,"int")) {
          $sql=$sql . intval($data) . ", ";
        } else {
          $sql=$sql . "\"" .tidystr($data) . "\", ";
        }
      }
    }
    $sql=$sql . "info=\"$siteinfo\" WHERE id=$id";
    //echo $sql . "<br>";
    $result=mysql_query($sql);
  }
  if (!$result) {
    $errormsg=mysql_error() . "<br>($sql)";
  } else {
    $errormsg=$id;
  }
  return $errormsg;
}

function checksec($userid,$seclevel,$uidmatch,$secmin) {
  
  if ($seclevel>=10 || ($userid==$uidmatch && $seclevel>$secmin)) {
    return 1;
  } else {
    return 0;
  }
}

function tidystr($instr) {
  $testchar="\"";
  $outstr=explode($testchar,$instr);
  $outstr=implode($testchar.$testchar,$outstr);
  
  return $outstr;
}

function entranceinterface() {
  
  global $form, $session;

  /**
   * User has already logged in, so display relavent links, including
   * a link to the admin center if the user is an administrator.
   */
  if($session->logged_in){
    echo "<h4><b>$session->username</b> logged in</h4>";
    
    //   ."[<a href=\"userinfo.php?user=$session->username\">My Account</a>] &nbsp;&nbsp;"
    //  ."[<a href=\"useredit.php\">Edit Account</a>] &nbsp;&nbsp;";
    //if($session->isAdmin()){
    //  echo "[<a href=\"admin/admin.php\">Admin Center</a>] &nbsp;&nbsp;";
    //}
    echo("<p><a href=\"status.php\">Go to data!</a></p>\n");
    echo "<p><a href=\"process.php\">Log out</a></p>\n";
  } else {
    echo("<h4>Login</h4>\n");
    /**
     * User not logged in, display the login form.
     * If user has already tried to login, but errors were
     * found, display the total number of errors.
     * If errors occurred, they will be displayed.
     */
    if($form->num_errors > 0){
      echo "<font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(s) found</font>";
    }
    echo("<form action=\"process.php\" method=\"POST\">\n");
    echo("User ID:<br>\n");
    echo("<input type=\"text\" name=\"user\" size=10 maxlength=\"30\" value=\"" .$form->value("user") . "\"><br>\n");
    if ($form->error("user")){
      echo($form->error("user") . "<br>\n");
    }
    
    echo("Password:<br>\n");
    echo("<input type=\"password\" name=\"pass\" size=10 maxlength=\"30\" value=\"" . $form->value("pass") . "\"><br>\n");
    if ($form->error("pass")){
      echo($form->error("pass") . "<br>\n");
    }
    //echo("<font size=\"2\"><input type=\"checkbox\" name=\"remember\"");
    //if($form->value("remember") != ""){ echo "checked"; }
    //echo(">Save login</font><br>\n");
    echo("<input type=\"hidden\" name=\"sublogin\" value=\"1\">\n");
    echo("<input type=\"hidden\" name=\"remember\" value=\"0\">\n");
    echo("<input type=\"submit\" value=\"Login\"><br>\n");
    echo("<font size=\"2\"><a href=\"forgotpass.php\">Forgot password</a></font><br><br>\n");
    echo("Not registered? <a href=\"register.php\">Sign up!</a><br>\n");
    echo("</form>\n");
  }
}

//version 0.1:  alpha edition
$siteinfo="NPC 0.3";

//important file paths
$dataroot="/home/predictor/npc/data/";
$predroot="/home/predictor/npc/pred/";
$admin_email="svd[at]umd.edu";

//automatically parse html posted variables (i think?)
//import_request_variables("GP", "");

// all the db/user management stuff has been replaced!!!
// hopefully without much pain?!?!?
// initializes and fills up objects $form, $session, $database and $mailer
// i assume they're all visible in the main routine. dunno if they're all globals
include("include/session.php");

// set a few variables to be conveniently backwards compatible with the old login system... userid, security level, etc...
$userid=$session->username;
$fullname=$session->userinfo['fullname'];
$seclevel=$session->userlevel;


if (!isset($userbg)) {
  $userbg="#FFFFFF";
}
if (!isset($userfg)) {
  $userfg="#000011";
}
if (!isset($linkfg)) {
  $linkfg="#222299";
 }
if (!isset($vlinkfg)) {
  $vlinkfg="#111166";
}
if (!isset($alinkfg)) {
  $alinkfg="#AA0000";
}

?>
