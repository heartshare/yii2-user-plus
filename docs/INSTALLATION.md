# Getting started with Yii2-user-plus

If you are using advanced template please view [Advance Template Configure](https://github.com/johnitvn/yii2-user-plus/blob/master/docs/ADVANCED_TEMPLTE.md)

### 1. Download

This extension can be installed using composer. Run following command to download and install :

```bash
composer require "johnitvn/yii2-user-plus:*"
```

or add to the require section of your composer.json file.

```
"johnitvn/yii2-user-plus": "*"
```

### 2. Configure


#####2.1 Config for <b>basic app template</b>
Add following lines to your web configuration file:

```php
'components' => [
    'gridview'=> 'kartik\grid\Module',
    'user' => [
        'identityClass' => 'johnitvn\userplus\models\User',
    ],  
],
'modules' => [
    'user' => [
        'class' => 'johnitvn\userplus\Module',
    ],
],
```
Add following lines to your console configuration file:
'modules' => [
    'user' => [
        'class' => 'johnitvn\userplus\Module',
    ],
],

#####2.1 Config for <b>advanced app template</b>

Add following lines into 'common/config/main.php':

```php
'components' => [
    'gridview'=> 'kartik\grid\Module',
    'user' => [
        'identityClass' => 'johnitvn\userplus\models\User',
    ],  
],
'modules' => [
    'user' => [
        'class' => 'johnitvn\userplus\Module',
    ],
],
```
Add following lines into console/config/main.php:
'modules' => [
    'user' => [
        'class' => 'johnitvn\userplus\Module',
    ],
],

>Remove `user` component in backend\config\main.php and frontend\config\main.php


### 3. Update database schema

>Make sure that you have properly configured `db` application component

Run the following command:

```bash
$ php yii migrate/up --migrationPath=@vendor/johnitvn/yii2-user-plus/src/migrations

```

###4. Create first super user
Run this command with email and password of super user

````php
yii  user/manager/create <email> <password>

````

Done! You can try to login, now

# Avaiable route

<b>user/manager</b>: For manager user, only superuser have permistion to access this route
<b>user/security/login</b>: For login
<b>user/security/logout</b>: For logout
<b>user/security/register</b>: For user register. Default this action is off. You must enable enableRegister in module for turn on route

# Where do we go?

[2. Configuration instructions](https://github.com/johnitvn/yii2-user-plus/blob/master/docs/CONFIGURATION.md)
<BR>
[2. Guide to troubleshoot](https://github.com/johnitvn/yii2-user-plus/blob/master/docs/TROUBLESHOOTING.MD)
<BR>
[3. Customization instructions](https://github.com/johnitvn/yii2-user-plus/blob/master/docs/CUSTOMIZATION.md)

