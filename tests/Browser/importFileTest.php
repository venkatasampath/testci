<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Browser\Pages\loginPage;
use Tests\Browser\Pages\importFilePage;

class importFileTest extends DuskTestCase
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
     * A Dusk test to verify the import criteria options for an report.
     *
     * @return void
     * @throws
     * @test
     * @group Import
     * @group UNO
     * @group ImportCriteria
     * @group AuthorKyle
     */
    public function ImportCriteria()
    {
        // Test user login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Import Options set up
            $browser->visit(new importFilePage)
                ->pause(1000)
                ->assertPathIs('/importFile')
                ->assertSee('Download Template')
                ->assertSee('Browse')
                ->assertSee('Upload')
                ->click('@import-type-select')
                ->pause(1000)

                // Verify Import Options
                ->assertSee('Specimens')
                ->select('@import-type-select','1')
                ->assertSee('Specimens')
                ->assertPathIs('/importFile')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to verify the import criteria options for an report for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Import
     * @group UNO
     * @group ImportCriteriaManager
     * @group AuthorKyle
     */
    public function ImportCriteriaManager()
    {
        // Test user login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Import Options set up
            $browser->visit(new importFilePage)
                ->pause(1000)
                ->assertPathIs('/importFile')
                ->assertSee('Download Template')
                ->assertSee('Browse')
                ->assertSee('Upload')
                ->click('@import-type-select')
                ->pause(1000)

                // Verify Import Options
                ->assertSee('Specimens')
                ->select('@import-type-select','1')
                ->assertSee('Specimens')
                ->assertPathIs('/importFile')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to verify the import criteria options for an report for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Import
     * @group UNO
     * @group ImportCriteriaOrgAdmin
     * @group AuthorKyle
     */
    public function ImportCriteriaOrgAdmin()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Import Options set up
            $browser->visit(new importFilePage)
                ->pause(1000)
                ->assertPathIs('/importFile')
                ->assertSee('Download Template')
                ->assertSee('Browse')
                ->assertSee('Upload')
                ->click('@import-type-select')
                ->pause(1000)

                // Verify Import Options
                ->assertSee('Specimens')
                ->select('@import-type-select','1')
                ->assertSee('Specimens')
                ->assertPathIs('/importFile')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to verify the failed import of an upload when a file type is not selected for an report.
     *
     * @return void
     * @throws
     * @test
     * @group Import
     * @group UNO
     * @group ImportUploadFail
     * @group AuthorKyle
     */
    public function ImportUploadFail()
    {
        // Test user login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Import Options set up
            $browser->visit(new importFilePage)
                ->pause(1000)
                ->assertPathIs('/importFile')
                ->assertSee('Download Template')
                ->assertSee('Browse')
                ->assertSee('Upload')

                // Click on the import selector without selecting an option
                ->select('@import-type-select','')
                ->pause(1000)

                // Verify the user is unable to upload a file
                ->click('@upload-file-button')
                ->assertPathIs('/importFile')
                ->assertSee('Upload File')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to verify the failed import of an upload when a file type is not selected for an report for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Import
     * @group UNO
     * @group ImportUploadFailManager
     * @group AuthorKyle
     */
    public function ImportUploadFailManager()
    {
        // Test user login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Import Options set up
            $browser->visit(new importFilePage)
                ->pause(1000)
                ->assertPathIs('/importFile')
                ->assertSee('Download Template')
                ->assertSee('Browse')
                ->assertSee('Upload')

                // Click on the import selector without selecting an option
                ->select('@import-type-select','')
                ->pause(1000)

                // Verify the user is unable to upload a file
                ->click('@upload-file-button')
                ->assertPathIs('/importFile')
                ->assertSee('Upload File')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to verify the failed import of an upload when a file type is not selected for an report for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Import
     * @group UNO
     * @group ImportUploadFailOrgAdmin
     * @group AuthorKyle
     */
    public function ImportUploadFailOrgAdmin()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Import Options set up
            $browser->visit(new importFilePage)
                ->pause(1000)
                ->assertPathIs('/importFile')
                ->assertSee('Download Template')
                ->assertSee('Browse')
                ->assertSee('Upload')

                // Click on the import selector without selecting an option
                ->select('@import-type-select','')
                ->pause(1000)

                // Verify the user is unable to upload a file
                ->click('@upload-file-button')
                ->assertPathIs('/importFile')
                ->assertSee('Upload File')

                ->logoutUser();
        });
    }
    /**
     * A Dusk test to verify the import of an upload when a file type is selected for an report.
     *
     * @return void
     * @throws
     * @test
     * @group Import
     * @group UNO
     * @group ImportUpload
     * @group AuthorKyle
     */
    public function ImportUpload()
    {
        // Test user login
        $user = ['email' => 'testuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Import Options set up
            $browser->visit(new importFilePage)
                ->pause(1000)
                ->assertPathIs('/importFile')
                ->assertSee('Download Template')
                ->assertSee('Browse')
                ->assertSee('Upload')

                // Click on the import selector and select the specimens option
                ->select('@import-type-select','1')
                ->pause(1000)

                // Verify the user is able to upload a file
                ->click('@upload-file-button')
                ->assertPathIs('/importFile')
                ->waitForText('File Import started. You will receive a notification when import is completed')
                ->assertSee('File Import started. You will receive a notification when import is completed');

            $response = $this->get('/importFile');

            $response->assertStatus(302);

            $browser->visit(new importFilePage)
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to verify the import of an upload when a file type is selected for an report for a manager.
     *
     * @return void
     * @throws
     * @test
     * @group Import
     * @group UNO
     * @group ImportUploadManager
     * @group AuthorKyle
     */
    public function ImportUploadManager()
    {
        // Test user login
        $user = ['email' => 'testmanageruno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Import Options set up
            $browser->visit(new importFilePage)
                ->pause(1000)
                ->assertPathIs('/importFile')
                ->assertSee('Download Template')
                ->assertSee('Browse')
                ->assertSee('Upload')

                // Click on the import selector and select the specimens option
                ->select('@import-type-select','1')
                ->pause(1000)

                // Verify the user is able to upload a file
                ->click('@upload-file-button')
                ->assertPathIs('/importFile')
                ->waitForText('File Import started. You will receive a notification when import is completed')
                ->assertSee('File Import started. You will receive a notification when import is completed');

            $response = $this->get('/importFile');

            $response->assertStatus(302);

            $browser->visit(new importFilePage)
                ->logoutUser();
        });
    }
    /**
     * A Dusk test to verify the import of an upload when a file type is selected for an report for an org admin.
     *
     * @return void
     * @throws
     * @test
     * @group Import
     * @group UNO
     * @group ImportUploadOrgAdmin
     * @group AuthorKyle
     */
    public function ImportUploadOrgAdmin()
    {
        // Test user login
        $user = ['email' => 'testorgadminuno@unomaha.edu', 'password' => 'Password!23'];
        $this->browse(function ($browser) use ($user) {
            $browser->visit(new loginPage)
                ->loginUser($user['email'], $user['password'])
                ->assertSee('Welcome');

            // Import Options set up
            $browser->visit(new importFilePage)
                ->pause(1000)
                ->assertPathIs('/importFile')
                ->assertSee('Download Template')
                ->assertSee('Browse')
                ->assertSee('Upload')

                // Click on the import selector and select the specimens option
                ->select('@import-type-select','1')
                ->pause(1000)

                // Verify the user is able to upload a file
                ->click('@upload-file-button')
                ->assertPathIs('/importFile')
                ->waitForText('File Import started. You will receive a notification when import is completed')
                ->assertSee('File Import started. You will receive a notification when import is completed');

            $response = $this->get('/importFile');

            $response->assertStatus(302);

            $browser->visit(new importFilePage)
                ->logoutUser();
        });
    }
}
