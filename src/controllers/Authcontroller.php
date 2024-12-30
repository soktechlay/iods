<?php
require_once 'src/models/User.php';
class Authcontroller
{
    public function login()
    {
        
        // Check if the user is already logged in
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            header('Location: /iods/dashboard');
            exit;
        }

        if (isset($_SESSION['user_id']) || isset($_SESSION['admin_id'])) {
            header('Location: /iods/dashboard');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = htmlspecialchars($_POST['password']);

            if ($email && $password) {
                $userModel = new UserModel();
                $appkey = "6dcad16f83595c43a18c848484de9d3ab58ca8adf824dbb0b583afb3990d5aa1";
                $authResult = $userModel->authenticateUser($email, $password, $appkey);

                if (!$authResult || $authResult['http_code'] !== 200) {
                    $_SESSION['error'] = [
                        'title' => "Authentication Error",
                        'message' => "Invalid email or password."
                    ];
                } else {
                    $user = $authResult['user'];
                    $token = $authResult['token']; // Assign the token here

                    // Handle blocked users
                    if ($user['active'] === '0') {
                        $_SESSION['blocked_user'] = true;
                        $_SESSION['user_khmer_name'] = $user['khmer_name'];
                        $_SESSION['user_profile'] = $user['profile_picture'];
                        require 'src/views/errors/block_page.php';
                        exit;
                    }

                    // Set session data
                    $_SESSION['token'] = $token;
                    $_SESSION['user_khmer_name'] = $user['lastNameKh'] . ' ' . $user['firstNameKh'];

                    // Fetch and set role, department, and office data
                    $this->setAdditionalUserInfo($userModel, $user, $token);

                    // Check if the user's roleLeave is 'superadmin'
                    if ($user['roleLeave'] === 'superadmin') {
                        $_SESSION['isAdmin'] = 'superadmin';
                        $this->setSuperAdminSession($user);
                        header('Location: /iods/dashboard');
                        exit;
                    }

                    // Set session for regular user
                    $this->setRegularUserSession($user, $token);

                    // Redirect to dashboard
                    header('Location: /iods/dashboard');
                    exit;
                }
            } else {
                $_SESSION['error'] = [
                    'title' => "Error",
                    'message' => "Please enter email and password."
                ];
            }
        }

        require 'src/views/auth/login.php';
    }

    public function logout()
    {
        session_start(); // Ensure session is started

        // Unset all session variables
        session_unset();

        // Destroy the session
        session_destroy();

        // Redirect to the login page
        header('Location: /iods/login');
        exit;
    }

    private function setAdditionalUserInfo($userModel, $user, $token)
    {
        // Fetch and set role
        $position = $userModel->getRoleApi($user['roleId'], $token);
        if (isset($position['data']['roleNameKh'])) {
            $_SESSION['position'] = $position['data']['roleNameKh'];
        }

        // Fetch and set department
        $department = $userModel->getDepartmentsApi($user['departmentId'], $token);
        if (isset($department['data']['departmentNameKh'])) {
            $_SESSION['department'] = $department['data']['departmentNameKh'];
        }

        // Fetch and set office
        $office = $userModel->getofficesApi($user['officeId'], $token);
        if (isset($office['data']['officeNameKh'])) {
            $_SESSION['office'] = $office['data']['officeNameKh'];
        }
    }

    private function setSuperAdminSession($user)
    {
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_email'] = $user['email'];
        $_SESSION['admin_name'] = $user['engName'];
        $_SESSION['admin_profile'] = 'https://hrms.iauoffsa.us/images/' . $user['image'];
        $_SESSION['roleLeave'] = $user['roleLeave'];
    }

    private function setRegularUserSession($user, $token)
    {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['departmentId'] = $user['departmentId'];
        $_SESSION['officeId'] = $user['officeId'];
        $_SESSION['user_eng_name'] = $user['engName'];
        $_SESSION['roleLeave'] = $user['roleLeave'];
        $_SESSION['user_profile'] = 'https://hrms.iauoffsa.us/images/' . $user['image'];
    }
}
