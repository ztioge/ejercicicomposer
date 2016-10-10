Video Checker
=========

[![Latest Stable Version](https://poser.pugx.org/mascame/video-checker/v/stable.svg)](https://packagist.org/packages/mascame/video-checker)
[![License](https://poser.pugx.org/mascame/video-checker/license.svg)](https://packagist.org/packages/mascame/video-checker)

Check if a video is available online.

Installation
--------------

Require this package in your composer.json and run composer update:

    "mascame/video-checker": "2.*"


Usage
--------------

Just use `$provider->check(videoId)` with the provider you want

```php

$youtubeProvider = new Mascame\VideoChecker\YoutubeProvider();

var_dump($youtubeProvider->check('C7OfO6r_5m0')); // true
var_dump($youtubeProvider->check('CWO3Tuo35-o')); // false

// Check if a video is disponible with API
$youtubeProviderWithAPI = new Mascame\VideoChecker\YoutubeProvider('MY_API_KEY');

var_dump($youtubeProviderWithAPI->check('GOHXRe9o_Ls')); //false

// Check if a video is disponible on a certain country
var_dump($youtubeProviderWithAPI->check('GOHXRe9o_Ls', 'ES')); // false
var_dump($youtubeProviderWithAPI->check('CWO3Tuo35-o', 'IT')); // true

// As array (youtube has an API limit of 50 ids per call)
var_dump($youtubeProviderWithAPI->check(['CWO3Tuo35-o', 'GOHXRe9o_Ls'], 'ES')); // ['CWO3Tuo35-o' => true, 'GOHXRe9o_Ls' => false]

$vimeoProvider = new Mascame\VideoChecker\VimeoProvider();

var_dump($vimeoProvider->check('31161781')); // true
var_dump($vimeoProvider->check('34134308a')); // false

$dailymotionProvider = new Mascame\VideoChecker\DailymotionProvider();

var_dump($dailymotionProvider->check('x38rpxc')); // true
var_dump($dailymotionProvider->check('x38rpxc3232')); // false

// As array
var_dump($dailymotionProvider->check(['x38rpxc', 'x38rpxc3232'])); // ['x38rpxc' => true, 'x38rpxc3232' => false]

```

Running tests
----
Install composer dependencies in development mode

`composer update --dev`

`vendor/bin/phpunit tests/TestVideoChecker.php`

Changelog
----

### 2.3
- Youtube Provider: Throw exception if API call fails or has errors (to avoid false negatives)

### 2.2
- Fixes stored Ids when was not in API response items
- Youtube Provider: get total API calls

### 2.1
- Allows array as parameter in 'check' method (output will be an array ['video-id' => bool, 'video-id2' => bool])
- Youtube Provider: Using ids parameter as array will avoid unneeded API calls (and dont waste quota)

### 2.0
- Allow Youtube API check without country specified
- Simplified API
- Updated tests

### 1.2
- Added API key injection via constructor for YoutubeProvider

### 1.1
- Added checkByCountry for YoutubeProvider

### 1.0
- Added Youtube, Vimeo & Dailymotion providers


Support
----

If you want to give your opinion, you can send me an [email](mailto:marcmascarell@gmail.com), comment the project directly (if you want to contribute with information or resources) or fork the project and make a pull request.

Also I will be grateful if you want to make a donation, this project hasn't got a death date and it wants to be improved constantly:

[![Website Button](http://www.rahmenversand.com/images/paypal_logo_klein.gif "Donate!")](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=marcmascarell%40gmail%2ecom&lc=US&item_name=Arrayer%20Development&no_note=0&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHostedGuest&amount=5 "Contribute to the project")


License
----

MIT