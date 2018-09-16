<?php

// namespace \controllers;
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;

use backend\models\User;
use backend\models\UserSearch;
date_default_timezone_set("UTC"); 

/**
 * PolyUserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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

    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        if (Yii::$app->user->isGuest) {

            return Yii::$app->getResponse()->redirect(array('/login'));
        }


         if (!Yii::$app->user->isGuest) {
            if ( Yii::$app->session->get('userSessionTimeout') < time() ) {
                   Yii::$app->user->logout();
                    $session = Yii::$app->session;
                    $session->destroy();
                   return Yii::$app->getResponse()->redirect(array('/login'));
            }else{
              Yii::$app->session->set('userSessionTimeout', time() + 300000);
            }
        }

        
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {

            return Yii::$app->getResponse()->redirect(array('/login'));
        }

        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionExecutive()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->getResponse()->redirect(array('/login'));
        }

        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('executive', [
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
        if (Yii::$app->user->isGuest) {
            return Yii::$app->getResponse()->redirect(array('/login'));
        }


         /*share tours*/
         $query = ReferralTour::find()->select([
                              'hoi_referrel.*', 
                              'hoi_referrel.phone_number as phone',
                   new \yii\db\Expression("(SELECT hoi_tours.tour_name FROM hoi_tours WHERE hoi_tours.tour_id = hoi_referrel.tour_id )  as TourName"),
                   new \yii\db\Expression("(SELECT hoi_user.name  FROM hoi_user WHERE hoi_user.user_id = hoi_referrel.user_id )  as Name"),
                              ])->where(['user_id' => $id]);
         
           

         $dataProvider = new ActiveDataProvider([                                                
            'query' => $query,
            'sort'=> ['defaultOrder' => ['referrel_id'=>SORT_DESC]]

        ]);

        $dataProvider->sort->attributes['Name'] = [
            // The tables are the ones our relation are configured to
            'asc' => ['hoi_referrel.user_id' => SORT_ASC],
            'desc' => ['hoi_referrel.user_id' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['TourName'] = [
            // The tables are the ones our relation are configured to
            'asc' => ['hoi_referrel.purchase_tour_id' => SORT_ASC],
            'desc' => ['hoi_referrel.purchase_tour_id' => SORT_DESC],
        ];
        
        $dataProvider->sort->attributes['phone'] = [
            // The tables are the ones our relation are configured to
            'asc' => ['hoi_referrel.purchase_tour_id' => SORT_ASC],
            'desc' => ['hoi_referrel.purchase_tour_id' => SORT_DESC],
        ];

        /*end*/
        /* purchased history*/

               $query = PurchasedTour::find()->select([
                              'hoi_purchase_tours.*', 
                                new \yii\db\Expression("(SELECT hoi_tours.tour_name  FROM hoi_tours WHERE hoi_tours.tour_id = hoi_purchase_tours.tour_id )  as TourName"),
                                new \yii\db\Expression("(SELECT hoi_user.name  FROM hoi_user WHERE hoi_user.user_id = $id )  as Name"),
                                new \yii\db\Expression("(SELECT hoi_payment_history.created_date  FROM hoi_payment_history WHERE hoi_payment_history.payment_id = hoi_purchase_tours.payment_id )  as PurchasedDate"),
                              ])->where(['user_id' => $id]);
                              
                              
              $PurchaseddataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'sort'=> ['defaultOrder' => ['payment_id'=>SORT_DESC]]

                ]);

                $PurchaseddataProvider->sort->attributes['Name'] = [
                    // The tables are the ones our relation are configured to
                    'asc' => ['hoi_purchase_tours.user_id' => SORT_ASC],
                    'desc' => ['hoi_purchase_tours.user_id' => SORT_DESC],
                ];

                $PurchaseddataProvider->sort->attributes['TourName'] = [
                    // The tables are the ones our relation are configured to
                    'asc' => ['hoi_purchase_tours.tour_id' => SORT_ASC],
                    'desc' => ['hoi_purchase_tours.tour_id' => SORT_DESC],
                ];
                
                 $PurchaseddataProvider->sort->attributes['PurchasedDate'] = [
                    // The tables are the ones our relation are configured to
                    'asc' => ['hoi_purchase_tours.payment_id' => SORT_ASC],
                    'desc' => ['hoi_purchase_tours.payment_id' => SORT_DESC],
                ];
            

        /*end*/

       
         $query = Transaction::find()->select([
                              'hoi_payment_history.*', 
                                new \yii\db\Expression("(SELECT hoi_user.name  FROM hoi_user WHERE hoi_user.user_id = $id )  as Name"),
                                new \yii\db\Expression("(SELECT hoi_tours.tour_name  FROM hoi_tours WHERE hoi_tours.tour_id = hoi_payment_history.tour_id )  as TourName"),
                              ])->where(['user_id' => $id]);
                              
                              
              $paymentHistorydataProvider = new ActiveDataProvider([
                    'query' => $query,
                    'sort'=> ['defaultOrder' => ['payment_id'=>SORT_DESC]]

                ]);

                $paymentHistorydataProvider->sort->attributes['Name'] = [
                    // The tables are the ones our relation are configured to
                    'asc' => ['hoi_payment_history.user_id' => SORT_ASC],
                    'desc' => ['hoi_payment_history.user_id' => SORT_DESC],
                ];
                $paymentHistorydataProvider->sort->attributes['TourName'] = [
                    // The tables are the ones our relation are configured to
                    'asc' => ['hoi_payment_history.tour_id' => SORT_ASC],
                    'desc' => ['hoi_payment_history.tour_id' => SORT_DESC],
                ];
 
        
        return $this->render('view', [
            'id' => $id,
            'model' => $this->findModel($id),
            'sharedDataProvider' => $dataProvider,
            'PurchaseddataProvider' => $PurchaseddataProvider,
            'paymentHistorydataProvider' => $paymentHistorydataProvider,
        ]);
    }
    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->getResponse()->redirect(array('/login'));
        }

        $model = new User();
        $model->scenario = 'create';
        
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) 
        {
            $model->app_type = 'M';
            $pass = md5($model->password);
            $model->password = $pass;
            $model->save(false);
            Yii::$app->session->setFlash('success', 'User Created Successfully');
            return $this->redirect(['view', 'id' => $model->user_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->getResponse()->redirect(array('/login'));
        }
        $model = $this->findModel($id);
        $checkpass = $model->password;
        
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) 
        {
            if ($model->password == '') {
                $model->password = $checkpass;
            } else {
                $pass = md5($model->password);
                $model->password = $pass;
            }
            if ($model->save(false))
             //   $this->redirect(array('index'));
        
            Yii::$app->session->setFlash('success', 'User Updated Successfully');
            return $this->redirect(['view', 'id' => $model->user_id]);
        } 
        else
        {
            $model->password = '';
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    public function actionUpdatestatus()
    {
        if (Yii::$app->user->isGuest) {
            return Yii::$app->getResponse()->redirect(array('/login'));
        }
        $model = new User();
    
        $user_id = Yii::$app->request->post('user_id');
        $status= Yii::$app->request->post('status');
//print_r($model);exit;
        
        if ($model->update_status($status,$user_id)) 
        {
       echo 'success';
        } 
        else 
        {
          echo 'failed';
        }
    }
    public function actionResetdevice()
    {
        if (Yii::$app->user->isGuest) {

            Yii::$app->session->setFlash('success', 'Failed to reset device');
            echo 'failed';die;
        }
        $model = new User();
    
        $user_id = Yii::$app->request->post('user_id');
        
        if ($model->reset_device($user_id)) 
        {
          Yii::$app->session->setFlash('success', 'Device reset Successfully');
          echo 'success';
        } 
        else 
        {
          Yii::$app->session->setFlash('success', 'Failed to reset device');
          echo 'failed';
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'User Deleted Successfully');
        return $this->redirect(['index']);
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
