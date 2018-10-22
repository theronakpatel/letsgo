<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use backend\models\LoginForm;
use backend\models\ContactForm;
use backend\models\ResetForm;
use backend\models\Dashboard;
use backend\models\Customer;
use backend\models\Posts;
use backend\models\Category;
use backend\models\CustomerActivatation;
use backend\models\Promotion;
use backend\models\MerchPromotion;
use backend\models\CustomerMerchActivatation;
date_default_timezone_set("UTC"); 

class SiteController extends Controller
{

    // public $layout = 'main_1';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [        
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','resetpassword'],
                'rules' => [
                    [
                        'actions' => ['logout','resetpassword'],
                        'allow' => true,
                    ],
                    [
                        'allow' => true,
                         'roles' => ['@'],
                    ]
                    
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
                ],
            ],
        ];
        
    }

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
        if (Yii::$app->user->isGuest) {
            return Yii::$app->getResponse()->redirect(array('/login'));
        }
    }



    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {


        if (!Yii::$app->user->isGuest) {
            $model = new Dashboard();
            $user_count = Customer::find()->count();
            $category_count = Category::find()->count();
            $posts_count = Posts::find()->count();
            $activation_count = CustomerActivatation::find()->count();
            $promotion_count = Promotion::find()->count();
            $merch_promotion_count = MerchPromotion::find()->count();
            $merch_activation_count = CustomerMerchActivatation::find()->count();

            return $this->render('index', [
                'model' => $model,
        		'user_count' => $user_count,
        		'category_count' => $category_count,
                'posts_count' => $posts_count,
                'promotion_count' => $promotion_count,
                'merch_promotion_count' => $merch_promotion_count,
                'merch_activation_count' => $merch_activation_count,
        		'activation_count' => $activation_count
            ]);
            
        }else{
            return Yii::$app->getResponse()->redirect(array('/login'));
        }
             
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
         Yii::$app->user->logout();
         Yii::$app->session->set('show_popup', '0');
        // Yii::$app->session->destroy();
        return Yii::$app->getResponse()->redirect(array('/login'));
         // exit;
        
        // $layout = 'category';
        
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
       

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
         Yii::$app->user->logout();

        $session = Yii::$app->session;
        $session->destroy();
        return Yii::$app->getResponse()->redirect(array('/login'));
    }
 

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }
    public function actionResetPassword($token)
    {
        $model = ResetForm::find()->where([ 'password_reset_token' => $token])->one();
        
        
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword())
        {
            // Yii::$app->session->setFlash('success', 'New password was saved successfully.');
            print_r('<center><h1>New password saved successfully!</h1></center>');
            exit;

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
