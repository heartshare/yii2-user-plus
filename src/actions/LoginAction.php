<?php
namespace johnitvn\advanceuser\actions;

use Yii;
use yii\base\Action; 
use johnitvn\advanceuser\models\LoginForm;
use yii\web\MethodNotAllowedHttpException; 
use johnitvn\advanceuser\traits\AjaxValidationTrait;

/**
* @author John Martin <john.itvn@gmail.com>
*/
class LoginAction extends Action{

	use AjaxValidationTrait;

	/**
	* @var string callback will be call when login success
	*/
	public $successCallback;

		
	/**
    * @var string view will be render when to register
    */
	public $view;

	/**
	* @var johnitvn\advanceuser\models\LoginForm form model for validate
	*/
	public $form = 'johnitvn\advanceuser\models\LoginForm';

  
	/** @inheritdoc */	
	public function init(){
		if($this->successCallback==null){
			// Set default success callback
			$this->successCallback = function($action){
				return $action->controller->goBack();
			};
		}	
	}

	/**
    * Runs the action
    *
    * @return string result content
    */
	public function run(){
		
		/** @var LoginForm $model */
		$model = Yii::createObject($this->form);

		$this->performAjaxValidation($model);

		if ($model->load(Yii::$app->request->post()) && $model->login()) {          
			return call_user_func($this->successCallback,$this,$model);
		}else{       
			return $this->controller->render($this->view, [                
				'model'  => $model,
			]);
		}    	
	}

}