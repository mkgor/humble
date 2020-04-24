# Humble
Lightweight, expandable and easy-to-use query builder.

## Contents
- [Requirments](https://github.com/mkgor/humble#requirments)
- [Installation](https://github.com/mkgor/humble#installation)
- [Quick start](https://github.com/mkgor/humble#quick-start)
- [Query building blocks](https://github.com/mkgor/humble#query-building-blocks)
    - [Where, AndWhere, OrWhere](https://github.com/mkgor/humble#where-andwhere-orwhere)
    - [Join](https://github.com/mkgor/humble#join)

## Requirments
- PHP 7.1+
- PDO

## Installation
Installtion via composer:

````
composer require mkgor/humble
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

/** @var stdClass $someUser */
$someUser = $user->get(1);

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

## Query building blocks

You can build complicated queries by using query building blocks. Query building block is a class, which add block of
SQL code to query.

Example:

```php
<?php
/** @var \Humble\Database\RepositoryInterface $user */
$user = $db->user;

$authorsAndTheirBooks = $user->getBy([
    new \Humble\Query\Join('books', ['user.id' => 'books.author_id'], \Humble\Query\Join::HUMBLE_LEFT_JOIN),
    new \Humble\Query\Where(['books.views','>',1000])
]);
```

That code will generate SQL
```sql
SELECT * FROM `user` LEFT JOIN `books` `books_1234` ON user.id = `books_1234`.author_id WHERE `books_1234`.views > 1000
```

### Where, AndWhere, OrWhere

Adding WHERE to query

**Usage:**
```php
<?php
/** @var \Humble\Database\RepositoryInterface $user */
$user = $db->user;

// ... WHERE `admin` = 1
$administrators = $user->getBy([
    new \Humble\Query\Where(['admin' => 1])
]);

// ... WHERE `admin` = 1 AND `registration_date` > '01-01-2020'
$newAdministrators = $user->getBy([
    new \Humble\Query\Where(['admin' => 1],['registration_date', '>' ,'01-01-2020'])
]);

// Doing the same, but it is unsafe if you are putting non-escaped values into query
$inlineWhere = $user->getBy([
    new \Humble\Query\Where('admin = 1 AND registration_date > "01-01-2020"')
]);

// ... WHERE `name` = 'John Doe' OR (`name` = 'Sarah Doe')
$objectInWhere = $user->getBy([
    new \Humble\Query\Where(['name' => 'John Doe'], new \Humble\Query\OrWhere(['name' => 'Sarah Doe']))
]);

// ... WHERE `name` = 'John Doe' OR (`name` = 'Sarah Doe' AND (`admin` = 1))
$complexWhere = $user->getBy([
    new \Humble\Query\Where(['name' => 'John Doe']),
    new \Humble\Query\OrWhere(['name' => 'Sarah Doe'], new \Humble\Query\AndWhere(['admin' => 1]))
]);
```

### Join

Adding JOIN into your query

```php
<?php

/** @var \Humble\Database\RepositoryInterface $user */
$user = $db->user;

$authorsAndTheirBooks = $user->getBy([
    new \Humble\Query\Join('books', ['user.id' => 'books.author_id'], \Humble\Query\Join::HUMBLE_LEFT_JOIN),
]);

$outerJoinFlagDemo = $user->getBy([
    new \Humble\Query\Join('books', ['user.id' => 'books.author_id'], \Humble\Query\Join::HUMBLE_LEFT_JOIN, [\Humble\Query\Join::HUMBLE_OUTER_JOIN_FLAG]),
]);
```

**List of all constants**
```php 
\Humble\Query\Join::HUMBLE_JOIN
```
```php
\Humble\Query\Join::HUMBLE_LEFT_JOIN
```
```php
\Humble\Query\Join::HUMBLE_RIGHT_JOIN
```
```php
\Humble\Query\Join::HUMBLE_CROSS_JOIN
```
```php
\Humble\Query\Join::HUMBLE_INNER_JOIN
```
```php
\Humble\Query\Join::HUMBLE_NATURAL_JOIN
```

**List of all flags**
```php
\Humble\Query\Join::HUMBLE_OUTER_JOIN_FLAG
```
