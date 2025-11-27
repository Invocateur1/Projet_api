# Projet_api

Introduction
Ce projet est une API RESTful construite avec Laravel 12 et MySQL, utilisant JWT (JSON Web Token) pour l’authentification.  
Il s’agit d’un atelier pratique qui couvre la création d’APIs prêtes pour la production : authentification, CRUD d’articles de blog, rate limiting, tests avec Postman et extensions (commentaires, tags, rôles).

Technologies utilisées
Laravel 12(Framework PHP)
MySQL 8+(Base de données)
JWT Auth(Authentification sécurisée)
Postman(Tests d’API)
phpMyAdmin(Gestion de la base de données)

Authentification
POST /api/auth/register->Créer un compte
POST /api/auth/login->Se connecter
GET /api/auth/me->Profil utilisateur
POST /api/auth/logout->Déconnexion
POST /api/auth/refresh->Rafraîchir le token

GET /api/posts->Liste des articles
POST /api/posts->Créer un article (auth requis)
GET /api/posts/{id}->Afficher un article
PUT /api/posts/{id}->Mettre à jour un article
DELETE /api/posts/{id}->Supprimer un article

Rate Limiting
POST /api/auth/login->5 requêtes/minute  
POST /api/auth/register->3 requêtes/heure  
GET /api/posts->60 requêtes/minute  
POST /api/posts->10 requêtes/minute   
