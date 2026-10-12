<?php
class User {
    private $conn;
    private $table_name = "users";

    public $user_id;
    public $full_name;
    public $phone_number;
    public $role;
    public $language_preference;
    public $password_hash;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function register() {
        $query = "INSERT INTO " . $this->table_name . " 
                  (full_name, phone_number, password_hash, language_preference) 
                  VALUES (:full_name, :phone_number, :password_hash, :language_preference)";

        $stmt = $this->conn->prepare($query);

        $this->full_name = htmlspecialchars(strip_tags($this->full_name));
        $this->phone_number = htmlspecialchars(strip_tags($this->phone_number));
        $this->language_preference = htmlspecialchars(strip_tags($this->language_preference));

        $stmt->bindParam(":full_name", $this->full_name);
        $stmt->bindParam(":phone_number", $this->phone_number);
        $stmt->bindParam(":password_hash", $this->password_hash);
        $stmt->bindParam(":language_preference", $this->language_preference);

        return $stmt->execute();
    }

    public function login() {
        $query = "SELECT user_id, full_name, role, language_preference, password_hash 
                  FROM " . $this->table_name . " 
                  WHERE phone_number = :phone_number LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $this->phone_number = htmlspecialchars(strip_tags($this->phone_number));
        $stmt->bindParam(":phone_number", $this->phone_number);
        $stmt->execute();

        return $stmt;
    }
}
?>