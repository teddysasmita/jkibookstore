<?php

namespace app\modules\rbac\controllers;

use Yii;
use app\modules\rbac\models\Users;
use app\modules\rbac\models\UsersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\HttpException;
use app\modules\rbac\models\AuthAssignment;

/**
 * UsersController implements the CRUD actions for Users model.
 */
class UsersController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Users models.
     * @return mixed
     */
    public function actionIndex()
    {
    	if ( ! \Yii::$app->user->isGuest) {
	        $searchModel = new UsersSearch();
	        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
	        
	        return $this->render('index', [
	            'searchModel' => $searchModel,
	            'dataProvider' => $dataProvider,
	        ]); 
    	} else {
    		throw new HttpException('401', 'You are not authorized');
    	}
    }

    /**
     * Displays a single Users model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Users model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Users();
        $model->load(Yii::$app->request->post());
        $command = Yii::$app->request->post('commandAction');
        
        if (isset($command)) {
 			$respond = $model->save();
        	if ( $respond ) 
            	return $this->redirect(['view', 'id' => $model->id]);
        	else if ( $respond == FALSE)
        		throw new HttpException(400, serialize($model->errors ));
        } else
         	return $this->render('create', [
                'model' => $model,
            ]);
    }

    /**
     * Updates an existing Users model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Users model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Users model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Users the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Users::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionAddrole($id)
    {	
    	$model = new AuthAssignment();
    	
    	$model->user_id = $id;
    	$command = Yii::$app->request->post('addroleAction');
    	
    	if (isset($command)) {
    		$model->load(Yii::$app->request->post());
    		$respond = $model->validate();
    		if ( $respond ) {
            	$auth = Yii::$app->authManager;
            	$role = $auth->getRole($model->item_name);
            	$auth->assign($role, $id);

    			return $this->redirect(['view', 'id' => $id]);
    		} else if ( $respond == FALSE)
        		throw new HttpException(400, serialize($model->errors ));	
    	} else
    		return $this->render('addrole', [
    			'id' => $id, 'model' => $model
    	]);
    }
}
