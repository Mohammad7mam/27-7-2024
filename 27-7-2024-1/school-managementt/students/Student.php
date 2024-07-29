<?php
class Student {
    private $conn;
    private $table_name = "students";

    public $id;
    public $name;
    public $date_of_birth;
    public $address;
    public $contact_info;

    public function __construct($db) {
        $this->conn = $db;
    }

    function create() {
        $query = "INSERT INTO " . $this->table_name . " SET name=:name, date_of_birth=:date_of_birth, address=:address, contact_info=:contact_info";

        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->date_of_birth = htmlspecialchars(strip_tags($this->date_of_birth));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->contact_info = htmlspecialchars(strip_tags($this->contact_info));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":date_of_birth", $this->date_of_birth);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":contact_info", $this->contact_info);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function read() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->name = $row['name'];
        $this->date_of_birth = $row['date_of_birth'];
        $this->address = $row['address'];
        $this->contact_info = $row['contact_info'];
    }

    function update() {
        $query = "UPDATE " . $this->table_name . " SET name=:name, date_of_birth=:date_of_birth, address=:address, contact_info=:contact_info WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->date_of_birth = htmlspecialchars(strip_tags($this->date_of_birth));
        $this->address = htmlspecialchars(strip_tags($this->address));
        $this->contact_info = htmlspecialchars(strip_tags($this->contact_info));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":date_of_birth", $this->date_of_birth);
        $stmt->bindParam(":address", $this->address);
        $stmt->bindParam(":contact_info", $this->contact_info);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>
