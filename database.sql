-- Base de données pour le sondage digital
-- Table pour stocker les réponses
CREATE TABLE IF NOT EXISTS responses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    problem TEXT NOT NULL,
    domain VARCHAR(100) NOT NULL,
    frustration INT NOT NULL CHECK (frustration >= 1 AND frustration <= 5),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_domain (domain),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Données de test (optionnel)
INSERT INTO responses (problem, domain, frustration) VALUES
('Difficulté à accéder aux services de santé en ligne', 'Santé', 5),
('Les plateformes éducatives sont trop complexes', 'Éducation', 4),
('Problème de sécurité avec les paiements mobiles', 'Finance', 5);
