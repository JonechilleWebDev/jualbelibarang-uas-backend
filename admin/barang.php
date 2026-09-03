<?php
require "../auth/middleware.php";
require "../config/database.php";
require "../controllers/BarangController.php";

// ADMIN ONLY
requireRole(['admin']);

$db = (new Database())->connect();
$controller = new BarangController($db);

$method = $_SERVER['REQUEST_METHOD'];
$id = $_GET['id'] ?? null;
$data = json_decode(file_get_contents("php://input"), true);

switch ($method) {
    case "GET":
        $id ? $controller->show($id) : $controller->index();
        break;

    case "POST":
        $controller->store($data);
        break;

    case "PUT":
        $controller->update($id, $data);
        break;

    case "DELETE":
        $controller->destroy($id);
        break;

    default:
        jsonResponse(["message" => "Method not allowed"], 405);
}
