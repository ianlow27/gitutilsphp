<?php
$usage = "
  Usage: php $argv[0] [-h|n]
Version: 0.0.11_250224-1831
  About: $argv[0] facilitates the creation and saving of projects to git repositories
 Author: Ian Low | Date: 2024-10-31 | Copyright (c) 2024, Ian Low | Usage Rights: MIT License
Options:
   -h            Display information on help and run options
   -n            Create a new project folder with default starter files and local git repository
   N/A!! -newgit       Create new local Git repository             
   -add2do       Add a to do item to Change log and update to status 'Changes' mode
   -upd2do       Update a to do item to Change log and update to status 'Changes' mode
   -save2git     Save and commit changes to git and update to status 'Committed' mode
   -addsave2git  Update to status 'Changes' mode and then save and update to 'Committed' mode
   -s            save to local Git and remote GitHub repositories
   N/A!! -adddep            Add details of dependencies to a project
   N/A!! -upddep            Update details of dependencies to a project
";
$aIniSettings = array();
init();
//echo $aIniSettings["email"]."\n";
//echo $aIniSettings["author"]."\n";
//echo $aIniSettings["GitHub account"]."\n";
//echo $aIniSettings["firstCommitRef"]."\n";
//return;
//---------------------!!
if(isset($argv[1])){
  //-----------------------------------------
  if($argv[1]=="-h"){            // Option -h
    echo $usage;
  //-----------------------------------------
  }else if($argv[1]=="-newgit"){ // Option -newgit
    newlocalgit(); 
  //-----------------------------------------
  }else if($argv[1]=="-upddep"){ // Option -upddepend  !!
  //-----------------------------------------
  }else if($argv[1]=="-adddep"){ // Option -adddepend  !!
    echo "Please enter the relative path to the dependent file: "; $depfile = trim(readline());
    if(!file_exists($depfile)){
//if(False){
      echo "ERROR: Sorry, this file does not exist!";
      return; 
    }
//$depfile = "../../jsproj/txutilsjs/txutils.js";
//$depfile = "/home/Administrator/temp/prj1php/prj1.php";
     $depdir  = dirname($depfile);
     $depprj  = basename($depdir);
     $depfnm  = basename($depfile);
     /*
     chdir(dirname($depfile))."\n";
     echo (getcwd());
     exec('git status', $output, $retval);
print_r($output);
     $bTreeClean=False;
     foreach($output as $ln1){
       $ln1 = trim($ln1);
       if($ln1 == "nothing to commit, working tree clean"){
         $bTreeClean=True;
       }
     }//endforeach
     //if($bTreeClean){
     */
     if(isgitclean(dirname($depfile))){
       echo "Tree is clean!\n";
     }else {
       echo "ERROR: Sorry, please please commit all changes in your folder '".dirname($depfile)."' before continuing.\n";
       return;
     }
     $lastver = getlastver($depdir);
     echo getcwd().">___".$lastver."\n";
     $strout =  mdfileAddBefH2("./README", "LICENSE", "DEPENDENCIES",
                  "\nThis application references external file(s) available from the '". $aIniSettings["GitHub account"] ."' GitHub user account. The project name, recommended version, and relative path are as follows:\n|project|version|relative path|\n |:-|:-|:-|",
                  "|". $depprj. "|". $lastver. "|". $depfile. "|");
     echo $strout;
     file_put_contents("./README.md", $strout);
     return;
  //-----------------------------------------
  }else if($argv[1]=="-addsave2git"){ // Option -upd2do  !!
    echo "Please enter the new release description: "; $relcomment = trim(readline());
    add2do($relcomment);
    save2git($relcomment);
    savecommit2git();
  }else if($argv[1]=="-save2git"){ // Option -upd2do  !!
    save2git();
    /*
    echo "Please enter the new release description: "; $relcomment = trim(readline());
    $lastver = getlastver();
    $nextver =  getnextver($lastver, "now")."";
    $nextver1 =  getnextver($lastver)."";

    //iterate through project directory for matching files
    $afiles = new DirectoryIterator("./");
    $prjdir = basename(realpath("./"));
    $langtype = "";
    foreach(explode(" ","go php js html py") as $sfx){
      if(substr($prjdir, strlen($prjdir)-(strlen($sfx)+0)) == "".$sfx){
        $langtype = trim($sfx);
        break;
      }
    }//endforeach
    $nextver1 = preg_replace("/([\.]{1,1})/", "\\.", $nextver1);
    $nextver1 = preg_replace("/([\-]{1,1})/", "\\-", $nextver1);

   foreach ($afiles as $file) {
    foreach(explode(" ","go php js html py") as $sfx){
     //if(substr($prjdir, strlen($prjdir)-(strlen($sfx)+0)) == "".$sfx){
      if($file->isFile()) {
        if(substr($file, strlen($file)-(strlen($sfx)+1)) == ".".$sfx){
          echo $file."____". $nextver1."_____". $nextver."\n";
          copy($file, $file."_".date("ymd-Hi").".bak");
          file_put_contents($file,
            preg_replace("/".$nextver1."/", $nextver,
               file_get_contents($file)) 
            );
        }//endif
      }//endif
     //}//endif
    }//endforeach
   }//endforeach
    $file = "./CHANGELOG.md";
    file_put_contents($file,
      preg_replace("/^\\- (cmp|2do|wip|del)\s*\\:/m", "- ",
        preg_replace("/".$nextver1."/", $nextver,
          preg_replace("/\\[___LEAVE COMMENT BLANK___\\]/", $relcomment,
            file_get_contents($file)) 
          )
        )
      );
    */
    savecommit2git();

    return;
  //-----------------------------------------
  }else if($argv[1]=="-upd2do"){ // Option -upd2do 
    $achnglog = explode("\n", file_get_contents("./CHANGELOG.md"));
    $strout="";
    for($i=0; $i<count($achnglog); $i++){ // as $line){
      $line = trim($achnglog[$i]);
      if( (substr($line,0,6)=='- wip:') ||
          (substr($line,0,6)=='- 2do:') ||
          (substr($line,0,6)=='- del:') ||
          (substr($line,0,6)=='- cmp:') ){
        if($strout != "") $strout.="%%%";
        $strout.=$line;
      }
    }//endfor
    $atmp1 = explode("%%%", $strout);
    $count = 0;
    foreach($atmp1 as $ln){
       $count++;
       echo $count. ") ". $ln."\n";
    }//endforeach
    echo "Please enter the line you wish to update: "; $selline = trim(readline());
    echo "[[". $atmp1[((int)$selline) - 1]."]]\n";
    echo "Please enter the status (2do/wip/cmp/del) or 'Enter' for no change: "; $selstatus = trim(readline());
    echo "Please enter the new description or 'Enter' for no change: "; $selnewdesc = trim(readline());
    echo "Please enter the additional description or 'Enter' for none: "; $seladddesc = trim(readline());
    if(!$selstatus){
       $selstatus = trim(substr($atmp1[((int)$selline) - 1], 2, 3));
    }
    if(!$selnewdesc){
       $selnewdesc = trim(substr($atmp1[((int)$selline) - 1], 6));
    }
    $newline = "- ".$selstatus.": ". $selnewdesc . ($seladddesc ? ", ".$seladddesc : "");

    $strout = "";
    for($i=0; $i<count($achnglog); $i++){ // as $line){
      $line = trim($achnglog[$i]);
      if($line == trim($atmp1[((int)$selline) - 1]) ){
        $strout.=$newline."\n";
      }else {
        $strout.=$line."\n";
      }
    }//endfor
    file_put_contents("./CHANGELOG.md", $strout);
    return;
  //-----------------------------------------
  }else if($argv[1]=="-add2do"){ // Option -add2do 
    add2do();
    /*
    echo "Please enter the new 'to-do' description: "; $desc2do = trim(readline());
    $lastver = getlastver();
    echo $lastver."\n";
    $nextver =  getnextver($lastver)."";


    $afiles = new DirectoryIterator("./");
    $prjdir = basename(realpath("./"));
    $langtype = "";
    foreach(explode(" ","go php js html py") as $sfx){
      if(substr($prjdir, strlen($prjdir)-(strlen($sfx)+0)) == "".$sfx){
        $langtype = trim($sfx);
        break;
      }
    }//endforeach
    $lastver1 = preg_replace("/([\.]{1,1})/", "\\.", $lastver);
    $lastver1 = preg_replace("/([\-]{1,1})/", "\\-", $lastver1);
    echo $lastver."____".$nextver."\n";

   foreach ($afiles as $file) {
    foreach(explode(" ","go php js html py") as $sfx){
     //if(substr($prjdir, strlen($prjdir)-(strlen($sfx)+0)) == "".$sfx){
      if($file->isFile()) {
        if(substr($file, strlen($file)-(strlen($sfx)+1)) == ".".$sfx){
          echo $file."____". $lastver1."_____". $nextver."\n";
          copy($file, $file."_".date("ymd-Hi").".bak");
          file_put_contents($file,
            preg_replace("/".$lastver1."/", $nextver,
               file_get_contents($file)) 
            );
        }//endif
      }//endif
     //}//endif
    }//endforeach
   }//endforeach

    //------------------------------
    $strout =  mdfileAddBefH2("./CHANGELOG", $lastver, $nextver,
                  " - [___LEAVE COMMENT BLANK___]",
                  "- 2do: ".$desc2do."");
    //------------------------------
    echo $strout."\n";
    file_put_contents("./CHANGELOG.md", $strout, );
    */

    return;
  //-----------------------------------------
  }else if($argv[1]=="-n"){      // Option -n (new)
    echo "Please enter the following information or press 'Enter' for the default. For long text we recommend typing the details in a notepad-like app and then copying and pasting into the CLI prompt...\n";
    echo "Project name (defaults to 'myprojphp'): "; $projname = trim(readline());
    if($projname=="") $projname = "myprojphp";
    echo $projname. " ?? (defaults to 'facilitates text processing'): "; $desc = trim(readline());
    echo "Email (defaults to '". $aIniSettings["email"] ."'): "; $email = trim(readline()); 
    echo "Author name (defaults to '". $aIniSettings["author"] ."'): "; $author = trim(readline()); 
    echo "GitHub account name (defaults to '". $aIniSettings["GitHub account"] ."'): "; $githubacct = trim(readline());  
    echo "License Type (apache2 (default), or mit, mpl, bsd0, bsd2, bsd3, bsd4, cc0, ccby4, ccbysa4, gpl2, gpl3, lgpl2, lgpl3, or arr (All Rights Reserved)): "; $usglic = trim(readline());
    $strtfile="";
    if(substr($projname,-2)=="go"){
      $strtfile = preg_replace("/go$/", ".go", $projname);
    }else if(substr($projname,-2)=="js"){
      $strtfile = preg_replace("/js$/", ".js", $projname);
    }else if(substr($projname,-2)=="py"){ 
      $strtfile = preg_replace("/py$/", ".py", $projname);
    }else if(substr($projname,-4)=="html"){ 
      $strtfile = preg_replace("/html$/", ".html", $projname);
    }else if(substr($projname,-3)=="php"){ 
      $strtfile = preg_replace("/php$/", ".php", $projname);
    }
    if($strtfile=="")  $strtfile = "myproj.php";
    if($desc=="")      $desc     = "facilitates text processing";
    if($email=="")     $email    = $aIniSettings["email"];
    if($author=="")    $author   = $aIniSettings["author"];
    if($githubacct=="")$githubacct = $aIniSettings["GitHub account"];
    if($usglic=="")    $usglic   = "apache2";
    if(!file_exists("./".$projname)){ mkdir($projname); }
    //-STARTER SOURCECODE FILE-----  
//unlink("./".$projname. "/". $strtfile); //temporary
    if(!file_exists("./".$projname. "/". $strtfile)){ 
      if(substr($projname,-2)=="go"){ 
        file_put_contents("./".$projname."/".$strtfile, 
"
TO DO!!
");
      }else if(substr($projname,-2)=="js"){
        file_put_contents("./".$projname."/".$strtfile, 
"
TO DO!!
");
      }else if(substr($projname,-2)=="py"){ 
        file_put_contents("./".$projname."/".$strtfile, 
"
TO DO!!
");
      }else if(substr($projname,-4)=="html"){ 
        file_put_contents("./".$projname."/".$strtfile, 
"<!DOCTYPE html><html><head><script>
let appref='". $projname. "';
</script>
<meta charset='UTF-8'/>
<meta name='viewport' content='width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=0' />
</head>
<body>
<b>
github.com/".$githubacct ."/". $projname . "
</b>
- ". $aIniSettings["firstCommitRef"]. " 
|". $projname. " ". $desc. "
|Author: ". $author. "
|Copyright (c) ". date("Y") . " ". $author. "
|Usage Rights: ". licenseinfo($usglic, "code") ."
<table style='width:95%;' border=0 cellspacing=0 cellpadding=0 >
<tr>
<td valign='top' style='width:69%;padding:0px;margin:0px;'>
<textarea id='tx1' style='width:98%;'></textarea>
</td>
<td valign='top' style='width:29%;padding:0px;margin:0px;'>
<textarea id='tx1' style='width:95%;'></textarea>
</tr>
</td>
</table>
<button id='btn1'>Submit</button>
<button id='btn1' onclick='func1();'>Submit</button>
<div id='dv1'>
</div>
<script>
  document.getElementById('tx1').focus();
  document.getElementById('dv1').innerHTML=
    \"<div style='background-color:#ffddbb;'>Output here!</div>\";
//--------------------------------------
function func1(){
  alert('Clicked here!');
}//endfunc
//--------------------------------------
</script>
</body>
</html>
");
      }else if(substr($projname,-3)=="php"){ 
        file_put_contents("./".$projname."/".$strtfile, 
"<?php
\$usage = \"
  Usage: php \$argv[0] [-h]
Version: ". $aIniSettings["firstCommitRef"] . "
  About: \$argv[0] ". $desc. "
 Author: ". $author. " | Date: ". date("Y-m-d"). " | Copyright (c) ". date("Y"). " ". $author.
         " | License: ". licenseinfo($usglic, "code") . "
Options:
    -h   Display help information including run options
    -n   Create a new instance
\";
if(isset(\$argv[1])){
  if(\$argv[1]==\"-h\"){
    echo \$usage;
  }else if(\$argv[1]==\"-n\"){  
    echo \"Please enter the following information or press 'Enter' for default...\\n\";
    echo \"Project name (defaults to 'myprojphp'): \"; \$projname = trim(readline());
    if(\$projname==\"\") \$projname = \"myprojphp\";
  }
}
?>"); 
      }
    }
    //-README.md------------------- 
//unlink("./".$projname. "/README.md" ); //temporary
    if(!file_exists("./".$projname. "/README.md" )){ 
      file_put_contents("./".$projname."/README.md", 
"# ".$projname. "\n
## Overview 
". $projname . " ". $desc. "\n
## LICENSE
". $projname. " uses the MIT License which can be found by clicking [on this link](https://github.com/". $githubacct. "/". $projname. "/blob/main/LICENSE.md)
");
    }
    //-CHANGELOG.md---------------- 
//unlink("./".$projname. "/CHANGELOG.md" ); //temporary
    if(!file_exists("./".$projname. "/CHANGELOG.md" )){ 
      file_put_contents("./".$projname."/CHANGELOG.md",
"# Changelog \n
## TO DO LIST
- : to do item 1
- : to do item 2
- : to do item 3

## NOTES

## ". $aIniSettings["firstCommitRef"]. " - Initial version
- a: initial comment
");
    }
    //-LICENSE.md------------------ 
//unlink("./".$projname. "/LICENSE.md" ); //temporary
    if(!file_exists("./".$projname. "/LICENSE.md" )){ 
      file_put_contents("./".$projname."/LICENSE.md",
        licenseinfo($usglic, "file") );
    }
    //-.gitignore------------------- 
//unlink("./".$projname. "/.gitignore" ); //temporary
    if(!file_exists("./".$projname. "/.gitignore" )){ 
      file_put_contents("./".$projname."/.gitignore",
"*.[ao]
*.swp
*.swo
*.log
*.tmp
*.old
0*buff
0*buf
*.bck
*.bkp
*.bak
*~
");
    }//endif
    //-CREATE LOCAL GIT REPOSITORY--
    newlocalgit(); 
  }
}
//----------------------------------
function savecommit2git(){ 
global $nextver, $relcomment;
  $projname = basename(realpath("./"));
  echo "\nIMPORTANT! PLEASE NOW FOLLOW THESE STEPS:\n".
       "1. Ensure that you are connected to the internet.\n".
       "2. Run this command from your '".$projname."' local folder:\n".
       "3. Then press 'Enter' to continue or 'Ctrl-C' to quit.";
  $lresp = readline();
  if( runcmd('git status') == "On branch main"){
    runcmd('git add .');
    runcmd('git commit -m "'. $nextver. ' - ' . $relcomment . '"');
    runcmd('git push -u origin main');
  }
}//endfunc
//----------------------------------
function newlocalgit(){ 
global $projname, $email, $author, $githubacct, $aIniSettings; //!! 
  $currdir = getcwd();
  chdir($projname);
  if( runcmd('git status') == "On branch main"){
  }else {
    runcmd('git init -b main');
    runcmd('git add .');
    runcmd('git config user.email "'.$email.'"');
    runcmd('git config user.name "'.$author.'"');
    //runcmd('git commit -m "0.0.1_'.date("ymd-Hi") .' - Initial commit"'); !!
    runcmd('git commit -m "'. $aIniSettings["firstCommitRef"].' - Initial commit"');
    runcmd('git remote add origin https://github.com/'.$githubacct.'/'.$projname.'.git');
    runcmd('git branch -M main');
    echo "\nIMPORTANT! PLEASE NOW FOLLOW THESE STEPS:\n".
      "1. If it doesn't exist create a repository called '".$projname."' in your GitHub ". $githubacct. " account.\n".
      "2. Ensure that you are connected to the internet.\n".
      "3. Run this command from your '".$projname."' local folder:\n".
      "   git push -u origin main\n\n";
  }
  chdir($currdir);
}//endfunc
//----------------------------------
function runcmd($cmd){
  $output = null;
  $retval = null;
  echo "In function 'runcmd()' running command: [". $cmd."]\n";
  exec($cmd, $output, $retval);
  echo "runcmd() retval: ".$retval. " - ";
  if(!$retval){
    echo "SUCCESS";
    if(isset($output[0])){
      echo " - output value: ".$output[0]. "\n";
      return $output[0];
    }
    echo "\n";
    return "success";
  }else {
    echo "FAILURE\n";
  }
  return "failure";
}//endfunc
//----------------------------------
function init(){ 
global $aIniSettings;
  $aIniSettings["email"]="fredbloggs@youremail.com";
  $aIniSettings["author"]="Fred Bloggs";
  $aIniSettings["GitHub account"]="fredbloggs";
  $aIniSettings["firstCommitRef"]="0.0.1_". date("ymd-Hi"); //!!
  $aini = explode("\n",file_get_contents(dirname(__FILE__)."/gitutils.ini"));
  foreach($aini as $setting){
    $setting=trim($setting);
    if(!isset($setting)) continue;
    $asetting = explode("=", $setting);
    if(isset($asetting[1]))
      $aIniSettings[$asetting[0]] = $asetting[1];
  }//endforeach
}
//----------------------------------
function vers3digits($pvers){ //!!
  $avers = preg_split("/[\._\-]/", $pvers);
  return 
     sprintf("%03d", $avers[0]).".".
     sprintf("%03d", $avers[1]).".".
     sprintf("%03d", $avers[2])."_".
     $avers[3]."-".$avers[4];
}//endfunc
//----------------------------------
function getnextver($pvers, $popt=""){
  $avers = preg_split("/[\._\-]/", $pvers);
  $timestamp = "ymd-Hi";
  if($popt == "now"){
    $timestamp = date("ymd-Hi");
  }else {
    return "0.".   "0.0_".   "ymd-Hi";
  }
  return 
     sprintf("%01d", $avers[0]).".".
     sprintf("%01d", $avers[1]).".".
     sprintf("%01d", ((int)$avers[2])+1)."_".
     $timestamp;
}//endfunc
//----------------------------------
function isgitclean($pprjdir="./"){ //!!
  $pprjdir = realpath($pprjdir);
  $origdir = getcwd();
  chdir($pprjdir);
  $output = null;
  $retval = null;
  exec('git status', $output, $retval);
  $bTreeClean=False;
  foreach($output as $ln1){
    $ln1 = trim($ln1);
    if($ln1 == "nothing to commit, working tree clean"){
      $bTreeClean=True;
      break;
    }
  }//endforeach
  chdir($origdir);
  return $bTreeClean;
}//endfunc
//----------------------------------
function getlastver($pprjdir="./"){ //!!
  $pprjdir = realpath($pprjdir);
  $origdir = getcwd();
  chdir($pprjdir);
  $output = null;
  $retval = null;
  exec('git reflog', $output, $retval);
  $lastver="";
print_r($output);
  foreach($output as $outln){
    if(preg_match("/\d+\.\d+\.\d+_\d{6,6}\-\d{4,4}/", $outln)){
      $lastver = preg_replace("/(.*)(\d+\.\d+\.\d+_\d{6,6}\-\d{4,4})(.*)/", "$2", $outln);
      break;
    }
  }//endforeach
  chdir($origdir);
  return $lastver;
}//endfunc
//----------------------------------
function  mdfileAddBefH2($pmdfile, $lastver, $nextver, $pcomment, $pdescline){
/*
$strout =  mdfileAddBefH2("./", "./CHANGELOG", $lastver, $nextver,
                  " - [___LEAVE COMMENT BLANK___]",
                  "- 2do: ".$desc2do."");
*/
echo $pmdfile."_1\n";
  $pmdfile = realpath($pmdfile.".md");
echo $pmdfile."_2\n";
  $pprjdir = dirname($pmdfile);
echo $pmdfile."_3\n";

  $achnglog = explode("\n", file_get_contents($pmdfile));
  $nextverexists=False;
  $strout="";
  $prevline="";
  for($i=0; $i<count($achnglog); $i++){ // as $line){
    $line = trim($achnglog[$i]);
    if(substr($line,0,strlen($nextver)+3)=="## ".$nextver.""){
      $nextverexists=True;
    }
    if(substr($line,0,strlen($lastver)+3)=="## ".$lastver.""){
      if(!$nextverexists){
        $strout.="\n## ". $nextver. $pcomment . "\n";
      }
      $strout.= $pdescline;
      $strout.= "\n\n".$line."\n";
    }else {
      if($line){
        $strout.=$line."\n";
      }else {
        if(isset($achnglog[$i+1]))
          if(($prevline)&&(substr($achnglog[$i+1],0,3)=="## ")){
            if((substr($achnglog[$i+1],0,strlen($lastver)+3)!="## ".$lastver))
              $strout.=$line."\n";
          }
      }
    }
    $prevline=$line;
  }//endfor
  return $strout;
}//endfunc
//----------------------------------
function add2do($pdesc=""){
  $desc2do = "";
  if($pdesc!=""){
    $desc2do = "Amendments as per the release description";
  }else {
    echo "Please enter the new 'to-do' description: "; $desc2do = trim(readline());
  } 
  $lastver = getlastver();
  echo $lastver."\n";
  $nextver =  getnextver($lastver)."";
  $afiles = new DirectoryIterator("./");
  $prjdir = basename(realpath("./"));
  
 
  $lastver1 = preg_replace("/([\.]{1,1})/", "\\.", $lastver);
  $lastver1 = preg_replace("/([\-]{1,1})/", "\\-", $lastver1);
  echo $lastver."____".$nextver."\n";
  foreach ($afiles as $file) {
   foreach(explode(" ","prj go php js html py") as $sfx){
    //if(substr($prjdir, strlen($prjdir)-(strlen($sfx)+0)) == "".$sfx){
     if($file->isFile()) {
       if(substr($file, strlen($file)-(strlen($sfx)+1)) == ".".$sfx){
         echo $file."____". $lastver1."_____". $nextver."\n";
         copy($file, $file."_".date("ymd-Hi").".bak");
         file_put_contents($file,
           preg_replace("/".$lastver1."/", $nextver,
              file_get_contents($file)) 
           );
       }//endif
     }//endif
    //}//endif
   }//endforeach
  }//endforeach
  //------------------------------
  $strout =  mdfileAddBefH2("./CHANGELOG", $lastver, $nextver,
                " - [___LEAVE COMMENT BLANK___]",
                "- 2do: ".$desc2do."");
  //------------------------------
  echo $strout."\n";
  file_put_contents("./CHANGELOG.md", $strout, );
}//endfunc
//----------------------------------
function licenseinfo($usglic, $ptype){
global $author, $githubacct;
$lgithubacct = $githubacct;
if(isset($lgithubacct)) $lgithubacct=" (github.com/".$lgithubacct.")";
$outstr="";
  if      ($usglic == "mit"){
     if($ptype == "file"){
       $outstr="MIT License\n
Copyright (c) ". date("Y"). " ". $author. $lgithubacct. "\n
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the “Software”), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:\n
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.\n
THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.\n
";
     }else {
       $outstr="MIT";
     }
  }else if($usglic == "mpl"){
     if($ptype == "file"){
       $outstr="Mozilla Public License 2.0\n
Copyright (c) ". date("Y"). " ". $author.$lgithubacct. "\n
This source code is licensed under the Mozilla Public License, v. 2.0; you may not use the resources from this project except in compliance with the License. You may obtain a copy of the License at\n
http://mozilla.org/MPL/2.0/ \n
Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an 'AS IS' basis, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing permissions and limitations under the License.\n
";
     }else {
       $outstr="MPL-2.0";
     }
  }else if($usglic == "bsd0"){
     if($ptype == "file"){
       $outstr="BSD Zero Clause License\n
Copyright (c) ". date("Y"). " ". $author.$lgithubacct. "\n
Permission to use, copy, modify, and/or distribute this software for any purpose with or without fee is hereby granted.\n
\n
THE SOFTWARE IS PROVIDED 'AS IS' AND THE AUTHOR DISCLAIMS ALL WARRANTIES WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF OR IN CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.\n
";
     }else {
       $outstr="0BSD";
     }
  }else if($usglic == "bsd2"){
     if($ptype == "file"){
       $outstr="BSD 2-Clause 'Simplified' License\n
Copyright (c) ". date("Y"). " ". $author.$lgithubacct. "\n
Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:\n
1. Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.\n
2. Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.\n
THIS SOFTWARE IS PROVIDED BY COPYRIGHT HOLDER 'AS IS' AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL COPYRIGHT HOLDER BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.\n
";
     }else {
       $outstr="BSD-2-Clause";
     }
  }else if($usglic == "bsd3"){
     if($ptype == "file"){
       $outstr="BSD 3-Clause 'Revised' License\n
Copyright (c) ". date("Y"). " ". $author.$lgithubacct. "\n
Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:\n
1. Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.\n
2. Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.\n
This product includes software developed by ". $author.$lgithubacct.  ".\n
3. Neither the name of the copyright holder nor the names the copyright holder nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.\n
THIS SOFTWARE IS PROVIDED BY COPYRIGHT HOLDER 'AS IS' AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL COPYRIGHT HOLDER BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.\n
";
     }else {
       $outstr="BSD-3-Clause";
     }
  }else if($usglic == "bsd4"){
     if($ptype == "file"){
       $outstr="BSD 4-Clause 'Original' License\n
Copyright (c) ". date("Y"). " ". $author.$lgithubacct. "\n
Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:\n
1. Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.\n
2. Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.\n
3. All advertising materials mentioning features or use of this software must display the following acknowledgement:\n
This product includes software developed by ". $author.$lgithubacct.  ".\n
4. Neither the name of the copyright holder nor the names the copyright holder nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.\n
THIS SOFTWARE IS PROVIDED BY COPYRIGHT HOLDER 'AS IS' AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL COPYRIGHT HOLDER BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.\n
";
     }else {
       $outstr="BSD-4-Clause";
     }
  }else if($usglic == "cc0"){
     if($ptype == "file"){
       $outstr="Creative Commons Zero v1.0 Universal\n
Copyright (c) ". date("Y"). " ". $author.$lgithubacct. "\n
This code is dedicated to the public domain under the CC0-1.0 license:\b
https://creativecommons.org/publicdomain/zero/1.0/ \n
";
     }else {
       $outstr="CC0-1.0"; 
     }
  }else if($usglic == "ccby4"){
     if($ptype == "file"){
       $outstr="Creative Commons Attribution 4.0\n
Copyright (c) ". date("Y"). " ". $author.$lgithubacct. "\n
This code is licensed under the Creative Commons Attribution 4.0 International License.\n
To view a copy of this license, visit https://creativecommons.org/licenses/by/4.0/\n
";
     }else {
       $outstr="CC-BY-4.0";
     }
  }else if($usglic == "ccbysa4"){
     if($ptype == "file"){
       $outstr="Creative Commons Attribution ShareAlike4.0\n
Copyright (c) ". date("Y"). " ". $author.$lgithubacct. "\n
This code is licensed under the Creative Commons Attribution-ShareAlike 4.0 International License.\n
To view a copy of this license, visit https://creativecommons.org/licenses/by-sa/4.0/\n
";
     }else {
       $outstr="CC-BY-SA-4.0";
     }
  }else if($usglic == "gpl2"){
     if($ptype == "file"){
       $outstr="GNU General Public License v2.0\n
Copyright (c) ". date("Y"). " ". $author.$lgithubacct. "\n
This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation under version 2 of the License.\n
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.\n
If you have not received a copy of the GNU General Public License along with this program, see <https://www.gnu.org/licenses/>.\n
";
     }else {
       $outstr="GPL-2.0";
     }
  }else if($usglic == "gpl3"){
     if($ptype == "file"){
       $outstr="GNU General Public License v3.0\n
Copyright (c) ". date("Y"). " ". $author.$lgithubacct. "\n
This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation under version 3 of the License.\n
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.\n
If you have not received a copy of the GNU General Public License along with this program, see <https://www.gnu.org/licenses/>.\n
";
     }else {
       $outstr="GPL-3.0";
     }
  }else if($usglic == "lgpl2"){
     if($ptype == "file"){
       $outstr="GNU Lesser General Public License v2.1\n
Copyright (c) ". date("Y"). " ". $author.$lgithubacct. "\n
This program is free software: you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation under version 2.1 of the License.\n
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License for more details.\n
If you have not received a copy of the GNU Lesser General Public License along with this program, see <https://www.gnu.org/licenses/>.\n
";
     }else {
       $outstr="LGPL-2.1";
     }
  }else if($usglic == "lgpl3"){
     if($ptype == "file"){
       $outstr="GNU Lesser General Public License v3.0\n
Copyright (c) ". date("Y"). " ". $author.$lgithubacct. "\n
This program is free software: you can redistribute it and/or modify it under the terms of the GNU Lesser General Public License as published by the Free Software Foundation under version 3 of the License.\n
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License for more details.\n
If you have not received a copy of the GNU Lesser General Public License along with this program, see <https://www.gnu.org/licenses/>.\n
";
     }else {
       $outstr="LGPL-3.0";
     }
  }else if($usglic == "arr"){
     if($ptype == "file"){
       $outstr="\n
Copyright (c) ". date("Y"). " ". $author.$lgithubacct.  ". All Rights Reserved.\n
This software and all its contents, including source code, text, graphics, and logos, are the copyrighted property of ". $author. ". Unauthorized use, reproduction or distribution is strictly prohibited and may result in legal action.\n
";
     }else {
       $outstr="No License Granted. All Rights Reserved.";
     }
  }else { // APACHE AS DEFAULT
     if($ptype == "file"){
       $outstr="Apache License 2.0\n
Copyright (c) ". date("Y"). " ". $author.$lgithubacct. "\n
Licensed under the Apache License, Version 2.0 (the 'License'); you may not use any resource from this project or repository except in compliance with the License. You may obtain a copy of the License at\n
http://www.apache.org/licenses/LICENSE-2.0\n
Unless required by applicable law or agreed to in writing, software distributed under the License is distributed on an 'AS IS' BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the License for the specific language governing permissions and limitations under the License.\n
";
     }else {
       $outstr="Apache-2.0";
     }

  }
  return $outstr;
}//endfunc
//----------------------------------
//----------------------------------
//----------------------------------
//----------------------------------
function save2git($pdesc=""){
global $nextver, $relcomment;
  $relcomments = "";
  if($pdesc!=""){
    $relcomments = $pdesc;
  }else {
    echo "Please enter the new release description: "; $relcomment = trim(readline());
  }
  $lastver = getlastver();
  $nextver =  getnextver($lastver, "now")."";
  $nextver1 =  getnextver($lastver)."";

  //iterate through project directory for matching files
  $afiles = new DirectoryIterator("./");
  $prjdir = basename(realpath("./"));
  
 
  $nextver1 = preg_replace("/([\.]{1,1})/", "\\.", $nextver1);
  $nextver1 = preg_replace("/([\-]{1,1})/", "\\-", $nextver1);

 foreach ($afiles as $file) {
  foreach(explode(" ","prj go php js html py") as $sfx){
   //if(substr($prjdir, strlen($prjdir)-(strlen($sfx)+0)) == "".$sfx){
    if($file->isFile()) {
      if(substr($file, strlen($file)-(strlen($sfx)+1)) == ".".$sfx){
        echo $file."____". $nextver1."_____". $nextver."\n";
        copy($file, $file."_".date("ymd-Hi").".bak");
        file_put_contents($file,
          preg_replace("/".$nextver1."/", $nextver,
             file_get_contents($file)) 
          );
      }//endif
    }//endif
   //}//endif
  }//endforeach
 }//endforeach
  $file = "./CHANGELOG.md";
  file_put_contents($file,
    preg_replace("/^\\- (cmp|2do|wip|del)\s*\\:/m", "- ",
      preg_replace("/".$nextver1."/", $nextver,
        preg_replace("/\\[___LEAVE COMMENT BLANK___\\]/", $relcomment,
          file_get_contents($file)
        ) 
      )
    )
  );

}//endfunc
//----------------------------------
//----------------------------------
?>
