<?php

/*
 * A Controller handling visibility functions
 *
 *
 * LICENSE:
 *
 * @category File
 * @package Src
 * @subpackage Controller
 * @copyright Copyright (c) 2021 Kevin Alexander Fronzeck
 * @license
 * @version 1.0
 * @link
 * @since 19.02.21
 *
 */

namespace Controller;

use Controller\DbController;
use Model\DbCredentials;

class VisibilityController
{

    public function getAlVisibilities(): array
    {
        $dbCredentials = new DbCredentials();
        $dbController = new DbController($dbCredentials);

        return $dbController->getAll("visibility");
    }


    public function getUserVisibility(): array
    {
        $dbCredentials = new DbCredentials();
        $dbController = new DbController($dbCredentials);

        $statement = "SELECT * FROM `visibility` WHERE `name`='draft' OR `name`='open'";

        return $dbController->executeQuery($statement);
    }


}