<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;
use api\modules\v1\models\State;
use api\modules\v1\models\Country;
use Yii;
/**
 * Country Controller API
 *
 */
class CountryController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Country';    

    public function actionIndex()
	{ 
	    Yii::$app->response->format = Response::FORMAT_JSON;
	}

    public function actionList()
    {
        try
        {
                $countryList = Country::find()->asArray()->all();
                foreach ($countryList as $key => $value) {
                        $countryList[$key]['icon'] = Yii::$app->params['uploadURL'] . 'countries/flags/flag-of-' . ($countryList[$key]['name']).'.jpg';
                }

                if(sizeof($countryList))
                {
                    $response = [
                      'status' => '1',
                      'message' => 'Data found',
                      'data' => $countryList
                    ];
                }
                else
                {
                        $response = [
                            'status' => '0',
                            'message' => 'No Country Found',
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
	public function actionStatelist()
	{
        try
        {

                $data = Yii::$app->request->post();
                $data = Yii::$app->request->getRawBody();
                $data = json_decode($data);
                
                $country_id = isset($data->country_id)?$data->country_id:'0';

                $stateList = State::find()->where(['country_id' => $country_id])->asArray()->all();

                if(sizeof($stateList))
                {
                    $response = [
                      'status' => '1',
                      'message' => 'Data found',
                      'data' => $stateList
                    ];
                }
                else
                {
                        $response = [
                            'status' => '0',
                            'message' => 'No Country Found',
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