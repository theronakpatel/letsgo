<?php
namespace api\modules\v1\models;

use Yii;
use yii\base\NotSupportedException;
use yii\filters\auth\HttpBasicAuth;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\web\UploadedFile;
date_default_timezone_set("UTC"); 

/**
 * User model
 *
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    private $_user;

    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_customer';
    }

    
    public static function primaryKey()
    {
        return ['customer_id'];
    }

    public function rules()
    {
        return [
            [['name','email','password','device_type','device_token'], 'required', 'on' => 'emaillogin'],
            [['fb_id','device_type','device_token'], 'required', 'on' => 'fblogin'],
            [['customer_id'], 'required', 'on' => 'customerupdate'],
            [['password'], 'string', 'min' => 6],
            [['referral_code','image'], 'string'],
            [['password','password_reset_token','country_id','city','state','register_date'],'safe'],
            [['email'], 'email','message'=>"The email isn't correct"],
            [['email'], 'unique'],
            [['fb_id'], 'unique','message'=>"Facebook User is already register. Please login."],
        ];
    }
    
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
        ];
        return $behaviors;
    }

    public function setAttribute12()
    {
         
        $user = Yii::createObject(User::className());
        $user->setScenario('register');
        $user->setAttributes($user->attributes);
        return $user;
    }
    
    public static function findIdentity($customer_id) {
        $user = self::find()
                ->where([
                    "customer_id" => $customer_id
                ])
                ->one();

        if (!count($user)) {
            return null;
        }
        return new static($user);
    }



    /**
     * @inheritdoc
     */
   /* public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }*/
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }
    

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByemail($phone)
    {
        return static::findOne(['phone' => $phone]);
    }
    public static function findByphone($phone)
    {
        return static::findOne(['phone' => $phone]);
    }
    public static function findByID($customer_id)
    {
        return static::findOne(['customer_id' => $customer_id]);

    }

     public static function findByIDWithLanguage($customer_id)
    {
      $query = new \yii\db\Query;
      $query->select(['*'])
      ->from('tbl_customer')
      ->join('JOIN','hoi_languages','hoi_languages.language_id = tbl_customer.language_id')->where(['customer_id'=>$customer_id]);
      $command = $query->createCommand();
      $data = $command->queryOne(); 

      return $data;

    }


    public static function getPhonenumber($tour_id,$customer_id)
    {
      // extract($data);
      $query = new \yii\db\Query;
      $query->select([
                          'GROUP_CONCAT(phone_number) as phone_number',
                          ])
        ->from('hoi_referrel')
        ->where([
              "customer_id" => $customer_id,
          ])
        ->andWhere([
              "tour_id" => $tour_id,
          ]); 
          
      $command = $query->createCommand();
      $data = $command->queryOne(); 
      
      return $data['phone_number'];

    }

    public static function checkShared($tour_id,$customer_id)
    {
      // extract($data);
      $query = new \yii\db\Query;
      $user = static::findOne(['customer_id' => $customer_id]);
      $device = isset($user['device'])?$user['device']:'all';
      $phone = isset($user['phone'])?$user['phone']:'none';
      $without_91 = str_replace("+91","",$phone);


      $query->select([
                                'hr.*',
                                ])
              ->from('hoi_referrel hr')
              ->join('JOIN','hoi_purchase_tours hpt','hpt.purchase_tour_id = hr.purchase_tour_id')
              ->where(["hpt.customer_id" => $customer_id])
              ->andWhere([
                        'or',
                        ['hr.phone_number' => $without_91],
                        ['hr.phone_number' => $phone]
                      ])
              ->andWhere([
                        'or',
                        ['hr.device' => 'all'],
                        ['hr.device' => 'web'],
                        ['hr.device' => $device]
                      ])
              ->andWhere(["hr.tour_id" => $tour_id])
              // ->andWhere(["hpt.device" => $device])
              ->andWhere([">","hpt.expiry_date",date('Y-m-d H:i:s')]);


    /*  $query->select([
                          '*',
                          ])
        ->from('hoi_referrel')
        ->where([
              "customer_id" => $customer_id,
          ])
        ->andWhere([
              "tour_id" => $tour_id,
          ]); */
          
      $command = $query->createCommand();
      $data = $command->queryOne(); 
// print_r($data);die;
      if(empty($data)){
        return "0";
      }else{
        return "1";
      }

    }

    public static function getTotalShared($tour_id,$customer_id)
    {

      $user = static::findOne(['customer_id' => $customer_id]);
      if(sizeof($user)){
          $device = $user['device'];

          $query = new \yii\db\Query;

            $query->select([
                                'hr.*',
                                ])
              ->from('hoi_referrel hr')
              ->join('INNER JOIN','hoi_purchase_tours hpt','hpt.purchase_tour_id = hr.purchase_tour_id')
              ->where(["hpt.customer_id" => $customer_id])
              ->andWhere(["hpt.tour_id" => $tour_id])
              ->andWhere(["hpt.device" => $device])
              ->andWhere([">","hpt.expiry_date",date('Y-m-d H:i:s')]);

              
          $command = $query->createCommand();
          $data = $command->queryAll(); 

           return sizeof($data);

        }else{
          return 0;
        }

    }


    public static function checkReferred($tour_id,$customer_id)
    {
       // extract($data);
      $user = static::findOne(['customer_id' => $customer_id]);
      if(sizeof($user) > 0){
        $phone = $user['phone'];
        $query = new \yii\db\Query;

        $user = static::findOne(['customer_id' => $customer_id]);
        $device = $user['device'];

        $without_91 = str_replace("+91","",$phone);


      /*   $query->select([
                                'hr.*',
                                ])
              ->from('hoi_referrel hr')
              ->join('JOIN','hoi_purchase_tours hpt','hpt.purchase_tour_id = hr.purchase_tour_id')
              ->where(["=","hr.phone_number",$phone])
              ->andWhere(["=","hr.tour_id",$tour_id])
              ->andWhere(["hpt.device" => $device])
              ->andWhere([">","hpt.expiry_date",date('Y-m-d H:i:s')]); */

$query = Tourlocation::find()
            ->select([
            'ht.*'
            ])
            ->from('hoi_tours ht')
            ->join('JOIN','hoi_tour_media htm','htm.tour_id = ht.tour_id')
            ->join('JOIN','hoi_referrel hr','hr.tour_id = ht.tour_id')
            ->join('JOIN','hoi_purchase_tours hpt','hpt.purchase_tour_id = hr.purchase_tour_id')
            ->join('JOIN','tbl_customer hu','hu.customer_id = hr.customer_id')
            ->join('JOIN','hoi_languages hl','hl.language_id = ht.language_id')
            // ->where(["=","hr.phone_number",$phone])
            ->where([
                        'or',
                        ['hr.phone_number' => $without_91],
                        ['hr.phone_number' => $phone]
                      ])
            ->andWhere([
                        'or',
                        ['hr.device' => 'all'],
                        ['hr.device' => 'web'],
                        ['hr.device' => $device]
                      ])
            ->andWhere([">","hpt.expiry_date",date('Y-m-d H:i:s')])
            ->andWhere(["=","hpt.tour_id", $tour_id ]);



       /* $query->select([
                            '*',
                            ])
          ->from('hoi_referrel hr')
          ->where(["like","hr.phone_number",$phone])
          ->andWhere(["=","hr.tour_id",$tour_id]);*/
            
        $command = $query->createCommand();
        $data = $command->queryOne(); 
         // print_r($data);die;
        if(empty($data)){
          return "0";
        }else{
          return "1";
        }
      }else{
        return "0";
      }

    }

    public static function checkPaid($tour_id,$customer_id)
    {

      $user = static::findOne(['customer_id' => $customer_id]);
      if(sizeof($user)){

        $device = $user['device'];

        $query = new \yii\db\Query;
        $query->select([
                            '*',
                            ])
          ->from('hoi_purchase_tours')
          ->where(["customer_id" => $customer_id])
          ->andWhere(["tour_id" => $tour_id])
          ->andWhere(["device" => $device])
          ->andWhere([">","expiry_date",date('Y-m-d H:i:s')]);
          // ->andWhere(['or',['device'=> $device]]);
            
        $command = $query->createCommand();
        $data = $command->queryOne(); 
         // print_r($command);die;
        if(empty($data)){
          return (string)"0";
        }else{
          return (string)"1";
        }
      }else{
          return (string)"0";
      }

    }
    public static function getPaidDates($tour_id,$customer_id)
    {
       // extract($data);
      $query = new \yii\db\Query;

      $user = static::findOne(['customer_id' => $customer_id]);
      $device = isset($user['device'])?$user['device']:'';

      /*$query->select([
                          '*',
                          ])
        ->from('hoi_purchase_tours')
        ->where([
              "customer_id" => $customer_id,
          ])
        ->andWhere([
              "tour_id" => $tour_id,
          ])
        ->andWhere([">","expiry_date",date('Y-m-d H:i:s')]); */

        $query->select([
                            '*',
                            ])
          ->from('hoi_purchase_tours')
          ->where(["customer_id" => $customer_id])
          ->andWhere(["tour_id" => $tour_id])
          ->andWhere(["device" => $device])
          ->andWhere([">","expiry_date",date('Y-m-d H:i:s')]);
          
      $command = $query->createCommand();
      $data = $command->queryOne(); 
 
      if(empty($data)){
        return array();
      }else{
        return $data;
      }

    }
    public static function getMaxavailabesharelimit($tour_id)
    {
       $query = new \yii\db\Query;
        $setting_query = Settings::find()->select([
                          'setting_value',
                          ])
        ->from('hoi_settings')
        ->where(['=','setting_name','MAX_REFERRAL_USER']);

         $command11 = $setting_query->createCommand();
        $data11 = $command11->queryOne();
        $var= $data11['setting_value'];
        $headers = Yii::$app->request->headers;
        $customer_id = $headers->get('customer_id', '0');
        
        if($customer_id != 0 ){
              $user = static::findOne(['customer_id' => $customer_id]);
              $device = $user['device'];

        		  $query = new \yii\db\Query; 
        		  /*$query->select([
        				    '*',
        				    ])
        		  ->from('hoi_referrel')
        		  ->where([
        			"customer_id" => $customer_id,
        		    ])
        		  ->andWhere([
        			"tour_id" => $tour_id,
        		    ]); */

              $query->select([
                              'hr.*',
                              ])
            ->from('hoi_referrel hr')
            ->join('JOIN','hoi_purchase_tours hpt','hpt.purchase_tour_id = hr.purchase_tour_id')
            ->where(["hr.customer_id" => $customer_id])
            ->andWhere(["hr.tour_id" => $tour_id])
            ->andWhere(["hpt.device" => $device])
            ->andWhere([">","hpt.expiry_date",date('Y-m-d H:i:s')]);

        		    
        		$command = $query->createCommand();
        		$data = $command->queryAll(); 
        		$size = count($data);

      }
      else
      {
         $size = $var; 
      }
	      $remaining = $var - $size;
		if($remaining < 0){
		  return "0";
		}else{
		  return (string)$remaining;
		}
    }


    public static function getContactofsharedtour($tour_id,$customer_id)
    {
       // extract($data);
     $query = new \yii\db\Query;
      /*$query->select([
                          '*',
                          ])
        ->from('hoi_referrel')
        ->where([
              "customer_id" => $customer_id,
          ])
        ->andWhere([
              "tour_id" => $tour_id,
          ]); */

      $user = static::findOne(['customer_id' => $customer_id]);
      $device = $user['device'];

 
      $query->select([
                        'hr.*',
                        ])
      ->from('hoi_referrel hr')
      ->join('INNER JOIN','hoi_purchase_tours hpt','hpt.purchase_tour_id = hr.purchase_tour_id')
      ->where(["hpt.customer_id" => $customer_id])
      ->andWhere(["hpt.tour_id" => $tour_id])
      ->andWhere(["hpt.device" => $device])
      ->andWhere([">","hpt.expiry_date",date('Y-m-d H:i:s')]);
          
      $command = $query->createCommand();
      $data = $command->queryAll(); 
      
      return $data;
      

    }

    public static function checkAuthenticate($customer_id,$token)
    {
      $query = new \yii\db\Query;
      $query->select([
                          '*',
                          ])
        ->from('auth_key')
        ->where([
              "customer_id" => $customer_id,
              "auth_key" => $token
          ]); 
          
      $command = $query->createCommand();
      $data = $command->queryOne(); 

      if(empty($data)){
        return 0;
      }else{
        return 1;
      }

    }

    public static function checkEmail($data)
    {
      extract($data);
      $query = new \yii\db\Query;
      $query->select([
                          'customer_id',
                          ])
        ->from('tbl_customer')
        ->where([
              "phone" => $phone
          ])
        ->andWhere(['!=', 'customer_id', $customer_id]); 
          
      $command = $query->createCommand();
      $data = $command->queryOne(); 
      if(empty($data)){
        return TRUE;
      }else{
        return FALSE;
      }

    } 

    
    public static function getData($customer_id)
    {
      $query = new \yii\db\Query;
      $query->select([
                          '*',
                          ])
        ->from('tbl_customer')
        ->where([
              "customer_id" => $customer_id
          ]); 
          
      $command = $query->createCommand();
      $data = $command->queryOne(); 

      if(empty($data)){
        return array();
      }else{
        return $data;
      }

    }
    

    /*public static function findByemail($phone) {
 
        if (!static::isPasswordResetTokenValid($phone)) {
            return null;
        }

        return static::findOne([
            'phone' => $phone
        ]);
    }*/


    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        // $hash = Yii::$app->getSecurity()->generatePasswordHash($password);
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
    public function generatePassHash($password)
    {
        return $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    public function getNewAuthKey()
    {
        return Yii::$app->security->generateRandomString();
    }

    public function updateDevice($customer_id,$device_token,$device_type)
    {
        Yii::$app->db->createCommand('UPDATE tbl_customer SET device_type = \''.$device_type.'\',device_token = \''.$device_token.'\' WHERE customer_id=\''.$customer_id.'\'')->execute();
        return TRUE;

    }
   
    public function updatePasswordResetToken($password_reset_token,$customer_id,$email)
    {
 

        Yii::$app->db->createCommand('UPDATE tbl_customer SET password_reset_token = \''.$password_reset_token.'\' WHERE customer_id=\''.$customer_id.'\'')->execute();
        Yii::$app
            ->mailer
            ->compose(
              ['html' => 'passwordResetToken-html'],
                ['password_reset_token' => $password_reset_token]
            )
            ->setFrom(['priyanka.sah@ecosmob.com'])
            ->setTo($email)
            ->setSubject('Password reset for ' . Yii::$app->name)
            ->send();
            

        return TRUE;

    }
    
    public function updateAuthKey($auth_key,$device,$device_token,$customer_id)
    {
          
        Yii::$app->db->createCommand("INSERT INTO `auth_key` (`customer_id`, `auth_key`, `device`, `device_token`, `created_date`) VALUES ( '$customer_id', '$auth_key','$device','$device_token', NOW())")->execute();
        return TRUE;

    }
    public function updatePassHash($password,$customer_id)
    {
        Yii::$app->db->createCommand('UPDATE tbl_customer SET password = \''.$password.'\' WHERE customer_id=\''.$customer_id.'\'')->execute();
        return TRUE;

    }
    public function updatePoints($user_credit,$customer_id)
    {
        Yii::$app->db->createCommand("UPDATE `tbl_customer` SET user_credit = user_credit + '$user_credit' WHERE customer_id = '$customer_id'")->execute();
        return TRUE;

    }
    
    public function reducePoint($user_credit,$customer_id)
    {
        Yii::$app->db->createCommand("UPDATE `tbl_customer` SET user_credit = user_credit - '$user_credit' WHERE customer_id = '$customer_id'")->execute();
        return TRUE;

    }

    public function updateProfile($data)
    {
        extract($data);

       Yii::$app->db->createCommand()
             ->update('tbl_customer', [
                                    'name' => $name,
                                    'phone' => $phone,
                                    
                                  ],['customer_id' => $customer_id])
             ->execute();

        return TRUE;

    }
    public function updatePassword($data)
    {
        extract($data);
    
        $new_password = isset($new_password)?md5($new_password):'';

        if($new_password != '')    
        {
          Yii::$app->db->createCommand()
             ->update('tbl_customer', [
                                    'password' => $new_password,
                                  ],['customer_id' => $customer_id])
             ->execute();
        }

        return TRUE;

    }
       

    public function addRegister($data)
    {
        extract($data);
        $phone = isset($phone)?$phone:'';
        $password = isset($password)?md5($password):'';
        $date = date('Y-m-d H:i:s');

        Yii::$app->db->createCommand("INSERT INTO `tbl_customer` 
                 (`name`, `email`,   `phone`, `password`,`created_date`) 
          VALUES ('$name',  '$email','$phone','$password',NOW())")->execute();

        $id = Yii::$app->db->getLastInsertID();
        if($id){
            return $id;
        }else{
            return FALSE;
        }
    }

    
    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }


    public function getPasswordSecurityToken()
    {
        return $this->password_reset_token = Yii::$app->security->generateRandomString(). '_' . time();
    }


    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save(false);
    }

    public function checkToken($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Password reset token cannot be blank.');
        }
        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidParamException('Wrong password reset token.');
        }
        parent::__construct($config);
    }
//    public static function removeIdentityByAccessToken($token)
//    {
//        $record = static::findIdentityByAccessToken($token);
//        $record->auth_key = NULL;
//        $record->update();
//    }
       
       public function getMediaimage($tour_id)
       {
            $query = new \yii\db\Query;
            $siteurl = Yii::$app->params['site_url'].'uploaded_file/tour/media/';
            $siteurl_thumb = Yii::$app->params['site_url'].'uploaded_file/tour/media/thumb/thumb_';

            $query->select([
                                'htm.*',
                                "CASE
                                  htm.media_type
                                  WHEN 'video' THEN concat('".Yii::$app->params['JW_videopath']."',htm.video_key,'.mp4') 
                                  WHEN 'audio' THEN IF(htm.video_key IS NULL or htm.video_key = '', if(htm.media_name is null or htm.media_name = '','',concat('".$siteurl."',htm.media_name)),concat('".Yii::$app->params['JW_videopath']."',htm.video_key,'.m4a') )
                                  ELSE 
                                  if(htm.media_name is null or htm.media_name = '','',concat('".$siteurl."',htm.media_name))
                                  END AS media_url",

                                "CASE
                                  htm.media_type
                                  WHEN 'video' THEN concat('".Yii::$app->params['JW_thumbpath']."',htm.video_key,'.jpg') 
                                  WHEN 'audio' THEN ''
                                  ELSE 
                                  CONCAT('".$siteurl_thumb."',htm.media_name)
                                  END AS thumb_url",
                                  'htm.media_type'
                                ])
              ->from('hoi_tour_media htm')
              ->where(['htm.tour_id' => $tour_id])
              ->andWhere(['<>','htm.media_type','audio']);

            $command = $query->createCommand();
            $data = $command->queryAll(); 


            if(empty($data)){
              return array();
            }else{
              foreach ($data as $key => $value) {
                $data[$key]['position']  = ($key+1);
              }
              return $data;
            }
       }

        public function getIntroAudio($tour_id)
       {
            $query = new \yii\db\Query;
            $siteurl = Yii::$app->params['site_url'].'uploaded_file/tour/media/';
            $siteurl_thumb = Yii::$app->params['site_url'].'uploaded_file/tour/media/thumb/thumb_';

            $query->select([
                                'htm.*',
                                "CASE
                                  htm.media_type
                                  WHEN 'video' THEN concat('".Yii::$app->params['JW_videopath']."',htm.video_key,'.mp4') 
                                  WHEN 'audio' THEN IF(htm.video_key IS NULL or htm.video_key = '', if(htm.media_name is null or htm.media_name = '','',concat('".$siteurl."',htm.media_name)),concat('".Yii::$app->params['JW_videopath']."',htm.video_key,'.m4a') ) 
                                  ELSE 
                                  if(htm.media_name is null or htm.media_name = '','',concat('".$siteurl."',htm.media_name))
                                  END AS media_url",

                                "CASE
                                  htm.media_type
                                  WHEN 'video' THEN concat('".Yii::$app->params['JW_thumbpath']."',htm.video_key,'.jpg') 
                                  WHEN 'audio' THEN ''
                                  ELSE 
                                  CONCAT('".$siteurl_thumb."',htm.media_name)
                                  END AS thumb_url",
                                  'htm.media_type'
                                ])
              ->from('hoi_tour_media htm')
              ->where(['htm.tour_id' => $tour_id,'htm.media_type'=>'audio']);

            $command = $query->createCommand();
            $data = $command->queryAll(); 

            


            if(empty($data)){
              return array();
            }else{
              foreach ($data as $key => $value) {
                $data[$key]['position']  = ($key+1);
              }
              return $data;
            }
       }



       public function getTourIcons($tour_id)
       {
            $query = new \yii\db\Query;
            $siteurl = Yii::$app->params['site_url'].'uploaded_file/places/';
 
            $query->select([
                                "hp.place_id",
                                "hp.place_name",
                                "hp.place_icon AS media_name",
                                "concat('".$siteurl ."',hp.place_icon ) AS media_url"
                                ])
              ->from('hoi_tour_point htp')
              ->join('JOIN','hoi_places hp','hp.place_id = htp.place_id')
              ->where(['htp.tour_id' => $tour_id,'hp.status' => 'active'])
              ->groupBy('hp.place_id');
              // ->andWhere(['<>','htm.media_type','audio']);

            $command = $query->createCommand();
            $data = $command->queryAll(); 
            if(empty($data)){
              return array();
            }else{
              // $newdata = array();
              // foreach ($data as $key => $value) {
              //     array_push($newdata, $value['media_url']);
              // }
              // $newdata = array_unique($newdata);
              // $newdata = array_values($newdata);
              return $data;
            }
       }

       
       public function getTourpoint($tour_id)
       {
            $query = new \yii\db\Query;
            $query->select([
                                '*',
                                ])
              ->from('hoi_tour_point')
              ->where(['tour_id' => $tour_id]);

            $command = $query->createCommand();
            $data = $command->queryAll(); 
            if(empty($data)){
              return array();
            }else{
              return $data;
            }
       }   
}
