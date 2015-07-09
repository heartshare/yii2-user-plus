<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\jui\DatePicker;
use johnitvn\userplus\models\User;

return [
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
                        'class' => 'btn btn-xs btn-default btn-block',
                        'role'=>'modal-remote',
                        'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                        'data-request-method'=>'post',
                        'data-confirm-title'=>Yii::t('user', 'Are you sure?'),
                        'data-confirm-message' => Yii::t('user', 'Are you sure you want to unblock this user?'),
                    ]);
                } else {
                    return Html::a(Yii::t('user', 'Block'), ['toggle-block', 'id' => $model->id], [
                       'class' => 'btn btn-xs btn-default btn-block',
                        'role'=>'modal-remote',
                        'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                        'data-request-method'=>'post',
                        'data-confirm-title'=>Yii::t('user', 'Are you sure?'),
                        'data-confirm-message' => Yii::t('user', 'Are you sure you want to unblock this user?'),
                    ]);
                }
        },
        'format' => 'raw',
        'filter' => [null=>'All',User::STATUS_BLOCKED=>'Blocked',User::STATUS_ACTIVED=>'Unblocked'],
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'width' => '100px',
        'attribute'=>'superuser',
        'value' => function ($model) {
                if ($model->superuser==User::IS_NOT_SUPER_USER) {
                    return Html::a(Yii::t('user', 'Set SU'), ['toggle-superuser', 'id' => $model->id], [
                        'class' => 'btn btn-xs btn-default btn-block',
                        'role'=>'modal-remote',
                        'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                        'data-request-method'=>'post',
                        'data-confirm-title'=>Yii::t('user', 'Are you sure?'),
                        'data-confirm-message' => Yii::t('user', 'Are you sure you want to unblock this user?'),
                    ]);
                } else {
                    return Html::a(Yii::t('user', 'Remove SU'), ['toggle-superuser', 'id' => $model->id], [
                        'class' => 'btn btn-xs btn-default btn-block',
                        'role'=>'modal-remote',
                        'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                        'data-request-method'=>'post',
                        'data-confirm-title'=>Yii::t('user', 'Are you sure?'),
                        'data-confirm-message' => Yii::t('user', 'Are you sure you want to unblock this user?'),
                    ]);
                }
            },
        'format' => 'raw',
        'filter' => [User::IS_NOT_SUPER_USER=>'Not Superuser',User::IS_SUPER_USER=>'IS Superuser'],
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'], 
    ],

];   