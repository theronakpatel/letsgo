<?php
namespace backend\models;

use Yii;
use backend\models\User;


/**
 * Login form
 */
class ResetForm extends \yii\db\ActiveRecord
{
     public $verify_password;
    
    
    public function rules()
    {
        return [
            [['password','verify_password'], 'required','message'=>'This field cannot be empty'],
            ['password_reset_token', 'string', 'min' => 6],
            ['verify_password','compare','compareAttribute'=>'password','message'=>'Both password must be same'],
        ];
    }
    
    public static function tableName()
    {
        return 'tbl_customer';
    }


    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    

    /**
     * @inheritdoc
     */
    

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

     public function setPassword($user_password)
    {
        $this->password_hash = ($user_password);
        $this->admin_password = ($user_password);
    }

    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->admin_password);
        $user->removePasswordResetToken();

        return $user->save(false);
    }
   
    public function rsPassword($token)
    {
    $query = new \yii\db\Query;
      $query->select([
                      '*',
                     ])
        ->from('tbl_customer')
        ->where([
              "password_reset_token" => $token
              
          ]) ; 
      $command = $query->createCommand();
      $data = $command->queryOne();    
      return $data;
    }
}