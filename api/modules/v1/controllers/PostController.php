<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use api\modules\v1\models\Category;
use api\modules\v1\models\Sliders;
use backend\models\Posts;
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
                $page = isset($data->page)?$data->page:'0';
                $limit = 10;
                $offset = $page * $limit;
                
                $total_records = Posts::find()->where(['category_id' => $category_id])->count();

                $postList = Posts::find()->where(['category_id' => $category_id])
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
                        $postList[$key]['image'] = Yii::$app->params['uploadURL'] . 'posts/' . $postList[$key]['image'];
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
                
                $post_id = isset($data->post_id)?$data->post_id:'0';

                $postList = Posts::find()->where(['post_id' => $post_id])->asArray()->one();

                if(sizeof($postList))
                {
                    $imagearray = array();
                    array_push($imagearray, Yii::$app->params['uploadURL'] . 'posts/' . $postList['image']);
                    $postList['image'] = $imagearray;
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