<?php

namespace App\Service;

use App\Model\DepartmentManager;

class GameDealer
{
    public const RANGE_NORMALIZATION = 100;
    public const MARGIN_DECREASE_STEP = 0.1;
    public const COEFF_SCORE_ACCELERATOR = 0.1;

    public function getInitialGameErrorMargin(): int
    {
        $deptId = $_SESSION['deptId'];
        $departmentManager = new DepartmentManager();
        $objectData = $departmentManager->selectOneByDeptId($deptId);
        $range = $objectData['max_date'] - $objectData['min_date'];
        return intval(round($range * 0.25));
    }

    public function scoreByAnswer($numQuestion, $initialErrorMargin, $userAnswer, $rightAnswer): array
    {
        $gameData = [];
        $gameData['currentErrorMargin'] = $initialErrorMargin * (1 - self::MARGIN_DECREASE_STEP * $numQuestion);
        if ($gameData['currentErrorMargin'] > 100) {
            $gameData['currentErrorMargin'] = round($gameData['currentErrorMargin'], -2);
        } else {
            $gameData['currentErrorMargin'] = round($gameData['currentErrorMargin'], -1);
        }
        $gameData['diff'] = abs($userAnswer - $rightAnswer);
        $gameData['nbPoints'] = self::RANGE_NORMALIZATION * (1 - $gameData['diff'] / $gameData['currentErrorMargin']);
        $gameData['nbPoints'] = $gameData['nbPoints'] * (1 + self::COEFF_SCORE_ACCELERATOR * $numQuestion);
        $gameData['nbPoints'] = round($gameData['nbPoints']);
        $gameData['userAnswer'] = $userAnswer;
        $gameData['rightAnswer'] = $rightAnswer;


        if ($gameData['diff'] === 0) {
            $gameData['nbPoints'] = $gameData['nbPoints'] * 2;
            $gameData['gameStatus'] = 'Perfect';
        } elseif ($gameData['diff'] > $gameData['currentErrorMargin']) {
            $gameData['nbPoints'] = 0;
            $gameData['gameStatus'] = 'Game Over';
            $logRecorder = new LogRecorder();
            $logRecorder->recordEndOfGame();
        } else {
            $gameData['gameStatus'] = 'Good Answer';
        }
        return $gameData;
    }
}
