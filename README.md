Arrayer
=========

[![Packagist](https://img.shields.io/packagist/v/mascame/arrayer.svg?maxAge=2592000?style=plastic)](https://packagist.org/packages/mascame/arrayer)
[![Travis](https://img.shields.io/travis/marcmascarell/arrayer.svg?maxAge=2592000?style=plastic)](https://travis-ci.org/marcmascarell/arrayer)
[![license](https://img.shields.io/github/license/marcmascarell/arrayer.svg?maxAge=2592000?style=plastic)](https://github.com/marcmascarell/arrayer)

Array manipulation. Get, set & delete keys with dot notation, also prepares an array to be put in a file (php array or json).

Installation
--------------

Require this package in your composer.json and run composer update:

    "mascame/arrayer": "3.*"


Usage
--------------

```php

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
*   Available options for ArrayBuilder
*    [
*        'oldSyntax' => false, // use old array syntax
*        'minify' => false,
*        'indexes' => true, // Show the incremental indexes (array keys)
*        'startWithScript' => true, // start with <?php
*        'initialStatement' => 'return ',
*    ]
*/
$builder = new \Mascame\Arrayer\Builder\ArrayBuilder($arrayer->getArray(), $options);

File::put('test.php', $builder->getContent()); // getContent returns a prepared output to put in a file

/**
*   Available options for JsonBuilder
*    [
*        'minify' => false,
*    ]
*/
$builder = new \Mascame\Arrayer\Builder\JsonBuilder($arrayer->getArray(), $options);

File::put('test.json', $builder->getContent());
```

Changelog
----

### 3.4
- Fix missing files after migration to PSR-4 

### 3.3
- ArrayBuilder 'indexes' option to remove the incremental indexes (array keys)

### 3.1
- Simplification
- Improved builders

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


Contributing
----

Thank you for considering contributing! You can contribute at any time forking the project and making a pull request.

Support
----

If you need help or any kind of support, please send an e-mail to Marc Mascarell at marcmascarell@gmail.com.

License
----

MIT
