<?php
session_start();
require_once 'cfg.php';

function FormularzLogowania() {
    $form = '
    <div class="login-form">
        <h2>Panel administracyjny</h2>
        <form method="post" action="admin.php">
            <div>
                <label for="login">Login:</label>
                <input type="text" name="login" id="login" required>
            </div>
            <div>
                <label for="password">Has�o:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <button type="submit" name="logowanie">Zaloguj</button>
        </form>
    </div>';

    return $form;
}

function DodajNowaPodstrone() {
    $form = '
    <div class="add-page-form">
        <h2>Dodaj now� podstron�</h2>
        <form method="post" action="admin.php?action=add">
            <div>
                <label for="page_title">Tytu�:</label>
                <input type="text" name="page_title" id="page_title" required>
            </div>
            <div>
                <label for="page_content">Tre��:</label>
                <textarea name="page_content" id="page_content" rows="10" required></textarea>
            </div>
            <div>
                <label>
                    <input type="checkbox" name="status" value="1" checked> Strona aktywna
                </label>
            </div>
            <button type="submit" name="add">Dodaj stron�</button>
        </form>
    </div>';
    return $form;
}

function insertPage() {
    global $db;
    if (!isset($_POST['add'])) return false;

    $title = $_POST['page_title'] ?? '';
    $content = $_POST['page_content'] ?? '';
    $status = isset($_POST['status']) ? 1 : 0;

    try {
        $query = "INSERT INTO page_list (page_title, page_content, status) VALUES (:title, :content, :status)";
        $stmt = $db->prepare($query);
        return $stmt->execute([
            'title' => $title,
            'content' => $content,
            'status' => $status
        ]);
    } catch(PDOException $e) {
        return false;
    }
}

function updatePage() {
    global $db;
    if (!isset($_POST['update'])) return false;

    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
    $title = $_POST['page_title'] ?? '';
    $content = $_POST['page_content'] ?? '';
    $status = isset($_POST['status']) ? 1 : 0;

    try {
        $query = "UPDATE page_list SET
                  page_title = :title,
                  page_content = :content,
                  status = :status
                  WHERE id = :id";

        $stmt = $db->prepare($query);
        return $stmt->execute([
            'title' => $title,
            'content' => $content,
            'status' => $status,
            'id' => $id
        ]);
    } catch(PDOException $e) {
        return false;
    }
}

function EdytujPodstrone() {
    global $db;
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    try {
        $query = "SELECT * FROM page_list WHERE id = :id LIMIT 1";
        $stmt = $db->prepare($query);
        $stmt->execute(['id' => $id]);
        $page = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$page) {
            return "Nie znaleziono strony.";
        }

        $form = '
        <div class="edit-form">
            <h2>Edycja podstrony</h2>
            <form method="post" action="admin.php?action=update&id=' . $id . '">
                <div>
                    <label for="page_title">Tytu�:</label>
                    <input type="text" name="page_title" id="page_title" value="' . htmlspecialchars($page['page_title']) . '" required>
                </div>
                <div>
                    <label for="page_content">Tre��:</label>
                    <textarea name="page_content" id="page_content" rows="10" required>' . htmlspecialchars($page['page_content']) . '</textarea>
                </div>
                <div>
                    <label>
                        <input type="checkbox" name="status" value="1" ' . ($page['status'] ? 'checked' : '') . '> Strona aktywna
                    </label>
                </div>
                <button type="submit" name="update">Zapisz zmiany</button>
            </form>
        </div>';

        return $form;
    } catch(PDOException $e) {
        return "B��d bazy danych: " . $e->getMessage();
    }
}

function UsunPodstrone() {
    global $db;
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    try {
        $query = "DELETE FROM page_list WHERE id = :id LIMIT 1";
        $stmt = $db->prepare($query);
        return $stmt->execute(['id' => $id]);
    } catch(PDOException $e) {
        return false;
    }
}

function ListaPodstron() {
    global $db;

    try {
        $query = "SELECT id, page_title FROM page_list";
        $result = $db->query($query);

        $html = '<div class="page-list">';
        $html .= '<h2>Lista podstron</h2>';
        $html .= '<table border="1">';
        $html .= '<tr><th>ID</th><th>Tytu�</th><th>Akcje</th></tr>';

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $html .= '<tr>';
            $html .= '<td>' . $row['id'] . '</td>';
            $html .= '<td>' . htmlspecialchars($row['page_title']) . '</td>';
            $html .= '<td>';
            $html .= '<a href="?action=edit&id=' . $row['id'] . '" class="button">Edytuj</a> ';
            $html .= '<a href="?action=delete&id=' . $row['id'] . '" class="button" onclick="return confirm(\'Czy na pewno chcesz usun��?\')">Usu�</a>';
            $html .= '</td>';
            $html .= '</tr>';
        }

        $html .= '</table>';
        $html .= '</div>';
        return $html;
    } catch(PDOException $e) {
        return "B��d bazy danych: " . $e->getMessage();
    }
}

function sprawdzLogowanie() {
    if (isset($_POST['logowanie'])) {
        $login = $_POST['login'] ?? '';
        $pass = $_POST['password'] ?? '';

        if ($login === ADMIN_LOGIN && $pass === ADMIN_PASSWORD) {
            $_SESSION['logged_in'] = true;
            return true;
        }
        echo '<p class="error">B��dny login lub has�o!</p>';
    }
    return false;
}

// Main logic
if (!isset($_SESSION['logged_in']) && !sprawdzLogowanie()) {
    echo FormularzLogowania();
    exit();
}

?>

<div class="admin-panel">
    <h1>Panel Administratora v1.6</h1>
    <nav>
        <ul>
            <li><a href="?action=pages">Zarz�dzaj stronami</a></li>
            <li><a href="?action=add_page">Dodaj podstron�</a></li>
            <li><a href="?action=logout">Wyloguj</a></li>
        </ul>
    </nav>
</div>

<?php
if (isset($_GET['action'])) {
    switch($_GET['action']) {
        case 'pages':
            echo ListaPodstron();
            break;
        case 'edit':
            echo EdytujPodstrone();
            break;
        case 'update':
            if (updatePage()) {
                header('Location: admin.php?action=pages');
                exit();
            }
            echo "B��d podczas aktualizacji strony.";
            break;
        case 'add_page':
            echo DodajNowaPodstrone();
            break;
        case 'add':
            if (insertPage()) {
                header('Location: admin.php?action=pages');
                exit();
            }
            echo "B��d podczas dodawania strony.";
            break;
        case 'delete':
            if (UsunPodstrone()) {
                header('Location: admin.php?action=pages');
                exit();
            }
            echo "B��d podczas usuwania strony.";
            break;
        case 'logout':
            session_destroy();
            header('Location: admin.php');
            exit();
            break;
    }
}
?>
