###Projet de Téléchargement et Géolocalisation de Photos

Ce projet Laravel permet aux utilisateurs de télécharger des photos, d'extraire des données EXIF, de géolocaliser les photos à partir de ces données, et d'enregistrer les informations pertinentes dans une base de données.

###Fonctionnalités
Téléchargement de photos avec validation.

Extraction de données EXIF pour récupérer la latitude, la longitude et la date de prise de la photo.

Utilisation des coordonnées pour obtenir des détails d'adresse via géocodage inversé.

Sauvegarde des informations de la photo et des détails de l'adresse dans une base de données.

Interface utilisateur pour afficher les détails de la photo et de l'adresse.

###Technologies Utilisées
Laravel: Framework PHP pour la structure du projet.

Tailwind CSS: Pour le stylisme des pages.

MySQL: Base de données pour stocker les informations des photos.

API HERE: Utilisée pour le géocodage inversé.
