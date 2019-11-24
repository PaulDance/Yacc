Yacc - Yet Another Couette & Café
---------------------------------

#### A dynamic room booking Web site, i.e. an AirBnB rip-off.


## Installation

* Clone this git repository.
* Go into the thus downloaded directory.
* Run `make install`, which should install the symfony console and the composer
  dependencies automatically.

## Execution

* Run `make db` in order to build a testing database containing example information,
  called "data fixtures". This will require an Internet connection, as it fetches
  images from the Web and stores them in the `public/assets/img` directory. There
  should only be a few of them, twenty at most. You can run this target as many
  times as you like, it is meant to destroy previous data before making the new
  ones, including the images.
* Run `make run` to start the Symfony local web server, which uses `bin/symfony`
  and not `bin/console`. Then open your Web browser and visit `localhost:8000`.

## Updating

Simply run `make update`. Careful though, as it will potentially overwrite the
requirements lock files `composer.lock` and `symfony.lock`, which detail exactly
what is installed, in order to upgrade the project as a whole.

