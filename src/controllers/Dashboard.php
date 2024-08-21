<?php
class Dashboard
{
    public function dashboard()
    {
        // Start the session if it's not already started
        // if (session_status() == PHP_SESSION_NONE) {
        //     session_start();
        // }

        // Check if the user is logged in as admin
        if (isset($_SESSION['admin_id'])) {
            // Load the admin dashboard
            require 'src/views/dashboard/admin.php';
        } elseif (isset($_SESSION['user_id'])) {
            // Load the user dashboard if logged in as a regular user
            require 'src/views/dashboard/user.php';
        } else {
            // If not logged in, redirect to the login page
            header('Location: /iods/login');
            exit;
        }
    }
}
