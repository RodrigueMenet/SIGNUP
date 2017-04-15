-- -- @author : RODRIGUE MENET
/*
-- TO EXECUTE IF ALREADY EXECUTED
drop table transac;
drop table customer;
drop table product;
drop table ref_type;
*/
-- --------------------------------------------------------------
-- -- STRUCTURES
-- --------------------------------------------------------------
CREATE TABLE ref_type (
	id smallint PRIMARY KEY,
	description varchar(255) NOT NULL
);

CREATE TABLE product (
	id bigint PRIMARY KEY,
	name varchar(26) NOT NULL,
	type_id smallint NOT NULL,
	FOREIGN KEY (type_id) REFERENCES ref_type(id)
);
CREATE INDEX ix_name ON product(name);

CREATE TABLE customer (
	id bigint PRIMARY KEY,
	firstname varchar(26) NOT NULL,
	lastname varchar(26),
	email varchar(50) NOT NULL
);

CREATE TABLE transac (
	id bigint PRIMARY KEY,
	product_id bigint NOT NULL,
	customer_id bigint NOT NULL,
	sold_date datetime NOT NULL,
	send_date datetime,
	fact_date datetime,
	FOREIGN KEY (product_id) REFERENCES product(id),
	FOREIGN KEY (customer_id) REFERENCES customer(id)
);
CREATE INDEX ix_solddate ON transac(sold_date);

-- --------------------------------------------------------------
-- -- DATA
-- --------------------------------------------------------------
-- populate ref_type
INSERT INTO ref_type VALUES (0, 'crosses');
INSERT INTO ref_type VALUES (1, 'squares');
INSERT INTO ref_type VALUES (2, 'triangles');
INSERT INTO ref_type VALUES (3, 'circles');

-- populate product
INSERT INTO product VALUES (0, 'blue cross', 0);
INSERT INTO product VALUES (1, 'pink square', 1);
INSERT INTO product VALUES (2, 'pink cross', 0);
INSERT INTO product VALUES (3, 'green triangle', 3);
INSERT INTO product VALUES (4, 'red circle', 2);

-- populate customer
INSERT INTO customer VALUES (0, 'unknown', 'custom', 'u.c@gmail.com');
INSERT INTO customer VALUES (1, 'custom', 'unknown', 'c.u@gmail.com');
INSERT INTO customer VALUES (2, 'scarlett', 'johansson', 's.j@gmail.com');
INSERT INTO customer VALUES (3, 'nathalie', 'portman', 'n.p@gmail.com');
INSERT INTO customer VALUES (4, 'marie', 'curie', 'm.c@gmail.com');

-- generated with populate.php
INSERT INTO transac (id, product_id, customer_id, sold_date) VALUES (0, 0, 0, DATE_ADD(curdate(), INTERVAL -05 DAY));
INSERT INTO transac (id, product_id, customer_id, sold_date) VALUES (1, 1, 0, DATE_ADD(curdate(), INTERVAL -06 DAY));
INSERT INTO transac (id, product_id, customer_id, sold_date) VALUES (2, 2, 0, DATE_ADD(curdate(), INTERVAL -02 DAY));
INSERT INTO transac (id, product_id, customer_id, sold_date) VALUES (3, 3, 0, DATE_ADD(curdate(), INTERVAL -05 DAY));
INSERT INTO transac (id, product_id, customer_id, sold_date) VALUES (4, 0, 1, DATE_ADD(curdate(), INTERVAL -05 DAY));
INSERT INTO transac (id, product_id, customer_id, sold_date) VALUES (5, 1, 1, DATE_ADD(curdate(), INTERVAL -06 DAY));
INSERT INTO transac (id, product_id, customer_id, sold_date) VALUES (6, 2, 1, DATE_ADD(curdate(), INTERVAL -01 DAY));
INSERT INTO transac (id, product_id, customer_id, sold_date) VALUES (7, 3, 1, DATE_ADD(curdate(), INTERVAL -04 DAY));
INSERT INTO transac (id, product_id, customer_id, sold_date) VALUES (8, 0, 2, DATE_ADD(curdate(), INTERVAL -08 DAY));
INSERT INTO transac (id, product_id, customer_id, sold_date) VALUES (9, 1, 2, DATE_ADD(curdate(), INTERVAL -08 DAY));
INSERT INTO transac (id, product_id, customer_id, sold_date) VALUES (10, 2, 2, DATE_ADD(curdate(), INTERVAL -02 DAY));
INSERT INTO transac (id, product_id, customer_id, sold_date) VALUES (11, 3, 2, DATE_ADD(curdate(), INTERVAL -03 DAY));
INSERT INTO transac (id, product_id, customer_id, sold_date) VALUES (12, 0, 3, DATE_ADD(curdate(), INTERVAL -05 DAY));
INSERT INTO transac (id, product_id, customer_id, sold_date) VALUES (13, 1, 3, DATE_ADD(curdate(), INTERVAL -05 DAY));
INSERT INTO transac (id, product_id, customer_id, sold_date) VALUES (14, 2, 3, DATE_ADD(curdate(), INTERVAL -02 DAY));
INSERT INTO transac (id, product_id, customer_id, sold_date) VALUES (15, 3, 3, DATE_ADD(curdate(), INTERVAL -01 DAY));
INSERT INTO transac (id, product_id, customer_id, sold_date) VALUES (16, 0, 4, DATE_ADD(curdate(), INTERVAL -01 DAY));
INSERT INTO transac (id, product_id, customer_id, sold_date) VALUES (17, 1, 4, DATE_ADD(curdate(), INTERVAL -04 DAY));
INSERT INTO transac (id, product_id, customer_id, sold_date) VALUES (18, 2, 4, DATE_ADD(curdate(), INTERVAL -07 DAY));
INSERT INTO transac (id, product_id, customer_id, sold_date) VALUES (19, 3, 4, DATE_ADD(curdate(), INTERVAL -04 DAY));

-- --------------------------------------------------------------
-- -- QUERIES
-- --------------------------------------------------------------
-- QUERY 1
SELECT c.firstname, c.email
FROM transac t
INNER JOIN customer c ON c.id = t.customer_id
INNER JOIN product p ON p.id = t.product_id
WHERE 1=1
AND p.name = 'blue cross' -- Index was created on the name for this kind of query

;
-- QUERY 2
SELECT p.name, count(*)
FROM transac t
INNER JOIN customer c ON c.id = t.customer_id
INNER JOIN product p ON p.id = t.product_id
WHERE 1=1
AND DATE_ADD(curdate(), INTERVAL -5 DAY) < t.sold_date
GROUP BY p.name;