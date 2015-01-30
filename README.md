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

$arrayer->append("I am an appended!");

$arrayer->set('we.use.dot.notation', array('so', 'cool.'));
$arrayer->set('more.examples', 'test');

$arrayer->set('this.is', 'this is gonna be deleted soon...');
$arrayer->delete('this.is');

$arrayer->get('more.examples'); // returns 'test'

$arrayer->getArray();
/** equals to

(
    [this] => Array
        (
            [0] => example
        )

    [we use a] => normal array
    [and transform it] => Array
        (
            [to be] => Array
                (
                    [able] => Array
                        (
                            [to put it] => in a file
                        )
                )
        )

    [0] => thats it
    [1] => cool? :)
    [2] => I am an appended!
    [we] => Array
        (
            [use] => Array
                (
                    [dot] => Array
                        (
                            [notation] => Array
                                (
                                    [0] => so
                                    [1] => cool.
                                )
                        )
                )
        )

    [more] => Array
        (
            [examples] => test
        )

)
*/
```

Build a prepared output for file:

```php

$builder = new \Mascame\Arrayer\Builder($arrayer->getArray(), true)); // (any array, (bool)minified)

File::put('test.php', $builder->getContent()); // getContent returns a prepared output to put in a file
```

Changelog
----
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
