# Guilde for configuation

###1. Remember me function
If you want to enable remeber me function. Let add below line to you config
```php
'components' => [
    'user' => [
        'enableAutoLogin' => true,
    ],  
],
'modules' => [
    'user' => [
    	'class' => 'johnitvn\userplus\Module'
        'rememberFor' => 3600*24*2,
    ],
],
```

Default the rember for is 3600*24*2. It's mean account will be auto login whithin 2 days 


###2. Register function
If you want to enable register function. Let add below line to you config

````php
'modules' => [
    'user' => [
    	'class' => 'johnitvn\userplus\Module'
        'enableRegister' => true,
    ],
],
````

###3. Disable security handler function
The default security handler is on. So you can acccess to route `user/security/*`. Maybe you wan't to disable security handler for customize see [Customization instructions](https://github.com/johnitvn/yii2-user-plus/blob/master/docs/CUSTOMIZATION.md). Let add below line to your config

````php
'modules' => [
    'user' => [
    	'class' => 'johnitvn\userplus\Module'
        'enableSecurityHandler' => false,
    ],
],
````