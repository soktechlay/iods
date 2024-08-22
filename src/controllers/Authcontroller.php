<?php
require_once 'src/models/User.php';

class Authcontroller
{
    public function login()
    {
        // Check if the user is already logged in
        if (isset($_SESSION['user_id']) || isset($_SESSION['admin_id'])) {
            header('Location: /iods/login');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if ($username && $password) {
                $userModel = new UserModel();

                // Check if the user is an admin or a regular user
                $admin = $userModel->getAdminByUsername($username);
                $user = $userModel->getUserByUsername($username);

                if ($admin && password_verify($password, $admin['password'])) {
                    $_SESSION['admin_id'] = $admin['id'];
                    header('Location: /iods/dashboard');
                    exit;
                } elseif ($user && password_verify($password, $user['Password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    header('Location: /iods/dashboard');
                    exit;
                }
            }

            // Invalid credentials or missing input
            $_SESSION['error'] = [
                'title' => "Invalid Login",
                'message' => "Incorrect username or password"
            ];
            header('Location: /iods/login');
            exit;
        }

        require 'src/views/auth/login.php';
    }


    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Collect form data
            $username = $_POST['username'];
            $password = $_POST['password'];
            $email = $_POST['email'];

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $userModel = new UserModel();

            // Register the user with the hashed password
            $registrationSuccess = $userModel->create($username, $hashedPassword, $email);

            // Check registration result
            if ($registrationSuccess) {
                // Registration successful
                $_SESSION['success'] = 'បង្កើតគណនីបានជោគជ័យ';
                header('Location: /iods/user'); // Redirect to the registration page or another page
                exit();
            } else {
                // Registration failed
                $_SESSION['error'] = 'បង្កើតគណនីមិនបានជោគជ័យ';
                header('Location: /iods/register'); // Redirect back to the registration page
                exit();
            }
        }
        require 'src/views/auth/register.php';
    }
    public function register()
    {

        require 'src/views/auth/register.php';
    }
}
