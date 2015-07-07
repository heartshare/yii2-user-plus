# Guilde for configuation

###1. Remember me function
If you want to enable remeber me funtion. Let add below line to you config
```php
'components' => [
    'user' => [
        'enableAutoLogin' => true,
    ],  
],
'modules' => [
    'user' => [
        'rememberFor' => 3600*24*2,
    ],
],
```

Default the rember for is 3600*24*2. It's mean account will be auto login whithin 2 days 