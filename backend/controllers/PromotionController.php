<?php

namespace backend\controllers;

use Yii;
use backend\models\Promotion;
use backend\models\PromotionSearch;
use backend\models\PostPromotion;
use backend\models\PromotionActivationcode;
use backend\models\PromotionActivationcodeSearch;
use backend\models\CategoryPromotion;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
/**
 * PromotionController implements the CRUD actions for Promotion model.
 */
class PromotionController extends Controller
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
     * Lists all Promotion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PromotionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Promotion models.
     * @return mixed
     */
    public function actionShowpromo($id)
    {
        $searchModel = new PromotionActivationcodeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,$id);

        return $this->render('showpromo', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Promotion model.
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
     * Creates a new Promotion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Promotion();
        $PostPromotionmodel = new PostPromotion();
        $CategoryPromotionmodel = new CategoryPromotion();
        $promotionActivationcodeModal = new PromotionActivationcode();
        $model->scenario = 'create';

        $model->posts = array();
        $model->categories = array();


        if ($model->load(Yii::$app->request->post()) && $promotionActivationcodeModal->load(Yii::$app->request->post()) ) {
            
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
                    'model' => $model,
                    'PostPromotionmodel' => $PostPromotionmodel,
                    'CategoryPromotionmodel' => $CategoryPromotionmodel,
                    'promotionActivationcodeModal' => $promotionActivationcodeModal,
              ]);
            }
            $model->save(false);
            $promotionActivationcodeModal->promotion_id = $model->promotion_id;
            $promotionActivationcodeModal->save(false);
            
            $post_ids = $model->posts;
            if($post_ids){
                foreach ($post_ids as $key => $value) {
                    /** @var TrunkGroupDetails $trunkgroupdetails */
                    $promotionmodal = new PostPromotion();
                    $promotionmodal->post_id = $value;
                    $promotionmodal->promotion_id = $model->promotion_id;
                    $promotionmodal->added_date = date('Y-m-d H:i:s');
                    $promotionmodal->save(false);
                }
            }
            $category_ids = $model->categories;
            if($category_ids){
                foreach ($category_ids as $key => $value) {
                    /** @var TrunkGroupDetails $trunkgroupdetails */
                    $promotionmodal = new CategoryPromotion();
                    $promotionmodal->category_id = $value;
                    $promotionmodal->promotion_id = $model->promotion_id;
                    $promotionmodal->added_date = date('Y-m-d H:i:s');
                    $promotionmodal->save(false);
                }    
            }
            /*$total_activationcodes = $model->total_activationcodes;

            for ($i=0; $i < $total_activationcodes ; $i++) {
                $length = 8;
                $promocode1 = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZ', 5)), 0, 12);
                $promocode3 = substr(str_shuffle(str_repeat('0123456789', 5)), 0, 12);
                $promocode = substr(str_shuffle($promocode1 . $promocode3), 0, 6);

                $pmc = new PromotionActivationcode;
                $pmc->promotion_id = $model->promotion_id;
                $pmc->activation_code = $promocode;
                $pmc->save(false);
            }*/
            Yii::$app->session->setFlash('success', 'Promotion Created Successfully');
            return $this->redirect(['index']);

        } else {
            return $this->render('create', [
                'model' => $model,
                'PostPromotionmodel' => $PostPromotionmodel,
                'CategoryPromotionmodel' => $CategoryPromotionmodel,
                'promotionActivationcodeModal' => $promotionActivationcodeModal,
            ]);
        }
    }

    /**
     * Updates an existing Promotion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
       
       $model = $old_data = $this->findModel($id);
       $PostPromotionmodel = PostPromotion::find()->where(['promotion_id' => $model->promotion_id])->asArray()->all();
       $CategoryPromotionmodel = CategoryPromotion::find()->where(['promotion_id' => $model->promotion_id])->asArray()->all();
       $promotionActivationcodeModal = PromotionActivationcode::findOne(['promotion_id' => $model->promotion_id]);
       $model->posts = array_column($PostPromotionmodel,"post_id");
       $model->categories = array_column($CategoryPromotionmodel,"category_id");

       /*$PostPromotionmodel = new PostPromotion();
       $CategoryPromotionmodel = new CategoryPromotion();*/

       $model->scenario = 'update';
        if ($model->load(Yii::$app->request->post()) && $promotionActivationcodeModal->load(Yii::$app->request->post()) ) {

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
                            $image = $model->promotion_id.'_'.time() . '.' . $model->image->extension;
                            // $image = $model->image->baseName . '.' . $model->image->extension;
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
            $promotionActivationcodeModal->save(false);
            PostPromotion::deleteAll(['promotion_id' => $model->promotion_id]);
            $post_ids = $model->posts;
            if($post_ids){
                foreach ($post_ids as $key => $value) {
                    /** @var TrunkGroupDetails $trunkgroupdetails */
                    $promotionmodal = new PostPromotion();
                    $promotionmodal->post_id = $value;
                    $promotionmodal->promotion_id = $model->promotion_id;
                    $promotionmodal->added_date = date('Y-m-d H:i:s');
                    $promotionmodal->save(false);
                }
            }

            CategoryPromotion::deleteAll(['promotion_id' => $model->promotion_id]);
            $category_ids = $model->categories;
            if($category_ids){
                foreach ($category_ids as $key => $value) {
                    /** @var TrunkGroupDetails $trunkgroupdetails */
                    $promotionmodal = new CategoryPromotion();
                    $promotionmodal->category_id = $value;
                    $promotionmodal->promotion_id = $model->promotion_id;
                    $promotionmodal->added_date = date('Y-m-d H:i:s');
                    $promotionmodal->save(false);
                }    
            }
            
            Yii::$app->session->setFlash('success', 'Promotion Updated Successfully');
            return $this->redirect(['index']);
        }else {
            return $this->render('update', [
                'model' => $model,
                'PostPromotionmodel' => $PostPromotionmodel,
                'CategoryPromotionmodel' => $CategoryPromotionmodel,
                'promotionActivationcodeModal' => $promotionActivationcodeModal,
            ]);
        }
    }

    /**
     * Deletes an existing Promotion model.
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
     * Finds the Promotion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Promotion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Promotion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
