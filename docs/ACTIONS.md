# Understanding about actions

Let open the SiteController.php you can see it contain bellow function

````php
	public function actions(){
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
````

That 's ....


### 4. Add action into controller
Yii2-advance-user don't force you use module's controller. I just define the action need for do your user follow of your application. You can use any controller as you want. Example i will use SiteController as demo site after we create yii Project. I will add [LoginAction](https://github.com/johnitvn/yii2-advance-user/blob/master/src/actions/LoginAction.php),[LogoutAction](https://github.com/johnitvn/yii2-advance-user/blob/master/src/actions/LogoutAction.php),[RegisterAction](https://github.com/johnitvn/yii2-advance-user/blob/master/src/actions/RegisterAction.php) into actions of SiteController

````php
	public function actions(){
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],           
            'logout' => [
                'class' => 'johnitvn/advanceuser/LogoutAction',                                
            ],
             'login' => [
                'class' => 'johnitvn/advanceuser/LoginAction',
            ],
            'register' => [
                'class' => 'johnitvn/advanceuser/RegisterAction',
            ],
        ];
    }
````

### 5. Add views
Default action will take the view of controller with id. Example you add LoginAction in SiteController it will take views/site/login.php. 