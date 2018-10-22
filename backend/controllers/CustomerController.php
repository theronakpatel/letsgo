<?php

namespace backend\controllers;

use Yii;
use backend\models\Customer;
use backend\models\CustomerSearch;
use backend\models\Posts;
use backend\models\CustomerActivatationSearch;
use backend\models\CustomerMerchActivatationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends Controller
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
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Customer models.
     * @return mixed
     */
    public function actionActivation()
    {
        $searchModel = new CustomerActivatationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('activation', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * send customer notificaion
     * @return mixed
     */
    public function actionCustomnotification()
    {
        $model = new Customer();
        $model->scenario = 'notification';
        if ($model->load(Yii::$app->request->post())) {
            $customerData  =  Customer::find()->asArray()->all();
            foreach ($customerData as $key => $value) {
              $device_type = $value['device_type'];
              $device_token = $value['device_token'];
                $title = $model->message;
                $param = '';
                $model1 = new Posts();
                $device = isset($model->device)?$model->device:'all';
                if(($device == 'all' || $device == 'android')  && $device_type == '1'){
                  $model1->sendAndroidNotification($device_token, $param, $title, 3,0,0);
                }                
                if(($device == 'all' || $device == 'ios')  && $device_type == '2'){
                  $model1->sendIosNotification($device_token, $param, $title, 3,0,0);
                }
            }
            
            Yii::$app->session->setFlash('success', 'Notification sent Successfully');
            return $this->redirect(['customnotification']);

        } else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }
    /**
     * Lists all Customer models.
     * @return mixed
     */
    public function actionMerchActivation()
    {
        $searchModel = new CustomerMerchActivatationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('merch-activation', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Customer model.
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
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Customer();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->customer_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->customer_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Customer model.
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
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
