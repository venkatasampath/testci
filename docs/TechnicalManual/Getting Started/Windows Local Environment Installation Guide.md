# Getting Started - Windows Local Environment Setup Guide

## Table of contents
- [Purpose](#purpose)
- [Terms and Definitions](#terms-and-definitions)

## System Requirements
 
- [Operating System Requirements](#operating-system-requirements)
- [Recommended Browsers](#recommended-browsers)
- [Minimum System Hardware Requirements](#minimum-system-hardware-requirements)
- [Software Requirements](#software-requirements)

### Windows Local Environment Setup
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

### Troubleshooting
- [Composer Issues](#composer-issues)
	- [symfony/thanks failed](#1.-error:-installation-of-symfony/thanks-failed)
	- [Symfony/thanks failed part two](#2.-error:-installation-of-symfony/thanks-failed-after-global-require-symfony/thanks)
	- [Generic Plugin Installation Failed or Runtime Exception error](#3.-Error:-generic-plugin-installation-failed-or-runtime-exception-error.)
- [PHP Issues](#php-issues)
	- [php Version incompatible](#1.-error:-php-version-incompatible.)
	- [Call to undefined method Monolog](#2.-error:-call-to-undefined-method-monolog)


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

## Windows Local Development Environment Initial Setup

This documentation was created in Fall 2020 at the time of CoRA version 2.5. Hereby noted as "cora25." 

### Download and Install PhpStorm 
*Note: PhpStorm version 2020.2 as of November 17, 2020*
1. As a UNO Student, PhpStorm is free. You can apply for a free license with JetBrains using your UNO email address at: https://www.jetbrains.com/community/education/#students. This will allow you to license your PhpStorm software at no cost and last beyond the 30 day trial period.

	After applying for the license and receiving a confirmation email. You can install PhpStorm at: https://www.jetbrains.com/phpstorm/.  

	Alternatively, you can download the PhpStorm software from your JetBrains account that is created after signing up at: https://account.jetbrains.com/licenses

2. After the application has been downloaded, proceed with the installation. 
	- At the installation options screen place a checkbox on the following:
	- "Create Associations" section: check all boxes (.php, .phtml, .js, .css, .html)
	- "Update PATH variable (restart needed)": check the box "Add launchers dir to the path"
3. Reboot your computer after the installation

### Download and Install Oracle VM VirtualBox
*Note: Oracle VM VirtualBox version 6.1.16 as of November 17, 2020*

1. Download Oracle VM VirtualBox version 6.1.16 at: [https://www.virtualbox.org/wiki/Downloads](https://www.virtualbox.org/wiki/Downloads)
2. Choose "Windows hosts"
3. After the application has been downloaded, proceed with the installation
	- At the "Custom Setup" screen leave everything as default and choose Next
	- At the 2nd "Custom Setup" screen, leave everything as default and choose Next
	- At the "Warning: Network Interfaces" screen, click yes to proceed with the installation now
	- A prompt will appear asking you to install Oracle USB software, choose install

### Download and Install Node.js 
***Note: This is only if you do not have Node.js already installed from previous classes. If you do not, proceed with following the steps listed below. You will need this and package.json to be able to run npm commands.* 

*Node.js version 14.15.1 (includes npm 6.14.8) as of November 17, 2020*

1. Download Node.js at https://nodejs.org/en/download
	- Choose your OS architecture 32-bit or 64-bit and download the Windows Installer (.msi)
	- "Custom Setup" screen: leave everything as default and click next
	- "Tools for Native Modules" screen: Check the box where it says "Automatically install the necessary tools"

### Download and Install Vagrant

*Note: Vagrant version 2.2.14 as of November 17, 2020*
1. Download Vagrant at: https://www.vagrantup.com/downloads.html
2. Install Vagrant 
3. Restart your computer when prompted
4. Install the Laravel Homestead Vagrant Box
	- Open command prompt and ensure that you are in your home directory i.e. C:\users\username
	- Type in the command: ***vagrant box add laravel/homestead*** and click enter
	- Enter 3 to choose virtualbox as your provider and click enter
	- VirtualBox will begin to download from an S3 Amazon bucket, it may take a while and freeze at times
5. Verify if Vagrant Box was properly installed by typing the following command in command prompt: **vagrant box list**
	- If it was properly installed, you will see **laravel/homestead (virtualbox, 10.1.1)** returned as a result

### Download and Install Git
Notes: If the git command does not work for you then you do not have Git for Windows. Install Git by following the steps listed below. 

1. Download Git at: [https://git-scm.com/download/win](https://git-scm.com/download/win)
2. "Select Components" screen, leave everything as default
3.  "Choosing the default editor used by Git" screen, click next
4. "Adjusting the name of the initial branch in new repositories" screen, leave the radio button at "Let Git decide"
5. "Adjusting your PATH environment" screen, choose "Git from the command line and also from 3rd-party software"
6. "Choosing HTTPS transport backend" screen, leave as default
7. "Configuring the line ending conversions" screen, choose "Checkout Windows style, commit Unix-style line endings
8. "Configuring the terminal emulator to use with Git Bash" screen, choose "use MinTTY"
9. "Choose the default behavior of 'git pull'" screen, choose "default"
10. "Choose a credential helper" screen, choose "Git Credential Manager Core"
11. "Configuring extra options" screen, leave as default 
12. Install Git
13. Make sure you close the command prompt and re-open before you try running the Git command


### Download and Install Homestead
Note: Every time you edit the Homestead.yaml file, you need to run the command: ***vagrant reload --provision*** in command prompt or console **FROM YOUR HOMESTEAD DIRECTORY**
1. Open command prompt and change to your home directory (C:\Users\username)
			
			-Run: cd C:\Users\<your username>

2. Download Homestead to your local machine:

			-Run: git clone https://github.com/laravel/homestead.git


3. After your download has completed you should have the home the homestead directory. Verify using the "dir" command and then change into the homestead directory.  Your path should show C:\Users\username\homestead

			-Run: dir
			-Run: cd homestead

4. Get the latest homestead release.

			-Run: git checkout release

5. Look for the homestead.yaml.example file and copy it and name your new file homestead.yaml

			-Run: cp homestead.yaml.example homestead.yaml

6. Open homestead.yaml file you just created using PhpStorm or Notepad++ and update the following:

			- folders: 
				- map: C:\Users\<your username>\code
			- sites:
				- map: cora25.test
				- to: /home/vagrant/code/cora25/public

7. Save the file 

### Clone CoRA Project from cora25 GitHub Repository
*Note: It is highly recommended to have the cora25 project within the code directory. If it is not in the recommended code directory, then you will need to update the map in homestead.yaml to match your local path. If you make any changes to homestead.yaml, you must run the command: ***vagrant reload --provision***

1. Create a new folder in C:\Users\username named code

				-Run: cd C:\Users\<your username>
				-Run: mkdir code

2. Change your directory to C:\Users\username\code

			- Run: cd code


3. Clone the project.

			-Run: git clone https://github.com/SachinPawaskarUNO/cora25.git

4. You may be prompted to log into your GitHub account, proceed with logging in. You may get the "remote: Repository not found" message. see the [Common Issues section](#1.-**error:**-remote-repository-not-found.) section.

5. The project will download and it may take a while

### SSH Key Setup

1. In the command prompt change your directory to homestead if you are not already there. (C:\Users\username\homestead)

			-Run: cd C:\Users\<you username>\homestead

2. You will need to generate SSH keys 

			-Run: ssh-keygen -t rsa -C "you\@homestead"

3. It will ask you to enter the file in which to save the key, just press enter (it will save in (C:\Users\username/.ssh/id_rsa)
4. It will ask you to enter a passphrase or leave it empty, press enter twice to leave it empty

### Hostname Resolution Setup
*Note: Make sure the IP address that you are adding is the same IP address that is set in homestead.yaml file. The hosts file will redirect requests for your Homestead sites into your Homestead machine.* 

1. Open the file explorer and navigate to C:\Windows\System32\drivers\etc\hosts (not command prompt)
2. Open the file in Notepad++, Notepad, or an editor of your choice (Right click run as administrator or the file may not save).

	***Note:*** You  may have to open Notepad++ or Notpad from cortana to see the right click as administrator, and then navigate to the file using File->open.

3. Add the following to the hosts file on the bottom: ***192.168.10.10 cora25.test***
4. Save the file

### Launch Vagrant Box

*Note: Composer version 2.0.7 as of November 17, 2020.* 

1. Open command prompt change to your homestead directory and start you vagrant server.

			-Run: cd C:\Users\<your username>\homestead
			-Run: vagrant up

2. This will bring up the homestead vagrant environment. 
3. After the environment is up, while you are still in the homestead directory (C:\Users\username\homestead) run the following command: ***vagrant ssh***. This will allow you to log into the vagrant machine. You will see your prompt change to a green color with the prompt showing vagrant@homestead:~$.

		-Run: vagrant ssh

4. While still in the vagrant@homestead:~$ command prompt, change your directory to code/cora25.

		-Run: cd code/cora25

5. While you are in code/cora25 directory, enter the following command: ***composer install*** Note: If you encounter any errors during the composer installation phase please refer to the [Common Issues](#common-issues) Section below. Update composer version

		-Run: composer install
		
6. When composer finishes installing, enter the following command: ***php artisan key:generate***
7. When php artisan finishes installing, enter the following command: **cp .env.example .env**

### Update Database env File
1. You will not be able to open the development environment until you receive the database credentials and instructions on what to enter in your .env file. See [call to undefined method Monolog](#2.-error:-call-to-undefined-method-monolog) in the common issues section.
2. Once you receive the information needed to put in your .env file in PhpStorm, navigate to code/cora25/.env. Update the file as directed.

### Accessing CORA Development Environment

1. Open a browser (Chrome or Edge) and navigate to ***cora25.test***. 
2. If the page loads with a login screen, then the local environment set up is complete. 
3. Obtain login credentials from the professor 

# Common Issues

## Git Issues
[<img src="../media/Octocat.png" width="150"/>](https://git-scm.com/doc)
</br>

### 1. **Error:** Remote Repository not found.
</br>


		TODO 

**Resolution:**
</br>


		- TODO
</br>

## Composer Issues 
[<img src="../media/composer-img.jpg" width="150"/>](https://getcomposer.org/)
</br>

### 1. **Error:** Installation of symfony/thanks failed.
</br>


		Installation failed, reverting ./composer.json and ./composer.lock to their original content [Runtime Exception] Could not delete /home/vagrant/code/cora25/vendor/symfony/thanks/src. 

**Resolution:**
</br>


		- Run: composer global require symfony/thanks
		- Run: composer update
</br>

### 2. **Error:** Installation of symfony/thanks failed after global require symfony/thanks.
</br>

		Your requirements could not be resolved to an installable set of packages.
		Problem 1
		- laravel/installer is locked to version v4.1.1 and an update of this package was not requrested.
		- laravel/installer v4.1.1 requires php^7.3|^8.0 -> your php version (7.2.x) does not satisfy that requirement. 
		Problem 2
		 - [...]

**Resolution:**
</br>

		-Run: update-alternatives --config.php
		-Type: "5" and press enter for php7.3
		-Run: composer global require symfony/thanks
		-Run: composer update

</br>

### 3. **Error:** Generic Plugin Installation Failed or Runtime Exception error.
</br>

**Resolution:** 

		- Run: composer require symfony/asset
		
			( If that does not work try adding global in the command above. ) 
				
				- Run: composer global require symfony/asset
		
		- Run: composer update

			(if composer update does not work)

				- Run: composer install 
</br>
</br>

## PHP Issues
[<img src="../media/php-logo.jpg" width="150"/>](https://www.php.net/manual/en/index.php)
</br>

### 1. **Error:** php Version incompatible.
</br>

		Your lock file does not contain a compatible set of packages. Please run composer update. 
		Problem 1 
		- Root composer.json requires php ^7.2 but your php version(8.0.0) does not satisfy that requirement.
		Problem 2
		- [...]

**Resolution:** If this is the first time installing this environment your php version has been set to the default php8.0.

		- Run: update-alternatives --config.php
		- Type: "4" press enter to change your php version to php7.2

</br>

### 2. **Error:** Call to undefined method Monolog
</br>

		Call to undefined method Monolog\Logger::getMonolog()

		Script @php artisan package:discover handling the post-autoload-dump even returned with error code 1

**Resolution:** Updating your credentials seemed to fix this error.

		- Run: cp.env.example .env
	
	The above command copies the example environement file and creates the working environment file. After the file is created open in your editor and change your credentials. ***(Note: actual creditials are confidential and will be given to you. The below is an example only and will not worl.)***

		DB_CONNECTION=pgsql
		DB_HOST=***<provided to you>***
		DB_PORT=5432
		DB_DATABASE=***<provided to you>***
		DB_USERNAME=***<provided to you>***
		DB_PASSWORD=***<provided to you>***
	
	Save the .env file.

		- Run: composer update
		- Run: php artisan key:generate

	(Note: this error will be encounted while inside the vagrant@homestead environemnt the server should already be running.)
	Test the server.

		- Run: ping 192.168.10.10
	
	If you successfully pinged the server open your browser and procede to cora25.test.  If you can ping 192.168.10.10 but cannot reach the url cora25.test check your /etc/hosts file. 
