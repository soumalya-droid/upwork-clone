<?php
require_once '../config/Database.php';
require_once '../models/Bid.php';

class BidController {

    public function create() {
        // This would be a protected route for 'influencer' role users
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $database = new Database();
            $db = $database->getConnection();

            $bid = new Bid($db);

            $data = json_decode(file_get_contents("php://input"));

            if (
                !empty($data->campaign_id) &&
                !empty($data->bid_price) &&
                !empty($data->proposal)
            ) {
                // In a real app, influencer_id would come from the logged-in user's session
                $bid->influencer_id = 2; // Placeholder
                $bid->campaign_id = $data->campaign_id;
                $bid->bid_price = $data->bid_price;
                $bid->proposal = $data->proposal;

                if ($bid->create()) {
                    http_response_code(201);
                    echo json_encode(array("message" => "Bid was submitted."));
                } else {
                    http_response_code(503);
                    echo json_encode(array("message" => "Unable to submit bid."));
                }
            } else {
                http_response_code(400);
                echo json_encode(array("message" => "Unable to submit bid. Data is incomplete."));
            }
        }
    }

    public function index($campaign_id) {
        // This would be a protected route for the 'company' who owns the campaign
        $database = new Database();
        $db = $database->getConnection();

        $bid = new Bid($db);
        $bid->campaign_id = $campaign_id;
        $stmt = $bid->findByCampaign();
        $num = $stmt->rowCount();

        if($num > 0) {
            $bids_arr = array();
            $bids_arr["records"] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $bid_item = array(
                    "id" => $id,
                    "influencer_name" => $influencer_name,
                    "bid_price" => $bid_price,
                    "proposal" => $proposal,
                    "status" => $status
                );

                array_push($bids_arr["records"], $bid_item);
            }

            http_response_code(200);
            echo json_encode($bids_arr);
        } else {
            http_response_code(404);
            echo json_encode(
                array("message" => "No bids found for this campaign.")
            );
        }
    }
}
