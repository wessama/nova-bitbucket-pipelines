
# Display Bitbucket pipeline status in Laravel Nova

## Installation

You can install the package in a Laravel app that uses [Nova](https://nova.laravel.com) via composer:

```bash
composer require wessama/nova-bitbucket-pipelines
```

Next up, you must register the card with Nova. This is typically done in the `cards` method of a `Dashboard` class.

```php
public function cards()
{
    return [
        // ...
         (new \WessamA\NovaBitbucketPipelines\Pipelines()),
    ];
}
```

## Configuration and Usage

Before using the package, you need to set up your environment variables and publish the configuration file to customize the package according to your needs.

### Setting Environment Variables

1. Open your `.env` file in the root of your Laravel project.

2. Find and set the following environment variables related to the Bitbucket API:

    ```env
    BITBUCKET_API_ROOT=https://api.bitbucket.org # Default API root URL (you may not need to change this)
    BITBUCKET_API_VERSION=2.0 # Default API version (you may not need to change this)
    BITBUCKET_APP_PASSWORD=your_app_password # Replace 'your_app_password' with your actual Bitbucket app password
    BITBUCKET_USERNAME=your_username # Replace 'your_username' with your actual Bitbucket username
    BITBUCKET_WORKSPACE_WEB_NAME=your_workspace_name # Replace with your workspace name
    BITBUCKET_WORKSPACE_WEB_REPO_NAME=your_repo_name # Replace with your repository name
    ```

### Publishing the Configuration File

To publish the package’s configuration file to your application's `config` directory, run the following command:

```bash
php artisan vendor:publish --tag=config --provider="WessamA\NovaBitbucketPipelines\CardServiceProvider"
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Security

If you discover any security related issues, please email wessam.ah@outlook.com instead of using the issue tracker.

## Credits

- [Wessam Ahmed](https://github.com/wessama)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
