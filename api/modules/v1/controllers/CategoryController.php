<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use api\modules\v1\models\Category;
use api\modules\v1\models\Sliders;
use Yii;

/**
 * Category Controller API
 *
 */
class CategoryController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Category';

    public function actionIndex()
	{ 
	    Yii::$app->response->format = Response::FORMAT_JSON;
	}

	public function actionList()
	{
        try
        {
                $categoryList = Category::find()->asArray()->all();

                if(sizeof($categoryList))
                {
                	foreach ($categoryList as $key => $value) {
                		$categoryList[$key]['icon'] = Yii::$app->params['uploadURL'] . 'category/' . $categoryList[$key]['icon'];
                	}
                    $topsliders = Sliders::find()->where(["position" => "top"])->asArray()->all();
                    foreach ($topsliders as $key => $value) {
                        $topsliders[$key]['image'] = Yii::$app->params['uploadURL'] . 'sliders/' . $topsliders[$key]['image'];
                    }

                    $bottomsliders = Sliders::find()->where(["position" => "bottom"])->asArray()->all();
                    foreach ($bottomsliders as $key => $value) {
                        $bottomsliders[$key]['image'] = Yii::$app->params['uploadURL'] . 'sliders/' . $bottomsliders[$key]['image'];
                    }

                    $response = [
                      'status' => '1',
                      'message' => 'Data found',
                      'data' => $categoryList,
                      'topslider' => $topsliders,
                      'bottomslider' => $bottomsliders,
                    ];
                }
                else
                {
                        $response = [
                            'status' => '0',
                            'message' => 'No Category Found',
                            'data' =>  (object)array()
                          ];
                }
                echo json_encode($response,TRUE);
        }
        catch (ErrorException $response)
        {
            $response = [
                    'status' => '0',
                    'message' => $response->getMessage(),
                    'data' =>  (object)array()
                  ];

            echo json_encode($response,TRUE);
        }
	}
}