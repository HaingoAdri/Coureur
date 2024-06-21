create table module(
    id serial primary key,
    nom VARCHAR(50),
    created_at timestamp,
    udpated_at timestamp
);

create table situation_matrimonial(
    id VARCHAR(10) primary key,
    nom VARCHAR(10),
    created_at timestamp,
    udpated_at timestamp
);

create table employer(
    id VARCHAR(20) primary key,
    noms VARCHAR(50),
    date_naissance date,
    email VARCHAR(50),
    mots_passe VARCHAR(50),
    situation_matrimonial VARCHAR(10) references situation_matrimonial(id),
    contact VARCHAR(50),
    date_embauche date,
    created_at timestamp,
    udpated_at timestamp
);

create table client(
    id VARCHAR(50) primary key,
    nom VARCHAR(50),
    email VARCHAR(50),
    mots_passe VARCHAR(50),
    created_at timestamp,
    udpated_at timestamp
);