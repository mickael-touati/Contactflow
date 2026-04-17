<?php
use App\Managers\UserManager;

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';
$input = json_decode(file_get_contents('php://input'), true);

$userManager = new UserManager();

if ($method === 'POST') {
    if ($action === 'register' && isset($input['username'], $input['password'])) {
        $success = $userManager->register($input['username'], $input['password']);
        echo json_encode(['success' => $success]);
        exit;
    } 
    
    if ($action === 'login' && isset($input['username'], $input['password'])) {
        $userId = $userManager->login($input['username'], $input['password']);
        if ($userId) {
            echo json_encode(['success' => true, 'userId' => $userId]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Identifiants incorrects']);
        }
        exit;
    }
}
