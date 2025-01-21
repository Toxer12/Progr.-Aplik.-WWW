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

function DodajKategorie($nazwa, $matka = 0) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO categories (nazwa, matka) VALUES (?, ?)");
    $stmt->bind_param("si", $nazwa, $matka);
    $stmt->execute();
    echo "Kategoria została dodana pomyślnie.<br>";
    $stmt->close();
}

function UsunKategorie($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = ? OR matka = ?");
    $stmt->bind_param("ii", $id, $id);
    $stmt->execute();
    echo "Kategoria została usunięta.<br>";
    $stmt->close();
}

function EdytujKategorie($id, $nowaNazwa) {
    global $conn;
    $stmt = $conn->prepare("UPDATE categories SET nazwa = ? WHERE id = ?");
    $stmt->bind_param("si", $nowaNazwa, $id);
    $stmt->execute();
    echo "Kategoria została zaktualizowana.<br>";
    $stmt->close();
}

function PokazKategorie() {
    global $conn;
    $sqlMatki = "SELECT * FROM categories WHERE matka = 0"; // Wybierz kategorie główne
    $resultMatki = $conn->query($sqlMatki);

    echo "<ul>";
    while ($matka = $resultMatki->fetch_assoc()) {
        echo "<li>[" . $matka['id'] . "] " . htmlspecialchars($matka['nazwa']) . "</li>";
        
        // Pobierz podkategorie dla tej matki
        $stmt = $conn->prepare("SELECT * FROM categories WHERE matka = ?");
        $stmt->bind_param("i", $matka['id']);
        $stmt->execute();
        $resultDzieci = $stmt->get_result();
        
        if ($resultDzieci->num_rows > 0) {
            echo "<ul>";
            while ($dziecko = $resultDzieci->fetch_assoc()) {
                echo "<li>[" . $dziecko['id'] . "] " . htmlspecialchars($dziecko['nazwa']) . "</li>";
            }
            echo "</ul>";
        }
        $stmt->close();
    }
    echo "</ul>";
}


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
</form>';

///////////////////////////////////////////////

// Funkcje CRUD
function DodajProdukt($conn, $tytul, $opis, $data_wygasniecia, $cena_netto, $podatek_vat, $ilosc, $status_dostepnosci, $kategoria, $gabaryt, $zdjecie) {
    $sql = "INSERT INTO produkty (tytul, opis, data_wygasniecia, cena_netto, podatek_vat, ilosc, status_dostepnosci, kategoria, gabaryt_produktu, zdjecie) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssddissss", $tytul, $opis, $data_wygasniecia, $cena_netto, $podatek_vat, $ilosc, $status_dostepnosci, $kategoria, $gabaryt, $zdjecie);
    $stmt->execute();
    $stmt->close();
}

function UsunProdukt($conn, $id) {
    $sql = "DELETE FROM produkty WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

function EdytujProdukt($conn, $id, $tytul, $opis, $data_wygasniecia, $cena_netto, $podatek_vat, $ilosc, $status_dostepnosci, $kategoria, $gabaryt, $zdjecie) {
    $sql = "UPDATE produkty 
            SET tytul = ?, opis = ?, data_wygasniecia = ?, cena_netto = ?, podatek_vat = ?, ilosc = ?, status_dostepnosci = ?, kategoria = ?, gabaryt_produktu = ?, zdjecie = ? 
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssddissssi", $tytul, $opis, $data_wygasniecia, $cena_netto, $podatek_vat, $ilosc, $status_dostepnosci, $kategoria, $gabaryt, $zdjecie, $id);
    $stmt->execute();
    $stmt->close();
}

function PokazProdukty($conn) {
    $sql = "SELECT * FROM produkty";
    $result = $conn->query($sql);

    echo "<table border='1' cellpadding='10'>";
    echo "<tr>
            <th>ID</th>
            <th>Tytuł</th>
            <th>Opis</th>
            <th>Cena netto</th>
            <th>VAT</th>
            <th>Ilość</th>
            <th>Status</th>
            <th>Kategoria</th>
            <th>Gabaryt</th>
            <th>Zdjęcie</th>
            <th>Akcje</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['tytul'] . "</td>";
        echo "<td>" . $row['opis'] . "</td>";
        echo "<td>" . $row['cena_netto'] . " zł</td>";
        echo "<td>" . $row['podatek_vat'] . "%</td>";
        echo "<td>" . $row['ilosc'] . "</td>";
        echo "<td>" . ($row['status_dostepnosci'] ? "Dostępny" : "Niedostępny") . "</td>";
        echo "<td>" . $row['kategoria'] . "</td>";
        echo "<td>" . $row['gabaryt_produktu'] . "</td>";
        echo "<td><img src='" . $row['zdjecie'] . "' alt='Zdjęcie produktu' width='50'></td>";
        echo "<td>
                <a href='?page=produkty&action=form&id=" . $row['id'] . "'>Edytuj</a>
                <form method='POST' style='display:inline;'>
                    <input type='hidden' name='action' value='delete'>
                    <input type='hidden' name='id' value='" . $row['id'] . "'>
                    <button type='submit' onclick='return confirm(\"Czy na pewno chcesz usunąć ten produkt?\")'>Usuń</button>
                </form>
              </td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "<a href='?page=produkty&action=form'>Dodaj nowy produkt</a>";
}

// Obsługa akcji
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] == 'add') {
        DodajProdukt($conn, $_POST['tytul'], $_POST['opis'], $_POST['data_wygasniecia'], $_POST['cena_netto'], 
                     $_POST['podatek_vat'], $_POST['ilosc'], $_POST['status_dostepnosci'], $_POST['kategoria'], 
                     $_POST['gabaryt_produktu'], $_POST['zdjecie']);
    } elseif ($_POST['action'] == 'edit') {
        EdytujProdukt($conn, $_POST['id'], $_POST['tytul'], $_POST['opis'], $_POST['data_wygasniecia'], 
                      $_POST['cena_netto'], $_POST['podatek_vat'], $_POST['ilosc'], $_POST['status_dostepnosci'], 
                      $_POST['kategoria'], $_POST['gabaryt_produktu'], $_POST['zdjecie']);
    } elseif ($_POST['action'] == 'delete') {
        UsunProdukt($conn, $_POST['id']);
    }

    // Przekierowanie po wykonaniu akcji
    header("Location: ?page=produkty");
    exit;
}

// Formularz dodawania/edycji produktu
if (isset($_GET['action']) && $_GET['action'] == 'form') {
    $product = null;
    if (isset($_GET['id'])) {
        $result = $conn->query("SELECT * FROM produkty WHERE id = " . (int)$_GET['id']);
        $product = $result->fetch_assoc();
    }
?>
    <form method="POST">
        <input type="hidden" name="action" value="<?= $product ? 'edit' : 'add' ?>">
        <?php if ($product): ?>
            <input type="hidden" name="id" value="<?= $product['id'] ?>">
        <?php endif; ?>
        <input type="text" name="tytul" placeholder="Tytuł" value="<?= $product['tytul'] ?? '' ?>" required>
        <textarea name="opis" placeholder="Opis"><?= $product['opis'] ?? '' ?></textarea>
        <input type="date" name="data_wygasniecia" value="<?= $product['data_wygasniecia'] ?? '' ?>">
        <input type="number" step="0.01" name="cena_netto" placeholder="Cena netto" value="<?= $product['cena_netto'] ?? '' ?>" required>
        <input type="number" step="0.01" name="podatek_vat" placeholder="Podatek VAT" value="<?= $product['podatek_vat'] ?? '' ?>" required>
        <input type="number" name="ilosc" placeholder="Ilość" value="<?= $product['ilosc'] ?? '' ?>" required>
        <select name="status_dostepnosci">
            <option value="1" <?= isset($product['status_dostepnosci']) && $product['status_dostepnosci'] == 1 ? 'selected' : '' ?>>Dostępny</option>
            <option value="0" <?= isset($product['status_dostepnosci']) && $product['status_dostepnosci'] == 0 ? 'selected' : '' ?>>Niedostępny</option>
        </select>
        <input type="text" name="kategoria" placeholder="Kategoria" value="<?= $product['kategoria'] ?? '' ?>">
        <input type="text" name="gabaryt_produktu" placeholder="Gabaryt" value="<?= $product['gabaryt_produktu'] ?? '' ?>">
        <input type="text" name="zdjecie" placeholder="Link do zdjęcia" value="<?= $product['zdjecie'] ?? '' ?>">
        <button type="submit"><?= $product ? 'Edytuj' : 'Dodaj' ?> Produkt</button>
    </form>
<?php
    exit;
}

// Wyświetlenie listy produktów
PokazProdukty($conn);
?>
