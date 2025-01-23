# PHP Sonar API Client
...
An Object Oriented API Client for the ISP account managment and billing Softwware, that is capable of making simultanious queries or mutationsa against the server.

# Installation
...
Run the following command to install the package via composer

```
$ composer require kengineering/sonar-api-client
```
# Requirements

Needs to have the $_ENV variable set up before sending a request, or else an error will be thrown
...

# Usage
...
There are 2 Primary ways to Interface with the api client:

1. Directly with the class that represents the object you with to interact with, found in `Kengineering\Sonar\Objects\`

2. With the Request Class found in `Kengineering\Sonar\Request`. the only time you would have to use this class is if there are multiple queries or mutations needing to run with one request

# Usage Examples

## Basic Querying

```php
$accounts = Accounts::get();
```