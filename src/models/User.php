<?php
// models/UserModel.php
class UserModel
{
  private $dbh;

  public function __construct()
  {
    global $dbh;
    $this->dbh = $dbh;
  }

  public function getUserByUsername($username)
  {
    $query = "SELECT id, UserName, Email, Password FROM tbluser WHERE UserName = :username";
    $stmt = $this->dbh->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function getAlluser()
  {
    $query = "SELECT * FROM tbluser ORDER BY id DESC";
    $stmt = $this->dbh->prepare($query);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function getAdminByUsername($username)
  {
    $query = "SELECT id, username, email, password  FROM admins WHERE UserName = :username";
    $stmt = $this->dbh->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function create($username, $hashedPassword, $email)
  {
    try {
      // Prepare an SQL statement
      $sql = $this->dbh->prepare("INSERT INTO tbluser (username, password, email, created_at, updated_at) 
                                    VALUES (?, ?, ?, NOW(), NOW())");

      // Execute the query with bound parameters
      $sql->execute([$username, $hashedPassword, $email]);

      // Return success
      return true;
    } catch (PDOException $e) {
      // Handle any errors
      error_log("Error in createUser: " . $e->getMessage());
      return false;
    }
  }

  public function createuser($username, $hashedPassword, $email)
  {
    try {
      // Prepare an SQL statement
      $sql = $this->dbh->prepare("INSERT INTO tbluser (username, password, email, created_at, updated_at) 
                                    VALUES (?, ?, ?, NOW(), NOW())");

      // Execute the query with bound parameters
      $sql->execute([$username, $hashedPassword, $email]);

      // Return success
      return true;
    } catch (PDOException $e) {
      // Handle any errors
      error_log("Error in createUser: " . $e->getMessage());
      return false;
    }
  }
}
