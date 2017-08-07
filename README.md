Sequence bundle
===============

Generating sequences (for invoices / orders / ...). With ability to have custom format for numbering.

## Installation:
```bash
composer require kebza/sequence-bundle
```

Enable bundle in AppKernel

``` php
# app/AppKernel.php
public function registerBundles()
{
    $bundles = array(
        // ...
        new Kebza\SequenceBundle\KebzaSequenceBundle(),
        // ...
    );
}
```

If you are using doctrine storage, you need to add mapping to your entity manager.
```yaml
doctrine:
    orm:
        mappings:
            KebzaSequenceBundle: ~
```

and then update your database schema

```bash
php bin/console doctine:schema:update
```

## Configuration

Before you start you need to configure your sequences.
```bash
kebza_sequence:
    storage: doctrine # file | memory
    sequences:
        first:
            pattern: '{YYYY}{ID|6|WEEK}'
            step: 1
            initial: 1
        second:
            pattern: '{YY}{WW}{ID|6|WEEK}'
            step: 1
            initial: 1
            
```

## Usage
You can use sequences by requestiong *kebza.sequence.manager* service with its methods.

```php
// From controller
$manager = $this->get('kebza.sequence.manager');
$manager->current('first'); // If sequence not initialized, returns null otherwise current formatted value
$manager->next('first'); // Returns next value
$manager->increment('first'); // Increments by configuration of step.
```

## Storages:

- *doctrine* - saves sequences in database
- *file* - saves information into files in directory
- *memory* - Once script ends, info about sequences is lost

## Pattern
In pattern there is possible to use replaces to format final output:

- *{ID|X|Y}* - Replaces ID with current number. If X is specified, will add padding using zeroes to final length. Y can be YEAR, MONTH, WEEK and means that sequence will reset on every new year, month, week
- *{YYYY}* - Year - 2017
- *{YY}* - Year - 17
- *{MM}* - month 12
- *{WW}* - Week number



