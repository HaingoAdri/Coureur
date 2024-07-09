-- Script pour le datawarehouse

-- Création des tables dans le datawarehouse
CREATE TABLE Equipe (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    login VARCHAR(255) NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT NOW()
);

CREATE TABLE Coureur (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    numero_dossard INT NOT NULL,
    genre VARCHAR(10) NOT NULL,
    date_naissance DATE NOT NULL,
    equipe INT REFERENCES Equipe(id),
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT NOW()
);

CREATE TABLE Categorie (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT NOW()
);

CREATE TABLE Course (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(50),
    date_debut DATE,
    date_fin DATE,
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT NOW()
);

CREATE TABLE Etape (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    longueur_km DECIMAL(5,2) NOT NULL,
    coureurs_par_equipe INT NOT NULL,
    rang_etape INT NOT NULL,
    id_course INT REFERENCES Course(id),
    date_depart DATE,
    heure_depart TIME,
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT NOW()
);

CREATE TABLE Participation (
    id SERIAL PRIMARY KEY,
    id_etape INT REFERENCES Etape(id),
    id_equipe INT REFERENCES Equipe(id),
    id_coureur INT REFERENCES Coureur(id),
    heure_depart TIME,
    heure_arrivee TIME,
    penalty_time INTERVAL,
    date_arrivee DATE,
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT NOW()
);

CREATE TABLE Points (
    id SERIAL PRIMARY KEY,
    classement INT,
    points INT
);

CREATE TABLE Categorie_Joueur (
    id SERIAL PRIMARY KEY,
    id_coureur INT REFERENCES Coureur(id),
    id_categorie INT REFERENCES Categorie(id)
);

CREATE TABLE Penalite (
    id_equipe INT REFERENCES Equipe(id),
    id_etape INT REFERENCES Etape(id),
    penalite INTERVAL
);

CREATE TABLE Admin (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(50),
    email VARCHAR(30),
    mot_de_passe VARCHAR(100),
    created_at TIMESTAMP DEFAULT NOW(),
    updated_at TIMESTAMP DEFAULT NOW()
);

CREATE OR REPLACE PROCEDURE inserer_equipe(
    p_nom VARCHAR(255),
    p_login VARCHAR(255),
    p_mot_de_passe VARCHAR(255)
)
LANGUAGE SQL
AS $$
    INSERT INTO Equipe (nom, login, mot_de_passe)
    VALUES (p_nom, p_login, p_mot_de_passe);
$$;

CREATE OR REPLACE PROCEDURE inserer_coureur(
    p_nom VARCHAR(255),
    p_numero_dossard INT,
    p_genre VARCHAR(10),
    p_date_naissance DATE,
    p_equipe_id INT
)
LANGUAGE SQL
AS $$
    INSERT INTO Coureur (nom, numero_dossard, genre, date_naissance, equipe, created_at, updated_at)
    VALUES (p_nom, p_numero_dossard, p_genre, p_date_naissance, p_equipe_id, NOW(), NOW());
$$;
