<?php

class Bid {
    private $conn;
    private $table_name = "bids";

    public $id;
    public $campaign_id;
    public $influencer_id;
    public $bid_price;
    public $proposal;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET campaign_id=:campaign_id, influencer_id=:influencer_id, bid_price=:bid_price, proposal=:proposal";

        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->campaign_id=htmlspecialchars(strip_tags($this->campaign_id));
        $this->influencer_id=htmlspecialchars(strip_tags($this->influencer_id));
        $this->bid_price=htmlspecialchars(strip_tags($this->bid_price));
        $this->proposal=htmlspecialchars(strip_tags($this->proposal));

        // bind values
        $stmt->bindParam(":campaign_id", $this->campaign_id);
        $stmt->bindParam(":influencer_id", $this->influencer_id);
        $stmt->bindParam(":bid_price", $this->bid_price);
        $stmt->bindParam(":proposal", $this->proposal);

        if($stmt->execute()){
            return true;
        }

        return false;
    }

    public function findByCampaign() {
        $query = "SELECT b.*, u.name as influencer_name FROM " . $this->table_name . " b LEFT JOIN users u ON b.influencer_id = u.id WHERE b.campaign_id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->campaign_id);
        $stmt->execute();

        return $stmt;
    }
}
