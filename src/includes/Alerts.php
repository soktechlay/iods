<?php
session_start(); // Start the session

function showAlert($type, $message) {
    $alertType = '';

    switch ($type) {
        case 'success':
            $alertType = 'alert-success';
            break;
        case 'error':
            $alertType = 'alert-danger';
            break;
        default:
            $alertType = 'alert-secondary';
            break;
    }

    echo "<div class='alert {$alertType} alert-dismissible fade show' role='alert'>
            {$message}
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
}

// Display success alert if set
if (isset($_SESSION['success'])) {
    showAlert('success', $_SESSION['success']);
    unset($_SESSION['success']); // Clear the message after displaying it
}

// Display error alert if set
if (isset($_SESSION['error'])) {
    showAlert('error', $_SESSION['error']);
    unset($_SESSION['error']); // Clear the message after displaying it
}
?>
