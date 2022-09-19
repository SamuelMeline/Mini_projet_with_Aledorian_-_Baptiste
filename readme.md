# Mini-projet

## Objectif

Mini-projet à réaliser en autonomie par groupe de 2 ou 3. Le but est de pratiquer tout ce qui a été vu durant la formation.

## Projet

Réalisation d'un site d'événements (création et affichage d'événements).

## Fonctionnalités

1 => Aledorian
2 => Baptiste
3 => Samuel

* Accueil (Liste des 5 derniers événements et des 5 derniers commentaires) => 3
* Liste des événements => 1
* Détail d'un événement => 2
* Création d'un événement =>
* Modifier un événement =>
* Supprimer un événement (Back-office) =>
* Liste des commentaires d'un événement =>
* Création d'un commentaire sur un événement =>
* Suppression des commentaires (Back-office) =>
* Création d'un back-office (interface d'administration) =>
* Inscription =>
* Connexion =>
* [BONUS] Inscription à un événement =>
* [BONUS] Affichage des événements proche de ma position (géolocalisation) =>
* [BONUS++] Accueil -> affichage de tous les événements sur une carte (style airbnb) =>

## Base de données

### Tables

* events (id, title, picture, description, created_at, started_at)
* categories (id, name)
* users (id, username, password, created_at, admin)
* comments (id, content, created_at)

## Gestion des droits

* L'interface d'administration n'est accessible que pour l'utilisateur "admin"
* La création d'un événement, d'un commentaire, l'inscription à un événement ne peuvent être faits que par un utilisateur connecté
* La modification d'un événement ne peut être fait que par l'auteur de l'événement ou l'administrateur
* La suppression d'événements et de commentaires ne peuvent être faits que par l'administrateur

## Technique

* Utilisation de la POO
* Au minimum mise en place d'une architecture MVC (framework maison recommandé)
* Git pour le travail en équipe