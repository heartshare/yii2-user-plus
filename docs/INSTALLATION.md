# Getting started with Yii2-advance-user

### 1. Download

This extension can be installed using composer. Run following command to download and install :

```bash
composer require "johnitvn/yii2-advance-user:*"
```

or add to the require section of your composer.json file.

```
"johnitvn/yii2-settings": "*"
```

### 2. Configure

Add following lines to your main configuration file:

```php
'components' => [
    'user' => [
        'identityClass' => 'johnitvn\advanceuser\models\User',
   ],  
],
'modules' => [
    'user' => [
        'class' => 'johnitvn\advanceuser\Module',
    ],
],
```

### 3. Update database schema

>Make sure that you have properly configured `db` application component

Run the following command:

```bash
$ php yii migrate/up --migrationPath=@vendor/johnitvn/yii2-advance-user/src/migrations
```

