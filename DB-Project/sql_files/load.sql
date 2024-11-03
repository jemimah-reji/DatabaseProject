-- Loading data into Products table
LOAD DATA LOCAL INFILE 'Products.csv'
INTO TABLE Products
FIELDS TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(ProductID, ProductName, Description, Price, StockQuantity);

-- Loading data into Orders table
LOAD DATA LOCAL INFILE 'Orders.csv'
INTO TABLE Orders
FIELDS TERMINATED BY ',' ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 ROWS
(OrderID, CustomerID, OrderDate, TotalAmount, OrderStatus);

-- Repeat for each table with appropriate columns
