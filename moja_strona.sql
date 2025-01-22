-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sty 22, 2025 at 11:16 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `moja_strona`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `matka` int(11) DEFAULT 0,
  `nazwa` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `matka`, `nazwa`) VALUES
(10, 0, 'Elektronika'),
(16, 0, 'Jedzenie'),
(22, 10, 'Telefon'),
(23, 10, 'Pendrive'),
(24, 16, 'Owoce'),
(25, 0, 'Buty'),
(26, 25, 'Nike'),
(29, 0, 'Ubrania'),
(30, 29, 'Koszula'),
(32, 29, 'Spodenki');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `page_list`
--

CREATE TABLE `page_list` (
  `id` int(11) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_content` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `page_list`
--

INSERT INTO `page_list` (`id`, `page_title`, `page_content`, `status`) VALUES
(1, 'glowna', '<table style=\"width:100%\">\r\n        <tr>\r\n            <th><a href=\"index.php?page=6\" target=\"_self\">Historia</a></th>\r\n            <th><a href=\"Index.php?page=7\" target=\"_self\">Rekordy</a></th>\r\n            <th><a href=\"Index.php?page=5\" target=\"_self\">Eksperymenty</a></th>\r\n            <th><a href=\"Index.php?page=4\" target=\"_self\">Galeria zdjęć</a></th>\r\n            <th><a href=\"Index.php?page=3\" target=\"_self\">Kontakt</a></th>\r\n            <th><a href=\"Index.php?page=2\" target=\"_self\">Filmy</a></th>\r\n            <th><a href=\"Index.php?page=14\" target=\"_self\">Koszyk</a></th>\r\n        </tr>\r\n    </table>\r\n    <br /><br /><br /><br /><br /><br />\r\n\r\n    <div class=\"transbox\">\r\n        <h1>\r\n            Witamy na stronie na której możesz poznać historie powstania samolotów, <br />\r\n            rekordy, ciekawstki i eksperymentalne wersje samolotów.\r\n        </h1>\r\n    </div>\r\n\r\n    <div class=\"clock\">\r\n        <div id=\"zegarek\"></div>\r\n        <div id=\"data\"></div>\r\n    </div>\r\n\r\n    <div class=\"option\">\r\n        <form method=\"post\" name=\"background\">\r\n            <input type=\"button\" value=\"czarny\" onclick=\"changeBackground(\'#000000\')\">\r\n            <input type=\"button\" value=\"biały\" onclick=\"changeBackground(\'#FFFFFF\')\" />\r\n        </form>\r\n    </div>\r\n\r\n    ', 1),
(2, 'Filmy', '<table style=\"width:100%\">\r\n    <tr>\r\n        <a href=\"Index.php?idp=\" target=\"_self\">⬅ Powrót do menu</a>\r\n    </tr>\r\n</table>\r\n\r\n<center>\r\n    <table style=\"\">\r\n\r\n        <tr>\r\n            <iframe width=\"1031\" height=\"703\" src=\"https://www.youtube.com/embed/JWtpdsfwq3w\" title=\"Northrop F-20 Tigershark Crash (1984)\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe> \r\n            <iframe width=\"1250\" height=\"703\" src=\"https://www.youtube.com/embed/FXlvqmrFJ8k\" title=\"Russia\'s Su-57 Fighter Jet Conducts Stunning Flight Demonstration at Airshow China\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe> \r\n            <iframe width=\"1250\" height=\"703\" src=\"https://www.youtube.com/embed/16ti9GwnlVs\" title=\"F22 Raptor Take-off at RIAT 2010\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe> \r\n        </tr>\r\n\r\n    </table>\r\n</center>', 1),
(3, 'Form', '\r\n\r\n    <table style=\"width:100%\">\r\n        <tr>\r\n            <a href=\"Index.php?idp=\" target=\"_self\">⬅ Powrót do menu</a>\r\n        </tr>\r\n    </table>\r\n    <br />\r\n    <br />\r\n    <br />\r\n    <br />\r\n    <br />\r\n    \r\n    <center>\r\n        \r\n        <form style=\"background-color:white; padding: 20px; display:block; width: 20%\"\r\n              action=\"mailto:marder4707@gmail.com\">\r\n            <h2>Wyślij wiadomość</h2>\r\n            <label for=\"name\">Imię:</label>\r\n            <input type=\"text\" id=\"name\" name=\"name\" required><br><br>\r\n\r\n            <label for=\"email\">Twój e-mail:</label>\r\n            <input type=\"email\" id=\"email\" name=\"email\" required><br><br>\r\n\r\n            <label for=\"message\">Wiadomość:</label><br>\r\n            <textarea id=\"message\" name=\"message\" rows=\"5\" cols=\"30\" required></textarea><br><br>\r\n\r\n            <input type=\"submit\" value=\"Wyślij\">\r\n        </form>\r\n    </center>\r\n    <div class=\"clock\">\r\n        <div id=\"zegarek\"></div>\r\n        <div id=\"data\"></div>\r\n    </div>', 1),
(4, 'galeria', '   \r\n\r\n\r\n    <table style=\"width:100%\">\r\n        <tr>\r\n            <a href=\"Index.php?idp=\" target=\"_self\">⬅ Powrót do menu</a>\r\n        </tr>\r\n    </table>\r\n\r\n    <center>\r\n        <table style=\"\">\r\n\r\n            <tr>\r\n                <th> <img src=\"img/Gal1.jpg\" width=\"600\" height=\"429\" /> </th>\r\n                <th> <img src=\"img/Gal2.jpg\" width=\"600\" height=\"429\" /></th>\r\n                <th> <img src=\"img/Gal3.jpg\" width=\"600\" height=\"429\" /></th>\r\n            </tr>\r\n\r\n            <tr>\r\n                <th> <img src=\"img/Gal4.jpg\" width=\"600\" height=\"429\" /></th>\r\n                <th> <img src=\"img/Gal5.jpg\" width=\"600\" height=\"429\" /></th>\r\n                <th> <img src=\"img/Gal6.jpg\" width=\"600\" height=\"429\" /></th>\r\n            </tr>\r\n\r\n            <tr>\r\n                <th> <img src=\"img/Gal7.jpg\" width=\"600\" height=\"429\" /></th>\r\n                <th> <img src=\"img/Gal8.jpg\" width=\"600\" height=\"429\" /></th>\r\n                <th> <img src=\"img/Gal9.jpg\" width=\"600\" height=\"429\" /></th>\r\n            </tr>\r\n\r\n        </table>\r\n    </center>\r\n    <div class=\"clock\">\r\n        <div id=\"zegarek\"></div>\r\n        <div id=\"data\"></div>\r\n    </div>', 1),
(5, 'Exp', '\r\n\r\n    <table style=\"width:100%\">\r\n        <tr>\r\n            <a href=\"Index.php?idp=\" target=\"_self\">⬅ Powrót do menu</a>\r\n        </tr>\r\n    </table>\r\n\r\n    <div class=\"transbox1\">\r\n\r\n        <p>\r\n            <img src=\"img/Eks1.jpg\" width=\"220\" height=\"143\" />\r\n            Grumman X-29 – eksperymentalny samolot amerykański będący platformą testową dla nowych technologii i rozwiązań takich jak sterowanie w systemie canarda czy ujemny skos skrzydeł. Zamierzona niestabilność samolotu wymagała zastosowania nowoczesnego skomputeryzowanego sterowania elektrycznego powierzchniami sterowymi (fly by wire), oraz zastosowania do konstrukcji skrzydeł materiałów kompozytowych bardzo wytrzymałych i jednocześnie lekkich.\r\n        </p>\r\n        <br />\r\n        <p>\r\n            <img src=\"img/Eks2.jpg\" width=\"220\" height=\"143\" />\r\n            Bell X-1 – eksperymentalny samolot amerykański, który jako pierwszy przekroczył barierę dźwięku w sposób kontrolowany w locie poziomym. Pierwszy z samolotów serii X przeznaczonych do testowania nowych technologii.\r\n        </p>\r\n        <br />\r\n        <p>\r\n            <img src=\"img/Eks3.jpg\" width=\"220\" height=\"143\" />\r\n            Bell X-5 – pierwszy samolot o zmiennej w locie geometrii skrzydeł, zainspirowany niemiecką konstrukcją z czasów II wojny światowej Messerschmitt P.1101. Chociaż geometria skrzydeł niemieckiej maszyny mogła być zmieniana tylko na ziemi, inżynierowie z wytwórni Bell Aircraft Corporation, konstruktora samolotu X-5, opracowali system silników elektrycznych do przestawiania kąta płatów w locie.\r\n        </p>\r\n        <br />\r\n        <p>\r\n            <img src=\"img/Eks4.jpg\" width=\"220\" height=\"143\" />\r\n            Convair X-6 – samolot eksperymentalny napędzany energią jądrową, który nigdy nie wyszedł poza fazę prototypu.\r\n            <br />\r\n            <br />\r\n            <br />\r\n            <br />\r\n            <br />\r\n            <br />\r\n            <br />\r\n            <br />\r\n            <br />\r\n        </p>\r\n    </div>\r\n    <div class=\"clock\">\r\n        <div id=\"zegarek\"></div>\r\n        <div id=\"data\"></div>\r\n    </div>\r\n', 1),
(6, 'History', '\r\n\r\n\r\n    <table style=\"width:100%\">\r\n        <tr>\r\n            <th><a href=\"Index.php?idp=\" target=\"_self\">⬅ Powrót do menu</a></th>\r\n        </tr>\r\n    </table>\r\n    <div class=\"transbox1\">\r\n\r\n        <p>\r\n            <img src=\"img/His1.jpg\" />\r\n            <img src=\"img/His2.jpg\" />\r\n            <img src=\"img/His3.jpg\" />\r\n            <img src=\"img/His4.jpg\" />\r\n            Ludzie od niepamiętnych czasów marzyli o lataniu. Na podstawie obserwacji ptaków Leonardo da Vinci (1452–1519) zaprojektował pierwszą lotnię. Pionierzy latania, tacy jak Niemiec Otto Lilienthal (1848–1896), udowodnili, że szybowiec może wynieść człowieka w powietrze.\r\n\r\n            Pod koniec XIX w. wielu wynalazców próbowało skonstruować samolot, czyli szybowiec z napędem. Udało się to dwóm Amerykanom braciom Orville’owi (1871–1948) i Wilburowi (1867–1912) Wrightom, którzy zbudowali samolot poruszany silnikiem tłokowym i w 1903 roku dokonali pierwszego kontrolowanego przelotu. Trwał on 12 sekund. Tego samego dnia bracia dokonali kolejnych trzech przelotów, w których samolot przeleciał 270 metrów, a najdłuższy lot trwał 59 sekund. Ten rok uznaje się za początek ery samolotów. Bracia Wright nie byli jednak pierwszymi, którzy zasłużyli się na polu budowy samolotów. Pierwszym człowiekiem, o którym można powiedzieć, że podróżował na pokładzie samolotu, był Clément Ader (1841–1925), który wzniósł się maszyną napędzaną silnikiem parowym.\r\n\r\n            Pierwsze prace nad silnikiem odrzutowym prowadzono w latach 30. XX wieku. Silniki tłokowe okazały się niezbyt przydatne przy dużych prędkościach oraz na znacznych wysokościach, gdzie powietrze jest rozrzedzone. Potrzebny był nowy typ silnika. Już w latach 30. XX w. brytyjski inżynier Frank Whittle (1907–1996) opatentował projekt silnika odrzutowego, ale pierwszym odrzutowcem był niemiecki Heinkel He 178, poddany próbom w 1939 roku. Brytyjskie i amerykańskie odrzutowce pojawiły się niedługo potem, w czasie drugiej wojny światowej. Dzisiejsze tego typu samoloty mogą pokonać barierę prędkości dźwięku.\r\n\r\n            Polską nazwę „samolot” wprowadził Władysław Umiński, używając jej po raz pierwszy w swojej powieści Samolotem naokoło świata z 1911.\r\n\r\n        </p>\r\n    </div>\r\n\r\n    <div class=\"clock\">\r\n        <div id=\"zegarek\"></div>\r\n        <div id=\"data\"></div>\r\n    </div>\r\n', 1),
(7, 'Records', '\r\n\r\n\r\n    <table style=\"width:100%\">\r\n        <tr>\r\n            <a href=\"Index.php?idp=\" target=\"_self\">⬅ Powrót do menu</a>\r\n        </tr>\r\n    </table>\r\n\r\n    <div class=\"transbox1\">\r\n\r\n        <p>\r\n            <img src=\"img/Rek1.jpg\" />\r\n            X-43 – bezzałogowy samolot eksperymentalny zbudowany przez agencję kosmiczną NASA, najszybszy samolot świata.\r\n\r\n            16 listopada 2004 roku pobił rekord prędkości dla samolotów bezzałogowych, osiągając na krótko prędkość mach 9,6 (11854 km/h). W ten sposób pobity został poprzedni rekord prędkości, ustanowiony przez samolot X-15 3 października 1967, kiedy maszyna osiągnęła szybkość mach 6,72.\r\n        </p>\r\n        <br />\r\n        <p>\r\n            <img src=\"img/Rek2.jpg\" width=\"220\" height=\"143\" />\r\n            Najdłuższy lot w historii trwał ponad dwa miesiące. Rekord Guinnessa ustanowiono w 1958 r., kiedy to Cessna 172 pokonała bez przerw i lądowań dystans ok. 240 tys. km w czasie 64 dni, 22 godzin i 19 minut. To mniej więcej sześć okrążeń Ziemi lub 15 lotów z Sydney do Nowego Jorku bez dotykania ziemi.\r\n        </p>\r\n        <br />\r\n        <p>\r\n            <img src=\"img/Rek3.jpg\" width=\"220\" height=\"143\" />\r\n            Mrija to po ukraińsku „marzenie”. Do 2022 roku był to największy i najcięższy samolot, jaki kiedykolwiek zbudowano. Był, ponieważ został zniszczony przez Rosjan podczas ataku na port lotniczy Kijów-Hostomel. An-225 to sześciosilnikowy samolot transportowy, który został zbudowany w zakładzie O.K. Antonowa w stolicy Ukrainy.\r\n\r\n            Zbudowano tylko jednego Antonowa An-225. Prototyp odbył swój pierwszy lot 21 grudnia 1988 r. Druga maszyna nigdy nie została dokończona, ale 7 listopada 2022 roku dyrektor generalny koncernu Antonow Jewhen Hawryłow poinformował, że w trwa budowa nowego największego samolotu świata „Mrija”. Ukraińcy przekazali informację, że transportowiec będzie składał się z części tego, który został zniszczony w czasie wojny.\r\n            An-225 został zbudowany w celu przetransportowania radzieckiego odpowiednika wahadłowca kosmicznego – Burana. Na pokładzie może pomieścić aż 250 ton ładunku. Jego rozpiętość wynosi 88,4 m, długość 84 m, a wysokość 18,1 m. Ma sześć silników i 32 koła. Przy pełnych zbiornikach paliwa może przebyć dystans ok. 4500 km.\r\n        </p>\r\n        <br />\r\n        <p>\r\n            <img src=\"img/Rek4.jpg\" width=\"220\" height=\"143\" />\r\n            W 1991 r. specjalnie skonfigurowany B744 El Al przewiózł pomiędzy Etiopią, a Izraelem w czasie jednego lotu ponad tysiąc osób. Przedsięwzięcie odbyło się w ramach misji ewakuacji ludzi uciekających przed wojną domową, która wtedy się toczyła na terytorium Etiopii. Osiągnięcie to nadal jest aktualne: B747 przetransportował wtedy prawie dwa razy więcej ludzi niż przewozi A380, największy samolot pasażerski świata. Dokładna liczba nie jest jednak łatwa do ustalenia, ponieważ w księdze Rekordów Guinnessa podawane jest 1088, a w innych źródłach nawet 1122 osób, w tym dwoje dzieci urodzonych podczas lotu.\r\n            <br />\r\n            <br />\r\n            <br />\r\n            <br />\r\n            <br />\r\n            <br />\r\n        </p>\r\n    </div>\r\n    <div class=\"clock\">\r\n        <div id=\"zegarek\"></div>\r\n        <div id=\"data\"></div>\r\n    </div>', 1),
(14, 'Koszyk', '<table style=\"width:100%\">\r\n    <tr>\r\n        <a href=\"Index.php?idp=\" target=\"_self\">⬅ Powrót do menu</a>\r\n    </tr>\r\n</table>\r\n    <h2>Lista produktów</h2>\r\n    <table>\r\n        <tr>\r\n            <th>Obrazek</th>\r\n            <th>ID</th>\r\n            <th>Tytuł</th>\r\n            <th>Cena netto</th>\r\n            <th>VAT</th>\r\n            <th>Dostępność</th>\r\n            <th>Dodaj do koszyka</th>\r\n        </tr>\r\n        <?php\r\n        $stmt = $pdo->query(\"SELECT * FROM produkty\");\r\n        while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) {\r\n            echo \"<tr>\r\n                <td><img src=\'{$product[\'zdjecie\']}\' alt=\'Zdjęcie produktu\'></td>\r\n                <td>{$product[\'id\']}</td>\r\n                <td>{$product[\'tytul\']}</td>\r\n                <td>{$product[\'cena_netto\']}</td>\r\n                <td>{$product[\'podatek_vat\']}%</td>\r\n                <td>\" . ($product[\'status_dostepnosci\'] ? \'Dostępny\' : \'Niedostępny\') . \"</td>\r\n                <td>\r\n                    <form method=\'post\'>\r\n                        <input type=\'hidden\' name=\'product_id\' value=\'{$product[\'id\']}\'>\r\n                        <input type=\'number\' name=\'quantity\' value=\'1\' min=\'1\'>\r\n                        <button type=\'submit\' name=\'add\'>Dodaj</button>\r\n                    </form>\r\n                </td>\r\n            </tr>\";\r\n        }\r\n        ?>\r\n    </table>\r\n\r\n    <h2>Koszyk</h2>\r\n    <?php if (!empty($_SESSION[\'cart\'])): ?>\r\n        <table>\r\n            <tr>\r\n                <th>Obrazek</th>\r\n                <th>Produkt</th>\r\n                <th>Ilość</th>\r\n                <th>Cena netto</th>\r\n                <th>VAT</th>\r\n                <th>Cena brutto</th>\r\n                <th>Łączna wartość</th>\r\n                <th>Akcje</th>\r\n            </tr>\r\n            <?php\r\n            $total = 0;\r\n            foreach ($_SESSION[\'cart\'] as $item):\r\n                $subtotal = $item[\'quantity\'] * $item[\'price_brutto\'];\r\n                $total += $subtotal;\r\n                echo \"<tr>\r\n                    <td><img src=\'{$item[\'image\']}\' alt=\'Zdjęcie produktu\'></td>\r\n                    <td>{$item[\'title\']}</td>\r\n                    <td>{$item[\'quantity\']}</td>\r\n                    <td>{$item[\'price_net\']}</td>\r\n                    <td>{$item[\'vat_rate\']}%</td>\r\n                    <td>{$item[\'price_brutto\']}</td>\r\n                    <td>{$subtotal}</td>\r\n                    <td>\r\n                        <form method=\'post\' style=\'display: inline;\'>\r\n                            <input type=\'hidden\' name=\'product_id\' value=\'{$item[\'id\']}\'>\r\n                            <input type=\'number\' name=\'quantity\' value=\'{$item[\'quantity\']}\' min=\'1\'>\r\n                            <button type=\'submit\' name=\'update\'>Aktualizuj</button>\r\n                        </form>\r\n                        <form method=\'post\' style=\'display: inline;\'>\r\n                            <input type=\'hidden\' name=\'product_id\' value=\'{$item[\'id\']}\'>\r\n                            <button type=\'submit\' name=\'remove\'>Usuń</button>\r\n                        </form>\r\n                    </td>\r\n                </tr>\";\r\n            endforeach;\r\n            ?>\r\n            <tr>\r\n                <td colspan=\"6\">Łączna wartość koszyka:</td>\r\n                <td colspan=\"2\"><?= $total ?></td>\r\n            </tr>\r\n        </table>\r\n    <?php else: ?>\r\n        <p>Koszyk jest pusty.</p>\r\n    <?php endif; ?>\r\n\r\n', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkty`
--

CREATE TABLE `produkty` (
  `id` int(11) NOT NULL,
  `tytul` varchar(255) NOT NULL,
  `opis` text DEFAULT NULL,
  `data_utworzenia` datetime DEFAULT current_timestamp(),
  `data_modyfikacji` datetime DEFAULT NULL ON UPDATE current_timestamp(),
  `data_wygasniecia` datetime DEFAULT NULL,
  `cena_netto` decimal(10,2) NOT NULL,
  `podatek_vat` decimal(5,2) NOT NULL,
  `ilosc` int(11) NOT NULL,
  `status_dostepnosci` tinyint(1) NOT NULL,
  `kategoria` varchar(255) DEFAULT NULL,
  `gabaryt_produktu` varchar(255) DEFAULT NULL,
  `zdjecie` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produkty`
--

INSERT INTO `produkty` (`id`, `tytul`, `opis`, `data_utworzenia`, `data_modyfikacji`, `data_wygasniecia`, `cena_netto`, `podatek_vat`, `ilosc`, `status_dostepnosci`, `kategoria`, `gabaryt_produktu`, `zdjecie`) VALUES
(1, 'Xiao 75.1', 'sdfse', '2025-01-21 20:41:35', '2025-01-21 20:57:24', '0000-00-00 00:00:00', 3233.00, 3.00, 3, 1, '22', 'kij wie', 'https://www.spyshop.pl/5121-thickbox_default/szyfrujacy-telefon-gsm-tripleton-enigma-e2.jpg'),
(6, 'Adidas', 'No buty', '2025-01-21 20:58:59', '2025-01-21 20:59:15', '0000-00-00 00:00:00', 300000.00, 25.00, 1, 1, '26', 'kij wie', 'https://static.nike.com/a/images/t_PDP_936_v1/f_auto,q_auto:eco/b9739f66-98f6-42a7-8fe6-6b25ef0b9d83/NIKE+AIR+MAX+PLUS.png'),
(8, 'Jabłko', 'Takie do czerwone', '2025-01-22 22:49:12', NULL, '2025-02-08 00:00:00', 2.00, 3.50, 7, 1, '24', 'maly', 'https://image.ceneostatic.pl/data/products/85220053/p-jablko-zielone.jpg');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `page_list`
--
ALTER TABLE `page_list`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `produkty`
--
ALTER TABLE `produkty`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `page_list`
--
ALTER TABLE `page_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `produkty`
--
ALTER TABLE `produkty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
