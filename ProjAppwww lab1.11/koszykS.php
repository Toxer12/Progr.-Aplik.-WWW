<?php include 'koszyk.php'; ?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep internetowy</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: center;
            background-color: #fff; /* Białe wypełnienie */
        }
        th {
            background-color: #f4f4f4;
        }
        img {
            max-width: 100px;
            height: auto;
        }
        h2 {
            text-align: center;
        }
        button {
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<table style="width:100%">
    <tr>
        <a href="Index.php?idp=" target="_self">⬅ Powrót do menu</a>
    </tr>
</table>
    <h2>Lista produktów</h2>
    <table>
        <tr>
            <th>Obrazek</th>
            <th>ID</th>
            <th>Tytuł</th>
            <th>Cena netto</th>
            <th>VAT</th>
            <th>Dostępność</th>
            <th>Dodaj do koszyka</th>
        </tr>
        <?php
        $stmt = $pdo->query("SELECT * FROM produkty");
        while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                <td><img src='{$product['zdjecie']}' alt='Zdjęcie produktu'></td>
                <td>{$product['id']}</td>
                <td>{$product['tytul']}</td>
                <td>{$product['cena_netto']}</td>
                <td>{$product['podatek_vat']}%</td>
                <td>" . ($product['status_dostepnosci'] ? 'Dostępny' : 'Niedostępny') . "</td>
                <td>
                    <form method='post'>
                        <input type='hidden' name='product_id' value='{$product['id']}'>
                        <input type='number' name='quantity' value='1' min='1'>
                        <button type='submit' name='add'>Dodaj</button>
                    </form>
                </td>
            </tr>";
        }
        ?>
    </table>

    <h2>Koszyk</h2>
    <?php if (!empty($_SESSION['cart'])): ?>
        <table>
            <tr>
                <th>Obrazek</th>
                <th>Produkt</th>
                <th>Ilość</th>
                <th>Cena netto</th>
                <th>VAT</th>
                <th>Cena brutto</th>
                <th>Łączna wartość</th>
                <th>Akcje</th>
            </tr>
            <?php
            $total = 0;
            foreach ($_SESSION['cart'] as $item):
                $subtotal = $item['quantity'] * $item['price_brutto'];
                $total += $subtotal;
                echo "<tr>
                    <td><img src='{$item['image']}' alt='Zdjęcie produktu'></td>
                    <td>{$item['title']}</td>
                    <td>{$item['quantity']}</td>
                    <td>{$item['price_net']}</td>
                    <td>{$item['vat_rate']}%</td>
                    <td>{$item['price_brutto']}</td>
                    <td>{$subtotal}</td>
                    <td>
                        <form method='post' style='display: inline;'>
                            <input type='hidden' name='product_id' value='{$item['id']}'>
                            <input type='number' name='quantity' value='{$item['quantity']}' min='1'>
                            <button type='submit' name='update'>Aktualizuj</button>
                        </form>
                        <form method='post' style='display: inline;'>
                            <input type='hidden' name='product_id' value='{$item['id']}'>
                            <button type='submit' name='remove'>Usuń</button>
                        </form>
                    </td>
                </tr>";
            endforeach;
            ?>
            <tr>
                <td colspan="6">Łączna wartość koszyka:</td>
                <td colspan="2"><?= $total ?></td>
            </tr>
        </table>
    <?php else: ?>
        <p>Koszyk jest pusty.</p>
    <?php endif; ?>
</body>
</html>
