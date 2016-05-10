Arrayer
=========

[![Latest Stable Version](https://poser.pugx.org/mascame/arrayer/v/stable.svg)](https://packagist.org/packages/mascame/arrayer)
[![License](https://poser.pugx.org/mascame/arrayer/license.svg)](https://packagist.org/packages/mascame/arrayer)

Array manipulation. Get, set & delete keys with dot notation, also prepares an array to be put in a file (php array or json).

Installation
--------------

Require this package in your composer.json and run composer update:

    "mascame/arrayer": "3.*"


Usage
--------------

```php

use \Mascame\Arrayer\Arrayer;
use \Mascame\Arrayer\Builder;

$array = array(

	'this' => array(
		'is' => 'an',
		'example'
	),

	'we use a' => 'normal array',

	'and manipulate it' => array(
		'as' => array(
			'we' => array(
				'want' => ':D'
			)
		)
	),

	'thats it',
	'cool? :)'

);

$arrayer = new \Mascame\Arrayer\Arrayer($array);

$arrayer->set('we.use.dot.notation', array('so', 'cool.'));

$arrayer->set('this.is', 'we gonna delete this very soon...');
$arrayer->delete('this.is');

$arrayer->set('more.examples', 'test');
$arrayer->get('more.examples'); // returns 'test'

$arrayer->getArray(); // returns the modified array
```

Build a prepared output for file (This example uses Laravel's "File" class to put file contents):

```php

/**
   Available options for ArrayBuilder
    [
        'oldSyntax' => false, // use old array syntax
        'minify' => false,
        'startWithScript' => true, // start with <?php
        'initialStatement' => 'return ',
    ]
*/
$builder = new \Mascame\Arrayer\Builder\ArrayBuilder($arrayer->getArray(), $options);

File::put('test.php', $builder->getContent()); // getContent returns a prepared output to put in a file

/**
   Available options for JsonBuilder
    [
        'minify' => false,
    ]
*/
$builder = new \Mascame\Arrayer\Builder\JsonBuilder($arrayer->getArray(), $options);

File::put('test.json', $builder->getContent());
```

Changelog
----
### 3.0
- Simplified code
- Improved ArrayBuilder, added options and included JsonBuilder
- Removed ->append() method @ Arrayer because was a bit confusing
- Removed not used laravel specific files

### 2.1
- Added tests
- Fixed arrayDot not being created on constructor
- Removed unnecessary dependency

### 2.0
- Added manipulation methods (get, set, delete)
- Dot notation
- Extracted builder

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
