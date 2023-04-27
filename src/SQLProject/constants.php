<?php
const SERVER = "localhost";
const USERNAME = "root";
const PASSWORD = "";

const DATABASE = "pharmacy";

const CUSTOMERS_SCHEMA = "
    id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(16)  NOT NULL,
    last_name  VARCHAR(16)  NOT NULL,
    birth_date DATE         NOT NULL,
    address    VARCHAR(46),
    PRIMARY KEY (id)
";

const EMPLOYEES_SCHEMA = "
    id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    first_name VARCHAR(16)  NOT NULL,
    last_name  VARCHAR(16)  NOT NULL,
    PRIMARY KEY (id)
";

const DRUGS_SCHEMA = "
    id         INT UNSIGNED NOT NULL,
    name       VARCHAR(16)  NOT NULL,
    PRIMARY KEY (id)
";

const DRUG_TYPES_SCHEMA = "
    id          INT UNSIGNED NOT NULL,
    drugId      INT UNSIGNED NOT NULL,
    description TINYTEXT     NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (drugId) REFERENCES Drugs(id)
";

const PRESCRIPTIONS_SCHEMA = "
    id         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    customerId INT UNSIGNED NOT NULL,
    drugId     INT UNSIGNED NOT NULL,
    employeeId INT UNSIGNED NOT NULL,
    count      INT UNSIGNED NOT NULL,
    refills    INT UNSIGNED NOT NULL,
    fill_date  DATE         NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (customerId) REFERENCES Customers(id),
    FOREIGN KEY (drugId)     REFERENCES Drug_Types(id),
    FOREIGN KEY (employeeId) REFERENCES Employees(id)
";