-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 07, 2024 at 08:40 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Shopping_System`
--

-- --------------------------------------------------------

--
-- Table structure for table `Customers`
--

CREATE TABLE `Customers` (
  `CustomerID` int(11) NOT NULL,
  `CustName` varchar(30) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Address` varchar(50) NOT NULL,
  `PhoneNumber` char(10) NOT NULL,
  `cust_password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Customers`
--

INSERT INTO `Customers` (`CustomerID`, `CustName`, `Email`, `Address`, `PhoneNumber`, `cust_password`) VALUES
(1, 'Teresa Mathew', 'teresa@example.com', '123 W Claire Rd', '469468467', 'teresa123'),
(3, 'Teresa Sam', 'teresa@example.com', '123 W Claire Rd', '469468467', 'teresa123'),
(4, 'Alice Smith', 'alice@example.com', '789 E Sun Blvd', '234235236', 'alice123');

-- --------------------------------------------------------

--
-- Table structure for table `Orders`
--

CREATE TABLE `Orders` (
  `OrderID` int(11) NOT NULL,
  `CustomerID` int(11) NOT NULL,
  `OrderDate` date NOT NULL,
  `TotalAmount` decimal(6,2) NOT NULL,
  `OrderStatus` varchar(8) NOT NULL DEFAULT 'Pending',
  `ProductID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Orders`
--

INSERT INTO `Orders` (`OrderID`, `CustomerID`, `OrderDate`, `TotalAmount`, `OrderStatus`, `ProductID`) VALUES
(11, 1, '2024-11-07', 49.99, 'Pending', 3),
(12, 1, '2024-11-07', 49.99, 'Pending', 3),
(13, 1, '2024-11-07', 49.99, 'Pending', 3),
(14, 1, '2024-11-07', 49.99, 'Pending', 3),
(15, 1, '2024-11-07', 49.99, 'Pending', 3),
(16, 1, '2024-11-07', 49.99, 'Pending', 3),
(17, 1, '2024-11-07', 49.99, 'Pending', 3),
(18, 1, '2024-11-07', 49.99, 'Pending', 3),
(19, 1, '2024-11-07', 49.99, 'Pending', 3);

-- --------------------------------------------------------

--
-- Table structure for table `Payments`
--

CREATE TABLE `Payments` (
  `PaymentID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `CustomerID` int(11) NOT NULL,
  `PaymentDate` date NOT NULL,
  `TotalAmount` decimal(6,2) NOT NULL,
  `PaymentMethod` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Payments`
--

INSERT INTO `Payments` (`PaymentID`, `OrderID`, `CustomerID`, `PaymentDate`, `TotalAmount`, `PaymentMethod`) VALUES
(11, 11, 1, '2024-11-07', 49.99, 'Debit Card'),
(12, 12, 1, '2024-11-07', 49.99, 'Credit Card'),
(13, 13, 1, '2024-11-07', 49.99, 'Credit Card'),
(14, 14, 1, '2024-11-07', 49.99, 'Credit Card'),
(15, 15, 1, '2024-11-07', 49.99, 'Credit Card'),
(16, 16, 1, '2024-11-07', 49.99, 'Credit Card'),
(17, 17, 1, '2024-11-07', 49.99, 'Credit Card'),
(18, 18, 1, '2024-11-07', 49.99, 'Credit Card'),
(19, 19, 1, '2024-11-07', 49.99, 'Credit Card');

-- --------------------------------------------------------

--
-- Table structure for table `Products`
--

CREATE TABLE `Products` (
  `ProductID` int(11) NOT NULL,
  `ProductName` varchar(50) NOT NULL,
  `Details` text DEFAULT NULL,
  `Price` decimal(6,2) NOT NULL,
  `StockQuantity` int(11) NOT NULL DEFAULT 0,
  `CustomerID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Products`
--

INSERT INTO `Products` (`ProductID`, `ProductName`, `Details`, `Price`, `StockQuantity`, `CustomerID`) VALUES
(3, 'Bluetooth Speaker', 'Wireless - Wi-Fi connectivity\r\nFull Spectrum sound with powerful bass', 49.99, 6, 1),
(4, 'Organic Cotton T-Shirt', 'A soft, breathable t-shirt made from 100% organic cotton. Available in various colors and sizes.', 19.99, 100, 1),
(5, 'Ceramic Coffee Mug Set', 'A set of four ceramic coffee mugs with unique, hand-painted designs. Microwave and dishwasher safe.', 25.99, 10, 1),
(6, 'Stainless Steel Water Bottle', 'Durable, double-walled water bottle that keeps drinks cold for 24 hours and hot for 12 hours. Leak-proof and perfect for on-the-go.', 15.99, 50, 4);

-- --------------------------------------------------------

--
-- Table structure for table `Reviews`
--

CREATE TABLE `Reviews` (
  `ReviewNum` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `CustomerID` int(11) DEFAULT NULL,
  `Stars` int(11) NOT NULL DEFAULT 1 CHECK (`Stars` between 1 and 5),
  `Review` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `Reviews`
--

INSERT INTO `Reviews` (`ReviewNum`, `ProductID`, `CustomerID`, `Stars`, `Review`) VALUES
(1, 3, 1, 5, 'Really good sound '),
(2, 3, 1, 3, 'A bit loose but good for the price');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Customers`
--
ALTER TABLE `Customers`
  ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `Orders`
--
ALTER TABLE `Orders`
  ADD PRIMARY KEY (`OrderID`),
  ADD KEY `CustomerID` (`CustomerID`),
  ADD KEY `fk_product` (`ProductID`);

--
-- Indexes for table `Payments`
--
ALTER TABLE `Payments`
  ADD PRIMARY KEY (`PaymentID`),
  ADD KEY `OrderID` (`OrderID`),
  ADD KEY `CustomerID` (`CustomerID`);

--
-- Indexes for table `Products`
--
ALTER TABLE `Products`
  ADD PRIMARY KEY (`ProductID`),
  ADD KEY `fk_customer` (`CustomerID`);

--
-- Indexes for table `Reviews`
--
ALTER TABLE `Reviews`
  ADD PRIMARY KEY (`ReviewNum`),
  ADD KEY `ProductID` (`ProductID`),
  ADD KEY `CustomerID` (`CustomerID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Customers`
--
ALTER TABLE `Customers`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `Orders`
--
ALTER TABLE `Orders`
  MODIFY `OrderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `Payments`
--
ALTER TABLE `Payments`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `Products`
--
ALTER TABLE `Products`
  MODIFY `ProductID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `Reviews`
--
ALTER TABLE `Reviews`
  MODIFY `ReviewNum` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Orders`
--
ALTER TABLE `Orders`
  ADD CONSTRAINT `fk_product` FOREIGN KEY (`ProductID`) REFERENCES `Products` (`ProductID`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`CustomerID`) REFERENCES `Customers` (`CustomerID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Payments`
--
ALTER TABLE `Payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`OrderID`) REFERENCES `Orders` (`OrderID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payments_ibfk_2` FOREIGN KEY (`CustomerID`) REFERENCES `Customers` (`CustomerID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Products`
--
ALTER TABLE `Products`
  ADD CONSTRAINT `fk_customer` FOREIGN KEY (`CustomerID`) REFERENCES `Customers` (`CustomerID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Reviews`
--
ALTER TABLE `Reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`ProductID`) REFERENCES `Products` (`ProductID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`CustomerID`) REFERENCES `Customers` (`CustomerID`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
