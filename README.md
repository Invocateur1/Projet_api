Description

Ce projet est une API développée avec Laravel, conçue pour gérer un système de blog avec des fonctionnalités de création, modification, suppression d'articles, ainsi que d'authentification des utilisateurs via JWT (JSON Web Token). Elle comprend également un mécanisme de Rate Limiting pour protéger l'API contre les abus et garantir un usage équitable.

Fonctionnalités
Authentification

Enregistrement des utilisateurs : Permet aux utilisateurs de s'enregistrer avec leur nom, email, et mot de passe.

Connexion : Authentification par email et mot de passe avec la génération d'un Token JWT.

Rafraîchissement du Token : Permet de rafraîchir un token JWT valide.

Déconnexion : Révoque le token actuel.

Accès protégé : Accès aux données utilisateurs et à la gestion des articles uniquement pour les utilisateurs authentifiés.

Gestion des Articles

Créer un article : Les utilisateurs authentifiés peuvent créer des articles.

Lire des articles : Affichage des articles publiés. Les articles sont accessibles publiquement.

Mettre à jour un article : Un utilisateur peut modifier ses propres articles.

Supprimer un article : Les utilisateurs peuvent supprimer leurs propres articles.

Rate Limiting

Mise en place de la limitation de débit pour prévenir l'abus de l'API (ex. : limiter les tentatives de connexion, les requêtes d'articles).

Limites par minute et par jour pour diverses actions.

Technologies utilisées

Laravel : Framework PHP pour le développement d'API.

JWT : Pour la gestion de l'authentification.

MySQL : Base de données utilisée pour stocker les informations utilisateur et les articles.

Postman : Utilisé pour tester l'API de manière interactive.

Installation
Prérequis

Avant de commencer, assurez-vous d'avoir les outils suivants installés sur votre machine :

PHP 7.x ou supérieur

Composer pour la gestion des dépendances

MySQL ou un autre serveur de base de données compatible

Postman pour tester les requêtes API

Git pour cloner le repository

Étapes d'installation

Cloner le projet depuis GitHub :

git clone https://github.com/votre-utilisateur/laravel-api-blog.git
cd laravel-api-blog


Installer les dépendances via Composer :

composer install


Configurer le fichier .env :

Copiez le fichier .env.example et renommez-le en .env :

cp .env.example .env


Ensuite, configurez vos paramètres de base de données dans le fichier .env.

Générer la clé d'application :

php artisan key:generate


Exécuter les migrations pour créer les tables dans la base de données :

php artisan migrate


Lancer le serveur local :

php artisan serve


L'API sera disponible à http://127.0.0.1:8000.

Test de l'API
Tester avec Postman

Créer une collection dans Postman pour organiser les tests de l'API.

Ajouter des variables d'environnement dans Postman :

base_url : http://127.0.0.1:8000/api

token : Valeur vide à remplir après la connexion.

Exemple de tests

Enregistrer un utilisateur :

Méthode : POST

URL : {{base_url}}/auth/register

Corps :

{
  "name": "Jean Dupont",
  "email": "jean@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}


Se connecter :

Méthode : POST

URL : {{base_url}}/auth/login

Corps :

{
  "email": "jean@example.com",
  "password": "password123"
}


Obtenir les informations de l'utilisateur (protégé) :

Méthode : GET

URL : {{base_url}}/auth/me

En-tête :

Authorization: Bearer {{token}}


Créer un article :

Méthode : POST

URL : {{base_url}}/posts

Corps :

{
  "titre": "Introduction à Laravel 12",
  "contenu": "Laravel 12 apporte de nombreuses améliorations...",
  "statut": "publie"
}

Tests d'erreurs

Validation échouée (titre manquant) :

Réponse attendue : 422 Unprocessable Entity avec un message d'erreur.

Non autorisé (sans token) :

Réponse attendue : 401 Unauthorized.

Trop de requêtes (Rate Limiting atteint) :

Réponse attendue : 429 Too Many Requests.

Rate Limiting

Pour prévenir les abus de l'API, nous avons mis en place une limitation de débit sur certaines routes, notamment :

POST /auth/login : Maximum 5 tentatives par minute.

POST /auth/register : Maximum 3 par heure.

POST /posts : Maximum 10 par minute pour les utilisateurs non authentifiés et 20 pour les utilisateurs authentifiés.

Contribution

Les contributions sont les bienvenues ! Si vous souhaitez améliorer ce projet, voici quelques étapes pour contribuer :

Fork le projet.

Créez une branche pour votre fonctionnalité (git checkout -b feature/ma-fonctionnalite).

Commitez vos changements (git commit -am 'Ajout d\'une nouvelle fonctionnalité').

Poussez à la branche (git push origin feature/ma-fonctionnalite).

Ouvrez une Pull Request.

License

Ce projet est sous la licence MIT - voir le fichier LICENSE
 pour plus de détails.

Exemple d'utilisation avec PowerShell pour tester le rate limiting

Voici un exemple de script PowerShell pour tester les limites de taux de l'API, par exemple pour tester les tentatives de connexion.

Créez un fichier nommé test_rate_limit.ps1 avec le code fourni dans votre projet.

Exécutez le script pour envoyer plusieurs requêtes et observer le comportement de l'API lorsqu'une limite est atteinte.
