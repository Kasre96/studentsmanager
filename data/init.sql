CREATE DATABASE studentsmanager;

use studentsmanager;

CREATE TABLE students (
	id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
	firstname VARCHAR(255) NOT NULL,
	lastname VARCHAR(255) NOT NULL,
	regno VARCHAR(255) NOT NULL,
	coursename VARCHAR(255) NULL,
	units VARCHAR(255) NULL,
	gpa VARCHAR(255) NULL
);