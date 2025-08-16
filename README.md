# gitutilsphp

## Overview 
gitutilsphp facilitates the creation of project that use Git and GitHub

## LICENSE
gitutilsphp uses the MIT License which can be found by clicking [on this link](https://github.com/ianlow27/gitutilsphp/blob/main/LICENSE.md)

## Installation
1. Clone this repository into a local directory
1. Set the environment variable GITUTILSPHP_PATH to point to the folder where you cloned the repository
1. Ensure that PHP is in your environment PATH
1. Ensure that gitutils.php is in your environment PATH
1. Ensure that gitutilsphp.sh is in your environment PATH
1. Navigate to the parent folder where you wish to create the folder for your project
1. Run gitutilsphp.sh -n to create a new project
1. cd into your new project folder.
1. Add the code changes inside your project folder and run gitutilsphp.sh with the other options from within this current folder

### Options with gitutilsphp.sh
| Options | Description |
|---------|-------------|
|-h   |         Display information on help and run options  |
|-n    |        Create a new project folder with default starter files and local git repository |
|-add2do  |     Add a to do item to Change log and update to status 'Changes' mode |
|-upd2do   |    Update a to do item to Change log and update to status 'Changes' mode |
|-save2git  |   Save and commit changes to git and update to status 'Committed' mode |
|-addsave2git | Update to status 'Changes' mode and then save and update to 'Committed' mode |
|-s          |  save to local Git and remote GitHub repositories |

### Worked Example
1. Cd to a the parent folder for your project e.g. **cd $C/home/projects**
1. Run the command **gitutilsphp.sh -n**
1. When prompted enter the information related to the project e.g. 
    1. Please enter the following information or press 'Enter' for the default. For long text we recommend typing the details in a notepad-like app and then copying and pasting into the CLI prompt...                                
    1. Project name (defaults to 'myprojphp'): **myproj1**
    1. Description (defaults to 'facilitates text processing'): **some description**
    1. Email (defaults to 'fredbloggs@someemail.com'): **some@email.com**
    1. Author name (defaults to 'Fred Blogs'): **Your Name**
    1. GitHub account name (defaults to 'fblogs101'): **youraccount**   
    1. License Type (apache2 (default), or mit, mpl, bsd0, bsd2, bsd3, bsd4, cc0, ccby4, ccbysa4, gpl2, gpl3, lgpl2, lgpl3, or arr (All Rights Reserved)): **mit**        
1. The folder **myproj1** is created. Cd into the folder
1. Make the necessary changes to the code
1. In your account on GitHub create the repository with the same project name
1. When you are ready to save your changes to GitHub, in the project folder run the command **gitutilsphp.sh -addsave2git**

