<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace console\controllers;

use yii\console\Controller;
use backend\models\PromocodesGenerator;
use backend\models\Promocodes;

/**
 * This command echoes the first argument that you have entered.
 * This command is provided as an example for you to learn how to create console commands.
 */
class PromocodecronController extends Controller
{
    public function actionGeneratepromocode()
    {

        $all_pmcgn = PromocodesGenerator::findAll(['pmcgn_is_generated' => 0, 'pmcgn_is_deleted' => 0]);

        foreach ($all_pmcgn as $key => $pmcgn) {

            for ($i=0; $i < $pmcgn->pmcgn_quantity; $i++) {
                $length = 16 - strlen($pmcgn->pmcgn_prefix);

                $promocode = $pmcgn->pmcgn_prefix . Yii::$app->Utility->getToken($length);

                $pmc = new Promocodes;
                $pmc->pmc_pmcgn_id = $pmcgn->pmcgn_id;
                $pmc->pmc_code = $promocode;
                $pmc->pmc_status = 'Y';
                $pmc->save();
                unset($pmc);
            }

            $pmcgn->pmcgn_is_generated = 1;
            $pmcgn->save(false);
            unset($pmcgn);
        }
    }
}
