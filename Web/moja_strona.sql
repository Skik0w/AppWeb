-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sty 02, 2025 at 06:45 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

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
-- Struktura tabeli dla tabeli `kategorie`
--

CREATE TABLE `kategorie` (
  `id` int(11) NOT NULL,
  `matka` int(11) NOT NULL DEFAULT 0,
  `nazwa` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategorie`
--

INSERT INTO `kategorie` (`id`, `matka`, `nazwa`) VALUES
(6, 0, 'Modele'),
(7, 6, 'Europa'),
(8, 6, 'Azja'),
(9, 0, 'Ikoniczne zdjęcia'),
(10, 9, 'Wieżowce'),
(11, 10, 'Burdż Chalifa'),
(12, 0, 'Pamiątki');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `page_list`
--

CREATE TABLE `page_list` (
  `id` int(11) NOT NULL,
  `page_title` varchar(255) NOT NULL,
  `page_content` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `alias` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `page_list`
--

INSERT INTO `page_list` (`id`, `page_title`, `page_content`, `status`, `alias`) VALUES
(1, 'glowna', '<main>\r\n    <div class=\"index\">\r\n        <h2>Witaj na stronie o największych budynkach świata!</h2>\r\n        <img src=\"img/burjkhalifa.png\" alt=\"Burj Khalifa\">\r\n        <p>Na naszej stronie zobaczysz najbardziej <i><b>imponujące</b></i> budowle na świecie, <i><b>wiele</b></i> ciekawostek oraz <i><b>niesamowite</b></i> zdjęcia.</p>\r\n    </div>\r\n\r\n    <script>\r\n        $(\".index img\").hover(\r\n            function() {\r\n                $(this).animate({\r\n                    height: \"+=70px\"\r\n                }, 300);\r\n            },\r\n            function() {\r\n                $(this).animate({\r\n                    height: \"-=70px\"\r\n                }, 300);\r\n            }\r\n        );\r\n    </script>\r\n</main>', 1, 'glowna'),
(2, 'ranking', '<main>\r\n\r\n    <h2 style=\"text-align: center; font-size: 40px;\">\r\n        <b><i>Ranking</i></b>\r\n    </h2>\r\n\r\n    <table class=\"t1\">\r\n        <thead>\r\n            <tr>\r\n                <th>Numer w rankingu</th>\r\n                <th>Nazwa Budynku</th>\r\n                <th>Lokalizacja</th>\r\n                <th>Wysokość (m)</th>\r\n                <th>Rok ukończenia</th>\r\n            </tr>\r\n        </thead>\r\n        <tbody>\r\n            <tr>\r\n                <td>1</td>\r\n                <td>Burj Khalifa</td>\r\n                <td>Dubaj, Zjednoczone Emiraty Arabskie</td>\r\n                <td>828</td>\r\n                <td>2010</td>\r\n            </tr>\r\n            <tr>\r\n                <td>2</td>\r\n                <td>Merdeka 118</td>\r\n                <td>Kuala Lumpur, Malezja</td>\r\n                <td>678,9</td>\r\n                <td>2024</td>\r\n            </tr>\r\n            <tr>\r\n                <td>3</td>\r\n                <td>Shanghai Tower</td>\r\n                <td>Szanghaj, Chiny</td>\r\n                <td>632</td>\r\n                <td>2015</td>\r\n            </tr>\r\n            <tr>\r\n                <td>4</td>\r\n                <td>Abraj Al-Bait Clock Tower</td>\r\n                <td>Mekka, Arabia Saudyjska</td>\r\n                <td>601</td>\r\n                <td>2012</td>\r\n            </tr>\r\n            <tr>\r\n                <td>5</td>\r\n                <td>Ping An Finance Centre</td>\r\n                <td>Shenzhen, Chiny</td>\r\n                <td>599</td>\r\n                <td>2017</td>\r\n            </tr>\r\n            <tr>\r\n                <td>6</td>\r\n                <td>China 117 Tower</td>\r\n                <td>Tiencin, Chiny</td>\r\n                <td>596,6</td>\r\n                <td>2019</td>\r\n            </tr>\r\n            <tr>\r\n                <td>7</td>\r\n                <td>Lotte World Tower</td>\r\n                <td>Seul, Korea Południowa</td>\r\n                <td>555</td>\r\n                <td>2016</td>\r\n            </tr>\r\n            <tr>\r\n                <td>8</td>\r\n                <td>One World Trade Center</td>\r\n                <td>Nowy Jork, Stany Zjednoczone</td>\r\n                <td>541,3</td>\r\n                <td>2014</td>\r\n            </tr>\r\n            <tr>\r\n                <td>9</td>\r\n                <td>Guangzhou CTF Finance Centre</td>\r\n                <td>Kanton, Chiny</td>\r\n                <td>530</td>\r\n                <td>2015</td>\r\n            </tr>\r\n            <tr>\r\n                <td>10</td>\r\n                <td>Tianjin CTF Finance Center</td>\r\n                <td>Tiencin, Chiny</td>\r\n                <td>530</td>\r\n                <td>2018</td>\r\n            </tr>\r\n            <tr>\r\n                <td>11</td>\r\n                <td>China Zun</td>\r\n                <td>Pekin, Chiny</td>\r\n                <td>528</td>\r\n                <td>2018</td>\r\n            </tr>\r\n            <tr>\r\n                <td>12</td>\r\n                <td>Taipei 101</td>\r\n                <td>Tajpej, Tajwan</td>\r\n                <td>509</td>\r\n                <td>2004</td>\r\n            </tr>\r\n        </tbody>\r\n    </table>\r\n</main>', 1, 'ranking'),
(3, 'ciekawostki', '<main>\r\n\r\n    <h2 style=\"text-align: center; font-size: 40px;\">\r\n        <b><i>Ciekawostki</i></b>\r\n    </h2>\r\n    \r\n    <div class=\"block\">\r\n        <h2>Najwyższy budynek w Polsce</h2>\r\n        <img src=\"img/varso.png\" alt=\"Varso\" />\r\n        <p>\r\n            Varso – kompleks budynków biurowych w warszawskiej dzielnicy Wola, na rogu ulicy Chmielnej i alei Jana Pawła II. \r\n            Wchodzący w skład kompleksu wieżowiec Varso Tower, liczący 310 metrów, jest najwyższym budynkiem w Polsce i w Unii Europejskiej.\r\n        </p>\r\n    </div>\r\n\r\n    <div class=\"block\">\r\n        <h2>Najwyższy kościół</h2>\r\n        <img src=\"img/ulm.png\" alt=\"Katedra w Ulm\" />\r\n        <p>\r\n            Katedra w Ulm - zabytkowy gotycki kościół parafialny w Ulm, początkowo katolicki, następnie protestancki. \r\n            Od 1890 roku, dzięki wieży o wysokości 161,53 metrów, jest najwyższym kościołem na świecie.\r\n        </p>\r\n    </div>\r\n\r\n    <div class=\"block\">\r\n        <h2>Najwyższy komin</h2>\r\n        <img src=\"img/gres.png\" alt=\"Elektrownia GRES-2\" />\r\n        <p>\r\n            Elektrownia GRES-2 – elektrownia cieplna znajdująca się w Jekybastuz, w Kazachstanie. \r\n            Posiada najwyższy komin na świecie mierzący 419,7 metrów wysokości.\r\n        </p>\r\n    </div>\r\n\r\n    <div class=\"block\">\r\n        <h2>Najwyższy budynek w Europie</h2>\r\n        <img src=\"img/lachta.png\" alt=\"Łachta Centr\" />\r\n        <p>\r\n            Łachta Centr – kompleks budynków o przeznaczeniu biurowo-usługowym budowany w Petersburgu w Rosji. \r\n            Jest to najwyższy budynek w Europie oraz siedziba Gazpromu.\r\n        </p>\r\n    </div>\r\n</main>', 1, 'ciekawostki'),
(4, 'galeria', '<main>\r\n\r\n    <h2 style=\"text-align: center; font-size: 40px;\">\r\n        <b><i>Galeria</i></b>\r\n    </h2>\r\n    \r\n    <div class=\"gallery\">\r\n        <div class=\"gallery-item\">\r\n            <img src=\"img/burj.png\" alt=\"Burj Khalifa\" />\r\n            <p>Burj Khalifa - Dubaj, Zjednoczone Emiraty Arabskie</p>\r\n        </div>\r\n        <div class=\"gallery-item\">\r\n            <img src=\"img/Merdeka-118.png\" alt=\"Merdeka 118\" />\r\n            <p>Merdeka 118 - Kuala Lumpur, Malezja</p>\r\n        </div>\r\n        <div class=\"gallery-item\">\r\n            <img src=\"img/shangtower.png\" alt=\"Shanghai Tower\" />\r\n            <p>Shanghai Tower - Szanghaj, Chiny</p>\r\n        </div>\r\n        <div class=\"gallery-item\">\r\n            <img src=\"img/Abraj_Al_Bait.png\" alt=\"Abraj Al-Bait Clock Tower\" />\r\n            <p>Abraj Al-Bait Clock Tower - Mekka, Arabia Saudyjska</p>\r\n        </div>\r\n        <div class=\"gallery-item\">\r\n            <img src=\"img/ping.png\" alt=\"Ping An Finance Centre\" />\r\n            <p>Ping An Finance Centre - Shenzhen, Chiny</p>\r\n        </div>\r\n        <div class=\"gallery-item\">\r\n            <img src=\"img/china117.png\" alt=\"China 117 Tower\" />\r\n            <p>China 117 Tower - Tiencin, Chiny</p>\r\n        </div>\r\n        <div class=\"gallery-item\">\r\n            <img src=\"img/lotte.png\" alt=\"Lotte World Tower\" />\r\n            <p>Lotte World Tower - Seul, Korea Południowa</p>\r\n        </div>\r\n        <div class=\"gallery-item\">\r\n            <img src=\"img/tradecenter.png\" alt=\"One World Trade Center\" />\r\n            <p>One World Trade Center - Nowy Jork, Stany Zjednoczone</p>\r\n        </div>\r\n        <div class=\"gallery-item\">\r\n            <img src=\"img/ctf.png\" alt=\"Guangzhou CTF Finance Centre\" />\r\n            <p>Guangzhou CTF Finance Centre - Kanton, Chiny</p>\r\n        </div>\r\n        <div class=\"gallery-item\">\r\n            <img src=\"img/tianjin.png\" alt=\"Tianjin CTF Finance Center\" />\r\n            <p>Tianjin CTF Finance Center - Tiencin, Chiny</p>\r\n        </div>\r\n        <div class=\"gallery-item\">\r\n            <img src=\"img/zun.png\" alt=\"China Zun\" />\r\n            <p>China Zun - Pekin, Chiny</p>\r\n        </div>\r\n        <div class=\"gallery-item\">\r\n            <img src=\"img/taipei.png\" alt=\"China Zun\" />\r\n            <p>Taipei 101 - Tajpej, Tajwan</p>\r\n        </div>\r\n    </div>\r\n\r\n    <script>\r\n        $(\".gallery-item img\").hover(\r\n            function() {\r\n                $(this).animate({\r\n                    height: \"+=40px\"\r\n                }, 300);\r\n            },\r\n            function() {\r\n                $(this).animate({\r\n                    height: \"-=40px\"\r\n                }, 300);\r\n            }\r\n        );\r\n    </script>\r\n</main>', 1, 'galeria'),
(5, 'kontakt', '<main>\r\n\r\n    <h2 style=\"text-align: center; margin-bottom: 20px; font-size: 40px;\">\r\n        <b><i>Formularz kontaktowy</i></b>\r\n    </h2>\r\n\r\n    <form action=\"mailto:mail@gmail.com\" method=\"post\">\r\n        <label for=\"name\">Imię:</label>\r\n        <input type=\"text\" id=\"name\" name=\"name\">\r\n\r\n        <label for=\"name\">Nazwisko:</label>\r\n        <input type=\"text\" id=\"surname\" name=\"surname\">\r\n\r\n        <label for=\"email\">E-mail:</label>\r\n        <input type=\"email\" id=\"email\" name=\"email\">\r\n\r\n        <label for=\"message\">Treść:</label>\r\n        <textarea id=\"message\" name=\"message\"></textarea>\r\n\r\n        <input type=\"submit\" class=\"przycisk-kontakt\" value=\"Wyślij\">\r\n    </form>\r\n</main>', 1, 'kontakt'),
(6, 'js', '<main>\r\n    <h2 style=\"text-align: center; margin-bottom: 20px; font-size: 40px;\">\r\n        <b><i>Wybierz kolor tła</i></b>\r\n    </h2>\r\n\r\n    <form method=\"post\" name=\"background\" class=\"background-form\">\r\n        <input type=\"button\" onmouseover=\"changeColor(this, \'#deb887\')\" onmouseout=\"changeColor(this, \'#ffffff\')\" value=\"oryginalny\" onclick=\"changeBackground(\'#deb887\')\">\r\n        <input type=\"button\" onmouseover=\"changeColor(this, \'#FFFF00\')\" onmouseout=\"changeColor(this, \'#ffffff\')\" value=\"żółty\" onclick=\"changeBackground(\'#FFFF00\')\">\r\n        <input type=\"button\" onmouseover=\"changeColor(this, \'#000000\')\" onmouseout=\"changeColor(this, \'#ffffff\')\" value=\"czarny\" onclick=\"changeBackground(\'#000000\')\">\r\n        <input type=\"button\" onmouseover=\"changeColor(this, \'#FFFFFF\')\" onmouseout=\"changeColor(this, \'#ffffff\')\" value=\"biały\" onclick=\"changeBackground(\'#FFFFFF\')\">\r\n        <input type=\"button\" onmouseover=\"changeColor(this, \'#00FF00\')\" onmouseout=\"changeColor(this, \'#ffffff\')\" value=\"zielony\" onclick=\"changeBackground(\'#00FF00\')\">\r\n        <input type=\"button\" onmouseover=\"changeColor(this, \'#0000FF\')\" onmouseout=\"changeColor(this, \'#ffffff\')\" value=\"niebieski\" onclick=\"changeBackground(\'#0000FF\')\">\r\n        <input type=\"button\" onmouseover=\"changeColor(this, \'#FF8000\')\" onmouseout=\"changeColor(this, \'#ffffff\')\" value=\"pomarańczowy\" onclick=\"changeBackground(\'#FF8000\')\">\r\n        <input type=\"button\" onmouseover=\"changeColor(this, \'#c0c0c0\')\" onmouseout=\"changeColor(this, \'#ffffff\')\" value=\"szary\" onclick=\"changeBackground(\'#c0c0c0\')\">\r\n        <input type=\"button\" onmouseover=\"changeColor(this, \'#FF0000\')\" onmouseout=\"changeColor(this, \'#ffffff\')\" value=\"czerwony\" onclick=\"changeBackground(\'#FF0000\')\">\r\n    </form>\r\n    <div id=\"time\">\r\n        <div id=\"zegarek\"></div>\r\n        <div id=\"data\"></div>\r\n    </div>\r\n</main>', 1, 'js'),
(7, 'jq', '<main>\r\n    <div id=\"animacjaTestowa1\" class=\"test-block\">Kliknij, a się powiększę</div>\r\n\r\n    <div id=\"animacjaTestowa2\" class=\"test-block\">Najedź kursorem, a się powiększę</div>\r\n\r\n    <div id=\"animacjaTestowa3\" class=\"test-block\">Klikaj, abym urósł</div>\r\n    \r\n    <script>\r\n        $(\"#animacjaTestowa1\").on(\"click\", function(){\r\n            $(this).animate({\r\n                width: \"500px\",\r\n                opacity: 0.4,\r\n                fontSize: \"3em\",\r\n                borderWidth: \"10px\"\r\n            }, 1500);\r\n        });\r\n    \r\n    \r\n        $(\"#animacjaTestowa2\").on(\"mouseover\", function(){\r\n            $(this).animate({\r\n                width: 300\r\n            }, 800);\r\n        }).on(\"mouseout\", function(){\r\n            $(this).animate({\r\n                width: 200\r\n            }, 800);\r\n        });\r\n    \r\n        $(\"#animacjaTestowa3\").on(\"click\", function() {\r\n            if (!$(this).is(\":animated\")) {\r\n                $(this).animate({\r\n                    width: \"+=50\",\r\n                    height: \"+=10\",\r\n                    opacity: \"+=0.1\"\r\n                }, {\r\n                    duration: 3000\r\n                });\r\n            }\r\n        });\r\n    </script>\r\n</main>', 1, 'jq'),
(8, 'filmy', '<main>\r\n    <h2 style=\"text-align: center; margin-bottom: 20px; font-size: 40px;\">\r\n        <b><i>Filmy</i></b>\r\n    </h2>\r\n\r\n    <iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/12f6n_n13EI?si=LqiMLsmtV-hiLzmv\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>\r\n\r\n    <iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/56L1ZVOtw6A?si=KVDrAo1e1jsulcFS\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>\r\n\r\n    <iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/ejmCR0IRzPQ?si=8JdYo51ctli1Aq3t\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share\" referrerpolicy=\"strict-origin-when-cross-origin\" allowfullscreen></iframe>\r\n</main>', 1, 'filmy'),
(9, 'admin', '\r\n', 1, 'admin'),
(10, 'kontakt_php', '', 1, 'kontakt_php'),
(11, 'sklep', '', 1, 'sklep');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `produkty`
--

CREATE TABLE `produkty` (
  `id` int(11) NOT NULL,
  `tytul` varchar(255) NOT NULL,
  `opis` text NOT NULL,
  `data_utworzenia` date NOT NULL,
  `data_modyfikacji` date NOT NULL,
  `data_wygasniecia` date NOT NULL,
  `cena_netto` decimal(10,2) NOT NULL,
  `vat` int(11) NOT NULL,
  `ilosc` int(11) NOT NULL,
  `status` enum('dostępny','niedostępny') NOT NULL DEFAULT 'niedostępny',
  `kategoria_id` int(11) DEFAULT NULL,
  `gabaryt` varchar(50) NOT NULL,
  `zdjecie` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produkty`
--

INSERT INTO `produkty` (`id`, `tytul`, `opis`, `data_utworzenia`, `data_modyfikacji`, `data_wygasniecia`, `cena_netto`, `vat`, `ilosc`, `status`, `kategoria_id`, `gabaryt`, `zdjecie`) VALUES
(1, 'Wieża Eiffla', 'Model Wieży Eiffla', '2025-01-01', '2025-01-01', '2025-01-31', 199.00, 23, 2, 'dostępny', 7, '20', 'https://p.turbosquid.com/ts-thumb/rP/NP89vf/g5HTKTcj/1/jpg/1556827347/600x600/fit_q87/40165f7fad0d436e9f9b28d977ad72a41fdbc372/1.jpg'),
(2, 'Lakhta Center', 'Model Lakhta Center', '2025-01-01', '2025-01-01', '2025-02-09', 100.00, 23, 30, 'dostępny', 7, '30', 'https://netrinoimages.s3.eu-west-2.amazonaws.com/2016/08/30/420266/356359/lakhta_center_3d_model_c4d_max_obj_fbx_ma_lwo_3ds_3dm_stl_3714222_m.png'),
(3, 'Varso', 'Model Varso', '2025-01-01', '2025-01-01', '2025-01-30', 489.00, 23, 18, 'dostępny', 7, '21', 'https://bi.im-g.pl/im/75/21/1b/z28448885Q,Model-wiezowca-Varso-Tower-wykonany-z-klockow-Lego.jpg'),
(4, 'Burdż Chalifa', 'Model Burdż Chalifa', '2024-12-31', '2024-12-31', '2025-02-16', 57.00, 23, 4, 'dostępny', 8, '13', 'https://www.metalearth.com/content/images/thumbs/0000746_burj-khalifa.jpeg'),
(5, 'Shanghai Tower', 'Model Shanghai Tower', '2024-12-24', '2024-12-25', '2025-01-22', 134.00, 23, 0, 'niedostępny', 8, '24', 'https://p.turbosquid.com/ts-thumb/ew/MC3eK6/wD7dE3o4/shanghaitowerchina3dmodel01/jpg/1425888870/600x600/fit_q87/2b1c09cde3d216193a14cf86a992f29588d2dd2c/shanghaitowerchina3dmodel01.jpg'),
(6, ' Zdjęcie Burdż Chalifa', 'Niezwykłe zdjęcie najwyższego budynku świata', '2025-01-02', '2025-01-03', '2025-01-30', 999.00, 23, 1000, 'dostępny', 11, '1', 'https://tickets-burjkhalifa.com/wp-content/uploads/2024/08/Burj-Khalifa-at-night.webp'),
(7, 'Lego Varso', 'Varso z klocków Lego', '2025-01-01', '2025-01-01', '2025-02-08', 99.99, 23, 2, 'dostępny', 12, '8', 'https://wykop.pl/cdn/c3201142/comment_1659096374I5kfWvXvw8K6ucVHcI15Pt.jpg'),
(8, 'Magnes Burdż Khalifa', 'Magnes Burdż Khalifa do przyczepienia na lodówkę', '2025-01-01', '2025-01-01', '2025-02-20', 5.00, 23, 4, 'dostępny', 12, '1', 'https://m.media-amazon.com/images/I/613N9AUM0SL._AC_UF1000,1000_QL80_.jpg');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `kategorie`
--
ALTER TABLE `kategorie`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `page_list`
--
ALTER TABLE `page_list`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `alias` (`alias`);

--
-- Indeksy dla tabeli `produkty`
--
ALTER TABLE `produkty`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_kategoria_id` (`kategoria_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategorie`
--
ALTER TABLE `kategorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `page_list`
--
ALTER TABLE `page_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `produkty`
--
ALTER TABLE `produkty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `produkty`
--
ALTER TABLE `produkty`
  ADD CONSTRAINT `fk_kategoria_id` FOREIGN KEY (`kategoria_id`) REFERENCES `kategorie` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `produkty_ibfk_1` FOREIGN KEY (`kategoria_id`) REFERENCES `kategorie` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
