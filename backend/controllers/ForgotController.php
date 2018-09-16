<?php
namespace backend\controllers;

use Yii;
use backend\models\LoginForm;
use backend\models\User;
use backend\models\ForgotForm;
use backend\models\OtpForm;
use backend\models\ResetForm;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LoginController implements the CRUD actions for LoginController model.
 */
class ForgotController extends Controller
{

    public $layout = 'login';

    
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
     public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Lists all TblCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new ForgotForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate() ) {

            if ($model->checkEmail(Yii::$app->request->post())) {

                extract(Yii::$app->request->post('ForgotForm'));
                if ($model->forgot($phone)) {
                    Yii::$app->session->setFlash('success', 'We sent you SMS to reset your password.');    
                    $phone = base64_encode($phone);
                    return $this->redirect('login/otp&id='.$phone);
                }else{
                    Yii::$app->session->setFlash('success', 'Failed to send.');    
                }

            }else{
                Yii::$app->session->setFlash('success', 'Phone number is not exist');
            }
            return $this->redirect('login/forgot');
        }

        return $this->render('forgot', [
            'model' => $model,
        ]);
    }




    
    

    public function actionForgot()
    {
        
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new ForgotForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate() ) {

            if ($model->checkEmail(Yii::$app->request->post())) {

                extract(Yii::$app->request->post('ForgotForm'));
                if ($model->forgot($phone)) {
                    Yii::$app->session->setFlash('success', 'We sent you SMS to reset your password.');    
                    $phone = base64_encode($phone);
                    return $this->redirect('login/otp&id='.$phone);
                }else{
                    Yii::$app->session->setFlash('success', 'Failed to send.');    
                }

            }else{
                Yii::$app->session->setFlash('success', 'Phone number is not exist');
            }
            return $this->redirect('login/forgot');
        }

        return $this->render('forgot', [
            'model' => $model,
        ]);
    }

    public function actionOtp($id)
    {
        if (!Yii::$app->user->isGuest || $id == '') {
            return $this->goHome();
        }
        $id = base64_decode($id);

        // $model = new OtpForm();

        $model = OtpForm::find()->where([
            'phone'=> $id
        ])->one();

        // print_r($model);

        // $model = $model->findModel($id)


        if ($model->load(Yii::$app->request->post()) && $model->validate() ) {

            if ($model->checkOTP(Yii::$app->request->post())) {
                $id = base64_encode($id);
                return $this->redirect('login/resetpassword&id='.$id);
            }else{
                Yii::$app->session->setFlash('success', 'OTP is not valid');
            }
            $id = base64_encode($id);
            return $this->redirect('login/otp&id='.$id);
        }
        $model->otp = '';
        return $this->render('otp', [
            'model' => $model,
        ]);
    }

    public function actionResetpassword($id)
    {
        if (!Yii::$app->user->isGuest || $id == '') {
            return $this->goHome();
        }
        $id = base64_decode($id);

        // $model = new OtpForm();

        $model = ResetForm::find()->where([
            'phone'=> $id
        ])->one();
 

        if ($model->load(Yii::$app->request->post()) && $model->validate() ) {

            if ($model->resetPassword(Yii::$app->request->post())) {

                $model1 = new LoginForm();
                
                $postdata = Yii::$app->request->post();
                $postdata['LoginForm'] = Yii::$app->request->post('ResetForm');
                
                
                if ($model1->load($postdata) && $model1->login()) 
                {
                    // print_r($postdata);exit;

                    $user_model = new User();
                    $data = $user_model->findByAppPhone($id);
                    $app_type = $data->app_type;
                    $user_type = $data->user_type;
                    Yii::$app->session->set('app_type', $app_type);
                    Yii::$app->session->set('user_type', $user_type);
                    Yii::$app->session->setFlash('success', 'Password reset successfully.');
                    return $this->goBack();
                }
                return $this->redirect('login');
            }else{
                Yii::$app->session->setFlash('success', 'OTP is not valid');
            }
            $id = base64_encode($id);
            return $this->redirect('login/otp&id='.$id);
        }else{
            $model->password = '';
            $model->verify_password = '';            
        }

        return $this->render('reset', [
            'model' => $model,
        ]);
    }

    
    protected function findModel($id)
    {
        if (($model = TblCategory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
