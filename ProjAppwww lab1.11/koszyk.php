<?php
session_start();

// Połączenie z bazą danych
$host = 'localhost';
$dbname = 'moja_strona';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Błąd połączenia z bazą danych: " . $e->getMessage());
}

// Funkcja dodająca produkt do koszyka
function addToCart($productId, $quantity) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM produkty WHERE id = :id");
    $stmt->execute(['id' => $productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        $productKey = "product_" . $productId;
        $bruttoPrice = $product['cena_netto'] + ($product['cena_netto'] * $product['podatek_vat'] / 100);

        if (isset($_SESSION['cart'][$productKey])) {
            $_SESSION['cart'][$productKey]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$productKey] = [
                'id' => $product['id'],
                'title' => $product['tytul'],
                'quantity' => $quantity,
                'price_net' => $product['cena_netto'],
                'vat_rate' => $product['podatek_vat'],
                'price_brutto' => $bruttoPrice,
                'image' => $product['zdjecie'] // Pobieramy ścieżkę obrazka
            ];
        }
    }
}

// Funkcja usuwająca produkt z koszyka
function removeFromCart($productId) {
    $productKey = "product_" . $productId;

    if (isset($_SESSION['cart'][$productKey])) {
        unset($_SESSION['cart'][$productKey]);
    }
}

// Funkcja aktualizująca ilość
function updateCartQuantity($productId, $quantity) {
    $productKey = "product_" . $productId;

    if (isset($_SESSION['cart'][$productKey])) {
        if ($quantity > 0) {
            $_SESSION['cart'][$productKey]['quantity'] = $quantity;
        } else {
            removeFromCart($productId);
        }
    }
}

// Obsługa formularzy
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        addToCart($_POST['product_id'], $_POST['quantity']);
        header("Location: index.php?page=14"); // Przekierowanie usuwa dane formularza
        exit();
    }

    if (isset($_POST['update'])) {
        updateCartQuantity($_POST['product_id'], $_POST['quantity']);
        header("Location: index.php?page=14");
        exit();
    }

    if (isset($_POST['remove'])) {
        removeFromCart($_POST['product_id']);
        header("Location: index.php?page=14");
        exit();
    }
}
?>
