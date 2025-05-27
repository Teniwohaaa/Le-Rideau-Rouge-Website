CREATE DATABASE Rideau_Rouge;
USE Rideau_Rouge;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    usr_password VARCHAR(255) NOT NULL,
    is_admin BOOLEAN DEFAULT FALSE
);

CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    event_description TEXT,
    image_path VARCHAR(255),
    category ENUM('cinema','theatre','opera') NOT NULL,
    date_event DATETIME NOT NULL,
    venue VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL
);

CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    event_id INT NOT NULL,
    quantity INT NOT NULL,
    phone VARCHAR(15) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (event_id) REFERENCES events(id)
);

--  remplissage de la table users
INSERT INTO users (username, email, usr_password, is_admin) VALUES ('Admin','admin01@gmail.com','admin0', TRUE);
INSERT INTO users (username, email, usr_password, is_admin) VALUES ('User1','user1@gmail.com','password', FALSE);

-- remplissage de la table events

-- Insert events data (Cinema)
INSERT INTO events (title, image_path, category, date_event, venue, price, event_description) VALUES 
('Until Dawn', 'until.jpg', 'cinema', '2025-05-16 13:00:00', 'Cinéma Cosmos Beta à Alger', 1000.00, 'Movie screening at Cinéma Cosmos Beta'),
('The Amateur', 'amateur.jpg', 'cinema', '2025-05-20 20:00:00', 'Salle Ibn Zeydoun à Alger', 1000.00, 'Movie screening at Salle Ibn Zeydoun'),
('Thunderbolts', 'thunderbolts.jpg', 'cinema', '2025-05-16 20:00:00', 'Cinéma Cosmos Beta à Alger', 1000.00, 'Movie screening at Cinéma Cosmos Beta'),
('Armageddon', 'armageddon.jpg', 'cinema', '2025-05-16 20:00:00', 'Le Maghreb à Oran', 1000.00, 'Movie screening at Le Maghreb'),
('Querelles', 'querelles.jpg', 'cinema', '2025-05-20 22:00:00', 'Le Maghreb à Oran', 1000.00, 'Movie screening at Le Maghreb'),
('Le Retour des Hirondelles', 'hirondelles.jpg', 'cinema', '2025-05-20 22:00:00', 'Salle Ibn Zeydoun à Alger', 1000.00, 'Movie screening at Salle Ibn Zeydoun');


-- Insert theatre events
INSERT INTO events (title, image_path, category, date_event, venue, price, event_description) VALUES 
('شارع المنافقين', 'charii', 'theatre', '2025-05-22 19:00:00', 'Théatre National d''Alger', 2000.00, 'Theatre performance at TNA'),
('Arlouken', 'arloukan.jpg', 'theatre', '2025-05-25 20:00:00', 'théatre regional d''Oran', 2000.00, 'Theatre performance at TRO'),
('Basta', 'basta.jpg', 'theatre', '2025-05-22 19:00:00', 'Théatre National d''Alger', 2000.00, 'Theatre performance at TNA');

-- Insert opera events
INSERT INTO events (title, image_path, category, date_event, venue, price, event_description) VALUES 
('Sahrat El Madina', 'sahrat.jpg', 'opera', '2025-05-27 20:00:00', 'Opéra D''Alger', 3000.00, 'Opera performance at Opéra D''Alger'),
('Théatre nationel de dance de Russie', 'russie.jpg', 'opera', '2025-05-31 20:00:00', 'Opéra D''Alger', 3000.00, 'Russian National Theatre Dance performance'),
('14e edition du festival culturel international de musique symphonique égupte,corée de Sud et Japon', 'russie.jpg', 'opera', '2025-05-14 22:00:00', 'Opéra D''Alger', 3000.00, 'International Symphonic Music Festival - Egypt, South Korea and Japan'),
('14e edition du festival culturel international de musique symphonique Afrique de Sud,France et Danemark', 'russie.jpg', 'opera', '2025-05-16 20:00:00', 'Le Maghreb à Oran', 3000.00, 'International Symphonic Music Festival - South Africa, France and Denmark'),
('14e edition du festival culturel international de musique symphonique Italie et Autriche', 'russie.jpg', 'opera', '2025-05-23 20:00:00', 'Opéra D''Alger', 3000.00, 'International Symphonic Music Festival - Italy and Austria'),
('14e edition du festival culturel international de musique symphonique Russie,Pologne et Syria', 'russie.jpg', 'opera', '2025-05-28 22:00:00', 'Opéra D''Alger', 3000.00, 'International Symphonic Music Festival - Russia, Poland and Syria');

