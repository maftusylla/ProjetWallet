# Énoncé de Projet : Système de Gestion de Portefeuille Électronique (E-Wallet) en PHP

## 1. Contexte et Objectif
Dans le cadre de la digitalisation des services financiers, une entreprise souhaite mettre en place une solution basique de gestion de portefeuilles électroniques (Wallets) via une interface console. 

L'objectif de ce projet est de développer une application procédurale en PHP simulant le fonctionnement d'un distributeur de services financiers. L'application devra permettre la création de portefeuilles, la gestion des dépôts et des retraits, ainsi que la consultation de l'historique des transactions.

## 2. Spécifications Fonctionnelles

L'application doit présenter à l'utilisateur le menu interactif suivant :
```text
** Menu Distributeur **
1 - Créer Wallet
2 - Faire Dépôt
3 - Faire Retrait
4 - Lister les Transactions
0 - Quitter
```

### Fonctionnalité 0 : Gestion du Menu Interactif
Le programme doit tourner en boucle pour permettre à l'utilisateur d'enchaîner les opérations.
*   **RG 0.1 (Boucle de menu) :** Le menu doit s'afficher de manière répétitive. L'exécution du programme ne s'arrête que si l'utilisateur saisit le choix `0`.
*   **RG 0.2 (Gestion des erreurs de saisie) :** Si l'utilisateur saisit une option non disponible (par exemple : `5`, `18`, `-1`, ou des lettres), le système doit afficher un message d'erreur clair : `"Choix invalide, veuillez réessayer"`.

### Fonctionnalité 1 : Créer un Wallet (Option 1)
Permet d'enregistrer un nouveau portefeuille client.
*   **RG 1.1 (Champs obligatoires et validité) :** Lors de la création, le système doit demander et vérifier les informations suivantes :
    *   `Numéro de téléphone` : Obligatoire.
    *   `Nom du client` : Obligatoire.
    *   `Solde initial` : Doit être obligatoirement positif ou nul (>= 0).
    *   `Code secret` : Obligatoire.
*   **RG 1.2 (Unicité des données) :** 
    *   Le numéro de téléphone doit être **unique** dans le système (un client ne peut pas avoir deux wallets avec le même numéro).
    *   Le code secret doit être **unique**.

### Fonctionnalité 2 : Faire un Dépôt (Option 2)
Permet d'ajouter des fonds sur un Wallet existant.
*   **RG 2.1 (Validation du compte et du montant) :** 
    *   L'utilisateur doit saisir le numéro de téléphone associé au wallet. Ce numéro doit obligatoirement exister dans le système.
    *   Le montant à déposer doit être strictement positif (> 0).

### Fonctionnalité 3 : Faire un Retrait (Option 3)
Permet de déduire des fonds d'un Wallet existant.
*   **RG 3.1 (Validation de la transaction) :**
    *   Le numéro de téléphone associé au wallet doit exister.
    *   Le montant à retirer doit être strictement positif (> 0).
    *   Le solde actuel du wallet (moins les frais) doit être suffisant pour couvrir le montant demandé (Solde disponible).
*   **RG 3.2 (Calcul des frais dynamiques) :**
    *   Le système de calcul des frais fonctionne par paliers :
        *   Pour un montant retiré entre **0 et 10 000 CFA** : Frais fixes de **200 CFA**.
        *   Pour un montant retiré entre **10 001 et 100 000 CFA** : Frais fixes de **500 CFA**.
        *   Pour un montant retiré strictement supérieur à **100 000 CFA** : Les frais s'élèvent à **1% du montant retiré**.
    *   Cependant, si la règle des 1% s'applique, le montant des frais est **plafondé à 5000 CFA** maximum par transaction (Exemple : pour un retrait de 1 000 000 CFA, les frais ne seront que de 5000 CFA et non 10 000 CFA).

### Fonctionnalité 4 : Lister les Transactions (Option 4)
*   Doit afficher l'historique des opérations (dépôts, retraits, frais appliqués) effectuées sur l'ensemble des wallets, ou sur un wallet spécifique demandé à l'utilisateur (à définir).

---

## 3. Déroulement du Projet (Phases de développement)

Le projet sera développé de manière itérative en deux grandes parties, avec des contraintes techniques spécifiques pour chacune. L'architecture globale s'appuie sur une répartition en plusieurs fichiers et l'utilisation de tableaux en mémoire pour stocker les données. L'approche objet (Classes) est interdite.

**Rôle attendu pour chaque fichier de l'architecture :**
*   **`index.php`** : Point d'entrée de l'application. Il contient la boucle principale d'exécution (`do...while` ou `while`), gère l'affichage du menu et lit le choix de l'utilisateur.
*   **`controller.php`** : Intermédiaire (routeur de logique). Il reçoit le choix de `index.php`, demande les saisies complémentaires à l'utilisateur (téléphone, montant, etc.), appelle les fonctions du service pour traiter l'action, puis affiche le résultat final.
*   **`services.php`** : Contient la logique métier (Business Logic). C'est ici que sont implémentées les règles complexes (ex: calcul des frais de retrait plafonnés à 5000) et l'orchestration des actions avant l'enregistrement.
*   **`repository.php`** : Dédié à la persistance et l'accès aux données. Il regroupe les fonctions qui lisent, ajoutent ou modifient directement les données dans les tableaux (ex: trouver un wallet, ajouter une transaction, mettre à jour un solde).
*   **`validator.php`** : Regroupe toutes les fonctions de validation. Il vérifie que les règles de gestion strictes sont respectées (ex: format du téléphone, unicité du numéro, montant strictement positif, vérification de la disponibilité du solde).

### Partie A : Les Fondamentaux du PHP Procédural
L'objectif de cette phase est de maîtriser les algorithmes de base et la structuration manuelle du code.
1.  **Sans fonctions natives sur les tableaux :** Il est **strictement interdit** d'utiliser les fonctions natives PHP de manipulation de tableaux (comme `in_array`, `array_push`, `array_search`, etc.). Vous devez manipuler les tableaux manuellement à l'aide de boucles (`for`, `foreach`, `while`).
2.  **Sans Namespace :** L'inclusion des fichiers se fera de manière classique (avec `require` ou `include`), sans utiliser d'espaces de noms.

### Partie B : Professionnalisation et Outils Modernes
L'objectif de cette phase est d'améliorer le code existant et d'introduire des concepts avancés.
1.  **Avec fonctions natives PHP :** Refactorisation du code de la Partie A en utilisant les fonctions natives de PHP sur les tableaux (`array_map`, `array_filter`, etc.) pour optimiser et raccourcir le code.
2.  **Avec Namespace :** Mise en place d'une architecture utilisant les **Namespaces** pour mieux organiser et cloisonner les fonctions.
3.  **Présentation Technique :** Préparation d'une présentation (diapositives) couvrant les points suivants :
    *   a) Les fonctions Anonymes / Fonctions fléchées (Arrow functions) / Closures en PHP.
    *   b) L'utilité et le fonctionnement des fonctions natives de tableaux (`array_*`).
    *   c) Le rôle du gestionnaire de dépendances **Composer**.
    *   d) La plateforme **Packagist.org** et son écosystème.

---

## 4. Stratégie de Versionning et Travail Collaboratif

Afin de garantir un suivi efficace des évolutions du code et d'adopter les bonnes pratiques de l'industrie, le projet devra obligatoirement être versionné avec **Git** et hébergé sur une plateforme distante (comme GitHub ou GitLab). Les règles suivantes doivent être respectées :

### 4.1. Versionnage Sémantique adaptatif (SemVer)
Le projet utilisera le versionnage sémantique au format `X.Y.Z` (Majeure.Mineure.Correctif). Le cycle de vie des versions est calqué sur l'avancement des parties A et B :
*   **v1.0.0** : Livraison finale de la **Partie A** (Version 100% fonctionnelle, procédurale, sans array functions, sans namespace).
*   **v2.0.0** : Livraison finale de la **Partie B** (Refactorisation complète, intégration des namespaces et fonctions natives).
*   **v0.X.Y / v1.X.Y** : Utilisées pour les versions intermédiaires lors du développement de chaque phase.
    *   *Exemples pour la Partie A (v0.X.Y) :* 
        *   `v0.1.0` : Intégration de la boucle de menu.
        *   `v0.2.0` : Ajout de la fonctionnalité "Créer Wallet".
        *   `v0.2.1` : Correction d'un bug mineur sur la vérification de l'unicité du téléphone.
    *   *Exemples pour la Partie B (v1.X.Y) :*
        *   `v1.1.0` : Refonte du stockage en utilisant les fonctions natives (`array_map`, `array_filter`).
        *   `v1.2.0` : Intégration complète des Namespaces sur tous les fichiers.

### 4.2. Stratégie de Branches (Git Workflow adapté)
L'équipe devra organiser son dépôt selon la structure suivante pour gérer les deux parties :
*   `main` (ou `master`) : Branche de production. Le code sur cette branche correspond aux versions stables taguées (v1.0.0, v2.0.0). **Aucun développement direct.**
*   `develop-partA` : Branche d'intégration pour la Partie A.
*   `develop-partB` : Branche d'intégration pour la Partie B (créée à partir du tag v1.0.0 une fois la Partie A achevée).
*   **Branches de fonctionnalités (Feature branches)** : Chaque fonctionnalité doit être développée sur une branche dédiée créée depuis la branche d'intégration en cours.
    *   *Nomenclature exigée :* `feature/nom-de-la-fonctionnalite` (ex: `feature/creation-wallet`, `feature/refacto-namespace`).

### 4.3. Conventions de Commits (Conventional Commits)
Les messages de commit doivent être clairs, explicites et suivre une convention standardisée pour générer facilement un historique lisible :
*   `feat:` pour l'ajout d'une nouvelle fonctionnalité (ex: *feat: ajout de la vérification d'unicité du téléphone*).
*   `fix:` pour la correction d'un bug (ex: *fix: correction du calcul des frais plafonnés à 5000*).
*   `refactor:` pour une modification du code n'ajoutant ni fonctionnalité ni correction de bug (ex: *refactor: passage des if/else imbriqués en switch case*).
*   `docs:` pour les modifications de la documentation.

### 4.4. Validation (Merge Requests / Pull Requests)
*   La fusion (merge) d'une branche `feature` vers `develop` doit faire l'objet d'une **Pull Request (PR)**.
*   Le code fusionné ne doit pas comporter d'erreurs de syntaxe (Parse error) et doit respecter les règles de gestion liées à la fonctionnalité traitée.

---

## 5. Livrables Attendus
*   Le code source PHP respectant l'arborescence demandée, versionné avec un historique de commits propre (couvrant la Partie A puis la Partie B).
*   Le support de présentation (PDF, PowerPoint ou Markdown) couvrant les concepts exigés dans la Partie B.
*   Le lien vers le dépôt Git distant.
