# Projet de Téléchargement et Géolocalisation de Photos

Ce projet Laravel permet aux utilisateurs de télécharger des photos, d'extraire des données EXIF, de géolocaliser les photos à partir de ces données, et d'enregistrer les informations pertinentes dans une base de données.

## Fonctionnalités

- **Téléchargement de photos avec validation** : Assure que seules les images valides sont traitées.
- **Extraction de données EXIF** : Récupère la latitude, la longitude et la date de prise de la photo à partir des métadonnées.
- **Géolocalisation** : Utilise les coordonnées pour obtenir des détails d'adresse via géocodage inversé avec l'API HERE.
- **Sauvegarde des informations** : Stocke les détails de la photo et de l'adresse dans une base de données MySQL.
- **Interface utilisateur** : Affiche les détails de la photo et de l'adresse dans une interface web utilisant Tailwind CSS.

## Technologies Utilisées

- **Laravel** : Un framework PHP robuste pour le développement d'applications web.
- **Tailwind CSS** : Un framework CSS pour un design rapide et réactif.
- **MySQL** : Système de gestion de base de données relationnelle pour stocker les informations.
- **API HERE** : Service de géocodage inversé pour transformer les coordonnées géographiques en adresses postales.

