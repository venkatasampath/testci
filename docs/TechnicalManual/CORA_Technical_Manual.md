Technical Manual
================

![University of Nebraska Omaha](media/UNOLogo.jpg)

## Table of Contents

* [INTRODUCTION](#intro)
    * [Purpose](#purpose)
    * [Terms/Definitions](#terms/definitions)
* [SYSTEM REQUIREMENTS](#systemrequirements)
    * [Hardware Requirements](#hardwarerequirement)
    * [Software Requirements](#softwarerequirement)
* [OPERATING ENVIRONMENT](#operatingenv)
    * [Local Development Environment](#localdev)
    * [Git and GitHub](#github)
* [JOB COMMANDS](#commands)
* [QUALITY ASSURANCE](#qa)
* [References](#ref)

<a name="intro"></a>
INTRODUCTION
============

<a name="purpose"></a>
Purpose
-------

The purpose of this document is to describe the architecture, design, technical
dependencies, key configurations, specifications used to develop the existing
Commingled Remains Analytics (CoRA) web application for Defense POW/MIA
Accounting Agency (DPAA). The document will provide a clear understanding of how
to set up the system locally, configurations for testing environment, any
potential issues that may arise and how to resolve them.

<a name="terms/definitions"></a>
Terms/Definitions
-----------------

The CoRA web application, database and APIs are a community resource for
inventorying assemblages of commingled human remains which are often encountered
in archaeological and forensic contexts, while providing a framework of analytic
methods, visualization techniques and tools to assist in the segregation and
identification process. The application is an enhancement of existing CoRA web
application layout, in order to bring progressive front-end design for the
users. These enhancements for the application will allow users to access the
website and use the full range of application features since it embraces both
the desktop and mobile universes with responsiveness, flexibility, and
extensibility.

**Terms used in this document shall have the following meanings:**

| **Terms**            | **Definition**                                                                                                                                                                                               |
|----------------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| Agile                | A software development project management methodology that is based on iterative development; it emphasizes on evolving solutions and client interaction                                                     |
| Composer             | Used to manage Laravel dependencies                                                                                                                                                                          |
| Git                  | A version control system which is used to maintain the versions of code during its development                                                                                                               |
| GitHub               | A website for free remote git repository which can be used to collaborate development among teams/developers                                                                                                 |
| Pull                 | Send code from the online code repository to the developer’s local machine                                                                                                                                   |
| Push                 | Send code from the developer’s local system to the online code repository                                                                                                                                    |
| Heroku               | Cloud platform based on a managed container system, with integrated data services and a powerful ecosystem, for deploying and running modern apps.                                                           |
| PostgresQL           | It is a free and open-source relational database management system emphasizing extensibility and technical standards compliance. Database management system used in Heroku.                                  |
| PHPStorm             | Standard development IDE                                                                                                                                                                                     |
| PHP                  | Scripting language                                                                                                                                                                                           |
| Vue.js               | It is an open-source Model–view–viewmodel JavaScript framework for building user interfaces and single-page applications.                                                                                    |
| Vuetify              | It is a Material Component Framework for Vue applications. It is a semantic component framework for Vue. It aims to provide clean, semantic and reusable components that make building your application fast |
| Vagrant              | It is an open-source software product for building and maintaining portable virtual software development environments                                                                                        |
| Oracle VM VirtualBox | It is a free and open-source hosted hypervisor for x86 virtualization, developed by Oracle Corporation. Supported version for this project is below 6.1                                                      |
| Laravel              | An open source MVC framework built with Php (https://laravel.com/). Provides a rich set of application-level add-on packages and has a dedicated dependency manager called Composer                          |
| Postman              | The Collaboration Platform for API Development. It is used for API testing                                                                                                                                   |
| Laravel Dusk         | Dusk is an end-to-end browser testing tool for JavaScript enabled applications.                                                                                                                              |
| Selenium             | Open source programs used to automate the testing of a web application.                                                                                                                                      |

<a name="systemrequirements"></a>
SYSTEM REQUIREMENTS
===================

<a name="hardwarerequirement"></a>
Hardware Requirements
---------------------

CoRA is a web browser-based application which can be accessed either through a
browser on a desktop, laptop or a mobile device. It is recommended that the
browsers being used are compatible with HTML5 and CSS3.

**Commonly used browsers and the recommended versions:**

Google Chrome, Microsoft Edge

**Commonly used mobile browsers and the recommended versions:**

Google Chrome, Microsoft Edge

For developing the application, an application, database and a web server are
needed. To run these server’s, it is recommended developers have the following
requirements installed or updated on the development environment:

**Operating Systems:** Windows 8 or higher, Ubuntu 12.0.4, MacOS 10 or higher

A 64-bit computer processor

<a name="softwarerequirement"></a>
Software Requirements
---------------------

**Application Server:** WAMP (for Windows) and MAMP (for MAC) are used for
setting up local working application servers. This local application server also
supports Apache and MySQL servers along with PHP5.

**Code Repository:** GitHub is used to store the working code remotely. To pull
the latest codes to the local machines, Git will be used to make any changes to
the code repository.

**Code Editor:** PhPStorm is preferred, but any code editors such as
TextWrangle, Sublime Text will also work.

**Composer:** A dependency manager for Laravel Project

**Frameworks:** Laravel, Bootstrap. Will be using the latest version of
frameworks for this project.

**Git:** A version control system which is used to maintain the versions of code
during its development

**GitHub:** A website for free remote git repository which can be used to
collaborate development among teams/developers. It can also be considered as a
place to host source code that can be shared with anyone across the globe.
[<https://github.com/>].

**Heroku:** A PAAS (Platform as a service) solution for hosting and running
applications entirely on the cloud. Using this, we can significantly reduce the
time and money on our infrastructure needs. It supports applications of many
languages and can spin up and run many kinds of server infrastructure which is
scalable when needed.

**Laravel:** An open source MVC framework built with Php
[<https://laravel.com/>]. We will be using the latest version of Laravel which
will be released in February 2020.

**PhpStorm**: An IDE (Integrated Development Environment) with many features
like git console integration etc., which is useful for reducing the effort of
programmers [<https://www.jetbrains.com/phpstorm/>].

**Composer:** Dependency manager in Laravel

**Programming Languages/Scripting Languages:** Php, SQL, HTML, CSS

**Vue.js:** It is an open-source Model–view–viewmodel JavaScript framework for
building user interfaces and single-page applications.

**Vuetify:** It is a Material Component Framework for Vue applications. It is a
semantic component framework for Vue. It aims to provide clean, semantic and
reusable components that make building your application fast
[<https://vuetifyjs.com/en/>].

**PostgreSQL**: It is a free and open-source relational database management
system emphasizing extensibility and technical standards compliance.

**Vagrant:** It is an open-source software product for building and maintaining
portable virtual software development environments.

**Oracle VM VirtualBox:** It is a free and open-source hosted hypervisor for x86
virtualization, developed by Oracle Corporation. Supported version for this
project is below 6.1

**JavaScript frameworks/libraries/packages:** npm, Webpack

<a name="operatingenv"></a>
OPERATING ENVIRONMENT
=====================

<a name="localdev"></a>
Local Development Environment
-----------------------------

**This documentation was created at the time of CoRA version 2.5. Hereby noted as "cora25".**

1.  Install PhpStorm: [https://www.jetbrains.com/phpstorm/]

2.  Download Virtual Box: [https://www.virtualbox.org/wiki/Downloads] 
    __2a.__ v6.1 _As of April 27, 2020 - Vagrant requires Version 6.1_ 

3.  Download Vagrant: [https://www.vagrantup.com/downloads.html]

**You can check the vagrant version installed through the command `vagrant --version`
As of April 2020, Laravel requires a user to have version 7 installed.**

4.  Install the Laravel Homestead Vagrant Box: `vagrant box add laravel/homestead`
    **4a**. Check to see if Vagrant Box was properly installed: `vagrant box list`

5.  Installing Homestead

* Clone Homestead: 

(Consider cloning the repository into a Homestead folder within your "_home_"
directory, as the Homestead box will serve as the host to all of Laravel
projects)

__Mac__: `git clone https://github.com/laravel/homestead.git \~/Homestead`

__Windows__: `git clone https://github.com/laravel/homestead.git`

* You should check out a tagged version of Homestead since the master branch may not always be stable: `cd` into `~/Homestead` then run command:
`git checkout release`

* Create the Configuration file for the Homestead Box. `cd` into `\~/Homestead`

* Create the `Homestead.yaml` file: 

    __Mac__: `bash init.h`

    __Windows__: `bash init.bat`

6.  Clone the CoRA project from the cora25 repository. 
* Recommended location for the cora25 project is within a **code** directory.

__Mac__: `~/code`

__Windows__: `C:/code`

**Clone the project with this command**: `git clone https://github.com/SachinPawaskarUNO/cora25.git`

7.  Configure Homestead.yaml

* Generate SSH Keys through below command in /Homestead if it is not generated
`_ssh-keygen -t rsa -C \"you\@homestead\"_`

* If cora25 is not in the recommended **code** directory, then you will need to update the map to match your local path.

 __Mac__:
 
        Folders: 
           - map: ~/code 
             to: /home/vagrant/code 
        Sites: 
           - map: cora25.test 
             to: /home/vagrant/code/cora25/public 

__Windows__:

        Folders: 
           - map: C:/Users/*user_name*/Code 
             to: /home/vagrant/code 
        Sites: 
           - map: cora25.test 
             to: /home/vagrant/code/cora25/public 
              
* Databases: Not required, as the database is hosted on AWS. Contact Dr. Sachin Pawaskar for credentials.

8.  Hostname Resolution

The hosts file will redirect requests for your Homestead sites into your Homestead machine. 
On Mac and Linux, this file is located at `/etc/hosts`. On Windows, it is located at `C:\Windows\System32\drivers\etc\hosts`

**Add the following line to the hosts file**:
`192.168.10.10   cora25.test`

* Make sure the IP address listed is the one set in your Homestead.yaml file

**Remember**: Every time you edit the Homestead.yaml file, you must run the command: `vagrant reload --provision`

9.  Launch Vagrant Box

Once you have edited the Homestead.yaml, run the following command from your Homestead directory.

**Command**: `vagrant up`

10.  Log into your machine with the command: `vagrant ssh`

11.  When the vagrant is up and running, `cd` into the project `/code/cora25` and run the following commands:

12. `composer install`

13. `php artisan key:generate` 

14. `cp .env.example .env`

When everything is installed, you can access the site via: [http://cora25.test]

**Common Installation Errors**

**Error:** "Plugin Installation Failed" or "RuntimeException"
**Solution:** 
    1. `composer require symfony/asset`
    2. `composer update` 
    3. `composer install` (if `composer update` does not work)

<a name="github"></a>
Git and GitHub
--------------

In order to modify a code, you need to have the code repository on your local machine. For that, the user needs to clone a repository from GitHub to the local machine.

**Prerequisite:**

1.  To access the cora25 repository. Select ‘Clone or download’ and copy the url

![](media/CoRA_Respository.png)

2. **Mac:** Open terminal and navigate to the directory you want your code to
be in. Type ‘_git clone \<the url you copied\> and hit enter_. This will
create a local repository for your project.

**Windows:** Open Git bash and navigate to the directory you want your code
to be in. Type ‘_git clone \<the url you copied\> and hit enter_. This will
create a local repository for your project.

3. PhpStorm IDE comes with a powerful Git Gui that you can use to commit and
push your code. First, check what branch you are currently in. When you open
your IDE, you can see the current branch on the bottom left corner.

![](media/CurrentBranch.png)

4. You can check out a new branch by clicking and picking a branch or by simply creating a new one.

5. When you make any modification and would like to commit your changes, you need to navigate to VCS and select commit.

6. PhpStorm GUI allows you to check all the changes that were not committed. You can review, select, unselect, or modify the files. Once finished make sure to add a message, the author and click Commit.

![](media/CheckChangesinGUI.png)

7. To push the changes to Github, click VSC and select Git-\>Push

8. GUI screen will show which branch your local changes will be pushed. You can click Push (all the changes will be pushed to Github to the branch specified) or Cancel if there are any issues.

![](media/ClickPushToGithub.png)

<a name="commands"></a>
JOB COMMANDS
============

Job commands are developed in CoRA to generate massive data that are used for analysis purposes. These commands are mainly based on the structure of Laravel Artisan. There are two categories of job commands in CoRA, which are statistics and analytics.

1.  **Statistics**

Statistics provides aggregation of specimen, DNA, isotope, project, and user
data for a given project, organization, or user. The list of commands created is
the following:

| Command Name         | Options                                                                                   | Description                                                                             |
|----------------------|-------------------------------------------------------------------------------------------|-----------------------------------------------------------------------------------------|
| cora:project-summary | \--org = specific org --project = specific project --report-type = daily\|weekly\|monthly | This command creates a general project summary or daily/weekly/monthly project summary. |
| cora:org-summary     | \--org = specific org                                                                     | This command creates an org summary.                                                    |
| cora:user-summary    | \--org = specific org --user = specific user                                              | This command creates a user summary.    

2.  **Analytics**

Analytics contains more complex functionalities. This category of commands
calculates possible refits, articulations, and pair matching based on certain
criteria.

| Command Name               | Options                                                                                             | Description                                                                                                                                                                                                          |
|----------------------------|-----------------------------------------------------------------------------------------------------|----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| cora:se-refits-using-zones | \--org = specific org --project = specific project --max-overlap-number=3 --refit-matches-number=16 | This command generates all potential refits for each incomplete specimen. - Max-overlap-number defines the desired number of overlapping zones. - Refit-matches-number defines the desired number of matching zones. |
| cora:se-articulations      | \--org = specific org --project = specific project                                                  | This command generates all possible articulations for each specimen that can be articulated.                                                                                                                         |
| cora:se-pair-matching      | \--org = specific org --project = specific project                                                  | This command generates all possible pair-matches for each specimen that can be paired.                                                                                                                               |
| cora:se-methodfeature      | \--org = specific org --project = specific project                                                  | This command generates all specimens that have a similar age interval of a given specimen.                                                                                                                           |
                         
                          
**The following diagrams show the algorithm behind each command of analytics:**

\- **Refits using zones**

![](media/Refits_using_zonesDiagram.png)

\- **Articulations**

![](media/ArticulationsDiagram.png)

\- **Pair matching**

![](media/PairmatchingDiagram.png)

\- **Method features**

![](media/MethodFeatureDiagram.png)

**To run a job command in the local environment:**

1.  On a command line interface, run vagrant ssh

2.  Go to the project directory

3.  Run php artisan \<\<name-of-the-command\>\>

![](media/job_run_command.png)

<a name="qa"></a>
QUALITY ASSURANCE
=================

Both API testing and User Interface(UI) testing are conducted through Postman
within two different environments - local and development. Testing can be
conducted outside of Postman with leveraging Newman or in Postman. When we are
testing in the local environment, we need to ensure that the local application
is up and running. Testing in the development environment can be conducted
without having the local application up and running. The specific steps are
listed as follows:

**Step 1 -** Download & Install Postman

[<https://www.postman.com/downloads/>]

**Step 2 -** Launch the Vagrant Box with the command ‘vagrant up’ and run the
application ‘cora25.test’ - As this step makes sure that the local APIs and the
local application UIs are up and running, it is only required when testing
against the local environment is conducted.

**Step 3 -** Open the Postman application

![](media/Postman_application.png)

**Testing is divided into two categories:**

1.  API testing - Testing for all APIs used for getting, creating and updating
    data in the application

2.  UI testing - Testing the user interface components of the application.

**Step 4 -** API testing

Environment variables can be set up with clicking on the “eye” icon at the top
right of the Postman application. Different tokens represent different user
roles, which should have different rights of accesses and whose accesses are
validated with API testing.

**Local Environment Variable:**

![](media/LocalEnvironmentVariables.png)

**Development Environment Variables:**

![](media/DevEnvironmentVariables.png)

| **Globals**  |                   |                   |
|--------------|-------------------|-------------------|
| **VARIABLE** | **INITIAL VALUE** | **CURRENT VALUE** |
| specimen_id  | 27987             | 27987             |
| dna_id       | 5663              | 5663              |

For each API test you will need to set the following criteria to run the
requests:

-   Method - GET, POST, PUT, etc.

-   URL

-   Parameters - depending on whether they are required or not

-   Authorization

-   Tests

As an example the API tests for ‘GET Tags’ & POST Tags’ will be demonstrated in
this manual.The remaining API tests can be accessed through the shared Postman
Workspace

-   Set the Method, add the URL and set the parameters if required

![](media/AddRequest.png)

-   Add the Authorization Token with type Bearer Token

![](media/Authorization_Token.png)

-   Add body in the ‘raw’ JSON format (ONLY FOR POST & PUT METHODS)

![](media/Addbody.png)

-   Add Test Script

![](media/AddTestScript.png)

-   Once everything is set, enter ‘Send’. If the Test passed you should see a
    green ‘PASS’ marked for each Test criteria set in the script

![](media/TestResults.png)

-   The Table below shows a list of all API requests that were tested and their
    corresponding URLs. Depending on the environments tested against, the root
    urls differ((hereinafter referred to as {root_url}), being
    [<http://cora25.test>] for the local
    environment and [<https://cora-vuetify-dev.herokuapp.com>] for the
    development environment.

| **NAME**                            | **URL**                                                                                            |
|-------------------------------------|----------------------------------------------------------------------------------------------------|
| get projects                        | {root url}[/api/projects](http://cora25.test/api/projects)                                         |
| get assigned userlist               | {root url}[/api/projects/13/users](http://cora25.test/api/projects/13/users)                       |
| create project                      | {root url}[/api/projects/](http://cora25.test/api/projects/)                                       |
| update project                      | {root url}[/api/projects/13](http://cora25.test/api/projects/13)                                   |
| get dashboard                       | {root url}/api/dashboard/projects/specimens/complete                                               |
| get specific dna                    | {root url}/api/dnas/5642                                                                           |
| get all dnas                        | {root url}/api/dnas/?se_id=27967                                                                   |
| create dna                          | {root url}/api/dnas                                                                                |
| update dna                          | {root url}/api/dnas/5642                                                                           |
| create an isotope                   | {root url}/api/isotopes/2                                                                          |
| update an isotope                   | {root url}/api/isotopes/2                                                                          |
| get isotopes                        | {root url}/api/isotopes/                                                                           |
| get specific isotope                | {root url}/api/isotopes/9                                                                          |
| get isotopes under one specimen     | {root url}/api/isotopes?se_id=27968                                                                |
| get zones                           | {root url}/api/base-data/zones?list&id=37                                                          |
| edit zones                          | {root url}/api/specimens/27968/associations                                                        |
| edit articulations                  | {root url}/api/specimens/27968/associations                                                        |
| get method feature by Id            | {root url}/api/specimens/27968/associations?method_id=301& type=methodfeatures                     |
| get measurements                    | {root url}/api/specimens/27988/associations?type=measurements                                      |
| edit method feature                 | {root url}[/api/specimens/27968/associations](http://cora25.test/api/specimens/27968/associations) |
| edit pathology                      | {root url}/api/specimens/27968/associations                                                        |
| get pathology                       | {root url}/api/specimens/27968/associations?type=pathologies                                       |
| get trauma                          | {root url}/api/specimens/27971/associations?type=traumas                                           |
| get methods                         | {root url}/api/specimens/27987/associations?type=methods                                           |
| edit methods                        | {root url}[/api/specimens/27968/associations](http://cora25.test/api/specimens/27968/associations) |
| get method feature                  | {root url}/api/specimens/27987/associations?type=methodfeatures                                    |
| get morphologies                    | {root url}/api/specimens/27968/associations?type=morphologies                                      |
| edit anomaly                        | {root url}/api/specimens/27968/associations                                                        |
| get bones in a group                | {root url}/api/base-data/bones/bones-in-group                                                      |
| get all bones                       | {root url}/api/base-data/bones/                                                                    |
| get all reviews                     | {root url}/api/review/                                                                             |
| create a review                     | {root url}/api/review/                                                                             |
| get measurements under one bone id  | {root url}/api/base-data/measurements?list&id=37                                                   |
| get articulations under one bone id | {root url}/api/base-data/bones/articulations?list&id=37                                            |
| get zones under one bone id         | {root url}/api/base-data/zones?list&id=37                                                          |
| get DNAs under one specimen         | {root url}/api/review/27988                                                                        |
| get measurements under one specimen | {root url}/api/review/27988                                                                        |
| get Articulations for a specimen    | {root url}/api/specimens/28054/associations?type=articulations                                     |
| get Taphonomies for a specimen      | {root url}/api/specimens/28054/associations?type=taphonomys                                        |
| get tags                            | {root url}/api/tags                                                                                |
| create a tag                        | {root url}/api/tags                                                                                |

All other remaining Data for API testing including Parameters, Authorization,
Body & Test scripts can be accessed via the shared Postman workspace.

**Step 6 -** UI testing

In UI testing, a token is needed every time for a user to load a page. The token
generated by Laravel is refreshed for every single page loading, and thus a new
token is required every time before we send the request to the frontend url
through Postman. The generation of the new token for each page is done through
pre-request scripts in Postman.

The same Local and Development Environment variables are used as for API
testing.

As an example the UI test only for **‘Login’** will be demonstrated in this
manual. The remaining UI tests can be accessed through the shared Postman
Workspace.

-   Set the Method, add the URL and set the parameters if required

![](media/UiTestingAddURL.png)

-   Add the X-CSRF-TOKEN in the ‘Headers’ section

![](media/UiTestingHeaders.png)

-   Add the ‘email’ and ‘password’ in the ‘Body’ section

![](media/UiTestingAddBody.png)

-   Add the Pre-request Script

![](media/UiTestingPreRequestScript.png)

-   Once everything is set, enter ‘Send’. If the Test passed you should see a
    status ‘200 Ok’ marked.

![](media/UiTestingSend.png)

The Table below shows a list of all UI requests that were tested and their
corresponding URLs. Depending on the environments tested against, the root urls
differ((hereinafter referred to as {root_url}), being
[<http://cora25.test>] for the local
environment and [<https://cora-vuetify-dev.herokuapp.com>] for the development
environment.

| **SCREEN**                 | **FUNCTION**                                       | **PAGE NAME**                   | **LOCAL LINK**                                                                                               |
|----------------------------|----------------------------------------------------|---------------------------------|--------------------------------------------------------------------------------------------------------------|
| **Login**                  | login                                              | login page                      | [{root url}/login](http://cora25.test/login)                                                                 |
|                            |                                                    |                                 |                                                                                                              |
| **Specimen**               |                                                    |                                 |                                                                                                              |
| Specimen                   | Specimen create                                    | Specimen create                 | [{root url}/skeletalelements/create](http://cora25.test/skeletalelements/create)                             |
|                            | Specimen Update                                    | specimen edit and specimen view | [{root url}/skeletalelements/27971](http://cora25.test/skeletalelements/27971)                               |
| **Biological profile**       | Biological Profile- Create Method                  | Create Method                   | [{root url}/skeletalelements/27968/age](http://cora25.test/skeletalelements/27968/age)                       |
|                            | Age                                                |                                 |                                                                                                              |
|                            | Ancestry                                           |                                 |                                                                                                              |
| **DNA Profile**                | DNA Profile - Edit dna                             | Edit DNA                        | [{root url}/skeletalelements/27987/dnas/5663/edit](http://cora25.test/skeletalelements/27987/dnas/5663/edit) |
|                            | DNA Creation                                       | Create DNA                      | [{root url}/skeletalelements/27987/dnas](http://cora25.test/skeletalelements/27987/dnas)                     |
| **Isotope Analysis**          | Isotope Create, Update                             | Isotope Create, Update          | [{root url}/isotopes/27971](http://cora25.test/isotopes/27971)                                               |
| **Taphonomy**                  | Taphonomy Create, Update, Delete                   | Taphonomy                       | [{root url}/skeletalelements/28054/taphonomys](http://cora25.test/skeletalelements/28054/taphonomys)         |
| **Zonal classification**       | Zones                                              | Fetch and update                | [{root url}/skeletalelements/27968/zones/](http://cora25.test/skeletalelements/27968/zones/)                 |
| **Measurements**               | Measurements Update                                | Measurements                    | [{root url}/skeletalelements/27971/measurements/](http://cora25.test/skeletalelements/27971/measurements/)   |
| **Associations**               | Articulations                                      | Articulations                   | [{root url}/skeletalelements/28054/articulations\#](http://cora25.test/skeletalelements/28054/articulations) |
|                            | Refits                                             | Refits                          | [{root url}/skeletalelements/28054/refits](http://cora25.test/skeletalelements/28054/refits)                 |
|                            | Pairs                                              | Pairs                           | [{root url}/skeletalelements/28054/pairs](http://cora25.test/skeletalelements/28054/pairs)                   |
|                            | Morphology Create, Update, Delete                  | Morphology                      | [{root url}/skeletalelements/28054/morphologys](http://cora25.test/skeletalelements/28054/morphologys)       |
| **Pathology,Trauma & anomaly** | Pathologies Create, Update                         | Pathologies Create, Update      | [{root url}/skeletalelements/27971/pat](http://cora25.test/skeletalelements/27971/pat)                       |
| **Review**                     | Review                                             | Create and get review           | [{root url}/skeletalelements/27968/review](http://cora25.test/skeletalelements/27968/review)                 |
| **Tags**                       | Tags Create, Update, Delete                        | Tags                            | [{root url}/skeletalelements/28054/edit](http://cora25.test/skeletalelements/28054/edit)                     |
|                            |                                                    |                                 |                                                                                                              |
| **New Bone Group**         | Create Bone By Group                               | Create Bone By Group            | [{root url}/skeletalelements/createbygroup](http://cora25.test/skeletalelements/createbygroup)               |
|                            |                                                    |                                 |                                                                                                              |
| **Reports Dashboard**      | Dashboard                                          | Dashboard                       |                                                                                                              |
|                            | Mito DNA Report Generate                           | mtDNA Report                    | [{root url}/reports/mtdna](http://cora25.test/reports/mtdna)                                                 |
|                            | Zones Report Generate                              | Zones Report                    | [{root url}/reports/zones](http://cora25.test/reports/zones)                                                 |
|                            | Methods Report : Generate                          | Methods Report                  | [{root url}/reports/methods](http://cora25.test/reports/methods)                                             |
|                            | Measurements Generate                              | Measurements Report             | [{root url}/reports/measurements](http://cora25.test/reports/measurements)                                   |
|                            | Articulation report- - Generate and reset          | Articulation report             | [{root url}/reports/articulation](http://cora25.test/reports/articulation)                                   |
|                            | specimen by individual number - Generate and reset |                                 | [{root url}/reports/individualnumber](http://cora25.test/reports/individualnumber)                           |
|                            | Trauma report - Generate and reset                 | Trauma report                   | [{root url}/reports/traumas](http://cora25.test/reports/traumas)                                             |
|                            | Anomaly report - Generate and reset                | Anomaly report                  | [{root url}/reports/anomalys](http://cora25.test/reports/anomalys)                                           |
|                            | Pathology report - Generate and reset              | Pathology report                | [{root url}/reports/pathologys](http://cora25.test/reports/pathologys)                                       |
|                            | Individual Number report - Generate and reset      |                                 | [{root url}/reports/individualnumberdetails](http://cora25.test/reports/individualnumberdetails)             |
|                            | Advanced report - Generate and reset               | Advanced report                 | [{root url}/reports/advanced](http://cora25.test/reports/advanced)                                           |
|                            |                                                    |                                 |                                                                                                              |
| **Isotope Batch**          |                                                    |                                 |                                                                                                              |
|                            |                                                    |                                 |                                                                                                              |
| **Administration**         |                                                    |                                 |                                                                                                              |
|                            | User Management                                    | Create and fetch users          | [{root url}/users](http://cora25.test/users)                                                                 |
|                            | Project Management- Create, Update and Delete      | Project management              | [{root url}/projects](http://cora25.test/projects)                                                           |
|                            | Accession Management- Create, Update and Delete    | Accession management            | [{root url}/accessions](http://cora25.test/accessions)                                                       |
|                            | Instrumentation Create, Update, Delete             | Instrumentation Management      | [{root url}/instruments](http://cora25.test/instruments)                                                     |
|                            | Haplogroup Create, Update, Delete                  | Haplogroup Management           | [{root url}/haplogroups](http://cora25.test/haplogroups)                                                     |
|                            | Tag management                                     |                                 |                                                                                                              |
|                            |                                                    |                                 |                                                                                                              |
| **User Profile**           |                                                    |                                 |                                                                                                              |
|                            | User Profile                                       | User Profile                    | [{root url}/users/245/profile](http://cora25.test/users/245/profile)                                         |
|                            |                                                    |                                 |                                                                                                              |
| **Search**                 |                                                    |                                 |                                                                                                              |
|                            | Search DNA, Specimen                               | Fetch data                      | in progress                                                                                                  |
|                            |                                                    |                                 |                                                                                                              |
| **Data API**               | **Manual testing**                                 |                                 |                                                                                                              |
|                            | Project summary                                    |                                 |                                                                                                              |
|                            | Org summary                                        |                                 |                                                                                                              |
|                            | User summary                                       |                                 |                                                                                                              |
|                            | Daily, weekly monthly summary                      |                                 |                                                                                                              |
|                            | Potential refits, articulations and pair matching  |                                 |                                                                                                              |
|                            |                                                    |                                 |                                                                                                              |
| **Dashboard**              |                                                    |                                 |                                                                                                              |
|                            | Org admin                                          |                                 |                                                                                                              |
|                            | Anthropologist dashboard                           |                                 |                                                                                                              |
|                            | project dashboard                                  |                                 |                                                                                                              |

All other remaining Data for UI testing including Parameters, Authorization,
Body & Pre-request scripts can be accessed via the shared Postman workspace. The
UI testing was only performed for necessary components. Some components only
have GET and POST methods for which the UI tests were performed whereas some
components have all methods tested for their respective UI pages.

<a name="ref"></a>
References
==========

-   [<https://www.postman.com/downloads/>]
