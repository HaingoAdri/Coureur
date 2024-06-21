INSERT INTO Equipe (nom, login, mot_de_passe)
VALUES
('Team A', 'team_a_login', 'password_a'),
('Team B', 'team_b_login', 'password_b'),
('Team C', 'team_c_login', 'password_c');

-- Insert sample data into Coureur
INSERT INTO Coureur (nom, numero_dossard, genre, date_naissance, equipe)
VALUES
('Rakoto Andrianina', 101, 'M', '1985-06-15', 1),
('Rasoamanana Tahina', 102, 'F', '1990-08-25', 2),
('Randrianarisoa Fidy', 103, 'M', '1987-11-05', 3),
('Raharison Tiana', 104, 'F', '1992-03-14', 1),
('Ravelomanana Hery', 105, 'M', '1989-07-30', 2),
('Rafalimanana Vola', 106, 'F', '1991-11-22', 3),
('Rabenandrasana Aina', 107, 'M', '1988-12-10', 1),
('Rambeloson Fara', 108, 'F', '1993-01-05', 2),
('Rasendra Zo', 109, 'M', '1986-02-17', 3),
('Rakotomalala Miora', 110, 'F', '1994-04-08', 1);

-- Insert sample data into Categorie
INSERT INTO Categorie (nom)
VALUES
('Elite'),
('Junior'),
('Senior');

-- Insert sample data into Course
INSERT INTO Course (nom, date_debut, date_fin)
VALUES
('Loko race', '2023-07-01', '2023-07-23'),
('Ultimate', '2023-05-06', '2023-05-28');

-- Insert sample data into Etape
INSERT INTO Etape (nom, longueur_km, coureurs_par_equipe, rang_etape, id_course)
VALUES
('Stage 1', 120.5, 8, 1, 1),
('Stage 2', 150.3, 8, 2, 1),
('Stage 1', 150.3, 8, 1, 2),
('Stage 2', 150.3, 8, 2, 2),
('Stage 3', 200.2, 8, 3, 2);
