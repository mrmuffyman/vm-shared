--Movie ID should be a primary Key, 272 already in table
--ERROR 1062 (23000) at line 1: Duplicate entry '272' for key 1

INSERT INTO Movie VALUE (272, "This should violate", 1934, "PG" , "Fox");

--This violates CHECK(title <> NULL)
INSERT INTO Movie VALUE (9999, \N, 1920, "PG","Fox);

-- This violates Actor id being primary key
-- ERROR 1062 (23000) at line 11: Duplicate entry '1' for key 1

INSERT INTO Actor VALUE (1, "B", "c", "f", 192929292, \N);

-- This violates CHECK (dob <> NULL)
INSERT INTO Actor VALUE (9999, "B", "c", "f", \N, \N);

--This violates CHECK (dod > dob)
INSERT INTO Actor VALUE  (9999, "B", "c", "f", 19700118, 19290118);

--This violates Director id being primary key
--ERROR 1062 (23000) at line 21: Duplicate entry '37146' for key 1
INSERT INTO Director VALUE (37146, "Kev", "Lin", 1929394, \N);

--This violates Director.dob not being NULL
INSERT INTO Director VALUE (1, "Kev","Lin", \N,\N);

--This violates foreign key constraint that mid has to reference Movie.id
--ERROR 1452 (23000) at line 27: Cannot add or update a child row: a foreign key constraint fails (`CS143/MovieGenre`, CONSTRAINT `MovieGenre_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))
INSERT INTO MovieGenre VALUE (09090, "Action");


--This violates foreign key constraint of mid and did to Movie.id and Director.id
--ERROR 1452 (23000) at line 31: Cannot add or update a child row: a foreign key constraint fails (`CS143/MovieDirector`, CONSTRAINT `MovieDirector_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))
INSERT INTO MovieDirector VALUE (272,99999);;
INSERT INTO MovieDirector VALUE (99999, 2093);;

--This violates foreign key constraint in MovieActor of mid to Movie.id, and aid to Actor.id
--ERROR 1452 (23000) at line 37: Cannot add or update a child row: a foreign key constraint fails (`CS143/MovieActor`, CONSTRAINT `MovieActor_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))
INSERT INTO MovieActor VALUE (99999,144,"Guy");
INSERT INTO MovieActor VALUE (272,99999,"guy");

--This violates foreign key constraint in Review of mid corresponding to Movie.id
--ERROR 1452 (23000) at line 40: Cannot add or update a child row: a foreign key constraint fails (`CS143/Review`, CONSTRAINT `Review_ibfk_1` FOREIGN KEY (`mid`) REFERENCES `Movie` (`id`))

INSERT INTO Review VALUE ("Hi", 19192, 99999, 5, "good movie!");
