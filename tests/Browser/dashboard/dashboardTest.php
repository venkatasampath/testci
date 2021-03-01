<?php

/**
 * DashboardTest DuskTestCase
 *
 * @category   DuskTestCases
 * @package    CoRA-DuskTestCases
 * @author     Kyle Hampton<kthampton@unomaha.edu>
 * @copyright  2016-2018
 * @license    The MIT License (MIT)
 * @version    GIT: $Id$
 * @since      File available since Release 1.0.0
 */

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\loginPage;
use Tests\Browser\Pages\homePage;
use App\User;

// 6 Total Test Cases
class dashboardTest extends DuskTestCase
{
    /**
     * Create a new LoginTest instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Delete cookies from each LoginTest instance.
     *
     * @return void
     */
    protected function setUp():void
    {
        parent::setUp();
        foreach (static::$browsers as $browser) {
            $browser->driver->manage()->deleteAllCookies();
        }
    }
    /**
     * Flush the session from each LoginTest instance.
     *
     * @return void
     */
    public function tearDown():void
    {
        session()->flush();

        parent::tearDown();
    }
    /**
     * A Dusk test to refresh the home dashboard.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group RefreshDashboard
     * @group AuthorKyle
     */
    public function RefreshDashboard()
    {
        // Test User login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')
                ->assertDontSee('User Profile successfully updated')
                ->click('@refresh-dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')
                ->click('@dashboard-home')
                ->assertPathIs('/dashboard')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to refresh the home dashboard for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group RefreshDashboardManager
     * @group AuthorKyle
     */
    public function RefreshDashboardManager()
    {
        // Test User login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')
                ->assertDontSee('User Profile successfully updated')
                ->click('@refresh-dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')
                ->click('@dashboard-home')
                ->assertPathIs('/dashboard')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to refresh the home dashboard for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group RefreshDashboardOrgAdmin
     * @group AuthorKyle
     */
    public function RefreshDashboardOrgAdmin()
    {
        // Test User login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')
                ->assertDontSee('User Profile successfully updated')
                ->click('@refresh-dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')
                ->click('@dashboard-home')
                ->assertPathIs('/dashboard')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to click through the welcome popup on the home dashboard.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group WelcomeDashboard
     * @group AuthorKyle
     */
    public function WelcomeDashboard()
    {
        // Test User login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')
                ->click('@cora-home')
                ->assertSee('Welcome to CoRA - Commingled Remains Analytics')
                ->assertPathIs('/')
                ->click('@dashboard-home')
                ->assertPathIs('/dashboard')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to click through the welcome popup on the home dashboard for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group WelcomeDashboardManager
     * @group AuthorKyle
     */
    public function WelcomeDashboardManager()
    {
        // Test User login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')
                ->click('@cora-home')
                ->assertSee('Welcome to CoRA - Commingled Remains Analytics')
                ->assertPathIs('/')
                ->click('@dashboard-home')
                ->assertPathIs('/dashboard')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to click through the welcome popup on the home dashboard for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group WelcomeDashboardOrgAdmin
     * @group AuthorKyle
     */
    public function WelcomeDashboardOrgAdmin()
    {
        // Test User login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')
                ->click('@cora-home')
                ->assertSee('Welcome to CoRA - Commingled Remains Analytics')
                ->assertPathIs('/')
                ->click('@dashboard-home')
                ->assertPathIs('/dashboard')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to evaluate the collapse features of the dashboard charts.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group CollapseDashboard
     * @group AuthorKyle
     */
    public function CollapseDashboard()
    {
        // Test User login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')

                // Pie Chart 1
                ->click('@pie-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Pie Chart 2
                ->click('@pie-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Pie Chart 3
                ->click('@pie-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 1
                ->click('@bar-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 2
                ->click('@bar-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 3
                ->click('@bar-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 4
                ->click('@bar-chart4-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Burndown Chart
                ->click('@burndown-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to evaluate the collapse features of the dashboard charts for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group CollapseDashboardManager
     * @group AuthorKyle
     */
    public function CollapseDashboardManager()
    {
        // Test User login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')

                // Pie Chart 1
                ->click('@pie-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Pie Chart 2
                ->click('@pie-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Pie Chart 3
                ->click('@pie-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 1
                ->click('@bar-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 2
                ->click('@bar-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 3
                ->click('@bar-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 4
                ->click('@bar-chart4-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Burndown Chart
                ->click('@burndown-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to evaluate the collapse features of the dashboard charts for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group CollapseDashboardOrgAdmin
     * @group AuthorKyle
     */
    public function CollapseDashboardOrgAdmin()
    {
        // Test User login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')

                // Navigate to the data populated CoRA 2 Demo Dashboard
                ->visit('/projectDashboard/1')

                // Pie Chart 1
                ->click('@pie-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Pie Chart 2
                ->click('@pie-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Pie Chart 3
                ->click('@pie-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Bar Chart 1
                ->click('@bar-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Bar Chart 2
                ->click('@bar-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Bar Chart 3
                ->click('@bar-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Bar Chart 4
                ->click('@bar-chart4-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Burndown Chart
                ->click('@burndown-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to evaluate the collapse features of the dashboard charts.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group ExpandDashboard
     * @group AuthorKyle
     */
    public function ExpandDashboard()
    {
        // Test User login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')

                // Pie Chart 1
                ->click('@pie-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Pie Chart 2
                ->click('@pie-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Pie Chart 3
                ->click('@pie-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 1
                ->click('@bar-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 2
                ->click('@bar-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 3
                ->click('@bar-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 4
                ->click('@bar-chart4-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Burndown Chart
                ->click('@burndown-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Expand Dashboard
                // Pie Chart 1
                ->click('@pie-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Pie Chart 2
                ->click('@pie-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Pie Chart 3
                ->click('@pie-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 1
                ->click('@bar-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 2
                ->click('@bar-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 3
                ->click('@bar-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 4
                ->click('@bar-chart4-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Burndown Chart
                ->click('@burndown-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to evaluate the collapse features of the dashboard charts for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group ExpandDashboardManager
     * @group AuthorKyle
     */
    public function ExpandDashboardManager()
    {
        // Test User login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')

                // Pie Chart 1
                ->click('@pie-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Pie Chart 2
                ->click('@pie-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Pie Chart 3
                ->click('@pie-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 1
                ->click('@bar-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 2
                ->click('@bar-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 3
                ->click('@bar-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 4
                ->click('@bar-chart4-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Burndown Chart
                ->click('@burndown-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Expand Dashboard
                // Pie Chart 1
                ->click('@pie-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Pie Chart 2
                ->click('@pie-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Pie Chart 3
                ->click('@pie-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 1
                ->click('@bar-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 2
                ->click('@bar-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 3
                ->click('@bar-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Bar Chart 4
                ->click('@bar-chart4-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Burndown Chart
                ->click('@burndown-minimize')
                ->pause(1000)
                ->assertPathIs('/dashboard')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to evaluate the collapse features of the dashboard charts for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group ExpandDashboardOrgAdmin
     * @group AuthorKyle
     */
    public function ExpandDashboardOrgAdmin()
    {
        // Test User login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')

                // Navigate to the data populated CoRA 2 Demo Dashboard
                ->visit('/projectDashboard/1')

                // Pie Chart 1
                ->click('@pie-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Pie Chart 2
                ->click('@pie-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Pie Chart 3
                ->click('@pie-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Bar Chart 1
                ->click('@bar-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Bar Chart 2
                ->click('@bar-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Bar Chart 3
                ->click('@bar-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Bar Chart 4
                ->click('@bar-chart4-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Burndown Chart
                ->click('@burndown-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Expand Dashboard
                // Pie Chart 1
                ->click('@pie-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Pie Chart 2
                ->click('@pie-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Pie Chart 3
                ->click('@pie-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Bar Chart 1
                ->click('@bar-chart1-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Bar Chart 2
                ->click('@bar-chart2-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Bar Chart 3
                ->click('@bar-chart3-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Bar Chart 4
                ->click('@bar-chart4-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')

                // Burndown Chart
                ->click('@burndown-minimize')
                ->pause(1000)
                ->assertPathIs('/projectDashboard/1')
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to customize the home dashboard.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group CustomizeDashboard
     * @group AuthorKyle
     */
    public function CustomizeDashboard()
    {
        // Test User login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                // Open the Customize Widget Visibility Window
                ->click('@customize-widget-visibility')
                ->assertPathIs('/dashboard')

                // Uncheck All Charts
                ->pause(1000)
                ->uncheck('@inventory')
                ->pause(1000)
                ->uncheck('@complete')
                ->pause(1000)
                ->uncheck('@skeletal-elements')
                ->pause(1000)
                ->uncheck('@dna-sampled')
                ->pause(1000)
                ->uncheck('@mito-sequences')
                ->pause(1000)
                ->uncheck('@mni-zones-side')
                ->pause(1000)
                ->uncheck('@mni-bones-side')
                ->pause(1000)
                ->uncheck('@mito-bones-side')
                ->pause(1000)
                ->click('@customize-widget-visibility')
                ->pause(1000)

                // Assert All Charts are no longer visible
                ->assertDontSee('Inventory')
                ->assertDontSee('Complete')
                ->assertDontSee('DNA Sampled')
                ->assertDontSee('Mito Sequences')
                ->assertDontSee('MNI Zones')
                ->assertDontSee('MNI Bones')

                // Refresh Dashboard and assert all charts are visible again
                ->click('@refresh-dashboard')
                ->assertPathIs('/dashboard')
                ->assertSee('Inventory')
                ->assertSee('Specimens')
                ->assertSee('Complete')
                ->assertSee('DNA Sampled')
                ->assertSee('Mito Sequences')
                ->assertSee('MNI Zones')
                ->assertSee('MNI Bones')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to customize the home dashboard for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group CustomizeDashboardManager
     * @group AuthorKyle
     */
    public function CustomizeDashboardManager()
    {
        // Test User login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                // Open the Customize Widget Visibility Window
                ->click('@customize-widget-visibility')
                ->assertPathIs('/dashboard')

                // Uncheck All Charts
                ->pause(1000)
                ->uncheck('@inventory')
                ->pause(1000)
                ->uncheck('@complete')
                ->pause(1000)
                ->uncheck('@skeletal-elements')
                ->pause(1000)
                ->uncheck('@dna-sampled')
                ->pause(1000)
                ->uncheck('@mito-sequences')
                ->pause(1000)
                ->uncheck('@mni-zones-side')
                ->pause(1000)
                ->uncheck('@mni-bones-side')
                ->pause(1000)
                ->uncheck('@mito-bones-side')
                ->pause(1000)
                ->click('@customize-widget-visibility')
                ->pause(1000)

                // Assert All Charts are no longer visible
                ->assertDontSee('Inventory')
                ->assertDontSee('Complete')
                ->assertDontSee('DNA Sampled')
                ->assertDontSee('Mito Sequences')
                ->assertDontSee('MNI Zones')
                ->assertDontSee('MNI Bones')

                // Refresh Dashboard and assert all charts are visible again
                ->click('@refresh-dashboard')
                ->assertPathIs('/dashboard')
                ->assertSee('Inventory')
                ->assertSee('Specimens')
                ->assertSee('Complete')
                ->assertSee('DNA Sampled')
                ->assertSee('Mito Sequences')
                ->assertSee('MNI Zones')
                ->assertSee('MNI Bones')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to customize the home dashboard for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group CustomizeDashboardOrgAdmin
     * @group AuthorKyle
     */
    public function CustomizeDashboardOrgAdmin()
    {
        // Test User login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                // Navigate to the data populated CoRA 2 Demo Dashboard
                ->visit('/projectDashboard/1')

                // Open the Customize Widget Visibility Window
                ->click('@customize-widget-visibility')
                ->assertPathIs('/projectDashboard/1')

                // Uncheck All Charts
                ->pause(1000)
                ->uncheck('@inventory')
                ->pause(1000)
                ->uncheck('@complete')
                ->pause(1000)
                ->uncheck('@skeletal-elements')
                ->pause(1000)
                ->uncheck('@dna-sampled')
                ->pause(1000)
                ->uncheck('@mito-sequences')
                ->pause(1000)
                ->uncheck('@mni-zones-side')
                ->pause(1000)
                ->uncheck('@mni-bones-side')
                ->pause(1000)
                ->uncheck('@mito-bones-side')
                ->pause(1000)
                ->click('@customize-widget-visibility')
                ->pause(1000)

                // Assert All Charts are no longer visible
                ->assertDontSee('Inventory')
                ->assertDontSee('Complete')
                ->assertDontSee('DNA Sampled')
                ->assertDontSee('Mito Sequences')
                ->assertDontSee('MNI Zones')
                ->assertDontSee('MNI Bones')

                // Refresh Dashboard and assert all charts are visible again
                ->click('@refresh-dashboard')
                ->assertPathIs('/projectDashboard/1')
                ->assertSee('Inventory')
                ->assertSee('Specimens')
                ->assertSee('Complete')
                ->assertSee('DNA Sampled')
                ->assertSee('Mito Sequences')
                ->assertSee('MNI Zones')
                ->assertSee('MNI Bones')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to close the individual sections of the home dashboard.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group CloseDashboard
     * @group AuthorKyle
     */
    public function CloseDashboard()
    {
        // Test User login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                // Close All Charts
                ->click('@inventory-close')
                ->pause(1000)
                ->click('@mito-bones-side-close')
                ->pause(1000)
                ->click('@mni-zones-side-close')
                ->pause(1000)
                ->click('@mni-bones-close')
                ->pause(1000)
                ->click('@mito-sequences-close')
                ->pause(1000)
                ->click('@dna-sampled-close')
                ->pause(1000)
                ->click('@skeletal-elements-close')
                ->pause(1000)
                ->click('@complete-close')
                ->pause(1000)

                // Assert All Charts are closed
                ->assertDontSee('Inventory')
                ->assertDontSee('Complete')
                ->assertDontSee('DNA Sampled')
                ->assertDontSee('Mito Sequences')
                ->assertDontSee('MNI Zones')
                ->assertDontSee('MNI Bones')

                // Refresh Dashboard and assert all charts are visible again
                ->click('@refresh-dashboard')
                ->assertPathIs('/dashboard')
                ->assertSee('Inventory')
                ->assertSee('Specimens')
                ->assertSee('Complete')
                ->assertSee('DNA Sampled')
                ->assertSee('Mito Sequences')
                ->assertSee('MNI Zones')
                ->assertSee('MNI Bones')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to close the individual sections of the home dashboard for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group CloseDashboardManager
     * @group AuthorKyle
     */
    public function CloseDashboardManager()
    {
        // Test User login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                // Close All Charts
                ->click('@inventory-close')
                ->pause(1000)
                ->click('@mito-bones-side-close')
                ->pause(1000)
                ->click('@mni-zones-side-close')
                ->pause(1000)
                ->click('@mni-bones-close')
                ->pause(1000)
                ->click('@mito-sequences-close')
                ->pause(1000)
                ->click('@dna-sampled-close')
                ->pause(1000)
                ->click('@skeletal-elements-close')
                ->pause(1000)
                ->click('@complete-close')
                ->pause(1000)

                // Assert All Charts are closed
                ->assertDontSee('Inventory')
                ->assertDontSee('Complete')
                ->assertDontSee('DNA Sampled')
                ->assertDontSee('Mito Sequences')
                ->assertDontSee('MNI Zones')
                ->assertDontSee('MNI Bones')

                // Refresh Dashboard and assert all charts are visible again
                ->click('@refresh-dashboard')
                ->assertPathIs('/dashboard')
                ->assertSee('Inventory')
                ->assertSee('Specimens')
                ->assertSee('Complete')
                ->assertSee('DNA Sampled')
                ->assertSee('Mito Sequences')
                ->assertSee('MNI Zones')
                ->assertSee('MNI Bones')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to close the individual sections of the home dashboard for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group CloseDashboardOrgAdmin
     * @group AuthorKyle
     */
    public function CloseDashboardOrgAdmin()
    {
        // Test User login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                // Navigate to the data populated CoRA 2 Demo Dashboard
                ->visit('/projectDashboard/1')

                // Close All Charts
                ->click('@inventory-close')
                ->pause(1000)
                ->click('@mito-bones-side-close')
                ->pause(1000)
                ->click('@mni-zones-side-close')
                ->pause(1000)
                ->click('@mni-bones-close')
                ->pause(1000)
                ->click('@mito-sequences-close')
                ->pause(1000)
                ->click('@dna-sampled-close')
                ->pause(1000)
                ->click('@skeletal-elements-close')
                ->pause(1000)
                ->click('@complete-close')
                ->pause(1000)

                // Assert All Charts are closed
                ->assertDontSee('Inventory')
                ->assertDontSee('Complete')
                ->assertDontSee('DNA Sampled')
                ->assertDontSee('Mito Sequences')
                ->assertDontSee('MNI Zones')
                ->assertDontSee('MNI Bones')

                // Refresh Dashboard and assert all charts are visible again
                ->click('@refresh-dashboard')
                ->assertPathIs('/projectDashboard/1')
                ->assertSee('Inventory')
                ->assertSee('Specimens')
                ->assertSee('Complete')
                ->assertSee('DNA Sampled')
                ->assertSee('Mito Sequences')
                ->assertSee('MNI Zones')
                ->assertSee('MNI Bones')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to test the Org Admin dashboard.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group OrgAdminDashboard
     * @group AuthorJohn
     */
    public function OrgAdminDashboard()
    {
        // Test User login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome to CoRA')
                ->assertSee('Home');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Org Admin Dashboard')
                ->assertPathIs('/dashboard')
                ->assertSee('All Projects')
                ->assertSee('DNA Summary')
                ->assertSee('Skeletal Summary')
                ->assertSee('CoRA Demo')
                ->click('@top_DNA_project')
                ->assertPathBeginsWith('/projectDashboard/')
                ->assertSee('Dashboard')
                ->click('@dashboard-home')
                ->assertPathIs('/dashboard');

            //scroll page down to view Specimens project table
            $browser->driver->executeScript('window.scrollTo(0, 500);');

            $browser
                ->click('@top_SE_project')
                ->assertPathBeginsWith('/projectDashboard/')
                ->assertSee('Dashboard')
                ->logoutUser();
        });
    }
     /**
     * A Dusk test to refresh the home dashboard.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group SidebarCollapse
     * @group AuthorKyle
     */
    public function SidebarCollapse()
    {
        // Test User login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                // Open Sidebar and Verify Menu Options
                ->click('@sidebar-collapse')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Open Specimens and Verify Menu Options
                ->click('@se-menu')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Open DNA and Verify Menu Options
                ->click('@dna-menu')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Open Reports and Verify Menu Options
                ->click('@reports')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Close the Sidebar and Verify Menu Options
                ->click('@sidebar-collapse')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to refresh the home dashboard for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group SidebarCollapseManager
     * @group AuthorKyle
     */
    public function SidebarCollapseManager()
    {
        // Test User login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                // Open Sidebar and Verify Menu Options
                ->click('@sidebar-collapse')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Open Specimens and Verify Menu Options
                ->click('@se-menu')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Open DNA and Verify Menu Options
                ->click('@dna-menu')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Open Reports and Verify Menu Options
                ->click('@reports')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Close the Sidebar and Verify Menu Options
                ->click('@sidebar-collapse')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to refresh the home dashboard for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group SidebarCollapseOrgAdmin
     * @group AuthorKyle
     */
    public function SidebarCollapseOrgAdmin()
    {
        // Test User login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                // Open Sidebar and Verify Menu Options
                ->click('@sidebar-collapse')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Open Specimens and Verify Menu Options
                ->click('@se-menu')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Open DNA and Verify Menu Options
                ->click('@dna-menu')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Open Reports and Verify Menu Options
                ->click('@reports')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                // Close the Sidebar and Verify Menu Options
                ->click('@sidebar-collapse')
                ->pause(1000)
                ->assertPathIs('/dashboard')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to the project switcher on home dashboard.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group ProjectSwitcher
     * @group AuthorKyle
     */
    public function ProjectSwitcher()
    {
        // Test User login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                // Change the Project Tarawa
                ->select('@cora-project-switcher','27')
                ->click('@cora-project-switcher-button')
                ->acceptDialog()
                ->pause(1000)
                ->assertValue('@cora-project-switcher','27')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                // Change the Project back to CoRA Demo
                ->select('@cora-project-switcher','1')
                ->click('@cora-project-switcher-button')
                ->acceptDialog()
                ->pause(1000)
                ->assertValue('@cora-project-switcher','1')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to the project switcher on home dashboard for a manager
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group ProjectSwitcherManager
     * @group AuthorKyle
     */
    public function ProjectSwitcherManager()
    {
        // Test User login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                // Change the Project Tarawa
                /*
                ->select('@cora-project-switcher','27')
                ->click('@cora-project-switcher-button')
                ->acceptDialog()
                ->pause(1000)
                ->assertValue('@cora-project-switcher','27')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')
                */

                // Change the Project back to CoRA Demo
                ->select('@cora-project-switcher','1')
                ->click('@cora-project-switcher-button')
                //->acceptDialog()
                ->pause(1000)
                ->assertValue('@cora-project-switcher','1')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to the project switcher on home dashboard for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group ProjectSwitcherOrgAdmin
     * @group AuthorKyle
     */
    public function ProjectSwitcherOrgAdmin()
    {
        // Test User login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            $browser->visit(new homePage)
                ->visit('/dashboard')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                // Navigate to the data populated CoRA 2 Demo Dashboard
                ->visit('/projectDashboard/1')

                // Change the Project Hamburger Hill
                ->select('@cora-project-switcher','32')
                ->click('@cora-project-switcher-button')
                ->acceptDialog()
                ->pause(1000)
                ->assertValue('@cora-project-switcher','32')
                ->assertSee('Dashboard')
                ->assertPathIs('/projectDashboard/1')

                // Change the Project back to CoRA Demo
                ->select('@cora-project-switcher','1')
                ->click('@cora-project-switcher-button')
                ->acceptDialog()
                ->pause(1000)
                ->assertValue('@cora-project-switcher','1')
                ->assertSee('Dashboard')
                ->assertPathIs('/projectDashboard/1')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test for each of the drilldown buttons on the project dashboard
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group Drilldowns
     * @group AuthorJohn
     */
    public function Drilldowns()
    {
        // Test User login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome to CoRA')
                ->assertSee('Home');

            //testing main graphs
            $browser->maximize();
            $browser->visit(new homePage)
                ->visit('/')
                ->assertSee('Welcome to CoRA')
                ->assertPathIs('/')
                ->click('@dashboard-home')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                //Testing each drilldown button
                ->click('@drill_complete')
                ->assertSee('Dashboard Details: Complete')
                ->click('@back_to_dashboard')
                ->assertSee('Dashboard')

                ->click('@drill_se_to_ind')
                ->assertSee('Dashboard Details: Specimens Associated')
                ->click('@back_to_dashboard')

                ->click('@drill_dna_sampled')
                ->assertSee('Dashboard Details: DNA Sampled')
                ->click('@back_to_dashboard')

                //$browser->driver->executeScript('window.scrollTo(0, 750);');
                //$browser
                ->click('@customize-widget-visibility')
                ->uncheck('@complete')
                ->uncheck('@skeletal-elements')
                ->uncheck('@dna-sampled')
                ->click('@customize-widget-visibility')
                ->click('#widget4_1 > div:nth-child(2) > div:nth-child(1) > a')
                //->click('@drill_mito_seq')
                ->assertSee('Dashboard Details: Mito Sequences')
                ->click('@back_to_dashboard')

                ->click('@drill_mni_bones_side');
                $browser->driver->executeScript('window.scrollTo(0, 750);');
                $browser
                ->assertSee('Dashboard Details: MNI by Bones and Side')
                ->click('@back_to_dashboard')

                ->click('@drill_mni_zones_side');
                $browser->driver->executeScript('window.scrollTo(0, 750);');
                $browser
                ->assertSee('Dashboard Details: MNI by Zones and Side')
                ->click('@back_to_dashboard')

                ->click('@drill_mito_bones_side');
                $browser->driver->executeScript('window.scrollTo(0, 750);');
                $browser
                ->assertSee('Dashboard Details: Mito Sequences by Bones and Side')
                ->click('@back_to_dashboard');

                $browser->driver->executeScript('window.scrollTo(0, 900);');
                $browser
                ->click('@drill_inventory')
                ->assertSee('Dashboard Details: Inventory')
                ->click('@back_to_dashboard')

                  /**
                //Begin testing of the additional charts
                //From here on each chart must be
                //manually selected to show up on page
                  */

                ->click('@customize-widget-visibility')
                ->uncheck('@complete')
                ->uncheck('@skeletal-elements')
                ->uncheck('@dna-sampled')
                ->check('@measured')
                ->click('@customize-widget-visibility')
                ->click('@drill_measured')
                ->assertSee('Dashboard Details: Measured')
                    ->assertSee('****FORCED FAIL****')
                ->click('@back_to_dashboard')

                ->click('@customize-widget-visibility')
                ->check('@ct-scan')
                ->click('@customize-widget-visibility');
                $browser->driver->executeScript('window.scrollTo(0, 750);');
                $browser
                ->click('@drill_ct_scan')
                ->assertSee('Dashboard Details: CT Scanned')
                ->click('@back_to_dashboard')

                ->click('@customize-widget-visibility')
                ->check('@xray')
                ->click('@customize-widget-visibility');
                $browser->driver->executeScript('window.scrollTo(0, 750);');
                $browser
                ->click('@drill_xray')
                ->assertSee('Dashboard Details: X-Ray Scanned')
                ->click('@back_to_dashboard')

                ->click('@customize-widget-visibility')
                ->check('@clavicle-triage')
                ->click('@customize-widget-visibility');
                $browser->driver->executeScript('window.scrollTo(0, 750);');
                $browser
                ->click('@drill_clavicle_triage')
                ->assertSee('Dashboard Details: Clavicle Triage')
                ->click('@back_to_dashboard')

                ->click('@customize-widget-visibility')
                ->check('@isotope-sampled')
                ->click('@customize-widget-visibility');
                $browser->driver->executeScript('window.scrollTo(0, 750);');
                $browser
                ->click('@drill_isotope_sampled')
                ->assertSee('Dashboard Details: Isotope Sampled')
                ->click('@back_to_dashboard')

                //TODO: drill crashes
                ->click('@customize-widget-visibility')
                ->check('@mni-bones')
                ->click('@customize-widget-visibility');
                $browser->driver->executeScript('window.scrollTo(0, 750);');
                $browser
                ->click('@drill_mni_bones')
                ->assertSee('Dashboard Details: Mito Sequences')
                ->click('@back_to_dashboard')

                //TODO: wrong drill loads
                ->click('@customize-widget-visibility')
                ->check('@mni-zones')
                ->click('@customize-widget-visibility');
                $browser->driver->executeScript('window.scrollTo(0, 750);');
                $browser
                ->click('@drill_mni_zones')
                //->assertSee('Dashboard Details: Mito Sequences')
                ->click('@back_to_dashboard')

                ->assertSee("****FORCED FAIL****");

        });
    }
    /**
     * A Dusk test for each of the drilldown buttons on the project dashboard for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group DrilldownsManager
     * @group AuthorJohn
     */
    public function DrilldownsManager()
    {
        // Test User login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome to CoRA')
                ->assertSee('Home');

            //testing main graphs
            $browser->maximize();
            $browser->visit(new homePage)
                ->visit('/')
                ->assertSee('Welcome to CoRA')
                ->assertPathIs('/')
                ->click('@dashboard-home')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                //Testing each drilldown button
                ->click('@drill_complete')
                ->assertSee('Dashboard Details: Complete')
                ->click('@back_to_dashboard')
                ->assertSee('Dashboard')

                ->click('@drill_se_to_ind')
                ->assertSee('Dashboard Details: Specimens Associated')
                ->click('@back_to_dashboard')

                ->click('@drill_dna_sampled')
                ->assertSee('Dashboard Details: DNA Sampled')
                ->click('@back_to_dashboard')

                //$browser->driver->executeScript('window.scrollTo(0, 750);');
                //$browser
                ->click('@customize-widget-visibility')
                ->uncheck('@complete')
                ->uncheck('@skeletal-elements')
                ->uncheck('@dna-sampled')
                ->click('@customize-widget-visibility')
                ->click('#widget4_1 > div:nth-child(2) > div:nth-child(1) > a')
                //->click('@drill_mito_seq')
                ->assertSee('Dashboard Details: Mito Sequences')
                ->click('@back_to_dashboard')

                ->click('@drill_mni_bones_side');
            $browser->driver->executeScript('window.scrollTo(0, 750);');
            $browser
                ->assertSee('Dashboard Details: MNI by Bones and Side')
                ->click('@back_to_dashboard')

                ->click('@drill_mni_zones_side');
            $browser->driver->executeScript('window.scrollTo(0, 750);');
            $browser
                ->assertSee('Dashboard Details: MNI by Zones and Side')
                ->click('@back_to_dashboard')

                ->click('@drill_mito_bones_side');
            $browser->driver->executeScript('window.scrollTo(0, 750);');
            $browser
                ->assertSee('Dashboard Details: Mito Sequences by Bones and Side')
                ->click('@back_to_dashboard');

            $browser->driver->executeScript('window.scrollTo(0, 900);');
            $browser
                ->click('@drill_inventory')
                ->assertSee('Dashboard Details: Inventory')
                ->click('@back_to_dashboard')

                /**
                //Begin testing of the additional charts
                //From here on each chart must be
                //manually selected to show up on page
                 */

                ->click('@customize-widget-visibility')
                ->uncheck('@complete')
                ->uncheck('@skeletal-elements')
                ->uncheck('@dna-sampled')
                ->check('@measured')
                ->click('@customize-widget-visibility')
                ->click('@drill_measured')
                ->assertSee('Dashboard Details: Measured')
                ->assertSee('****FORCED FAIL****')
                ->click('@back_to_dashboard')

                ->click('@customize-widget-visibility')
                ->check('@ct-scan')
                ->click('@customize-widget-visibility');
            $browser->driver->executeScript('window.scrollTo(0, 750);');
            $browser
                ->click('@drill_ct_scan')
                ->assertSee('Dashboard Details: CT Scanned')
                ->click('@back_to_dashboard')

                ->click('@customize-widget-visibility')
                ->check('@xray')
                ->click('@customize-widget-visibility');
            $browser->driver->executeScript('window.scrollTo(0, 750);');
            $browser
                ->click('@drill_xray')
                ->assertSee('Dashboard Details: X-Ray Scanned')
                ->click('@back_to_dashboard')

                ->click('@customize-widget-visibility')
                ->check('@clavicle-triage')
                ->click('@customize-widget-visibility');
            $browser->driver->executeScript('window.scrollTo(0, 750);');
            $browser
                ->click('@drill_clavicle_triage')
                ->assertSee('Dashboard Details: Clavicle Triage')
                ->click('@back_to_dashboard')

                ->click('@customize-widget-visibility')
                ->check('@isotope-sampled')
                ->click('@customize-widget-visibility');
            $browser->driver->executeScript('window.scrollTo(0, 750);');
            $browser
                ->click('@drill_isotope_sampled')
                ->assertSee('Dashboard Details: Isotope Sampled')
                ->click('@back_to_dashboard')

                //TODO: drill crashes
                ->click('@customize-widget-visibility')
                ->check('@mni-bones')
                ->click('@customize-widget-visibility');
            $browser->driver->executeScript('window.scrollTo(0, 750);');
            $browser
                ->click('@drill_mni_bones')
                ->assertSee('Dashboard Details: Mito Sequences')
                ->click('@back_to_dashboard')

                //TODO: wrong drill loads
                ->click('@customize-widget-visibility')
                ->check('@mni-zones')
                ->click('@customize-widget-visibility');
            $browser->driver->executeScript('window.scrollTo(0, 750);');
            $browser
                ->click('@drill_mni_zones')
                //->assertSee('Dashboard Details: Mito Sequences')
                ->click('@back_to_dashboard')

                ->assertSee("****FORCED FAIL****");

        });
    }
    /**
     * A Dusk test for each of the drilldown buttons on the project dashboard for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Dashboard
     * @group UNO
     * @group DrilldownsOrgAdmin
     * @group AuthorJohn
     */
    public function DrilldownsOrgAdmin()
    {
        // Test User login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome to CoRA')
                ->assertSee('Home');

            //testing main graphs
            $browser->maximize();
            $browser->visit(new homePage)
                ->visit('/')
                ->assertSee('Welcome to CoRA')
                ->assertPathIs('/')
                ->click('@dashboard-home')
                ->assertSee('Dashboard')
                ->assertPathIs('/dashboard')

                //Testing each drilldown button
                ->click('@drill_complete')
                ->assertSee('Dashboard Details: Complete')
                ->click('@back_to_dashboard')
                ->assertSee('Dashboard')

                ->click('@drill_se_to_ind')
                ->assertSee('Dashboard Details: Specimens Associated')
                ->click('@back_to_dashboard')

                ->click('@drill_dna_sampled')
                ->assertSee('Dashboard Details: DNA Sampled')
                ->click('@back_to_dashboard')

                //$browser->driver->executeScript('window.scrollTo(0, 750);');
                //$browser
                ->click('@customize-widget-visibility')
                ->uncheck('@complete')
                ->uncheck('@skeletal-elements')
                ->uncheck('@dna-sampled')
                ->click('@customize-widget-visibility')
                ->click('#widget4_1 > div:nth-child(2) > div:nth-child(1) > a')
                //->click('@drill_mito_seq')
                ->assertSee('Dashboard Details: Mito Sequences')
                ->click('@back_to_dashboard')

                ->click('@drill_mni_bones_side');
            $browser->driver->executeScript('window.scrollTo(0, 750);');
            $browser
                ->assertSee('Dashboard Details: MNI by Bones and Side')
                ->click('@back_to_dashboard')

                ->click('@drill_mni_zones_side');
            $browser->driver->executeScript('window.scrollTo(0, 750);');
            $browser
                ->assertSee('Dashboard Details: MNI by Zones and Side')
                ->click('@back_to_dashboard')

                ->click('@drill_mito_bones_side');
            $browser->driver->executeScript('window.scrollTo(0, 750);');
            $browser
                ->assertSee('Dashboard Details: Mito Sequences by Bones and Side')
                ->click('@back_to_dashboard');

            $browser->driver->executeScript('window.scrollTo(0, 900);');
            $browser
                ->click('@drill_inventory')
                ->assertSee('Dashboard Details: Inventory')
                ->click('@back_to_dashboard')

                /**
                //Begin testing of the additional charts
                //From here on each chart must be
                //manually selected to show up on page
                 */

                ->click('@customize-widget-visibility')
                ->uncheck('@complete')
                ->uncheck('@skeletal-elements')
                ->uncheck('@dna-sampled')
                ->check('@measured')
                ->click('@customize-widget-visibility')
                ->click('@drill_measured')
                ->assertSee('Dashboard Details: Measured')
                ->assertSee('****FORCED FAIL****')
                ->click('@back_to_dashboard')

                ->click('@customize-widget-visibility')
                ->check('@ct-scan')
                ->click('@customize-widget-visibility');
            $browser->driver->executeScript('window.scrollTo(0, 750);');
            $browser
                ->click('@drill_ct_scan')
                ->assertSee('Dashboard Details: CT Scanned')
                ->click('@back_to_dashboard')

                ->click('@customize-widget-visibility')
                ->check('@xray')
                ->click('@customize-widget-visibility');
            $browser->driver->executeScript('window.scrollTo(0, 750);');
            $browser
                ->click('@drill_xray')
                ->assertSee('Dashboard Details: X-Ray Scanned')
                ->click('@back_to_dashboard')

                ->click('@customize-widget-visibility')
                ->check('@clavicle-triage')
                ->click('@customize-widget-visibility');
            $browser->driver->executeScript('window.scrollTo(0, 750);');
            $browser
                ->click('@drill_clavicle_triage')
                ->assertSee('Dashboard Details: Clavicle Triage')
                ->click('@back_to_dashboard')

                ->click('@customize-widget-visibility')
                ->check('@isotope-sampled')
                ->click('@customize-widget-visibility');
            $browser->driver->executeScript('window.scrollTo(0, 750);');
            $browser
                ->click('@drill_isotope_sampled')
                ->assertSee('Dashboard Details: Isotope Sampled')
                ->click('@back_to_dashboard')

                //TODO: drill crashes
                ->click('@customize-widget-visibility')
                ->check('@mni-bones')
                ->click('@customize-widget-visibility');
            $browser->driver->executeScript('window.scrollTo(0, 750);');
            $browser
                ->click('@drill_mni_bones')
                ->assertSee('Dashboard Details: Mito Sequences')
                ->click('@back_to_dashboard')

                //TODO: wrong drill loads
                ->click('@customize-widget-visibility')
                ->check('@mni-zones')
                ->click('@customize-widget-visibility');
            $browser->driver->executeScript('window.scrollTo(0, 750);');
            $browser
                ->click('@drill_mni_zones')
                //->assertSee('Dashboard Details: Mito Sequences')
                ->click('@back_to_dashboard')

                ->assertSee("****FORCED FAIL****");

        });
    }
}
