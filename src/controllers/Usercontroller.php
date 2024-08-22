<?php
require_once 'src/models/User.php';

class Usercontroller
{
    public function createuser()
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
            $registrationSuccess = $userModel->createuser($username, $hashedPassword, $email);

            // Check registration result
            if ($registrationSuccess) {
                // Registration successful
                $_SESSION['success'] = 'បង្កើតគណនីបានជោគជ័យ';
                header('Location: /iods/createuser'); // Redirect to the registration page or another page
                exit();
            } else {
                // Registration failed
                $_SESSION['error'] = 'បង្កើតគណនីមិនបានជោគជ័យ';
                header('Location: /iods/createuser'); // Redirect back to the registration page
                exit();
            }
        }

        $getuserModel = new UserModel();
        $getAllusers = $getuserModel->getAlluser();
        require 'src/views/admin/createuser.php';
    }
}
