<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model johnitvn\userplus\models\User */
?>
<div class="user-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'login',
            'password_hash',
            'auth_key',
            'status',
            'superuser',
            'creator',
            'creator_ip',
            'confirm_token',
            'resetpaswd_token',
            'confirmed_at',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
