<?php

include('cfg.php'); // Łączenie z bazą danych

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
?>
