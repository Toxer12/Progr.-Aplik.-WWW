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

// SKLEP

include('../categories.php');

echo '<h2>Dodaj nową kategorię</h2>';
echo '<form method="POST" action="">
    Nazwa kategorii: <input type="text" name="nazwa" required><br>
    Kategoria nadrzędna: 
    <select name="matka">
        <option value="0">Brak (kategoria główna)</option>';

// Pobierz dostępne kategorie nadrzędne
$sql = "SELECT * FROM categories WHERE matka = 0";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['nazwa']) . '</option>';
}

echo '</select><br>
    <button type="submit" name="dodaj">Dodaj kategorię</button>
</form>';

if (isset($_POST['dodaj'])) {
    DodajKategorie($_POST['nazwa'], $_POST['matka']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();

}

echo '<h2>Lista kategorii</h2>';
PokazKategorie();

echo '<h2>Usuń kategorię</h2>';
echo '<form method="POST" action="">
    ID kategorii: <input type="number" name="id" required><br>
    <button type="submit" name="usun">Usuń kategorię</button>
</form>';

if (isset($_POST['usun'])) {
    UsunKategorie($_POST['id']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();

}

echo '<h2>Edytuj kategorię</h2>';
echo '<form method="POST" action="">
    ID kategorii: <input type="number" name="id" required><br>
    Nowa nazwa: <input type="text" name="nowaNazwa" required><br>
    <button type="submit" name="edytuj">Edytuj kategorię</button>
</form>';

if (isset($_POST['edytuj'])) {
    EdytujKategorie($_POST['id'], $_POST['nowaNazwa']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

function Wyloguj() {
    session_unset(); // Usuwa zmienne sesyjne
    session_destroy(); // Kończy sesję
    header("Location: admin.php"); // Przekierowanie na stronę główną
    exit();
}

if (isset($_POST['logout'])) {
    Wyloguj();
}

// Wyświetlanie guzika wylogowania
echo '
<form method="POST" action="">
    <button type="submit" name="logout">Wyloguj</button>
</form>
';
?>