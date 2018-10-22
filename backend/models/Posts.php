<?php

namespace backend\models;

use backend\models\Category;
use Yii;

/**
 * This is the model class for table "tbl_posts".
 *
 * @property integer $post_id
 * @property integer $category_id
 * @property resource $name
 * @property resource $description
 * @property resource $address
 * @property double $latitude
 * @property double $longitude
 * @property string $image
 * @property string $added_date
 *
 * @property PostPromotion[] $PostPromotions
 * @property Category $category
 */
class Posts extends \yii\db\ActiveRecord
{
    public $files;
    /**
     * @inheritdoc
     */
    public $category_name;
    
    public static function tableName()
    {
        return 'tbl_posts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id','name', 'description', 'address', 'latitude', 'longitude','ph_No'], 'required'],
            [['files'], 'required', 'on'=>'create'],
            [['category_id'], 'integer'],
            [['name', 'description', 'address','image','ph_No'], 'string'],
            [['latitude', 'longitude'], 'number'],
            [['added_date','category_name'], 'safe'],
            [['files'],'file','skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 10, 'maxSize' => 1024 * 1024 * 5,],
            [['files'], 'file','skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 10, 'maxSize' => 1024 * 1024 * 5 ,'on'=>'update'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'category_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'Post',
            'category_id' => 'Category',
            'name' => 'Name',
            'ph_No' => 'Phone number',
            'description' => 'Description',
            'address' => 'Address',
            'files' => 'Images',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'image' => 'Image',
            'added_date' => 'Added Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPostPromotions()
    {
        return $this->hasMany(PostPromotion::className(), ['post_id' => 'post_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['category_id' => 'category_id']);
    }


    public static function sendAndroidNotification($deviceId, $param, $title, $type, $cat_id, $post_id)
    {
        //1 for category , 2 for post
        if($type == 1){ // post

                $msg = array
                    (
                        'title' => "Let's Go",
                        'message' => $title,
                        'type' => $type,  
                        'cat_id' => $cat_id
                    );  

        }else if($type == 2){ // post

                $msg = array
                    (
                        'title' => "Let's Go",
                        'message' => $title,
                        'type' => $type,  
                        'cat_id' => $cat_id,
                        'post_id' => $post_id,
                    );

        }else{ // category
                $msg = array
                    (
                        'title' => "Let's Go",
                        'message' => $title,
                        'type' => $type
                    );            
        }


        $fields = array
                (
                    'to' => $deviceId,
                    'data' => array('M' => $msg),
                    'priority' => 'high'
                );

        $headers = array
        (
            'Authorization: key=' . Yii::$app->params['ANDROID_API_KEY'],
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);

        curl_close($ch);
    }

    /**
     * @param $deviceId
     * @param $sipUserDetail
     * @param $forwardingService
     * @param $param
     */
   public static function sendIosNotification($deviceId, $param, $title, $type, $cat_id, $post_id)
    {
        $passPhrase = '';
        $pemFile = Yii::$app->params['uploadPath'] . 'LetsGo_apns_dist.pem';

        if (file_exists($pemFile)) {
            
                /*$apnsHost = 'gateway.sandbox.push.apple.com';
                $apnsCert = $pemFile;
                $apnsPort = 2195;
                $apnsPass = '';
                $token = $deviceId;

                $payload['aps'] = array('alert' => 'Oh hai!', 'badge' => 1, 'sound' => 'default');
                $output = json_encode($payload);
                $token = pack('H*', str_replace(' ', '', $token));
                $apnsMessage = chr(0).chr(0).chr(32).$token.chr(0).chr(strlen($output)).$output;

                $streamContext = stream_context_create();
                stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert);
                stream_context_set_option($streamContext, 'ssl', 'passphrase', $apnsPass);

                $apns = stream_socket_client('ssl://'.$apnsHost.':'.$apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext);
                fwrite($apns, $apnsMessage);
                fclose($apns);*/

                /*if ($production) {
                    $gateway = 'gateway.push.apple.com:2195';
                } else { */
                    $gateway = 'ssl://gateway.sandbox.push.apple.com:2195';
                // }

                // Create a Stream
                $ctx = stream_context_create();
                // Define the certificate to use 
                stream_context_set_option($ctx, 'ssl', 'local_cert', $pemFile);
                // Passphrase to the certificate
                stream_context_set_option($ctx, 'ssl', 'passphrase', '');

                // Open a connection to the APNS server
                $fp = stream_socket_client(
                    $gateway, $err,
                    $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

                // Check that we've connected
                if (!$fp) {
                    die("Failed to connect: $err $errstr");
                }
                $notification= 'tesss';
                // Ensure that blocking is disabled
                stream_set_blocking($fp, 0);

                // Send it to the server
                $result = fwrite($fp, $notification, strlen($notification));

                // Close the connection to the server
                fclose($fp);
        }

        

        if (file_exists($pemFile)) {
            
            $ctx = stream_context_create();
            stream_context_set_option($ctx, 'ssl', 'local_cert', $pemFile);
            stream_context_set_option($ctx, 'ssl', 'passphrase', $passPhrase);
            // Open a connection to the APNS server
            $fp = stream_socket_client(
                'ssl://gateway.sandbox.push.apple.com:2195', $err,
                //   'ssl://gateway.push.apple.com:2195', $err,
                $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
            if (!$fp)
                exit("Failed to connect: $err $errstr" . PHP_EOL);


            //1 for category , 2 for post
            if($type == 1){ // post

                    $msg = array
                        (
                            'title' => "Let's Go",
                            'message' => $title,
                            'type' => $type,  
                            'cat_id' => $cat_id
                        );  

            }else if($type == 2){ // post

                    $msg = array
                        (
                            'title' => "Let's Go",
                            'message' => $title,
                            'type' => $type,  
                            'cat_id' => $cat_id,
                            'post_id' => $post_id,
                        );

            }else{ // category
                    $msg = array
                    (
                        'title' => "Let's Go",
                        'message' => $title,
                        'type' => $type
                    );

            }
            $message = $title;
            $alert = array(
                "title" => $title,
                "body" => $message
            );
            $body['aps'] = array(
                'loc-key' => 'IC_MSG',
                'data' => array('M' => $msg),
                'type' =>$type
            );

            $payload = json_encode($body);
            $msg = chr(0) . pack('n', 32) . pack('H*', $deviceId) . pack('n', strlen($payload)) . $payload;
            $result = fwrite($fp, $msg, strlen($msg));

            fclose($fp);
        }
    }


}
