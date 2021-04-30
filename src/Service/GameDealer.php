<?php

namespace App\Service;

use App\Model\DepartmentManager;
use App\Entity\Log;

class GameDealer
{
    public const RANGE_NORMALIZATION = 100;
    public const MARGIN_DECREASE_STEP = 0.1;
    public const COEFF_SCORE_ACCELERATOR = 0.1;

    public const COEFF_INIT_MARGIN = 0.25;

    public function getGameErrorMargin(): int
    {
        $deptId = $_SESSION['deptId'];
        $departmentManager = new DepartmentManager();
        $objectData = $departmentManager->selectOneByDeptId($deptId);
        $range = abs($objectData['max_date'] - $objectData['min_date']);
        $initialErrorMargin = $range * self::COEFF_INIT_MARGIN;

        $_SESSION['game']['currentErrorMargin'] = $initialErrorMargin *
            (1 - self::MARGIN_DECREASE_STEP * ($_SESSION['game']['numQuestion'] - 1));
        $_SESSION['game']['currentErrorMargin'] = intval(round($_SESSION['game']['currentErrorMargin'], -1));
        return $_SESSION['game']['currentErrorMargin'];
    }

    public function scoreByAnswer($userAnswer, $rightAnswer)
    {
        $_SESSION['game']['diff'] = abs($userAnswer - $rightAnswer);
        $_SESSION['game']['nbPoints'] = self::RANGE_NORMALIZATION *
            (1 - $_SESSION['game']['diff'] / $_SESSION['game']['currentErrorMargin']);
        $_SESSION['game']['coeffQuestion'] = 1 + self::COEFF_SCORE_ACCELERATOR * ($_SESSION['game']['numQuestion'] - 1);
        $_SESSION['game']['nbPoints'] = $_SESSION['game']['nbPoints'] * $_SESSION['game']['coeffQuestion'];
        $_SESSION['game']['nbPoints'] = round($_SESSION['game']['nbPoints']);
        $_SESSION['game']['userAnswer'] = $userAnswer;
        $_SESSION['game']['rightAnswer'] = $rightAnswer;

        if ($_SESSION['game']['diff'] === 0) {
            $_SESSION['game']['nbPoints'] = $_SESSION['game']['nbPoints'] * 2;
            $_SESSION['game']['status'] = 'Perfect';
        } elseif ($_SESSION['game']['diff'] > $_SESSION['game']['currentErrorMargin']) {
            $_SESSION['game']['nbPoints'] = 0;
            $_SESSION['game']['status'] = 'Game Over';
            $logRecorder = new LogRecorder();

            $logRecorder->recordEndOfGame();
        } else {
            $_SESSION['game']['status'] = 'Good Answer';
        }
    }
}
