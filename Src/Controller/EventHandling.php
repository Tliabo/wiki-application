<?php

/*
 * A file handling user interaction and calling neccessary functzions
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
 * @since 17.02.21
 *
 */

use Controller\ArticleController;
use Controller\UserController;
use Controller\LinkController;

use Controller\LoginController;
use Controller\LogoutController;


$articleController = new ArticleController();
$userController = new UserController();
$linkController = new LinkController();

$loginController = new LoginController();
$logoutController = new LogoutController();


//Logout Event
if (isset($_POST["logout"])) {
    $logoutController->logout();
}

if (isset($_POST["articleTest"])) {
//    $articleController = new ArticleController();
//    $articleController->getAllArticles();
    header('location: http://localhost/wiki/?site=articleView');
}

//Article Save Event
if (isset($_POST["articleHidden"]) && isset($_POST["articleTitle"]) && isset($_POST["articleText"])) {
    $articleController->saveArticleInDb($_POST["articleTitle"], $_POST["articleText"], $_POST["articleCategory"],
      $_POST["visibilityFilter"]);
    header('location: http://localhost/wiki/?site=articleView');
}

//Article Update Event
if (isset($_POST["articleHiddenUpdate"]) && isset($_POST["articleTitle"]) && isset($_POST["articleText"])) {
    if ($_POST["visibilityFilter"]) {
        $visibility = $_POST["visibilityFilter"];
    } else {
        $visibility = 5;
    }

    $articleController->updateArticleInDb($_POST["articleId"], $_POST["articleTitle"], $_POST["articleText"],
      $_POST["articleCategory"], $visibility);

    header('location: http://localhost/wiki/?site=articleView');
}


//Login Event
if (isset($_POST["loginHidden"]) && isset($_POST["usernameInput"]) && isset($_POST["passwordInput"])) {
    $username = $_POST["usernameInput"];
    $password = $_POST["passwordInput"];

    $loginController->login($username, $password);
}


//User Save Event
if (isset($_POST["newUserHidden"])) {
    $username = $_POST["newUsername"];
    $password = $_POST["newPassword"];
    $email = $_POST["newEmail"];
    $role = $_POST["roleSelect"];
    $group = $_POST["groupSelect"];

    $userController->createNewUser($username, $email, $password, $role, $group);

    header('location: http://localhost/wiki/?site=articleView');
}

if (isset($_POST["userEdit"])) {
    header('location: http://localhost/wiki/?site=userProfile');
}

if (isset($_POST["editProfile"])) {
    $password = $_POST["changePassword"];

    if (isset($_POST["role"])) {
        $role = $_POST["role"];
    } else {
        $role = $userController->getRoleOfUser();
    }

    if (isset($_POST["userId"])) {
        $id = $_POST["userId"];
    } else {
        $id = $userController->getUserId();
    }

    $userController->updateUser($password, $role, $id);


    header('location: http://localhost/wiki/?site=userProfile');
}


if (isset($_POST["linkHidden"])) {
    $linkURL = $_POST["linkURL"];
    $linkName = $_POST["linkName"];
    $currentArticleId = $_POST["linkHidden"];

    $linkController->saveLink($linkURL, $linkName, $currentArticleId);

    header('location: http://localhost/wiki/?site=articleCreation&articleId=' . $currentArticleId);
}

if (isset($_POST["filter"])) {
    $filterWord = $_POST["categoryFilter"];

    header('location: http://localhost/wiki/?site=articleView&category=' . $filterWord);
}


//route to articleCreation
if (isset($_POST["createNew"])) {
    header('location: http://localhost/wiki/?site=articleCreation');
}


//route to articleCreation(Own Article View)
if (isset($_POST["editArticle"])) {
    header('location: http://localhost/wiki/?site=articleView&permission=own');
}


if (isset($_POST["userCreation"])) {
    header('location: http://localhost/wiki/?site=userCreation');
}


if (isset($_POST["articleId"])) {
    $articleId = $_POST["articleId"];
    header('location: http://localhost/wiki/?site=articleCreation&articleId=' . $articleId);
}

if (isset($_POST["articleView"])) {
    header('location: http://localhost/wiki/?site=articleView');
}