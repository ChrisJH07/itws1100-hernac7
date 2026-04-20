-- create the tables for our movies
CREATE TABLE `movies` (
   `movieid` int(10) unsigned NOT NULL AUTO_INCREMENT,
   `title` varchar(100) NOT NULL,
   `year` char(4) DEFAULT NULL,
   PRIMARY KEY (`movieid`)
);
-- insert data into the tables
INSERT INTO movies
VALUES (1, "Elizabeth", "1998"),
   (2, "Black Widow", "2021"),
   (3, "Oh Brother Where Art Thou?", "2000"),
   (
      4,
      "The Lord of the Rings: The Fellowship of the Ring",
      "2001"
   ),
   (5, "Up in the Air", "2009");

-- create table for actors
CREATE TABLE `actors` (
   `actorid` int(10) unsigned NOT NULL AUTO_INCREMENT,
   `first_name` varchar(100) NOT NULL,
   `last_name` varchar(100) NOT NULL,
   `dob` date DEFAULT NULL,
   PRIMARY KEY (`actorid`)
);

-- insert actors into table
INSERT INTO `actors` (`actorid`, `first_name`, `last_name`, `dob`) VALUES 
   ('1', 'Tom', 'Hanks', '1970-01-23'),
   ('2', 'Leonardo', 'DiCaprio', '1950-02-28'), 
   ('3', 'Brad', 'Pitt', '1968-03-29'), 
   ('4', 'Jim', 'Carrey', '1945-03-21'), 
   ('5', 'Johnny', 'Depp', '1943-06-21');

-- relationship table
CREATE TABLE `movie_actors` (
   movie_id INT,
   actor_id INT,
   PRIMARY KEY (movie_id, actor_id)
);

-- insert relationships
INSERT INTO movie_actors (movie_id, actor_id) VALUES
(5, 1), 
(3, 3),
(2, 5), 
(4, 2), 
(1, 4);

-- list all movies
SELECT * FROM movies;

-- Movies + Actors joined
SELECT 
   m.title, 
   m.year, 
   a.first_name, 
   a.last_name
FROM movies m
JOIN movie_actors ma ON m.movieid = ma.movie_id
JOIN actors a ON a.actorid = ma.actor_id;