#Some guide to troubleshoot

#### 1. User::identityClass must be set.
````php
Invalid Configuration – yii\base\InvalidConfigException
User::identityClass must be set.
````

When application throw this error. It's mean you didn't config user component. Make sure you have this in config file
'components' => [
    'user' => [
        'identityClass' => 'johnitvn\userplus\models\User',
    ],
],

#### 2. Exception 'yii\db\Exception' with message 'SQLSTATE[HY000] [1049]
````bash
Exception 'yii\db\Exception' with message 'SQLSTATE[HY000] [1049] Unknown database '<xxxxxx>''
````

When application throw this error both console or web application. It's mean you are config wrong database. Check it again 


