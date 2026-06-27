<?php

require 'validator.php';
require 'repository.php';
require 'services.php';
require 'controller.php';

use function EWallet\Controller\controllerCreerWallet;
use function EWallet\Controller\controllerFaireDepot;
use function EWallet\Controller\controllerFaireRetrait;
use function EWallet\Controller\controllerListerTransactions;

$wallets = [
    0 => ['client' => 'Baila Wane', 'telephone' => '778939021', 'code' => 1234, 'solde' => 0],
    1 => ['client' => 'Mame Fatou', 'telephone' => '783245609', 'code' => 5678, 'solde' => 30000]
];

$transactions = [
    0 => ['montant' => 1000,  'frais' => 0,   'indexClient' => 0],
    1 => ['montant' => -5000, 'frais' => 200, 'indexClient' => 0]
];

do {
    echo "\n** Menu Distributeur **\n";
    echo "1 - Créer Wallet\n";
    echo "2 - Faire Dépôt\n";
    echo "3 - Faire Retrait\n";
    echo "4 - Lister les Transactions\n";
    echo "0 - Quitter\n";

    $choix = readline("Votre choix : ");

    switch ($choix) {
        case '1':
            controllerCreerWallet();
            break;
        case '2':
            controllerFaireDepot();
            break;
        case '3':
            controllerFaireRetrait();
            break;
        case '4':
            controllerListerTransactions();
            break;
        case '0':
            echo "Au revoir !\n";
            break;
        default:
            echo "Choix invalide, veuillez réessayer\n";
    }

} while ($choix !== '0');