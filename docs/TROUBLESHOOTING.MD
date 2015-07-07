#Some guide to troubleshoot

#### 1. User::identityClass must be set.
````$
Invalid Configuration – yii\base\InvalidConfigException
User::identityClass must be set.
````

When application throw this error. It's mean you didn't config user component. Make sure you have this in config file
'components' => [
    'user' => [
        'identityClass' => 'johnitvn\userplus\models\User',
    ],
],


