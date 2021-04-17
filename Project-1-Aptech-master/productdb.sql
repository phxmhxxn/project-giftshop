-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2021 at 07:10 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `productdb`
--

DELIMITER $$
--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `acronym` (`str` TEXT) RETURNS TEXT CHARSET utf8 begin
    declare result text default '';
    set result = initials( str, '[[:alnum:]]' );
    return result;
end$$

CREATE DEFINER=`root`@`localhost` FUNCTION `initials` (`str` TEXT, `expr` TEXT) RETURNS TEXT CHARSET utf8 begin
    declare result text default '';
    declare buffer text default '';
    declare i int default 1;
    if(str is null) then
        return null;
    end if;
    set buffer = trim(str);
    while i <= length(buffer) do
        if substr(buffer, i, 1) regexp expr then
            set result = concat( result, substr( buffer, i, 1 ));
            set i = i + 1;
            while i <= length( buffer ) and substr(buffer, i, 1) regexp expr do
                set i = i + 1;
            end while;
            while i <= length( buffer ) and substr(buffer, i, 1) not regexp expr do
                set i = i + 1;
            end while;
        else
            set i = i + 1;
        end if;
    end while;
    return result;
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `billing`
--

CREATE TABLE `billing` (
  `id` int(11) NOT NULL,
  `invoiceID` varchar(30) NOT NULL,
  `productID` varchar(30) NOT NULL,
  `price` decimal(7,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `stt` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `billing`
--

INSERT INTO `billing` (`id`, `invoiceID`, `productID`, `price`, `quantity`, `stt`) VALUES
(68, 'CB2021-04-000058', 'CV2021000003', '24.00', 1, 1),
(69, 'CB2021-04-000058', 'AV2021000004', '20.00', 1, 0),
(70, 'CB2021-04-000059', 'CV2021000003', '24.00', 1, 1),
(71, 'CB2021-04-000059', 'AV2021000004', '20.00', 1, 0),
(72, 'CB2021-04-000060', 'AV2021000004', '20.00', 1, 0),
(73, 'CB2021-04-000061', 'AV2021000004', '20.00', 1, 0),
(74, 'CB2021-04-000062', 'AV2021000004', '20.00', 1, 0),
(75, 'CB2021-04-000063', 'AV2021000004', '20.00', 1, 0),
(76, 'CB2021-04-000064', 'AV2021000004', '20.00', 1, 0),
(77, 'CB2021-04-000065', 'AV2021000004', '20.00', 1, 0),
(78, 'CB2021-04-000066', 'AV2021000004', '20.00', 1, 0),
(79, 'CB2021-04-000067', 'AV2021000004', '20.00', 2, 0),
(80, 'CB2021-04-000071', 'CV2021000003', '24.00', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brandID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `stt` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brandID`, `name`, `stt`) VALUES
(1, 'GUCCI', 1),
(2, 'CHANEL', 1),
(22, 'VERSACE', 1);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categoryID` int(11) NOT NULL,
  `maincategoryID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `stt` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`categoryID`, `maincategoryID`, `name`, `stt`) VALUES
(1, 1, 'Anime', 1),
(2, 1, 'Cartoon', 1),
(3, 1, 'K-POP', 1),
(4, 1, 'Dog', 1),
(5, 1, 'Cat', 1),
(7, 2, 'Game', 1),
(8, 2, 'Manga - Anime', 1),
(9, 2, 'Lego', 1),
(11, 3, 'Men\'s fashion', 1),
(12, 3, 'Women\'s fashion', 1),
(13, 3, 'Girl\'s fashion', 1),
(14, 3, 'Boy\'s fashion', 1),
(15, 4, 'Mobile cases', 1),
(16, 4, 'Phone accessories', 1),
(17, 4, 'Laptop accessories', 1),
(18, 4, 'Handheld electronic game', 1),
(19, 4, 'Headphones', 1),
(20, 4, 'Speakers', 1),
(21, 5, 'Backpack', 1),
(22, 5, 'Cross bag', 1),
(23, 5, 'Pen', 1),
(24, 5, 'Notebook', 1),
(25, 5, 'Ruler', 1),
(26, 5, 'Pen box', 1),
(27, 5, 'Postcard - Poster', 1),
(28, 5, 'STICKER', 1);

-- --------------------------------------------------------

--
-- Table structure for table `customer_user`
--

CREATE TABLE `customer_user` (
  `userID` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `customerFname` varchar(20) NOT NULL,
  `customerLname` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `city` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer_user`
--

INSERT INTO `customer_user` (`userID`, `username`, `password`, `customerFname`, `customerLname`, `phone`, `email`, `address`, `city`) VALUES
(0, 'none', '', '', '', '', '', '', ''),
(2, 'hiencao', '9f88c9d7cde4cc704c7874846b71846b', 'Hiển', 'Phạm', '0999333999', '92kkid@gmail.com', 'hoang mai', ''),
(5, 'hiencao1', '9f88c9d7cde4cc704c7874846b71846b', 'Hien', 'Cao', '0999999999', '92kkid1@gmail.com', 'aaaaccc', ''),
(6, 'hiencao2', '9f88c9d7cde4cc704c7874846b71846b', 'hien', 'pham', '0921687382', '92kkid2@gmail.com', 'qewwqeqw', 'Cao Bằng');

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `invoiceID` varchar(30) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `city` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `CreateDate` datetime NOT NULL,
  `stt` int(1) NOT NULL,
  `userID` int(30) NOT NULL,
  `shippingfee` decimal(7,2) NOT NULL,
  `freeshipping` tinyint(1) NOT NULL,
  `buyerpaid` decimal(7,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoices`
--

INSERT INTO `invoices` (`id`, `invoiceID`, `name`, `phone`, `city`, `address`, `CreateDate`, `stt`, `userID`, `shippingfee`, `freeshipping`, `buyerpaid`) VALUES
(98, 'CB2021-04-000058', 'hien', '0921687382', 'Cao Bằng', 'qewwqeqw', '2021-04-17 00:00:00', 4, 6, '12.00', 0, '12.00'),
(99, 'CB2021-04-000059', 'hien', '0921687382', 'Cao Bằng', 'qewwqeqw', '2021-04-17 00:00:00', 4, 6, '4.00', 1, '4.00'),
(100, 'CB2021-04-000060', 'hien', '0921687382', 'Cao Bằng', 'qewwqeqw', '2021-04-17 00:00:00', 5, 6, '3.00', 0, '0.00'),
(101, 'CB2021-04-000061', 'hien', '0921687382', 'Cao Bằng', 'qewwqeqw', '2021-04-17 00:00:00', 1, 6, '0.00', 0, '0.00'),
(102, 'CB2021-04-000062', 'hien', '0921687382', 'Cao Bằng', 'dasdacasda ', '2021-04-17 00:00:00', 1, 6, '0.00', 0, '0.00'),
(103, 'CB2021-04-000063', 'hien', '0921687382', 'Cao Bằng', 'qewwqeqw', '2021-04-17 00:00:00', 1, 6, '0.00', 0, '0.00'),
(104, 'CB2021-04-000064', 'hien', '0921687382', 'Cao Bằng', 'qewwqeqw', '2021-04-17 00:00:00', 1, 6, '0.00', 0, '0.00'),
(105, 'CB2021-04-000065', 'hien', '0921687382', 'Cao Bằng', 'qewwqeqw', '2021-04-17 00:00:00', 1, 6, '0.00', 0, '0.00'),
(106, 'CB2021-04-000066', 'hien', '0921687382', 'Cao Bằng', 'qewwqeqw', '2021-04-17 00:00:00', 1, 6, '0.00', 0, '0.00'),
(107, 'CB2021-04-000067', 'hien', '0921687382', 'Cao Bằng', 'qewwqeqw', '2021-04-17 00:00:00', 0, 6, '0.00', 0, '0.00'),
(111, 'CB2021-04-000071', 'hien', '0921687382', 'Cao Bằng', 'qewwqeqw', '2021-04-18 00:02:46', 0, 6, '0.00', 0, '0.00');

--
-- Triggers `invoices`
--
DELIMITER $$
CREATE TRIGGER `tg_invoice_insert` BEFORE INSERT ON `invoices` FOR EACH ROW BEGIN
  INSERT INTO invoice_seq VALUES (NULL);
  SET NEW.invoiceID = CONCAT(acronym(NEW.city), LEFT(NEW.CreateDate,8),RIGHT(LPAD(LAST_INSERT_ID(), 20, '0'),6));
  INSERT INTO invoice_noti VALUES (NEW.invoiceID);
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_noti`
--

CREATE TABLE `invoice_noti` (
  `invoiceID` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoice_noti`
--

INSERT INTO `invoice_noti` (`invoiceID`) VALUES
('CB000068');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_seq`
--

CREATE TABLE `invoice_seq` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `invoice_seq`
--

INSERT INTO `invoice_seq` (`id`) VALUES
(1),
(2),
(3),
(4),
(5),
(6),
(7),
(8),
(9),
(10),
(11),
(12),
(13),
(14),
(15),
(16),
(17),
(18),
(19),
(20),
(21),
(22),
(23),
(24),
(25),
(26),
(27),
(28),
(29),
(30),
(31),
(32),
(33),
(34),
(35),
(36),
(37),
(38),
(39),
(40),
(41),
(42),
(43),
(44),
(45),
(46),
(47),
(48),
(49),
(50),
(51),
(52),
(53),
(54),
(55),
(56),
(57),
(58),
(59),
(60),
(61),
(62),
(63),
(64),
(65),
(66),
(67),
(68),
(69),
(70),
(71);

-- --------------------------------------------------------

--
-- Table structure for table `main_categories`
--

CREATE TABLE `main_categories` (
  `maincategoryID` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `stt` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `main_categories`
--

INSERT INTO `main_categories` (`maincategoryID`, `name`, `stt`) VALUES
(1, 'Stuffed animals', 1),
(2, 'Toy models', 1),
(3, 'Fashion', 1),
(4, 'Electronics', 1),
(5, 'Stationery', 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productID` varchar(30) CHARACTER SET utf8mb4 NOT NULL,
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `desci` text NOT NULL,
  `price` decimal(7,2) NOT NULL,
  `rrp` decimal(7,2) NOT NULL DEFAULT 0.00,
  `quantity` int(11) NOT NULL,
  `img` text NOT NULL,
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `categoryID` int(11) NOT NULL,
  `brandID` int(11) NOT NULL,
  `stt` tinyint(1) NOT NULL,
  `file` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`productID`, `id`, `name`, `desci`, `price`, `rrp`, `quantity`, `img`, `date_added`, `categoryID`, `brandID`, `stt`, `file`) VALUES
('CV2021000003', 61, 'Gấu bông chữ U Mèo áo hoa kèm bịt mắt', 'dsadascasd', '24.00', '0.00', 105, '21040006_GR_1000x1000.jpg', '2021-04-15 12:23:55', 2, 2, 1, ''),
('AV2021000004', 62, 'Gấu bông MJ Tàu ngầm cartoon 55cm - Vàng', '', '20.00', '0.00', 77, '21040010_YL_1000x1000.jpg', '2021-04-15 12:24:14', 1, 22, 1, '');

--
-- Triggers `products`
--
DELIMITER $$
CREATE TRIGGER `tg_productid_insert` BEFORE INSERT ON `products` FOR EACH ROW BEGIN
DECLARE brand_ VARCHAR(100);
DECLARE category_ VARCHAR(100);
  INSERT INTO products_seq VALUES (NULL);
  SELECT `name` INTO brand_ FROM brands WHERE brandID = NEW.brandID; 
  SELECT `name` INTO category_ FROM categories WHERE categoryID = NEW.categoryID;
  SET NEW.productID = CONCAT(acronym(category_),acronym(brand_), LEFT(NEW.date_added,4), RIGHT(LPAD(LAST_INSERT_ID(), 20, '0'),6));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `products_seq`
--

CREATE TABLE `products_seq` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products_seq`
--

INSERT INTO `products_seq` (`id`) VALUES
(1),
(2),
(3),
(4);

-- --------------------------------------------------------

--
-- Stand-in structure for view `search`
-- (See below for the actual view)
--
CREATE TABLE `search` (
`file` text
,`date_added` datetime
,`quantity` int(11)
,`stt` tinyint(1)
,`img` text
,`name` varchar(200)
,`productID` varchar(30)
,`desci` text
,`price` decimal(7,2)
,`rrp` decimal(7,2)
,`categoryNAME` varchar(100)
,`maincategoryNAME` varchar(100)
,`brandNAME` varchar(100)
);

-- --------------------------------------------------------

--
-- Table structure for table `slideshow`
--

CREATE TABLE `slideshow` (
  `id` int(11) NOT NULL,
  `img` text NOT NULL,
  `stt` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `slideshow`
--

INSERT INTO `slideshow` (`id`, `img`, `stt`) VALUES
(16, '4247776023_718b392cac_h.jpg', 1),
(17, '4432435310_4edf8c0576_o.jpg', 1),
(18, '6240134386_d9b3f8ad15_k.jpg', 1),
(19, '265740754_d25f99d452_k.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id`, `username`, `password`, `role`) VALUES
(1, 'hien', '9f88c9d7cde4cc704c7874846b71846b', 0),
(5, 'nguyen', 'eaaf8fdc39a482fdd2e720814cabbf9d', 0),
(6, 'invoice1', '9f88c9d7cde4cc704c7874846b71846b', 2),
(7, 'product1', '9f88c9d7cde4cc704c7874846b71846b', 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_customer`
-- (See below for the actual view)
--
CREATE TABLE `view_customer` (
`userID` int(11)
,`username` varchar(20)
,`customerFname` varchar(20)
,`phone` varchar(20)
,`invoiceID` varchar(30)
,`city` varchar(20)
,`address` text
,`recipient` varchar(100)
,`CreateDate` datetime
,`stt` int(1)
,`productNAME` varchar(200)
,`price` decimal(7,2)
,`quantity` int(11)
,`freeshipping` tinyint(1)
,`shippingfee` decimal(7,2)
,`img` text
,`productID` varchar(30)
,`itemstt` tinyint(1)
);

-- --------------------------------------------------------

--
-- Structure for view `search`
--
DROP TABLE IF EXISTS `search`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `search`  AS SELECT `products`.`file` AS `file`, `products`.`date_added` AS `date_added`, `products`.`quantity` AS `quantity`, `products`.`stt` AS `stt`, `products`.`img` AS `img`, `products`.`name` AS `name`, `products`.`productID` AS `productID`, `products`.`desci` AS `desci`, `products`.`price` AS `price`, `products`.`rrp` AS `rrp`, `categories`.`name` AS `categoryNAME`, `main_categories`.`name` AS `maincategoryNAME`, `brands`.`name` AS `brandNAME` FROM (((`products` left join `categories` on(`products`.`categoryID` = `categories`.`categoryID`)) left join `main_categories` on(`categories`.`maincategoryID` = `main_categories`.`maincategoryID`)) left join `brands` on(`products`.`brandID` = `brands`.`brandID`)) ;

-- --------------------------------------------------------

--
-- Structure for view `view_customer`
--
DROP TABLE IF EXISTS `view_customer`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_customer`  AS SELECT `customer_user`.`userID` AS `userID`, `customer_user`.`username` AS `username`, `customer_user`.`customerFname` AS `customerFname`, `invoices`.`phone` AS `phone`, `invoices`.`invoiceID` AS `invoiceID`, `invoices`.`city` AS `city`, `invoices`.`address` AS `address`, `invoices`.`name` AS `recipient`, `invoices`.`CreateDate` AS `CreateDate`, `invoices`.`stt` AS `stt`, `products`.`name` AS `productNAME`, `billing`.`price` AS `price`, `billing`.`quantity` AS `quantity`, `invoices`.`freeshipping` AS `freeshipping`, `invoices`.`shippingfee` AS `shippingfee`, `products`.`img` AS `img`, `products`.`productID` AS `productID`, `billing`.`stt` AS `itemstt` FROM ((`billing` left join (`invoices` left join `customer_user` on(`customer_user`.`userID` = `invoices`.`userID`)) on(`invoices`.`invoiceID` = `billing`.`invoiceID`)) left join `products` on(`products`.`productID` = `billing`.`productID`)) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `billing`
--
ALTER TABLE `billing`
  ADD PRIMARY KEY (`id`),
  ADD KEY `BillID` (`invoiceID`),
  ADD KEY `productID` (`productID`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brandID`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categoryID`),
  ADD KEY `main_category` (`maincategoryID`);

--
-- Indexes for table `customer_user`
--
ALTER TABLE `customer_user`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `billingID` (`invoiceID`) USING BTREE,
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `invoice_seq`
--
ALTER TABLE `invoice_seq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `main_categories`
--
ALTER TABLE `main_categories`
  ADD PRIMARY KEY (`maincategoryID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `productID` (`productID`),
  ADD KEY `category` (`categoryID`),
  ADD KEY `brand` (`brandID`);

--
-- Indexes for table `products_seq`
--
ALTER TABLE `products_seq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slideshow`
--
ALTER TABLE `slideshow`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `billing`
--
ALTER TABLE `billing`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brandID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `customer_user`
--
ALTER TABLE `customer_user`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `invoice_seq`
--
ALTER TABLE `invoice_seq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `main_categories`
--
ALTER TABLE `main_categories`
  MODIFY `maincategoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT for table `products_seq`
--
ALTER TABLE `products_seq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `slideshow`
--
ALTER TABLE `slideshow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `billing`
--
ALTER TABLE `billing`
  ADD CONSTRAINT `billing_ibfk_2` FOREIGN KEY (`invoiceID`) REFERENCES `invoices` (`invoiceID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `billing_ibfk_3` FOREIGN KEY (`productID`) REFERENCES `products` (`productID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`maincategoryID`) REFERENCES `main_categories` (`maincategoryID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `invoices`
--
ALTER TABLE `invoices`
  ADD CONSTRAINT `invoices_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `customer_user` (`userID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`categoryID`) REFERENCES `categories` (`categoryID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `products_ibfk_3` FOREIGN KEY (`brandID`) REFERENCES `brands` (`brandID`) ON DELETE NO ACTION ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
