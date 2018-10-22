<?php

namespace backend\controllers;

use Yii;
use backend\models\MerchPromotion;
use backend\models\MerchPromotionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * MerchPromotionController implements the CRUD actions for MerchPromotion model.
 */
class MerchPromotionController extends Controller
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
     * Lists all MerchPromotion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MerchPromotionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MerchPromotion model.
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
     * Creates a new MerchPromotion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MerchPromotion();
        $model->scenario = 'create';

        if ($model->load(Yii::$app->request->post())) {
            
            $model->image = UploadedFile::getInstance($model, 'image');
            if ($model->validate())
            {       
                    if($model->image != '')
                    {
                        $image = time() . '.' . $model->image->extension;
                        $model->image->saveAs(Yii::$app->params['uploadPath'] . 'promotion/' . $image);                        
                        $model->image = $image;
                    }
                        
            }else
            {
              return $this->render('create', [
                    'model' => $model
              ]);
            }
            $model->save(false); 
            Yii::$app->session->setFlash('success', 'Promotion Created Successfully');
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MerchPromotion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $old_data = $this->findModel($id);
        $model->scenario = 'update';

        if ($model->load(Yii::$app->request->post())) {
            
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
                                
                            $oldFile = Yii::$app->params['uploadPath'] .'promotion/' .$old_data->image;             
                            if(file_exists($oldFile))
                                unlink($oldFile);
                            }
                            $image = $model->mer_promotion_id.'_'.time() . '.' . $model->image->extension;
                            $model->image->saveAs(Yii::$app->params['uploadPath'] . 'promotion/' . $image);                        
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
             
            Yii::$app->session->setFlash('success', 'Promotion Created Successfully');
            return $this->redirect(['index']);

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MerchPromotion model.
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
     * Finds the MerchPromotion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MerchPromotion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MerchPromotion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
