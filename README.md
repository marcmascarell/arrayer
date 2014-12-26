Arrayer
=========

[![Latest Stable Version](https://poser.pugx.org/mascame/arrayer/v/stable.svg)](https://packagist.org/packages/mascame/arrayer)
[![License](https://poser.pugx.org/mascame/arrayer/license.svg)](https://packagist.org/packages/mascame/arrayer)

Prepares an array to be put in a file. Very useful for configuration files.

Installation
--------------

Require this package in your composer.json and run composer update:

    "mascame/arrayer": "1.*"


Laravel
--------------

Add the Service Provider to `app/config` at the bottom of Providers:

```php
Mascame\Arrayer\ArrayerServiceProvider
```

Usage
--------------

This example uses laravel's "File" class to put file contents. 

```php
$array = array(

    'this' => array(
        'is' => 'an',
        'example'
    ),

    'we use a' => 'normal array',

    'and transform it' => array(
        'to be' => array(
            'able' => array(
                'to put it' => 'in a file'
            )
        )
    ),

    'thats it',
    'cool? :)'

);

$arrayer = new Arrayer($array);

File::put('test.php', $arrayer->getContent());

/** Results in 'test.php':
<?php

return array(

	"this" => array(
		"is" => "an",
		"0" => "example",
	),

	"and transform it" => array(
		"to be" => array(
			"able" => array(
				"to put it" => "in a file",
			),

		),

	),

	"we use a" => "normal array",
	"0" => "thats it",
	"1" => "cool? :)",
);
*/
```

Now you can easily use that file:

```php
$myArray = include_once('test.php');

// You can manipulate as you like and put it again or append something to the end
unset($myArray[0]);
$myArray[] = "new value!";

$arrayer = new Arrayer($myArray);
$arrayer->append(array("Hello" => "World!"));

File::put('test.php', $arrayer->getContent());
```

Changelog
----

### 1.1
- Added escaping for keys and values


Support
----

If you want to give your opinion, you can send me an [email](mailto:marcmascarell@gmail.com), comment the project directly (if you want to contribute with information or resources) or fork the project and make a pull request.

Also I will be grateful if you want to make a donation, this project hasn't got a death date and it wants to be improved constantly:

[![Website Button](http://www.rahmenversand.com/images/paypal_logo_klein.gif "Donate!")](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=marcmascarell%40gmail%2ecom&lc=US&item_name=Arrayer%20Development&no_note=0&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donateCC_LG%2egif%3aNonHostedGuest&amount=5 "Contribute to the project")


License
----

MIT
