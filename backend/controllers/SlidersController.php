<?php

namespace backend\controllers;

use Yii;
use backend\models\Sliders;
use backend\models\SlidersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * SlidersController implements the CRUD actions for Sliders model.
 */
class SlidersController extends Controller
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
     * Lists all Sliders models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SlidersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Sliders model.
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
     * Creates a new Sliders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->getResponse()->redirect(array('/login'));
        }

        $model = new Sliders();
        $model->scenario = 'create';
        $model->added_date = date('Y-m-d H:i:s');
        
        if ($model->load(Yii::$app->request->post())) 
        {
            $model->image = UploadedFile::getInstance($model, 'image');
            if ($model->validate())
            {       
                    if($model->image != '')
                    {
                        $image = $model->image->baseName . '.' . $model->image->extension;
                        $model->image->saveAs(Yii::$app->params['uploadPath'] . 'sliders/' . $image);                        
                        $model->image = $image;
                    }
                        
            }else
            {
              return $this->render('create', [
                    'model' => $model,
              ]);
            }
            $model->save(false);
            Yii::$app->session->setFlash('success', 'Slider Created Successfully');
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
     * Updates an existing Sliders model.
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
                                
                            $oldFile = Yii::$app->params['uploadPath'] .'sliders/' .$old_data->image;             
                            if(file_exists($oldFile))
                                unlink($oldFile);
                            }
                            $image = $model->image->baseName . '.' . $model->image->extension;
                            $model->image->saveAs(Yii::$app->params['uploadPath'] . 'sliders/' . $image);                        
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
        
            Yii::$app->session->setFlash('success', 'Slider Updated Successfully');
            return $this->redirect(['index']);
        } else {
            
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Sliders model.
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
     * Finds the Sliders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sliders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sliders::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
