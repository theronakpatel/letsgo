<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use api\modules\v1\models\Login;
use api\modules\v1\models\Category;
use api\modules\v1\models\Sliders;
use backend\models\CategoryPromotion;
use backend\models\PromotionActivationcode;
use backend\models\PostPromotion;
use backend\models\CustomerMerchActivatation;
use backend\models\MerchPromotion;
use yii\data\Pagination;
use Yii;

/**
 * Category Controller API
 *
 */
class MerchPromotionController extends ActiveController
{
    public $modelClass = 'backend\models\MerchPromotion';

    public function actionIndex()
	{ 
	    Yii::$app->response->format = Response::FORMAT_JSON;
	}

    public function actionData()
    {
        try
        {
                
                $data = Yii::$app->request->post();
                $data = Yii::$app->request->getRawBody();
                $data = json_decode($data);
                
                $page = isset($data->page)?$data->page:'0';
                $customer_id = isset($data->customer_id)?$data->customer_id:'0';
                $limit = 10;
                $offset = $page * $limit;
                
                $total_records = MerchPromotion::find()->count();

                $PromotionData = MerchPromotion::find()
                            ->limit($limit)
                            ->offset($offset)
                            ->asArray()->all();

                $found_records = sizeof($PromotionData);

                $more_records_found = 0;
                if(($total_records - (($page + 1) * $limit)) > 0){
                    $more_records_found = 1;
                }

                if($found_records)
                {
                    foreach ($PromotionData as $key => $value) {
                         $PromotionData[$key]['image'] = Yii::$app->params['uploadURL'] . 'promotion/' . $value['image'];

                         $customerActivationModal = CustomerMerchActivatation::find()->where(['mer_promotion_id' => $value['mer_promotion_id'],'customer_id' => $customer_id])->count();
                         if($customerActivationModal){
                            $PromotionData[$key]['is_activated'] = '1';
                         }else{
                            $PromotionData[$key]['is_activated'] = '0';
                         }
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
                    $mer_promotion_id = isset($data->mer_promotion_id)?$data->mer_promotion_id:'0';
                    $merchant_code = isset($data->activation_code)?$data->activation_code:'';

                    $postList = MerchPromotion::find()->where(['mer_promotion_id' => $mer_promotion_id,'merchant_code' => $merchant_code])->asArray()->one();
                    if(sizeof($postList))
                    {
                        $customerActivationModal = CustomerMerchActivatation::find()->where(['mer_promotion_id' => $mer_promotion_id,'customer_id' => $customer_id])->asArray()->one();
                        if(sizeof($customerActivationModal))
                        {
                            $response = [
                                'status' => '0',
                                'message' => 'This promotion is already activated!',
                                'data' =>  (object)array(),
                              ];
                        }else{
                            $promotionOne = MerchPromotion::find()->where(['mer_promotion_id' => $mer_promotion_id ])->one();
                            if($customer_details->promotion_points > $promotionOne->promotion_points ){
                                $customer_details->promotion_points =  $customer_details->promotion_points - $promotionOne->promotion_points; 
                                $customer_details->save(false);

                                $CustomerMerchActivatationModal = new CustomerMerchActivatation();
                                $CustomerMerchActivatationModal->customer_id = $customer_id;
                                $CustomerMerchActivatationModal->mer_promotion_id = $mer_promotion_id;
                                $CustomerMerchActivatationModal->merchant_code = $merchant_code; 
                                $CustomerMerchActivatationModal->activation_date = date('Y-m-d H:i:s');
                                $CustomerMerchActivatationModal->points = $promotionOne->promotion_points;
                                $CustomerMerchActivatationModal->save();
                                
                                
                                $postList['promotion_points']  = (string)$promotionOne->promotion_points;
                                $response = [
                                  'status' => '1',
                                  'message' => 'Congratulations! Activation code verified and activated for the promotion.',
                                  'data' => $postList,
                                ];
                            }else{
                                $response = [
                                    'status' => '0',
                                    'message' => 'You donot have sufficient reward points!',
                                    'data' =>  (object)array(),
                                  ];           
                            }
                            
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
                    
                    $total_records = CustomerMerchActivatation::find()->where(['customer_id' => $customer_id])->count();

                    $postList = CustomerMerchActivatation::find()->where(['customer_id' => $customer_id])->asArray()->all();
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