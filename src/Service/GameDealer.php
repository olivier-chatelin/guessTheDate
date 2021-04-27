<?php

namespace App\Service;

use App\Model\DepartmentManager;

class GameDealer
{
    public const RANGE_REF_FOR_NORMALIZATION = 1000;
    public const MARGIN_DECREASE_STEP = 0.1;
    public const COEFF_SCORE_ACCELERATOR = 0.1;

    public function getInitialGameErrorMargin(): int
    {
        $deptId = $_SESSION['deptId'];
        $departmentManager = new DepartmentManager();
        $objectData = $departmentManager->selectOneByDeptId($deptId);
        $minDate = $objectData['min_date'];
        $maxDate = $objectData['max_date'];
        $range = $maxDate - $minDate;
        $initialErrorMargin = intval(round($range / 4));
        return $initialErrorMargin;
    }

    public function scoreByAnswer($numQuestion, $initialErrorMargin, $userAnswer, $rightAnswer): array
    {
        $currentErrorMargin = $initialErrorMargin * (1 - self::MARGIN_DECREASE_STEP * $numQuestion);
        $currentErrorMargin = round($currentErrorMargin);

        $diff = abs($userAnswer - $rightAnswer);
        $score = [];
        $score['nbPoints'] = (($initialErrorMargin - $diff) * self::RANGE_REF_FOR_NORMALIZATION) / $initialErrorMargin;
        $score['nbPoints'] = $score['nbPoints'] * (1 + self::COEFF_SCORE_ACCELERATOR * $numQuestion);
        $score['nbPoints'] = round($score['nbPoints']);
        $score['diff'] = $diff;
        $score['userAnswer'] = $userAnswer;
        $score['rightAnswer'] = $rightAnswer;
        $score['currentErrorMargin'] = $currentErrorMargin;

        if ($diff === 0) {
            $score['nbPoints'] = $score['nbPoints'] * 2;
            $score['gameStatus'] = 'Perfect';
        } elseif ($diff > $currentErrorMargin) {
            $score['nbPoints'] = 0;
            $score['gameStatus'] = 'Game Over';
        } else {
            $score['gameStatus'] = 'Good Answer';
        }
        return $score;
    }
}
