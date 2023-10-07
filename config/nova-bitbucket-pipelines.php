<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Bitbucket API URL
    |--------------------------------------------------------------------------
    |
    | This value is the URL of the Bitbucket API. You should provide the base
    | URL of the API, as it is used as the basis for all API requests.
    | Typically, this value is set in your environment file.
    |
    */

    'api_url' => env('BITBUCKET_API_ROOT', 'https://api.bitbucket.org'),

    /*
    |--------------------------------------------------------------------------
    | API Version
    |--------------------------------------------------------------------------
    |
    | Here you may specify the version of the Bitbucket API that should be used
    | by the package when sending API requests. This allows for future-proofing
    | your application in case of API changes or upgrades.
    |
    */

    'api_version' => env('BITBUCKET_API_VERSION', '2.0'),

    /*
    |--------------------------------------------------------------------------
    | Application Password
    |--------------------------------------------------------------------------
    |
    | This is the password used for authenticating with the Bitbucket API.
    | It should be kept secure and not be exposed or committed to your
    | code repository. Typically, this value is set in your environment file.
    |
    */

    'app_password' => env('BITBUCKET_APP_PASSWORD', 'your-app-password'),

    /*
    |--------------------------------------------------------------------------
    | Username
    |--------------------------------------------------------------------------
    |
    | This value is your Bitbucket username, used together with the application
    | password to authenticate API requests. Typically, this is set in your
    | environment file.
    |
    */

    'username' => env('BITBUCKET_USERNAME', 'your-username'),

    /*
    |--------------------------------------------------------------------------
    | Workspaces Configuration
    |--------------------------------------------------------------------------
    |
    | Below, you can define the configuration for the Bitbucket workspaces.
    | Each workspace should be identified by a unique key, and can have
    | a 'name', 'repo', and 'refs' or branches configuration. These ref names will be
    | used when checking for the pipeline status. Adjust as necessary.
    |
    */

    'workspace' => [
        'name' => env('BITBUCKET_WORKSPACE_WEB_NAME', ''),
        'repo' => [
            'name' => env('BITBUCKET_WORKSPACE_WEB_REPO_NAME', ''),
            'refs' => [
                // Add your refs configuration here
            ],
        ],
    ],

];
