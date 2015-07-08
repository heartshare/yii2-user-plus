<?php
use yii\helpers\Url;
use yii\widgets\Pjax;
use johnitvn\ajaxcrud\GridView;
use yii\helpers\Html;
use johnitvn\userplus\controllers\ManagerController; 
use yii\jui\DatePicker;
use johnitvn\userplus\models\User;

/* @var $this yii\web\View */
/* @var $searchModel johnitvn\userplus\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


?>


<?php

/**
* Grid toolbar config
*/
$createActionButton = Html::a('<i class="glyphicon glyphicon-plus"></i>',['create'],['data-modal-title'=>'Create new User','class'=>'create-action-button btn btn-default']);
$refreshActionButton = Html::a('<i class="glyphicon glyphicon-repeat"></i>',['index'],['data-pjax'=>1,'class'=>'btn btn-default']);
$fullScreenActionButton = Html::a('<i class="glyphicon glyphicon-resize-full"></i>','#',['class'=>'btn-toggle-fullscreen btn btn-default']);
$bulkDeleteButton = Html::a('<i class="glyphicon glyphicon-trash"></i>&nbsp; Delete All Selected',
                                 ["bulk-delete"] ,
                                 [
                                     "class"=>"btn-bulk-delete btn btn-danger",
                                     "data-method"=>"post",
                                     "title"=>"Delete All Selected",
                                     "data-confirm-message"=>"Are you sure to delete all this items?"
                                 ]);


/**
* Grid column config
*/
$gridColumns = [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id',
        'width' => '40px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'login',
    ],        
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'created_at',
        'value'=>function($model){
            return date('d/m/Y', $model->created_at);
        },
        'filter' => DatePicker::widget([
            'model'      => $searchModel,
            'attribute'  => 'created_at',
            'dateFormat' => 'php:Y-m-d',
            'options' => [
                'class' => 'form-control',
            ],
        ]),
    ],          
    [
        'class'=>'\kartik\grid\DataColumn',
        'width' => '50px',
        'attribute'=>'status',
         'value' => function ($model) {
                if ($model->status==User::STATUS_BLOCKED) {
                    return Html::a(Yii::t('user', 'Unblock'), ['toggle-block', 'id' => $model->id], [
                        'class' => 'btn btn-toggle btn-xs btn-success btn-block',
                        'data-method' => 'post',
                        'data-confirm-message' => Yii::t('user', 'Are you sure you want to unblock this user?'),
                    ]);
                } else {
                    return Html::a(Yii::t('user', 'Block'), ['toggle-block', 'id' => $model->id], [
                        'class' => 'btn btn-toggle btn-xs btn-danger btn-block',
                        'data-method' => 'post',
                        'data-confirm-message' => Yii::t('user', 'Are you sure you want to block this user?'),
                    ]);
                }
            },
            'format' => 'raw',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'width' => '100px',
        'attribute'=>'superuser',
         'value' => function ($model) {
                if ($model->superuser==User::IS_NOT_SUPER_USER) {
                    return Html::a(Yii::t('user', 'Set SU'), ['toggle-superuser', 'id' => $model->id], [
                        'class' => 'btn btn-toggle btn-xs btn-success btn-block',
                        'data-method' => 'post',
                        'data-confirm-message' => Yii::t('user', 'Are you sure you want to set superuser permistion to this user?'),
                    ]);
                } else {
                    return Html::a(Yii::t('user', 'Remove SU'), ['toggle-superuser', 'id' => $model->id], [
                        'class' => 'btn btn-xs btn-danger btn-block',
                        'data-method' => 'post',
                        'data-confirm-message' => Yii::t('user', 'Are you sure you want to disable superuser permistion of this user?'),
                    ]);
                }
            },
            'format' => 'raw',
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['class'=>'view-action-button','title'=>'View', 'data-toggle'=>'tooltip','data-modal-title'=>'View User'],
        'updateOptions'=>['class'=>'update-action-button','title'=>'Update', 'data-toggle'=>'tooltip','data-modal-title'=>'Update User'],
        'deleteOptions'=>['class'=>'delete-action-button','title'=>'Delete', 'data-toggle'=>'tooltip','data-confirm-message'=>'Are you sure to delete this item?'], 
    ],

];   

echo GridView::widget([
    'id'=>'crud-datatable',
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => $gridColumns,
    'toolbar' =>  [['content'=> $createActionButton.$refreshActionButton.$fullScreenActionButton.'{toogleDataNoContainer}'],'{export}'],
    'bordered' => true,
    'striped' => true,
    'condensed' => true,
    'responsive' =>true,
    'responsiveWrap' => false,
    'hover' => false,
    'showPageSummary' => false,        
    'panel' => [
        'type' => 'primary', 
        'heading' => '<i class="glyphicon glyphicon-list"></i>  User listing',
        'before' => '<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',
        'after' =>  '<div class="pull-left"></div><div class="pull-right">'.$bulkDeleteButton.'</div><div class="clearfix"></div>',
        ],    

]);

?>

   
  
