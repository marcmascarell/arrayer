Arrayer
=========

Prepares an array to be put in a file. Very useful for configuration files.

Installation
--------------

Require this package in your composer.json and run composer update:

    "mascame/arrayer": "dev-master"

Or use latest stable (recommended)

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

License
----

MIT
