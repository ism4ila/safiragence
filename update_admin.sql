-- Mise à jour de l'administrateur SAFIR
-- Email: ismailahamadou5@gmail.com
-- Password: 12345678

USE safirdb25;

UPDATE admins SET 
    email = 'ismailahamadou5@gmail.com',
    password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    first_name = 'Ismail',
    last_name = 'HAMADOU'
WHERE username = 'admin';

-- Vérification
SELECT id, username, email, first_name, last_name FROM admins WHERE username = 'admin';