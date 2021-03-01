<?php

/*------------------------Breadcrumbs for Home, Eula----------------------------*/
// Home
Breadcrumbs::register('home', function ($breadcrumbs) {
    $breadcrumbs->push('Home', route('home'));
});

// Home > Eula
Breadcrumbs::register('eula', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Eula', route('eula'));
});
/*******************************************************************************/


/*------------------------Breadcrumbs for Dashboards----------------------------*/
// Home > Dashboard
Breadcrumbs::register('dashboard', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Dashboard', route('dashboard'));
});

// For Admin and OrgAdmin
// Home > Dashboard > Project Dashboard
Breadcrumbs::register('projectDashboard', function($breadcrumbs, $project) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push($project, route('projectDashboard', 'projectId'));
});

// Home > Dashboard > Details (Drilldowns)
Breadcrumbs::register('drilldown', function ($breadcrumbs, $project) {
    $breadcrumbs->parent('projectDashboard', $project);
    $breadcrumbs->push('Details', route('drilldown', 'id'));
});
/*******************************************************************************/


/*------------------------Breadcrumbs for User Management----------------------------*/
// Home > Users
Breadcrumbs::register('users.index', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Users', route('users.index'));
});

// Home > Users > Create User
Breadcrumbs::register('users.create', function($breadcrumbs) {
    $breadcrumbs->parent('users.index');
    $breadcrumbs->push('Create User', route('users.create'));
});

// Home > Users > View User
Breadcrumbs::register('users.show', function($breadcrumbs, $user) {
    $breadcrumbs->parent('users.index');
    $breadcrumbs->push('View User', route('users.show', $user->id));
});

// Home > Users > Edit User
Breadcrumbs::register('users.edit', function($breadcrumbs, $user) {
    $breadcrumbs->parent('users.show', $user);
    $breadcrumbs->push('Edit User', route('users.edit', $user->id));
});

// Home > Users > View User
Breadcrumbs::register('users.resetPassword', function($breadcrumbs, $user) {
    $breadcrumbs->parent('users.show', $user);
    $breadcrumbs->push('Reset Password', route('users.resetPassword', $user->id));
});
/*******************************************************************************/


/*------------------------Breadcrumbs for Haplogroup Management----------------------------*/
// Home > Haplogroups
Breadcrumbs::register('haplogroups.index', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Haplogroups', route('haplogroups.index'));
});

// Home > Haplogroups > Create Haplogroup
Breadcrumbs::register('haplogroups.create', function($breadcrumbs) {
    $breadcrumbs->parent('haplogroups.index');
    $breadcrumbs->push('Create Haplogroup', route('haplogroups.create'));
});

// Home > Haplogroups > View Haplogroup
Breadcrumbs::register('haplogroups.show', function($breadcrumbs, $haplogroup) {
    $breadcrumbs->parent('haplogroups.index');
    $breadcrumbs->push('View Haplogroup', route('haplogroups.show', $haplogroup->id));
});

// Home > Haplogroups > Edit Haplogroup
Breadcrumbs::register('haplogroups.edit', function($breadcrumbs, $haplogroup) {
    $breadcrumbs->parent('haplogroups.show', $haplogroup);
    $breadcrumbs->push('Edit Haplogroup', route('haplogroups.edit', $haplogroup->id));
});

/*------------------------Breadcrumbs for Tag Management----------------------------*/
// Home > Tags
Breadcrumbs::register('tags.index', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Tags', route('tags'));
});
/*******************************************************************************/


/*------------------------Breadcrumbs for User Profile----------------------------*/
// Home > My Profile
Breadcrumbs::register('profile', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('My Profile', route('profile', 'user'));
});

// Home > Change Password
Breadcrumbs::register('changePassword', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Change Password', route('changePassword'));
});
/*******************************************************************************/

/*------------------------Breadcrumbs for Org Profile----------------------------*/
// Home > My Profile
Breadcrumbs::register('orgProfile', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Org Profile', route('orgProfile', 'org'));
});
/*******************************************************************************/

/*------------------------Breadcrumbs for About----------------------------*/
// Home > About
Breadcrumbs::register('about', function ($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('About', route('about'));
});
/*******************************************************************************/

/*------------------------Breadcrumbs for Notifications----------------------------*/
// Home > Notifications
Breadcrumbs::register('notifications.index', function ($breadcrumbs, $user) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Notifications', route('notifications.index', $user->id));
});

// Home > Notifications > View
Breadcrumbs::register('notifications.show', function ($breadcrumbs, $user, $notification) {
    $breadcrumbs->parent('notifications.index', $user);
    $breadcrumbs->push('View', route('notifications.show', ['user' => $user, 'id' => $notification->id]));
});
/*******************************************************************************/

/*------------------------Breadcrumbs for Reports Dashboard----------------------------*/
// Home > Reports Dashboard
Breadcrumbs::register('reports.dashboard', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Reports Dashboard', route('reports.dashboard'));
});

// Home > Reports Dashboard > mtDNA Report
Breadcrumbs::register('reports.mtdna', function($breadcrumbs) {
    $breadcrumbs->parent('reports.dashboard');
    $breadcrumbs->push('mtDNA Report', route('reports.mtdna'));
});

// Home > Reports Dashboard > auSTRdna Report
Breadcrumbs::register('reports.austrdna', function($breadcrumbs) {
    $breadcrumbs->parent('reports.dashboard');
    $breadcrumbs->push('AuSTR DNA Report', route('reports.austrdna'));
});

// Home > Reports Dashboard > ySTRdna Report
Breadcrumbs::register('reports.ystrdna', function($breadcrumbs) {
    $breadcrumbs->parent('reports.dashboard');
    $breadcrumbs->push('Y-STR DNA Report', route('reports.ystrdna'));
});

// Home > Reports Dashboard > Advanced Report
Breadcrumbs::register('reports.advanced.search', function($breadcrumbs) {
    $breadcrumbs->parent('reports.dashboard');
    $breadcrumbs->push('Advanced Specimen Report', route('reports.advanced.search'));
});

// Home > Reports Dashboard > Consolidated Accession Number Report
Breadcrumbs::register('reports.consolidatedAccession.search', function($breadcrumbs) {
    $breadcrumbs->parent('reports.dashboard');
    $breadcrumbs->push('Consolidated Accession Report', route('reports.consolidatedAccession.search'));
});

// Home > Reports Dashboard > Zones Report
Breadcrumbs::register('reports.zones', function($breadcrumbs) {
    $breadcrumbs->parent('reports.dashboard');
    $breadcrumbs->push('Zones Report', route('reports.zones'));
});

// Home > Reports Dashboard > Articulations Report
Breadcrumbs::register('reports.articulation.search', function($breadcrumbs) {
    $breadcrumbs->parent('reports.dashboard');
    $breadcrumbs->push('Articulations Report', route('reports.articulation.search'));
});

// Home > Reports Dashboard > Methods Report
Breadcrumbs::register('reports.methods', function($breadcrumbs) {
    $breadcrumbs->parent('reports.dashboard');
    $breadcrumbs->push('Methods Report', route('reports.methods'));
});

// Home > Reports Dashboard > Pathology Report
Breadcrumbs::register('reports.pathologys', function($breadcrumbs) {
    $breadcrumbs->parent('reports.dashboard');
    $breadcrumbs->push('Pathology Report', route('reports.pathologys'));
});

// Home > Reports Dashboard > Anomaly Report
Breadcrumbs::register('reports.anomalys', function($breadcrumbs) {
    $breadcrumbs->parent('reports.dashboard');
    $breadcrumbs->push('Anomaly Report', route('reports.anomalys'));
});

// Home > Reports Dashboard > Measurements Report
Breadcrumbs::register('reports.measurements', function($breadcrumbs) {
    $breadcrumbs->parent('reports.dashboard');
    $breadcrumbs->push('Measurements Report', route('reports.measurements'));
});

// Home > Reports Dashboard > Specimens by Individual Number Report
Breadcrumbs::register('reports.individualnumber', function($breadcrumbs) {
    $breadcrumbs->parent('reports.dashboard');
    $breadcrumbs->push('Specimens By Individual Number Report', route('reports.individualnumber'));
});

// Home > Reports Dashboard > Trauma Report
Breadcrumbs::register('reports.traumas', function($breadcrumbs) {
    $breadcrumbs->parent('reports.dashboard');
    $breadcrumbs->push('Trauma Report', route('reports.traumas'));
});

// Home > Reports Dashboard > Search Reports
Breadcrumbs::register('reports.search', function($breadcrumbs) {
    $breadcrumbs->parent('reports.dashboard');
    $breadcrumbs->push('Search Reports', route('reports.search'));
});

// Home > Reports > Bone Group Report
Breadcrumbs::register('reports.bonegroup', function($breadcrumbs) {
    $breadcrumbs->parent('reports.dashboard');
    $breadcrumbs->push('Bone Group Report', route('reports.bonegroup', 'bone_group_id'));
});

// Home > Reports Dashboard > Individual Number Report
Breadcrumbs::register('reports.individualnumberdetails', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Individual Numbers Report', route('reports.individualnumberdetails'));
});

// Home > Reports Dashboard > Isotopes Report
Breadcrumbs::register('reports.isotopes', function($breadcrumbs) {
    $breadcrumbs->parent('reports.dashboard');
    $breadcrumbs->push('Isotopes Report', route('reports.isotopes'));
});

// Home > Reports Dashboard > Specimen Comparisons Report
Breadcrumbs::register('reports.secomparisons', function($breadcrumbs) {
    $breadcrumbs->parent('reports.dashboard');
    $breadcrumbs->push('Specimen Comparisons Report', route('reports.secomparisons'));
});

/*******************************************************************************/


/*------------------------Breadcrumbs for Visualizations Dashboard----------------------------*/
// Home > Reports Dashboard
Breadcrumbs::register('visualizations.dashboard', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Visualizations Dashboard', route('visualizations.dashboard'));
});
// Home > Visualizations Dashboard > Pairs Visualization
Breadcrumbs::register('visualization.pairs', function($breadcrumbs) {
    $breadcrumbs->parent('visualizations.dashboard');
    $breadcrumbs->push('Pairs Visualization', route('visualizations.pairs'));
});

/*******************************************************************************/


/*------------------------Breadcrumbs for Export-Import Files----------------------------*/
// Home > Export Files
Breadcrumbs::register('exportOptions', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Export Files', route('exportOptions'));
});

//TODO: Check this on Admin Login
// Home > Export Files > Select Tables
Breadcrumbs::register('selectTables', function($breadcrumbs) {
    $breadcrumbs->parent('exportOptions');
    $breadcrumbs->push('Select Tables', route('selectTables', 'id'));
});

// Home > Import Files
Breadcrumbs::register('importFile', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Import Files', route('importFile'));
});

// Home > File Manager
Breadcrumbs::register('exportFileManager', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('File Manager', route('exportFileManager'));
});

// Home > File Manager > View Files
Breadcrumbs::register('viewExportedFiles', function($breadcrumbs) {
    $breadcrumbs->parent('exportFileManager');
    $breadcrumbs->push('View Files', route('viewExportedFiles', 'exportType'));
});
/*******************************************************************************/


/*------------------------Breadcrumbs for Specimens, DNA----------------------------*/
// Home > Search Specimens
Breadcrumbs::register('skeletalelements.search', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Specimens Search', route('skeletalelements.search'));
});

// Home > Search DNA
Breadcrumbs::register('dnas.search', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('DNA Search', route('dnas.search'));
});

// Home > Search Specimens > View Specimen
Breadcrumbs::register('skeletalelements.show', function($breadcrumbs, $skeletalelement) {

    // Check if this route is coming from a POST request
    // If not, MethodNotAllowed Exception will be thrown.
    // Check for a get request and set the flag to true.
    $currentRoute = app('router')->getRoutes()->match(app('request')->create(URL::current()))->getName();
    try {
        $previousRoute = app('router')->getRoutes()->match(app('request')->create(URL::previous(),'POST'))->getName();
    } catch (Exception $e) {
        $previousRoute = app('router')->getRoutes()->match(app('request')->create(URL::previous()))->getName();
    }
    
    if($previousRoute == 'skeletalelements.searchgo' || $previousRoute == 'skeletalelements.search') {
        $breadcrumbs->parent('skeletalelements.search');
    } elseif($previousRoute == 'dnas.searchgo' || $previousRoute == 'dnas.search') {
        $breadcrumbs->parent('dnas.search');
    } else {
        // This is just a fail-safe fall-back mechanism breadcrumb
        $breadcrumbs->parent('dashboard');
    }
    $breadcrumbs->push('View', route('skeletalelements.show', $skeletalelement->id));
});

// Home > Search Specimens > Create Specimen
Breadcrumbs::register('skeletalelements.create', function($breadcrumbs) {
    $breadcrumbs->parent('skeletalelements.search');
    $breadcrumbs->push('Create', route('skeletalelements.create'));
});

// Home > Search Specimens > Create By Group
Breadcrumbs::register('skeletalelements.createbygroup', function($breadcrumbs) {
    $breadcrumbs->parent('skeletalelements.search');
    $breadcrumbs->push('Create By Group', route('skeletalelements.createbygroup'));
});

// Home > Search Specimens > Edit Specimen
Breadcrumbs::register('skeletalelements.edit', function($breadcrumbs, $skeletalelement) {
    $breadcrumbs->parent('skeletalelements.show', $skeletalelement);
    $breadcrumbs->push('Edit', route('skeletalelements.edit', $skeletalelement->id));
});

// Home > Specimens
Breadcrumbs::register('skeletalelements.index', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Specimens', route('skeletalelements.index'));
});

// Home > Search Specimens > View > {{Heading}}
Breadcrumbs::register('skeletalelements.associations', function($breadcrumbs, $skeletalelement, $heading) {

    // Check if this route is coming from a POST request
    // If not, MethodNotAllowed Exception will be thrown.
    // Check for a get request and set the flag to true.
    $currentRoute = app('router')->getRoutes()->match(app('request')->create(URL::current()))->getName();
    try {
        $previousRoute = app('router')->getRoutes()->match(app('request')->create(URL::previous(),'POST'))->getName();
    } catch (Exception $e) {
        $previousRoute = app('router')->getRoutes()->match(app('request')->create(URL::previous()))->getName();
    }

    if($previousRoute == 'skeletalelements.show') {
        $breadcrumbs->parent('skeletalelements.show', $skeletalelement);
    } elseif(($previousRoute == 'skeletalelements.searchgo' || $previousRoute == 'skeletalelements.search') &&
                     $currentRoute == 'dnas.show') {
        $breadcrumbs->parent('skeletalelements.search');
    } elseif( ($previousRoute == 'dnas.searchgo' || $previousRoute == 'dnas.search') && $currentRoute == 'dnas.show') {
        $breadcrumbs->parent('dnas.search');
    } else {
        // This is just a fail-safe fall-back mechanism breadcrumb
        $breadcrumbs->parent('dashboard');
    }
    $breadcrumbs->push($heading, route('skeletalelements.associations', $skeletalelement->id));
});

// Home > Search Specimens > View > Review
Breadcrumbs::register('skeletalelements.review', function($breadcrumbs, $skeletalelement) {
    $breadcrumbs->parent('skeletalelements.show', $skeletalelement);
    $breadcrumbs->push('Review', route('skeletalelements.review', $skeletalelement->id));
});

/*******************************************************************************/


/*------------------------Breadcrumbs for Project Management----------------------------*/
// Home > Projects
Breadcrumbs::register('projects.index', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Projects', route('projects.index'));
});

// Home > Projects > Create Project
Breadcrumbs::register('projects.create', function($breadcrumbs) {
    $breadcrumbs->parent('projects.index');
    $breadcrumbs->push('Create', route('projects.create'));
});

// Home > Projects > View Project
Breadcrumbs::register('projects.show', function($breadcrumbs, $project) {
    $breadcrumbs->parent('projects.index');
    $breadcrumbs->push('View', route('projects.show', $project->id));
});

// Home > Projects > Edit Project
Breadcrumbs::register('projects.edit', function($breadcrumbs, $project) {
    $breadcrumbs->parent('projects.show', $project);
    $breadcrumbs->push('Edit', route('projects.edit', $project->id));
});

// Home > Projects > View > Add Users
Breadcrumbs::register('projects.users', function($breadcrumbs, $project) {
    $breadcrumbs->parent('projects.show', $project);
    $breadcrumbs->push('Add Users', route('projects.users', $project->id));
});
/*******************************************************************************/


/*------------------------Breadcrumbs for Accession Management----------------------------*/
// Home > Accessions
Breadcrumbs::register('accessions.index', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Accessions', route('accessions.index'));
});

// Home > Accessions > View
Breadcrumbs::register('accessions.show', function($breadcrumbs, $accession) {
    $breadcrumbs->parent('accessions.index');
    $breadcrumbs->push('View', route('accessions.show', $accession->id));
});

// Home > Accessions > Create
Breadcrumbs::register('accessions.create', function($breadcrumbs) {
    $breadcrumbs->parent('accessions.index');
    $breadcrumbs->push('Create', route('accessions.create'));
});

// Home > Accessions > View > Edit
Breadcrumbs::register('accessions.edit', function($breadcrumbs, $accession) {
    $breadcrumbs->parent('accessions.show', $accession);
    $breadcrumbs->push('Edit', route('accessions.edit', $accession->id));
});
/*******************************************************************************/


/*------------------------Breadcrumbs for Instrument Management----------------------------*/
// Home > Instruments
Breadcrumbs::register('instruments.index', function($breadcrumbs) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push('Instruments', route('instruments.index'));
});

// Home > Instruments > Create Instrument
Breadcrumbs::register('instruments.create', function($breadcrumbs) {
    $breadcrumbs->parent('instruments.index');
    $breadcrumbs->push('Create', route('instruments.create'));
});

// Home > Instruments > View Instrument
Breadcrumbs::register('instruments.show', function($breadcrumbs, $instrument) {
    $breadcrumbs->parent('instruments.index');
    $breadcrumbs->push('View', route('instruments.show', $instrument->id));
});

// Home > Instruments > Edit Instrument
Breadcrumbs::register('instruments.edit', function($breadcrumbs, $instrument) {
    $breadcrumbs->parent('instruments.show', $instrument);
    $breadcrumbs->push('Edit', route('instruments.edit', $instrument->id));
});
/*******************************************************************************/
