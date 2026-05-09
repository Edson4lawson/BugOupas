-- Base de données PostgreSQL pour le sondage digital
-- Ce script crée la table responses compatible PostgreSQL

-- Création de la table responses (PostgreSQL n'utilise pas AUTO_INCREMENT mais SERIAL)
CREATE TABLE IF NOT EXISTS responses (
    id SERIAL PRIMARY KEY,
    problem TEXT NOT NULL,
    domain VARCHAR(100) NOT NULL,
    frustration INTEGER NOT NULL CHECK (frustration >= 1 AND frustration <= 5),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Création des index pour optimiser les requêtes
CREATE INDEX IF NOT EXISTS idx_domain ON responses (domain);
CREATE INDEX IF NOT EXISTS idx_created_at ON responses (created_at);

-- Données de test (optionnel)
INSERT INTO responses (problem, domain, frustration) VALUES
('Difficulté à accéder aux services de santé en ligne', 'Santé', 5),
('Les plateformes éducatives sont trop complexes', 'Éducation', 4),
('Problème de sécurité avec les paiements mobiles', 'Finance', 5)
ON CONFLICT DO NOTHING;
