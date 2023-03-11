<?php
/*** NEURODB
peoplelist.php3 - 
created 01-14-2005 - SVD
***/

// global include: connect to db and get important basic info about user prefs
include_once "./neurodb.php3";

if ($mail==1 & $seclevel>=10) {
  mail("stephen@socrates.berkeley.edu", "test", "test content");
  header ("Location: peoplelist.php3?userid=$userid&sessionid=$sessionid");
  exit;  /* Make sure that code below does not execute */
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
  <TITLE>NeuroTree - The Neuroscience Family Tree</TITLE>
</HEAD>
<?php
echo("<BODY bgcolor=\"$userbg\" text=\"$userfg\" link=\"$linkfg\" vlink=\"$vlinkfg\" alink=\"$alinkfg\">");

neuroheader();

if (2==$new) {
  echo("<p><b>Enter search criteria:</b></p>\n");
 }

echo("<table><tr><td>\n");
echo("<FORM ACTION=\"peoplelist.php3\" METHOD=POST>\n");
echo(" <input type=\"hidden\" name=\"userid\" value=\"$userid\">\n");
echo(" <input type=\"hidden\" name=\"sessionid\" value=\"$sessionid\">\n");

$searchname=explode("\\'",$searchname);
$searchname=implode("'",$searchname);
$searchinst=explode("\\'",$searchinst);
$searchinst=implode("'",$searchinst);
echo("Name: ");
echo("<INPUT TYPE=TEXT NAME=\"searchname\" value=\"" . $searchname . "\">");
echo("&nbsp;&nbsp;Inst: ");
echo("<INPUT TYPE=TEXT NAME=\"searchinst\" value=\"" . $searchinst . "\">");
echo(" <INPUT TYPE=SUBMIT VALUE=\"Search\">");
echo("</FORM>");

echo("</td>\n<td>");

//echo("&nbsp;<a href=\"peoplelist.php3?userid=$userid&sessionid=$sessionid\">Browse all</a>\n");

echo("</td></tr></table>");



if (""!=$orderby) {
  $torderby=$orderby . ",lastname,firstname";
} else {
  $torderby="lastname,firstname";
}

$estring="";
if (1==$new) {
  $sql="SELECT max(id) as maxid FROM people";
  $peopledata=mysql_query($sql);
  $row = mysql_fetch_array($peopledata);
  $maxid=$row["maxid"];
  $estring=$estring . " AND id>" . ($maxid-20);
}
if (""!=$searchname) {
  $estring=$estring . " AND (firstname like \"%$searchname%\" OR lastname like \"%$searchname%\")";
}
if (""!=$searchinst) {
  $estring=$estring . " AND location like \"%$searchinst%\"";
}
if (""!=$addedby) {
  $estring=$estring . " AND addedby like \"%$addedby%\"";
}
if (2==$new) {
  // force it so that search returns nothing!
  $estring=" AND 0";
}

$sql="SELECT * FROM people WHERE not(bad) $estring ORDER BY $torderby";
$peopledata=mysql_query($sql);

 if (1==$new) {
   echo("<p><b>Recent additions to Neurotree:</b></p>\n");
 } elseif (2==$new) {
   // do nothing
 } elseif (""!=$searchname) {
   echo("<p><b>People with name matching &quot;$searchname:&quot;</b></p>\n");
 } elseif (""!=$searchinst) {
   echo("<p><b>People with institution matching &quot;$searchinst&quot;:</b></p>\n");
 } elseif (""!=$addedby) {
   echo("<p><b>People added by $addedby:</b></p>\n");
 }
 
 echo("<table>");
 if (mysql_num_rows($peopledata) > 0) {
   
   echo("<tr>\n");
   echo("  <td><a href=\"peoplelist.php3?userid=$userid&sessionid=$sessionid&searchname=$searchname&searchinst=$searchinst&new=$new&orderby=lastname\"><b>Name</b></a></td>\n");
   echo("  <td><a href=\"peoplelist.php3?userid=$userid&sessionid=$sessionid&searchname=$searchname&searchinst=$searchinst&new=$new&orderby=location\"><b>Institution</b></a></td>\n");
   
   echo("  <td><a href=\"peoplelist.php3?userid=$userid&sessionid=$sessionid&searchname=$searchname&searchinst=$searchinst&new=$new&orderby=area\"><b>Area</b></a></td>\n");
   
   if ($seclevel>5) {  
     echo("  <td><a href=\"peoplelist.php3?userid=$userid&sessionid=$sessionid&searchname=$searchname&searchinst=$searchinst&new=$new&orderby=addedby\"><b>Added by</b></a></td>\n");
   }
   echo("  <td><a href=\"peoplelist.php3?userid=$userid&sessionid=$sessionid&searchname=$searchname&searchinst=$searchinst&new=$new&orderby=dateadded\"><b>Date</b></a></td>\n");
   
   echo("</tr>\n");
 } elseif (2!=$new) {
   echo("<tr><td>No matches</td></tr>\n");
 }
 
while ($row = mysql_fetch_array($peopledata)) {
  
  echo("<tr>\n");
  echo("  <td>");
  echo("<a href=\"tree.php3?userid=$userid&sessionid=$sessionid&pid=" . $row["id"] . "\">" . $row["firstname"] . " " . $row["middlename"]);
  echo(" " . $row["lastname"] . "</a>");
  echo(" (<a href=\"peopleinfo.php3?userid=$userid&sessionid=$sessionid&pid=" . $row["id"] . "\">Info</a>)");
  echo("</td>\n");
  
  $location=$row["location"];
  //echo("  <td><a href=\"peoplelist.php3?userid=$userid&sessionid=$sessionid&searchname=&searchinst=$location&orderby=$orderby\">" . $location . "</td>\n");
  echo("  <td><a href=\"peoplelist.php3?userid=$userid&sessionid=$sessionid&searchname=&searchinst=$location&orderby=$orderby\">" . $location . "</td>\n");
  //substr($location,0,25)
  echo("  <td>" . $row["area"] . "</td>\n");
  if ($seclevel>5) {
    echo("  <td>" . $row["addedby"] . "</td>\n");
  }
  echo("  <td>" . substr($row["dateadded"],0,10) . "</td>\n");
  echo("  <td>");
  if (checksec($userid,$seclevel,$row["addedby"],5)) {
    echo("<a href=\"peopleedit.php3?userid=$userid&sessionid=$sessionid&pid=" . $row["id"] . "\">Edit</a>");
  }
  if ($seclevel>=10) {
    if (0==$row["bad"]) {
      echo(" <a href=\"peopleedit.php3?userid=$userid&sessionid=$sessionid&pid=" . $row["id"] . "&action=1\">Del</a>");
    } else {
      echo(" <a href=\"peopleedit.php3?userid=$userid&sessionid=$sessionid&pid=" . $row["id"] . "&action=1\">Undel</a>");
    }
  }
  echo("</td>\n");

  echo("</tr>\n");
}

if ($seclevel>5) {
  echo("<tr>\n");
  
  // space over to the appropriate column
  //echo("  <td colspan=5></td>\n");
  
  echo("  <td>");
  echo("<a href=\"peopleedit.php3?userid=$userid&sessionid=$sessionid&pid=-1\">Add person</a>");
  echo("</td>\n");
  
  echo("</tr>\n");
}

echo("<table>");

footer($userid);

?>

<script language="javascript">
function gotoUrl(url) {
  if (url == "")
    return;
  location.href = url;
}
function newWin(url) {
  // url of this function should have the format: "target,URL".
  if (url == "")
    return;
  window.open(url.substring(url.indexOf(",") + 1, url.length), 
	url.substring(0, url.indexOf(",")));
}
</script>

</BODY>
</HTML>
