<?php


include_once "DbController.php";
include_once "Model/DbCredentials.php";
include_once "SessionController.php";


class UserController
{

    public function createNewUser($username,$email,$password,$role,$group)
    {

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        if($this->usernameExists($username) == true){

            //ToDo: Output Message
        }else{

            error_log("username not exists");

            if($this->verifyMail($email) == true){

                if ($this->emailExists($email) == true){
                    //ToDo: Output Message
                }else{

                    error_log("mail not exists");

                    //ToDo: Prevent SQL Injection
                    $statement = "INSERT INTO `user` (`id`, `username`, `mail`, `password`, `group_fsid`, `role_fsid`, `joindate`, `current_session`) VALUES ( NULL, '".$username."', '".$email."', '".$hashedPassword."', '".$group."', '".$role."',current_timestamp(), NULL);";

                    error_log($statement);

                    $dbCredentials = new \DbCredentials\DbCredentials();
                    $dbController = new DbController($dbCredentials);

                    return $dbController->executeQuery($statement);
                }
            }else{
                //Todo Output Message

                return null;
            }

        }

    }


    public function verifyMail($email):bool
    {
        if(filter_var($email,FILTER_VALIDATE_EMAIL)){
            return true;
        }
        return false;
    }


    public function usernameExists($username):bool
    {
        $dbCredentials = new \DbCredentials\DbCredentials();
        $dbController = new DbController($dbCredentials);

        return  $dbController->doesExist("user","username",$username);

    }

    public function emailExists($email):bool
    {
        $dbCredentials = new \DbCredentials\DbCredentials();
        $dbController = new DbController($dbCredentials);

        return  $dbController->doesExist("user","mail",$email);

    }



    public function hashPassword($password){

        //ToDo: Prevent SQL Injections before hashing just to be sure

        $passwordToHash = $password;
        $hashedPassword = password_hash($passwordToHash, PASSWORD_DEFAULT);

        //Check if password was really hashed
        if($hashedPassword != $password){
            return $hashedPassword;
        }

        return null;

    }


    public function isAdmin():bool
    {
        $sessionController = new SessionController();

        $isAdmin = false;

        if($sessionController->verifySession()){

            if($this->getRoleOfUser() == "1"){

                $isAdmin = true;

            }else{

                $isAdmin = false;
            }
        }

        return $isAdmin;

    }


    public function isCurator():bool
    {
        $sessionController = new SessionController();

        $isCurator = false;

        if($sessionController->verifySession()){
            if($this->getRoleOfUser() == "2") {
                $isCurator = true;
            }
        }

        return $isCurator;
    }


    public function getRoleOfUser()
    {
        $sessionController = new SessionController();

        $dbCredentials = new \DbCredentials\DbCredentials();
        $dbController = new DbController($dbCredentials);

        $userRole = null;

        if($sessionController->verifySession()){

            $username = $_SESSION["username"];

            $user = $dbController->getAllBy("user","username",$username);

            $userRole = $user[0][5];


        }

        return $userRole;

    }

    public function getUserVisibility()
    {
        $sessionController = new SessionController();

        $dbCredentials = new \DbCredentials\DbCredentials();
        $dbController = new DbController($dbCredentials);

        $userGroup = null;

        if($sessionController->verifySession()){

            $username = $_SESSION["username"];

            $user = $dbController->getAllBy("user","username",$username);

            $userGroup = $user[0][4];
        }

        return $userGroup;

    }

    public function getUserId():int
    {
        $sessionController = new SessionController();

        $dbCredentials = new \DbCredentials\DbCredentials();
        $dbController = new DbController($dbCredentials);

        $userId = null;

        if($sessionController->verifySession()){

            $username = $_SESSION["username"];

            $user = $dbController->getAllBy("user","username",$username);

            $userId = $user[0][0];
        }

        error_log("userId: ".$userId);

        return $userId;
    }





}