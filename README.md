# TP 7 — Conception et CRUD multi-entités

**Licence Développement Web Full Stack et DevOps**
**Technologies :** PHP, PDO, MySQL, HTML/CSS, XAMPP

Application web de gestion d'un **centre de formation** : formations, étudiants et modules, avec un CRUD complet pour chaque entité.

---

## Sommaire

1. [Contexte et règles métier](#1-contexte-et-règles-métier)
2. [Entités et relations](#2-entités-et-relations)
3. [Modèle de données](#3-modèle-de-données)
4. [Structure du projet](#4-structure-du-projet)
5. [Installation](#5-installation)
6. [Fonctionnalités](#6-fonctionnalités)
7. [Tests effectués](#7-tests-effectués)

---

## 1. Contexte et règles métier

- Le centre propose plusieurs **formations**.
- Chaque **étudiant** est rattaché à **une seule** formation.
- Une formation peut accueillir **plusieurs** étudiants.
- Chaque formation contient **plusieurs modules**.
- Chaque **module** appartient à **une seule** formation.

## 2. Entités et relations

| Relation | Cardinalité | Clé étrangère placée dans |
|---|---|---|
| Formation **accueille** Étudiant | 1 — 0..* | `etudiants.formation_id` |
| Formation **contient** Module | 1 — 0..* | `modules.formation_id` |

> La clé étrangère se place toujours du côté « plusieurs » de la relation.

## 3. Modèle de données

Base de données : **`tp7_crud`**

### Table `formations`
| Colonne | Type | Remarque |
|---|---|---|
| `id` | INT AUTO_INCREMENT | Clé primaire |
| `intitule` | VARCHAR(120) | Nom de la formation |
| `duree_mois` | INT | Durée en mois |
| `tarif` | DECIMAL(10,2) | Prix en DH |

### Table `etudiants`
| Colonne | Type | Remarque |
|---|---|---|
| `id` | INT AUTO_INCREMENT | Clé primaire |
| `nom` | VARCHAR(80) | |
| `prenom` | VARCHAR(80) | |
| `email` | VARCHAR(150) | Unique |
| `formation_id` | INT | Clé étrangère → `formations(id)` |

### Table `modules`
| Colonne | Type | Remarque |
|---|---|---|
| `id` | INT AUTO_INCREMENT | Clé primaire |
| `intitule` | VARCHAR(120) | |
| `volume_horaire` | INT | Heures |
| `semestre` | INT | |
| `formation_id` | INT | Clé étrangère → `formations(id)` |

## 4. Structure du projet

```
tp7-crud/
├── index.php              # Page d'accueil
├── README.md
├── database.sql           # Création de la base, des tables et des données de test
├── database/
│   └── connexion.php      # Connexion PDO centralisée
├── formations/            # index.php · create.php · edit.php · delete.php
├── etudiants/             # index.php · create.php · edit.php · delete.php
├── modules/               # index.php · create.php · edit.php · delete.php
└── assets/
    └── css/style.css

```

## 5. Installation

1. Démarrer **Apache** et **MySQL** dans XAMPP.
2. Copier le dossier `tp7-crud` dans `C:\xampp\htdocs\`.
3. Ouvrir **phpMyAdmin** (`http://localhost/phpmyadmin`), onglet **Importer**, choisir `database.sql` puis **Exécuter**.
4. Ouvrir **http://localhost/tp7-crud/**.

> La connexion utilise `root` sans mot de passe (configuration par défaut de XAMPP). Modifier `database/connexion.php` si besoin.

## 6. Fonctionnalités

| Entité | Lire | Créer | Modifier | Supprimer |
|---|---|---|---|---|
| Formations | Liste avec nombre d'étudiants et de modules | Formulaire POST | Formulaire prérempli | Refusée si la formation contient encore des étudiants ou des modules |
| Étudiants | Liste avec le nom de la formation (`JOIN`) | `select` des formations | `select` prérempli | Directe |
| Modules | Liste avec le nom de la formation (`JOIN`) | `select` des formations | `select` prérempli | Directe |

Points techniques :
- Requêtes **préparées** PDO (`prepare()` / `execute()`) contre les injections SQL.
- Sorties échappées avec `htmlspecialchars()`.
- Redirection vers la liste après chaque ajout, modification ou suppression.
- Clause `WHERE id = :id` obligatoire pour les modifications et suppressions.
- Un email déjà utilisé affiche un message d'erreur au lieu de planter.

## 7. Tests effectués

- [x] Les trois listes s'affichent correctement.
- [x] Un élément peut être ajouté dans chaque entité.
- [x] Les formulaires de modification sont préremplis.
- [x] Les modifications sont enregistrées.
- [x] Les suppressions ciblent le bon élément.
- [x] Les relations s'affichent (nom de la formation au lieu de l'identifiant).
- [x] La navigation permet de revenir aux listes et à l'accueil.
