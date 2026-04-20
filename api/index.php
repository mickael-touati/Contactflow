<?php

require_once __DIR__ . '/../src/Core/Database.php';
require_once __DIR__ . '/../src/Managers/ContactManager.php';

use App\Managers\ContactManager;

header("Content-Type: application/json; charset=utf-8");

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? null;

$manager = new ContactManager();

function json($data) {
    echo json_encode($data);
    exit;
}

if (!$action) {
    json(["error" => "no action"]);
}

if ($action === "show") {

    $id = $_GET['id'] ?? null;

    if (!$id) json(["error" => "missing id"]);

    $contact = $manager->getContactById($id);

    json($contact);
}

if ($action === "search") {

    $keyword = $_GET['name'] ?? "";

    $result = $manager->searchContacts(1, $keyword);

    json($result);
}

if ($action === "listPaginated") {

    $limit = $_GET['limit'] ?? 10;
    $offset = $_GET['offset'] ?? 0;

    $data = $manager->getContactsPaginated(1, $limit, $offset);

    json($data);
}

if ($action === "store") {

    $ok = $manager->addContact(
        $_POST['nom'] ?? "",
        $_POST['prenom'] ?? "",
        $_POST['email'] ?? "",
        $_POST['phone'] ?? "",
        0,
        1
    );

    json([
        "success" => $ok
    ]);
}

if ($action === "edit") {

    $id = $_GET['id'] ?? null;

    if (!$id) json(["error" => "missing id"]);

    $ok = $manager->updateContact(
        $id,
        $_POST['nom'] ?? "",
        $_POST['prenom'] ?? "",
        $_POST['email'] ?? "",
        $_POST['phone'] ?? "",
        $_POST['favoris'] ?? 0
    );

    json([
        "success" => $ok
    ]);
}

if ($action === "delete") {

    $id = $_GET['id'] ?? null;

    if (!$id) json(["error" => "missing id"]);

    $ok = $manager->deleteContact($id);

    json([
        "success" => $ok
    ]);
}

json(["error" => "unknown action"]);