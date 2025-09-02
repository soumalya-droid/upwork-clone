<?php
session_start();

require_once '../config/Database.php';
require_once '../models/User.php';

class AuthController {

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processRegistration();
        } else {
            require_once __DIR__ . '/../views/register.php';
        }
    }

    private function processRegistration() {
        $database = new Database();
        $db = $database->getConnection();

        $user = new User($db);

        $data = json_decode(file_get_contents("php://input"));

        if (
            !empty($data->name) &&
            !empty($data->email) &&
            !empty($data->password) &&
            !empty($data->role)
        ) {
            $user->name = $data->name;
            $user->email = $data->email;
            $user->password = $data->password;
            $user->role = $data->role;

            $existing_user = new User($db);
            $existing_user->email = $user->email;
            if ($existing_user->findByEmail()) {
                http_response_code(409);
                echo json_encode(array("message" => "Email already exists."));
                return;
            }

            if ($user->create()) {
                http_response_code(201);
                echo json_encode(array("message" => "User was created."));
            } else {
                http_response_code(503);
                echo json_encode(array("message" => "Unable to create user."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Unable to create user. Data is incomplete."));
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->processLogin();
        } else {
            require_once __DIR__ . '/../views/login.php';
        }
    }

    private function processLogin() {
        $database = new Database();
        $db = $database->getConnection();
        $user = new User($db);

        $data = json_decode(file_get_contents("php://input"));

        if (!empty($data->email) && !empty($data->password)) {
            $user->email = $data->email;
            $found_user = $user->findByEmail();

            if ($found_user && password_verify($data->password, $found_user->password)) {
                $_SESSION['user_id'] = $found_user->id;
                $_SESSION['user_name'] = $found_user->name;
                $_SESSION['user_role'] = $found_user->role;

                http_response_code(200);
                echo json_encode(array(
                    "message" => "Login successful.",
                    "user" => array(
                        "id" => $found_user->id,
                        "name" => $found_user->name,
                        "role" => $found_user->role
                    )
                ));
            } else {
                http_response_code(401);
                echo json_encode(array("message" => "Login failed. Invalid credentials."));
            }
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Login failed. Data is incomplete."));
        }
    }
}
