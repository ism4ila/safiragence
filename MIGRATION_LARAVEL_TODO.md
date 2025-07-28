# TODO - Migration SAFIR vers Laravel

## ✅ PHASE 1: CONFIGURATION ET STRUCTURE DE BASE

### Configuration Initiale
- [ ] Créer nouveau projet Laravel 11 (`composer create-project laravel/laravel safir-laravel`)
- [ ] Configurer `.env` (DB_CONNECTION, DB_HOST, DB_DATABASE, etc.)
- [ ] Tester connexion à la base de données existante
- [ ] Configurer Vite pour les assets CSS/JS
- [ ] Installer packages nécessaires (Laravel Breeze/Fortify pour auth)

### Structure des Dossiers
- [ ] Créer structure des vues (`resources/views/admin/`, `resources/views/public/`)
- [ ] Organiser les assets (`public/assets/`, migration des CSS/JS existants)
- [ ] Configurer les routes (`routes/web.php`, `routes/admin.php`)

---

## ✅ PHASE 2: MODÈLES ET MIGRATIONS

### Migrations Base de Données
- [ ] Migration `admins` (id, username, email, password, role, etc.)
- [ ] Migration `services` (id, slug, title, description, price, etc.)
- [ ] Migration `cities` (id, name, region, country)
- [ ] Migration `encadreurs` (id, full_name, phone_1, phone_2, city_id, etc.)
- [ ] Migration `reservations` (id, reference, service_id, client_name, etc.)
- [ ] Migration `contact_messages` (id, name, email, subject, message, etc.)
- [ ] Migration `gallery_albums` et `gallery_images`
- [ ] Migration `testimonials` (id, client_name, content, rating, etc.)
- [ ] Migration `documents` (id, title, filename, file_path, etc.)
- [ ] Migration `site_settings` (id, setting_key, setting_value, etc.)
- [ ] Migration `activity_logs` (id, admin_id, action, table_name, etc.)
- [ ] Migration `visits` (id, ip_address, page_url, visit_date, etc.)

### Modèles Eloquent
- [ ] Modèle `Admin` avec authentification
- [ ] Modèle `Service` avec relations
- [ ] Modèle `City` avec relation vers encadreurs
- [ ] Modèle `Encadreur` avec relations city
- [ ] Modèle `Reservation` avec relations service
- [ ] Modèle `ContactMessage`
- [ ] Modèles `GalleryAlbum` et `GalleryImage`
- [ ] Modèle `Testimonial`
- [ ] Modèle `Document`
- [ ] Modèle `SiteSetting`
- [ ] Modèle `ActivityLog`
- [ ] Modèle `Visit`

### Seeders et Factory
- [ ] Seeder pour importer données `cities` existantes
- [ ] Seeder pour importer données `encadreurs` existantes
- [ ] Seeder pour importer données `services` existantes
- [ ] Seeder pour créer admin par défaut
- [ ] Seeder pour `site_settings` par défaut

---

## ✅ PHASE 3: INTERFACE D'ADMINISTRATION

### Authentification Admin
- [ ] Configuration Laravel Breeze/Fortify
- [ ] Middleware pour accès admin
- [ ] Guards séparés pour admin
- [ ] Page de login admin (`/admin/login`)
- [ ] Logout et gestion sessions

### Dashboard Admin
- [ ] Layout admin avec sidebar (AdminLTE ou équivalent)
- [ ] Dashboard principal avec statistiques
- [ ] Graphiques avec Chart.js (réservations, statuts, etc.)
- [ ] Widgets de statistiques (encadreurs, réservations, messages)

### CRUD Encadreurs
- [ ] Liste des encadreurs avec filtres par ville
- [ ] Formulaire création encadreur
- [ ] Formulaire édition encadreur
- [ ] Upload photo encadreur
- [ ] Soft delete encadreurs
- [ ] Export PDF/Excel liste encadreurs

### CRUD Services
- [ ] Liste des services avec statuts
- [ ] Formulaire création service
- [ ] Formulaire édition service
- [ ] Upload images services
- [ ] Gestion galerie par service
- [ ] Ordre d'affichage services

### Gestion Réservations
- [ ] Liste réservations avec filtres
- [ ] Vue détail réservation
- [ ] Changement statut réservation
- [ ] Assignation réservation à admin
- [ ] Génération PDF devis/facture
- [ ] Notifications nouvelles réservations

### Gestion Messages Contact
- [ ] Liste messages avec statuts
- [ ] Vue détail message
- [ ] Réponse à un message
- [ ] Marquage lu/non-lu
- [ ] Archive messages

### Galerie
- [ ] Gestion albums photo
- [ ] Upload multiple images
- [ ] Redimensionnement automatique
- [ ] Ordre des images par drag&drop
- [ ] Suppression images

---

## ✅ PHASE 4: FRONTEND PUBLIC (PAGES STATIQUES)

### Layout Principal
- [ ] Layout Blade principal avec navigation
- [ ] Header responsive avec logo
- [ ] Footer avec liens sociaux
- [ ] Navigation mobile (hamburger menu)
- [ ] Integration Bootstrap/Tailwind

### Pages Statiques
- [ ] Page d'accueil (`/`) avec services en vedette
- [ ] Page À propos (`/about`)
- [ ] Page Contact (`/contact`) avec formulaire
- [ ] Pages services individuelles (`/service/{slug}`)
- [ ] Page galerie (`/galerie`)
- [ ] Page encadreurs (`/encadreurs`)

### Système Réservation/Devis
- [ ] Formulaire réservation avec validation
- [ ] Envoi email confirmation client
- [ ] Notification admin nouvelle réservation
- [ ] Génération référence unique
- [ ] Page confirmation réservation

### Fonctionnalités Frontend
- [ ] Formulaire contact avec captcha
- [ ] Système de recherche services
- [ ] Filtrage encadreurs par ville
- [ ] Lightbox pour galerie
- [ ] Boutons partage réseaux sociaux

---

## ✅ PHASE 5: FONCTIONNALITÉS AVANCÉES

### API et Services
- [ ] API REST pour mobile (`/api/services`, `/api/encadreurs`)
- [ ] API pour réservations
- [ ] Middleware API avec rate limiting
- [ ] Documentation API (Swagger)

### Performance et Cache
- [ ] Configuration Redis pour cache
- [ ] Cache des requêtes lourdes
- [ ] Optimisation images (WebP, lazy loading)
- [ ] Minification CSS/JS
- [ ] Configuration OPcache

### Notifications
- [ ] Notifications temps réel (Pusher/WebSockets)
- [ ] Emails templates (réservation, contact)
- [ ] Notifications admin (dashboard)
- [ ] SMS notifications (optionnel)

### Logs et Monitoring
- [ ] Logs activité admin
- [ ] Logs erreurs application
- [ ] Monitoring performances
- [ ] Statistiques visites (Google Analytics)

---

## ✅ PHASE 6: DÉPLOIEMENT ET MIGRATION

### Préparation Production
- [ ] Configuration serveur (Apache/Nginx)
- [ ] Configuration SSL/HTTPS
- [ ] Optimisation PHP (OPcache, memory_limit)
- [ ] Configuration base de données production
- [ ] Backup automatique BDD

### Migration Données
- [ ] Script migration données existantes
- [ ] Validation intégrité données
- [ ] Migration fichiers uploads
- [ ] Test migration sur environnement staging

### Tests et Validation
- [ ] Tests unitaires modèles
- [ ] Tests fonctionnels interface admin
- [ ] Tests d'intégration frontend
- [ ] Tests performance charge
- [ ] Tests sécurité (OWASP)

### Documentation et Formation
- [ ] Documentation technique développeur
- [ ] Manuel utilisateur admin
- [ ] Guide maintenance/backup
- [ ] Formation équipe admin
- [ ] Documentation API

---

## 📋 NOTES IMPORTANTES

### Technologies Utilisées
- **Framework:** Laravel 11
- **Frontend:** Blade + Bootstrap 5
- **Database:** MySQL (existante)
- **Cache:** Redis
- **Assets:** Vite
- **Admin Theme:** AdminLTE ou équivalent

### Estimation Temps
- **Phase 1-2:** 2 semaines
- **Phase 3:** 2-3 semaines  
- **Phase 4:** 2 semaines
- **Phase 5:** 1-2 semaines
- **Phase 6:** 1 semaine
- **Total:** 8-10 semaines

### Équipe Recommandée
- 1 Développeur Laravel Senior
- 1 Développeur Frontend
- 1 DevOps (pour déploiement)

---

## 🚀 PROCHAINES ÉTAPES

1. **Validation du plan** avec l'équipe
2. **Setup environnement de développement**
3. **Création du repository Git**
4. **Début Phase 1** - Configuration Laravel

---

*Dernière mise à jour: 27/07/2025*