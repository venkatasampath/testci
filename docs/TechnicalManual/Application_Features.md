## Application Features

#### [Back](Introduction.md) |     [Home](Index.md) |     [Next](Application_Architecture.md)

**Sections:**

- [Email Notification Configuration](#email-notification-configuration)

- [Image File Upload](#image-file-upload)

* * * 

This section highlights the major application features included in the functional prototype of the inventory management system of commingled human remains. In the following sections features which need technical configurations are specified.

### Email notification Configuration

The main purpose of this module is to generate automatic emails to the Analyst, whenever a task is assigned or updated by the Admin. The emails should be specific on the task details like type, accession, number, group and due date. For this module, we have written two jobs each on new task assignment and updating task assignment, which could be triggered on the form submission related to the task assignment. We also have configured gun mail as the service provider instead of SMTP (Simple Mail Transfer Protocol) so that the security of the mail is taken care of by an SSL (Secure Sockets Layer) certificate, provided by registering in our domain on gunmail.org.

#### Steps to configure:


1. Add the cacert.pem file to your apache/lib directory. Download [here](
http://curl.haxx.se/docs/caextract.html).
2. Update the apache/bin/php.ini and php/php.ini files

    [curl]
    
    ; A default value for the CURLOPT_CAINFO option. This is required to be an
     
    ; absolute path.
    
    curl.cainfo = "C:/wamp/bin/apache/apache2.4.18/lib/cacert.pem"
    
3. Install guzzlehttp via composer
    ```bash
    composer require guzzlehttp/guzzle
   ```
4. Create jobs queue table migration
    ```bash
    php artisan queue:table
    php artisan migrate
   ```
5. Change QUEUE_DRIVER in .env file from sync to database
6. Update your App\Console\Kernel.php class script by adding the following to your schedule
method
    * $schedule->command('queue:work')->everyMinute();
    
### Image File Upload

This section describes steps the system administrator can use to replace zone and measurement images files used in the CoRA system. The tables below document the name of the individual zones and measurements used in the system and their respective image file names that the system is designed to use.

#### Steps to Replace Image Files

To replace an image file, the replacement file must be named exactly as shown in the tables below.

1. Name the new image file based on the ‘File Name’ column in the table.
2. Navigate to the appropriate folder (noted below) and change the name of the current image file to
something new. For example, appending “_old” to the end of the file name will prevent it from interfering with the new file.

    a. public\images\zones
    
    b. public\images\measurements
    
3. The new image will now show after refreshing the web browser.

The list of file names are provided in Appendix I

***

#### [Back](Introduction.md) |     [Home](Index.md) |     [Next](Application_Architecture.md)
