-- Country State City SQL Script

-- Create country table
CREATE TABLE country (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL
);

-- Create state table
CREATE TABLE state (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  country_id INT NOT NULL,
  FOREIGN KEY (country_id) REFERENCES country(id)
);

-- Create city table
CREATE TABLE city (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(255) NOT NULL,
  state_id INT NOT NULL,
  FOREIGN KEY (state_id) REFERENCES state(id)
);

-- Insert data into country table
INSERT INTO country (name) VALUES
  ('USA'),
  ('Canada'),
  ('Mexico');

-- Insert data into state table
INSERT INTO state (name, country_id) VALUES
  ('California', 1),
  ('New York', 1),
  ('Texas', 1),
  ('Ontario', 2),
  ('Quebec', 2),
  ('Chiapas', 3);

-- Insert data into city table
INSERT INTO city (name, state_id) VALUES
  ('Los Angeles', 1),
  ('New York City', 2),
  ('Houston', 3),
  ('Toronto', 4),
  ('Montreal', 5),
  ('Tuxtla Gutierrez', 6);

-- Add indexes and constraints
ALTER TABLE country ADD INDEX (name);
ALTER TABLE state ADD INDEX (name, country_id);
ALTER TABLE city ADD INDEX (name, state_id);