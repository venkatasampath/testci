<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],


    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here which uses session storage and the Eloquent user provider.
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | Supported: "session", "token"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'api' => [
            'driver' => 'token',
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | If you have multiple user tables or models you may configure multiple
    | sources which represent each model / table. These sources may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\User::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | You may specify multiple password reset configurations if you have more
    | than one user table or model in the application and you want to have
    | separate password reset settings based on the specific user types.
    |
    | The expire time is the number of minutes that the reset token should be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_resets',
            'expire' => 60,
        ],
        'numPasswordHistory' => env('NUM_PASSWORD_HISTORY', 3),
        'expiryDays' => env('PASSWORD_EXPIRY_DAYS', 90),
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Strength Requirements
    |--------------------------------------------------------------------------
    |
    | The next few lines correspond to password strength requirements such as
    | min length, having at least one capital, one lowercase letters, one
    | digit, one special character. When true the corresponding rule is
    | enforced. Note that by default the minimum password length is 8
    |
    */

    'passwordstrength' => [
        'min10' => true,
        'max'   => true,
        'pass_capital_lowercase' => true,
        'pass_digit' => true,
        'pass_sp_char' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Login Security Requirements
    |--------------------------------------------------------------------------
    |
    | The next few lines correspond to login security requirements such as
    | maxInactiveDays (max number of days the account can be inactive
    | before account is locked, which will require admin to unlock
    | maxLoginAttempts (number of failed login attempts before lockout),
    | lockoutTime (The lockout time in minutes when max login attempts
    | is reached).
    |
    */
    'login' => [
        'maxInactiveDays' => 60,
        'maxLoginAttempts' => 3,
        'lockoutTime' => 10,
    ],
];
