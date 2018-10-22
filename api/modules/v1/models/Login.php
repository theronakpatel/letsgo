<?php
namespace api\modules\v1\models;

use Yii;
use yii\base\NotSupportedException;
use yii\filters\auth\HttpBasicAuth;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
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
class Login extends ActiveRecord implements IdentityInterface
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
            [['password', 'email','device_type','device_token'], 'required', 'on' => 'emaillogin'],
            [['fb_id','device_type','device_token'], 'required', 'on' => 'fblogin'],
            [['device_token'], 'string'],
            [['referral_code','image'], 'string'],
            [['promotion_points','fb_id'], 'safe'],
            [['email','phone','password','device_token','password_reset_token'],'safe'],
            [['email'], 'email','message'=>"The email isn't correct"],
        ];
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
        return FALSE;
      }else{
        return TRUE;
      }

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
    

    /**
     * @inheritdoc
     */


    /**
     * @inheritdoc
     *//*
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }
    */
    public static function findIdentity($id) {
        // $id = 2;
        // print_r($id);exit();
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
    public static function findByemail($email)
    {
        return static::findOne(['email' => $email]);
    }

    public static function findByphone($phone)
    {
        $query = new \yii\db\Query;
        $query->select(['*'])->from('tbl_customer')->where(["phone" => $phone]);
        $command = $query->createCommand();
        $data = $command->queryOne(); 
        return $data;
    }
     
    public static function findemail($email)
    {
        $query = new \yii\db\Query;
        $query->select(['*'])->from('tbl_customer')->where(["email" => $email]);
        $command = $query->createCommand();
        $data = $command->queryOne(); 

        return $data;
    }
    
    public static function findByID($customer_id)
    {
        return static::findOne(['customer_id' => $customer_id]);
    }
    
    public static function findByFBID($fb_id)
    {
        return static::findOne(['fb_id' => $fb_id]);
    }
    

    
    public static function checkPhone($data)
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
    public static function logout($customer_id,$auth_key) 
    {
      $query = new \yii\db\Query;
      Yii::$app->db->createCommand("UPDATE tbl_customer SET auth_key = '' WHERE customer_id = '$customer_id' ")->execute();
      Yii::$app->db->createCommand("DELETE FROM `auth_key` WHERE customer_id = '$customer_id' AND  auth_key = '$auth_key' ")->execute();
      return TRUE;      
    }

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
      if( md5($password) == $this->password){
        return TRUE;
      }
      return FALSE;
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

    
    public function updatePasswordResetToken($password_reset_token,$customer_id,$email)
    {
 
        Yii::$app->db->createCommand('UPDATE tbl_customer SET password_reset_token = \''.$password_reset_token.'\' WHERE customer_id=\''.$customer_id.'\' AND email=\''.$email.'\'')->execute();
        Yii::$app
            ->mailer
            ->compose(
              ['html' => 'passwordResetToken-html'],
              ['password_reset_token' => $password_reset_token]
            )
            ->setFrom(['eronax59@gmail.com'])
            ->setTo($email)
            ->setSubject('Password reset request')
            ->send();
            

        return TRUE;

    }
    public function deleteAuthKey($customer_id)
    {
          
        Yii::$app->db->createCommand("DELETE FROM `auth_key` WHERE customer_id= '$customer_id' " )->execute();
 
        return TRUE;

    }
    public function updateAuthKey($auth_key,$customer_id)
    {
          
        Yii::$app->db->createCommand('UPDATE tbl_customer SET auth_key = "'.$auth_key.'" WHERE customer_id= "'.$customer_id.'"')->execute();
        Yii::$app->db->createCommand("INSERT INTO `auth_key` (`customer_id`, `auth_key`, `created_date`) VALUES ( '$customer_id', '$auth_key', NOW())")->execute();
        return TRUE;
    }
    public function updatePassword($data)
    {
        extract($data);
        $password = isset($password)?md5($password):'';
        if($password != ''){
          Yii::$app->db->createCommand()
             ->update('tbl_customer', [
                                    'password' => $password,
                                  ],['customer_id' => $customer_id])
             ->execute();
        }

        return TRUE;

    }

    public function addRegister($data)
    {
        extract($data);
        $phone = isset($phone)?$phone:'';
        $app_type = 'M';
        $language_id = isset($language_id)?$language_id:'1';
        if(trim($language_id) == '')
          $language_id = '1';

         $password = isset($password)?md5($password):'';
      
        $date = date('Y-m-d H:i:s');
        
        Yii::$app->db->createCommand("INSERT INTO `tbl_customer` (`name`, `email`,`phone`,`password`,`status`,`created_date`,`app_type`,`language_id`) 
          VALUES ('$name',  '$email','$phone','$password','A',NOW(),'$app_type','$language_id')")->execute();

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
        //echo Yii::$app->security->generateRandomString(). '_' . time(); die;
        return Yii::$app->security->generateRandomString(). '_' . time();
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
  
}
