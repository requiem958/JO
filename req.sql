select nBillet, nEpreuve, nomE, dateEpreuve from lesBillets natural join Lesepreuves where nDossier = 1 ;

with EpVide as (
	select nEpreuve from LesEpreuves minus select nEpreuve from LesBillets
	)
select distinct nomE from lesEpreuves natural join EpVide;


