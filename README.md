php-bignumbers
==============

A library to handle immutable big numbers inside PHP applications
(requires PHP >= 5.4.0 or HHVM >= 2.2.0)

The current stable version is 0.2 .

## Install Instructions

To install it via Composer, just write in the require block of your
composer.json file the following text:

```json
{
    "require": {
        "litipk/php-bignumbers": "0.2"
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
   *   Decimal::create // this is for dodgers... ¬¬
   */
  
  $ten = Decimal::fromInteger(10);
  $two = Decimal::fromString('2.0');
  
  $twenty = $ten->mul($two);
  $forty  = $two->mul(Decimal::fromFloat(20.));
  
  /**
   * At this moment there are few binary operators
   * that we can use with Decimal objects:
   *
   *  $d1->add($d2);
   *  $d1->sub($d2);
   *  $d1->mul($d2);
   *  $d1->div($d2);
   */
  
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
- [ ] Add the *log* method.
- [ ] Create an extended set of basic exceptions package.
