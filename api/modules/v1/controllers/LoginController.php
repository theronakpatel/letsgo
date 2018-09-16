<?php
namespace api\modules\v1\controllers;

use yii;
use yii\rest\ActiveController;
use api\modules\v1\models\Login;
use api\modules\v1\models\User;
use yii\data\ActiveDataProvider;
use yii\base\ErrorException;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
date_default_timezone_set("UTC"); 

class LoginController extends ActiveController
{
	public $modelClass = 'api\modules\v1\models\Login';
    public function actionIndex()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
    }
    public function actionMakelogin()
    {
	try 
        {
            
      	$response = [];
    	$data = Yii::$app->request->post();
		$data = Yii::$app->request->getRawBody();
		$data = json_decode($data);

    	$model = new Login();
        $model->email = $email = isset($data->email)?$data->email:'';
        $model->password = $password = isset($data->password)?$data->password:'';
        $device_type = isset($data->device_type)?$data->device_type:'';
        $device_token = isset($data->device_token)?$data->device_token:'';

    	if($data){

	    	if (!$model->validate()){
			      $errors = $model->errors;
				  if(isset($errors['email'][0])){
				  	$errors = isset($errors['email'][0])?$errors['email'][0]:'';
			  	  }else if(isset($errors['password'][0])){
			  	  	$errors = isset($errors['password'][0])?$errors['password'][0]:'';
			  	  }
			    	$response = [
			            'status' => '0',
			            'message' => $errors,
			            'data' =>  array(),
			          ];	
		    }
		    else if ($model->validate()){
		    	$user = Login::findOne(['email' => $email]);
		    	if($user)
		    	{	
		    		 $customer_id = $user->customer_id;
   	    	         $user = Login::findByID($customer_id);
					 if($user->validatePassword($password)){

					 		$usermodal = new User();
				          	$auth_key = $usermodal->getNewAuthKey();
				          	$usermodal->updateAuthKey($auth_key,$device_type,$device_token,$customer_id);
		          		    $newuser = Login::find()->where(['customer_id' => $customer_id])->asArray()->one();
		                    $newuser['auth_key'] = $auth_key;
		                    $newuser['password_reset_token'] = '';
		                    $response = [
		                                'status' => '1',
		                                'message' => 'Login success',
		                                'data' => $newuser
		                    ];
			          }
			          else{
				            $response = [
				              'status' => '0',
				              'message' => 'Password not matched!',
				              'data' =>  array(),
				            ];
			          }	  	
		        }
		        else{
		          $response = [
		            'status' => '0',
		            'message' => 'Email not found!',
		            'data' =>  array(),
		          ];
		        }

		    }else{
		    	$errors = $model->errors;
		    	$response = [
		            'status' => '0',
		            'message' => $errors,
		            'data' =>  array(),
		          ];	
		    }
    	}else{
    		$response = [
	            'status' => '0',
	            'message' => 'Blank data given!',
	            'data' =>  array(),
	          ];
    	}
	    echo json_encode($response,TRUE);
        }
        catch (ErrorException $response)
        {
            $response = [
	            'status' => 'error',
	            'message' => $response->getMessage(),
	            'data' =>  array(),
	          ];
            
	    echo json_encode($response,TRUE);
        }
    }
	 
    public function actionVerified()
    {
	try
        {	
        $response = [];
    	$data = Yii::$app->request->post();
    	$model = new \api\modules\v1\models\Login();
        $model->load(Yii::$app->request->post());
        $model->attributes=Yii::$app->request->post();
        $model->phone = $model->phone;
        $model->email = $model->email;
        $model->photo = $model->photo;
                
                        
        $myfile = fopen(Yii::$app->params['uploadPath']."log/ws_log.log", "a") or die("Unable to open file!");       
        $txt = date('Y-m-d H:i:s')." | ".$_SERVER['REMOTE_ADDR']." Input Register WS: ".json_encode($data);
        fwrite($myfile, "\n". $txt);
        fclose($myfile);
//		 print_r($model->attributes);exit;
    	if(sizeof($data)){
    		extract($data);

	    	if (!is_null($model->phone)){

		    	$user = \api\modules\v1\models\Login::findByphone($model->phone);
		    	if(!empty($user)){
		    		\api\modules\v1\models\Login::verifiedPhone($user['user_id']);
 				
		          	
		    		$user = \api\modules\v1\models\Login::findByID($user['user_id']);
		    		$auth_key = $user->getNewAuthKey();
		          	$user = $user->findByID($user->user_id);

		          	$photo = $user->photo;
	                if($photo != ''){
	                  $photo = Yii::$app->params['site_url'].'uploaded_file/'.$photo;
	                }

		          	
		          	
		    		// print_r($user);exit;
		            $response = [
		              'status' => 'success',
		              'message' => 'Phone number verified successfully!',
		              'data' => [
		                  'user_id' => (string)$user->user_id,
		                  'name' => (string)$user->name,
		                  'phone' => (string)$user->phone,
                          'email' => (string)$user->email,
                          'photo' => (string)$photo,
		                  'status' => (string)$user->status,
		                  'device' => (string)$user->device,
		                  'device_token' => (string)$user->device_token,
		                  'token' => (string)$auth_key,
		                  //'token' => (string)$user->auth_key,
		              ]
		            ];
		          
		        }
		        else{
		          $response = [
		            'status' => 'error',
		            'auth_failed' => '0',
		            'message' => 'Phone number not found!',
		            'data' =>  array(),
		          ];
		        }

		    }else{
		    	$errors = 'Phone number must be blank';
		    	$response = [
		            'status' => 'error',
		            'auth_failed' => '0',
		            'message' => $errors,
		            'data' =>  array(),
		          ];	
		    }
    	}else{
    		$response = [
	            'status' => 'error',
	            'auth_failed' => '0',
	            'message' => 'Blank data given!',
	            'data' =>  array(),
	          ];
    	}
    	
	    $myfile = fopen(Yii::$app->params['uploadPath']."log/ws_log.log", "a") or die("Unable to open file!");       
            $txt = date('Y-m-d H:i:s')." | ".$_SERVER['REMOTE_ADDR']." Output Register WS: ".json_encode($response);
            fwrite($myfile, "\n". $txt);
            fclose($myfile);
	    echo json_encode($response,TRUE);
        }
        catch (ErrorException $response)
        {
            $response = [
	            'status' => 'error',
	            'auth_failed' => '0',
	            'message' => $response->getMessage(),
	            'data' =>  array(),
	          ];
            
	    echo json_encode($response,TRUE);
        }
    }
    
    
    
	 
    public function actionForgotpassword()
    {
        try
        {
	$response = [];
        $headers = Yii::$app->request->headers;
        $user_id = $headers->get('user_id', '0');
        $token = $headers->get('token','0');
    	$data = Yii::$app->request->post();
    	$model = new \api\modules\v1\models\ForgotForm();
        $model->load(Yii::$app->request->post());
        $model->attributes=Yii::$app->request->post();
        $model->email = $model->email;
         
        $myfile = fopen(Yii::$app->params['uploadPath']."log/ws_log.log", "a") or die("Unable to open file!");       
        $txt = date('Y-m-d H:i:s')." | ".$_SERVER['REMOTE_ADDR']." Input Forgotpassword WS: ".json_encode($data);
        fwrite($myfile, "\n". $txt);
        fclose($myfile);

    	if(sizeof($data)){
    		extract($data);
	    	if (!$model->validate())
                {

			      $errors = $model->errors;
    			  // print_r($errors); exit();
				  
			  	  if(isset($errors['email'][0])){
			  	  	$errors = isset($errors['email'][0])?$errors['email'][0]:'';
			  	  }

			    	$response = [
		            'status' => 'error',
		            'auth_failed' => '0',
		            'message' => $errors,
		            'data' => '',
		          ];	
		}
		else if ($model->validate())
                {
                    
		    	$user = \api\modules\v1\models\ForgotForm::findByemail($email);	
		    	if(!empty($user))
                {

                	 if($user['status'] == 'I'){
				          	$response = [
				              'status' => 'error',
				              'auth_failed' => '0',
				              'message' => 'Account is inactive! Please contact admin!',
				              'data' =>  array(),
				            ];
			          }
			          else if($user['status'] == 'B'){
				          	$response = [
				              'status' => 'error',
				              'auth_failed' => '0',
				              'message' => 'Account is blocked! Please contact admin!',
				              'data' =>  array(),
				            ];
			          }
			          else if($user['status'] == 'ENV'){
					          	$response = [
					              'status' => 'error',
					              'auth_failed' => '0',
					              'message' => 'Please verify email first!',
					              'data' =>  array(),
					            ];
				      }else{


                            $user_id =  $user['user_id'];
                            $password_reset_token = \api\modules\v1\models\Login::getPasswordSecurityToken();
                            $id = \api\modules\v1\models\Login::updatePasswordResetToken($password_reset_token,$user_id,$email);

				            $response = [
				              'status' => 'success',
				              'message' => 'Success! Check your email for further instructions to reset password!',
				              'data' => ""
				            ];
				      }
		           
		        }
		        else
                        {
		          $response = [
		            'status' => 'error',
		            'auth_failed' => '0',
		            'message' => 'Email not found!',
		            'data' => '',
		          ];
		        }
                   

		}
        else{
		    	 $errors = $model->errors;
				  
			  	  if(isset($errors['email'][0])){
			  	  	$errors = isset($errors['email'][0])?$errors['email'][0]:'';
			  	  }

			    	$response = [
		            'status' => 'error',
		            'auth_failed' => '0',
		            'message' => $errors,
		            'data' => '',
		          ];	
		}	
    	}
        else
        {
    		$response = [
	            'status' => 'error',
	            'auth_failed' => '0',
	            'message' => 'Blank data given!',
	            'data' => '',
	          ];
    	}
        
        $myfile = fopen(Yii::$app->params['uploadPath']."log/ws_log.log", "a") or die("Unable to open file!");       
        $txt = date('Y-m-d H:i:s')." | ".$_SERVER['REMOTE_ADDR']." Output Forgotpassword WS: ".json_encode($response);
        fwrite($myfile, "\n". $txt);
        fclose($myfile);
        echo json_encode($response,TRUE);    
        
        }
        catch (ErrorException $response)
        {
            $response = [
                    'status' => 'error',
                    'auth_failed' => '0',
                    'message' => $response->getMessage(),
                    'data' =>  array(),
                  ];

            echo json_encode($response,TRUE);
        }
    }
    
    
}