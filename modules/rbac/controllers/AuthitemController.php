<?php

namespace app\modules\rbac\controllers;

use Yii;
use app\modules\rbac\models\AuthItem;
use app\modules\rbac\models\AuthItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\rbac\models\AuthItemChild;
use yii\web\HttpException;

/**
 * AuthitemController implements the CRUD actions for AuthItem model.
 */
class AuthitemController extends Controller
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
     * Lists all AuthItem models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuthItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AuthItem model.
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
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AuthItem();

        /*if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }*/
        $model->load(Yii::$app->request->post());
        $command = Yii::$app->request->post('commandAction');
        if (isset($command)) {
        	$respond = $model->validate();
        	if ($respond) {
        		$auth = Yii::$app->authManager;
        		switch($model->type) {
        			case '1': {
        				$role = $auth->createRole($model->name);
        				$role->description = $model->description;
        				$auth->add($role);
        				break;
        			}
        			case  '3': {
        				$permission = $auth->createPermission($model->name);
        				$permission->description = $model->description;
        				$auth->add($permission);
        				break;
        			}
        			case '2' : {
        				$parent1 = $auth->createPermission($model->name);
        				$parent1->description = $model->description;
        				$auth->add($parent1);
        				$child1 = $auth->createPermission($model->name.'-Append');
        				$child1->description = $model->description.'-Tambah Data';
        				$auth->add($child1);
        				$auth->addChild($parent1, $child1);
        				$child1 = $auth->createPermission($model->name.'-List');
        				$child1->description = $model->description.'-Lihat Daftar';
        				$auth->add($child1);
        				$auth->addChild($parent1, $child1);
        				$child1 = $auth->createPermission($model->name.'-Delete');
        				$child1->description = $model->description.'-Hapus Data';	
        				$auth->add($child1);
        				$auth->addChild($parent1, $child1);
        				$child1 = $auth->createPermission($model->name.'-Update');
        				$child1->description = $model->description.'-Ubah Data';
        				$auth->add($child1);
        				$auth->addChild($parent1, $child1);
        				break;
        			}
        		} 
        		return $this->redirect(['view', 'id' => $model->name]);
        	} else {
        		throw new HttpException(400, serialize($model->errors ));
        	}
        } else {
        	return $this->render('create', [
        			'model' => $model,
        	]);
        }
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AuthItem model.
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
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionAddchild($idparent)
    {
    	$model = new AuthItemChild();
    	$model->parent = $idparent;
    	$command = Yii::$app->request->post('commandAction');
    	if (isset($command)) {
    		$model->load(Yii::$app->request->post());
    		$respond = $model->validate();
    		if ($respond) {
    			$auth = Yii::$app->authManager;
    			$parent = $auth->getRole($model->parent);
    			if (is_null($parent))
    				$parent = $auth->getPermission($model->parent);
    			$child = $auth->getRole($model->child);
    			if (is_null($child))
    				$child = $auth->getPermission($model->child);
    			$auth->addChild($parent, $child);
   
    			return $this->redirect(['view', 'id'=>$idparent]);
    		} else 
				throw new HttpException('400', serialize($model->errors));    		
    	} else {
    		return $this->render('addchild',['model'=>$model]);
    	}
    }
}
