User Manual
============

![Image result for university of nebraska omaha](../media/UNOLogo.jpg)

## Table of Contents

* [INTRODUCTION](#intro)
* [ROLES](#roles)
* [DEFINITIONS](#defintions)
* [SYSTEM REQUIREMENT](#systemreq)
* [CORA FEATURES](#corafeatures)
   * [Overview](#overview)
   * [Specimen](#specimen)
     * [Details Section](#detailssection)
       * [Biological Profile](#bp)
       * [DNA Profile](#dnaprofile)
       * [Isotope Analysis](#isotopeanalysis)
       * [Taphonomy](#taphonomy)
       * [Zonal  Classification](#zonal)
       * [Measurements](#measurement)
       * [Association](#association)
       * [Pathology](#pathology)
       * [Review](#review)
       * [New Bone Group](#newbonegroup)
* [Org Reports](#org-reports)
  * [DNA Austr Report](#dna-austr-report)  
  * [DNA Mito Report](#dna-mito-report)  
  * [DNA Ystr Report](#dna-ystr-report) 
  * [Isotopes Report](#isotopes-report) 
  * [Specimen by Individual Number Details Report](#specimen-by-individual-number-details-report)  
* [Project Reports](#project-reports)
    * [Advanced Specimen Report](#advanced-specimen-report)
    * [Anomaly Report](#anomaly-report)
    * [Articulations Report](#articulations-report)
    * [DNA Mito Report](#dna-mito-report)
    * [DNA Austr Report](#dna-austr-report)
    * [DNA Ystr Report](#dna-ystr-report)
    * [Individual Number Report](#individual-number-report)
    * [Isotopes Report](#isotopes-report)
    * [Measurements Report](#measurements-report)
    * [Methods Report](#methods-report)
    * [Pathology Report](#pathology-report)
    * [Specimens by Individual Number Report](#specimens-by-individual-number-report)
    * [Specimen Comparison Report](#specimen-comparison-report)
    * [Trauma Report](#trauma-report)
    * [Zones Report](#zones-report)
* [Administration](#administration)
    * [User Management](#usermanagement)
    * [Project Management](#projectmanagement)
    * [Accession Management](#accessionmanagement)
    * [Instrument Management](#instrumentmanagement)
    * [Haplogroup Management](#haplogroupmanagement)
    * [Tag Management](#tagmanagement)
* [Dashboard](#dashboard)
* [User Profile](#userprofile2)
    * [Profile](#profile)
    * [General](#general1)
    * [Project](#project)
    * [Notification](#notification)
    * [Localization](#localization1)
    * [Last Logon](#lastlogon)
    * [User Activity](#useravtivity)
* [Org Profile](#orgprofile)
    * [General](#general)
    * [Unit of measure](#unitofmeasure)
    * [Localization](#localization2)
    * [API Keys](#apikeys)
* [About](#aboutbox)
    * [About](#about)
    * [About Browser](#aboutbrowser)
    * [Welcome](#welcome)
    * [EULA](#eula)
* [Search - Specimen and DNA](#searchspecimenanddna)

<a name="intro"></a>
INTRODUCTION 
=============

The idea behind Cora25 is to implement VueJs which is a technical advancement to
speed up the application’s performance and to improve the user experience. “The
template, CSS, methods, props, computed values, data model, watchers, mapped
Vuex actions, state and getters, lifecycle hooks—are all kept inside the .vue
file” which makes it possible for the framework to optimize the components and
render it quickly. All the form fields such as the text fields, auto completes,
check box - switches, buttons are reusable Vue Components. The data for the
pages are fed through the APIs making the project lean toward loosely coupled
architecture and paving the way to the implementation of microservices by making
the modules independent from each other. This helps to ensure flexibility,
scalability and provides a good level of granularity of this large project. The
first step was to replace the specimen pages like the Create Specimen, View/Edit
Specimen, Biological Profile, DNA, Isotope, Taphonomy, Zones, Measurements,
Associations, Pathology, Trauma, Anomaly and Create Specimen by bone group with
Vue components, followed by the DNA screens, User Profile, User Management,
Project Management, Haplogroup Management, Instrumentation Management, Reviews,
Report screens, Report dashboard. There are data API for Analytics such as
Articulation, Pair Matching, Associations and Individual Specimens. Data jobs
are available to update Project statistics, Specimen statistics, DNA statistics,
User statistics & Org statistics.

<a name="roles"></a>
ROLES 
======

The Org Admins can create different user accounts, and can assign various roles.
Certain roles provide a specific level of access to features on the website. The
table () will provide the details of the user access to the different pages of
the website.

1.  Anthropologist

2.  DNA Analyst

3.  Isotope Analyst

4.  Org Administrator

5.  Org Manager

6.  Anthropologist – Project Lead

<a name="defintions"></a>
DEFINITIONS 
============

| Term         | Definitions                                                                                                                                                                                                                                                                                                   |
|--------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| Cora25       | The Commingled Remains Analytics (CoRA25) web application, database and APIs are a community resource for inventorying assemblages of commingled human remains, while providing a framework of analytic methods, visualization techniques, and tools to assist in the segregation and identification process. |
| Dashboard    | The Dashboard provides high-level statistical information about the skeletal elements.                                                                                                                                                                                                                        |
| Specimen     | Specimens are individual human remains that can be categorized.                                                                                                                                                                                                                                               |
| DNA          | Specimens that have had a DNA sample successfully completed will have an associated DNA Profile.                                                                                                                                                                                                              |
| Reports      | The report page allows a user to search for different skeletal elements by other categories.                                                                                                                                                                                                                  |
| Accession    | Tracking identifier, such as a laboratory or project name and/or number.                                                                                                                                                                                                                                      |
| Provenance 1 | Secondary tracking identifier, such as information related to the grave, casket, or recovery provenience.                                                                                                                                                                                                     |
| Provenance 2 | Additional tracking identifiers, such as additional information related to the grave, casket, recovery provenience, or bag number.                                                                                                                                                                            |
| Designator   | Unique number for the skeletal element.                                                                                                                                                                                                                                                                       |

<a name="systemreq"></a>
SYSTEM REQUIREMENT
==================

This application resides in the cloud and requires a browser with an
internet connection. Chrome and Firefox are recommended.

|                         | **Minimum Requirements**      | **Recommended** |
|-------------------------|-------------------------------|-----------------|
| **Internet Connection** | Cable or DSL                  |                 |
| **Internet Browser**    | Google Chrome, Microsoft Edge | Google Chrome   |


<a name="corafeatures"></a>
CORA FEATURES 
==============

This section discusses different features that are available in the Cora25 site.
Certain features are only available to specific users based on their user
profiles. Below is the table that maps features that are accessible by the user
profiles.

| **User/Feature**                        | **Specimen** |   |  |  |    |   **DNA**         |          |            |   **Isotope**          |          |            | **Administration Screen**  |  **Org Profile**  |
|-----------------------------------------|--------------|----------|-------------|---------------------------|--------------------|------------|----------|------------|-------------|----------|------------|---|---|
|                                         | **Create**   | **Edit** | **Delete**  | **View**                  | **New Bone Group** | **Create** | **Edit** | **Delete** | **Create**  | **Edit** | **Delete** |   |   |
| **Org Admin**                  | ✅            | ✅        | ✅           | ✅                         | ✅                  |            |          |            |             |          |            | ✅ | ✅ |
| **Anthro Analyst**              | ✅            | ✅        | ✅           | ✅                         | ✅                  | ✅          | ✅        |            | ✅           | ✅        |            |   |   |
| **Anthro Analyst Project Lead** |   ✅           |      ✅   | ✅            |   ✅                        |  ✅                  | ✅           |    ✅      |            |   ✅          |      ✅    |            |   |   |
| **DNA Analyst**                 |              |          |             | ✅                         |                    | ✅          | ✅        |            |             |          |            |   |   |
| **Org Manager**                |   ✅           |   ✅       |   ✅          |    ✅                       |        ✅            | ✅           |    ✅      |            |       ✅      |      ✅    |   ✅         |  ✅ |   |
| **Isotope Analyst**             |              |          |             | ✅                         |                    |            |          |            | ✅           | ✅        |            |   |   |


<a name="overview"></a>
Overview
--------

The homepage of the site is as below and the navigation is explained as well.
Although the homepage is identical to all user profiles, the options under the
Menu bar and User Avatar differ.

![](../media/homepage.png)

The top navigation bar includes

1.  Menu button

2.  Project name - The current project is displayed here and can be changed by
    selecting a different project and clicking the button next to the dropdown.

3.  search bar - skeletal elements can be filtered using the search bar. The
    search can be made based on specimens or DNA.

4.  user avatar

5.  Notifications - Notifications can be accessed from here and unread
    notification count is displayed.

The Menu shows the below-mentioned list of options.

![](../media/Menu.png)

The user avatar shows details of the user and links to access the user profile,
org profile, and button to log out. Org profile is only accessible to Org Admin
User and Org Manager User.

![](../media/useravatar.png)   

<a name="specimen"></a>
Specimen
-----------------------------------------------------------

A new specimen can be created by navigating to Menu bar -\> Specimen -\> New.
The screen is shown below. The toolbar shows the following options.

-   Expand and collapse button

-   Save button

The fields to create a new specimen are:

- Accession
- Provenance Number 1
- Provenance Number 2
- **Designator**
- **Bone**
- **Side**
- **Completeness**

The bolded fields are required. Below are some fields with some validation rule


![](../media/newspecimen.png)

Once these details are filled and the specimen is saved, a new specimen number is generated and the user is navigated to the below screen. The screen is in View state and user can edit it by clicking on the edit icon.

1.  The toolbar shows the options to the Edit/Save button and the
    Expand/Collapse button.

2.  The Details button lists all specimen associations.

![](../media/viewspecimen.png)

Below is the list of Specimen associations mentioned under the Details button.
Each option is explained in the following section.

![](../media/listofspecimen.png)

General

This tab has options for users to select the lines per page to control the
numbers of rows of data displayed for views with tables. The user can choose to display the Welcome Screen on startup when the user logs into the application.
Users can choose to have help slide out the right sidebar with help on screens such as Skeletal Elements measurements, zones and methods.

<a name="detailssection"></a>
### **Details Section:** 

<a name="bp"></a>
1.  Biological Profile

Biological Profile shows sub-options as Age, Ancestry, Sex, and Ancestry. User can add, edit or delete a method. 

Age:

![](../media/Age.gif)

Sex:

![](../media/sex.gif)

Ancestry:

![](../media/Ancestry.gif)

<a name="dnaprofile"></a>
2.  DNA Profile

The DNA Profile screen displays the following elements about a bone:

- DNA Sample Number
- Lab
- External Case #
- BTB Request Date
- BTB Results Date
- Disposition
- Sample Condition
- Weight Sample Remaining

On this screen, you can also view the "Mito", "auSTR", and "Y-STR" forms and navigate by clicking the form name or by clicking the Next button.

![](../media/DNA.gif )

<a name="isotopeanalysis"></a>
3.  Isotope Analysis

The 'Create Isotope' section allows to create a isotope for the given bone. This section has the following elements. 
- Lab
- External Case # 
- Isotope Sample Number

After you create the Isotope, you will receive the "Isotope Add Successful" message. By selecting the sample number, the Isotope screen pops up. Click on the Edit button to edit the information under each section.CLick on the Save button under each section saves the information and navigates the user to the next section of information. All the updated information can be saved at once by clicking on the ‘Save All’ button.

![](/media/Isotope.gif)

<a name="taphonomy"></a>
4.  Taphonomy

The Taphonomies section allows you to view Taphonomies for the given bone. To add Taphonomy, click the pencil icon to edit and select Taphonomies. Click the Save icon to save the changes.

![](../media/Taphonomy.gif)

<a name="zonal"></a>
5.  Zonal Classification

The Zones pane displays various zones of the bone. For example below are the following zones about the bone Radius:

- Lateral half of radial head
- Medial half of radial head
- Lateral portion of distal articulation
- Medial portion of distal articulation
- Proximal diaphysis
- Lateral half of diaphysis
- Medial half of diaphysis
- Superior half of distal third
- Lateral distal third
- Medial distal third
- Styloid process

These fields are read only - to edit then click the pencil icon. Multiple zones can be selected. All the listed Zones can be selected or deselected by clicking the ‘Select all’ check box. Click the save icon to save the changes.

![](../media/Zones.gif)

<a name="measurement"></a>
6.  Measurements

The measurements pane displays various measurements of the given bone. The following are the measurements for a given bone Radius: 
- Rad_01 Maximum Length 
- Rad_02 Maximum Diameter of the Radius at Midshaft 
- Rad_03 Minimum Diameter of the Radius at Midshaft 
- Rad_04 Maximum Diameter of the Head 
- Rad_05 Anterior-Posterior (Sagittal) Diameter at Midshaft 
- Rad_06 Medial-Lateral (Transverse) Diameter at Midshaft 
- Rad_07 Maximum Diameter at the Radial Tuberosity 
- Rad_08 Maximum Diameter of the Diaphysis Distal to the Radial Tuberosity 
- Rad_09 Minimum Diameter of the Diaphysis Distal to the Radial Tuberosity 
- Rad_10 Breadth of the Distal Epiphysis

These fields are read only - to edit, click the pencil icon. the minimum value, threshold limit and maximum limit are indicated to the user through the alerts. Click the save icon to save the changes or ‘Undo’ icon to undo all the changes made. The blue badge on top of the bone name indicates the number of measurements filled out of the total number of available measurements for that particular bone.  The pane can be expanded or collapsed by clicking on the arrow icon.


![](../media/Measurements.gif)

<a name="association"></a>

7.  Association

There are four types of associations. Process of adding each association is shown below. After the association is added, refresh the page to see the Details button updated. The details button opens a data table of all available associations under that specimen.

>   a. PAIR MATCHING

![](../media/PairMatch.gif)

>   b. REFITS

![](../media/Refits.gif)

>   c. ARTICULATIONS

![](../media/Articulation.gif)

>   d. MORPHOLOGY

![](../media/Morphology.gif)

<a name="pathology"></a>
8.  Pathology

Pathology, Trauma and Anomaly can be accessed on one screen as different tabs. The user can create a new item by clicking on the create button. 

![](../media/pathology.gif )

<a name="review"></a>
9. Review

The review tab is a pane which displays all other sub reports in one area. All reports are editable in the pane. For information on individual reports - see their detailed documentation.

![](../media/Review.gif)

<a name="newbonegroup"></a>
10.  New Bone Group

To add a new bone group - click "New Bone Group" on the left navbar. You will be taken to the "New Bone Group Page". Here you can create a superclass which can contain multiple specimens.

![](../media/NewBoneGroup.gif)

The fields to create a new bone group are:

- Bone Group
    - **Grouping**
    - Bones
    - Side (defaulted to 'Left')
    - Completeness (defaulted to 'Complete')
- Accession
    - **Accession**
    - **Provenance 1**
    - Provenance 2
    - **Starting Designator**
- Pathology
    - Trauma
    - Pathology
    - Taphonomy
    
The bolded fields are required. Once you have created a new bone group, you can edit the fields and click "Save" to update the bone group.

![](../media/CreateNewBoneGroup.gif)

## Org Reports

The Org Reports dashboard is accessible by organization admin only. You can expand/collapse all report tabs or individual tabs and also drag and rearrange the tab arrangement. This arrangement is saved even after the user logs out. This state is saved in your local storage until browser cache is cleared. Each report pane holds an image of its respective sample report showing column names of that report. 

![](../media/OrgReportDashboardGif.gif)

### DNA Austr Report

The DNA Austr Report allows a user to select by Projects, Lab, Priority, Result Status, Austr Sequence Number, and Austr Sequence Subgroup. 

***There are no fields required to generate the report.***

The search fields that are available are: 

* Projects
* Lab
* Priority
* Results Status
* Austr Sequence Number
* Austr Sequence Subgroup
* Request Dates From
* Request Dates To
* Receive Dates From
* Receive Dates To

The report will return the following results if available: 

* Project
* Key
* Bone
* Side
* Bone Group
* Individual Number
* Sample Number
* Austr Sequence Number
* Austr Sequence Subgroup
* Austr Sequence Similar
* Austr Result Status
* Austr Request Date
* Austr Receive Date

![](../media/OrgDNAAustrReportGif.gif)

### DNA Mito Report

The DNA Mito Report allows a user to select by Projects, Lab, Priority, Result Status, Mito Sequence Number, and Mito Sequence Subgroup. 

***There are no fields required to generate the report.***

The search fields that are available are: 

* Projects
* Lab
* Priority
* Results Status
* Mito Sequence Number
* Mito Sequence Subgroup
* Request Dates From
* Request Dates To
* Receive Dates From
* Receive Dates To

The report will return the following results if available: 

* Project
* Key
* Bone
* Side
* Bone Group
* Individual Number
* Sample Number
* Mito Sequence Number
* Mito Sequence Subgroup
* Mito Sequence Similar
* Mito Result Status
* Mito Request Date
* Mito Receive Date

![](../media/OrgDNAMitoReportGif.gif)

### DNA Ystr Report

The DNA Ystr Report allows a user to select by Projects, Lab, Priority, Result Status, Ystr Sequence Number, and Ystr Sequence Subgroup. 

***There are no fields required to generate the report.***

The search fields that are available are: 

* Projects
* Lab
* Priority
* Results Status
* Ystr Sequence Number
* Ystr Sequence Subgroup
* Request Dates From
* Request Dates To
* Receive Dates From
* Receive Dates To

The report will return the following results if available: 

* Project
* Key
* Bone
* Side
* Bone Group
* Individual Number
* Sample Number
* Ystr Sequence Number
* Ystr Sequence Subgroup
* Ystr Sequence Similar
* Ystr Result Status
* Ystr Request Date
* Ystr Receive Date
* 
![](../media/OrgDNAYstrReportGif.gif)

### Isotopes Report

The Isotope Report allows a user to select by project, lab, result status, and batch ID. 

***There are no fields required to generate the report.***

The search fields that are available are: 

 - Accession Number
 - Provenance 1
 - Provenance 2
 - Designator
 - Batch ID
 - Lab
 - Results Status
 - Collagen Yield From/To
 - Collagen Weight From/To
 - Carbon Weight From/To
 - Nitrogen Weight From/To
 - Oxygen Weight From/To
 - Sulfur Weight From/To
 - Carbon Percentage From/To
 - Nitrogen Percentage From/To
 - Oxygen Percentage From/To
 - Sulfur Percentage From/To
 - Carbon-to-Nitrogen Ratio From/To
 - Carbon-to-Oxygen Ratio From/To

The report will return results of of the following if it is available: 
 - Project
 - Key
 - Bone
 - Side
 - Bone Group
 - Individual Number
 - Sample Number
 - Collagen Yield
 - Collagen Weight
 - Carbon Weight
 - Nitrogen Weight
 - Oxygen Weight
 - Sulfur Weight
 - Carbon Percentage
 - Nitrogen Percentage
 - Oxygen Percentage
 - Sulfur Percentage
 - Carbon-to-Nitrogen Ratio
 - Carbon-to-Oxygen Ratio

![](../media/OrgIsotopeReportGif.gif)

### Specimen by Individual Number Details Report

The Specimen by Individual Number Details Report allows a user to select by project, individual number or bone. Either individual number or bone is required to run the report. If project is blank, the report will retrieve by individual number or bone for all projects. 

***The bolded fields are required. The user is required to select a bone or an individual number for this report.***

The search fields that are available are: 

 - Projects
 - **Individual Number**
 - **Bone**
 - Side

The report will return results of of the following if it is available: 
 - Project
 - Key
 - Individual Number
 - Bone
 - Side
 - DNA Sample Number
 - DNA Sequence Number
 - Traumas
 - Pathologies
 - Anomalies

![](../media/OrgSpecimenbyIndividualNumberDetailReportGif.gif)



## Project Reports  
  
Reports dashboard is accessible by all user profiles. You can expand/collapse all the report tabs or individual tabs and also drag and rearrange the tab arrangement. This arrangement is saved even after the user logs out. This state is saved in your local storage until browser cache is cleared. Each report pane holds an image of its respective sample report showing column names of that report.  
  
Each report tab navigates to a report criteria by selecting which each report can be generated. Once the report is generated the user can perform the following actions.  
- Collapse or expand the report criteria.  
- Choose visible columns on the report  
- Export as PDF or Excel  
- Reset the whole report  
  
![](../media/ProjectReportDashboardGIF.gif)

### Advanced Specimen Report

The Advanced Specimen Report is the most comprehensive report that is available for a skeletal element. 

***There are no fields required to generate this report.***

The search fields that are available are: 

* Accession Number
* Provenance 1
* Provenance 2
* Bone
* Side
* Completeness
* Created By
* Reviewed By
* Inventoried By

The status of the bone toggle buttons that you can enable as part of the search function are:

* Measured
* DNA Sampled
* CT Scanned
* Clavicle Triage
* Xray Scanned
* Inventory Completed
* Reviewed

![](../media/AdvancedSpecimenReportGIF.gif)

### Anomaly Report

The Anomaly Report allows a user to select by an anomaly category.

***The fields in bold are required fields in order to generate the report. The user is required to select an anomaly for this report.***

The search fields that are available are: 

* Accession Number
* Provenance 1
* Provenance 2
* Bone
* Side
* **Anomaly**

![](../media/AnomalyReportGIF.gif)

### Articulations Report

The Articulations Report allows a user to select by articulations. 

***The fields in bold are required fields in order to generate the report. The user is required to select a group and a bone for this report.***

The search fields that are available are: 

* **Group**
* Group Side
* Accession Number
* Provenance 1
* Provenance 2
* **Bone**
* Side

![](../media/ArticulationReportGIF.gif)

### DNA Mito Report

The DNA Mito Report allows a user to select DNA mitochondrial sequence numbers and subgroups. 

***There are no fields required to generate this report.***

The search fields that are available are: 

* Accession Number
* Provenance 1
* Provenance 2
* Results Status
* Mito Sequence Number
* Mito Sequence Subgroup
* Request Dates From
* Request Dates To
* Receive Dates From
* Receive Dates To

![](../media/DNAMitoReportGIF.gif)

### DNA Austr Report

The DNA Austr Report allows a user to select DNA Austr sequence numbers and subgroups.

***There are no fields required to generate this report.***

The search fields that are available are:

* Accession Number
* Provenance 1
* Provenance 2
* Results Status
* Austr Sequence Number
* Austr Sequence Subgroup
* Request Dates From
* Request Dates To
* Receive Dates From
* Receive Dates To

![](../media/DNAAustrReportGIF.gif)

### DNA Ystr Report

The DNA Ystr Report allows a user to select DNA Ystr sequence numbers and subgroups.

***There are no fields required to generate this report.***

The search fields that are available are:

* Accession Number
* Provenance 1
* Provenance 2
* Results Status
* Ystr Sequence Number
* Ystr Sequence Subgroup
* Request Dates From
* Request Dates To
* Receive Dates From
* Receive Dates To

![](../media/DNAYstrReportGIF.gif)

### Individual Number Report

The Individual Number Report allows a user to view all individual numbers and related specimen counts. 

![](../media/IndividualNumberReportMainGif.gif)

No fields are chosen on the main page, instead you can choose the individual number on the left column to be taken to the "Specimens by Individual Numbers Report" report. The following fields are available once you arrive the "Specimen by Individual Numbers Report" page: 

* Accession Number
* Provenance 1
* Provenance 2
* Individual Number (This will be pre-populated for you from the previous page)
* Bone
* Side

![](../media/IndividualNumberReportDetailsGif.gif)

Alternatively, you can click on the specimen data in the middle column to see more information about the skeletal element and whether the element was measured, DNA sampled, Isotopes sampled, CT Scanned, CT Scanned At date, X-ray Scanned, 3D Scanned, Inventory Completed status, and Inventory Date. 

You can edit the skeletal element by clicking the pencil icon on the upper right corner and update the necessary fields. 

![](../media/IndividualNumberReportSpecimenGif.gif)

### Isotopes Report

The Isotope Report allows a user to select by project, lab, result status, and batch ID. 

***There are no fields required to generate the report.***

The search fields that are available are: 

 - Accession Number
 - Provenance 1
 - Provenance 2
 - Batch ID
 - Lab
 - Results Status
 - Collagen Yield From/To
 - Collagen Weight From/To
 - Carbon Weight From/To
 - Nitrogen Weight From/To
 - Oxygen Weight From/To
 - Sulfur Weight From/To
 - Carbon Percentage From/To
 - Nitrogen Percentage From/To
 - Oxygen Percentage From/To
 - Sulfur Percentage From/To
 - Carbon-to-Nitrogen Ratio From/To
 - Carbon-to-Oxygen Ratio From/To

The report will return results of of the following if it is available: 
 - Project
 - Key
 - Bone
 - Side
 - Bone Group
 - Individual Number
 - Sample Number
 - Collagen Yield
 - Collagen Weight
 - Carbon Weight
 - Nitrogen Weight
 - Oxygen Weight
 - Sulfur Weight
 - Carbon Percentage
 - Nitrogen Percentage
 - Oxygen Percentage
 - Sulfur Percentage
 - Carbon-to-Nitrogen Ratio
 - Carbon-to-Oxygen Ratio

![](../media/ProjectIsotopeReportGif.gif)

### Measurements Report

The Measurements Report allows a user to select by individual number or bone. Either individual number or bone is required to run the report. 

***The fields in bold are required fields in order to generate the report. The user is required to select either Bone or Individual Number for this report. Only one or the other can be chosen.***

The search fields that are available are: 

 - Accession Number
 - Provenance Number 1
 - Provenance Number 2
 - **Bone**
 - Side
 - **Individual Number**
 - Side

The bolded fields are required. The user is required to select a bone or an individual number for this report. 

The report will return results of of the following if it is available: 

 - Key
 - Bone
 - Side
 - Various measurements for the bone that is chosen

![](../media/MeasurementsReportGif.gif)

### Methods Report

The Method Report allows a user to search by bones by a specific method. 

The search fields that are available are: 
  
***The bolded fields are required. The user is required to select a bone and a method for this report.***
  
- Accession Number  
- Provenance 1  
- Provenance 2  
- **Bone**  
- Method Type  
- **Method**  
- Method Feature  
- Score  
- Range  

![](../media/MethodsReportGif.gif)

### Pathology Report

The Pathology Report allows a user to select by a pathology category. 

***The bolded fields are required. The user is required to select a Pathology for this report.***

The search fields that are available are: 

* Accession Number
* Provenance 1
* Provenance 2
* **Pathology**
* Bone
* Side

![](../media/PathologyReportGif.gif)

### Specimens by Individual Number Report

The Specimens by Individual Number Report allows a user to generate a report by Individual Numbers which will return results of an Individual Number's bone, side, DNA Sample Number, DNA Sequence Number, Traumas, Pathologies, and Anomalies. 

***The bolded fields are required. The user is required to select a Individual Number for this report.***

The search fields that are available are: 

* Accession Number
* Provenance 1
* Provenance 2
* **Individual Number**
* Bone
* Side

![](../media/SpecimenIndividualNumberReportGif.gif)

### Specimen Comparison Report

The Specimen Comparison Report allows a user to compare more than two specimens side by side. The report return results of bone group, individual number, remains status, Mito Seq Number, Zones, Trauma, Pathology, Taphonomy, Paired, Refit, and Articulated. 

***The bolded fields are required. The user is required to select Bone and Bone Side for this report.***

The search fields that are available are: 

* Accession Number
* Provenance 1
* Provenance 2
* **Bone**
* **Bone Side**

![](../media/SpecimenComparisonReportGif.gif)


### Trauma Report

The Trauma Report allows a user to select by an trauma category. 

***The bolded fields are required. The user is required to select Trauma for this report.***

The search fields that are available are:

-   Accession Number
-   Provenance 1
-   Provenance 2
-   **Trauma**
-   Bone
-   Side

![](../media/TraumaReportGif.gif)

### Zones Report

The Zones Report is designed to allow a user to locate bones by specific zones. 

***The bolded fields are required. The user is required to select Bone, Zones, and Search Select type.***

The search fields that are available are: 

-   Accession Number
-   Provenance Number 1
-   Provenance Number 2
-   **Bone**
-   Side
-   **Zones**
-   **Search Select Type**

You can also select from one of 5 search types:

-   Inclusive
-   Exclusive
-   Inclusive Only
-   Exclusive Only
-   Exclusive Or
-   Not Present

![](../media/ZoneReportGif.gif )

<a name="administration"></a>
Administration 
-------------------------------

The administration section is authorized only to an Org Administrator. The Org Admin takes the responsibility of creating and managing the Users, Projects, Accession, Instruments, Haplogroup and Tag.

<a name="usermanagement"></a>
**1. USER MANAGEMENT**

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

![](../media/UserManagement.gif)

<a name="projectmanagement"></a>
**2.  PROJECT MANAGEMENT**

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

![](../media/ProjectManagementScreen.gif )

<a name="accessionmanagement"></a>
**3.  ACCESSION MANAGEMENT**

The Accession list screen provides the information of the accession details associated with the project such as Projects, Key, Number, Provenance 1 and Provenance 2. The Org Admin can choose a specific project from the drop down option to assign the accession details. The following fields are available in “Update Accession” dialog box, click Save when finished editing, or Close undo the changes.

- Number
- Provenance 1
- Provenance 2

Navigation to the Accession Management Screen is shown below. The column visibility will allow Users to add more details to the list. The Search tab can be used to search any details in the list. The Create button opens a dialog box to prompt the user to create a Accession. Edit and delete icon are also shown.

![](../media/AccessionManagment.gif)

<a name="instrumentmanagement"></a>
**4.  INSTRUMENT MANAGEMENT**

The Instrument list screen provides the list of all Instruments with Code, Module, Category, Reference and Assigned Users fields. The Org Admin will also be able to edit the users associated with the instrument by clicking the dropdown "Assigned Users". The following fields are available in “Update Instrument” dialog box, click Save when finished editing, or Close undo the changes.

- Code
- Category
- Module
- Reference 
- Assigned Users

Navigation to the Instrument Management Screen is shown below. The column visibility will allow Users to add more details to the list. The Search tab can be used to search any details in the list. The Create button opens a dialog box to prompt the user to create a Instrument. Edit and delete icon are also shown.

![](../media/InstrumentManagement.gif)

<a name="haplogroupmanagement"></a>
**5.  HAPLOGROUP MANAGEMENT**

The Haplogroup list screen provides the list of all Haplogroups with their columns such as Type, Letter, Subgroup and Ancestry. The following fields are available in the “Update Haplogroup” dialog box, click Save when finished editing, or Close to undo the changes.

- Type
- Letter
- Subgroup
- Ancestry

Navigation to the Accession Management Screen is shown below. The column visibility will allow Users to add more details to the list. The Search tab can be used to search any details in the list. The Create button opens a dialog box to prompt the user to create a Haphlogroup. Edit and delete icon are also shown.


![](../media/HaphlogroupManagement.gif)

<a name="tagmanagement"></a>
**6.  TAG MANAGEMENT**

The Tag list screen provides the list of all Tags associated with Specimen or DNA. The following fields are available in the "Edit Tag" dialog box, click Save when finished editing, or Cancel to undo the changes and close the dialog box.

- Tag Name
- Description
- Color
- Select Project
- Category
- Type
- Icon

Navigation to the Tag Management Screen is shown below. The column visibility will allow Users to add more details to the list. The Search tab can be used to search any details in the list. The Create button opens a dialog box to prompt the user to create a Tag. Edit and delete icon are also shown.

![](../media/TagManagement.gif)


<a name="dashboard"></a>
Dashboard
-----------------------------------------

1.  project dashboard - org admin

2.  individual dashboard - individual users

<a name="userprofile2"></a>
User Profile
------------------

The User profile screens are to gather information and preference of the user so the cora25 website becomes user friendly by adopting to the needs of the user. The User can navigate to the profile by clicking on the avatar icon on the right top corner. There are tabs that have different sets of form inputs.

<a name="profile"></a>
**Profile**

Profile tab has the details about the user. There are fields like Name, Email,
Organization name, Cell phone, Alternative number, slack channel.

The Email and the Organization name are not editable.

<a name="general1"></a>
**General**

This tab has options for users to select the lines per page to control the
numbers of rows of data displayed for views with tables. The user can choose to
display the Welcome Screen on startup when the user logs into the application.
Users can choose to have help slide out the right sidebar with help on screens
such as Skeletal Elements measurements, zones and methods.

<a name="project"></a>
**Project**

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

<a name="notification"></a>
**Notification**

There are options for users to choose to receive notification when either an
export or import job is completed that was initiated by that user, when a
skeletal element has been marked as reviewed. The notification can be through
Email, SMS, Slack and the user can also select this medium.

<a name="localization1"></a>
**Localization**

This tab is to set the user’s home county, default Language and Default Time
zone.

<a name="lastlogon"></a>
Last Logon

The last logon shows the details such as last login time, Device, Total Number
of logins, IP address and Password last changed.

<a name="useravtivity"></a>
**User Activity**

This tab shows the user activity feed for specimens as a table with columns such
as Key, Name, Side, Completeness and Updated At details. Also there is the user
activity feed table for DNA with the fields such as key, Mito sequence Number,
Mito sequence subgroup and Update at columns with details.

![](../media/UserProfile.gif)

<a name="orgprofile"></a>
Org Profile
------------


<a name="general"></a>
**General**

In this tab the user can configure the URL for the welcome screen that is
displayed to the user on startup when the user logs into the application and
turn on a switch to automatically add the CoRA Demo project for new users
created in this organization.

<a name="unitofmeasure"></a>
**Unit of measure**

The user can save the unit of measure used for mass/weight and
length/measurement fields within all projects in this organization.

<a name="localization2"></a>
**Localization**

This tab is to set the user’s home county, default Language and Default Time
zone.

<a name="apikeys"></a>
**API Keys**

The API keys tab has the option for the user to enter the Organization API URL
for Slack Webhook, this is required to send messages via slack. A field to enter
the Organization Slack Channel, this is the channel that the org slack messages
will be sent to and lastly can save the Organization API Key for Google Maps,
this is required to display project information on a map.

![](../media/OrgProfile.gif)

<a name="aboutbox"></a>
AboutBox
------------
It includes information about the application, and browser.

<a name="about"></a>
**About**

In this tab the application details are displayed to the user which includes
Application Name, Version, Copyright, Product Protection, Optimized for Browser, 
Supported Browsers, Popup Blocker

<a name="aboutbrowser"></a>
**About Browser**

In this tab the browser details are displayed to the user which includes
Browser Name, Browser Version, Cookies, Language, Online, Product, 
Operating System, User Agent

<a name="welcome"></a>
**Welcome**

This tab displays a short description of the application.

<a name="eula"></a>
**EULA**

This tab will be updated later.

![](../media/About.gif)

<a name="searchspecimenanddna"></a>
Search - Specimen and DNA
-------------------------
The easiest way to search for specimens is to use the top search bar in the nav bar. The Advance search bar allows the user to search the Skeletal Elements. By default, "Bone" is selected as the search option. The user can search the Skeletal Element by Bone. Once the search type is selected the user can enter the value in the search input and then click the magnifying glass to execute your search. It will list the deatils of the skeletal element for the value selected. It will display the following details:

- Key
- Bone
- Side
- Bone Group
- Individual Number
- DNA Sampled
- Mito Sequence Number
- Measured
- Isotope Sampled
- Clavicle Triage

There are some columns which are not displayed at the screen but can be made visible by checking the column visibility section. The names of those columns are given below: - CT Scanned - Xray Scanned - Inventoried - Reviewed - Inventoried By - Inventoried At - Reviewed By - Reviewed At - Created By - Created At - Updated By - Updated At

On this page you can filter how many results are shown per page, as well as search the results. To view the details of a skeletal elements, click on the key in the search results.

![](../media/search.gif)
