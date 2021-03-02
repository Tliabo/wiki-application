<?php
/*
 * A page for editing users
 *
 *
 * LICENSE:
 *
 * @category File
 * @package Src
 * @subpackage View
 * @copyright Copyright (c) 2021 Kevin Alexander Fronzeck
 * @license
 * @version 1.0
 * @link
 * @since 22.02.21
 *
 */


use Controller\UserController;
use Controller\RoleController;

$userController = new UserController();
$roleController = new RoleController();

echo "
<div class='userCreationContainer'>
    <div class='container-fluid'>
        <form method='post' action='Controller/EventHandling.php' class='was-validated'>
        
            <div class='row'>
                <div class='col-sm-12'>
                    <p class='menuTitle'>Edit Profile</p>
                </div>
            </div>
            
            <div class='row' >
                <div class='col-sm-2'>
                    <input type='text' name='username' value='" . $_SESSION["username"] . "' class='form-control' disabled>
                </div>";

//ToDo: Load Password in box, Align Show Password Icon

echo "
                <div class='col-sm-2'>
                    <div class='input-group'>
                        <input type='password' name='changePassword' id='passwordInput' class='form-control' 
                        placeholder='password' required>
                    
                        <a href='#' ><i class='fa fa-eye-slash' onclick='showPassword()' aria-hidden='true'></i></a>
                    </div>
                    
                    <div class='valid-feedback'>Valid.</div>
                    <div class='invalid-feedback'>Please fill out this field to change your password.</div>
                </div>
            
                <div class='col-sm-2'>";

//ToDo: Email Output

echo "
                    <div class='input-group mb-3'>
                        <select lass='custom-select' class='custom-select' disabled>
                            <option>coming soon</option>
                        </select>
                    </div>
                </div>
                
                <div class='col-sm-2'>";

$userRoleId = $userController->getRoleOfUser();

$userRole = $roleController->getRoleName($userRoleId);

echo "
                    <div class='input-group mb-3'>
                        <select lass='custom-select' class='custom-select' disabled>
                            <option>" . $userRole . "</option>
                        </select>
                    </div>
                </div>

                <div class='col-sm-2'>
                    <button type='submit' class='btn btn-light'>Save Change</button>
                </div>
                
                <div class='col-sm-2'>
            
                </div>
            </div>
        </form>
    </div>
</div>

<hr class='menuDivider'>
";

if ($userController->isAdmin()) {
    $users = $userController->getAllUsers();

    echo "

<div class='userCreationContainer'>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-sm-12'>
                <p class='menuTitle'>Edit Users</p>
            </div>
        </div>";

    foreach ($users as $user) {
        echo "
        
            <form method='post' action='Controller/EventHandling.php' class='was-validated'>

                <div class='row' >
            
                    <span class='col-sm-2'>
                        <input type='text' name='username' value='" . $user["username"] . "' class='form-control' disabled>
                    </span>
            
                    <span class='col-sm-2'>
                         <input type='text' name='changePassword' id='changePassword' value='" . $user["password"] . "'
                         class='form-control' required>

                         <div class='invalid-feedback'>Please fill out this field to change the password.</div>
                    </span>
            
                    <input type='hidden' name='editProfile' id='editProfile'>
            
                    <input type='hidden' name='userId' id='userId' value='" . $user["id"] . "'>
            
                    <span class='col-sm-2'>
                       <input type='text' value='" . $user["mail"] . "'  class='form-control' disabled>
                    </span>
            
                    <span class='col-sm-2'>
                        <div class='input-group mb-3'>
                            <select name='role' class='custom-select'>";

        $roles = $roleController->getAllRoles();

        foreach ($roles as $role) {
            if ($role["id"] == $user["role_fsid"]) {
                echo "<option value='" . $role["id"] . "' selected>" . $role["name"] . "</option>";
            } else {
                echo "<option value='" . $role["id"] . "'>" . $role["name"] . "</option>";
            }
        }


        echo "
                            </select>
                        </div>
                            
                        <div class='invalid-feedback'>Please select a role.</div>
                    </span>
            
                    <span class='col-sm-2'>
                        <button type='submit' class='btn btn-light'>Save Change</button>
                    </span>
                        
                    <span class='col-sm-2'>
                        
                    </span>
                </div>
            </form>";
    }
    echo "
        </div>
    </div>";
}

?>
