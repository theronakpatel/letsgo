<?php

namespace backend\controllers;

use Yii;
use backend\models\Posts;
use backend\models\PostsSearch;
use backend\models\Category;
use backend\models\PostImages;
use backend\models\Customer;
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
            // $model->image = UploadedFile::getInstance($model, 'image');
            $model->files = UploadedFile::getInstances($model, 'files');
            if ($model->validate())
            {

                $model->save(false);
                if ($model->files && $model->validate()) {
                    foreach ($model->files as $file) {
                        $postimage = new PostImages();
                        $postimage->post_id = $model->post_id;
                        $image =  $model->post_id.'_'. rand() . time() . '.' . $file->extension;
                        $postimage->image = $image;
                        $postimage->added_date = date('Y-m-d H:i:s');
                        if ($postimage->save()) {
                            $file->saveAs(Yii::$app->params['uploadPath'] . 'posts/' . $image);
                        }
                    }
                }                        
            }else
            {
              return $this->render('create', [
                    'model' => $model,
              ]);
            }
            $post_id = $model->post_id;
            $cat_id = $model->category_id;
            $customerData  =  Customer::find()->asArray()->all();
            foreach ($customerData as $key => $value) {
              $device_type = $value['device_type'];
              $device_token = $value['device_token'];
                $title = 'New Post added';
                $param = '';
                if($device_type == '1'){
                  $model->sendAndroidNotification($device_token, $param, $title, 2, $cat_id, $post_id);
                }else{
                  $model->sendIosNotification($device_token, $param, $title, 2, $cat_id, $post_id);
                }
            }
            
            Yii::$app->session->setFlash('success', 'Post Created Successfully');
            return $this->redirect(['index']);

        } else {
            return $this->render('create', [
                'model' => $model,
                'categories' => $categories,
                'multipleImages' => array()
            ]);
        }
    }

    public function actionTest()
    {
                $model = new Posts();
                $title = 'New Post added';
                $param = '';
                $device_token = 'emY5r0hoVmE:APA91bH1gXacF1gvfTcJQz2nVk0dYVYyzPqAWRhWSbdguCTveBmLN_ZSi05LjJVMqLyHfGMA2UF0iV3NewFdtWNm-bzbOe48XqxAdy8mtwibwRFyzwqlGGfBcw2qLjU6-ea7CW3vT9qJ';
                $model->sendAndroidNotification($device_token, $param, $title);
    }
    /**
     * Updates an existing Posts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $multipleImages = PostImages::find()->where(['post_id' => $id])->asArray()->all();
        $model = $this->findModel($id);
        $old_data = $this->findModel($id);
        $categories = Category::find()->asArray()->all();
        $categories = ArrayHelper::map($categories, 'category_id', 'name');
        $model->scenario = 'update';
        if ($model->load(Yii::$app->request->post()) ) {
            $model->files = UploadedFile::getInstances($model, 'files');
        
            if ($model->validate()) 
            {  
                if ($model->files && $model->validate()) {
                    foreach ($model->files as $file) {
                        $postimage = new PostImages();
                        $postimage->post_id = $model->post_id;
                        $image =  $model->post_id.'_'.rand() . time() . '.' . $file->extension;
                        $postimage->image = $image;
                        $postimage->added_date = date('Y-m-d H:i:s');
                        if ($postimage->save()) {
                            // $image = $file->baseName . '.' . $file->extension;
                            $file->saveAs(Yii::$app->params['uploadPath'] . 'posts/' . $image);
                        }
                    }
                }
            }
         
            $model->save(false);
            
            $post_id = $model->post_id;
            $cat_id = $model->category_id;
            $customerData  =  Customer::find()->asArray()->all();
            foreach ($customerData as $key => $value) {
              $device_type = $value['device_type'];
              $device_token = $value['device_token'];
              if($device_type == '1'){
                $title = 'New Post added';
                $param = '';

                // $model->sendAndroidNotification($device_token, $param, $title, 2, $cat_id, $post_id);
              }
            }

            Yii::$app->session->setFlash('success', 'Post Updated Successfully');
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'categories' => $categories,
                'multipleImages' => $multipleImages
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
        Yii::$app->session->setFlash('success', 'Post deleted Successfully');
    }/**
     * Deletes an existing Posts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeleteimage($id)
    {
        $postimagedata = PostImages::findOne(['post_image_id' => $id]);
        $post_id = $postimagedata->post_id;
        $image = $postimagedata->image;
        
        $path = Yii::$app->params['uploadPath'] . 'posts/' . $image;
        if(file_exists($path)){
            unlink($path);
        }

        PostImages::deleteAll(['post_image_id' => $id]);
        Yii::$app->session->setFlash('success', 'Image deleted Successfully');
        return $this->redirect(['update?id='.$post_id]);
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
