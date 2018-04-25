INSERT INTO LesSportifs values (:num,:nom,:prenom,:pays,:cat,:date);
INSERT INTO LesEquipes values (:numS,:numE);
INSERT INTO LesLocataires values (:numS,:nLog,nBat);
	
	
	
	-- Affichage des logements disponibles
with X as (
	select NomBat, nlogement, count( nSportif) as occupe,capacite from lesLogements natural join leslocataires group by NomBat,nlogement,capacite having count( nSportif) != capacite
	union
	select nomBat, nlogement, 0 as occupe, capacite from (select nomBat,nlogement,capacite from lesLogements minus select nomBat,nlogement,capacite from lesLocataires natural join lesLogements)
)
select nomBat,nLogement from X natural join leslogements where occupe < capacite;
