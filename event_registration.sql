-- SQL Schema for Event Registration Portal

-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS event_registration_db;

-- Use the event_registration_db database
USE event_registration_db;

-- Create the registrants table
CREATE TABLE IF NOT EXISTS registrants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50),
    surname VARCHAR(255) NOT NULL,
    othernames VARCHAR(255) NOT NULL,
    gender VARCHAR(10) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(20),
    age VARCHAR(20) NOT NULL,
    marital_status VARCHAR(50) NOT NULL,
    residence VARCHAR(255) NOT NULL,
    lga VARCHAR(255) NOT NULL,
    state_of_residence VARCHAR(255) NOT NULL,
    occupation VARCHAR(255),
    trained_as VARCHAR(255),
    church_assembly VARCHAR(255) NOT NULL,
    registration_tag VARCHAR(255) UNIQUE,
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
