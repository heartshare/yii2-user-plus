<?php

namespace johnitvn\advanceuser\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use \yii\web\Response;

/**
 * SecurityController implements the CRUD actions for User model.
 */
class SecurityTestController extends Controller
{


	public function actions(){
		return [
			'register'=>[
				'class'=>'johnitvn\advanceuser\actions\RegisterAction',			
				'view'=>'@vendor/johnitvn/yii2-advance-user/src/views/security-test/register',
				'successCallback'=>function($model){
					$this->goHome();
				},
			],
			'login'=>[
				'class'=>'johnitvn\advanceuser\actions\LoginAction',
				'view'=>'@vendor/johnitvn/yii2-advance-user/src/views/security-test/login',
				'successCallback'=>function($model){
					$this->goBack();
				},
			],
			'logout'=>[
				'class'=>'johnitvn\advanceuser\actions\LogoutAction',
				'successCallback'=>function($model){
					$this->goHome();
				},
			]
		];
	}

}