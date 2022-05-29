-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 25 May 2022, 07:15:21
-- Sunucu sürümü: 10.4.24-MariaDB
-- PHP Sürümü: 8.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `automation`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `account`
--

CREATE TABLE `account` (
  `accId` int(11) NOT NULL,
  `accDate` datetime NOT NULL DEFAULT current_timestamp(),
  `accAuthorizedFullName` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
  `accCompany` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
  `accMail` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
  `accPhone` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
  `accTaxOffice` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
  `accTaxNumber` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
  `accIban` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
  `accAddress` text COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `account`
--

INSERT INTO `account` (`accId`, `accDate`, `accAuthorizedFullName`, `accCompany`, `accMail`, `accPhone`, `accTaxOffice`, `accTaxNumber`, `accIban`, `accAddress`) VALUES
(7, '2022-05-24 19:39:00', 'Barış Akar', 'Akardev Yazılım Hizmetleri', 'akardev@gmail.com', '039-710-0237', 'Kadıköy', '0000000123', 'TR5085318913218943218231', 'Kadıköy/İstanbul'),
(12, '2022-05-25 07:48:13', 'Sonny Keebler', '', 'your.email+fakedata11440@gmail.com', '899-798-1126', 'Connecticut', '4752134', '339546456456457', '36611 German Street'),
(13, '2022-05-25 07:48:25', 'Aliyah Fisher', 'Grady - Halvorson', 'your.email+fakedata48605@gmail.com', '839-596-8120', 'Nevada', '6452435', '60763453478679234', '98102 Kirlin Rest');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `admin`
--

CREATE TABLE `admin` (
  `adminId` int(11) NOT NULL,
  `adminName` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
  `adminSurname` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
  `adminFile` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
  `adminUsername` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
  `adminPass` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
  `adminStatus` enum('0','1') COLLATE utf8_turkish_ci NOT NULL DEFAULT '1',
  `adminMust` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `admin`
--

INSERT INTO `admin` (`adminId`, `adminName`, `adminSurname`, `adminFile`, `adminUsername`, `adminPass`, `adminStatus`, `adminMust`) VALUES
(1, 'Barış', 'Akar', '628a5e9eec6ab.jpg', 'akardev', 'e10adc3949ba59abbe56e057f20f883e', '1', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `operation`
--

CREATE TABLE `operation` (
  `opId` int(11) NOT NULL,
  `accId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `opDate` date NOT NULL,
  `opType` enum('Gelir','Gider') COLLATE utf8_turkish_ci NOT NULL,
  `opPrice` float(9,2) NOT NULL,
  `opDescription` text COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `operation`
--

INSERT INTO `operation` (`opId`, `accId`, `productId`, `opDate`, `opType`, `opPrice`, `opDescription`) VALUES
(1, 7, 2, '2022-05-24', 'Gelir', 1000.00, 'E Ticaret 1.  Taksit'),
(4, 7, 2, '2022-05-25', 'Gelir', 1000.00, 'E Ticaret 2. Taksit'),
(5, 7, 2, '2022-05-25', 'Gelir', 1000.00, 'E Ticaret 3. Taksit'),
(6, 7, 4, '2022-05-25', 'Gelir', 7500.00, 'Otopilot Ödemesi'),
(7, 7, 2, '2022-05-25', 'Gider', 4500.00, 'E Ticaret Sunucu gideri'),
(8, 12, 3, '2022-05-24', 'Gelir', 10000.00, 'Tasarım Ödemesi');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `product`
--

CREATE TABLE `product` (
  `productId` int(11) NOT NULL,
  `productTitle` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
  `productContent` varchar(250) COLLATE utf8_turkish_ci NOT NULL,
  `productPrice` float(9,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `product`
--

INSERT INTO `product` (`productId`, `productTitle`, `productContent`, `productPrice`) VALUES
(2, 'E-Ticaret Sitesi', '<p>E-Ticarete başlamanız için tüm paketler</p>', 15000.00),
(3, 'AkarKonsept Tasarım', '<p>Özel Tasarımlar</p>', 10000.00),
(4, 'OtoPilot', '<p>Google reklamlarınızı otomatik oluşturun</p>', 7500.00);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sales`
--

CREATE TABLE `sales` (
  `salesId` int(11) NOT NULL,
  `accId` int(11) NOT NULL,
  `productId` int(11) NOT NULL,
  `salesDate` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `sales`
--

INSERT INTO `sales` (`salesId`, `accId`, `productId`, `salesDate`) VALUES
(1, 7, 4, '2022-05-24 08:03:47'),
(2, 7, 3, '2022-05-25 08:03:55'),
(3, 7, 2, '2022-05-25 08:04:00'),
(4, 12, 3, '2022-05-25 08:10:06');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `setting`
--

CREATE TABLE `setting` (
  `setId` int(11) NOT NULL,
  `setDescription` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `setKey` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `setValue` text COLLATE utf8_turkish_ci NOT NULL,
  `setType` varchar(50) COLLATE utf8_turkish_ci NOT NULL,
  `setMust` int(3) NOT NULL,
  `setDelete` enum('0','1') COLLATE utf8_turkish_ci NOT NULL,
  `setStatus` enum('0','1') COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

--
-- Tablo döküm verisi `setting`
--

INSERT INTO `setting` (`setId`, `setDescription`, `setKey`, `setValue`, `setType`, `setMust`, `setDelete`, `setStatus`) VALUES
(1, 'Site Başlığı', 'title', 'Akardev CMS Yönetim Paneli', 'text', 0, '0', '1'),
(2, 'Site Açıklama', 'description', 'Site Açıklaması', 'text', 1, '0', '1'),
(3, 'Site Logo', 'logo', '628db87f93f53.jpg', 'file', 2, '0', '1'),
(4, 'Fav Icon', 'icon', '5cd14ad1392fa.jpg', 'file', 4, '0', '1'),
(5, 'Anahtar Kelimeler', 'keywords', 'php, oop, cms, barış akar', 'text', 5, '0', '1'),
(6, 'Telefon Numarası', 'phone', '0850 850 50 50', 'text', 10, '0', '1'),
(7, 'Mail Adresi', 'email', 'contact@barisakar.com', 'text', 11, '0', '1'),
(9, 'İl', 'city', 'İstanbul', 'text', 12, '0', '1'),
(10, 'Açık Adres', 'address', '<p>Buraya a&ccedil;ık adres detaylı gelecek. <strong>G&uuml;ncelleme</strong></p>\r\n', 'ckeditor', 13, '0', '1'),
(11, 'Facebook Hesabı', 'facebook', 'www.facebook.com', 'text', 14, '0', '1'),
(12, 'Çalışma Saatleri', 'workHours', 'Hafta içi 09:00 - 17:00', 'text', 15, '0', '1'),
(17, 'Twitter Hesabı', 'twitter', 'www.twitter.com', 'text', 16, '0', '1'),
(18, 'Site Sahibi', 'author', 'Akardev', 'text', 6, '0', '1'),
(19, 'Copyright', 'copyright', 'Copyright © Akardev 2022', 'text', 7, '0', '1'),
(20, 'Slogan', 'slogan', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Molestias, expedita, saepe, vero rerum deleniti beatae veniam harum neque nemo praesentium cum alias asperiores commodi.', 'text', 8, '0', '1'),
(21, 'Slogan Linki', 'sloganUrl', '', 'text', 9, '0', '1'),
(22, 'Site Logo Text', 'logoText', 'AKARDEV', 'text', 3, '0', '1'),
(23, 'Anasayfa Reklam Alanı İçerik', 'home_01_content', '<h2><strong>Modern Business Features</strong></h2>\r\n\r\n<p>The Modern Business template by Start Bootstrap includes:</p>\r\n\r\n<ul>\r\n	<li><strong>Bootstrap v4</strong></li>\r\n	<li>jQuery</li>\r\n	<li>Font Awesome</li>\r\n	<li>Working contact form with validation</li>\r\n	<li>Unstyled page elements for easy customization</li>\r\n</ul>\r\n\r\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis, omnis doloremque non cum id reprehenderit, quisquam totam aspernatur tempora minima unde aliquid ea culpa sunt. Reiciendis quia dolorum ducimus unde.</p>\r\n', 'ckeditor', 18, '0', '1'),
(24, 'Anasayfa Reklam Alanı Görsel', 'home_01_file', '628b78caee015.jpg', 'file', 17, '0', '1');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`accId`);

--
-- Tablo için indeksler `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminId`);

--
-- Tablo için indeksler `operation`
--
ALTER TABLE `operation`
  ADD PRIMARY KEY (`opId`);

--
-- Tablo için indeksler `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productId`);

--
-- Tablo için indeksler `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`salesId`);

--
-- Tablo için indeksler `setting`
--
ALTER TABLE `setting`
  ADD PRIMARY KEY (`setId`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `account`
--
ALTER TABLE `account`
  MODIFY `accId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Tablo için AUTO_INCREMENT değeri `admin`
--
ALTER TABLE `admin`
  MODIFY `adminId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `operation`
--
ALTER TABLE `operation`
  MODIFY `opId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Tablo için AUTO_INCREMENT değeri `product`
--
ALTER TABLE `product`
  MODIFY `productId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Tablo için AUTO_INCREMENT değeri `sales`
--
ALTER TABLE `sales`
  MODIFY `salesId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `setting`
--
ALTER TABLE `setting`
  MODIFY `setId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
