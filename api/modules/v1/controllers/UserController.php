<?php
namespace api\modules\v1\controllers;

use yii;
use yii\rest\ActiveController;
use api\modules\v1\models\User;
use api\modules\v1\models\TourLocation;
use api\modules\v1\models\Tour;
use api\modules\v1\models\Referrel;
use api\modules\v1\models\PaymentHistory;
use api\modules\v1\models\PurchaseTours;
use api\modules\v1\models\State;
use api\modules\v1\models\Country;
use backend\models\CustomerReferral;

use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;
date_default_timezone_set("UTC"); 


class UserController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\User';

  public function actionIndex()
	{ 
	    Yii::$app->response->format = Response::FORMAT_JSON;
	}

	 public function actionRegister()
	{
             try
             {

                $response = [];
                $data = Yii::$app->request->post();
                $data = Yii::$app->request->getRawBody();
                $data = json_decode($data);

                $model = new User();
                $model->name= isset($data->name)?$data->name:'';
                $model->email = isset($data->email)?$data->email:'';
                $model->password = isset($data->password)?md5($data->password):'';
                $model->country_id = isset($data->country_id)?$data->country_id:'';
                $model->device_type = $device_type = isset($data->device_type)?$data->device_type:'';
                $model->device_token = $device_token = isset($data->device_token)?$data->device_token:'';
                $model->state = $state = isset($data->state)?$data->state:(isset($data->state_id)?$data->state_id:'');
                $model->city = $city = isset($data->city)?$data->city:'';
                $model->fb_id = $fb_id = isset($data->fb_id)?$data->fb_id:'';

                $referral_code1 = substr(str_shuffle(str_repeat('ABCDEFGHJKMNPQRSTUVWXYZ', 5)), 0, 3);
                $referral_code2 = substr(str_shuffle(str_repeat('abcdefghjkmnpqrstuvwxyz', 5)), 0, 3);
                $referral_code3 = substr(str_shuffle(str_repeat('123456789', 5)), 0, 3);
                $referral_code = substr(str_shuffle($referral_code1 . $referral_code2 . $referral_code3 ), 0, 6);
                $Usermodel = User::findOne(['referral_code' => $referral_code]);
                if(!$Usermodel){
                  $model->referral_code = $referral_code;  
                }else{
                  $model->referral_code = $referral_code = time();
                }
                

                if($model->fb_id != ''){
                  $model->setScenario('fblogin');
                }else{
                  $model->setScenario('emaillogin');
                }
                if($data)
                {
                    if (!$model->validate()){
                          $errors = $model->errors;
                          if(isset($errors['name'][0])){
                            $errors = isset($errors['name'][0])?$errors['name'][0]:'';
                          }else if(isset($errors['email'][0])){
                            $errors = isset($errors['email'][0])?$errors['email'][0]:'';
                          }else if(isset($errors['password'][0])){
                            $errors = isset($errors['password'][0])?$errors['password'][0]:'';
                          }else if(isset($errors['fb_id'][0])){
                            $errors = isset($errors['fb_id'][0])?$errors['fb_id'][0]:'';
                          }else if(isset($errors['device_type'][0])){
                            $errors = isset($errors['device_type'][0])?$errors['device_type'][0]:'';
                          }else if(isset($errors['device_token'][0])){
                            $errors = isset($errors['device_token'][0])?$errors['device_token'][0]:'';
                          }else{
                            $errors = 'Something went wrong';
                          }
                          
                          $response = [
                                          'status' => '0',
                                          'message' => $errors,
                                          'data' =>  (object)array(),
                                      ];	
                    }
                    else if($model->validate())
                    {
                        $model->register_date = date('Y-m-d H:i:s');
                        $model->save(false);
                        $customer_id = $model->customer_id;

                        if($customer_id){
                                  $usermodal = new User();
                                  $auth_key = $usermodal->getNewAuthKey();
                                  $usermodal->updateAuthKey($auth_key,$device_type,$device_token,$customer_id);

                                  $newuser = User::find()->where(['customer_id' => $customer_id])->asArray()->one();
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
                                                'message' => 'Registered successfully!',
                                                'data' => $newuser
                                  ];

                        }
                        else{
                            $response = [
                                          'status' => 'error',
                                          'message' => 'Registration failed!',
                                          'data' =>  (object)array(),
                                        ];
                        }
                    }
                    else
                    {
                        $errors = $model->errors;
                        $response = [
                                      'status' => 'error',
                                      'message' => $errors,
                                      'data' =>  (object)array(),
                                  ];	
                    }	
                }
                else
                {
                    $response = [
                                  'status' => 'error',
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
        
  public function actionChecklogin()
  {
        try
        {
                $response = [];
                $headers = Yii::$app->request->headers;
                $user_id = $headers->get('user_id', '0');
                $token = $headers->get('token','0');
                 
                $myfile = fopen(Yii::$app->params['uploadPath']."/log/ws_log.log", "a") or die("Unable to open file!");       
                $txt = date('Y-m-d H:i:s')." | ".$_SERVER['REMOTE_ADDR']." Input checklogin WS: ".$user_id."_".$token;
                fwrite($myfile, "\n". $txt);
                fclose($myfile);
                
                         
                if(User::checkAuthenticate($user_id,$token)){
                       $response = [
                                          'status' => 'success',
                                          'message' => 'Login valid',
                                          'data' =>  (object)array(),
                            ];
                }else{
                        $response = [
                            'status' => 'error',
                            'auth_failed' => '1',
                            'message' => 'Invalid Login. Please login again!',
                            'data' =>  (object)array(),
                          ];
                    }
           
                  
                $myfile = fopen(Yii::$app->params['uploadPath']."/log/ws_log.log", "a") or die("Unable to open file!");       
                      $txt = date('Y-m-d H:i:s')." | ".$_SERVER['REMOTE_ADDR']." Output UpdateProfile WS: ".json_encode($response);
                      fwrite($myfile, "\n". $txt);
                      fclose($myfile);


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
  



        
	public function actionUpdateprofile()
	{
             try
             {
                $response = [];

                $data = Yii::$app->request->post();
                // $data = Yii::$app->request->getRawBody();
                // $data = json_encode($data);

                $customer_id = isset($data['customer_id']) ? $data['customer_id'] : '';

                $model = User::findOne(['customer_id' => $customer_id]);
                if($model){
                  $oldFile = $model->image;
                  $model->setScenario('customerupdate');
                  if($data)
                  {
                    $model->name= (isset($data['name']) && $data['name'] != '') ? $data['name'] : $model->name;
                    $model->email = (isset($data['email']) && $data['email'] != '') ? $data['email'] : $model->email;
                    $model->country_id = (isset($data['country_id']) && $data['country_id'] != '') ? $data['country_id'] : $model->country_id;
                    $model->state = $state = (isset($data['state']) && $data['state'] != '') ? $data['state'] :(isset($data['state_id']) ? $data['state_id']: $model->state );
                    $model->city = $city = (isset($data['city']) && $data['city'] != '') ? $data['city'] : $model->city;

                    
                        if (!$model->validate()){
                              $errors = $model->errors;
                              if(isset($errors['name'][0])){
                                $errors = isset($errors['name'][0])?$errors['name'][0]:'';
                              }else if(isset($errors['email'][0])){
                                $errors = isset($errors['email'][0])?$errors['email'][0]:'';
                              }else if(isset($errors['password'][0])){
                                $errors = isset($errors['password'][0])?$errors['password'][0]:'';
                              }else if(isset($errors['fb_id'][0])){
                                $errors = isset($errors['fb_id'][0])?$errors['fb_id'][0]:'';
                              }else if(isset($errors['device_type'][0])){
                                $errors = isset($errors['device_type'][0])?$errors['device_type'][0]:'';
                              }else if(isset($errors['device_token'][0])){
                                $errors = isset($errors['device_token'][0])?$errors['device_token'][0]:'';
                              }else{
                                $errors = 'Something went wrong';
                              }
                              
                              $response = [
                                              'status' => '0',
                                              'message' => $errors,
                                              'data' =>  (object)array(),
                                          ];  
                        }
                        else if($model->validate())
                        {
                            $model->save(false);

                            if(sizeof($_FILES)> 0 && $_FILES['image']['error'] == 0)
                            {                     
                                $oldFiles = Yii::$app->params['uploadPath'].''.$oldFile;
                                if(!empty($oldFile) && file_exists($oldFile)) 
                                { 
                                    unlink($oldFiles);
                                }
                                $fn = $model->image = time().'_'.$_FILES['image']['name']; 
                                move_uploaded_file($_FILES['image']['tmp_name'],Yii::$app->params['uploadPath'] . 'customer/' .$model->image);
                                $model->save(false);
                            }  


                            if($customer_id){
                                      $newuser = User::find()->where(['customer_id' => $customer_id])->asArray()->one();
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
                                                    'message' => 'Profile updated successfully!',
                                                    'data' => $newuser
                                      ];

                            }
                            else{
                                $response = [
                                              'status' => '0',
                                              'message' => 'Edit Profile failed!',
                                              'data' =>  (object)array(),
                                            ];
                            }
                        }
                        else
                        {
                            $errors = $model->errors;
                            $response = [
                                          'status' => '0',
                                          'message' => $errors,
                                          'data' =>  (object)array(),
                                      ];  
                        } 
                  }
                  else
                  {
                      $response = [
                                    'status' => '0',
                                    'message' => 'Blank data given!',
                                    'data' =>  (object)array(),
                                  ];
                  }  
                }else{
                  $response = [
                              'status' => '0',
                              'message' => 'User not found',
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


      
  public function actionCitylist()
  {
            try
            {
                $response =  array();
                $headers = Yii::$app->request->headers;
                $user_id = $headers->get('user_id', '0');
                $token = $headers->get('token','0');
                $data = Yii::$app->request->post();
				if($user_id == '0')
                {
                    $access_type = '0';
                }
                else
                {
				    $get_user_role = User::findByID($user_id);
				    $access_type = $get_user_role->access_type;
                }
                $language_id = 1;
                if(isset($data['language_id'])){
                    $language_id = ($data['language_id'] != 0)?$data['language_id']:'1';
                }else{
                    if(User::checkAuthenticate($user_id,$token)){
                        $user = Login::findByIDWithLanguage($user_id);
                        $language_id = $user['language_id'];
                    }
                }


                $myfile = fopen(Yii::$app->params['uploadPath']."/log/ws_log.log", "a") or die("Unable to open file!");       
                $txt = "QA | ".date('Y-m-d H:i:s')." | ".$_SERVER['REMOTE_ADDR']." headers Citylist WS: ".json_encode($headers);
                fwrite($myfile, "\n". $txt);
                fclose($myfile); 

                $myfile = fopen(Yii::$app->params['uploadPath']."/log/ws_log.log", "a") or die("Unable to open file!");       
                $txt = "QA | ".date('Y-m-d H:i:s')." | ".$_SERVER['REMOTE_ADDR']." Input Citylist WS: ".json_encode($data);
                fwrite($myfile, "\n". $txt);
                fclose($myfile); 


                    $user = City::getData($language_id,$access_type);
                    // print_r($user);die;
                    if($user)
                    {
                        $response = [
                          'status' => 'success',
                          'message' => '',
                          'data' => $user
                        ];
                    }
                    else
                    {
                            $response = [
                                'status' => 'error',
                                'message' => 'No City Found',
                                'data' =>  (object)array(),
                              ];
                    }

                $myfile = fopen(Yii::$app->params['uploadPath']."/log/ws_log.log", "a") or die("Unable to open file!");       
                $txt = date('Y-m-d H:i:s')." | ".$_SERVER['REMOTE_ADDR']." Output Citylist WS: ".json_encode($response);
                fwrite($myfile, "\n". $txt);
                fclose($myfile);
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
        
	public function actionLanguage()
	{
        try
        {
                $language_list = Language::getData();

                if(sizeof($language_list))
                {
                    $response = [
                      'status' => 'success',
                      'message' => '',
                      'data' => $language_list
                    ];
                }
                else
                {
                        $response = [
                            'status' => 'error',
                            'message' => 'No Language Found',
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
        
  public function actionTourlist()
  {
            try
            {
                $response =  array();
                $headers = Yii::$app->request->headers;
                $user_id = $headers->get('user_id', '0');
                $token = $headers->get('token','0');
                $data = Yii::$app->request->post();
                $tour_id = isset($data['tour_id'])?$data['tour_id']:'';
                $siteurl = Yii::$app->params['site_url'].'uploaded_file/';
                $count = 0;
                
                $myfile = fopen(Yii::$app->params['uploadPath']."/log/ws_log.log", "a") or die("Unable to open file!");       
                $txt = date('Y-m-d H:i:s')." | ".$_SERVER['REMOTE_ADDR']." | token: ".$token." | user_id: ".$user_id." | tour_id: ".$tour_id." Input TourDetails WS: ".json_encode($data);
                fwrite($myfile, "\n". $txt);
                fclose($myfile); 
               
    
               
                $user = TourLocation::getLoggedData($tour_id);

                if(sizeof($user))
                {                 
                      if($user[0]['is_shared']){

                        $userdata = User::findByID($user_id);
                        if(sizeof($userdata)){
                            $device = $userdata['device'];
                        }else{
                            $device = 'all';
                        }
                        $referral_change = Referrel::find()->where(['user_id' => $user_id, 'tour_id' => $tour_id])->one();
                        $referral_change->device = $device;
                        // print_r($user);die;
                        $referral_change->save(false);
                        

                      }

                        $response = [
                        'status' => 'success',
                        'message' => 'Tour List',
                        'data' => $user
                      ];
                }
                else
                {
                    $response = [
                                'status' => 'error',
                                'message' => 'Tour not found!',
                                'data' =>  (object)array(),
                              ];
                }
                
                $myfile = fopen(Yii::$app->params['uploadPath']."/log/ws_log.log", "a") or die("Unable to open file!");       
                $txt = date('Y-m-d H:i:s')." | ".$_SERVER['REMOTE_ADDR']." Output TourDetails WS: ".json_encode($response);
                fwrite($myfile, "\n". $txt);
                fclose($myfile);

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
       

	public function actionChangepassword()
        {
            try{
                        $response = [];
                        $headers = Yii::$app->request->headers;
                    		$user_id = $headers->get('user_id', '0');
                    		$token = $headers->get('token','0');
                        $data = Yii::$app->request->post();
                        $data['user_id'] = $user_id;
                        $old_password = $data['old_password'];
                        $new_password = $data['new_password'];
                        $myfile = fopen(Yii::$app->params['uploadPath']."/log/ws_log.log", "a") or die("Unable to open file!");       
                        $txt = date('Y-m-d H:i:s')." | ".$_SERVER['REMOTE_ADDR']." Input ChangePassword WS: ".json_encode($data);
                        fwrite($myfile, "\n". $txt);
                        fclose($myfile);

                        
                        
                        if(User::checkAuthenticate($user_id,$token)){
                            if(sizeof($data))
                              {
                                      extract($data);
                                      $model = UserUpdate::findByID($user_id);
                                      $model->attributes=Yii::$app->request->post();
                                      $model->email = $model->email;
                                      $model->user_id = $user_id;
                                      $data['user_id'] = $user_id;
                                    
                                      if (!$model->validate())
                                      {
                                          $errors = $model->errors;
                                          if(isset($errors['old_password'][0])){
                                               $errors = isset($errors['old_password'][0])?$errors['old_password'][0]:'';
                                           }else if(isset($errors['phone'][0])){
                                               $errors = isset($errors['phone'][0])?$errors['phone'][0]:'';
                                           }else if($states){
                                                 $errors = 'Phone number is already taken.';
                                           }

                                          $response = [
                                              'status' => 'error',
                                              'message' => $errors,
                                              'data' =>  (object)array(),
                                            ];	
                      		            }
                               	      else if(isset($old_password) && $old_password != '' ){

                                              $status_old = User::getOldpassword($old_password,$user_id);
                                              if(sizeof($status_old))
                                              {
                                                  if($new_password != $old_password)
                                                  {
                                                        $user = User::findByID($user_id);
                                                        $user->updatePassword($data);
                                                        // $user = User::findByID($user_id);
                                                        $photo = $user->photo;
                                                        if($photo != '')
                                                        {
                                                            $photo = Yii::$app->params['site_url'].'uploaded_file/'.$photo;
                                                        }

                                                        $response = [
                                                            'status' => 'success',
                                                            'message' => 'Password changed successfully!',
                                                            'data' => [
                                                                        'user_id' => (string)$user->user_id,
                                                                        'name' => (string)$user->name,
                                                                        'phone' => (string)$user->phone,
                                                                        'email' => (string)$user->email,
                                                                        'photo' => (string)$photo,
                                                                        'status' => (string)$user->status,
                                                                        'device' => (string)$user->device,
                                                                        'device_token' => (string)$user->device_token,
                                                                      ]
                                                                    ];
                                                           
                                                  }
                                                  else
                                                  {
                                                          $response = [
                                                              'status' => 'error',
                                                              'message' => 'New password cannot be same as old password!.',
                                                              'data' =>  (object)array(),
                                                            ];
                                                  }
                                              }
                                              else
                                              {
                                                      $response = [
                                                          'status' => 'error',
                                                          'message' => 'Old Password is invalid!',
                                                          'data' =>  (object)array(),
                                                        ];
                                              }
                                      }
                                      else
                                      {
                                              $response = [
                                                  'status' => 'error',
                                                  'message' => 'Password must not be blank!',
                                                  'data' =>  (object)array(),
                                                ];
                                      }
                               	
                             	}else{
                             		$response = [
                          	            'status' => 'error',
                          	            'message' => 'Blank data given!',
                          	            'data' =>  (object)array(),
                          	          ];
                             	}

                          }else{
                            $response = [
                                      'status' => 'error',
                                      'auth_failed' => '1',
                                      'message' => 'Invalid login! Please login again!',
                                      'data' =>  (object)array(),
                                    ];
                          }
                     	
              	          $myfile = fopen(Yii::$app->params['uploadPath']."/log/ws_log.log", "a") or die("Unable to open file!");       
                          $txt = date('Y-m-d H:i:s')." | ".$_SERVER['REMOTE_ADDR']." Output ChangePassword WS: ".json_encode($response);
                          fwrite($myfile, "\n". $txt);
                          fclose($myfile);
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
        
        
        public function actionLogout()
        {
           try
           {
            $response = [];
            $headers = Yii::$app->request->headers;
            $user_id = $headers->get('user_id', '0');
            $token = $headers->get('token','0');

            // $data = Yii::$app->request->post();
            $data['user_id'] = $user_id;
            $data['token'] = $token;
            
            $myfile = fopen(Yii::$app->params['uploadPath']."/log/ws_log.log", "a") or die("Unable to open file!");       
            $txt = date('Y-m-d H:i:s')." | ".$_SERVER['REMOTE_ADDR']." Input Logout WS: ".json_encode($data);
            fwrite($myfile, "\n". $txt);
            fclose($myfile);
		
            if(isset($user_id) && $user_id != '' && isset($token) && $token != '')
            {
                           $user = User::findByID($user_id);
                            if(!empty($user))
                            {
                                    $user = Login::logout($user_id,$token);
                                    $response = [
                                        'status' => 'success',
                                        'message' => 'You are  logged out!',
                                        'data' =>  (object)array(),
                                      ];
                            }
                            else
                            {
                                    $response = [
                                        'status' => 'error',
                                        'message' => 'This user does not exist!',
                                        'data' =>  (object)array(),
                                      ];
                            }
            }
            else
            {
                    $response = [
                        'status' => 'error',
                        'message' => 'Blank data given!',
                        'data' =>  (object)array(),
                      ];
            }
    	
	    $myfile = fopen(Yii::$app->params['uploadPath']."/log/ws_log.log", "a") or die("Unable to open file!");       
            $txt = date('Y-m-d H:i:s')." | ".$_SERVER['REMOTE_ADDR']." Output Logout WS: ".json_encode($response);
            fwrite($myfile, "\n". $txt);
            fclose($myfile);
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
        
}