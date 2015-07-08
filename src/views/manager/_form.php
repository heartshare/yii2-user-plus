<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model johnitvn\userplus\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">


    <?php $form = ActiveForm::begin(); ?>
<?php if($model->isNewRecord){ ?>
    <?= $form->field($model, 'login')->textInput(['maxlength' => true]) ?>
<?php }else{ ?>
	<?= $form->field($model, 'login')->textInput(['maxlength' => true,'disabled'=> true]) ?>
<?php } ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'confirm_password')->passwordInput(['maxlength' => true]) ?>

  
<?php if (!Yii::$app->request->isAjax){ ?>
  	<div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
<?php } ?>

    <?php ActiveForm::end(); ?>
</div>
