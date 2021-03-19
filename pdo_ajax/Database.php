<?php
class Database
{
   private $dsn = "mysql:host=localhost;dbname=pdo_ajax";
   private $user = 'root';
   private $pass = '';
   public $conn;

   public function __construct()
   {
      try {
         $this->conn = new PDO($this->dsn, $this->user, $this->pass);
      } catch (PDOException $e) {
         echo 'error: ' . $e->getMessage();
      }
   }

   public function insert($fname, $lname, $email, $phone)
   {
      $sql = "INSERT INTO users (first_name, last_name, email, phone) VALUES (:fname, :lname, :email, :phone)";
      $pre = $this->conn->prepare($sql);
      $pre->bindParam(':fname', $fname, PDO::PARAM_STR);
      $pre->bindParam(':lname', $lname, PDO::PARAM_STR);
      $pre->bindParam(':email', $email, PDO::PARAM_STR);
      $pre->bindParam(':phone', $phone, PDO::PARAM_STR);
      $pre->execute();
      return true;
   }

   public function read()
   {
      $data = array();
      $sql = "SELECT * FROM users";
      $pre = $this->conn->prepare($sql);
      $pre->execute();
      $result = $pre->fetchAll(PDO::FETCH_ASSOC);
      foreach ($result as $row) {
         $data[] = $row;
      }
      // while ($row = $pre->fetch(PDO::FETCH_ASSOC)) {
      //    $data[] = $row;
      // }
      return $data;
   }

   public function getUserId($id)
   {
      $sql = "SELECT * FROM users WHERE id = :id";
      $pre = $this->conn->prepare($sql);
      $pre->bindParam(':id', $id, PDO::PARAM_INT);
      $pre->execute();
      $result = $pre->fetch(PDO::FETCH_ASSOC);
      return $result;
   }

   public function update($id, $fname, $lname, $email, $phone)
   {
      $sql = "UPDATE users SET first_name=:fname, last_name=:lname, email=:email, phone=:phone WHERE id = :id";
      $pre = $this->conn->prepare($sql);
      $pre->bindParam(':id', $id, PDO::PARAM_INT);
      $pre->bindParam(':fname', $fname, PDO::PARAM_STR);
      $pre->bindParam(':lname', $lname, PDO::PARAM_STR);
      $pre->bindParam(':email', $email, PDO::PARAM_STR);
      $pre->bindParam(':phone', $phone, PDO::PARAM_STR);
      $pre->execute();
      return true;
   }

   public function delete($id)
   {
      $sql = "DELETE FROM users WHERE id = :id";
      $pre = $this->conn->prepare($sql);
      $pre->bindParam(':id', $id, PDO::PARAM_INT);
      $pre->execute();
      return true;
   }

   public function totalRowCount()
   {
      $sql = "SELECT * FROM users";
      $pre = $this->conn->prepare($sql);
      $pre->execute();
      $result = $pre->rowCount();
      return $result;
   }
}
