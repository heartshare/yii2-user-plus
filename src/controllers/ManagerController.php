<?php

namespace johnitvn\userplus\controllers;

use Yii;
use johnitvn\userplus\models\User;
use johnitvn\userplus\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\grid\GridView;
use \yii\web\Response;
use yii\web\ForbiddenHttpException;
use yii\web\UnauthorizedHttpException;
use yii\helpers\Html;


/**
 * ManagerController implements the CRUD actions for User model.
 */
class ManagerController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'bulk-delete' => ['post'],
                ],
            ],
        ];
    }

    public function beforeAction($action){
        if(!parent::beforeAction($action)){
            return false;
        }else{
            if(Yii::$app->user->isGuest){
                throw new UnauthorizedHttpException('You are not loged in!');
            }else if(!Yii::$app->user->identity->isSuperuser()){
                throw new ForbiddenHttpException('Only superuser have permistion to access!');
            }
            return true;
        }
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {    
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $request = Yii::$app->request;
        if($request->isAjax){
            Yii::$app->response->format = Response::FORMAT_JSON;
            return [
                    'code'=>'200',
                    'message'=>'OK',
                    'data'=>$this->renderPartial('view', [
                        'model' => $this->findModel($id),
                    ])
                ];    
        }else{
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }
    }

    /**
     * Creates a new User model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $currentUserId = Yii::$app->user->identity->getId(); 
        $model = Yii::createObject([
            'class'    => User::className(),           
            'scenario' => 'create',
        ]);

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'code'=>'200',
                    'message'=>'OK',
                    'data'=>$this->renderPartial('create', [
                        'model' => $model,
                    ]),
                ];         
            }else if($model->load($request->post()) && $model->create($currentUserId)){
                return [
                    'code'=>'200',
                    'message'=>'Create User success',
                ];
            }else{        
                var_export($model);
                die();        
                return [
                    'code'=>'400',
                    'message'=>'Validate error',
                    'data'=>$this->renderPartial('create', [
                        'model' => $model,
                    ]),
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
        }
       
    }

    /**
     * Updates an existing User model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $request = Yii::$app->request;
        $model = $this->findModel($id);       
        $model->scenario = 'update';

        if($request->isAjax){
            /*
            *   Process for ajax request
            */
            Yii::$app->response->format = Response::FORMAT_JSON;
            if($request->isGet){
                return [
                    'code'=>'200',
                    'message'=>'OK',
                    'data'=>$this->renderPartial('update', [
                        'model' => $model,
                    ]),
                ];         
            }else if($model->load($request->post()) && $model->save()){
                return [
                    'code'=>'200',
                    'message'=>'Update User success',
                ];
            }else{
                return [
                    'code'=>'400',
                    'message'=>'Validate error',
                    'data'=>$this->renderPartial('update', [
                        'model' => $model,
                    ]),
                ];         
            }
        }else{
            /*
            *   Process for non-ajax request
            */
            if ($model->load($request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }
    }

    /**
     * Delete an existing User model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
    }

     /**
     * Delete multiple existing User model.
     * For ajax request will return json object
     * and for non-ajax request if deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBulkDelete()
    {        
        $request = Yii::$app->request;
        $pks = $request->post('pks'); // Array or selected records primary keys
        foreach (User::findAll(json_decode($pks)) as $model) {
            $model->delete();
        }
    }


    public function actionToggleBlock($id){

        $model = $this->findModel($id);
        $model->scenario = 'toggle-block';

        if($model!=null && $model->toggleBlock()){
            if ($model->status==User::STATUS_BLOCKED) {
                echo Html::a(Yii::t('user', 'Unblock'), ['block', 'id' => $model->id], [
                    'class' => 'btn btn-toggle btn-xs btn-success btn-block',
                    'data-method' => 'post',
                    'data-confirm-message' => Yii::t('user', 'Are you sure you want to unblock this user?'),
                ]);
            } else {
                echo Html::a(Yii::t('user', 'Block'), ['block', 'id' => $model->id], [
                    'class' => 'btn btn-toggle btn-xs btn-danger btn-block',
                    'data-method' => 'post',
                    'data-confirm-message' => Yii::t('user', 'Are you sure you want to block this user?'),
                ]);
            }
            return;
        }else{
            Yii::$app->response->setStatusCode(400,"Can't block this user");
            return;
        }
    }



    public function actionToggleSuperuser($id){
        $model = $this->findModel($id);
        $model->scenario = 'toggle-superuser';

        if($model!=null && $model->toggleSuperuser()){
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
            return;
        }else{
            Yii::$app->response->setStatusCode(400,"Can't block this user");
            return;
        }
    }



    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
