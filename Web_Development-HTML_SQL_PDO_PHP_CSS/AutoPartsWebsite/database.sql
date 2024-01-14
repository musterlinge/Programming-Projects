-- Create the database
CREATE DATABASE AutoPartsStore;

-- Use the database
USE AutoPartsStore;

-- Create table for users
CREATE TABLE Users (
    UserID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(255) NOT NULL,
    Email VARCHAR(255) NOT NULL UNIQUE,
    HashedPassword VARCHAR(255) NOT NULL,
    Address VARCHAR(255),
    PhoneNumber VARCHAR(15),
    MailingAddress VARCHAR(255),
    CreditCardNumber VARCHAR(16),
    CreditCardExpirationDate DATE
);

-- Create table for products
CREATE TABLE Products (
    PartNumber INT PRIMARY KEY,
    Name VARCHAR(255),
    Description VARCHAR(255),
    Weight DECIMAL(10,2),
    PictureLink VARCHAR(255),
    Price DECIMAL(10,2)
);

-- Create table for quantity on hand
CREATE TABLE QuantityOnHand (
    PartNumber INT,
    Quantity INT,
    PRIMARY KEY (PartNumber),
    FOREIGN KEY (PartNumber) REFERENCES Products(PartNumber)
);

-- Create table for orders
CREATE TABLE Orders (
    OrderID INT AUTO_INCREMENT PRIMARY KEY,
    CustomerID INT,
    TotalWeight DECIMAL(10,2),
    TotalPrice DECIMAL(10,2),
    ShippingCharge DECIMAL(10,2),
    Date DATE,
    Status VARCHAR(50),
    FOREIGN KEY (CustomerID) REFERENCES Users(UserID)
);

-- Create table for order details
CREATE TABLE OrderDetails (
    OrderID INT,
    PartNumber INT,
    Quantity INT,
    Price DECIMAL(10,2),
    PRIMARY KEY (OrderID, PartNumber),
    FOREIGN KEY (OrderID) REFERENCES Orders(OrderID),
    FOREIGN KEY (PartNumber) REFERENCES Products(PartNumber)
);

-- Create table for inventory
CREATE TABLE Inventory (
    ProductID INT PRIMARY KEY,
    Name VARCHAR(255),
    Description VARCHAR(255),
    PartNumber INT,
    QuantityOnHand INT,
    FOREIGN KEY (PartNumber) REFERENCES Products(PartNumber)
);

-- Create table for shipping and handling charges
CREATE TABLE ShippingHandlingCharges (
    WeightBracket INT PRIMARY KEY,
    Charge DECIMAL(10,2)
);

-- Insert products into the Products table
INSERT INTO Products (PartNumber, Name, Description, Weight, PictureLink, Price)
VALUES (1001, 'Brake Pad Set', 'High-quality brake pads', 2.5, 'brake.jpeg', 49.99);

INSERT INTO Products (PartNumber, Name, Description, Weight, PictureLink, Price)
VALUES (1002, 'Oil Filter', 'Premium oil filter for engine protection', 0.5, 'oilfilter.jpg', 9.99);

INSERT INTO Products (PartNumber, Name, Description, Weight, PictureLink, Price)
VALUES (1003, 'Spark Plug Set', 'Spark plugs for efficient combustion', 1, 'sparkplugs.jpg', 19.99);

INSERT INTO Products (PartNumber, Name, Description, Weight, PictureLink, Price)
VALUES (1004, 'Air Filter', 'High-flow air filter for improved performance', 0.8, 'airfilter.jpg', 14.99);

INSERT INTO Products (PartNumber, Name, Description, Weight, PictureLink, Price)
VALUES (1005, 'Headlight Bulb (Pair)', 'Bright and durable headlights', 0.2, 'bulb.jpeg', 24.99);

INSERT INTO Products (PartNumber, Name, Description, Weight, PictureLink, Price)
VALUES (1006, 'Wiper Blade Set', 'Quality wiper blades for clear visibility', 0.7, 'wipers.jpeg', 17.99);

INSERT INTO Products (PartNumber, Name, Description, Weight, PictureLink, Price)
VALUES (1007, 'Battery', 'Powerful car battery for reliable starts', 10, 'battery.jpg', 79.99);

INSERT INTO Products (PartNumber, Name, Description, Weight, PictureLink, Price)
VALUES (1008, 'Alternator', 'High-output alternator for charging system', 8, 'alternator.jpg', 129.99);

INSERT INTO Products (PartNumber, Name, Description, Weight, PictureLink, Price)
VALUES (1009, 'Radiator', 'Efficient radiator for engine cooling', 12, 'radiator.jpg', 89.99);

INSERT INTO Products (PartNumber, Name, Description, Weight, PictureLink, Price)
VALUES (1010, 'Brake Rotor Set', 'Durable brake rotors for smooth braking', 15, 'brakekit.jpg', 59.99);


-- Insert quantities on hand into the QuantityOnHand table
INSERT INTO QuantityOnHand (PartNumber, Quantity)
VALUES (1001, 50);

INSERT INTO QuantityOnHand (PartNumber, Quantity)
VALUES (1002, 100);

INSERT INTO QuantityOnHand (PartNumber, Quantity)
VALUES (1003, 75);

INSERT INTO QuantityOnHand (PartNumber, Quantity)
VALUES (1004, 60);

INSERT INTO QuantityOnHand (PartNumber, Quantity)
VALUES (1005, 40);

INSERT INTO QuantityOnHand (PartNumber, Quantity)
VALUES (1006, 80);

INSERT INTO QuantityOnHand (PartNumber, Quantity)
VALUES (1007, 30);

INSERT INTO QuantityOnHand (PartNumber, Quantity)
VALUES (1008, 25);

INSERT INTO QuantityOnHand (PartNumber, Quantity)
VALUES (1009, 35);

INSERT INTO QuantityOnHand (PartNumber, Quantity)
VALUES (1010, 20);

-- Insert inventory into the Inventory table
INSERT INTO Inventory (ProductID, Name, Description, PartNumber, QuantityOnHand)
VALUES (1, 'Brake Pad Set', 'High-quality brake pads', 1001, 50);

INSERT INTO Inventory (ProductID, Name, Description, PartNumber, QuantityOnHand)
VALUES (2, 'Oil Filter', 'Premium oil filter for engine protection', 1002, 100);

INSERT INTO Inventory (ProductID, Name, Description, PartNumber, QuantityOnHand)
VALUES (3, 'Spark Plug Set', 'Spark plugs for efficient combustion', 1003, 75);

INSERT INTO Inventory (ProductID, Name, Description, PartNumber, QuantityOnHand)
VALUES (4, 'Air Filter', 'High-flow air filter for improved performance', 1004, 60);

INSERT INTO Inventory (ProductID, Name, Description, PartNumber, QuantityOnHand)
VALUES (5, 'Headlight Bulb (Pair)', 'Bright and durable headlights', 1005, 40);

INSERT INTO Inventory (ProductID, Name, Description, PartNumber, QuantityOnHand)
VALUES (6, 'Wiper Blade Set', 'Quality wiper blades for clear visibility', 1006, 80);

INSERT INTO Inventory (ProductID, Name, Description, PartNumber, QuantityOnHand)
VALUES (7, 'Battery', 'Powerful car battery for reliable starts', 1007, 30);

INSERT INTO Inventory (ProductID, Name, Description, PartNumber, QuantityOnHand)
VALUES (8, 'Alternator', 'High-output alternator for charging system', 1008, 25);

INSERT INTO Inventory (ProductID, Name, Description, PartNumber, QuantityOnHand)
VALUES (9, 'Radiator', 'Efficient radiator for engine cooling', 1009, 35);

INSERT INTO Inventory (ProductID, Name, Description, PartNumber, QuantityOnHand)
VALUES (10, 'Brake Rotor Set', 'Durable brake rotors for smooth braking', 1010, 20);


-- Insert shipping and handling charges into the ShippingHandlingCharges table
INSERT INTO ShippingHandlingCharges (WeightBracket, Charge)
VALUES (1, 5.00);

INSERT INTO ShippingHandlingCharges (WeightBracket, Charge)
VALUES (2, 8.00);

INSERT INTO ShippingHandlingCharges (WeightBracket, Charge)
VALUES (3, 10.00);

INSERT INTO ShippingHandlingCharges (WeightBracket, Charge)
VALUES (4, 12.50);

INSERT INTO ShippingHandlingCharges (WeightBracket, Charge)
VALUES (5, 15.00);

