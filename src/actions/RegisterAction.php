<?php
namespace johnitvn\userplus\actions;

use Yii;
use yii\base\Action; 
use yii\base\InvalidConfigException;
use johnitvn\userplus\models\RegistrationForm;
use johnitvn\userplus\traits\AjaxValidationTrait;
use johnitvn\userplus\base\BaseRegistrationForm;

/**
* @author John Martin <john.itvn@gmail.com>
*/
class RegisterAction extends Action{

  	use AjaxValidationTrait;

	/**
	* @var string callback will be call when login success
	*/
	public $successCallback;
 
		
	/**
     * @var string the view file to be rendered. If not set, it will take the value of [[id]].
     * That means, if you name the action as "error" in "SiteController", then the view name
     * would be "error", and the corresponding view file would be "views/site/error.php".
     */
	public $view;

	/**
	* @var johnitvn\userplus\models\RegistrationForm form model for validate
	*/
	public $form = 'johnitvn\userplus\models\RegistrationForm';

	/** @inheritdoc */	
	public function init(){
		if($this->successCallback==null){
			// Set default success callback
			$this->successCallback = function($action){
				return $this->controller->goHome();
			};
		}
		$this->form = Yii::createObject($this->form); 
		if(!($this->form instanceof BaseRegistrationForm)){
			throw new InvalidConfigException('LoginAction::$form must be instanceof johnitvn\userplus\base\BaseLoginForm');
		}

	}

	/**
	* Runs the action
	*
	* @return string result content
	*/
	public function run(){
		// Create form model
		$model = $this->form;

		$this->performAjaxValidation($model);     

		if ($model->load(Yii::$app->request->post()) && $model->register()) {          
			return call_user_func($this->successCallback,$this,$model);
		}else{       
			return $this->controller->render($this->view==null?$this->id:$this->view, [                
				'model'  => $model,
			]);
		}
	}

}