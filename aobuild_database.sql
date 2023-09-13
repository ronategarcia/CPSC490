-- Rodrigo Onate
-- CPSC 491
-- Aobuild project javascript file
-- ==========================================
--  "aobuild_database"
-- ==========================================					
-- Drop Database Schema if it exists
DROP DATABASE IF EXISTS aobuild_database;
-- Creating DocOffice Schema
CREATE DATABASE aobuild_database;
USE aobuild_database;

-- Tables for Aobuild

-- Creating the userprofile Table:
CREATE TABLE userprofile (
  username varchar(300) NOT NULL,
  email    varchar(300) NOT NULL,
  pass     varchar(300) NOT NULL,
  image    varchar(300) DEFAULT NULL,
  PRIMARY KEY (username)
);

CREATE TABLE user_post (
  username varchar(300) NOT NULL,
  time_posted datetime NOT NULL,
  post_message text NOT NULL,
  id int(11) NOT NULL,
  post_image varchar(300) DEFAULT NULL,
  PRIMARY KEY (id)
);
