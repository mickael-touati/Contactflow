if ($_GET['action'] === 'search') {

    session_start();

    $userId = $_SESSION['user_id'];

    $keyword = $_GET['name'] ?? '';

    $manager = new ContactManager();

    $result = $manager->searchContacts($userId, $keyword);

    echo json_encode($result);
}

if ($_GET['action'] === 'listPaginated') {

    session_start();

    $userId = $_SESSION['user_id'];

    $limit = $_GET['limit'] ?? 5;
    $page = $_GET['page'] ?? 1;

    $offset = ($page - 1) * $limit;

    $manager = new ContactManager();

    $data = $manager->getContactsPaginated($userId, $limit, $offset);

    echo json_encode($data);
}