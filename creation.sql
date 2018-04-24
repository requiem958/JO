--Creation vue lesdossiers

drop view LesDossiers;
drop table LesLocataires;
drop table LesBillets;
drop table LesInscriptions;
drop table LesLogements;
drop table LesResultats;
drop table LesEpreuves;
drop table LesDossiers_base;

drop table LesSportifs;
drop table LesEquipes;
drop table LesDisciplines;
drop table LesBatiments;

create view LesDossiers(nDossier,nUtil,dateEmission,prix) as
	select nDossier, nUtil, dateEmission, sum(prix) as prix
	from JO_INF245.LesDossiers_base natural join JO_INF245.lesBillets natural join
		JO_INF245.lesEpreuves
	group by nDossier, nUtil, dateEmission;

--Creation de tables

create table LesSportifs(
	nSportif integer check( nSportif > 0) primary key,
	nomS varchar(100), prenomS varchar(100), pays varchar(100),
	categorieS varchar(100) check (categorieS in ('feminin','masculin') ),
	dateNais date,
	constraint pk_identite unique (nomS,prenomS)
	);

insert into LesSportifs (select * from JO_INF245.LesSportifs);


create table LesEquipes(
	nSportif integer check( nSportif > 0),
	nEquipe integer check( nEquipe > 0),
	constraint pk_nspeq primary key (nSportif, nEquipe)
	);

insert into LesEquipes (select * from JO_INF245.LesEquipes);

create table LesDisciplines(
	);

insert into LesDisciplines (select * from JO_INF245.LesDisciplines);


create table LesEpreuves(
	nEpreuve integer check (nEpreuve > 0) primary key,
	nomE varchar(100),
	forme varchar(100) check (forme in ('par equipe','individuelle','par couple') ),
	discipline varchar(100) references LesDisciplines(discipline),
	categorieE varchar(100) check (categorieE in ('feminin','masculin','mixte') ),
	nbs integer,
	dateEpreuve date,
	prix real);
insert into LesEpreuves (select * from JO_INF245.LesEpreuves);

create table LesInscriptions(
	nInscrit integer check (nInscrit > 0),
	nEpreuve integer ,
	constraint pk_inscript primary key (nInscrit, nEpreuve),
	constraint ref_nep foreign key (nEpreuve) references LesEpreuves(nEpreuve)
	);
insert into LesInscriptions (select * from JO_INF245.LesInscriptions);

create table LesResultats(
	nEpreuve integer primary key references LesEpreuves(nEpreuve),
	gold integer,
	silver integer,
	bronze integer
	);

insert into LesResultats (select * from JO_INF245.LesResultats);

create table LesBatiments(
	nomBat varchar(100) primary key,
	num integer check(num > 0),
	rue varchar(100),
	ville varchar(100)
	);

insert into LesBatiments (select * from JO_INF245.LesBatiments);

create table LesLogements(
	nLogement integer check(nLogement > 0),
	capacite integer check(capacite > 0),
	nomBat varchar(100) references LesBatiments(nomBat),
	constraint pk_log primary key (nLogement,nomBat)
	);

insert into LesLogements (select * from JO_INF245.LesLogements);

create table LesLocataires(
	nSportif integer primary key references LesSportifs(nSportif),
	nLogement integer ,
	nomBat varchar(100),
	foreign key (nlogement, nombat) references leslogements(nlogement, nombat)
	);
insert into LesLocataires (select * from JO_INF245.LesLocataires);

create table LesDossiers_base(
	nDossier integer primary key check(nDossier > 0),
	nUtil integer check (nUtil > 0),
	dateEmission date
	);
insert into LesDossiers_base (select * from JO_INF245.LesDossiers_base);

create table LesBillets(
	nBillet integer check(nBillet > 0),
	nDossier integer check(nDossier > 0),
	nEpreuve integer references LesEpreuves(nEpreuve),
	constraint pk_lesbillets primary key (nBillet,nDossier),
	constraint ref_Dossierlesbillets foreign key (nDossier) references LesDossiers_base(nDossier),
	constraint ref_Epreuvelesbillets foreign key (nEpreuve) references LesEpreuves(nEpreuve)
	);
insert into LesBillets (select * from JO_INF245.LesBillets);

commit;
