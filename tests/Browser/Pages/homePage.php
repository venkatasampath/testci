<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

class homePage extends page
{
    /**
     * Get the URL for the page.
     *
     * @return string
     */
    public function url()
    {
        return '/';
    }

    /**
     * Get the element shortcuts for the page.
     *
     * @return array
     */
    public function elements()
    {
        return [
            '@element' => '#selector',
            '@refresh-dashboard' => '#dashboard > div:nth-child(1) > div > div.float-right.col-4 > span > input',
            '@cora-home' => '#app > header > nav > a',
            //'@sidebar-collapse' => '[dusk="rightSideBar-menu"]',
            '@sidebar-collapse' => '#sidebarCollapse',
            '@dashboard-home' => '[dusk="dashboard"]',
            '@se-menu' => '@se-menu',
            '@se-search' => '@se-search',
            '@se-new' => '@se-new',
            '@se-reports-dashboard' => '@se-reports_dashboard',
            '@se-advance-search' => '@se-advance_search',
            '@dna-menu' => '@dna-menu',
            '@dna-search' => '@dna-search',
            '@dna-mtDNA' => '@dna-mtDNA',
            '@reports' => '#sidebar > ul > li:nth-child(4) > a',
            '@file-export' => '@file-export',
            '@file-import' => '@file-import',
            '@file-manager' => '@file-manager',

            '@cora-project-switcher' => '[dusk="cora-project-switcher"]',
            '@cora-project-switcher-button' => '[dusk="cora-project-switcher-button"]',
            '@search-type-selector' => '[dusk="cora-search-options"]',
            '@cora-search-options' => '[dusk="cora-search-options"]',
            '@cora-search' => '[dusk="cora-search"]',
            '@cora-search-button' => '[dusk="cora-search-button"]',

            // Minimize Buttons
            //'@pie-chart1-minimize' => '#dashboard > div:nth-child(2) > section:nth-child(3) > div:nth-child(1) > div > div.card-header > div:nth-child(2) > a:nth-child(2)',
            '@pie-chart1-minimize' => '#dashboard > div:nth-child(2) > div > section:nth-child(2) > div:nth-child(1) > div > div.card-header > div:nth-child(2) > a:nth-child(2) > i',
            //'@pie-chart2-minimize' => '#dashboard > div:nth-child(2) > section:nth-child(3) > div:nth-child(2) > div > div.card-header > div:nth-child(2) > a:nth-child(2)',
            '@pie-chart2-minimize' => '#dashboard > div:nth-child(2) > div > section:nth-child(2) > div:nth-child(2) > div > div.card-header > div:nth-child(2) > a:nth-child(2) > i',
            //'@pie-chart3-minimize' => '#dashboard > div:nth-child(2) > section:nth-child(3) > div:nth-child(3) > div > div.card-header > div:nth-child(2) > a:nth-child(2)',
            '@pie-chart3-minimize' => '#dashboard > div:nth-child(2) > div > section:nth-child(2) > div:nth-child(3) > div > div.card-header > div:nth-child(2) > a:nth-child(2) > i',
            //'@bar-chart1-minimize' => '#dashboard > div:nth-child(2) > section:nth-child(3) > div:nth-child(4) > div > div.card-header > div:nth-child(2) > a:nth-child(2)',
            '@bar-chart1-minimize' => '#dashboard > div:nth-child(2) > div > section:nth-child(2) > div:nth-child(4) > div > div.card-header > div:nth-child(2) > a:nth-child(2) > i',
            //'@bar-chart2-minimize' => '#dashboard > div:nth-child(2) > section:nth-child(3) > div:nth-child(5) > div > div.card-header > div:nth-child(2) > a:nth-child(2)',
            '@bar-chart2-minimize' => '#dashboard > div:nth-child(2) > div > section:nth-child(2) > div:nth-child(5) > div > div.card-header > div:nth-child(2) > a:nth-child(2) > i',
            //'@bar-chart3-minimize' => '#dashboard > div:nth-child(2) > section:nth-child(3) > div:nth-child(6) > div > div.card-header > div:nth-child(2) > a:nth-child(2)',
            '@bar-chart3-minimize' => '#dashboard > div:nth-child(2) > div > section:nth-child(2) > div:nth-child(6) > div > div.card-header > div:nth-child(2) > a:nth-child(2) > i',
            //'@bar-chart4-minimize' => '#dashboard > div:nth-child(2) > section:nth-child(3) > div:nth-child(7) > div > div.card-header > div:nth-child(2) > a:nth-child(2)',
            '@bar-chart4-minimize' => '#dashboard > div:nth-child(2) > div > section:nth-child(2) > div:nth-child(7) > div > div.card-header > div:nth-child(2) > a:nth-child(2) > i',
            //'@burndown-minimize' => '#dashboard > div:nth-child(2) > section:nth-child(6) > div > div > div.card-header > div:nth-child(2) > a:nth-child(2)',
            '@burndown-minimize' => '#dashboard > div:nth-child(2) > div > section:nth-child(5) > div > div > div.card-header > div:nth-child(2) > a:nth-child(2) > i',

            // Customize Buttons
            //'@customize-widget-visibility' => '#dashboard > div:nth-child(2) > section.row.subHeader > div > div > div.card-header',
            '@customize-widget-visibility' => '#visible',
            '@inventory' => '#widgetsUL > div > div:nth-child(4) > ul > li > div:nth-child(1) > input',
            '@complete' => '#widgetsUL > div > div:nth-child(2) > ul > li:nth-child(1) > div:nth-child(1) > input',
            '@skeletal-elements' => '#widgetsUL > div > div:nth-child(2) > ul > li:nth-child(2) > div:nth-child(1) > input',
            '@dna-sampled' => '#widgetsUL > div > div:nth-child(2) > ul > li:nth-child(3) > div:nth-child(1) > input',
            '@measured' => '#widgetsUL > div > div:nth-child(2) > ul > li:nth-child(4) > div:nth-child(1) > input',
            '@ct-scan' => '',
            '@xray' => '',
            '@clavicle-triage' => '',
            '@isotope-sampled' => '',
            '@mito-sequences' => '#widgetsUL > div > div:nth-child(2) > ul > li:nth-child(9) > div:nth-child(1) > input',
            '@mni-zones' => '#widgetsUL > div > div:nth-child(2) > ul > li:nth-child(5) > div:nth-child(1) > input',
            '@mni-bones' => '#widgetsUL > div > div:nth-child(2) > ul > li:nth-child(6) > div:nth-child(1) > input',
            '@mni-zones-side' => '#widgetsUL > div > div:nth-child(2) > ul > li:nth-child(12) > div:nth-child(1) > input',
            '@mni-bones-side' => '#widgetsUL > div > div:nth-child(2) > ul > li:nth-child(13) > div:nth-child(1) > input',
            '@mito-bones-side' => '#widgetsUL > div > div:nth-child(2) > ul > li:nth-child(14) > div:nth-child(1) > input',

            // Close Buttons
            //'@complete-close' => '#dashboard > div:nth-child(2) > section:nth-child(3) > div:nth-child(1) > div > div.card-header > div:nth-child(2) > a:nth-child(3) > i',
            //'@skeletal-elements-close' => '#dashboard > div:nth-child(2) > section:nth-child(3) > div:nth-child(2) > div > div.card-header > div:nth-child(2) > a:nth-child(3) > i',
            //'@dna-sampled-close' => '#dashboard > div:nth-child(2) > section:nth-child(3) > div:nth-child(3) > div > div.card-header > div:nth-child(2) > a:nth-child(3) > i',
            //'@mito-sequences-close' => '#dashboard > div:nth-child(2) > section:nth-child(3) > div:nth-child(4) > div > div.card-header > div:nth-child(2) > a:nth-child(3) > i',
            //'@mni-zones-close' => '#dashboard > div:nth-child(2) > section:nth-child(7) > div:nth-child(5) > div > div.card-header > div:nth-child(2) > a:nth-child(3) > i',
            //'@mni-bones-close' => '#dashboard > div:nth-child(2) > section:nth-child(3) > div:nth-child(5) > div > div.card-header > div:nth-child(2) > a:nth-child(3) > i',
            //'@mni-zones-side-close' => '#dashboard > div:nth-child(2) > section:nth-child(3) > div:nth-child(6) > div > div.card-header > div:nth-child(2) > a:nth-child(3) > i',
            //'@mni-bones-side-close' => '#dashboard > div:nth-child(2) > section:nth-child(3) > div:nth-child(5) > div > div.card-header > div:nth-child(2) > a:nth-child(3) > i',
            //'@inventory-close' => '#dashboard > div:nth-child(2) > section:nth-child(6) > div > div > div.card-header > div:nth-child(2) > a:nth-child(3) > i',

            '@complete-close' => '#dashboard > div:nth-child(2) > div > section:nth-child(2) > div:nth-child(1) > div > div.card-header > div:nth-child(2) > a:nth-child(3) > i',
            '@skeletal-elements-close' => '#dashboard > div:nth-child(2) > div > section:nth-child(2) > div:nth-child(2) > div > div.card-header > div:nth-child(2) > a:nth-child(3) > i',
            '@dna-sampled-close' => '#dashboard > div:nth-child(2) > div > section:nth-child(2) > div:nth-child(3) > div > div.card-header > div:nth-child(2) > a:nth-child(3) > i',
            '@mito-sequences-close' => '#dashboard > div:nth-child(2) > div > section:nth-child(2) > div:nth-child(4) > div > div.card-header > div:nth-child(2) > a:nth-child(3) > i',
            //'@mni-zones-close' => '#dashboard > div:nth-child(2) > section:nth-child(7) > div:nth-child(5) > div > div.card-header > div:nth-child(2) > a:nth-child(3) > i',
            '@mni-bones-close' => '#dashboard > div:nth-child(2) > div > section:nth-child(2) > div:nth-child(5) > div > div.card-header > div:nth-child(2) > a:nth-child(3) > i',
            '@mni-zones-side-close' => '#dashboard > div:nth-child(2) > div > section:nth-child(2) > div:nth-child(6) > div > div.card-header > div:nth-child(2) > a:nth-child(3) > i',
            '@mito-bones-side-close' => '#dashboard > div:nth-child(2) > div > section:nth-child(2) > div:nth-child(7) > div > div.card-header > div:nth-child(2) > a:nth-child(3) > i',
            '@inventory-close' => '#dashboard > div:nth-child(2) > div > section:nth-child(5) > div > div > div.card-header > div:nth-child(2) > a:nth-child(3) > i',

            // Drilldown/View Details Buttons
            '@back_to_dashboard' => '#dashboard > div.card-header > div > div.float-right.col-4 > span > a',
            '@drill_complete' => '#widget4_1 > div:nth-child(2) > div:nth-child(1) > a',
            '@drill_se_to_ind' => '#widget4_2 > div:nth-child(2) > div:nth-child(1) > a',
            '@drill_dna_sampled' => '#widget4_3 > div:nth-child(2) > div:nth-child(1) > a',
            '@drill_measured' => '#widget4_8 > div:nth-child(2) > div:nth-child(1) > a',
            '@drill_ct_scan' => '#widget4_9 > div:nth-child(2) > div:nth-child(1) > a',
            '@drill_xray' => '#widget4_10 > div:nth-child(2) > div:nth-child(1) > a',
            '@drill_clavicle_triage' => '#widget4_11 > div:nth-child(2) > div:nth-child(1) > a',
            '@drill_isotope_sampled' => '#widget4_12 > div:nth-child(2) > div:nth-child(1) > a',
            '@drill_mito_seq' => '#widget4_4 > div:nth-child(2) > div:nth-child(1) > a',
            '@drill_mni_bones' => '#widget4_5 > div:nth-child(2) > div:nth-child(1) > a',
            '@drill_mni_zones' => '#widget4_6 > div:nth-child(2) > div:nth-child(1) > a',
            '@drill_mni_bones_side' => '#widget4_13 > div:nth-child(2) > div:nth-child(1) > a',
            '@drill_mni_zones_side' => '#widget4_14 > div:nth-child(2) > div:nth-child(1) > a',
            '@drill_mito_bones_side' => '#widget4_15 > div:nth-child(2) > div:nth-child(1) > a',
            '@drill_inventory' => '#widget4_7 > div:nth-child(2) > div:nth-child(1) > a ',

            //OrgAdmin Elements
            '@top_DNA_project' => '#dna > tbody > tr > td:nth-child(1) > a',
            '@top_SE_project' => '#se > tbody > tr > td:nth-child(1) > a',

            //Right Sidebar Elements
                //tab navigation
            '@right-sidebar' => '[dusk="right-sideBar-Menu"]',
            '@right-sb-layout' => '[dusk="theme-tab-menu"]',
            '@right-sb-media' => '[dusk="media-tab-menu"]',
            '@right-sb-help' => '[dusk="help-tab-menu"]',
            '@right-sb-feed' => '[dusk="home-tab-menu"]',
            '@right-sb-settings' => '[dusk="settings-tab-menu"]',


                //layout tab
            '@right-sb-layout-Ltoggle' => '[dusk="toggle-sidebar-expand"]',
            '@right-sb-layout-hover' => '[dusk="sidebar-expand-on_hover"]',
            '@right-sb-layout-Rtoggle' => '[dusk="toggle-rightSideBar-slide"]',
            '@right-sb-layout-skin' => '[dusk="toggle-rightSideBar-skin"]',
            '@right-sb-skin-bluedark' => '[dusk="blue-theme"]',
            '@right-sb-skin-blackdark' => '[dusk="black-theme"]',
            '@right-sb-skin-purpledark' => '[dusk="purple-theme"]',
            '@right-sb-skin-greendark' => '[dusk="green-theme"]',
            '@right-sb-skin-reddark' => '[dusk="red-theme"]',
            '@right-sb-skin-yellowdark' => '[dusk="yellow-theme"]',
            '@right-sb-skin-bluelight' => '[dusk="blue-light-theme"]',
            '@right-sb-skin-blacklight' => '[dusk="black-light-theme"]',
            '@right-sb-skin-purplelight' => '[dusk="purple-light-theme"]',
            '@right-sb-skin-greenlight' => '[dusk="green-light-theme"]',
            '@right-sb-skin-redlight' => '[dusk="red-light-theme"]',
            '@right-sb-skin-yellowlight' => '[dusk="yellow-light-theme"]',
                //activity feed tab
            '@right-sb-feed-se' => '#se_feed > tbody > tr > td:nth-child(1) > a',
            '@right-sb-feed-dna' => '#dna_feed > tbody > tr > td:nth-child(1) > a',
                //general setting tab
            '@right-sb-settings-lines' => '[dusk="lines_per_page"]',
            '@right-sb-settings-update-general' => '[dusk="update_general"]',
            '@right-sb-settings-accession' => '[dusk="accession"]',
            '@right-sb-settings-provenance1' => '[dusk="provenance1"]',
            '@right-sb-settings-provenance2' => '[dusk="provenance2"]',
            '@right-sb-settings-update-se' => '[dusk="update_projects-rightsidebar-se"]',
            '@right-sb-settings-lab' => '[dusk="default_laboratory"]',
            '@right-sb-settings-dna' => '[dusk="default_dna_method"]',
            '@right-sb-settings-update-dna' => '[dusk="update_projects"]',

            '@online-help' => '[dusk="onlineHelp"]',
            '@about_menu' => '[dusk="about-menu"]',

            // Logout Buttons
            '@profile-picture' => '[dusk="profile-img"]',
        ];
    }

    /**
     * Assert that the browser is on the page.
     *
     * @param  Browser  $browser
     * @return void
     */
    public function assert(Browser $browser)
    {
        //
    }
    /**
     * Login a new user.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @param  string  $email
     * @param  string  $password
     * @return void
     */
    public function loginUser(Browser $browser, $email, $password)
    {
        $browser->type('@email', $email)
            ->type('@password', $password)
            ->press('Login');
    }
    /*
    *
     * Logout a user.
     *
     * @param  \Laravel\Dusk\Browser  $browser
     * @return void
     */
    public function logoutUser(Browser $browser)
    {
        //$browser->click('#app > header > nav > div > ul > li.nav-item.dropdown > a > span')
        $browser->click('@profile-picture')
            ->press('@logout-menu')
            ->waitForText('Login')
            ->assertDontSee('Administration');
    }
}
