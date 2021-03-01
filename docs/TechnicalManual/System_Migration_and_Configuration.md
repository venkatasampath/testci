## System Migration and Configuration

#### [Back](Security_Design_and_Configuration.md) |     [Home](Index.md) |     [Next](Glossary.md)

**Sections:**

- [Application Requirements](#application-requirements)

- [Code Migration](#code-migration)

* * *

This section is specific to migration requirements and processes based on the Heroku web platform as they 
pertain to PHP applications. This section summarizes information found on the Heroku website, specifically 
in the section [‘Deploying PHP Apps on Heroku’](https://devcenter.heroku.com/articles/deploying-php).

### Application Requirements

* PHP and Composer must be installed.

* A PHP application that uses Composer for dependency management.

* A Heroku account.

* Heroku Command Line Interface (CLI) is a tool “for creating and managing Heroku apps from the command line / shell of various operating systems”.

### Code Migration

**Managing Dependencies**

* Dependencies are defined in the composer.json file on the root directory of the application. This file is required, even if empty, for Composer to recognize the PHP application.

* Composer installs vendor libraries, based on dependencies defined in the composer.json file, in to the /vendor folder. At the time of installation, a composer.lock file is generated on the root.

* When dependencies are updated or modified, a new composer.lock file must be generated and the dependency changes must be committed to the Git repository using the below commands.

    Whenever the app is deployed, it looks to the composer.lock file and installs the dependencies from the /vendor folder:
    ```bash
    composer update
    ```
    ```bash
    git add composer.json composer.lock
    ```
    ```bash
    git commit
    ```
* The Profile is stored on the root as well. This file contains the command that should be used to start the app; see below.

    * web: vendor/bin/heroku-php-apache2 public/

**Deploying the Application to Heroku**

* After changes have been committed to the Heroku site, the following commands can be run to deploy the applications:
    
    ```bash
    git add .
    ```
    ```bash
    git commit -m “Added a Profile.”
    ```
    ```bash
    heroku login
    ```
    ```bash
    heroku create
    ```
    ```bash
    git push heroku master
    ```
***

#### [Back](Security_Design_and_Configuration.md) |     [Home](Index.md) |     [Next](Glossary.md)