# Humble
Lightweight, expandable and easy-to-use query builder.

## Contents
- [Requirments](https://github.com/pixaye/humble#requirments)
- [Installation](https://github.com/pixaye/humble#installation)
- [Quick start](https://github.com/pixaye/humble#quick-start)

## Requirments
- PHP 7.1+
- PDO

## Installation
Installtion via composer:

````
composer require pixaye/humble
````

## Quick start

```php
<?php

/** Initializing database manager */
$db = new \Humble\DatabaseManager([
    'connection' => [
        'db' => 'test',
        'host' => '127.0.0.1',
        'user' => 'root',
        'password' => ''
    ]
]);

/** After initializing, you can get any table from specified db */

/** @var Humble\Database\RepositoryInterface $user */
$user = $db->user;

/** @var stdClass[] $administrators */
$administrators = $user->getBy([
    new \Humble\Query\Where(['admin' => 1])
]);

$authorsAndTheirBooks = $user->getBy([
    new \Humble\Query\Join('books', ['user.id' => 'books.author_id'], \Humble\Query\Join::HUMBLE_LEFT_JOIN)
]);

/** Creating new record */
$user->insert([
    'name' => 'John Doe',  
    'admin' => 1
]);

/** Updating record */
$user->update([
    new \Humble\Query\Where(['name' => 'John Doe'])
], [
    'name' => 'John Doe jr.'
]);

/** Deleting record */
$user->delete([
    new \Humble\Query\Where(['id' => 2])
]);
```



