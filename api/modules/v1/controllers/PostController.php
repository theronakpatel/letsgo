<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use api\modules\v1\models\Category;
use api\modules\v1\models\Sliders;
use api\modules\v1\models\Login;
use backend\models\Promotion;
use backend\models\Posts;
use backend\models\PostImages;
use backend\models\CustomerActivatation;
use yii\data\Pagination;
use Yii;

/**
 * Category Controller API
 *
 */
class PostController extends ActiveController
{
    public $modelClass = 'backend\models\Posts';

    public function actionIndex()
	{ 
	    Yii::$app->response->format = Response::FORMAT_JSON;
	}

    public function actionPerCategory()
    {
        try
        {
                
                $data = Yii::$app->request->post();
                $data = Yii::$app->request->getRawBody();
                $data = json_decode($data);
                
                $category_id = isset($data->category_id)?$data->category_id:'0';
                
                $latitude = isset($data->lat)?$data->lat:'0';
                $longitude = isset($data->long)?$data->long:'0';
                $radius = isset($data->radius)?$data->radius:'100';
                $page = isset($data->page)?$data->page:'0';
                $search_keyword = isset($data->search_keyword)?$data->search_keyword:'';
                $search_km = isset($data->search_km)?$data->search_km:'';


                $limit = 10;
                $offset = $page * $limit;
                
                $postList = Posts::find()
                    ->select([
                    '111.1111 * DEGREES(ACOS(COS(RADIANS('.$latitude.'))
                    * COS(RADIANS(latitude))
                    * COS(RADIANS('.$longitude.' - longitude))
                    + SIN(RADIANS('.$latitude.'))
                    * SIN(RADIANS(latitude)))) AS distance_in_km',
                    'tbl_posts.*',
                    'tbl_posts.category_id as category',
                    ])
                    ->orderBy(['distance_in_km' => SORT_ASC])
                    ->having(['=', 'category',$category_id] )
                    ->andHaving(['<', 'distance_in_km',$radius] );
                
                if($search_keyword != ''){
                    $postList->andWhere(['or',
                               ['like', 'name',$search_keyword],
                               ['like', 'description',$search_keyword],
                               ['like', 'address',$search_keyword]
                           ]);
                }
                if($search_km != ''){
                    $postList->andHaving(['like', 'distance_in_km',$search_km]);
                }            
                $total_records  = $postList->asArray()->all();
                $total_records = sizeof($total_records);

                $postList->limit($limit)->offset($offset);
                
                $postList = $postList->asArray()->all();

                $found_records = sizeof($postList);

                $more_records_found = 0;
                if(($total_records - (($page + 1) * $limit)) > 0){
                    $more_records_found = 1;
                }

                if($found_records)
                {
                    foreach ($postList as $key => $value) {
                        $postList[$key]['distance_in_km'] = number_format($postList[$key]['distance_in_km'],2).' كيلومتر';
                        $latitudeFrom = $latitude;
                        $longitudeFrom = $longitude; 
                        $latitudeTo =  $postList[$key]['latitude'];
                        $longitudeTo = $postList[$key]['longitude'];

                        $multipleimages = PostImages::find()->where(['post_id' => $value['post_id']])->asArray()->all();
                        $post_images = array();
                        $postList[$key]['image'] = '';

                        foreach ($multipleimages as $key1 => $value1) {
                            $post_images[$key1] = Yii::$app->params['uploadURL'] . 'posts/' . $value1['image'];
                            if($key1 == 0){
                                $postList[$key]['image'] = Yii::$app->params['uploadURL'] . 'posts/' . $value1['image'];
                            }
                        }
                        $postList[$key]['post_images'] = $post_images;
                    }
                     

                    $response = [
                      'status' => '1',
                      'message' => 'Data found',
                      'data' => $postList,
                      'total_records' => $total_records,
                      'found_records' => $found_records,
                      'more_records_found' => $more_records_found,
                      'page' => $page,
                      'limit' => $limit,
                    ];
                }
                else
                {
                        $response = [
                            'status' => '0',
                            'message' => 'No Posts Found',
                            'data' =>  (object)array(),
                            'total_records' => $total_records,
                            'found_records' => $found_records,
                            'more_records_found' => 0,
                            'page' => $page,
                            'limit' => $limit,
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
    public function actionActivated()
    {
        try
        {
                
                $data = Yii::$app->request->post();
                $data = Yii::$app->request->getRawBody();
                $data = json_decode($data);
                
                
                $customer_id = isset($data->customer_id)?$data->customer_id:'0';
                $latitude = isset($data->lat)?$data->lat:'0';
                $longitude = isset($data->long)?$data->long:'0';
                $page = isset($data->page)?$data->page:'0';

                $limit = 10;
                $offset = $page * $limit;
                
                $postList = Posts::find()
                    ->select([
                    '111.1111 * DEGREES(ACOS(COS(RADIANS('.$latitude.'))
                    * COS(RADIANS(latitude))
                    * COS(RADIANS('.$longitude.' - longitude))
                    + SIN(RADIANS('.$latitude.'))
                    * SIN(RADIANS(latitude)))) AS distance_in_km',
                    'tbl_posts.*',
                    'tbl_posts.category_id as category',
                    'tbl_customer_activatation.promotion_id',
                    'tbl_customer_activatation.points',
                    'tbl_customer_activatation.activation_date',
                    ])
                    ->join('INNER JOIN', 'tbl_post_promotion', 'tbl_post_promotion.post_id = tbl_posts.post_id')
                    ->join('INNER JOIN', 'tbl_promotion', 'tbl_promotion.promotion_id = tbl_post_promotion.promotion_id')
                    ->join('INNER JOIN', 'tbl_customer_activatation', 'tbl_customer_activatation.promotion_id = tbl_promotion.promotion_id')
                    ->where(['tbl_customer_activatation.customer_id' => $customer_id])
                    ->andWhere(['>', 'tbl_customer_activatation.points' , 0])
                    ->orderBy(['distance_in_km' => SORT_ASC]);
                
                
                $total_records  = $postList->asArray()->all();
                $total_records = sizeof($total_records);

                $postList->limit($limit)->offset($offset);
                
                $postList = $postList->asArray()->all();

                $found_records = sizeof($postList);

                $more_records_found = 0;
                if(($total_records - (($page + 1) * $limit)) > 0){
                    $more_records_found = 1;
                }

                if($found_records)
                {
                    foreach ($postList as $key => $value) {
                        $postList[$key]['distance_in_km'] = number_format($postList[$key]['distance_in_km'],2).' كيلومتر';
                        $latitudeFrom = $latitude;
                        $longitudeFrom = $longitude; 
                        $latitudeTo =  $postList[$key]['latitude'];
                        $longitudeTo = $postList[$key]['longitude'];

                        $multipleimages = PostImages::find()->where(['post_id' => $value['post_id']])->asArray()->all();
                        $post_images = array();
                        $postList[$key]['image'] = '';

                        foreach ($multipleimages as $key1 => $value1) {
                            $post_images[$key1] = Yii::$app->params['uploadURL'] . 'posts/' . $value1['image'];
                            if($key1 == 0){
                                $postList[$key]['image'] = Yii::$app->params['uploadURL'] . 'posts/' . $value1['image'];
                            }
                        }
                        $postList[$key]['post_images'] = $post_images;
                    }
                     

                    $response = [
                      'status' => '1',
                      'message' => 'Data found',
                      'data' => $postList,
                      'total_records' => $total_records,
                      'found_records' => $found_records,
                      'more_records_found' => $more_records_found,
                      'page' => $page,
                      'limit' => $limit,
                    ];
                }
                else
                {
                        $response = [
                            'status' => '0',
                            'message' => 'No Posts Found',
                            'data' =>  (object)array(),
                            'total_records' => $total_records,
                            'found_records' => $found_records,
                            'more_records_found' => 0,
                            'page' => $page,
                            'limit' => $limit,
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

    public function actionCheckactivationcode()
    {
        try
        {
                
                $data = Yii::$app->request->post();
                $data = Yii::$app->request->getRawBody();
                $data = json_decode($data);
                
                $customer_id = isset($data->customer_id)?$data->customer_id:'0';

                $customer_details = Login::find()->where(['customer_id' => $customer_id])->one();
                if($customer_details){
                    $promotion_id = isset($data->promotion_id)?$data->promotion_id:'0';
                    $activation_code = isset($data->activation_code)?$data->activation_code:'';

                    $postList = Promotion::find()->where(['merchant_code' => $activation_code])->asArray()->one();
                    if(sizeof($postList))
                    {
                        $customerActivationModal = CustomerActivatation::find()->where(['promotion_id' => $promotion_id,'customer_id' => $customer_id])->asArray()->one();
                        if(sizeof($customerActivationModal))
                        {
                            $points = $customerActivationModal['points'];
                            if($points == 0){
                                $response = [
                                    'status' => '0',
                                    'message' => 'This promotion is already activated by customer!',
                                    'data' =>  (object)array(),
                                  ];
                            }else{
                                $remaining_points = $customer_details->promotion_points - $points;
                                if($remaining_points < 0){
                                    $remaining_points = 0;
                                }
                                $customer_details->promotion_points = $remaining_points;
                                $customer_details->save(false);

                                $CustomerActivatationModal = CustomerActivatation::findOne(['promotion_id' => $promotion_id,'customer_id' => $customer_id]);
                                $CustomerActivatationModal->points = 0;
                                $CustomerActivatationModal->save(false);
                                
                                $postList['promotion_points']  = '0';
                                $response = [
                                  'status' => '1',
                                  'message' => 'Congratulations! Activation code verified and redeemed for the promotion.',
                                  'data' => $postList,
                                ];    
                            }
                        }else{
                            $response = [
                                    'status' => '0',
                                    'message' => 'This promotion is not activated by customer!',
                                    'data' =>  (object)array(),
                                  ];
                        }
                    }
                    else
                    {
                            $response = [
                                'status' => '0',
                                'message' => 'Activation code is not valid!',
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


	public function actionDetails()
	{
        try
        {
                
                $data = Yii::$app->request->post();
                $data = Yii::$app->request->getRawBody();
                $data = json_decode($data);
                
                $post_id = isset($data->post_id)?$data->post_id:'0';

                $postList = Posts::find()->where(['post_id' => $post_id])->asArray()->one();

                if(sizeof($postList))
                {

                    $multipleimages = PostImages::find()->where(['post_id' => $postList['post_id']])->asArray()->all();
                    $post_images = array();

                    foreach ($multipleimages as $key1 => $value1) {
                        $post_images[$key1] = Yii::$app->params['uploadURL'] . 'posts/' . $value1['image'];
                    }
                    $postList['image'] = $post_images;

                    $categoryname = Category::findOne(['category_id' => $postList['category_id']]);
                	$postList['category_name'] = $categoryname->name;

                    $response = [
                      'status' => '1',
                      'message' => 'Data found',
                      'data' => $postList,
                    ];
                }
                else
                {
                        $response = [
                            'status' => '0',
                            'message' => 'No Posts Found',
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

    public function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
       // convert from degrees to radians
      $latFrom = deg2rad($latitudeFrom);
      $lonFrom = deg2rad($longitudeFrom);
      $latTo = deg2rad($latitudeTo);
      $lonTo = deg2rad($longitudeTo);

      $lonDelta = $lonTo - $lonFrom;
      $a = pow(cos($latTo) * sin($lonDelta), 2) +
        pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
      $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

      $angle = atan2(sqrt($a), $b);
      $distance_in_km = ($angle * $earthRadius) / 1000;
      return number_format($distance_in_km,2).' كيلومتر';
    }
}