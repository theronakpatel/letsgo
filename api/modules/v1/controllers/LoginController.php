<?php
namespace api\modules\v1\controllers;

use yii;
use yii\rest\ActiveController;
use api\modules\v1\models\Login;
use api\modules\v1\models\User;
use api\modules\v1\models\ForgotForm;
use api\modules\v1\models\State;
use api\modules\v1\models\Country;
use backend\models\CustomerReferral;
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
        $model->device_type = $device_type = isset($data->device_type)?$data->device_type:'';
        $model->device_token = $device_token = isset($data->device_token)?$data->device_token:'';
        $model->fb_id = $fb_id = isset($data->fb_id)?$data->fb_id:'';
        if($model->fb_id != ''){
          $model->setScenario('fblogin');
        }else{
          $model->setScenario('emaillogin');
        }

    	if($data){

	    	if (!$model->validate()){
			      $errors = $model->errors;
				  if(isset($errors['email'][0])){
				  	$errors = isset($errors['email'][0])?$errors['email'][0]:'';
			  	  }else if(isset($errors['password'][0])){
			  	  	$errors = isset($errors['password'][0])?$errors['password'][0]:'';
			  	  }else if(isset($errors['fb_id'][0])){
			  	  	$errors = isset($errors['fb_id'][0])?$errors['fb_id'][0]:'';
			  	  }else if(isset($errors['device_type'][0])){
			  	  	$errors = isset($errors['device_type'][0])?$errors['device_type'][0]:'';
			  	  }else if(isset($errors['device_token'][0])){
			  	  	$errors = isset($errors['device_token'][0])?$errors['device_token'][0]:'';
			  	  }
			    	$response = [
			            'status' => '0',
			            'message' => $errors,
			            'data' =>  (object)array(),
			          ];	
		    }
		    else if ($model->validate()){
		    	if($fb_id != ''){
					$user = Login::findOne(['fb_id' => $fb_id]);
		    	}else{
		    		$user = Login::findOne(['email' => $email]);
		    	}
		    	if($user)
		    	{	
		    		 $customer_id = $user->customer_id;
   	    	         $user = Login::findByID($customer_id);

   	    	         $is_validate = $user->validatePassword($password);
   	    	         if($fb_id != ''){
   	    	         	$is_validate = 1;
   	    	         }
					 if($is_validate){

					 		$usermodal = new User();
				          	$auth_key = $usermodal->getNewAuthKey();
				          	$usermodal->updateAuthKey($auth_key,$device_type,$device_token,$customer_id);
		          		    $newuser = Login::find()->where(['customer_id' => $customer_id])->asArray()->one();
		                    $newuser['auth_key'] = $auth_key;
		                    $newuser['password_reset_token'] = '';
		                    $newuser['city'] = (isset($newuser['city']) && $newuser['city'] != '')?$newuser['city']:'';
		                    $newuser['state'] = (isset($newuser['state']) && $newuser['state'] != '')?$newuser['state']:'';
		                    $newuser['state_id'] = $newuser['state'];

		                    if((isset($newuser['state']) && $newuser['state'] != '')){
		                    	$statemodal = State::findOne(['id' => $newuser['state']]);
		                    	if($statemodal){
		                    		$name = $statemodal->name;
		                    	}else{
		                    		$name = '';
		                    	}
		                    	$newuser['state_name'] = $name;
		                    }else{
			                    $newuser['state_name'] = '';
		                    }

		                    if((isset($newuser['country_id']) && $newuser['country_id'] != '')){
		                    	$country = Country::findOne(['country_id' => $newuser['country_id']]);
		                    	if($country){
		                    		$name = $country->name;
		                    	}else{
		                    		$name = '';
		                    	}
		                    	$newuser['country_name'] = $name;
		                    }else{
			                    $newuser['country_name'] = '';
		                    }
		                    if($newuser['image'] != ''){
	                            $newuser['image'] = Yii::$app->params['uploadURL'] . 'customer/' .$newuser['image'];
	                        }
	                        $is_referral = CustomerReferral::find()->where(['customer_id' => $customer_id])->count();
	                        if($is_referral){
	                        	$newuser['is_referred'] = "1";	
	                        }else{
	                        	$newuser['is_referred'] = "0";
	                        }

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
				              'data' =>  (object)array(),
				            ];
			          }	  	
		        }
		        else{
		          $response = [
		            'status' => '0',
		            'message' => 'User not found!',
		            'data' =>  (object)array(),
		          ];
		        }

		    }else{
		    	$errors = $model->errors;
		    	$response = [
		            'status' => '0',
		            'message' => $errors,
		            'data' =>  (object)array(),
		          ];	
		    }
    	}else{
    		$response = [
	            'status' => '0',
	            'message' => 'Blank data given!',
	            'data' =>  (object)array(),
	          ];
    	}
	    echo json_encode($response,TRUE);
        }
        catch (ErrorException $response)
        {
            $response = [
	            'status' => 'error',
	            'message' => $response->getMessage(),
	            'data' =>  (object)array(),
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
		            'data' =>  (object)array(),
		          ];
		        }

		    }else{
		    	$errors = 'Phone number must be blank';
		    	$response = [
		            'status' => 'error',
		            'auth_failed' => '0',
		            'message' => $errors,
		            'data' =>  (object)array(),
		          ];	
		    }
    	}else{
    		$response = [
	            'status' => 'error',
	            'auth_failed' => '0',
	            'message' => 'Blank data given!',
	            'data' =>  (object)array(),
	          ];
    	}
    	
	    
	    echo json_encode($response,TRUE);
        }
        catch (ErrorException $response)
        {
            $response = [
	            'status' => 'error',
	            'auth_failed' => '0',
	            'message' => $response->getMessage(),
	            'data' =>  (object)array(),
	          ];
            
	    echo json_encode($response,TRUE);
        }
    }
    
    
    
	 
    public function actionForgotpassword()
    {
        try
        {
		
			$response = [];
	    	$data = Yii::$app->request->post();
			$data = Yii::$app->request->getRawBody();
			$data = json_decode($data);

	    	$model = new Login();
	    	$user = new ForgotForm();
	        $user->email = $email = isset($data->email)?$data->email:'';
	    	if($user->email != ''){
			    if (!$user->validate()){
					    $errors = $user->errors;
					  	if(isset($errors['email'][0])){
					  	  		$errors = isset($errors['email'][0])?$errors['email'][0]:'';
					  	}
					    $response = [
				            'status' => '0',
				            'message' => $errors,
				            'data' => (object)array(),
				        ];	
				}
				else{
				    	$userdata = $user->findByemail($email);
				    	if($userdata)
		                {
		                    $customer_id =  $userdata['customer_id'];

		                    $password_reset_token = $user->getPasswordSecurityToken();
		                    $user->updatePasswordResetToken($password_reset_token,$customer_id,$email);

				            $response = [
				              'status' => 'success',
				              'message' => 'Success! Check your email for further instructions to reset password!',
				              'data' => (object)array()
				            ];		           
				        }
				        else{
				          $response = [
				            'status' => '0',
				            'message' => 'Email not found!',
				            'data' => (object)array()
				          ];
				        }
		                   

				} 
	    	}
	        else
	        {
	    		$response = [
		            'status' => '0',
		            'message' => 'Blank data given!',
		            'data' => (object)array()
		          ];
	    	}
        }
        catch (ErrorException $response)
        {
            $response = [
                    'status' => '0',
                    'message' => $response->getMessage(),
                    'data' =>  (object)array()
                  ];

        }
            echo json_encode($response,TRUE);
    }
    

    public function actionRedeemed()
    {
        try
        {

                $data = Yii::$app->request->getRawBody();
                $data = json_decode($data);
                
                $customer_id = isset($data->customer_id)?$data->customer_id:'0';
                $referral_code = isset($data->referral_code)?$data->referral_code:'0';

                $customer_details = Login::find()->where(['customer_id' => $customer_id])->one();
                if($customer_details){
                	if($customer_details['referral_code'] != $referral_code){
                		$referral_code_details = Login::find()->where(['referral_code' => $referral_code])->one();
	                	if($referral_code_details){
							$ref_customer_id = $referral_code_details['customer_id'];
		                    $CustomerReferralDetails = CustomerReferral::find()->where(['ref_customer_id' => $ref_customer_id, 'customer_id' => $customer_id])->one();

		                    if(!$CustomerReferralDetails)
		                    {
		                        $CustomerReferralModal = new CustomerReferral();
		                        $CustomerReferralModal->ref_customer_id = $ref_customer_id; 
		                        $CustomerReferralModal->customer_id = $customer_id; 
		                        $CustomerReferralModal->date = date('Y-m-d H:i:s'); 
		                        $CustomerReferralModal->save(false);

		                        $referral_code_details->promotion_points = $referral_code_details->promotion_points + 50;
		                        $referral_code_details->save(false);

		                        $customer_details->promotion_points = $customer_details->promotion_points + 50;
		                        $customer_details->save(false);

		                        $response = [
		                          'status' => '1',
		                          'message' => 'Referral code valid! 50 points added in your account.',
		                          'data' => (object)array(),
		                        ];

		                    }else{
		                        $response = [
		                            'status' => '0',
		                            'message' => 'You have already used referral code!',
		                            'data' =>  (object)array(),
		                          ];                        
		                    }
	                		
	                	}else{
	                		    $response = [
		                            'status' => '0',
		                            'message' => 'Referral code is not valid!',
		                            'data' =>  (object)array(),
		                          ];                       
	                	}
                	}else{
                		$response = [
	                            'status' => '0',
	                            'message' => 'Cannot use your own referral code!',
	                            'data' =>  (object)array(),
	                          ];                       
                	}
                }else{

                    $response = [
                        'status' => '0',
                        'message' => 'Customer is not valid!',
                        'data' =>  (object)array(),
                      ];
                }
                echo json_encode($response,TRUE);
        }
        catch (ErrorException $response)
        {
            $response = [
                    'status' => '0',
                    'message' => $response->getMessage(),
                    'data' =>  (object)array(),
                  ];

            echo json_encode($response,TRUE);
        }
    }
    
}