<?php

namespace backend\controllers;

use Yii;
use backend\models\Posts;
use backend\models\PostsSearch;
use backend\models\Category;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * PostsController implements the CRUD actions for Posts model.
 */
class PostsController extends Controller
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
     * Lists all Posts models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Posts model.
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
     * Creates a new Posts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Posts();
        $categories = Category::find()->asArray()->all();
        $categories = ArrayHelper::map($categories, 'category_id', 'name');
        $model->scenario = 'create';
        $model->added_date = date('Y-m-d H:i:s');
        if ($model->load(Yii::$app->request->post())) {

            $model->image = UploadedFile::getInstance($model, 'image');
            if ($model->validate())
            {       
                    if($model->image != '')
                    {
                        $image = $model->image->baseName . '.' . $model->image->extension;
                        $model->image->saveAs(Yii::$app->params['uploadPath'] . 'posts/' . $image);                        
                        $model->image = $image;
                    }
                        
            }else
            {
              return $this->render('create', [
                    'model' => $model,
              ]);
            }
            $model->save(false);
            Yii::$app->session->setFlash('success', 'Post Created Successfully');
            return $this->redirect(['index']);

        } else {
            return $this->render('create', [
                'model' => $model,
                'categories' => $categories,
            ]);
        }
    }

    /**
     * Updates an existing Posts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $old_data = $this->findModel($id);
        $categories = Category::find()->asArray()->all();
        $categories = ArrayHelper::map($categories, 'category_id', 'name');
        $model->scenario = 'update';
        if ($model->load(Yii::$app->request->post()) ) {
            $model->image = UploadedFile::getInstance($model, 'image');
            
            if($model->image != '')
            {
                if($model->image)
                {
                    if ($model->validate()) 
                    {  
                        if(sizeof($old_data) > 0)
                        {
                            if($old_data->image != '') 
                            {
                                
                            $oldFile = Yii::$app->params['uploadPath'] .'posts/' .$old_data->image;             
                            if(file_exists($oldFile))
                                unlink($oldFile);
                            }
                            $image = $model->image->baseName . '.' . $model->image->extension;
                            $model->image->saveAs(Yii::$app->params['uploadPath'] . 'posts/' . $image);                        
                            $model->image = $image;
                         }
                    }
                }
            }
            else
            {
                unset($model->image);
            }
            $model->save(false);
        
            Yii::$app->session->setFlash('success', 'Post Updated Successfully');
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'categories' => $categories,
            ]);
        }
    }

    /**
     * Deletes an existing Posts model.
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
     * Finds the Posts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Posts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Posts::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
