<?php
namespace api\modules\v1\models;

use Yii;
use yii\base\NotSupportedException;
use yii\filters\auth\HttpBasicAuth;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $email
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class ForgotForm extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    public $password;
    private $_user;

    public function init()
    {
        parent::init();
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
            [['email'], 'required'],
        ];
    }
 


    /**
     * @inheritdoc
     */
    /*public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }*/

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
    
    public static function findByphone($phone)
    {
        $query = new \yii\db\Query;
        $query->select(['*'])->from('tbl_customer')->where(["phone" => $phone]);
        $command = $query->createCommand();
        $data = $command->queryOne(); 

        return $data;
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
//    public static function findByemail($email)
//    {
//        return static::findOne(['email' => $email]);
//    }
    public static function findByemail($email)
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

    public static function checkEmail($data)
    {
      extract($data);
      $query = new \yii\db\Query;
      $query->select([
                          'customer_id',
                          ])
        ->from('tbl_customer')
        ->where([
              "email" => $email
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

    /*public static function findByemail($email) {
 
        if (!static::isPasswordResetTokenValid($email)) {
            return null;
        }

        return static::findOne([
            'email' => $email
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
    public function validatePassword($user_password)
    {
        // $hash = Yii::$app->getSecurity()->generatePasswordHash($user_password);
        return Yii::$app->security->validatePassword($user_password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($user_password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($user_password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }
    public function generatePassHash($user_password)
    {
        return $this->password_hash = Yii::$app->security->generatePasswordHash($user_password);
    }

    public function getNewAuthKey()
    {
        return $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function updatePasswordResetToken($password_reset_token,$customer_id,$email)
    {
        $noreplayEmail = Yii::$app->params['noreplayEmail'];
        Yii::$app->db->createCommand('UPDATE tbl_customer SET password_reset_token = \''.$password_reset_token.'\' WHERE customer_id=\''.$customer_id.'\' AND email=\''.$email.'\'')->execute();
        
        $data = self::find()
                ->where([
                    "customer_id" => $customer_id
                ])
                ->asArray()->one();

        Yii::$app
            ->mailer
            ->compose(
              ['html' => 'passwordResetToken-html'],
              ['name' => $data['name'],'password_reset_token' => $password_reset_token,]
            )
            ->setFrom($noreplayEmail)
            ->setTo($email)
            ->setSubject('Password reset request')
            ->send();

        return TRUE;

    }
    public function updateAuthKey($auth_key,$customer_id)
    {
        Yii::$app->db->createCommand('UPDATE tbl_customer SET auth_key = \''.$auth_key.'\' WHERE customer_id=\''.$customer_id.'\'')->execute();
        return TRUE;

    }
    public function updatePassHash($password_hash,$customer_id)
    {
        Yii::$app->db->createCommand('UPDATE tbl_customer SET password_hash = \''.$password_hash.'\' WHERE customer_id=\''.$customer_id.'\'')->execute();
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
                                    'user_firstname' => $user_firstname,
                                    'user_lastname' => $user_lastname,
                                    'email' => $email,
                                    'user_phone' => $user_phone
                                  ],['customer_id' => $customer_id])
             ->execute();

        return TRUE;

    }
    public function updatePassword($data)
    {
        extract($data);
        $user_password = isset($user_password)?md5($user_password):'';
        if($user_password != ''){
          Yii::$app->db->createCommand()
             ->update('tbl_customer', [
                                    'user_password' => $user_password,
                                  ],['customer_id' => $customer_id])
             ->execute();
        }

        return TRUE;

    }
    public function updateBuyingrate($data)
    {
        extract($data);
        $user_buyingrate = isset($user_buyingrate)?trim($user_buyingrate):'';
        if($user_buyingrate != ''){
          Yii::$app->db->createCommand()
             ->update('tbl_customer', [
                                    'user_buyingrate' => $user_buyingrate,
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

        Yii::$app->db->createCommand("INSERT INTO `tbl_customer` "
                . "( `name`,`email`, `phone`, `password`, `auth_key`, `status`,`created_date`) VALUES "
                . "('$name', '$email', '$phone', '$password', '$auth_key','$date')")->execute();

        $id = Yii::$app->db->getLastInsertID();

        if($id){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function addTransaction($data)
    {
        extract($data);
        $ctransaction_userid = isset($customer_id)?$customer_id:'';
        $ctransaction_paypalid = isset($ctransaction_paypalid)?$ctransaction_paypalid:'';
        $ctransaction_amount = isset($ctransaction_amount)?$ctransaction_amount:'0';
        $ctransaction_status = isset($ctransaction_status)?$ctransaction_status:'failed';
        $ctransaction_datetime = date('Y-m-d H:i:s');

        Yii::$app->db->createCommand("INSERT INTO `tbl_credittransaction` 
          ( `ctransaction_userid`, `ctransaction_paypalid`, `ctransaction_amount`, `ctransaction_status`, `ctransaction_datetime`) 
   VALUES ('$ctransaction_userid', '$ctransaction_paypalid', '$ctransaction_amount', '$ctransaction_status', '$ctransaction_datetime')")->execute();

        $id = Yii::$app->db->getLastInsertID();

        if($id){
            return TRUE;
        }else{
            return FALSE;
        }
    }
public function addUsageTransaction($data)
    {
        extract($data);
        
        $utransaction_userid = isset($customer_id)?$customer_id:'';
        $utransaction_wifiid = isset($utransaction_wifiid)?$utransaction_wifiid:'';
        $utransaction_start_time = isset($utransaction_start_time)?$utransaction_start_time:'0';
        $utransaction_end_time = isset($utransaction_end_time)?$utransaction_end_time:'0';
        $utransaction_wifiusage = isset($utransaction_wifiusage)?$utransaction_wifiusage:'0';
        $utransaction_amount = isset($utransaction_amount)?$utransaction_amount:'0';
        $utransaction_datetime = date('Y-m-d H:i:s');

        Yii::$app->db->createCommand("INSERT INTO `tbl_usagetransaction` 
          ( `utransaction_userid`, `utransaction_wifiid`, `utransaction_start_time`, `utransaction_end_time`, `utransaction_wifiusage`, `utransaction_amount`, `utransaction_datetime`) 
   VALUES ('$utransaction_userid', '$utransaction_wifiid', '$utransaction_start_time', '$utransaction_end_time', '$utransaction_wifiusage', '$utransaction_amount', '$utransaction_datetime')")->execute();

        $id = Yii::$app->db->getLastInsertID();

        if($id){
            return TRUE;
        }else{
            return FALSE;
        }
    }



    public static function getTransactionHistory($customer_id) {

      $query = new \yii\db\Query;
      $query->select([
                      'ctransaction_id',
                      'ctransaction_paypalid',
                      'ctransaction_amount',
                      'ctransaction_status',
                      'ctransaction_datetime',
                     ])
        ->from('tbl_credittransaction')
        ->where([
              "ctransaction_userid" => $customer_id
          ])
        ->orderBy(["ctransaction_datetime"=> SORT_DESC]) ; 
          
      $command = $query->createCommand();
         // print_r($customer_id);exit();
      $data = $command->queryAll(); 
      

      return $data;
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


}
