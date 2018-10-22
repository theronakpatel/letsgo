<?php

namespace backend\controllers;

use Yii;
use backend\models\Category;
use backend\models\CategorySearch;
use backend\models\Customer;
use backend\models\Posts;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
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
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->getResponse()->redirect(array('/login'));
        }

        $model = new Category();
        $model->scenario = 'create';
        $model->added_date = date('Y-m-d H:i:s');
        
        if ($model->load(Yii::$app->request->post())) 
        {
            $model->icon = UploadedFile::getInstance($model, 'icon');
            if ($model->validate())
            {       
                    if($model->icon != '')
                    {
                        $icon = $model->icon->baseName . '.' . $model->icon->extension;
                        $model->icon->saveAs(Yii::$app->params['uploadPath'] . 'category/' . $icon);                        
                        $model->icon = $icon;
                    }
                        
            }else
            {
              return $this->render('create', [
                    'model' => $model,
              ]);
            }
            $model->save(false);

            $cat_id = $model->category_id;
            $customerData  =  Customer::find()->asArray()->all();
            foreach ($customerData as $key => $value) {
              $device_type = $value['device_type'];
              $device_token = $value['device_token'];
              $title = 'New category added';
              $param = '';
              $model = new Posts();
              if($device_type == '1'){
                $model->sendAndroidNotification($device_token, $param, $title, 1, $cat_id, '');
              }else{
                $model->sendIosNotification($device_token, $param, $title, 1, $cat_id, '');
              }
            }

            Yii::$app->session->setFlash('success', 'Category Created Successfully');
            return $this->redirect(['index']);        
        } 
        else 
        {
                return $this->render('create', [
                    'model' => $model,
                ]);
        }
    }


    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->getResponse()->redirect(array('/login'));
        }
        
        $model1 = $this->findModel($id);

        $old_data = $this->findModel($id);
        
        $model = $this->findModel($id);
        $model->scenario = 'update';

        if ($model->load(Yii::$app->request->post())) 
        {
            $model->icon = UploadedFile::getInstance($model, 'icon');
            
            if($model->icon != '')
            {
                if($model->icon)
                {
                    if ($model->validate()) 
                    {  
                        if(sizeof($old_data) > 0)
                        {
                            if($old_data->icon != '') 
                            {
                                
                            $oldFile = Yii::$app->params['uploadPath'] .'category/' .$old_data->icon;             
                            if(file_exists($oldFile))
                                unlink($oldFile);
                            }
                            $icon = $model->icon->baseName . '.' . $model->icon->extension;
                            $model->icon->saveAs(Yii::$app->params['uploadPath'] . 'category/' . $icon);                        
                            $model->icon = $icon;
                         }
                    }
                }
            }
            else
            {
                unset($model->icon);
            }
            $model->save(false);
            $cat_id = $model->category_id;
            $customerData  =  Customer::find()->asArray()->all();
            foreach ($customerData as $key => $value) {
              $device_type = $value['device_type'];
              $device_token = $value['device_token'];
              if($device_type == '1'){
                $title = 'New category added';
                $param = '';
                $model = new Posts();
                // $model->sendAndroidNotification($device_token, $param, $title, 1, $cat_id, '');
              }
            }
            Yii::$app->session->setFlash('success', 'Category Updated Successfully');
            return $this->redirect(['index']);
        } else {
            
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
