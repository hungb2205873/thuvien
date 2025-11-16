
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ql_sach`
--

DELIMITER $$
--
-- Procedures
--
DROP PROCEDURE IF EXISTS `chinhsuadocgia`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `chinhsuadocgia` (IN `tendg` VARCHAR(40) CHARSET utf8, IN `ngaysinh` DATE, IN `diachi` VARCHAR(255), IN `id1` INT(11))  UPDATE docgia SET tendg=tendg, ngaysinh=ngaysinh, diachi=diachi WHERE id=id1$$

DROP PROCEDURE IF EXISTS `chinhsuamuontra`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `chinhsuamuontra` (IN `id_sach` INT(11), IN `id_dg` INT(11), IN `ngaymuon` DATE, IN `ngaytra` DATE, IN `tinhtrang` VARCHAR(40) CHARSET utf8, IN `id1` INT(10))  UPDATE muontra SET id_sach=id_sach, id_dg=id_dg, ngaymuon=ngaymuon, ngaytra=ngaytra, tinhtrang=tinhtrang WHERE id=id1$$

DROP PROCEDURE IF EXISTS `chinhsuasach`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `chinhsuasach` (IN `tensach` VARCHAR(100) CHARSET utf8, IN `tentg` VARCHAR(100) CHARSET utf8, IN `nhaxuatban` VARCHAR(100) CHARSET utf8, IN `ngayxb` DATE, IN `soluong` INT(11), IN `tomtat` VARCHAR(255) CHARSET utf8, IN `id1` INT(11))  UPDATE sach SET tensach=tensach, tentg=tentg, nhaxuatban=nhaxuatban, ngayxb=ngayxb, soluong=soluong, tomtat=tomtat WHERE id=id1$$

DROP PROCEDURE IF EXISTS `hienthidocgia`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `hienthidocgia` ()  SELECT * FROM docgia$$

DROP PROCEDURE IF EXISTS `hienthisach`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `hienthisach` ()  SELECT * FROM sach$$

DROP PROCEDURE IF EXISTS `themdocgia`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `themdocgia` (IN `tendg` VARCHAR(40) CHARSET utf8, IN `ngaysinh` DATE, IN `diachi` VARCHAR(255) CHARSET utf8)  INSERT INTO docgia(tendg, ngaysinh, diachi) VALUES(tendg, ngaysinh, diachi)$$

DROP PROCEDURE IF EXISTS `themmuontra`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `themmuontra` (IN `id_sach` INT(11), IN `id_dg` INT(11), IN `ngaymuon` DATE, IN `ngaytra` DATE, IN `tinhtrang` VARCHAR(40) CHARSET utf8)  INSERT INTO muontra(id_sach,id_dg,ngaymuon,ngaytra,tinhtrang) VALUES(id_sach,id_dg,ngaymuon,ngaytra,tinhtrang)$$

DROP PROCEDURE IF EXISTS `themsach`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `themsach` (IN `tensach` VARCHAR(100) CHARSET utf8, IN `tentg` VARCHAR(100) CHARSET utf8, IN `nhaxuatban` VARCHAR(100) CHARSET utf8, IN `ngayxb` DATE, IN `soluong` INT(11), IN `tomtat` VARCHAR(255) CHARSET utf8)  INSERT INTO sach(tensach,tentg,nhaxuatban,ngayxb,soluong,tomtat) VALUES(tensach,tentg,nhaxuatban,ngayxb,soluong,tomtat)$$

DROP PROCEDURE IF EXISTS `xoadocgia`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `xoadocgia` (IN `id1` INT(10))  DELETE FROM docgia WHERE id=id1$$

DROP PROCEDURE IF EXISTS `xoamuontra`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `xoamuontra` (IN `id1` INT(10))  DELETE FROM muontra WHERE id=id1$$

DROP PROCEDURE IF EXISTS `xoa_sach`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `xoa_sach` (IN `id1` INT(10))  DELETE FROM sach WHERE id=id1$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tk` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mk` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `tk`, `mk`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `docgia`
--

DROP TABLE IF EXISTS `docgia`;
CREATE TABLE IF NOT EXISTS `docgia` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tendg` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ngaysinh` date NOT NULL,
  `diachi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `docgia`
--
INSERT INTO `docgia` (`id`, `tendg`, `ngaysinh`, `diachi`) VALUES
(1, 'TRAN TUONG DOAN', '2001-08-24', 'Can Tho'),
(2, 'Nguyen Quan Thang', '2004-08-02', '0362123456'),
(3, 'NGUYEN NHAT ANH', '1996-10-02', 'Vinh Long'),
(4, 'Luu Vu Hung', '2004-02-01', '0362123789'),
(5, 'Duong Quoc Thien', '2004-11-05', '0365456789'),
(6, 'HUYNH ANH KHOI', '2001-07-16', 'Ca Mau'),
(7, 'PHAM HONG PHU', '1994-09-27', 'Vinh Long'),
(8, 'Nguyen Anh Kiet', '2004-08-02', '0369123098'),
(9, 'Nguyen Thi Minh', '2004-02-28', '0935159753'),
(10, 'Tran Gia Hao', '2004-11-05', '0365963741'),
(11, 'Vo Thi Nguyet', '2004-03-08', '0932258963'),
(13, 'Nguyen Vu Nguyen', '2002-02-11', '0123521140'),
(14, 'Nguyen Van A', '2000-11-11', '01235211400'),
(15, 'Nguyen Van B', '2006-11-11', '02354646456'),
(16, 'Dương Minh Tri', '2004-11-06', '0368098765');


-- --------------------------------------------------------

--
-- Table structure for table `muontra`
--

DROP TABLE IF EXISTS `muontra`;
CREATE TABLE IF NOT EXISTS `muontra` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_sach` int NOT NULL,
  `id_dg` int NOT NULL,
  `ngaymuon` date NOT NULL,
  `ngaytra` date NOT NULL,
  `tinhtrang` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_sach` (`id_sach`),
  KEY `id_dg` (`id_dg`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `muontra`
--
INSERT INTO `muontra` (`id`, `id_sach`, `id_dg`, `ngaymuon`, `ngaytra`, `tinhtrang`) VALUES
(1, 19, 3, '2022-10-28', '2022-11-04', 'Trả muộn'),   
(2, 3, 1, '2022-10-28', '2022-11-03', 'Đã trả'),     
(3, 11, 3, '2022-10-12', '2022-11-04', 'Đã mượn'),    
(4, 9, 7, '2022-10-08', '2022-11-15', 'Đã trả');      

-- --------------------------------------------------------

--
-- Table structure for table `sach`
--

DROP TABLE IF EXISTS `sach`;
CREATE TABLE IF NOT EXISTS `sach` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tensach` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tentg` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nhaxuatban` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ngayxb` date NOT NULL,
  `soluong` int NOT NULL,
  `tomtat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `sach`
--
-- Bảng sach (id duy nhất, ngày chuẩn YYYY-MM-DD)
-- Dumping data for table `sach`
INSERT INTO `sach` (`id`, `tensach`, `tentg`, `nhaxuatban`, `ngayxb`, `soluong`, `tomtat`) VALUES
(1, 'DOREMON', 'Fujiko F. Fujio', 'Kim Dong', '2014-12-18', 120, 'Doraemon - chú mèo máy đến từ tương lai'),
(2, 'DE MEN PHIEU LUU KY', 'To Hoai', 'Ha Noi', '2015-05-31', 96, 'Dành cho lứa tuổi thiếu nhi'),
(3, 'HARRY POTTER', 'J. K. Rowling', 'Kim Dong', '2020-05-14', 255, 'Harry Potter và Phòng chứa Bí mật'),
(4, 'DA VINCI CODE', 'Dan Brown', 'Dong Thap', '2018-09-14', 219, 'Về mật mã Da Vinci'),
(5, 'NHAT THUC', 'Meyer', 'Thanh Nien', '2021-09-16', 340, 'Dành cho độ tuổi thiếu niên'),
(6, 'Cho Tôi Xin Một Vé Đi Tuổi Thơ', 'Nguyễn Nhật Ánh', 'NXB Trẻ', '2008-01-01', 18, 'Tác phẩm thiếu nhi nổi tiếng'),
(7, 'Harry Potter và Hòn Đá Phù Thủy', 'J.K. Rowling', 'Bloomsbury', '1997-01-01', 15, 'Tập đầu tiên của Harry Potter'),
(8, 'Sapiens: Lược Sử Loài Người', 'Yuval Noah Harari', 'HarperCollins', '2011-01-01', 9, 'Khảo cứu lịch sử loài người'),
(9, 'Đắc Nhân Tâm', 'Dale Carnegie', 'Simon & Schuster', '1936-01-01', 20, 'Sách kỹ năng sống nổi tiếng'),
(10, 'Doraemon Tập 1', 'Fujiko F. Fujio', 'Shogakukan', '1970-01-01', 23, 'Tập đầu tiên của Doraemon'),
(11, 'Thám Tử Lừng Danh Conan Tập 1', 'Gosho Aoyama', 'Shogakukan', '1994-01-01', 30, 'Tập đầu tiên của Conan'),
(12, 'Cha Giàu Cha Nghèo', 'Robert T. Kiyosaki', 'Plata Publishing', '1997-01-01', 18, 'Sách tài chính cá nhân nổi tiếng'),
(13, 'Giáo Trình Cấu Trúc Dữ Liệu và Giải Thuật', 'Nguyễn Quàn Thắng', 'NXB Giáo Dục', '2010-01-01', 10, 'Giáo trình CNTT'),
(14, 'Project Hail Mary', 'Robert C. Martin', 'Ballantine Books', '2021-01-01', 7, 'Tiểu thuyết khoa học viễn tưởng'),
(15, 'Tomorrow, and Tomorrow, and Tomorrow', 'Gabrielle Zevin', 'Knopf', '2022-01-01', 10, 'Tiểu thuyết hiện đại'),
(16, 'Nhà Giả Kim', 'Paulo Coelho', 'HarperTorch', '1988-01-01', 20, 'Tác phẩm nổi tiếng toàn cầu'),
(17, 'Norwegian Wood', 'Haruki Murakami', 'Kodansha', '1987-01-01', 13, 'Tiểu thuyết Nhật Bản'),
(18, 'Mật Mã Da Vinci', 'Dan Brown', 'Doubleday', '2003-01-01', 16, 'Tiểu thuyết trinh thám nổi tiếng'),
(19, '1984', 'George Orwell', 'Secker & Warburg', '1949-01-01', 25, 'Tác phẩm phản utopia'),
(20, 'Phía Tây Không Có Gì Lạ', 'Erich Maria Remarque', 'Propyläen Verlag', '1929-01-01', 12, 'Tiểu thuyết chiến tranh'),
(21, 'Lược Sử Thời Gian', 'Stephen Hawking', 'Bantam Books', '1988-01-01', 20, 'Sách khoa học nổi tiếng'),
(22, 'Hoàng Tử Bé', 'Antoine de Saint-Exupéry', 'Reynal & Hitchcock', '1943-01-01', 26, 'Tác phẩm thiếu nhi nổi tiếng'),
(23, 'Think and Grow Rich', 'Napoleon Hill', 'The Ralston Society', '1937-01-01', 17, 'Sách kinh doanh kinh điển'),
(24, 'Outliers: The Story of Success', 'Malcolm Gladwell', 'Little, Brown and Company', '2008-01-01', 14, 'Phân tích thành công'),
(25, 'Atomic Habits', 'James Clear', 'Avery', '2018-01-01', 21, 'Sách về thói quen'),
(26, 'Nguyễn Vũ Nguyên', 'Lưu Vũ Hùng', 'Mẹ', '2004-01-01', 20, 'Tác phẩm cá nhân');






--
-- Constraints for dumped tables
--  

--
-- Constraints for table `muontra`
--
ALTER TABLE `muontra`
  ADD CONSTRAINT `muontra_ibfk_1` FOREIGN KEY (`id_sach`) REFERENCES `sach` (`id`),
  ADD CONSTRAINT `muontra_ibfk_2` FOREIGN KEY (`id_dg`) REFERENCES `docgia` (`id`);
COMMIT
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
