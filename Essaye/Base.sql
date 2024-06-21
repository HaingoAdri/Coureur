create database eval_essaye;

\c eval_essaye

create table maison_data(
    id serial primary key,
    nom varchar(50),
    descriptions varchar(50),
    surface double precision,
    duree int,
    created_at timestamp,
    updated_at timestamp
);

create table type_travaux(
    id serial primary key,
    nom varchar(10),
    unite varchar(10),
    pu double precision,
    created_at timestamp,
    updated_at timestamp
);

create table finition(
    id serial primary key,
    nom varchar(10),
    pourcentage double precision,
    created_at timestamp,
    updated_at timestamp
);

create table maison_travaux(
    id serial primary key,
    maison_data int references maison_data(id),
    type_travaux int references type_travaux(id),
    quantite double precision,
    created_at timestamp,
    updated_at timestamp
);

create table devis_client(
    id VARCHAR(10) primary key,
    numero VARCHAR(14),
    date_devis date,
    date_debut date,
    maison_data int references maison_data(id),
    lieu varchar(20),
    finition int references finition(id),
    created_at timestamp,
    updated_at timestamp
);

create table paiement(
    id VARCHAR(20) primary key,
    devis_client varchar(10) references devis_client(id),
    date_paiement date,
    montant double precision,
    created_at timestamp,
    updated_at timestamp
);

create table admin(
    id serial primary key,
    nom varchar(20),
    email varchar(30),
    mot_de_passe varchar(100),
    created_at timestamp,
    updated_at timestamp
);

create table client(
    id VARCHAR(10) primary key,
    created_at timestamp,
    updated_at timestamp
);


create view view_maison_data
AS
select maison_data.nom, maison_data.descriptions,
maison_data.surface, maison_data.duree,
type_travaux.nom as type_travaux,
type_travaux.unite,
type_travaux.pu,
maison_travaux.quantite,
(type_travaux.pu*maison_travaux.quantite) as montant
from maison_travaux
JOIN
maison_data on maison_travaux.maison_data = maison_data.id
join type_travaux on maison_travaux.type_travaux = type_travaux.id;

create view montant_par_maison
AS
select sum(montant) as montant_total, nom from view_maison_data
GROUP BY nom;
