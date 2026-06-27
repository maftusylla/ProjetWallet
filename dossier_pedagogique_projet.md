# Dossier Pédagogique : Application de Gestion de Wallet

Ce document regroupe l'ensemble des éléments nécessaires pour encadrer le Sprint 1 du projet. Il se divise en deux parties : le sujet à distribuer aux étudiants (Partie 1) et le support pour votre présentation orale (Partie 2).

---

## PARTIE 1 : DESCRIPTION DU PROJET (Sujet pour les étudiants)

### 1. Contexte du Projet
Vous êtes chargés de développer un simulateur de portefeuille électronique (Wallet) de type "Mobile Money". Cette application permettra d'effectuer des opérations basiques telles que la création de comptes, les dépôts, les retraits et la consultation de l'historique des transactions.

Ce projet a pour but de vous faire manipuler et consolider les concepts fondamentaux du langage PHP avant de passer à des notions plus avancées.

### 2. Objectifs Pédagogiques
Ce premier jalon (Sprint 1) vise à évaluer votre maîtrise des éléments suivants :
- **Les Tableaux Numériques** : pour stocker les données de l'application en mémoire.
- **Les Fonctions natives sur les chaînes de caractères**.
- **Les Fonctions nommées** : vous devrez savoir manipuler les arguments obligatoires, les arguments par défaut, les arguments nommés, et bien comprendre la notion de *Scope* (portée des variables).

### 3. Contraintes Techniques (Sprint 1)
Votre rendu devra **strictement** respecter les règles suivantes :
1. **Mode Console** : L'application est un script exécuté en ligne de commande (Terminal), sans interface graphique web.
2. **Fichier Unique** : Tout votre code doit résider dans un seul fichier nommé `index.php`.
3. **Structuration** : L'application doit être découpée en utilisant uniquement des **fonctions nommées**. L'utilisation de programmation orientée objet (classes) n'est pas attendue pour ce sprint.

### 4. Spécifications Fonctionnelles

Au lancement, votre application doit présenter un menu interactif à l'utilisateur :

**Menu Distributeur**
> 1. Créer Wallet
> 2. Faire Dépôt
> 3. Faire Retrait
> 4. Lister les Transactions
> 0. Quitter

#### Règles de gestion et de validation (Definition of Done)

**Feature 0 : Réalisation du Menu**
- **RG1** : Le menu doit s'afficher de manière répétitive. L'application ne s'arrête que si l'utilisateur saisit explicitement le choix `0`.
- **RG2** : Si l'utilisateur saisit une option invalide (ex: `18`, `-1`), le système affiche **"Choix invalide"** et propose à nouveau le menu.

**Feature 1 : Créer un Wallet** (Un Wallet = Client, Téléphone, Code secret, Solde)
- **RG1 (Saisie)** : Le téléphone, le client et le code sont obligatoires. Le solde initial doit être positif ou nul.
- **RG2 (Unicité)** : Le numéro de téléphone et le code secret doivent être uniques dans tout le système.
- **RG3 (Format Téléphone)** : Le numéro doit respecter le format sénégalais (ex: commence par 77, 78, 76, 70 ou 75).
- **RG4 (Format Code)** : Le code secret doit comporter exactement **4 caractères**.

**Feature 2 : Faire un Dépôt**
- **RG1** : Le numéro de téléphone saisi doit être associé à un wallet existant.
- **RG2** : Le montant à déposer doit être strictement positif.

**Feature 3 : Faire un Retrait**
- **RG1** : Le numéro de téléphone saisi doit être associé à un wallet existant.
- **RG2 (Fonds)** : Le montant à retirer doit être positif et le solde du compte doit être suffisant.
- **RG3 (Frais)** : Chaque retrait occasionne des frais de **1% du montant retiré**, plafonnés à **5000 CFA**. Le solde est débité du montant demandé + les frais.

---

## PARTIE 2 : SUPPORT DE PRÉSENTATION & EXPOSÉ (Pour le formateur)

*Cette section détaille le contenu des diapositives (à afficher) et le discours associé (à dire à l'oral) pour introduire le projet à votre classe.*

### Slide 1 : Titre de la Présentation
**Visuel (Sur l'écran) :**
> # Projet Gestion de Wallet : Sprint 1
> ## Objectifs Pédagogiques et Compétences Visées
> *Présenté par : [Votre Nom]*

**Exposé (À l'oral) :**
> *"Bonjour à toutes et à tous. Aujourd'hui, je vais vous présenter les objectifs pédagogiques du premier Sprint de notre projet de création d'une application de gestion de Wallet en console. L'idée est de bien comprendre quelles sont les compétences techniques en PHP que vous allez acquérir."*

### Slide 2 : Le Cœur du Sprint 1
**Visuel (Sur l'écran) :**
> ### Les 3 Piliers du Sprint 1
> - **Pas de base de données**, stockage en mémoire.
> - **Pas d'interface graphique**, uniquement console.
> - **Pas d'orienté objet (POO)**, tout en procédural.
> **Objectif principal :** Consolider les bases algorithmiques en PHP.

**Exposé (À l'oral) :**
> *"Pour ce Sprint 1, nous nous affranchissons de la complexité visuelle et des bases de données. Tout se fera en console et dans un seul fichier. Pourquoi ? Parce que notre objectif est de nous concentrer sur l'algorithmique pure et la maîtrise des structures fondamentales de PHP."*

### Slide 3 : Objectif N°1 - Les Tableaux Numériques
**Visuel (Sur l'écran) :**
> ### 1. Maîtriser les Tableaux Numériques
> - Simulation d'une base de données.
> - **Compétences :** Création, parcours (boucles), ajout et recherche d'éléments.

**Exposé (À l'oral) :**
> *"Le premier grand objectif est la maîtrise des tableaux numériques. Ils vont nous servir de zone de stockage temporaire. Vous allez apprendre à structurer vos données (historique de transactions), à les parcourir pour trouver un numéro, et à y insérer de nouvelles données."*

### Slide 4 : Objectif N°2 - Fonctions sur les Chaînes
**Visuel (Sur l'écran) :**
> ### 2. Manipuler les Chaînes de Caractères
> - Validation des données (Sécurité et Fiabilité).
> - **Cas pratiques :** Longueur d'un code (4 caractères), format d'un téléphone sénégalais.

**Exposé (À l'oral) :**
> *"Le deuxième objectif concerne le traitement des chaînes. Vous devrez utiliser les fonctions natives de PHP pour vérifier qu'un code secret fait bien 4 caractères, ou analyser un numéro de téléphone pour s'assurer qu'il commence par un préfixe valide au Sénégal (77, 70, etc.)."*

### Slide 5 : Objectif N°3 - Les Fonctions Nommées et le Scope
**Visuel (Sur l'écran) :**
> ### 3. Structurer avec les Fonctions Nommées
> - Découper un problème complexe.
> - **Notions :** Arguments (obligatoires/par défaut/nommés) et notion de **Scope** (Portée des variables, références).

**Exposé (À l'oral) :**
> *"Enfin, le troisième objectif est l'organisation du code. Tout sera dans un fichier unique. Pour éviter le chaos, vous allez encapsuler votre logique dans des fonctions nommées. Nous aborderons la notion de 'Scope' pour comprendre comment une fonction peut modifier le solde stocké dans notre tableau global."*

### Slide 6 : Conclusion
**Visuel (Sur l'écran) :**
> ### En résumé
> À la fin du Sprint 1, vous saurez :
> 1. Structurer des données en mémoire.
> 2. Valider des entrées utilisateur.
> 3. Écrire un code découpé et réutilisable.

**Exposé (À l'oral) :**
> *"En conclusion, ce Sprint 1 assure que vos fondations en PHP sont solides. Si vous maîtrisez ces trois piliers, vous serez parfaitement armés pour aborder par la suite les bases de données et la POO. Je vous remercie de votre attention, et nous sommes prêts à coder."*






