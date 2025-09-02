<?php
require_once '../config/Database.php';
require_once '../models/Campaign.php';

class CampaignController {

    public function create() {
        // This would be a protected route for 'company' role users
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $database = new Database();
            $db = $database->getConnection();

            $campaign = new Campaign($db);

            $data = json_decode(file_get_contents("php://input"));

            if (
                !empty($data->title) &&
                !empty($data->description) &&
                !empty($data->budget) &&
                !empty($data->start_date) &&
                !empty($data->end_date)
            ) {
                // In a real app, company_id would come from the logged-in user's session
                $campaign->company_id = 1; // Placeholder
                $campaign->title = $data->title;
                $campaign->description = $data->description;
                $campaign->target_audience = $data->target_audience ?? '';
                $campaign->budget = $data->budget;
                $campaign->start_date = $data->start_date;
                $campaign->end_date = $data->end_date;

                if ($campaign->create()) {
                    http_response_code(201);
                    echo json_encode(array("message" => "Campaign was created."));
                } else {
                    http_response_code(503);
                    echo json_encode(array("message" => "Unable to create campaign."));
                }
            } else {
                http_response_code(400);
                echo json_encode(array("message" => "Unable to create campaign. Data is incomplete."));
            }
        } else {
            // Show the form to create a campaign
            require_once '../views/create_campaign.php';
        }
    }

    public function index() {
        $database = new Database();
        $db = $database->getConnection();

        $campaign = new Campaign($db);
        $stmt = $campaign->readAll();
        $num = $stmt->rowCount();

        if($num > 0) {
            $campaigns_arr = array();
            $campaigns_arr["records"] = array();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $campaign_item = array(
                    "id" => $id,
                    "title" => $title,
                    "description" => html_entity_decode($description),
                    "budget" => $budget,
                    "start_date" => $start_date,
                    "end_date" => $end_date
                );

                array_push($campaigns_arr["records"], $campaign_item);
            }

            http_response_code(200);
            echo json_encode($campaigns_arr);
        } else {
            http_response_code(404);
            echo json_encode(
                array("message" => "No campaigns found.")
            );
        }
    }
}
