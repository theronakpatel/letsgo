<?php 
namespace api\modules\v1\models;
    
    use Yii;
    use yii\base\Model;
    use frontend\models\Login;
    
    
    class PasswordForm extends Model{
        public $admin_oldpass;
        public $password;
        public $repeatpassword;
        
        
        public function rules(){
            return [
                [['admin_oldpass','password','repeatpassword'],'required'],
                ['admin_oldpass','findPasswords'],
                ['repeatpassword','compare','compareAttribute'=>'password'],
            ];
        }
        
        public function findPasswords($attribute, $params){
            $user = Login::find()->where([
                'phone'=>Yii::$app->user->identity->phone
            ])->one();
           
            $password = $user->password;

            if($password!=  md5($this->admin_oldpass))
                $this->addError($attribute,'Old password is incorrect');
            
           
        }
        
        public function attributeLabels(){
            return [
                'admin_oldpass'=>'Old Password',
                'password'=>'New Password',
                'repeatpassword'=>'Repeat New Password',
            ];
        }
    }