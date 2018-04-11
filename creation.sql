--Creation vue lesdossiers

create view LesDossiers(nDossier,nUtil,dateEmission,prix) as
	select nDossier, nUtil, dateEmission, sum(prix) as prix
	from JO_INF245.LesDossiers_base natural join JO_INF245.lesBillets natural join
		JO_INF245.lesEpreuves
	group by nDossier, nUtil, dateEmission;



