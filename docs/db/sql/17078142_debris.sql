-- phpMyAdmin SQL Dump
-- version home.pl
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 18 Wrz 2015, 00:09
-- Wersja serwera: 5.5.44-37.3-log
-- Wersja PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `17078142_debris`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `size` int(20) NOT NULL,
  `path` varchar(255) DEFAULT NULL,
  `uploaded_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `uploaded_by` varchar(45) NOT NULL,
  `is_deleted` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fk_files_types_idx` (`type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Zrzut danych tabeli `files`
--

INSERT INTO `files` (`id`, `type_id`, `title`, `size`, `path`, `uploaded_date`, `uploaded_by`, `is_deleted`) VALUES
(1, 2, 'cudna-o.jpg', 29957, '20150226_022513_65b9ee.jpeg', '2015-02-26 01:25:13', '192.168.0.1', NULL),
(2, 2, 'cudna-o.jpg', 29957, '20150226_161112_6ecbdd.jpeg', '2015-02-26 15:11:12', '192.168.0.1', NULL),
(3, 2, 'cudna-o.jpg', 29957, '20150226_161129_2ab564.jpeg', '2015-02-26 15:11:29', '192.168.0.1', NULL),
(4, 2, 'P1060110.JPG', 3156876, '20150226_161205_46922a.jpeg', '2015-02-26 15:12:05', '192.168.0.1', NULL),
(5, 2, 'P1060115.JPG', 2507266, '20150226_161224_8c235f.jpeg', '2015-02-26 15:12:24', '192.168.0.1', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `test`
--

CREATE TABLE IF NOT EXISTS `test` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin2 AUTO_INCREMENT=4 ;

--
-- Zrzut danych tabeli `test`
--

INSERT INTO `test` (`id`, `name`) VALUES
(1, 'Daniil'),
(2, 'Mama'),
(3, 'Artem');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `types`
--

CREATE TABLE IF NOT EXISTS `types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(45) NOT NULL,
  `extension` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Zrzut danych tabeli `types`
--

INSERT INTO `types` (`id`, `title`, `extension`) VALUES
(1, 'graphic', 'jpeg'),
(2, 'graphic', 'jpg'),
(3, 'audio', 'mp3'),
(4, 'data', 'txt');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `urls`
--

CREATE TABLE IF NOT EXISTS `urls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(2048) NOT NULL,
  `short_url` varchar(512) NOT NULL,
  `description` varchar(2048) NOT NULL,
  `hash` varchar(256) NOT NULL,
  `ip` varchar(45) NOT NULL,
  `views` int(11) NOT NULL DEFAULT '0',
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=73 ;

--
-- Zrzut danych tabeli `urls`
--

INSERT INTO `urls` (`id`, `url`, `short_url`, `description`, `hash`, `ip`, `views`, `date`) VALUES
(1, 'http://guideto.ru/it/sobstvennyj-servis-sokrashheniya-ssylok/', 'http://debrs.com/1wer', '', 'd23rf3g545h5h657j56h445g', '192.168.0.1', 1, '2015-02-21 06:21:14'),
(2, 'http://symfony.com/doc/current/cookbook/doctrine/registration_form.html', 'http://debrs.com/77e6', '', 'aa78fabcee7de35fa7510cf73108be5b902ffdb3', '176.221.120.129', 0, '2015-03-28 19:26:47'),
(3, 'http://www.sitepoint.com/building-processing-forms-in-symfony-2/', 'http://debrs.com/6149', '', '009738c722acd75d27482f57ea69259ce26f64c8', '176.221.120.129', 0, '2015-03-28 19:27:06'),
(4, 'http://arsetnatura.pl/index.php?p70,pasta-do-zebow-neem-200g-ajurwedyjska', 'http://debrs.com/f7c9', '', '39c17471ff698cdeb41ec76a2624dac588ecafc1', '176.221.120.129', 0, '2015-03-29 08:21:53'),
(5, 'http://ain.ua/2015/03/29/572366', 'http://debrs.com/9007', '', 'a9ff809948b55f46828a9993ddfff64e13f5eb79', '176.221.120.129', 0, '2015-03-29 12:38:36'),
(6, 'http://pxtoem.com/', 'http://debrs.com/ba93', '', '37ce6091ba0d484d7920cf4f067810297f41cefd', '176.221.120.129', 0, '2015-04-04 13:44:50'),
(7, 'http://www.freshdesignweb.com/jquery-css3-loading-progress-bar.html', 'http://debrs.com/c27e', '', '8c4297e7170065d8ed8663d66132ac1ea1d37ebb', '176.221.120.129', 2, '2015-04-05 12:49:31'),
(8, 'http://habrahabr.ru/post/42080/', 'http://debrs.com/7981', '', '8c7613a700b20a70463e1836f7927d3a2ae7adbd', '176.221.120.129', 1, '2015-04-05 13:37:30'),
(9, 'https://developers.google.com/analytics/devguides/collection/upgrade/?hl=ru', 'http://debrs.com/43f9', '', '7efe54994d2943f249e222f6f9e7bb320e13ff34', '176.221.120.129', 0, '2015-04-05 15:14:55'),
(10, 'https://about.me/dsydorenko', 'http://debrs.com/f73c', '', '0bf074db6214352bc6427a67078aa6501afc1efb', '85.17.24.66', 4, '2015-04-05 15:58:07'),
(11, 'https://www.google.com.ua/search?q=%D0%BA%D0%B0%D1%80%D1%82%D0%B8%D0%BD%D0%BA%D0%B8+%D0%B3%D0%BD%D0%B5%D0%B7%D0%B4%D0%BE&espv=2&biw=1366&bih=667&tbm=isch&imgil=Wo8Cdk6go2O0OM%253A%253Byt5AAuK2-reT3M%253Bhttp%25253A%25252F%25252Flenagold.ru%25252Ffon%25252Fclipart%25252Fg%25252Fgnez.html&source=iu&pf=m&fir=Wo8Cdk6go2O0OM%253A%252Cyt5AAuK2-reT3M%252C_&usg=__mUne1E_KfkOuLSsoHoqE6NWshkg%3D&ved=0CC8Qyjc&ei=b3UhVYb_A8WLsAG5k4PwCQ#imgrc=Wo8Cdk6go2O0OM%253A%3Byt5AAuK2-reT3M%3Bhttp%253A%252F%252Fs54.radikal.ru%252Fi143%252F0810%252F88%252Fb2d9a3342fb5.png%3Bhttp%253A%252F%252Flenagold.ru%252Ffon%252Fclipart%252Fg%252Fgnez.html%3B2521%3B2511', 'http://debrs.com/e5ff', '', '60c03f1667d4966672758521fc97c66a00263633', '77.122.72.103', 2, '2015-04-05 17:48:41'),
(12, 'http://stackoverflow.com/questions/3711357/getting-title-and-meta-tags-from-external-website', 'http://debrs.com/cc22', '', '37b0453ae2ff7a16dd9f4442204c021bd6e5257d', '176.221.120.129', 0, '2015-04-05 17:48:50'),
(13, 'https://support.google.com/adwords/answer/2544985?hl=ru', 'http://debrs.com/d863', '', 'd9691174ca3c8fa7bd928d76dc408e62a139881e', '176.221.120.129', 0, '2015-04-06 10:14:54'),
(14, 'https://mail.ru', 'http://debrs.com/3f8b', '', 'e04973b83a84c27220789d92c972bdae78b35077', '79.188.51.73', 3, '2015-04-07 09:23:49'),
(15, 'https://www.google.com.ua/search?q=%D0%BA%D0%B0%D1%80%D1%82%D0%B8%D0%BD%D0%BA%D0%B8+%D1%8D%D1%82%D0%BE+%D0%BF%D0%BE%D0%BB+%D0%B4%D1%8D%D0%BD%D1%81+%D0%B0+%D0%BD%D0%B5+%D1%81%D1%82%D1%80%D0%B8%D0%BF%D1%82%D0%B8%D0%B7&espv=2&biw=1920&bih=979&source=lnms&tbm=isch&sa=X&ei=ILkkVY_cEMWuswGDo4DQBA&ved=0CAYQ_AUoAQ#tbm=isch&q=%D1%81%D0%BE%D0%B1%D0%B0%D0%BA%D0%B0+%D1%81%D1%82%D1%80%D0%B8%D0%BF%D1%82%D0%B8%D0%B7%D1%8F%D0%BA%D0%B0&imgrc=E6caKg_iIGUnCM%253A%3B_WU73-sJw-7vXM%3Bhttp%253A%252F%252Fdemotivators.to%252Fmedia%252Fposters%252F2544%252F68664426_sobaka-striptizyaka.png%3Bhttp%253A%252F%252Fdemotivators.to%252Fp%252F664426%252Fsobaka-striptizyaka.htm%3B612%3B700', 'http://debrs.com/b40c', '', 'bc14fe80990106258f9c04d441c60a0269a6c83e', '93.76.221.75', 5, '2015-04-08 05:16:17'),
(16, 'http://www.w3schools.com/php/php_ref_array.asp', 'http://debrs.com/bce6', '', '1b46e4959bebbebfa1f11c8610a9b89fda63f129', '79.188.51.73', 1, '2015-04-08 14:08:07'),
(17, 'http://tapon.pl/', 'http://www.debrs.com/9b48', '', '6e2836ffad3d843d8ae3a0db4bd1235f8204553f', '91.237.138.11', 1, '2015-04-15 15:53:02'),
(18, 'http://fc07.deviantart.net/fs70/f/2013/238/d/c/stolen_uniform___tg_transformation_by_grumpy_tg-d6jvz2y.jpg', 'http://debrs.com/3e03', '', '9c948d4cc35bdd22aa080343e9cb3716aa714708', '176.221.120.129', 1, '2015-04-20 20:58:37'),
(19, 'https://phpunit.de/manual/current/en/test-doubles.html#test-doubles.mock-objects', 'http://debrs.com/bb1f', '', 'd0029fba0dbf03136065dcc66390c3492cb369e2', '79.188.51.73', 0, '2015-04-24 09:23:50'),
(20, 'http://stackoverflow.com/questions/17278233/phpunit-test-array-of-objects', 'http://debrs.com/cf18', '', 'b4669ad90ed044d13c4a069261c940364fc59368', '79.188.51.73', 0, '2015-04-24 09:26:19'),
(21, 'http://obtech.misc.unit27.net', 'http://www.debrs.com/acac', '', 'a546b198b33f3df94df7f234b309945dd5f8dc64', '79.188.51.73', 1, '2015-04-24 09:27:05'),
(22, 'http://www.fromdev.com/2013/09/best-php-books.html', 'http://debrs.com/7734', '', '77ff16b0fbe782fedafc7a9ffcc2e99b7044b561', '176.221.120.129', 1, '2015-04-29 21:08:25'),
(23, 'http://habrahabr.ru/post/140217/', 'http://debrs.com/b42a', '', 'dc757acc44330449bb62bfd34dfc0abf32dced19', '79.188.51.73', 2, '2015-05-05 13:25:46'),
(24, 'http://photoshop-besplatno.ru/', 'http://debrs.com/c23d', '', 'b0ac2aafdde5859d51f9e0accd95f1e53d9349f7', '79.188.51.73', 0, '2015-05-08 08:09:56'),
(25, 'https://www.google.pl', 'http://debrs.com/fefd', '', 'fb4848c0e0d4701b0664b7ad7753050e1b41f0e1', '79.188.51.73', 0, '2015-05-08 08:10:28'),
(26, 'http://www.onet.pl/', 'http://debrs.com/856d', '', '8b27881f27dba3ae97cf05ff85b6b6c52b610aae', '79.188.51.73', 0, '2015-05-08 08:15:37'),
(27, 'http://tapon.pl', 'http://debrs.com/2927', '', '6d5c53b1491b11f48df1cace544205b4d617d251', '79.188.51.73', 0, '2015-05-08 08:18:36'),
(28, 'https://ru.wikipedia.org/wiki/%D0%9A%D0%BE%D1%81%D1%82%D0%B5%D0%BD%D0%BA%D0%BE,_%D0%9B%D0%B8%D0%BD%D0%B0_%D0%92%D0%B0%D1%81%D0%B8%D0%BB%D1%8C%D0%B5%D0%B2%D0%BD%D0%B0', 'http://debrs.com/c362', '', 'b2d99fec94ff16c8e5c971ed21aae7f7870bee42', '77.122.72.103', 2, '2015-05-09 15:46:18'),
(29, 'https://ru.wikipedia.org/wiki/%D0%90%D1%85%D0%BC%D0%B0%D1%82%D0%BE%D0%B2%D0%B0,_%D0%90%D0%BD%D0%BD%D0%B0_%D0%90%D0%BD%D0%B4%D1%80%D0%B5%D0%B5%D0%B2%D0%BD%D0%B0', 'http://debrs.com/028c', '', '75ff9dfdcd1aedd024e2be8973b00bc53fea9714', '77.122.72.103', 3, '2015-05-09 15:48:11'),
(30, 'https://ru.wikipedia.org/wiki/%D0%95%D1%81%D0%B5%D0%BD%D0%B8%D0%BD,_%D0%A1%D0%B5%D1%80%D0%B3%D0%B5%D0%B9_%D0%90%D0%BB%D0%B5%D0%BA%D1%81%D0%B0%D0%BD%D0%B4%D1%80%D0%BE%D0%B2%D0%B8%D1%87', 'http://debrs.com/4f7d', '', '92aa48d490dbdd0b7e40c11ac0ef8e49925530be', '77.122.72.103', 2, '2015-05-09 15:49:08'),
(31, 'https://www.npmjs.com/package/image-size', 'http://debrs.com/b80b', '', '398bfd21243d312ccb1f69142657c338d8bf030b', '176.221.120.129', 0, '2015-05-09 19:53:24'),
(32, 'http://37.59.15.182', 'http://www.debrs.com/1ebc', '', 'b461019b0827913b70387d27a498294889a71408', '31.223.126.227', 2, '2015-05-10 08:59:21'),
(33, 'https://developer.mozilla.org/ru/docs/Web/JavaScript/Reference/Global_Objects/Array/forEach', 'http://debrs.com/7af6', '', 'b6b7f3c4144aa45c00057a41764af90b043659a4', '176.221.120.129', 0, '2015-05-10 12:12:27'),
(34, 'https://www.digitalocean.com/community/tutorials/how-to-use-node-js-request-and-cheerio-to-set-up-simple-web-scraping', 'http://debrs.com/d18f', '', '8735fe6cf936731ffc46b4bd343cc8003c920d31', '79.188.51.73', 0, '2015-05-14 08:17:39'),
(35, 'http://www.studygerman.ru/lessons/anfanger.html', 'http://debrs.com/ac53', '', '978587fd8b0c05b010279d5ace53190017f5ac09', '176.221.120.86', 0, '2015-05-30 07:57:45'),
(36, 'http://inspired.com.ua/columns/travelling-success/', 'http://debrs.com/3c21', '', '21b988aa24216e7b08e81085bac7cd137041eda7', '54.145.159.201', 0, '2015-06-15 11:24:15'),
(37, 'http://dron.by/post/pattern-proektirovaniya-singleton-odinochka-na-php.html', 'http://debrs.com/e804', '', 'af8481bb5b98ce6460223b20c5b67fe4100026c0', '174.129.132.184', 0, '2015-06-18 07:12:38'),
(38, 'http://pcpro100.info/luchshie-programmyi-dlya-ochistki-kompyutera-ot-musora/', 'http://debrs.com/aa1c', 'Đ ŃŃĐ°ŃŃĐľ ĐżŃĐ¸Đ˛ĐžĐ´ŃŃŃŃ ĐťŃŃŃĐ¸Đľ ĐżŃĐžĐłŃĐ°ĐźĐźŃ, ĐşĐžŃĐžŃŃĐľ ĐżĐžĐźĐžĐłŃŃ ŃĐ´Đ°ĐťĐ¸ŃŃ Đ˛ĐľŃŃ ĐźŃŃĐžŃ Ń ĐşĐžĐźĐżŃŃŃĐľŃĐ°: Đ˛ŃĐľĐźĐľĐ˝Đ˝ŃĐľ ŃĐ°ĐšĐťŃ, ŃŃĐ°ŃŃĐľ Đ˝ĐľĐ¸ŃĐżĐžĐťŃĐˇŃĐľĐźŃĐľ ĐżŃĐžĐłŃĐ°ĐźĐźŃ Đ¸ Đ¸ĐłŃŃ.', 'a1ec529ec4e35db67e39942177e38a6a99e12c78', '79.188.51.73', 0, '2015-06-23 11:51:38'),
(39, 'http://vindavoz.ru/win_obwee/411-krakozyabry-vmesto-russkih-bukv.html/', 'http://debrs.com/f23c', 'Čç ýňîé ńňŕňüč Âű óçíŕĺňĺ ęŕę ěîćíî óáđŕňü ęđŕęîç˙áđű â ďđîăđŕěěŕő Windows, ęîňîđűĺ ďî˙âë˙ţňń˙ âěĺńňî đóńńęčő áóęâ.', 'b5cbd74242c2d454fc22e3c85701649f010dd432', '79.188.51.73', 0, '2015-06-23 11:54:26'),
(40, 'https://developer.mozilla.org/en-us/docs/web/http/access_control_cors/', 'http://debrs.com/e7ce', 'Cross-site HTTP requests are HTTP requests for resources from a different domain than the domain of the resource making the request. Â For instance, a resource loaded from Domain A (http://domaina.example) such as an HTML web page, makes a request for a resource on Domain B (http://domainb.foo), such', 'f1939aef209230a71605c61019ce5affcdf74279', '79.188.51.73', 0, '2015-06-23 11:55:30'),
(41, 'http://habrahabr.ru/post/181988/', 'http://debrs.com/9cf9', 'ĐĐ˝ŃŃĐž\r\nĐ­ŃĐž ĐşŃĐ°ŃĐşĐ¸Đš ĐżĐľŃĐľĐ˛ĐžĐ´ ĐžŃĐ˝ĐžĐ˛Đ˝ŃŃ ŃĐľĐˇĐ¸ŃĐžĐ˛ Đ¸Đˇ ĐąŃĐžŃŃŃŃ ÂŤWeb API Design. Crafting Interfaces that Developers LoveÂť ĐŃĐ°ĐšĐ°Đ˝Đ° ĐĐ°ĐťĐťĐžŃ Đ¸Đˇ ĐşĐžĐźĐżĐ°Đ˝Đ¸Đ¸ Apigee Labs. Apigee ĐˇĐ°Đ˝Đ¸ĐźĐ°ĐľŃŃŃ ŃĐ°ĐˇŃĐ°ĐąĐžŃĐşĐžĐš ŃĐ°ĐˇĐťĐ¸ŃĐ˝ŃŃ...', '7881702d33ed3c7b9d0af0d588877c99890d00ed', '79.188.51.73', 0, '2015-06-23 11:58:07'),
(42, 'https://toster.ru/q/223804?utm_source=tm_habrahabr&utm_medium=tm_block&utm_campaign=tm_promo/', 'http://debrs.com/883c', '', 'b4642193cecb43d794f3cb6d5d6d760c3eb5e1c5', '79.188.51.73', 0, '2015-06-23 12:09:10'),
(43, 'http://megamozg.ru/post/16688/', 'http://debrs.com/b24a', '', 'ee128b9dd5559addbd8e1ad2a40ea3071cd03a7c', '79.188.51.73', 0, '2015-06-23 12:09:49'),
(44, 'http://megamozg.ru/company/email-competitors/blog/16660/', 'http://debrs.com/2280', '', '0bd69b37761b7997de4058fd39b231d4bfef64df', '79.188.51.73', 0, '2015-06-23 12:10:04'),
(45, 'http://phpclub.ru/talk/threads/%d0%bf%d0%b5%d1%80%d0%b5%d1%85%d0%be%d0%b4-%d1%81-php-%d0%bd%d0%b0-java.10340/', 'http://debrs.com/d438', '', '33a17a19c18c3a512ffe8209a34caca9643290dd', '79.188.51.73', 0, '2015-06-23 12:10:37'),
(46, 'https://github.com/daniilsydorenko/', 'http://debrs.com/ac1c', '', 'd61eda937986e82645fc08afdfe4b825b78787fc', '79.188.51.73', 1, '2015-06-23 12:12:37'),
(47, 'http://mashable.com/', 'http://debrs.com/d8cf', '', '8c9cbb7534b8ecf0f85077fee9423610d6a8b38a', '79.188.51.73', 0, '2015-06-23 12:53:51'),
(48, 'https://github.com/DaniilSydorenko/debris/tree/e7f649e808b0a3990e81bf280a160f8e820f07be', 'http://debrs.com/5fd4', 'DaniilSydorenko/debris at e7f649e808b0a3990e81bf280a160f8e820f07be Âˇ GitHub', '3dc678283a643867ae24f45e2bc1f252bcb5b345', '79.188.51.73', 1, '2015-06-30 11:13:28'),
(49, 'https://www.youtube.com/channel/UCnExw5tVdA3TJeb4kmCd-JQ', 'http://debrs.com/7761', 'Yakov Fain\n - YouTube', 'a9c0475006162f81255e02c9e52b27c6c0da4381', '79.188.51.73', 1, '2015-06-30 11:13:50'),
(50, 'http://siliconrus.com/2014/11/train-your-brain/', 'http://debrs.com/2190', 'ÂŤĐĐ°Ń ĐźĐžĐˇĐł â ĐťĐľĐ˝Đ¸Đ˛Đ°Ń ŃĐ˛ĐžĐťĐžŃŃÂť Đ¸ĐťĐ¸ ĐşĐ°Đş ĐżŃĐľĐ´ĐžŃĐ˛ŃĐ°ŃĐ¸ŃŃ ĐˇĐ°ŃŃŃĐ˛Đ°Đ˝Đ¸Đľ Đ¸ Đ´ĐľĐłŃĐ°Đ´Đ°ŃĐ¸Ń ŃĐ°ĐˇŃĐźĐ°', 'ea302a67e2cfa1d82e26cba56b9d3b487fe28d29', '79.188.51.73', 0, '2015-06-30 11:14:57'),
(51, 'http://geektimes.ru/company/ulmart/blog/252458/?utm_source=tm_habrahabr&utm_medium=tm_block&utm_campaign=tm_promo', 'http://debrs.com/5ad0', 'ĐĐ°ĐšŃĐ°Đš ĐźĐ˝Đľ Đ˛ ŃĐžĐˇĐľŃĐşŃ: ĐżŃĐžĐşĐ¸Đ´ŃĐ˛Đ°ĐľĐź Đ¸Đ˝ŃĐľŃĐ˝ĐľŃ Đ˝ĐľŃŃĐ°Đ˝Đ´Đ°ŃŃĐ˝ŃĐź ĐżŃŃŃĐź / ĐĐťĐžĐł ĐşĐžĐźĐżĐ°Đ˝Đ¸Đ¸ ĐĐ¸ĐąĐľŃĐźĐ°ŃĐşĐľŃ ĐŽĐťĐźĐ°ŃŃ / Geektimes', 'f0e85fb603333f1cdd0aea90e78b823b229009e0', '79.188.51.73', 0, '2015-06-30 11:16:30'),
(52, 'http://docs.oracle.com/javaee/7/tutorial/', 'http://debrs.com/e675', 'Java Platform, Enterprise Edition: The Java EE Tutorial Release 7 - Contents', '622683fc9f22431df55c26daa5e9d89956265beb', '79.188.51.73', 0, '2015-06-30 12:06:10'),
(53, 'http://coreymaynard.com/blog/creating-a-restful-api-with-php/', 'http://debrs.com/2e59', 'Creating a RESTful API with PHP', '1a027e06120c0c96e3cba39bc663c0f60f68dc96', '79.188.51.73', 0, '2015-06-30 12:06:27'),
(54, 'http://www.econet.ru/articles/61968-pochemu-my-vstupaem-v-brak-s-nepravilnymi-lyudmi', 'http://debrs.com/41ce', 'ĐĐžŃĐľĐźŃ ĐźŃ Đ˛ŃŃŃĐżĐ°ĐľĐź Đ˛ ĐąŃĐ°Đş Ń Đ˝ĐľĐżŃĐ°Đ˛Đ¸ĐťŃĐ˝ŃĐźĐ¸  ĐťŃĐ´ŃĐźĐ¸', 'cbbf2bc83a570e777d7a2585b7a29e180339ef79', '79.188.51.73', 0, '2015-06-30 12:06:38'),
(55, 'http://www.javatpoint.com/method-overriding-in-java', 'http://debrs.com/9ba6', 'Method Overriding in Java - javatpoint', '8f188ecaa841548aae87ca7a68fcc764408b7f8d', '79.188.51.73', 0, '2015-06-30 12:07:51'),
(56, 'https://www.jetbrains.com/idea/help/creating-and-running-your-first-java-application.html', 'http://debrs.com/2e79', 'IntelliJ IDEA 14.1.1 Help :: Creating and Running Your First Java Application', 'e80cdf6a1f6f9db3f088559c58afe7df73186ed9', '79.188.51.73', 0, '2015-06-30 12:08:01'),
(57, 'http://www.awwwards.com/', 'http://debrs.com/851b', 'Awwwards - Website Awards - Best Web Design Trends', '612eeea2caa31149904a0995503637c929054e65', '79.188.51.73', 0, '2015-06-30 12:11:18'),
(58, 'http://eloquentjavascript.net/', 'http://debrs.com/7d45', 'Eloquent JavaScript', 'd950400dacc2c6bfaa7307786b75af2d992cc320', '79.188.51.73', 0, '2015-06-30 12:11:26'),
(59, 'http://stackoverflow.com/questions/10515439/how-to-properly-kill-sessions-in-zend-framework', 'http://debrs.com/1689', 'php - How to properly kill sessions in zend framework? - Stack Overflow', 'ffbc4dc378f1ad83cbad91986dbdeb245ccb1939', '217.67.194.50', 0, '2015-07-13 12:18:04'),
(60, 'http://ddd.com', 'http://debrs.com/3f2b', 'DDD | Advanced Imaging', 'c7d768ae8d12d64f5311959c0b892506f2921344', '217.67.194.50', 0, '2015-08-03 14:31:10'),
(61, 'http://sdsd.com', 'http://debrs.com/3b51', 'http://sdsd.com', '8fd920448e4113d5f157a9ae5bcccf098c6b6d08', '217.67.194.50', 0, '2015-08-03 14:31:58'),
(62, 'http://desss.com', 'http://debrs.com/3d69', 'Houston Web Design & Web Development Company | Mobile App Developer', 'fbf5e787a5349abeb755acf588c16b3bdf7ddb66', '217.67.194.50', 0, '2015-08-03 14:39:03'),
(63, 'http://stackoverflow.com/questions/16227644/angularjs-factory-http-service', 'http://debrs.com/0a90', 'javascript - angularjs factory $http service - Stack Overflow', 'd881cb84eeee4cbdd5972fe436435f70289c6bd1', '217.67.194.50', 1, '2015-08-03 14:43:41'),
(64, 'http://www.gumtree.pl/a-mieszkania-i-domy-do-wynajecia/%c5%bcoliborz/dwa-oddzielne-pokoje-na-zielonym-zoliborzu-po-remoncie-ul-potocka-przystanek-do-metra-pl-wilsona/1001396052040910661256109', 'http://debrs.com/c9ee', 'Dwa oddzielne pokoje na zielonym Ĺťoliborzu po remoncie ul.Potocka, przystanek do Metra pl.Wilsona | Ĺťoliborz | Gumtree | 139605204', '8af8fefcf1003a80c0bd3c9aa1647ac98fec9f66', '176.221.120.226', 1, '2015-08-23 14:36:50'),
(65, 'http://tapon.pl/12', 'http://debrs.com/9cd0', 'TapOn - 404 - strona nie istnieje', '899963e1a7fc59becb758ac9f4e0ca6a8d137ce9', '176.221.120.226', 0, '2015-08-29 22:14:03'),
(66, 'http://www.michaelbromley.co.uk/blog/108/paginate-almost-anything-in-angularjs', 'http://debrs.com/0bf3', 'http://www.michaelbromley.co.uk/blog/108/paginate-almost-anything-in-angularjs', 'cf468822141d70415656777970c8ec4ad904240a', '78.131.216.205', 7, '2015-09-03 11:14:36'),
(67, 'http://debrs.com/0bf3', 'http://debrs.com/6e85', 'http://debrs.com/0bf3', '1584e980cfe555089eddcce70d3ca29a27b2cbe6', '78.131.216.205', 5, '2015-09-03 11:15:00'),
(68, 'http://debrs.com/6e85', 'http://debrs.com/2bd0', 'http://debrs.com/6e85', 'e5f9b22d9050834fb508a612d80ede9164f0dd03', '78.131.216.205', 3, '2015-09-03 11:15:14'),
(69, 'http://debrs.com/2bd0', 'http://debrs.com/8d06', 'http://debrs.com/2bd0', '594e0c7eaee20d165a0435d9071d6f8ee37b8edd', '78.131.216.205', 1, '2015-09-03 11:15:24'),
(70, 'http://techcrunch.com', 'http://debrs.com/d3e2', 'TechCrunch - The latest technology news and information on startups', 'a378c52c60a6192287fa7f009630bdb9877096cb', '87.207.205.245', 0, '2015-09-03 17:29:47'),
(71, 'https://developer.mozilla.org/en-us/docs/web/javascript/reference/global_objects/numberformat', 'http://debrs.com/1647', 'Intl.NumberFormat - Web technology for developers | MDN', '1bbceb5fc0cb69155c173fa80350386cfc3cffaa', '78.131.216.205', 1, '2015-09-11 09:47:34'),
(72, 'http://stackoverflow.com/questions/149055/how-can-i-format-numbers-as-money-in-javascript', 'http://debrs.com/7732', 'formatting - How can I format numbers as money in JavaScript? - Stack Overflow', '4cae137983c463d9fc3a8606f4fff858bbe7933e', '78.131.216.205', 1, '2015-09-11 09:48:26');

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `fk_files_types` FOREIGN KEY (`type_id`) REFERENCES `types` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
