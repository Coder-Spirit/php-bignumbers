php-bignumbers
==============

A robust library to handle immutable big numbers inside PHP applications
The current stable version is 0.4.2. [![Donate](https://dl.dropboxusercontent.com/u/487440/reformal/donate.png "Donate")](https://www.gittip.com/castarco/)

* Build Status: [![Build Status](https://api.travis-ci.org/Litipk/php-bignumbers.png?tag=0.4.2)](https://travis-ci.org/Litipk/php-bignumbers)
* Coverage Status: [![Coverage Status](https://coveralls.io/repos/Litipk/php-bignumbers/badge.png?tag=0.4.2)](https://coveralls.io/r/Litipk/php-bignumbers?branch=master)
* Dependency Status: [![Dependency Status](https://www.versioneye.com/user/projects/52cc91c6ec13754970000275/badge.png)](https://www.versioneye.com/user/projects/52cc91c6ec13754970000275)

## Requirements

Litipk PHP BigNumbers supports PHP 5.3.x, 5.4.x and 5.5.x,
but also Facebook's [HHVM](http://www.hhvm.com).

## Install Instructions

You can install this library using [Composer](http://getcomposer.org/).

To install it via Composer, just write in the require block of your
composer.json file the following text:

```json
{
    "require": {
        "litipk/php-bignumbers": "0.4.2"
    }
}
```

## Basic Usage

```php
<?php
  
  use \Litipk\BigNumbers\Decimal as Decimal;
  
  /**
   * There are many ways to create Decimal objects.
   *
   * We can use the following methods:
   *
   *   Decimal::fromInteger
   *   Decimal::fromFloat
   *   Decimal::fromString
   *   Decimal::fromDecimal
   *
   *   Decimal::create // this method works as methods fromType, but is more flexible
   */
  
  $ten = Decimal::fromInteger(10);
  $two = Decimal::fromString('2.0');
  
  /**
   * At this moment there are few binary operators
   * that we can use with Decimal objects:
   *
   *  $d1->add($d2);
   *  $d1->sub($d2);
   *  $d1->mul($d2);
   *  $d1->div($d2);
   */

  $twenty = $ten->mul($two);
  $forty  = $two->mul(Decimal::fromFloat(20.));

  /**
   * There are many unary operators too:
   *
   * $d1->abs();
   * $d1->sqrt();
   * $d1->log10();
   * $d1->round($scale);
   * $d1->additiveInverse();
   */
  
  $five  = Decimal::fromInteger(-5)->abs();
  $six   = Decimal::fromInteger(6)->abs();

  $three = Decimal::fromInteger(9)->sqrt();

  Decimal::fromString('0.06')->round(0)->equals(Decimal::fromString('0'));   // returns true
  Decimal::fromString('0.06')->round(1)->equals(Decimal::fromString('0.1')); // returns true

  $five->additiveInverse()->equals(Decimal::fromInteger(-5)); // returns true

  /**
   * You can check many properties of your numbers:
   *
   * $d1->isNegative();
   * $d1->isZero();
   * $d1->isPositive();
   * $d1->isInfinite();
   * $d1->isNaN();
   */
  
  $zero = Decimal::fromInteger(0);
  $zero->isZero(); // Returns true

  $five->div($zero)->isNaN(); // Returns true
  $zero->div($five)->isNaN(); // Returns false

  $five->additiveInverse()->sqrt()->isNaN(); // Returns true
?>
```

The documentation is incomplete, if you want to use
all the features of this package, you can see which
public methods are declared in the Decimal class.


## TODO List

- [ ] Create the **Integer** class.
- [ ] Create the **Rational** class.
- [ ] Create the **Complex** class.
- [ ] Add the *pow* method.
