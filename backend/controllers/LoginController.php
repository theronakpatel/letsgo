<?php
namespace backend\controllers;

use Yii;
use backend\models\LoginForm;
use backend\models\ResetForm;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
date_default_timezone_set("UTC"); 
/**
 * LoginController implements the CRUD actions for LoginController model.
 */
class LoginController extends Controller
{

    public $layout = 'login';
    
    /**
     * @inheritdoc
     */
    
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


    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        if (!Yii::$app->user->isGuest) {
            return Yii::$app->getResponse()->redirect(array('/site/index'));
        }
    }

    public function actionVerifyemail($token)
    {
        
        $tkn_arr = explode("_", $token);
        if(sizeof($tkn_arr) == 2){
            $email = base64_decode($tkn_arr[1]);
            
            $user_model = new User();
            $data = $user_model->findByEmail($email);

            if(sizeof($data)){
                $user_model->update_status('A',$data['customer_id']);
                print_r('<center><h1>Email verified successfully!</h1></center>');                
            }else{
                print_r('<center><h1>User is not existing!</h1></center>');   
            }
        }else{
            print_r('<center><h1>Link is not valid!</h1></center>');
        }
        die;


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
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) 
        {            
            return $this->goBack();
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }
    public function actionChangestatus()
    {
        Yii::$app->session->set('show_popup', '0');
    }
    
    
    public function actionGetdata()
    {
        $id = 10;
//        echo $id;exit;
        
//        $model = PolyUser::findOne($id)->asArray()->one();
       $model= PolyUser::find()->where(['customer_id' => $id])->asArray()->one();
       echo json_encode($model);

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

                $password_reset_token = $model->getPasswordSecurityToken();

                if($model->updatePasswordResetToken($password_reset_token,$email)) {

                    Yii::$app->session->setFlash('success', 'We sent you email to reset your password.');    
                    
                    return Yii::$app->getResponse()->redirect(array('/login/forgot'));

                }else{
                    Yii::$app->session->setFlash('success', 'Failed to send.');    
                }

            }else{
                Yii::$app->session->setFlash('success', 'Phone number is not exist');
            }
            return Yii::$app->getResponse()->redirect(array('/login/forgot'));
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
                return Yii::$app->getResponse()->redirect(array('/login/resetpassword?id='.$id));
            }else{
                Yii::$app->session->setFlash('success', 'OTP is not valid');
            }
            $id = base64_encode($id);
            return Yii::$app->getResponse()->redirect(array('/login/otp?id='.$id));
        }
        $model->otp = '';
        return $this->render('otp', [
            'model' => $model,
        ]);
    }

    public function actionResetpassword($token)
    {
   
        if (!Yii::$app->user->isGuest || $token == '') {
            return $this->goHome();
        }

        $model = ResetForm::find()->where([
            'password_reset_token'=> $token
        ])->one();
        
        if(!$model){
            Yii::$app->session->setFlash('success', 'Link is not activated or already used!.');    
            return Yii::$app->getResponse()->redirect(array('/login/index'));
        }
        
        $customer_id = $model['customer_id'];
        if ($model->load(Yii::$app->request->post()) && $model->validate()) 
        {  
       
            $pass = md5($model->password);
            $model->password = $pass;
            $model->password_reset_token = '';
            $model->verify_password = '';
            $model->save(false);
            Yii::$app->session->setFlash('success', 'Password reset successfully.');    
            return Yii::$app->getResponse()->redirect(array('/login/index'));
        }
        else
        {
            $model->password_reset_token = '';
            return $this->render('resetPassword', ['model' => $model]);
        }
     
        
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
