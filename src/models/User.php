<?php

class UserModel
{
  private $dbh;
  private $url = "http://127.0.0.1:8000";  // Default URL

  public function __construct()
  {
    global $dbh;
    $this->dbh = $dbh;
  }
  // Method to set a new URL using getApi
  public function getApi($url)
  {
    $this->url = $url;
  }
  // Method to get all users with role information

  public function getAllUsersFromApi($token, $maxRetries = 3)
  {
    $url = $this->url . "/api/v1/users";
    $retryCount = 0;
    $response = null;

    while ($retryCount < $maxRetries) {
      // Initialize cURL session
      $ch = curl_init($url);

      // Set cURL options
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token
      ]);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Ignore SSL certificate verification

      // Execute cURL request
      $response = curl_exec($ch);
      $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      $error = curl_error($ch);

      // Close the cURL session
      curl_close($ch);

      // Check for cURL errors
      if ($response === false) {
        error_log("CURL Error (Attempt {$retryCount}): $error");
      } else {
        // Decode the JSON response
        $responseData = json_decode($response, true);

        if (json_last_error() === JSON_ERROR_NONE && $httpCode === 200) {
          if (isset($responseData['data'])) {
            return [
              'http_code' => $httpCode,
              'data' => $responseData['data']
            ];
          } else {
            error_log("Unexpected API Response: " . print_r($responseData, true));
          }
        } else {
          error_log("HTTP Code: $httpCode, JSON Decode Error: " . json_last_error_msg());
        }
      }

      $retryCount++;
      sleep(1); // Add a delay between retries
    }

    // If all retries fail, return error
    return [
      'http_code' => $httpCode ?? 500,
      'error' => $error ?? 'Unknown error occurred',
      'response' => $responseData ?? []
    ];
  }

  // Method to authenticate user
  public function authenticateUser($email, $password, $appkey)
  {
    $url = $this->url . '/api/login';  // Use $this->url dynamically
    $data = json_encode(['email' => $email, 'password' => $password, 'app_key' => $appkey]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      'Content-Type: application/json',
      'Content-Length: ' . strlen($data)
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

    // Ignore SSL certificate verification (only for development)
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    // Debugging output
    if ($response === false) {
      error_log("CURL Error: $error");
      return null;
    }

    $responseData = json_decode($response, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
      error_log("JSON Decode Error: " . json_last_error_msg());
      return null;
    }

    if ($httpCode === 200 && isset($responseData['user'], $responseData['token'])) {
      return [
        'http_code' => $httpCode,
        'user' => $responseData['user'],
        'token' => $responseData['token']
      ];
    } else {
      error_log("Unexpected API Response: " . print_r($responseData, true));
      return [
        'http_code' => $httpCode,
        'response' => $responseData
      ];
    }
  }
  // Method to get role by ID
  public function getRoleApi($roleId, $token)
  {
    // Construct the API URL using the roleId
    $url = $this->url . "/api/v1/roles/" . urlencode($roleId); // Append roleId to the URL

    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      'Authorization: Bearer ' . $token,  // Pass the token for authentication
      'Content-Type: application/json'
    ]);

    // Execute the cURL request
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Check for cURL errors
    if (curl_errno($ch)) {
      $error_msg = curl_error($ch);
      curl_close($ch);
      return ['error' => 'cURL error: ' . $error_msg]; // Handle cURL errors
    }

    // Close the cURL session
    curl_close($ch);

    // Process the response
    if ($httpcode == 200) {
      $result = json_decode($response, true);
      if (isset($result['data']['roleNameKh'])) {
        return $result; // Return the role data
      } else {
        return ['error' => 'API response format is incorrect'];
      }
    } else {
      return ['error' => 'HTTP error: ' . $httpcode . ' - Failed to fetch role from API'];
    }
  }
  public function getRoleLeaveByUserId($userId, $token)
  {
    $url = $this->url . "/api/roleLeave/{$userId}";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      'Authorization: Bearer ' . $token,
      'Content-Type: application/json',
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode === 200) {
      $result = json_decode($response, true);
      if (isset($result['data']) && isset($result['data']['roles'])) {
        return $result['data']['roles']; // Assuming the API returns roles as a string
      }
    } else {
      error_log("Failed to fetch roleLeave data: HTTP $httpCode. Response: $response");
    }

    return null; // Return null if the API call fails or data is missing
  }

  public function getDepartmentsApi($departmentId, $token)
  {
    // Construct the API URL for fetching departments
    $url = $this->url . "/api/v1/departments/" . $departmentId; // Change to include departmentId

    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      'Authorization: Bearer ' . $token,  // Pass the token for authentication
      'Content-Type: application/json'
    ]);

    // Execute the cURL request
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Check for cURL errors
    if (curl_errno($ch)) {
      $error_msg = curl_error($ch);
      curl_close($ch);
      return ['error' => 'cURL error: ' . $error_msg]; // Handle cURL errors
    }

    // Close the cURL session
    curl_close($ch);

    // Process the response
    if ($httpcode == 200) {
      $result = json_decode($response, true);

      // Check if the expected structure exists
      if (isset($result['data'])) {
        return $result; // Return the full response
      } else {
        return ['error' => 'API response format is incorrect'];
      }
    } else {
      return ['error' => 'HTTP error: ' . $httpcode . ' - Failed to fetch departments from API'];
    }
  }
  public function getofficesApi($officeId, $token)
  {
    // Construct the API URL for fetching departments
    $url = $this->url . "/api/v1/offices/" . $officeId; // Change to include departmentId

    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      'Authorization: Bearer ' . $token,  // Pass the token for authentication
      'Content-Type: application/json'
    ]);

    // Execute the cURL request
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Check for cURL errors
    if (curl_errno($ch)) {
      $error_msg = curl_error($ch);
      curl_close($ch);
      return ['error' => 'cURL error: ' . $error_msg]; // Handle cURL errors
    }

    // Close the cURL session
    curl_close($ch);

    // Process the response
    if ($httpcode == 200) {
      $result = json_decode($response, true);

      // Check if the expected structure exists
      if (isset($result['data'])) {
        return $result; // Return the full response
      } else {
        return ['error' => 'API response format is incorrect'];
      }
    } else {
      return ['error' => 'HTTP error: ' . $httpcode . ' - Failed to fetch departments from API'];
    }
  }
  public function getUnitApi($roleLeave, $token)
  {
    // Construct the API URL for fetching departments
    $url = $this->url . "/api/v1/roleLeave/" . $roleLeave; // Change to include departmentId

    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      'Authorization: Bearer ' . $token,  // Pass the token for authentication
      'Content-Type: application/json'
    ]);

    // Execute the cURL request
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Check for cURL errors
    if (curl_errno($ch)) {
      $error_msg = curl_error($ch);
      curl_close($ch);
      return ['error' => 'cURL error: ' . $error_msg]; // Handle cURL errors
    }

    // Close the cURL session
    curl_close($ch);

    // Process the response
    if ($httpcode == 200) {
      $result = json_decode($response, true);

      // Check if the expected structure exists
      if (isset($result['data'])) {
        return $result; // Return the full response
      } else {
        return ['error' => 'API response format is incorrect'];
      }
    } else {
      return ['error' => 'HTTP error: ' . $httpcode . ' - Failed to fetch departments from API'];
    }
  }
  public function getAllDepartments($token)
  {
    // Construct the API URL for fetching all departments
    $url = $this->url . "/api/v1/departments";

    // Check if token is valid
    if (empty($token)) {
      return ['error' => 'Authorization token is missing.'];
    }

    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      'Authorization: Bearer ' . $token,
      'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); // Set a timeout (in seconds)

    // Execute the cURL request
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Check for cURL errors
    if (curl_errno($ch)) {
      return ['error' => 'cURL error: ' . curl_error($ch)];
    }

    // Close the cURL session
    curl_close($ch);

    // Process the response
    if ($httpcode == 200) {
      return json_decode($response, true);
    } else {
      // Handle different HTTP error codes appropriately
      switch ($httpcode) {
        case 401:
          return ['error' => 'Unauthorized: Invalid token.'];
        case 403:
          return ['error' => 'Forbidden: You do not have permission to access this resource.'];
        case 404:
          return ['error' => 'Not Found: The requested resource was not found.'];
        default:
          return ['error' => 'HTTP error: ' . $httpcode];
      }
    }
  }
  public function getAllUserIds()
  {
    $UserModel = new UserModel();

    // Call the API to get all users
    $allUsers = $UserModel->getAllUsersFromApi($_SESSION['token'], $maxRetries = 3);

    // Check if the response contains valid user data
    if (isset($allUsers['data']) && is_array($allUsers['data'])) {
      return array_map(function ($user) {
        return $user['id']; // Adjust this key to match the API's user ID field
      }, $allUsers['data']);
    }

    return []; // Return an empty array if no users are found
  }
  public function getuserapi($token, $maxRetries = 3)
  {
    $url = $this->url . "/api/v1/users";
    $retryCount = 0;
    $response = null;

    while ($retryCount < $maxRetries) {
      // Initialize cURL session
      $ch = curl_init($url);

      // Set cURL options
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token
      ]);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Ignore SSL certificate verification

      // Execute cURL request
      $response = curl_exec($ch);
      $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      $error = curl_error($ch);

      // Close the cURL session
      curl_close($ch);

      // Check for cURL errors
      if ($response === false) {
        error_log("CURL Error (Attempt {$retryCount}): $error");
      } else {
        // Decode the JSON response
        $responseData = json_decode($response, true);

        if (json_last_error() === JSON_ERROR_NONE && $httpCode === 200) {
          if (isset($responseData['data'])) {
            return [
              'http_code' => $httpCode,
              'data' => $responseData['data']
            ];
          } else {
            error_log("Unexpected API Response: " . print_r($responseData, true));
          }
        } else {
          error_log("HTTP Code: $httpCode, JSON Decode Error: " . json_last_error_msg());
        }
      }

      $retryCount++;
      sleep(1); // Add a delay between retries
    }

    // If all retries fail, return error
    return [
      'http_code' => $httpCode ?? 500,
      'error' => $error ?? 'Unknown error occurred',
      'response' => $responseData ?? []
    ];
  }
  private function makeApiRequest($url, $token, $timeout)
  {
    // Initialize cURL session
    $ch = curl_init($url);

    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
      'Authorization: Bearer ' . $token
    ]);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Ignore SSL certificate verification
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);    // Set request timeout

    // Execute cURL request
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);

    // Close the cURL session
    curl_close($ch);

    // Check for cURL errors
    if ($response === false) {
      return [
        'success' => false,
        'http_code' => $httpCode,
        'error' => $error
      ];
    }

    // Decode the JSON response
    $responseData = json_decode($response, true);

    if (json_last_error() === JSON_ERROR_NONE && $httpCode === 200) {
      return [
        'success' => true,
        'http_code' => $httpCode,
        'data' => $responseData['data'] ?? []
      ];
    }

    return [
      'success' => false,
      'http_code' => $httpCode,
      'error' => json_last_error_msg() ?: "Unexpected HTTP Code: $httpCode",
      'data' => $responseData ?? []
    ];
  }
}
