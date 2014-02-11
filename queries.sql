SELECT concat(first, " ", last)
FROM Movie M ,Actor A, MovieActor MA
WHERE M.id = MA.mid AND A.id = MA.aid AND M.title = 'Die Another Day';

SELECT COUNT(*) FROM (SELECT COUNT(*)
FROM MovieActor MA
GROUP BY MA.aid
HAVING COUNT(*) > 1) A;

-- All Directors who created Action movies

SELECT first,last
FROM Director D, MovieGenre MG, MovieDirector MD
WHERE D.id = MD.did AND MG.mid = MD.mid AND MG.genre = 'Action'; 
