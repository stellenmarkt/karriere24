Karriere24 YAWIK module
=======================

This module provides the layout and special functionality for the yawik instance
running on [karriere24.com](http://karriere24.com)

Requirements
------------

running [YAWIK](https://github.com/cross-solution/YAWIK) >= 0.33

Installation
------------

Require a dependency via composer.

```bash
composer require stellenmarkt/karriere24
```

You should have been asked by the zf-component-installer to add the module to the configuration.
If - for whatever reason - this did not happen, you need to manually add the module name to the file 
config/modules.php


Development
-------
1.  Clone project
```sh
$ git clone git@github.com:stellenmarkt/karriere24.git /path/to/karriere24 
```

2. Install dependencies:
```sh
$ composer install
```

3. Run PHPUnit Tests
```sh
$ ./vendor/bin/phpunit
```

4. Run Behat Tests
```sh

# start selenium
$ composer run start-selenium --timeout=0

# start php server
$ composer run serve --timeout=0

# run behat
$ ./vendor/bin/behat

```

Licence
-------

MIT
