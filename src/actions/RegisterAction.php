<?php
namespace johnitvn\advanceuser\actions;

use Yii;
use yii\base\Action; 
use johnitvn\advanceuser\models\RegistrationForm;
use yii\web\MethodNotAllowedHttpException; 
use johnitvn\advanceuser\traits\AjaxValidationTrait;

class RegisterAction extends Action{

    use AjaxValidationTrait;

	/**
    * @var string url will be redirect to when register success
    */
	public $successUrl;
		
	/**
    * @var string view will be render when to register
    */
	public $view;

	/**
     * Runs the action
     *
     * @return string result content
     */
    public function run(){
		/** @var RegistrationForm $model */
		$model = Yii::createObject(RegistrationForm::className());

    	$this->performAjaxValidation($model);       
    	if ($model->load(Yii::$app->request->post()) && $model->register()) {          
	        return $this->controller->redirect($this->successUrl);
    	}else{       
    		return $this->controller->render($this->registerView, [                
	            'model'  => $model,
	        ]);
    	}
    }

}