
### Initialize the API Client

The following parameters are configurable for the API Client:

| Parameter | Type | Description |
|  --- | --- | --- |
| `oAuthClientId` | `string` | OAuth 2 Client ID |
| `oAuthClientSecret` | `string` | OAuth 2 Client Secret |
| `environment` | Environment | The API environment. <br> **Default: `Environment.PRODUCTION`** |
| `timeout` | `int` | Timeout for API calls |
| `oAuthToken` | `?Models\OAuthToken` | OAuth 2 token |

The API client can be initialized as follows:

```php
$client = new MdNotesCCGLib\MdNotesCCGClient([
    // Set authentication parameters
    'oAuthClientId' => 'OAuthClientId',
    'oAuthClientSecret' => 'OAuthClientSecret',

    // Set the environment
    'environment' => 'production',
]);
```

You must now authorize the client.

### Authorization

The SDK uses *OAuth 2.0 Authorization* to authorize the client.

The `authorize()` method will exchange the OAuth client credentials for an *access token*. The access token is an object containing information for authorizing client requests and refreshing the token itself.

```php
try {
    $client->auth()->authorize();
} catch (MdNotesCCGLib\Exceptions\OAuthProviderException $ex) {
    // handle exception
}
```

The client can now make authorized endpoint calls.

#### Storing an access token for reuse

It is recommended that you store the access token for reuse.

```php
// store token
$_SESSION['access_token'] = MdNotesCCGLib\Configuration::$oAuthToken;
```

#### Creating a client from a stored token

To authorize a client from a stored access token, just set the access token in Configuration along with the other configuration parameters before creating the client:

```php
// load token later...
MdNotesCCGLib\Configuration::$oAuthToken = $_SESSION['access_token'];

// Set other configuration, then instantiate client
$client = new MdNotesCCGLib\MdNotesCCGClient();
```

#### Complete example

```php
<?php
require_once __DIR__.'/vendor/autoload.php';

session_start();

// Client configuration
$client = new MdNotesCCGLib\MdNotesCCGClient([
    // Set authentication parameters
    'oAuthClientId' => 'OAuthClientId',
    'oAuthClientSecret' => 'OAuthClientSecret',

    // Set the environment
    'environment' => 'production',
]);



// try to restore access token from session
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
    MdNotesCCGLib\Configuration::$oAuthToken = $_SESSION['access_token'];
} else {
    try {
        // obtain a new access token
        $token = $client->auth()->authorize();
        $_SESSION['access_token'] = $token;
    } catch (MdNotesCCGLib\Exceptions\OAuthProviderException $ex) {
        // handle exception
        die();
    }
}

// the client is now authorized; you can use $client to make endpoint calls
```

### Test the SDK

Unit tests in this SDK can be run using PHPUnit.

1. First install the dependencies using composer including the `require-dev` dependencies.
2. Run `vendor\bin\phpunit --verbose` from commandline to execute tests. If you have installed PHPUnit globally, run tests using `phpunit --verbose` instead.

You can change the PHPUnit test configuration in the `phpunit.xml` file.

