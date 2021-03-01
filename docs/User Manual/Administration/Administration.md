## User Management, Profile, & Permissions

* [Administration](#administration)
    * [User Management](#user-management)
    * [Project Management](#project-management)
    * [Accession Management](#accession-management)
    * [Instrument Management](#instrument-management)
    * [Haplogroup Management](#haplogroup-management)
    * [Tag Management](#tag-management)
* [Dashboard](#dashboard)
* [User Profile](#user-profile)
    * [Profile](#profile)
    * [User General](#user-general)
    * [Project](#project)
    * [Notification](#notification)
    * [User Localization](#user-localization1)
    * [Last Logon](#last-logon)
    * [User Activity](#user-avtivity)
* [Org Profile](#org-profile)
    * [Org General](#org-general)
    * [Unit of measure](#unit-of-measure)
    * [Org Localization](#org-localization)
    * [API Keys](#apikeys)
    
The administration section is authorized only to an Org Administrator. The Org Admin takes the responsibility of creating and managing the Users, Projects, Accession, Instruments, Haplogroup and Tag.

### User Management

The user management screen provides the information related to the users such as Name, Role, Email, Cell Phone, Active Status, Country, Language, Time Zone, IP Address and Last Activity. The users list will be sorted based on the Name and Email. It also has the ability to reset the password of each user by clicking on the Action column as shown below.


To edit an existing user information, Click on the Name and the dialog box will open for editing the existing user information. The following fields are available in “Update User” dialog box, click Save when finished editing, or Close undo the changes.

- First Name
- Last Name
- Email Address
- Cell Phone
- Active Status
- Instruments
- Country
- Timezone
- Languages
- Select the role

Navigation to the User Management Screen is shown below. The column visibility will allow Users to add more details to the list. The Search tab can be used to search any details in the list. The Create button opens a dialog box to prompt to create a new user. Click on the user name to edit the user information. Click on the actions icon to change the password.

![](media/UserManagement.gif)

### Project Management

The Project list screen provides the information related to the project such as its Name, Description, Manager, Start Date, Status and whether it is Public or not. The Org Admin will be able to add users to specific projects through the 'Assigned Users' field. From the dropdown box, the OrgAdmin adds users to the project and clicks save option. The following fields are available in “Update Project Profile” dialog box, click Save when finished editing, or Close undo the changes.

- Description
- Status
- Manager
- Start Date
- Latest MCC Date
- Geo Latitude
- Geo Longitude
- Slack Channel
- Public Status
- Allow Users to Create Accessions
- Assigned Users
- Assigned Instrument

Navigation to the Project Management Screen is shown below. The column visibility will allow Users to add more details to the list. The Search tab can be used to search any details in the list. The Create button opens a dialog box to prompt the user to create a new project. Click on the project name to edit the project information.

![](media/ProjectManagementScreen.gif)

### Accession Management

The Accession list screen provides the information of the accession details associated with the project such as Projects, Key, Number, Provenance 1 and Provenance 2. The Org Admin can choose a specific project from the drop down option to assign the accession details. The following fields are available in “Update Accession” dialog box, click Save when finished editing, or Close undo the changes.

- Number
- Provenance 1
- Provenance 2

Navigation to the Accession Management Screen is shown below. The column visibility will allow Users to add more details to the list. The Search tab can be used to search any details in the list. The Create button opens a dialog box to prompt the user to create a Accession. Edit and delete icon are also shown.

![](media/AccessionManagment.gif)

### Instrument Management

The Instrument list screen provides the list of all Instruments with Code, Module, Category, Reference and Assigned Users fields. The Org Admin will also be able to edit the users associated with the instrument by clicking the dropdown "Assigned Users". The following fields are available in “Update Instrument” dialog box, click Save when finished editing, or Close undo the changes.

- Code
- Category
- Module
- Reference 
- Assigned Users

Navigation to the Instrument Management Screen is shown below. The column visibility will allow Users to add more details to the list. The Search tab can be used to search any details in the list. The Create button opens a dialog box to prompt the user to create a Instrument. Edit and delete icon are also shown.

![](media/InstrumentManagement.gif)

### Halpogroup Management

The Haplogroup list screen provides the list of all Haplogroups with their columns such as Type, Letter, Subgroup and Ancestry. The following fields are available in the “Update Haplogroup” dialog box, click Save when finished editing, or Close to undo the changes.

- Type
- Letter
- Subgroup
- Ancestry

Navigation to the Accession Management Screen is shown below. The column visibility will allow Users to add more details to the list. The Search tab can be used to search any details in the list. The Create button opens a dialog box to prompt the user to create a Haphlogroup. Edit and delete icon are also shown.

![](media/HaphlogroupManagement.gif)

### Tag Management

The Tag list screen provides the list of all Tags associated with Specimen or DNA. The following fields are available in the "Edit Tag" dialog box, click Save when finished editing, or Cancel to undo the changes and close the dialog box.

- Tag Name
- Description
- Color
- Select Project
- Category
- Type
- Icon

Navigation to the Tag Management Screen is shown below. The column visibility will allow Users to add more details to the list. The Search tab can be used to search any details in the list. The Create button opens a dialog box to prompt the user to create a Tag. Edit and delete icon are also shown.

![](media/TagManagement.gif)


## Dashboard

Project Dashboard only available for Org Admin

Individual Dashboard available for Individual Users

### User Profile

The User profile screens are to gather information and preference of the user so the cora25 website becomes user friendly by adopting to the needs of the user. The User can navigate to the profile by clicking on the avatar icon on the right top corner. There are tabs that have different sets of form inputs.

#### Profile

Profile tab has the details about the user. There are fields like Name, Email,
Organization name, Cell phone, Alternative number, slack channel.

The Email and the Organization name are not editable.

#### User General

This tab has options for users to select the lines per page to control the
numbers of rows of data displayed for views with tables. The user can choose to
display the Welcome Screen on startup when the user logs into the application.
Users can choose to have help slide out the right sidebar with help on screens
such as Skeletal Elements measurements, zones and methods.

#### Project

The project tab has an expansion panel for the below:

-   Project: User can set the default project to use when the user logs into the
    application.

-   Specimen: Can set the accession, provenance1 , provenance2 number that will
    be auto-populated on New Skeletal Element screen. The MRU List specimen is
    the number of Most Recently Used/Accessed (MRU List) Skeletal Elements to
    keep track of. Also there is an option for the user to set a page direct to
    any module after the creation of a new SE in specific to the SE association.

-   DNA: The user can set the lab to be auto-populated on the DNA association
    screen for Skeletal Element. Users can add a configurable default search
    option to use for quick search. The DNA method will be auto-populated on
    Y-STR, auSTR DNA associations for Specimens based on the selections in the
    tab. Also the user can choose to select an option that will use older DNA
    sample record information if a new DNA sample record exists but has NULL
    values.

-   Search: The user can set a default search option. Can save the last used
    Search By criteria and the search will be defaulted to this saved Search By
    criteria. Finally can select a choose to open the Skeletal Element on the
    Search screen in a new tab.

#### Notification

There are options for users to choose to receive notification when either an
export or import job is completed that was initiated by that user, when a
skeletal element has been marked as reviewed. The notification can be through
Email, SMS, Slack and the user can also select this medium.

#### User Localization

This tab is to set the user’s home county, default Language and Default Time
zone.

#### Last Logon

The last logon shows the details such as last login time, Device, Total Number
of logins, IP address and Password last changed.

#### User Activity

This tab shows the user activity feed for specimens as a table with columns such
as Key, Name, Side, Completeness and Updated At details. Also there is the user
activity feed table for DNA with the fields such as key, Mito sequence Number,
Mito sequence subgroup and Update at columns with details.

![](media/UserProfile.gif)

### Org Profile


#### Org General

In this tab the user can configure the URL for the welcome screen that is
displayed to the user on startup when the user logs into the application and
turn on a switch to automatically add the CoRA Demo project for new users
created in this organization.

#### Unit of Measure

The user can save the unit of measure used for mass/weight and
length/measurement fields within all projects in this organization.

#### Org Localization

This tab is to set the user’s home county, default Language and Default Time
zone.

#### API Keys

The API keys tab has the option for the user to enter the Organization API URL
for Slack Webhook, this is required to send messages via slack. A field to enter
the Organization Slack Channel, this is the channel that the org slack messages
will be sent to and lastly can save the Organization API Key for Google Maps,
this is required to display project information on a map.

![](media/OrgProfile.gif)