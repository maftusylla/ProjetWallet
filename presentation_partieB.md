**Présentation Technique  Partie B**  
**Projet E-Wallet  Système de Gestion de Portefeuille Électronique en PHP**  
**Auteur : Mame Fatou Sylla**

**Sommaire**

1. Fonctions Anonymes, Arrow Functions et Closures en PHP  
2. Fonctions Natives de Tableaux   La famille array\_\*  
3. Composer   Le Gestionnaire de Dépendances PHP  
4. Packagist.org   L'Écosystème des Packages PHP

1\. Fonctions Anonymes, Arrow Functions et Closures en PHP  
1.1 Fonctions Anonymes

Une fonction anonyme est une fonction qui ne possède pas de nom déclaré. Elle peut être assignée à une variable, passée en argument à une autre fonction, ou retournée comme valeur de retour. Ce concept est fondamental en programmation fonctionnelle et permet d'écrire du code plus flexible et modulaire.

En PHP, les fonctions anonymes sont disponibles depuis la version 5.3. Elles sont particulièrement utiles lorsqu'on a besoin d'une logique ponctuelle qui ne mérite pas d'être déclarée comme une fonction globale nommée.

Syntaxe de base

$direBonjour \= function(string $nom): string {

    return "Bonjour " . $nom;

};

echo $direBonjour("Mame");

// Résultat : Bonjour Mame

Dans cet exemple, la fonction est stockée dans la variable $direBonjour et peut être appelée comme une fonction normale. Elle peut aussi être passée directement comme argument à une autre fonction.

Utilisation comme argument

$nombres \= \[3, 1, 4, 1, 5, 9, 2\];

usort($nombres, function($a, $b) {

    return $a \- $b;

});

// Résultat : \[1, 1, 2, 3, 4, 5, 9\]

Utilisation dans le projet E-Wallet

Dans notre projet, les fonctions anonymes sont utilisées notamment dans controller.php pour filtrer les messages d'erreur selon le code retourné par les services.

// controller.php   Partie B

$trouve \= array\_filter($messages, function($valeur, $cle) use ($code) {

    return $cle \=== $code;

}, ARRAY\_FILTER\_USE\_BOTH);

Ici la fonction anonyme reçoit la valeur et la clé de chaque élément du tableau $messages et retourne vrai uniquement si la clé correspond au code d'erreur recherché.  
1.2 Arrow Functions (Fonctions Fléchées)  
Les arrow functions, introduites en PHP 7.4, sont une syntaxe raccourcie des fonctions anonymes. Elles sont conçues pour les expressions courtes et ont la particularité de capturer automatiquement les variables du scope parent sans avoir besoin du mot-clé use.

Cette capture automatique est la différence fondamentale avec les fonctions anonymes classiques. Avec une arrow function, toutes les variables disponibles dans le contexte appelant sont directement accessibles à l'intérieur de la fonction.

Syntaxe

// Fonction anonyme classique

$double \= function(int $n): int {

    return $n \* 2;

};

// Arrow function équivalente   syntaxe compacte

$double \= fn(int $n) \=\> $n \* 2;

echo $double(5);

// Résultat : 10

Capture automatique des variables

$taux \= 0.20;

// Avec une fonction anonyme, on doit déclarer use ($taux)

$calculerTTC \= function(int $montant) use ($taux): float {

    return $montant \* (1 \+ $taux);

};

// Avec une arrow function, $taux est capturé automatiquement

$calculerTTC \= fn(int $montant) \=\> $montant \* (1 \+ $taux);

echo $calculerTTC(10000);

// Résultat : 12000

Utilisation dans le projet E-Wallet

Les arrow functions sont massivement utilisées dans la Partie B du projet pour remplacer les boucles manuelles de la Partie A.

// validator.php   Partie B

// Vérifier si un téléphone existe déjà parmi les wallets

$telExiste \= array\_filter($wallets, fn($w) \=\> $w\['telephone'\] \=== $telephone);

// repository.php   Partie B

// Trouver un wallet à partir de son numéro de téléphone

$trouve \= array\_filter($wallets, fn($w) \=\> $w\['telephone'\] \=== $telephone);

// repository.php   Partie B

// Filtrer les transactions d'un client spécifique

$transactionsClient \= array\_filter(

    $transactions,

    fn($t) \=\> $t\['indexClient'\] \=== $index

);

Tableau comparatif

| Caractéristique | Fonction anonyme | Arrow function |
| :---- | :---- | :---- |
| Syntaxe | function() {} | fn() \=\> |
| Capture des variables | use ($var) obligatoire | Automatique |
| Nombre de lignes | Plusieurs lignes possibles | Une seule expression |
| Valeur de retour | return explicite | Implicite |
| Version PHP | Depuis PHP 5.3 | Depuis PHP 7.4 |

1.3 Closures  
Une Closure est une fonction anonyme qui ferme sur les variables de son environnement extérieur. Techniquement en PHP, toute fonction anonyme est une instance de la classe interne Closure. Ce concept vient de la programmation fonctionnelle et permet à une fonction de mémoriser et d'accéder aux variables qui existaient au moment de sa création.

La différence entre une simple fonction anonyme et une Closure réside dans cette capacité à capturer et à maintenir l'état des variables extérieures, même après que le contexte d'origine a terminé son exécution.

Capture par valeur avec use

$taxe \= 0.18;

$calculerTTC \= function(int $montant) use ($taxe): float {

    return $montant \* (1 \+ $taxe);

};

// Même si on modifie $taxe ici, la closure garde la valeur capturée au moment de sa création

$taxe \= 0.30;

echo $calculerTTC(10000);

// Résultat : 11800 (la valeur 0.18 a été capturée, pas 0.30)

Capture par référence avec use (&$var)

$compteur \= 0;

$incrementer \= function() use (&$compteur): void {

    $compteur++;

};

$incrementer();

$incrementer();

$incrementer();

echo $compteur;

// Résultat : 3 (la variable originale a été modifiée)

Utilisation dans le projet E-Wallet

Dans services.php, les closures avec use sont utilisées pour capturer le wallet dans la fonction de mapping des transactions.

// services.php   Partie B

// La closure capture $wallet par valeur avec use

function listerTransactionsParTelephone(string $telephone): array {

    $wallet \= trouverWalletParTelephone($telephone);

    return array\_map(function($transaction) use ($wallet) {

        $type \= $transaction\['montant'\] \> 0 ? 'Dépôt' : 'Retrait';

        return \[

            'type'    \=\> $type,

            'montant' \=\> $transaction\['montant'\],

            'frais'   \=\> $transaction\['frais'\],

            'client'  \=\> $wallet\['client'\]

        \];

    }, $transactions);

}

Ici $wallet est capturé par valeur au moment de la création de la closure. Chaque appel à cette closure utilise le même wallet, ce qui est exactement le comportement voulu pour associer chaque transaction à son titulaire.

---

2\. Fonctions Natives de Tableaux   La famille array\_\*  
2.1 Pourquoi utiliser les fonctions natives ?  
Dans la Partie A du projet, toutes les manipulations de tableaux étaient réalisées manuellement avec des boucles for et foreach. C'est une approche pédagogique qui permet de comprendre les algorithmes de base. Cependant, en production et dans un code professionnel, PHP met à disposition un ensemble riche de fonctions natives pour manipuler les tableaux de manière optimisée.

Ces fonctions natives présentent plusieurs avantages majeurs. Elles sont implémentées en C au niveau du moteur PHP, ce qui les rend plus rapides que les boucles écrites en PHP. Elles rendent le code plus court, plus lisible et plus expressif. Elles réduisent les risques d'erreurs algorithmiques comme les erreurs d'index ou les boucles infinies. Enfin elles constituent un vocabulaire commun entre développeurs PHP.  
2.2 array\_filter   Filtrer un tableau  
array\_filter parcourt un tableau et retourne un nouveau tableau contenant uniquement les éléments pour lesquels la fonction de rappel retourne vrai. Les clés du tableau original sont préservées, ce qui peut nécessiter un appel à array\_values pour réindexer.

Signature

array\_filter(array $tableau, callable $callback, int $mode \= 0): array

Comparaison Partie A vs Partie B

// Partie A   boucle manuelle dans validator.php

function validerExistenceTelephone(string $telephone): int {

    global $wallets;

    for ($i \= 0; $i \< count($wallets); $i++) {

        if ($wallets\[$i\]\['telephone'\] \=== $telephone) {

            return 2;

        }

    }

    return \-7;

}

// Partie B   array\_filter dans validator.php

function validerExistenceTelephone(string $telephone): int {

    global $wallets;

    $trouve \= array\_filter($wallets, fn($w) \=\> $w\['telephone'\] \=== $telephone);

    if (count($trouve) \=== 0\) {

        return \-7;

    }

    return 2;

}

Exemple avec le mode ARRAY\_FILTER\_USE\_BOTH

$messages \= \[

    \-1 \=\> "Longueur invalide",

    \-2 \=\> "Préfixe invalide",

    \-7 \=\> "Téléphone inexistant",

\];

$code \= \-2;

$trouve \= array\_filter($messages, fn($valeur, $cle) \=\> $cle \=== $code, ARRAY\_FILTER\_USE\_BOTH);

// Résultat : \[-2 \=\> "Préfixe invalide"\]  
2.3 array\_map   Transformer un tableau  
array\_map applique une fonction de rappel à chaque élément d'un tableau et retourne un nouveau tableau contenant les valeurs transformées. Contrairement à array\_filter, array\_map ne supprime pas d'éléments, il les transforme tous.

Signature

array\_map(callable $callback, array $tableau): array

Comparaison Partie A vs Partie B

// Partie A   boucle manuelle dans services.php

function listerTransactions(): array {

    $transactions \= obtenirTransactions();

    $resultat \= \[\];

    for ($i \= 0; $i \< count($transactions); $i++) {

        $telephone \= obtenirTelephoneParIndex($transactions\[$i\]\['indexClient'\]);

        $wallet \= trouverWalletParTelephone($telephone);

        $type \= 'Dépôt';

        if ($transactions\[$i\]\['montant'\] \< 0\) {

            $type \= 'Retrait';

        }

        $resultat\[\] \= \[

            'type'    \=\> $type,

            'montant' \=\> $transactions\[$i\]\['montant'\],

            'frais'   \=\> $transactions\[$i\]\['frais'\],

            'client'  \=\> $wallet\['client'\]

        \];

    }

    return $resultat;

}

// Partie B   array\_map dans services.php

function listerTransactions(): array {

    $transactions \= obtenirTransactions();

    return array\_map(function($t) {

        $telephone \= obtenirTelephoneParIndex($t\['indexClient'\]);

        $wallet \= trouverWalletParTelephone($telephone);

        $type \= $t\['montant'\] \> 0 ? 'Dépôt' : 'Retrait';

        return \[

            'type'    \=\> $type,

            'montant' \=\> $t\['montant'\],

            'frais'   \=\> $t\['frais'\],

            'client'  \=\> $wallet\['client'\]

        \];

    }, $transactions);

}  
2.4 array\_search   Rechercher une valeur  
array\_search cherche une valeur dans un tableau et retourne la clé correspondante si elle est trouvée, ou false si elle n'est pas trouvée. La comparaison est stricte si le troisième paramètre est true.

Signature

array\_search(mixed $valeur, array $tableau, bool $strict \= false): int|string|false

Comparaison Partie A vs Partie B

// Partie A   boucle manuelle dans repository.php

function trouverIndexParTelephone(string $telephone): int {

    global $wallets;

    for ($i \= 0; $i \< count($wallets); $i++) {

        if ($wallets\[$i\]\['telephone'\] \=== $telephone) {

            return $i;

        }

    }

    return \-7;

}

// Partie B   array\_search \+ array\_column dans repository.php

function trouverIndexParTelephone(string $telephone): int {

    global $wallets;

    $index \= array\_search($telephone, array\_column($wallets, 'telephone'));

    if ($index \=== false) {

        return \-7;

    }

    return $index;

}  
2.5 array\_column   Extraire une colonne  
array\_column extrait les valeurs d'une colonne spécifique d'un tableau multidimensionnel. Elle est très utile pour récupérer tous les identifiants, tous les noms ou toutes les valeurs d'un champ particulier.

Signature

array\_column(array $tableau, string|int|null $cle): array

Exemple dans le projet

$wallets \= \[

    0 \=\> \['client' \=\> 'Baila Wane',  'telephone' \=\> '778939021', 'solde' \=\> 0\],

    1 \=\> \['client' \=\> 'Mame Fatou',  'telephone' \=\> '783245609', 'solde' \=\> 30000\],

\];

$telephones \= array\_column($wallets, 'telephone');

// Résultat : \['778939021', '783245609'\]

// Utilisé en combinaison avec array\_search

$index \= array\_search('783245609', array\_column($wallets, 'telephone'));

// Résultat : 1  
2.6 array\_push   Ajouter un élément  
array\_push ajoute un ou plusieurs éléments à la fin d'un tableau. Elle modifie le tableau original par référence.

Signature

array\_push(array &$tableau, mixed ...$valeurs): int

Comparaison Partie A vs Partie B

// Partie A

$wallets\[\] \= $wallet;

// Partie B

array\_push($wallets, $wallet);

Les deux approches sont fonctionnellement équivalentes. La Partie B utilise array\_push pour se conformer à l'utilisation explicite des fonctions natives.  
2.7 array\_values   Réindexer un tableau  
Après un array\_filter, les clés du tableau original sont conservées, ce qui peut créer des gaps dans les indices. array\_values retourne un nouveau tableau avec des clés numériques consécutives démarrant à 0\.

Exemple

$wallets \= \[

    0 \=\> \['telephone' \=\> '778939021'\],

    1 \=\> \['telephone' \=\> '783245609'\],

    2 \=\> \['telephone' \=\> '776543876'\],

\];

// Après array\_filter, les clés 0 et 2 sont conservées, la clé 1 est absente

$filtre \= array\_filter($wallets, fn($w) \=\> $w\['telephone'\] \!== '783245609');

// Résultat : \[0 \=\> \[...\], 2 \=\> \[...\]\]

// array\_values réindexe proprement

$reindexe \= array\_values($filtre);

// Résultat : \[0 \=\> \[...\], 1 \=\> \[...\]\]

Utilisation dans le projet

// repository.php   Partie B

function trouverWalletParTelephone(string $telephone): array {

    global $wallets;

    $trouve \= array\_filter($wallets, fn($w) \=\> $w\['telephone'\] \=== $telephone);

    return array\_values($trouve)\[0\];

    // array\_values garantit que l'indice 0 existe bien

}  
2.8 Tableau récapitulatif des fonctions utilisées

| Fonction | Rôle | Fichier utilisé |
| :---- | :---- | :---- |
| array\_filter | Filtrer les éléments selon une condition | validator.php, repository.php, controller.php |
| array\_map | Transformer chaque élément du tableau | services.php |
| array\_search | Chercher la clé d'une valeur | repository.php |
| array\_column | Extraire une colonne d'un tableau | repository.php |
| array\_push | Ajouter un élément en fin de tableau | repository.php |
| array\_values | Réindexer après un filtre | repository.php, services.php |

3\. Composer   Le Gestionnaire de Dépendances PHP  
3.1 Définition et rôle  
Composer est le gestionnaire de dépendances officiel et standard de PHP. Il a été créé en 2012 par Nils Adermann et Jordi Boggiano et est depuis devenu un outil incontournable de l'écosystème PHP moderne.

Son rôle principal est de permettre à un projet PHP de déclarer les bibliothèques externes dont il dépend, puis de les installer et de les gérer de manière automatisée. Avant Composer, les développeurs devaient télécharger manuellement les bibliothèques, gérer leurs versions et résoudre eux-mêmes les conflits de dépendances. Composer automatise tout ce processus.

Composer fonctionne sur le principe de la déclaration des dépendances dans un fichier composer.json et résout automatiquement l'arbre de dépendances, c'est-à-dire que si une bibliothèque A dépend elle-même d'une bibliothèque B, Composer installe les deux automatiquement.  
3.2 Installation  
\# Télécharger et installer Composer globalement sur Linux/Mac

curl \-sS https://getcomposer.org/installer | php

sudo mv composer.phar /usr/local/bin/composer

\# Vérifier l'installation

composer \--version

\# Résultat : Composer version 2.x.x  
3.3 Initialiser un projet  
La commande composer init lance un assistant interactif qui génère le fichier composer.json en posant des questions sur le projet.

composer init

Exemple de composer.json généré pour le projet E-Wallet :

{

    "name": "mame/projet-wallet",

    "description": "Système de Gestion de Portefeuille Électronique en PHP",

    "type": "project",

    "require": {

        "php": "\>=8.0"

    },

    "autoload": {

        "psr-4": {

            "EWallet\\\\": "src/"

        }

    }

}  
3.4 Installer et gérer les dépendances  
Installer une nouvelle dépendance

composer require monolog/monolog

Cette commande télécharge le package, l'ajoute à composer.json sous la clé require et met à jour composer.lock.

Installer une dépendance de développement uniquement

composer require \--dev phpunit/phpunit

Les dépendances de développement sont ajoutées sous la clé require-dev et ne sont pas installées en production.

Installer toutes les dépendances d'un projet existant

composer install

Cette commande lit composer.lock et installe exactement les versions spécifiées, garantissant la reproductibilité de l'environnement.

Mettre à jour les dépendances

composer update  
3.5 Les fichiers générés par Composer  
composer.json est le fichier de configuration du projet. Il déclare les dépendances requises, les versions acceptées et la configuration de l'autoloader. C'est le fichier que le développeur édite.

composer.lock est généré automatiquement et contient les versions exactes de chaque package installé, y compris les dépendances des dépendances. Ce fichier garantit que tous les développeurs d'une équipe utilisent exactement les mêmes versions. Il doit être versionné avec Git.

vendor/ est le dossier dans lequel Composer installe tous les packages. Ce dossier ne doit jamais être versionné avec Git car il peut être régénéré avec composer install.  
3.6 L'autoloader de Composer  
L'un des atouts majeurs de Composer est son système d'autoloading. Après installation, il suffit d'inclure un seul fichier pour que toutes les classes et fonctions des packages installés soient disponibles automatiquement.

\<?php

require 'vendor/autoload.php';

// Toutes les dépendances sont maintenant disponibles

use Monolog\\Logger;

use Monolog\\Handler\\StreamHandler;

$logger \= new Logger('ewallet');

$logger-\>pushHandler(new StreamHandler('app.log', Logger::WARNING));

$logger-\>warning('Tentative de retrait avec solde insuffisant');  
3.7 Commandes essentielles de Composer

| Commande | Description |
| :---- | :---- |
| composer init | Initialiser un nouveau projet et générer composer.json |
| composer require vendor/package | Installer un package et l'ajouter à composer.json |
| composer require \--dev vendor/package | Installer un package uniquement en développement |
| composer install | Installer toutes les dépendances depuis composer.lock |
| composer update | Mettre à jour toutes les dépendances vers leurs dernières versions |
| composer dump-autoload | Régénérer le fichier d'autoloading |
| composer show | Lister tous les packages installés |
| composer remove vendor/package | Désinstaller un package |

---

4\. Packagist.org   L'Écosystème des Packages PHP  
4.1 Définition  
Packagist.org est le dépôt central et officiel de packages PHP. C'est le registre que Composer interroge par défaut lorsqu'on exécute composer require. Il joue pour PHP le même rôle que npm pour JavaScript ou PyPI pour Python.

Lancé en 2012 en parallèle de Composer, Packagist référence aujourd'hui plus de 350 000 packages et héberge des milliards de téléchargements. Il est entièrement gratuit et ouvert à tous les développeurs.  
4.2 Comment fonctionne Packagist  
Quand un développeur exécute composer require monolog/monolog, Composer contacte Packagist pour obtenir les informations sur le package demandé : versions disponibles, dépendances de ce package, URL du code source sur GitHub ou GitLab. Composer télécharge ensuite le code source directement depuis le dépôt Git référencé.

Développeur exécute composer require monolog/monolog

                    ↓

Composer interroge Packagist.org

                    ↓

Packagist retourne les métadonnées du package (versions, dépendances)

                    ↓

Composer télécharge le code depuis GitHub

                    ↓

Package installé dans le dossier vendor/  
4.3 Structure d'un nom de package  
Chaque package Packagist suit la convention vendor/package où vendor est le nom de l'auteur ou de l'organisation et package est le nom du projet.

monolog/monolog

└── vendor : monolog (l'organisation)

└── package : monolog (le nom du package)

symfony/console

└── vendor : symfony (le framework)

└── package : console (le composant)  
4.4 Packages populaires de l'écosystème PHP  
Logging et débogage

| Package | Description |
| :---- | :---- |
| monolog/monolog | Bibliothèque de logs la plus utilisée en PHP |
| symfony/var-dumper | Affichage amélioré des variables pour le débogage |

HTTP et API

| Package | Description |
| :---- | :---- |
| guzzlehttp/guzzle | Client HTTP pour consommer des API REST |
| slim/slim | Micro-framework PHP pour créer des API |

Base de données

| Package | Description |
| :---- | :---- |
| doctrine/dbal | Couche d'abstraction de base de données |
| illuminate/database | ORM Eloquent de Laravel utilisable indépendamment |

Tests

| Package | Description |
| :---- | :---- |
| phpunit/phpunit | Framework de tests unitaires standard PHP |
| fakerphp/faker | Génération de données de test réalistes |

Utilitaires

| Package | Description |
| :---- | :---- |
| vlucas/phpdotenv | Gestion des variables d'environnement via .env |
| ramsey/uuid | Génération d'identifiants uniques UUID |

4.5 Comment publier un package sur Packagist  
Un développeur qui souhaite partager sa bibliothèque avec la communauté PHP peut la publier sur Packagist en suivant ces étapes.

La première étape consiste à créer un dépôt Git public sur GitHub ou GitLab contenant le code du package avec un fichier composer.json valide déclarant le nom, la description et les dépendances du package.

La deuxième étape est de s'inscrire sur packagist.org et de soumettre l'URL du dépôt Git. Packagist indexe automatiquement le package et le rend disponible pour tous les utilisateurs de Composer.

La troisième étape est optionnelle mais recommandée : configurer un webhook GitHub qui notifie Packagist automatiquement à chaque nouveau commit ou tag, permettant à Packagist de mettre à jour les informations du package en temps réel.

// composer.json d'un package publié sur Packagist

{

    "name": "mame/ewallet-utils",

    "description": "Utilitaires pour le projet E-Wallet",

    "type": "library",

    "license": "MIT",

    "require": {

        "php": "\>=8.0"

    },

    "autoload": {

        "psr-4": {

            "EWallet\\\\": "src/"

        }

    }

}  
4.6 Lien avec le projet E-Wallet  
Bien que notre projet E-Wallet n'utilise pas de packages externes dans sa version actuelle (les données sont stockées en mémoire et aucune bibliothèque n'est requise), Composer et Packagist deviendraient indispensables dans une version évoluée du projet.

Par exemple, pour persister les données dans une base de données, on pourrait utiliser doctrine/dbal. Pour journaliser les transactions, on utiliserait monolog/monolog. Pour tester le code, on intégrerait phpunit/phpunit. Pour une version avec interface HTTP, on utiliserait slim/slim.

\# Exemple d'initialisation du projet E-Wallet avec Composer

composer init

composer require monolog/monolog

composer require \--dev phpunit/phpunit

Conclusion  
Ce projet E-Wallet a permis de mettre en pratique une progression naturelle du code PHP. La Partie A a posé les bases algorithmiques en manipulant les structures de données manuellement, sans abstraction. La Partie B a introduit les outils professionnels qui rendent le code plus expressif, plus maintenable et plus conforme aux standards de l'industrie.

Les fonctions anonymes, les arrow functions et les closures permettent d'écrire des callbacks concis et lisibles. Les fonctions natives array\_\* éliminent la verbosité des boucles manuelles et rendent l'intention du code immédiatement claire. Composer et Packagist constituent l'infrastructure standard de tout projet PHP professionnel, permettant de ne pas réinventer la roue et de s'appuyer sur des bibliothèques éprouvées par la communauté.

La maîtrise de ces concepts est aujourd'hui une compétence fondamentale pour tout développeur PHP qui souhaite travailler sur des projets réels en entreprise.  
