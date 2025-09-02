<?php

class Campaign {
    private $conn;
    private $table_name = "campaigns";

    public $id;
    public $company_id;
    public $title;
    public $description;
    public $target_audience;
    public $budget;
    public $start_date;
    public $end_date;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET company_id=:company_id, title=:title, description=:description, target_audience=:target_audience, budget=:budget, start_date=:start_date, end_date=:end_date";

        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->company_id=htmlspecialchars(strip_tags($this->company_id));
        $this->title=htmlspecialchars(strip_tags($this->title));
        $this->description=htmlspecialchars(strip_tags($this->description));
        $this->target_audience=htmlspecialchars(strip_tags($this->target_audience));
        $this->budget=htmlspecialchars(strip_tags($this->budget));
        $this->start_date=htmlspecialchars(strip_tags($this->start_date));
        $this->end_date=htmlspecialchars(strip_tags($this->end_date));

        // bind values
        $stmt->bindParam(":company_id", $this->company_id);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":target_audience", $this->target_audience);
        $stmt->bindParam(":budget", $this->budget);
        $stmt->bindParam(":start_date", $this->start_date);
        $stmt->bindParam(":end_date", $this->end_date);


        if($stmt->execute()){
            return true;
        }

        return false;
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}
