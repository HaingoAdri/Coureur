create database eval_coureur;

\c eval_coureur

-- Création des tables

CREATE TABLE Equipe (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    login VARCHAR(255) NOT NULL,e
    mot_de_passe VARCHAR(255) NOT NULL,
    created_at timestamp default now(),
    updated_at timestamp default now()
);

CREATE TABLE Coureur (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    numero_dossard INT NOT NULL,
    genre VARCHAR(10) NOT NULL,
    date_naissance DATE NOT NULL,
    equipe int REFERENCES equipe(id),
    created_at timestamp default now(),
    updated_at timestamp default now()
);

CREATE TABLE Categorie (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    created_at timestamp default now(),
    updated_at timestamp default now()
);

create table course(
    id serial primary key,
    nom varchar(50),
    date_debut date,
    date_fin date,
    created_at timestamp default now(),
    updated_at timestamp default now()
);

CREATE TABLE Etape (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    longueur_km DECIMAL(5,2) NOT NULL,
    coureurs_par_equipe INT NOT NULL,
    rang_etape INT NOT NULL,
    id_course int REFERENCES course(id),
    date_depart date,
    heure_depart time,
    created_at timestamp default now(),
    updated_at timestamp default now() -- Nouveau champ pour le rang de l'étape
);

CREATE TABLE Participation (
    id SERIAL PRIMARY KEY,
    id_etape INT REFERENCES Etape(id),
    id_equipe INT REFERENCES Equipe(id),
    id_coureur INT REFERENCES Coureur(id),
    heure_depart TIME,
    heure_arrivee TIME,
    penalty_time interval,
    date_arrivee date,
    created_at timestamp default now(),
    updated_at timestamp default now()
);

create table points(
    id serial primary key,
    classement int,
    points int
);

create table categorie_joueur(
    id serial primary key,
    id_coureur int REFERENCES coureur(id),
    id_categorie int REFERENCES Categorie(id)
);

create table penalite(
    id_equipe int REFERENCES equipe(id),
    id_etape int REFERENCES etape(id),
    penalite interval
);

create table admin(
    id serial primary key,
    nom varchar(50),
    email varchar(30),
    mot_de_passe varchar(100),
    created_at timestamp default now(),
    updated_at timestamp default now()
);


create view veiw_coureur as select coureur.genre, coureur.date_naissance, coureur.numero_dossard, coureur.nom as nom_coureur,  equipe.nom as nom_equipe, coureur.equipe, coureur.id
FROM coureur
join equipe on coureur.equipe = equipe.id;

CREATE VIEW pview_participation AS
    SELECT DISTINCT
        Etape.nom AS lieu,
        Etape.longueur_km,
        Etape.coureurs_par_equipe AS nbr,
        Etape.id_course,
        Etape.rang_etape,
        view_coureur_categorie.nom AS nom_coureur,
        view_coureur_categorie.id_categorie AS categorie,
        participation.heure_arrivee,
        participation.heure_depart,
        participation.penalty_time,
        participation.id_coureur,
        participation.id_etape,
        participation.date_arrivee,
        TO_TIMESTAMP(participation.date_arrivee || ' ' || participation.heure_arrivee, 'YYYY-MM-DD HH24:MI:SS')-TO_TIMESTAMP(etape.date_depart || ' ' || participation.heure_depart, 'YYYY-MM-DD HH24:MI:SS') as chrono_tonga,
        TO_TIMESTAMP(participation.date_arrivee || ' ' || participation.heure_arrivee, 'YYYY-MM-DD HH24:MI:SS') + participation.penalty_time AS heure_final,
        TO_TIMESTAMP(Etape.date_depart || ' ' || participation.heure_depart, 'YYYY-MM-DD HH24:MI:SS') AS date_depart,
        view_coureur_categorie.nom_categorie,
        equipe.nom AS nom_equipe,
        participation.id,
        (TO_TIMESTAMP(participation.date_arrivee || ' ' || participation.heure_arrivee, 'YYYY-MM-DD HH24:MI:SS') -
         TO_TIMESTAMP(participation.date_arrivee || ' ' || participation.heure_depart, 'YYYY-MM-DD HH24:MI:SS')) +
        (participation.penalty_time) AS total
    FROM
        participation
    Left JOIN
        view_coureur_categorie ON participation.id_coureur = view_coureur_categorie.id_coureur
    Left JOIN
        equipe ON participation.id_equipe = equipe.id
    Left JOIN
        Etape ON participation.id_etape = Etape.id;


-- INSERT INTO categorie (nom) VALUES ('Homme'), ('Femme'), ('Junior');

SELECT nom_equipe, nom_coureur,heure_arrivee, heure_depart,penalty_time,((heure_arrivee - heure_depart)+penalty_time) as total from pview_participation;

-- Classement general
-- create view view_classement as
-- WITH classement AS (
--     SELECT
--         id_coureur,
--         id_etape,
--         DENSE_RANK() OVER(PARTITION BY id_etape ORDER BY heure_final asc) AS rang
--     FROM pview_participation
-- ),
-- points_assigned AS (
--     SELECT
--         c.id_coureur,
--         c.id_etape,
--         c.rang,
--          COALESCE(p.points, 0) AS points
--     FROM classement c
--     LEFT JOIN points p ON c.rang = p.classement
-- )
-- SELECT
--     pp.nom_coureur,
--     pp.nom_equipe,
--     pp.id_coureur,
--     pp.id_etape,
--     pp.rang_etape,
--     pp.lieu,
--     pp.id_course,
--     c.genre,
--     pp.longueur_km,
--     pp.chrono_tonga,
--     pp.date_depart,
--     pp.heure_depart,
--     pp.heure_arrivee,
--     pp.penalty_time,
--     pp.date_arrivee,
--     pp.heure_final,
--     p.rang,
--     p.points AS total_points
-- FROM points_assigned p
-- JOIN pview_participation pp ON p.id_coureur = pp.id_coureur
--     AND p.id_etape = pp.id_etape FULL join coureur as c on p.id_coureur = c.id
-- GROUP BY pp.nom_coureur, pp.chrono_tonga ,pp.date_depart,pp.nom_equipe, pp.rang_etape,c.genre,pp.id_coureur, pp.heure_final,p.points, pp.id_etape, pp.lieu, pp.id_course,pp.date_arrivee, pp.longueur_km, pp.heure_depart, pp.heure_arrivee, pp.penalty_time, p.rang;

CREATE VIEW view_classement AS
WITH classement AS (SELECT pview_participation.id_coureur,
                           pview_participation.id_etape,
                           dense_rank() OVER (PARTITION BY pview_participation.id_etape ORDER BY (
                               CASE
                                   WHEN EXTRACT(hour FROM pview_participation.heure_arrivee) = 0::numeric AND
                                        EXTRACT(minute FROM pview_participation.heure_arrivee) = 0::numeric AND
                                        EXTRACT(second FROM pview_participation.heure_arrivee) = 0::numeric THEN 1
                                   ELSE 0
                                   END), pview_participation.heure_final) AS rang
                    FROM pview_participation),
     points_assigned AS (SELECT c_1.id_coureur,
                                c_1.id_etape,
                                c_1.rang,
                                CASE
                                    WHEN EXTRACT(hour FROM pp_1.heure_final) = 0::numeric AND
                                         EXTRACT(minute FROM pp_1.heure_final) = 0::numeric AND
                                         EXTRACT(second FROM pp_1.heure_final) = 0::numeric THEN 0
                                    ELSE COALESCE(p_1.points, 0)
                                    END AS points
                         FROM classement c_1
                                  LEFT JOIN points p_1 ON c_1.rang = p_1.classement
                                  JOIN pview_participation pp_1
                                       ON c_1.id_coureur = pp_1.id_coureur AND c_1.id_etape = pp_1.id_etape)
SELECT pp.nom_coureur,
       pp.nom_equipe,
       pp.id_coureur,
       pp.id_etape,
       pp.rang_etape,
       pp.lieu,
       pp.id_course,
       c.genre,
       pp.longueur_km,
       pp.chrono_tonga,
       pp.date_depart,
       pp.heure_depart,
       pp.heure_arrivee,
       pp.penalty_time,
       pp.date_arrivee,
       pp.heure_final,
       p.rang,
       p.points AS total_points
FROM points_assigned p
         JOIN pview_participation pp ON p.id_coureur = pp.id_coureur AND p.id_etape = pp.id_etape
         FULL JOIN coureur c ON p.id_coureur = c.id
GROUP BY pp.nom_coureur, pp.chrono_tonga, pp.date_depart, pp.nom_equipe, pp.rang_etape, c.genre, pp.id_coureur,
         pp.heure_final, p.points, pp.id_etape, pp.lieu, pp.id_course, pp.date_arrivee, pp.longueur_km, pp.heure_depart,
         pp.heure_arrivee, pp.penalty_time, p.rang;

-- classement equipe
create view classement_equipe as
WITH classement_equipe AS (
    SELECT
        nom_equipe,
        rang_etape,
        lieu,
        SUM(total_points) AS total_points_etape -- Total des points par équipe et par étape
    FROM view_classement
    GROUP BY nom_equipe, rang_etape, lieu
)
SELECT
    rang_etape,
    nom_equipe,
    total_points_etape,
    lieu,
    DENSE_RANK() OVER(PARTITION BY rang_etape ORDER BY total_points_etape DESC) AS rang_equipe -- Classement des équipes par étape
FROM classement_equipe;

-- maka classement par categorie par equipe
SELECT
    cl.nom_coureur,
    cl.nom_equipe,
    vc.id_coureur,
    cl.id_etape,
    cl.rang_etape,
    cl.lieu,
    cl.id_course,
    cl.longueur_km,
    cl.heure_depart,
    cl.heure_arrivee,
    cl.heure_final,
    cl.penalty_time,
    vc.nom_categorie,
    cl.rang,
    cl.total_points
FROM
    view_coureur_categorie vc
JOIN
    view_classement cl ON vc.id_coureur = cl.id_coureur
ORDER BY
    vc.nom_categorie, cl.rang_etape, cl.rang;


select veiw_coureur.* , participation.* from veiw_coureur JOIN participation on
veiw_coureur.id = participation.id_coureur;

-- classement par categorie  pour chaque etape
create view view_classement_categorie_etape as
WITH classement_par_categorie AS (
    SELECT
        cl.nom_coureur,
        cl.nom_equipe,
        vc.id_coureur,
        cl.id_etape,
        cl.rang_etape,
        cl.lieu,
        cl.id_course,
        cl.longueur_km,
        cl.heure_depart,
        cl.date_arrivee,
        cl.heure_arrivee,
        cl.penalty_time,
        cl.heure_final,
        vc.nom_categorie,
        cl.rang,
        cl.total_points,
        DENSE_RANK() OVER (PARTITION BY cl.id_etape, vc.nom_categorie ORDER BY cl.heure_final asc) AS rang_coureur
    FROM
        view_coureur_categorie vc
    left JOIN
        view_classement cl ON vc.id_coureur = cl.id_coureur
)
SELECT
    nom_coureur,
    nom_equipe,
    id_coureur,
    id_etape,
    rang_etape,
    lieu,
    id_course,
    longueur_km,
    heure_depart,
    heure_arrivee,
    penalty_time,
    nom_categorie,
    heure_final,
    rang_coureur,
    date_arrivee,
    total_points,
    COALESCE((select points from points where classement = rang_coureur), 0) as points_cate
FROM
    classement_par_categorie
ORDER BY
    nom_categorie, rang_etape, rang_coureur;

-- calssement général par equipe
create view view_equipe_classement as
WITH class AS (
    SELECT nom_equipe, SUM(total_points) AS totals,
           DENSE_RANK() OVER(ORDER BY SUM(total_points) desc) AS rang
    FROM view_classement
    GROUP BY nom_equipe
)
SELECT nom_equipe, totals, rang
FROM class;



-- classement général par catégorie
create view view_categorie_classement as
WITH class AS (
    SELECT nom_equipe, nom_categorie, SUM(points_cate) AS points_equipe,
           DENSE_RANK() OVER(PARTITION BY nom_categorie ORDER BY SUM(points_cate) DESC) AS rang
    FROM view_classement_categorie_etape
    GROUP BY nom_equipe, nom_categorie
)
SELECT nom_equipe, nom_categorie, points_equipe, rang
FROM class;


-- montrer penalités par equipe
select nom_equipe, penalty_time from pview_participation where penalty_time!='00:00:00' group by nom_equipe, penalty_time;

create view view_getChrono as
select veiw_coureur.genre, veiw_coureur.date_naissance, veiw_coureur.numero_dossard,veiw_coureur.nom_coureur ,veiw_coureur.nom_equipe , participation.*, TO_TIMESTAMP(participation.date_arrivee || ' ' || participation.heure_arrivee, 'YYYY-MM-DD HH24:MI:SS') +
        (participation.penalty_time) AS heure_final,
        TO_TIMESTAMP(Etape.date_depart || ' ' || participation.heure_depart, 'YYYY-MM-DD HH24:MI:SS') AS date_depart,

        etape.nom as lieu, etape.longueur_km, etape.coureurs_par_equipe as nbr, etape.rang_etape from veiw_coureur
Left join participation on veiw_coureur.id = participation.id_coureur
left join etape on participation.id_etape = etape.id;

create view vie_penalite AS
select equipe.nom as nom_equipe, etape.nom as nom, penalite.id_etape, penalite.id_equipe, etape.rang_etape, penalite.penalite, penalite.id from penalite
join equipe on penalite.id_equipe = equipe.id
join etape on penalite.id_etape = etape.id;
