CREATE SCHEMA Shopping_System;

CREATE TABLE Products(
ProductID INT NOT NULL,
    ProductName VARCHAR(50) NOT NULL,
    Details TEXT,
    Price DECIMAL(6,2) NOT NULL,
    StockQuantity INT NOT NULL DEFAULT 0,
    PRIMARY KEY (ProductID)
);
CREATE TABLE Orders(
OrderID INT NOT NULL,
    CustomerID INT NOT NULL,
    OrderDate DATE NOT NULL,
    TotalAmount DECIMAL(6,2) NOT NULL,
    OrderStatus VARCHAR(8) NOT NULL DEFAULT 'Pending',
    PRIMARY KEY (OrderID),
    FOREIGN KEY (CustomerID) REFERENCES Customers(CustomerID)
ON DELETE CASCADE
        ON UPDATE CASCADE
);
CREATE TABLE Customers(
CustomerID INT NOT NULL,
    CustName VARCHAR(30) NOT NULL,
    Email VARCHAR(100) NOT NULL,
    Address VARCHAR(50) NOT NULL,
    PhoneNumber CHAR(10) NOT NULL,
    cust_password VARCHAR(20) NOT NULL,
    PRIMARY KEY (CustomerID)
);
CREATE TABLE Payments(
PaymentID INT NOT NULL,
    OrderID INT NOT NULL,
    CustomerID INT NOT NULL,
    PaymentDate DATE NOT NULL,
    TotalAmount DECIMAL(6,2) NOT NULL,
    PaymentMethod VARCHAR(16) NOT NULL,
    PRIMARY KEY (PaymentID),
    FOREIGN KEY (OrderID) REFERENCES Orders(OrderID)
ON DELETE CASCADE
        ON UPDATE CASCADE,
FOREIGN KEY (CustomerID) REFERENCES Customers(CustomerID)
ON DELETE CASCADE
        ON UPDATE CASCADE
);
CREATE TABLE Reviews(
ReviewNum INT NOT NULL,
    ProductID INT NOT NULL,
    CustomerID INT NOT NULL,
    Stars INT NOT NULL DEFAULT 1 CHECK(Stars BETWEEN 1 AND 5),
    Review TEXT NOT NULL,
    PRIMARY KEY (ReviewNum),
    FOREIGN KEY (ProductID) REFERENCES Orders(ProductID)
ON DELETE CASCADE
        ON UPDATE CASCADE,
FOREIGN KEY (CustomerID) REFERENCES Customers(CustomerID)
ON DELETE SET NULL
        ON UPDATE CASCADE
);