<?php
require_once 'src/models/User.php';
require_once 'src/models/document/DocumentModel.php';
class Usercontroller
{
    public function alluser()
    {
        try {
            // Fetch unread notifications
            $userId = $_SESSION['admin_id'] ?? $_SESSION['user_id'] ?? 0;          

            // Fetch all users from API
            $UserModel = new UserModel();

            $allUsers = $UserModel->getAllUsersFromApi($_SESSION['token'], $maxRetries = 3);

            // Check if users were successfully fetched
            if ($allUsers === false || empty($allUsers)) {
                throw new Exception("Failed to fetch users from the API.");
            }

            require 'src/views/admin/alluser.php';

        } catch (Exception $e) {
            // Log the error and redirect to an error page or show an error message
            error_log($e->getMessage());
            $_SESSION['error'] = $e->getMessage();
            header('Location: /error');
            exit;
        }
    }
}
