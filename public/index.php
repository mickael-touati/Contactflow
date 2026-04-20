<?php
require_once __DIR__ . '/../src/Core/Database.php';
require_once __DIR__ . '/../src/Managers/UserManager.php';
require_once __DIR__ . '/../src/Managers/ContactManager.php';

use App\Managers\UserManager;
use App\Managers\ContactManager;

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

// --- Partie contacts ---
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

if (in_array('contacts', $uri)) {
    $contactManager = new ContactManager();
    $id = end($uri) !== 'contacts' ? (int)end($uri) : null;

    if ($method === 'GET') {
        if ($id) {
            echo json_encode($contactManager->getContactById($id));
        } else {
            $limit = $_GET['limit'] ?? 10;
            $offset = $_GET['offset'] ?? 0;
            $search = $_GET['search'] ?? '';
            if ($search) {
                echo json_encode($contactManager->searchContacts(1, $search));
            } else {
                echo json_encode($contactManager->getContactsPaginated(1, $limit, $offset));
            }
        }
        exit;
    }

    if ($method === 'POST') {
        echo json_encode($contactManager->addContact(
            $input['nom'],
            $input['prenom'],
            $input['email'],
            $input['phone'],
            $input['favoris'] ?? 0,
            1
        ));
        exit;
    }

    if ($method === 'PATCH') {
        echo json_encode($contactManager->updateContact(
            $id,
            $input['nom'],
            $input['prenom'],
            $input['email'],
            $input['phone'],
            $input['favoris'] ?? 0
        ));
        exit;
    }

    if ($method === 'DELETE') {
        echo json_encode($contactManager->deleteContact($id));
        exit;
    }
}