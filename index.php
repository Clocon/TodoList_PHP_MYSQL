<?php
require_once './database.php';

$request = $_SERVER['REQUEST_METHOD'];
switch ($request) {
  case '':
  case 'GET':
    consultTarea($conect);
    break;
  case 'POST':
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    addTarea($data['title'], $data['description'], $dateCreated, $conect);
    break;
  case 'PUT':
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    editTarea($data['id'], $data['description'], $data['category'], $conect);
    break;
  case 'DELETE':
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    deleteTarea($data['id'], $conect);
    break;
  default:
    http_response_code(404);
    break;
}