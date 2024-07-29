<?php
class Exam {
    private $conn;
    private $table_name = "exams";

    public $id;
    public $subject_id;
    public $date;
    public $max_score;

    public function __construct($db) {
        $this->conn = $db;
    }

    function create() {
        $query = "INSERT INTO " . $this->table_name . " SET subject_id=:subject_id, date=:date, max_score=:max_score";

        $stmt = $this->conn->prepare($query);

        $this->subject_id=htmlspecialchars(strip_tags($this->subject_id));
        $this->date=htmlspecialchars(strip_tags($this->date));
        $this->max_score=htmlspecialchars(strip_tags($this->max_score));

        $stmt->bindParam(":subject_id", $this->subject_id);
        $stmt->bindParam(":date", $this->date);
        $stmt->bindParam(":max_score", $this->max_score);

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
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row) {
            $this->subject_id = $row['subject_id'];
            $this->date = $row['date'];
            $this->max_score = $row['max_score'];
        }
    }

    function update() {
        $query = "UPDATE " . $this->table_name . " SET subject_id = :subject_id, date = :date, max_score = :max_score WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->subject_id=htmlspecialchars(strip_tags($this->subject_id));
        $this->date=htmlspecialchars(strip_tags($this->date));
        $this->max_score=htmlspecialchars(strip_tags($this->max_score));
        $this->id=htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':subject_id', $this->subject_id);
        $stmt->bindParam(':date', $this->date);
        $stmt->bindParam(':max_score', $this->max_score);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        $this->id=htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>
