CREATE TABLE MaxPersonID(
        id int NOT NULL
        ) ENGINE=InnoDB;

CREATE TABLE MaxMovieID(
        id int NOT NULL
        ) ENGINE=InnoDB;

CREATE TABLE Movie(
        id int NOT NULL,
        title varchar(100) NOT NULL,
        year int,
        rating varchar(10),
        company varchar(50),
        PRIMARY KEY(id),
        CHECK(id < ALL (SELECT id FROM MaxMovieID))
        ) ENGINE=InnoDB;
-- Constraints:
-- The id for a row in movie must not be null, and must be unique.
-- the id must be less than the max person id from MaxMovieID

CREATE TABLE Actor(
        id int NOT NULL,
        last varchar(20),
        first varchar(20),
        dob date,
        dod date,
        PRIMARY KEY(id),
        CHECK(id < ALL (SELECT id FROM MaxPersonID))
        ) ENGINE=InnoDB;
-- Constraints:
-- The id for a row in Actor must not be null, and must be unique.
-- the id must be less than the max person id from MaxPersonID

CREATE TABLE Director(
        id int NOT NULL,
        last varchar(20),
        first varchar(20),
        dob date,
        dod date,
        PRIMARY KEY(id),
        CHECK(id < ALL (SELECT id FROM MaxPersonID))
        ) ENGINE=InnoDB;
-- Constraints:
-- The id for a row in Director must not be null, and must be unique.
-- the id must be less than the max person id from MaxPersonID

CREATE TABLE MovieGenre(
        mid int NOT NULL,
        genre varchar(20) NOT NULL,
        FOREIGN KEY (mid) REFERENCES Movie(id)
        ) ENGINE=InnoDB;
-- Constraints:
-- The mid must refer to an id in the Movie table.

CREATE TABLE MovieDirector(
        mid int NOT NULL,
        did int NOT NULL,
        FOREIGN KEY (did) REFERENCES Director(id),
        FOREIGN KEY (mid) REFERENCES Movie(id)
        ) ENGINE=InnoDB;
-- Constraints:
-- The mid must refer to an id in the Movie table.
-- The did must refer to an id in the Director table.

CREATE TABLE MovieActor(
        mid int NOT NULL,
        aid int NOT NULL,
        role varchar(50),
        FOREIGN KEY (aid) REFERENCES Actor(id),
        FOREIGN KEY (mid) REFERENCES Movie(id)
        ) ENGINE=InnoDB;
-- Constraints:
-- The mid must refer to an id in the Movie table.
-- This aid must refer to an id in the Actor table.

CREATE TABLE Review(
        name varchar(20),
        time timestamp,
        mid int NOT NULL,
        rating int NOT NULL,
        comment varchar(500),
        FOREIGN KEY (mid) REFERENCES Movie(id)
        ) ENGINE=InnoDB;
-- Constraints:
-- The mid must refer to an id in the Movie table.
