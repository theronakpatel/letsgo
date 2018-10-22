<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use api\modules\v1\models\Login;
use api\modules\v1\models\Category;
use api\modules\v1\models\Sliders;
use backend\models\CategoryPromotion;
use backend\models\PromotionActivationcode;
use backend\models\PostPromotion;
use backend\models\CustomerActivatation;
use backend\models\Promotion;
use yii\data\Pagination;
use Yii;

/**
 * Category Controller API
 *
 */
class PromotionController extends ActiveController
{
    public $modelClass = 'backend\models\Promotion';

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
                $page = isset($data->page)?$data->page:'0';
                $customer_id = isset($data->customer_id)?$data->customer_id:'0';
                $limit = 10;
                $offset = $page * $limit;
                
                

                $PromotionQuery = CategoryPromotion::find()->where(['category_id' => $category_id])
                                  ->select(['tbl_category_promotion.*',
                                    /*"(SELECT count(*)
                                      FROM tbl_customer_activatation
                                      WHERE 
                                      tbl_customer_activatation.promotion_id = tbl_category_promotion.promotion_id 
                                      AND 
                                      tbl_customer_activatation.customer_id = '$customer_id') AS test"*/

                                    ])->where(['=', "(SELECT count(*)
                                      FROM tbl_customer_activatation
                                      WHERE 
                                      tbl_customer_activatation.promotion_id = tbl_category_promotion.promotion_id 
                                      AND 
                                      tbl_customer_activatation.customer_id = '$customer_id')", "0"]);

                $total_records = $PromotionQuery->count();
                $PromotionData =  $PromotionQuery->limit($limit)->offset($offset)->asArray()->all();

                $found_records = sizeof($PromotionData);
                $more_records_found = 0;
                if(($total_records - (($page + 1) * $limit)) > 0){
                    $more_records_found = 1;
                }

                if($found_records)
                {
                    foreach ($PromotionData as $key => $value) {
                         $promotionOne = Promotion::find()->where(['promotion_id' => $value['promotion_id']])->asArray()->one();
                         $promotionOne['image'] = Yii::$app->params['uploadURL'] . 'promotion/' . $promotionOne['image'];
                         $PromotionData[$key] = $promotionOne;

                         $customerActivationModal = CustomerActivatation::find()->where(['promotion_id' => $value['promotion_id'],'customer_id' => $customer_id])->count();
                         if($customerActivationModal){
                            $PromotionData[$key]['is_activated'] = '1';
                         }else{
                            $PromotionData[$key]['is_activated'] = '0';
                         }
                            // $PromotionData[$key]['test'] = $value['test'];
                    }
                     

                    $response = [
                      'status' => '1',
                      'message' => 'Data found',
                      'data' => $PromotionData,
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
                            'message' => 'No Promotion Found',
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

    public function actionPerPost()
    {
        try
        {
                
                $data = Yii::$app->request->post();
                $data = Yii::$app->request->getRawBody();
                $data = json_decode($data);
                
                $customer_id = isset($data->customer_id)?$data->customer_id:'0';
                $post_id = isset($data->post_id)?$data->post_id:'0';
                $page = isset($data->page)?$data->page:'0';
                $limit = 10;
                $offset = $page * $limit;
                
                $total_records = PostPromotion::find()->where(['post_id' => $post_id])->count();

                $postList = PostPromotion::find()->where(['post_id' => $post_id])
                            ->limit($limit)
                            ->offset($offset)
                            ->asArray()->all();

                $found_records = sizeof($postList);

                $more_records_found = 0;
                if(($total_records - (($page + 1) * $limit)) > 0){
                    $more_records_found = 1;
                }

                if($found_records)
                {
                    foreach ($postList as $key => $value) {
                         $promotionOne = Promotion::find()->where(['promotion_id' => $value['promotion_id']])->asArray()->one();
                         $promotionOne['image'] = Yii::$app->params['uploadURL'] . 'promotion/' . $promotionOne['image'];
                         $postList[$key] = $promotionOne;
                         
                         $customerActivationModal = CustomerActivatation::find()->where(['promotion_id' => $value['promotion_id'],'customer_id' => $customer_id])->count();
                         if($customerActivationModal){
                            $postList[$key]['is_activated'] = '1';
                         }else{
                            $postList[$key]['is_activated'] = '0';
                         }
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
                            'message' => 'No Promotion Found',
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
    public function actionDetails()
    {
        try
        {
                
                $data = Yii::$app->request->post();
                $data = Yii::$app->request->getRawBody();
                $data = json_decode($data);
                
                $customer_id = isset($data->customer_id)?$data->customer_id:'0';
                $promotion_id = isset($data->promotion_id)?$data->promotion_id:'0';

                $postList = Promotion::find()->where(['promotion_id' => $promotion_id])->asArray()->one();
                if(sizeof($postList)){
                    $postList['image'] = Yii::$app->params['uploadURL'] . 'promotion/' . $postList['image'];
                    $customerActivationModal = CustomerActivatation::find()->where(['promotion_id' => $promotion_id ,'customer_id' => $customer_id])->count();
                     if($customerActivationModal){
                        $postList['is_activated'] = '1';
                     }else{
                        $postList['is_activated'] = '0';
                     }
                }

                if(sizeof($postList))
                {

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
                            'message' => 'No Promotion Found',
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

                    $postList = PromotionActivationcode::find()->where(['promotion_id' => $promotion_id,'activation_code' => $activation_code])->asArray()->one();
                    if(sizeof($postList))
                    {
                        
                        $customerActivationModal = CustomerActivatation::find()->where(['promotion_id' => $promotion_id,'customer_id' => $customer_id])->asArray()->one();
                        if(sizeof($customerActivationModal))
                        {
                            $response = [
                                'status' => '0',
                                'message' => 'This promotion is already activated!',
                                'data' =>  (object)array(),
                              ];
                        }else{
                            $promotionOne = Promotion::find()->where(['promotion_id' => $promotion_id ])->one();
                            $customer_details->promotion_points =  $customer_details->promotion_points + $promotionOne->promotion_points; 
                            $customer_details->save(false);

                            $CustomerActivatationModal = new CustomerActivatation();
                            $CustomerActivatationModal->customer_id = $customer_id;
                            $CustomerActivatationModal->promotion_id = $promotion_id;
                            $CustomerActivatationModal->activation_code = $activation_code; 
                            $CustomerActivatationModal->activation_date = date('Y-m-d H:i:s');
                            $CustomerActivatationModal->points = $promotionOne->promotion_points;
                            $CustomerActivatationModal->save(false);
                            
                            
                            $postList['promotion_points']  = (string)$promotionOne->promotion_points;
                            $response = [
                              'status' => '1',
                              'message' => 'Congratulations! Activation code verified and activated for the promotion.',
                              'data' => $postList,
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


    public function actionRedeemed()
    {
        try
        {
                
                $data = Yii::$app->request->post();
                $data = Yii::$app->request->getRawBody();
                $data = json_decode($data);
                
                $customer_id = isset($data->customer_id)?$data->customer_id:'0';
                $page = isset($data->page)?$data->page:'0';
                $limit = 10;
                $offset = $page * $limit;

                $customer_details = Login::find()->where(['customer_id' => $customer_id])->one();
                if($customer_details){
                    
                    $total_records = CustomerActivatation::find()->where(['customer_id' => $customer_id])->count();

                    $postList = CustomerActivatation::find()->where(['customer_id' => $customer_id])->asArray()->all();
                    $found_records = sizeof($postList);

                    $more_records_found = 0;
                    if(($total_records - (($page + 1) * $limit)) > 0){
                        $more_records_found = 1;
                    }

                    if($found_records)
                    {
                        
                        foreach ($postList as $key => $value) {
                             $points = $value['points'];
                             $promotionOne = Promotion::find()->where(['promotion_id' => $value['promotion_id']])->asArray()->one();
                             $promotionOne['image'] = Yii::$app->params['uploadURL'] . 'promotion/' . $promotionOne['image'];
                             $postList[$key] = $promotionOne;
                             $postList[$key]['is_activated'] = '1';
                             $postList[$key]['points'] = $points;
                             $postList[$key]['activation_date'] = $value['activation_date'];
                        }

                        $customer_details = Login::find()->where(['customer_id' => $customer_id])->one();
                         

                        $response = [
                          'status' => '1',
                          'message' => 'Data found',
                          'data' => $postList,
                          'total_records' => $total_records,
                          'found_records' => $found_records,
                          'more_records_found' => $more_records_found,
                          'page' => $page,
                          'customer_points' => $customer_details->promotion_points,
                          'limit' => $limit,
                        ];

                    }else{
                        $response = [
                            'status' => '0',
                            'message' => 'You have not activated any promotion!',
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