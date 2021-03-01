# Getting Started - MacOS Local Environment Setup Guide

## Purpose
- [Purpose](#purpose)

## Terms and Definitions 
- [Terms and Definitions](#terms-and-definitions)

## System Requirements
 
- [Operating System Requirements](#operating-system-requirements)
- [Recommended Browsers](#recommended-browsers)
- [Minimum System Hardware Requirements](#minimum-system-hardware-requirements)
- [Software Requirements](#software-requirements)

### MacOS Local Environment Setup
- [Download and Install PhpStorm](#download-and-install-phpstorm)
- [Download and Install Oracle VM VirtualBox](#download-and-install-oracle-vm-virtualbox) 
- [Download and Install Node.js](#download-and-install-node.js)
- [Download and Install Vagrant](#download-and-install-vagrant)
- [Download and Install Git](#download-and-install-git)
- [Download and Install Homestead](#download-and-install-homestead)
- [Clone CoRA Project from cora25 GitHub Repository](#clone-cora-project-from-cora25-github-repository)
- [SSH Key Setup](#ssh-key-setup)
- [Hostname Resolution Setup](#hostname-resolution-setup)
- [Launch Vagrant Box](#launch-vagrant-box)
- [Update Database env File](#update-database-env-file)
- [Accessing CORA Development Environment](#accessing-cora-development-environment)

### Common Issues
- [Common Issues](#common-issues)

## Purpose
The purpose of this document is to describe the architecture, design, technical dependencies, key configurations, specifications used to develop the existing Commingled Remains Analytics (CoRA) web application for Defense POW/MIA Accounting Agency (DPAA). The document will provide a clear understanding of how to set up the system locally, configurations for the testing environment, and any potential issues that may arise and how to resolve them.

## Terms and Definitions
The CoRA web application, database and APIs are a community resource for inventorying assemblages of commingled human remains which are often encountered in archaeological and forensic contexts, while providing a framework of analytic methods, visualization techniques and tools to assist in the segregation and identification process. The application is an enhancement of existing CoRA web application layout, in order to bring progressive front-end design for the users. These enhancements for the application will allow users to access the website and use the full range of application features since it embraces both the desktop and mobile universes with responsiveness, flexibility, and extensibility.

## System Requirements

### Operating System Requirements

- Microsoft Windows - Windows 10 or higher
- Apple - Mac OS 10.5 or higher 
- Linux - Ubuntu 18 

### Recommended Browsers

CoRA is a web browser-based application which can be accessed through a browser on a computer or a mobile device. It is recommended that the browsers being used are compatible with HTML5 and CSS3.  

#### Desktop/Laptop Browsers
- Google Chrome
- Microsoft Edge

Note: CoRA may work with Mozilla Firefox and Safari however it has not been thorougly tested at the time of this documentation.

#### Mobile Browsers
- Google Chrome

Note: CoRA may work with Mozilla Firefox and Safari however it has not been thorougly tested at the time of this documentation.

### Minimum System Hardware Requirements
Note: The minimum requirement meets the requirement to get the system up and running. However, you will notice serious performance degradation when just meeting minimum requirements not using recommended requirements.

| Hardware          | Minimum    | Recommended       | Notes                                                                                                                                              |
| ----------------- | ---------- | ----------------- | -------------------------------------------------------------------------------------------------------------------------------------------------- |
| RAM               | 8 GB      | 16+ GB             | Running a development environment consumes significant RAM, 8 GB will give you decent performance and 16 GB will give you a better experience      |
| Screen Resolution | 1024x768   | 1920x1080         |   To allow proper viewing of the site                                                                                                                                                 |
| CPU Cores         | 2          | 4+ Cores          | Running a VM for Vagrant will require consuming parts of your CPU cores, the more you have the better performance you will receive                 |
| Free Disk Space   | 4 GB       | 8+ GB             | Code is 2 GB, VirtualBox is 217 MB, Node.js is 54.2 MB, space is also needed for cache                                                                            |
| Disk Type         | Hard Drive | Solid State Drive | SSD does not require mechanical spinning drives which is known for slowing down systems, SSD runs much faster than standard mechanical hard drives |

### Software Requirements 
Mac OS

Windows

Linux

## MacOS Local Development Environment Initial Setup

This documentation was developed using MacOS Big Sur version 11.0.1. 

### Download and Install PhpStorm

*Note: PhpStorm version 2020.2.3 as of November 17, 2020*  

1. As a UNO Student, PhpStorm is free. You can apply for a free license with JetBrains using your UNO email address at: https://www.jetbrains.com/community/education/#students. This will allow you to license your PhpStorm software at no cost and last beyond the 30 day trial period.  
  
   After applying for the license and receiving a confirmation email. You can install PhpStorm at: https://www.jetbrains.com/phpstorm/.    
  
   Alternatively, you can download the PhpStorm software from your JetBrains account that is created after signing up at: https://account.jetbrains.com/licenses  
  
2. After the application has been downloaded, move PhpStorm to the Applications folder as instructed.

### Download and Install Oracle VM VirtualBox

*Note: Oracle VM VirtualBox version 6.1.16 as of November 17, 2020*

1. Download Oracle VM VirtualBox version 6.1.16 at: [https://www.virtualbox.org/wiki/Downloads](https://www.virtualbox.org/wiki/Downloads)
2. After the application installs, navigate to ***System Preferences*** -> ***Security & Privacy*** -> ***Privacy Tab*** - > ***Full Disk Access*** and add VirtualBox to the list

### Download and Install Node.js

***Note: Node.js version 14.15.1 LTS as of November 21, 2020.***

1. Download Node.js at https://node.js.org/en/download
2. Install Node.js
3. Open terminal and verify that /usr/local/bin is in your $PATH. Enter the following command: ***sudo nano /etc/paths***
4. If the path is not there in the file, go to the bottom of the file and add /usr/local/bin to your path then hit ***control + x*** to quit then enter ***Y*** to save. 

### Download and Install Vagrant

*Note: Vagrant version 2.2.14 as of November 21, 2020.*

1. Download Vagrant at https://www.vagrantup.com/downloads
2. Install Vagrant
3. Open Terminal and navigate to your home directory /users/username and enter the command: ***vagrant box add laravel/homestead*** and click enter
4. Enter the number 3 to choose virtualbox as the provider. 
5. Vagrant will begin to download from an S3 Amazon bucket, it may take a while and freeze a times. 
6. After you see that vagrant was successfully installed, verify that it was properly installed by typing the following command in terminal: ***vagrant box list***
7. If it was properly installed, you will see **laravel/homstead (virtualbox, 10.1.1)** returned as a result

### Download and Install Git

*Note: If you have already installed Xcode previously, you can move forwards to the next section.* 

*Xcode version 12.2 as of November 21, 2020*

1. Navigate to https://developer.apple.com/download/more/
2. Sign in with your iTunes account id
3. On the search bar on the left and download the latest stable version of Xcode. 
4. Download the file and install it on your computer.

### Download and Install Homestead

*Note: Homestead version 10.1.1 as of November 21, 2020.* 

 *Every time you edit the Homestead.yaml file, you need to run the command: ***vagrant reload --provision*** in command prompt or console **FROM YOUR HOMESTEAD DIRECTORY***

1. Open terminal and change to your home directory: /Users/username
2. Enter the following command: ***git clone https://github.com/laravel/homestead.git***
3. If you see a prompt that says "no developer tools were found at 'Application/Xcode.app" then you will need to install the command line developer tools. Install it and then move forwards to the next step
4. Enter the command: ***cd homestead*** and you are now in the homestead directory. Your path should show /Users/username/homestead. 
5. Enter the command: ***git checkout release***
6. Make a copy of homestead.yaml.example file and create a new file named homestead.yaml. 
7. Open the homestead.yaml file you just created and make changes to the path for the folders and sites:
	- Under sites make the following changes:
		- map: cora25.test
		- to: /home/vagrant/code/cora25/public

### Clone CoRA Project from cora25 GitHub Repository

*Note: It is highly recommended to have the cora25 project within the code directory. If it is not in the recommended code directory, then you will need to update the map in homestead.yaml to match your local path. If you make any changes to homestead.yaml, you must run the command:* ***vagrant reload --provision***

1. Open Terminal and navigate to your home directory (/Users/username). 
2. Enter the command: ***mkdir code*** and press enter
3. Change to the new code directory by entering the command: ***cd /Users/username/code***
4. Clone the project by entering this in terminal while you're in the code directory: ***git clone https://github.com/SachinPawaskarUNO/cora25.git.*** 
5. You may be prompted to log into your GitHub account, proceed with logging in if prompted. 
6. The project will begin to download and it may take a while, the project is 2 GB in size. 

### SSH Key Setup

1. In Terminal, change your directory to homestead directory (/Users/username/homestead)
2. Enter the command: ***ssh-keygen -t rsa -C \"username\@homestead\"***
3. Press enter at the prompt "Enter file in which to save the key
4. If you want to give your key a passphrase, enter it twice, otherwise press enter twice to leave it empty
5. A new directory will be created called .ssh/id_rsa in your home directory. 

### Hostname Resolution Setup

*Note: Make sure the IP address that you are adding is the same IP address that is set in homestead.yaml file. The hosts file will redirect requests for your Homestead sites into your Homestead machine.*

1. Enter the command: sudo nano /etc/hosts to edit the hosts file
2. Add a new line on the bottom of the hosts file with the following: ***192.168.10.10 cora25.test***
3. ***Control + X*** to exit editing and enter **Y** to save the hosts file

### Launch Vagrant Box

*Note: Composer version 2.0.7 as of November 21, 2020.*

1. Open Terminal and navigate to your homestead directory (/Users/username/homestead)
2. Enter the command: ***vagrant up*** and press enter
3. If you encounter errors, you need to ensure that in Systems & Preferences that Virtual Box has full disk access and Oracle is allowed. 
4. While you are still in the homestead directory, run the following command: ***vagrant ssh*** Your prompt will change to a green color and show vagrant@homestead:~$.  
5. While still in the vagrant@homestead:~$ command prompt, change your directory to code/cora25 by entering the command:  ***cd code/cora25*** or navigate to the /code/cora25 directory.
6. Enter the following command: ***cp .env.example .env***
7. Enter the following command: ***composer install*** 
	- If you encounter any errors during the composer installation phase, please refer to the [Common Issues](#common-issues) section below. 
	- When composer finishes installing, enter the following command ***php artisan key:generate***

### Update Database env File

*Note: You will not be able to open the development environment until you receive the database credentials and instructions on what to enter in your .env file.*

Once you receive the information needed to put in your .env file in PhpStorm, navigate to code/cora25/.env. Update the file as directed.

### Accessing CORA Development Environment

1. Open a browser (Chrome or Edge) and navigate to ***cora25.test***. 
2. If the page loads with a login screen, then the local environment set up is complete. 
3. Obtain login credentials from the professor 

### Common Issues

1. **Error:** Installation failed, reverting ./composer.json and ./composer.lock to their original content [Runtime Exception] Could not delete /home/vagrant/code/cora25/vendor/symfony/thanks/src.   
  
   **Resolution:** Enter the following command: ***composer global require symfony/thanks*** once that completes then run the following command: ***composer update***.

2. **Error:** Allowed memory size of XXXX bytes exhausted (tried to allocate XXX bytes) in phar:

   **Resolution:** To find your memory limit, you need to run the following command in vagrant@homestead directory: ***php -r "echo ini_get('memory_limit').PHP_EOL;"*** 
   You need to update the php.ini file located in /etc/php.ini.default and update the memory limit to a larger number
   Alternatively you can also bump the memory limit just once without updating the php.ini file by running the following command: php -d memory_limit=-1 /usr/local/bin/composer update
   If you are still experiencing errors run the command: ***composer dump-autoload*** and then run the command: ***composer install***