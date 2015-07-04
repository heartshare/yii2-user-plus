<?php

use yii\helpers\Html;
use johnitvn\ajaxcrudassets\CrudAsset; 
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel johnitvn\advanceuser\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;

CrudAsset::register($this);

?>
<div class="user-index">
    <div id="ajaxCrudDatatable">
        <?php
                            echo $this->render('_grid', [ 
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);
                        
        ?>
    </div>
</div>

<div id="ajaxCrubModal" class="fade modal" role="dialog" tabindex="-1">
<div class="modal-dialog ">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

</div>
<div class="modal-body">

</div>

</div>
</div>
</div>
