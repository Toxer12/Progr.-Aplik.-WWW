<?php
session_start();
include('../cfg.php');

function FormularzLogowania() {
    echo '
    <form method="post">
        <label>Login: <input type="text" name="login"></label><br>
        <label>Hasło: <input type="password" name="pass"></label><br>
        <input type="submit" name="submit" value="Zaloguj">
    </form>
    ';
}

if (isset($_POST['submit'])) {
    if ($_POST['login'] === $login && $_POST['pass'] === $pass) {
        $_SESSION['logged_in'] = true;
        header("Location: admin.php");
        exit;
    } else {
        echo "<p>Błąd logowania. Spróbuj ponownie.</p>";
        FormularzLogowania();
        exit;
    }
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    FormularzLogowania();
    exit;
}

function ListaPodstron($conn) {
    $sql = "SELECT id, page_title FROM page_list";
    $result = $conn->query($sql);

    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Tytuł</th><th>Akcje</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['page_title'] . "</td>";
        echo "<td>
            <a href='admin.php?edit=" . $row['id'] . "'>Edytuj</a> |
            <a href='admin.php?delete=" . $row['id'] . "'>Usuń</a>
        </td>";
        echo "</tr>";
    }

    echo "</table>";
}


function EdytujPodstrone($conn, $id) {
    if (isset($_POST['update'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $status = isset($_POST['status']) ? 1 : 0;

        $sql = "UPDATE page_list SET page_title = ?, page_content = ?, status = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $title, $content, $status, $id);
        $stmt->execute();

        echo "<p>Podstrona została zaktualizowana.</p>";
        return;
    }

    $sql = "SELECT * FROM page_list WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    echo '
    <form method="post">
        <label>Tytuł: <input type="text" name="title" value="' . $row['page_title'] . '"></label><br>
        <label>Treść: <textarea name="content">' . $row['page_content'] . '</textarea></label><br>
        <label>Aktywna: <input type="checkbox" name="status" ' . ($row['status'] ? 'checked' : '') . '></label><br>
        <input type="submit" name="update" value="Zaktualizuj">
    </form>
    ';
}

function DodajNowaPodstrone($conn) {
    if (isset($_POST['add'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $status = isset($_POST['status']) ? 1 : 0;

        $sql = "INSERT INTO page_list (page_title, page_content, status) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $title, $content, $status);
        $stmt->execute();

        echo "<p>Nowa podstrona została dodana.</p>";
        return;
    }

    echo '
    <form method="post">
        <label>Tytuł: <input type="text" name="title"></label><br>
        <label>Treść: <textarea name="content"></textarea></label><br>
        <label>Aktywna: <input type="checkbox" name="status"></label><br>
        <input type="submit" name="add" value="Dodaj">
    </form>
    ';
}

function UsunPodstrone($conn, $id) {
    $sql = "DELETE FROM page_list WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    echo "<p>Podstrona została usunięta.</p>";
}

echo '<a href="admin.php?add=true"><button>Dodaj nową podstronę</button></a><br><br>';

if (isset($_GET['edit'])) {
    EdytujPodstrone($conn, intval($_GET['edit']));
} elseif (isset($_GET['delete'])) {
    UsunPodstrone($conn, intval($_GET['delete']));
} elseif (isset($_GET['add']) && $_GET['add'] == 'true') {
    DodajNowaPodstrone($conn);
} else {
    ListaPodstron($conn);
}
?>
