<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use api\modules\v1\models\Category;
use api\modules\v1\models\Sliders;
use backend\models\CategoryPromotion;
use backend\models\PostPromotion;
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
                $limit = 10;
                $offset = $page * $limit;
                
                $total_records = CategoryPromotion::find()->where(['category_id' => $category_id])->count();

                $postList = CategoryPromotion::find()->where(['category_id' => $category_id])
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
                            'data' =>  array(),
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
                    'data' =>  array(),
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
                            'data' =>  array(),
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
                    'data' =>  array(),
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
                
                $promotion_id = isset($data->promotion_id)?$data->promotion_id:'0';

                $postList = Promotion::find()->where(['promotion_id' => $promotion_id])->asArray()->one();
                $postList['image'] = Yii::$app->params['uploadURL'] . 'promotion/' . $postList['image'];

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
                            'data' =>  array(),
                          ];
                }
                echo json_encode($response,TRUE);
        }
        catch (ErrorException $response)
        {
            $response = [
                    'status' => '0',
                    'message' => $response->getMessage(),
                    'data' =>  array(),
                  ];

            echo json_encode($response,TRUE);
        }
	}
}