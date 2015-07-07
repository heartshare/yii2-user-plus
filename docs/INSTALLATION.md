# Getting started with Yii2-user-plus

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

Add following lines to your main configuration file:

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

### 3. Update database schema

>Make sure that you have properly configured `db` application component

Run the following command:

```bash
$ php yii migrate/up --migrationPath=@vendor/johnitvn/yii2-user-plus/src/migrations

```

### 4. Add action into controller

Yii2-user-plus have 3 Actions:
+ [LoginAction](https://github.com/johnitvn/yii2-user-plus/blob/master/src/actions/LoginAction.php)
+ [LogoutAction](https://github.com/johnitvn/yii2-user-plus/blob/master/src/actions/LogoutAction.php)
+ [RegisterAction](https://github.com/johnitvn/yii2-user-plus/blob/master/src/actions/RegisterAction.php)

We not create controller for flexible in extensible. Don't force you use module's controller. You can use any controller as you want. 

Now let's add action into controller. Let override <b>actions()</b> in your controller.

````php
	public function actions(){
        return [               
            'logout' => [
                'class' => 'johnitvn/userplus/LogoutAction',                                
            ],
            'login' => [
                'class' => 'johnitvn/userplus/LoginAction',
            ],
            'register' => [
                'class' => 'johnitvn/userplus/RegisterAction',
            ],
        ];
    }
````
Now we can access to login action with <ControllerID>/login. Example you add actions into SiteController
So you can access site/login, site/logout,site/register to run your action

### 5. Add views

As the default contruct of yii. If you add actions into SiteController, you must create view in app/views/site
Just <b>Login Action</b> and <b>Register Action</b> need a view. 

The example of login view:

````php
 <?php $form = ActiveForm::begin([
                    'id'                     => 'login-form',
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => false,
                    'validateOnBlur'         => false,
                    'validateOnType'         => false,
                    'validateOnChange'       => false,
                ]) ?>

<?= $form->field($model, 'email', ['inputOptions' => [ 'class' => 'form-control']]) ?>

<?= $form->field($model, 'password', ['inputOptions' => ['class' => 'form-control', ]])->passwordInput()->label('Password')?> 

<?= Html::submitButton('Sign in'), ['class' => 'btn btn-primary btn-block']) ?>

<?php ActiveForm::end(); ?>
````
The example of register view:


````php
 <?php $form = ActiveForm::begin([
                    'id'                     => 'register-form',
                    'enableAjaxValidation'   => true,
                    'enableClientValidation' => false,
                    'validateOnBlur'         => false,
                    'validateOnType'         => false,
                    'validateOnChange'       => false,
                ]) ?>

<?= $form->field($model, 'email', ['inputOptions' => [ 'class' => 'form-control']]) ?>



<?= $form->field($model, 'password', ['inputOptions' => ['class' => 'form-control', ]])->passwordInput()->label('Password')?> 

<?= $form->field($model, 'confirm_password', ['inputOptions' => ['class' => 'form-control', ]])->passwordInput()->label('Confirm Password')?> 

<?= Html::submitButton('Register'), ['class' => 'btn btn-primary btn-block']) ?>

<?php ActiveForm::end(); ?>
````

> The important thing is: make sure we have the email, password fields in login views form and email, password, confirm_password fields in register form
