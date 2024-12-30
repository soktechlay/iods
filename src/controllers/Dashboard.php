<?php
require_once 'src/models/User.php';
require_once 'src/models/document/DocumentModel.php';

class Dashboard
{
    public function dashboard()
    {
        

        if (!isset($_SESSION['user_id']) && !isset($_SESSION['isAdmin'])) {
            // Redirect to login if no session is active
            header('Location: /iods/login');
            exit;
        }

        // Check for superadmin role
        if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] === 'superadmin') {
            require 'src/views/dashboard/admin.php';
            exit;
        }

        // Check for roleLeave-based roles
        if (isset($_SESSION['roleLeave'])) {
            $roleLeave = $_SESSION['roleLeave'];
            $roleMapping = [
                // 'superadmin' => 'admin.php',
                'Head Of Unit' => 'head_of_unit.php',
                'Deputy Head Of Unit 1' => 'deputy_head.php',
                'Deputy Head Of Unit 2' => 'deputy_head.php',
                'Head Of Department' => 'head_of_department.php',
                'Deputy Head Of Department' => 'head_of_department.php',
                'Head Of Office' => 'head_of_office.php',
                'Deputy Head Of Office' => 'head_of_office.php',
            ];

            if (array_key_exists($roleLeave, $roleMapping)) {
                require 'src/views/dashboard/' . $roleMapping[$roleLeave];
                exit;
            } else {
                // Redirect to login for unrecognized roles
                header('Location: /iods/login');
                exit;
            }
        }

        // Default case for NULL or unrecognized roles
        require 'src/views/dashboard/user.php';
        exit;
    }
}
