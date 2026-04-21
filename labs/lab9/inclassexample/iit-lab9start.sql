-- create the tables for our movies
CREATE TABLE `movies` (
   `movieid` int(10) unsigned NOT NULL AUTO_INCREMENT,
   `title` varchar(100) NOT NULL,
   `year` char(4) DEFAULT NULL,
   PRIMARY KEY (`movieid`)
);

-- insert data into the movies table
INSERT INTO movies
VALUES (1, "Elizabeth", "1998"),
   (2, "Black Widow", "2021"),
   (3, "Oh Brother Where Art Thou?", "2000"),
   (4, "The Lord of the Rings: The Fellowship of the Ring", "2001"),
   (5, "Up in the Air", "2009");

-- create the actors table
CREATE TABLE `actors` (
   `actorid` int(10) unsigned NOT NULL AUTO_INCREMENT,
   `first_names` varchar(100) NOT NULL,
   `last_name` varchar(100) NOT NULL,
   `dob` date DEFAULT NULL,
   PRIMARY KEY (`actorid`)
);

-- insert sample actors (at least 5, at least 3 born before 1960)
INSERT INTO actors (first_names, last_name, dob) VALUES
   ('Cate', 'Blanchett', '1969-05-14'),
   ('Scarlett', 'Johansson', '1984-11-22'),
   ('George', 'Clooney', '1961-05-06'),
   ('Viggo', 'Mortensen', '1958-10-20'),
   ('Frances', 'McDormand', '1957-06-23'),
   ('Jeff', 'Bridges', '1949-12-04'),
   ('Meryl', 'Streep', '1949-06-22');

-- create the movie_actors relationship table (Q5)
CREATE TABLE `movie_actors` (
   `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
   `movieid` int(10) unsigned NOT NULL,
   `actorid` int(10) unsigned NOT NULL,
   PRIMARY KEY (`id`),
   FOREIGN KEY (`movieid`) REFERENCES movies(`movieid`),
   FOREIGN KEY (`actorid`) REFERENCES actors(`actorid`)
);

-- associate some actors to movies
INSERT INTO movie_actors (movieid, actorid) VALUES
   (1, 1),  -- Cate Blanchett in Elizabeth
   (2, 2),  -- Scarlett Johansson in Black Widow
   (3, 3),  -- George Clooney in Oh Brother Where Art Thou?
   (4, 5),  -- Viggo Mortensen in Lord of the Rings
   (5, 3);  -- George Clooney in Up in the Air
