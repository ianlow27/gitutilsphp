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

