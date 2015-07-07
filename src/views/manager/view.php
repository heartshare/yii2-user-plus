<?php

use yii\widgets\DetailView;
use johnitvn\userplus\models\User;

/* @var $this yii\web\View */
/* @var $model johnitvn\userplus\models\User */
?>
<div class="user-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'email',
            [
                'label'  => User::attributeLabels()['creator'],
                'value'  => $model->creator==User::CREATOR_BY_REGISTER?'Register':User::findOne(1)->email,                  
            ],
            'creator_ip',
            [
                'label'  => User::attributeLabels()['status'],
                'value'  => '<span class="btn btn-xs btn-'.($model->status==User::STATUS_ACTIVED?'success">Actived':'danger">Blocked').'</span>',
                'format' => ['html'],
            ],
            [
                'label'  => User::attributeLabels()['confirmed_at'],
                'value'  => '<span class="btn btn-xs btn-'.($model->confirmed_at==null?'danger">Not confirmed':'success">Confirmed').'</span>',
                'format' => ['html'],
            ],
            [
                'label'  => User::attributeLabels()['created_at'],
                'value'  => Yii::t('user','{date}, {time}', ['date'=>date('H:i',$model->created_at),'time'=>date('m/d/Y',$model->created_at)]),
            ],
            [
                'label'  => User::attributeLabels()['updated_at'],
                'value'  =>  $model->updated_at==null?"Never":date('H:i',$model->updated_at).',ngày '.date('m/d/Y',$model->updated_at),
            ],
        ],
    ]) ?>

</div>
