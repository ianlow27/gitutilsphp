<?php
$usage = "
  Usage: php $argv[0] [-h|n]
Version: 0.0.1-241031
  About: $argv[0] facilitates the creation and saving of projects to git repositories
 Author: Ian Low | Date: 2024-10-31 | Copyright (c) 2024, Ian Low | Usage Rights: MIT License
Options:
   -h       Display information on help and run options
   -n       Create a new project folder with default starter files and local git repository
   -newgit  Create new local Git repository             
   -s       save to local Git and remote GitHub repositories
";
if(isset($argv[1])){
  if($argv[1]=="-h"){
    echo $usage;
  }else if($argv[1]=="-newgit"){  
    newlocalgit(); 
  }else if($argv[1]=="-n"){  
    echo "Please enter the following information or press 'Enter' for default...\n";
    echo "Project name (defaults to 'myprojphp'): "; $projname = trim(readline());
    if($projname=="") $projname = "myprojphp";
    echo $projname. " ?? (defaults to 'facilitates text processing'): "; $desc = trim(readline());
    echo "Email (defaults to 'fbloggs@youremail.com'): "; $email = trim(readline());
    echo "Author name (defaults to 'Fred Bloggs'): "; $author = trim(readline());
    echo "GitHub account name (defaults to 'fredbloggs'): "; $githubacct = trim(readline()); 
    echo "Usage Rights (defaults to 'MIT License'): "; $usglic = trim(readline());
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
    if($strtfile=="") $strtfile = "myproj.php";
    if($desc=="") $desc = "facilitates text processing";
    if($email=="")   $email   = "fbloggs@youremail.com"; 
    if($author=="")   $author   = "Fred Bloggs";
    if($githubacct=="")   $githubacct   = "fredbloggs";
    if($usglic=="")   $usglic   = "MIT License";
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
"<!DOCTYPE html><html><head>
<meta name='viewport' content='width=device-width, initial-scale=1' />
</head>
<body>
<b>
github.com/".$githubacct ."/". $projname . "
</b>
- v0.0.1-". date("ymd") ." 
|". $projname. " ". $desc. "
|Author: ". $author. "
|Copyright (c) ". date("Y") . " ". $author. "
|Usage Rights: ". $usglic ."
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
Version: v0.0.1-".date("ymd")."
  About: \$argv[0] ". $desc. "
 Author: ". $author. " | Date: ". date("Y-m-d"). " | Copyright (c) ". date("Y"). " ". $author.
         " | Usage Rights: ". $usglic. "
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
- : to do item 3\n
## v0.0.1-" .date("ymd"). " - Initial version
- a: initial comment
");
    }
    //-LICENSE.md------------------ 
//unlink("./".$projname. "/LICENSE.md" ); //temporary
    if(!file_exists("./".$projname. "/LICENSE.md" )){ 
      file_put_contents("./".$projname."/LICENSE.md",
"MIT License\n
Copyright (c) ". date("Y"). " ". $author."\n
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the “Software”), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:\n
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.\n
THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.\n
");
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
*~
");
    }//endif
    //-CREATE LOCAL GIT REPOSITORY--
    newlocalgit(); 
  }
}
//----------------------------------
function newlocalgit(){ 
global $projname, $email, $author, $githubacct; 
  $currdir = getcwd();
  chdir($projname);
  if( runcmd('git status') == "On branch main"){
  }else {
    runcmd('git init -b main');
    runcmd('git add .');
    runcmd('git config user.email "'.$email.'"');
    runcmd('git config user.name "'.$author.'"');
    runcmd('git commit -m "v0.0.1_'.date("ymd-Hi") .' - Initial commit"');
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
//----------------------------------!!
?>
