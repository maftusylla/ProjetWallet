<?php

namespace EWallet\Controller;

use function EWallet\Services\creerWallet;
use function EWallet\Services\faireDepot;
use function EWallet\Services\faireRetrait;
use function EWallet\Services\listerTransactions;
use function EWallet\Services\listerTransactionsParTelephone;

function message(int $code): string {
    $messages = [
        -1 => "La longueur du numéro ou du code est invalide ",
        -2 => "Préfixe du numéro est invalide ",
        -3 => "Ce numéro de télèphone existe dèjà ",
        -4 => "Ce code existe dèjà ",
        -5 => "Veuillez entrez un solde valide ",
        -6 => "Veuillez entrez un montant valide ",
        -7 => "Ce numéro de télèphone n'existe pas ",
        -8 => "Votre solde est insuffisant ",
        -9 => "Le nom du client est  obligatoire "
    ];
    if (isset($messages[$code])) {
    return $messages[$code];
}
    return "Erreur inconnue";
}
function afficherTransactions(array $transactions): void {
    if (count($transactions) === 0) {
        echo "Aucune transaction trouvée\n";
        return;
    }
    foreach ($transactions as $transaction){
        echo "----------------------------\n";
        echo "Type      : " . $transactions[$i]['type'] . "\n";
        echo "Montant   : " . $transactions[$i]['montant'] . " CFA\n";
        echo "Titulaire : " . $transactions[$i]['client'] . "\n";
        echo "Frais     : " . $transactions[$i]['frais'] . " CFA\n";
    }
   
}

function controllerCreerWallet(): void { 

    $client    = readline("Veuillez entrez le nom du client : ");
    $telephone = readline("Veuillez entrez un numéro de téléphone : ");
    $code      = (int) readline("Veuillez saisir votre code secret (4 chiffres) : ");
    $solde     = (int) readline("Veuillez entrez votre solde initial : ");

    
    $resultat  = creerWallet($client, $telephone, $code, $solde);
    if ($resultat < 2) {
        echo "Erreur : " . message($resultat) . "\n";
        return;
    }
    echo "Wallet créé avec succès !\n";
}

function controllerFaireDepot(): void {
    $telephone = readline("Numéro de téléphone : ");
    $montant   = (int) readline("Montant à déposer : ");
    $resultat  = faireDepot($telephone, $montant);
    if ($resultat < 2) {
        echo "Erreur : " . message($resultat) . "\n";
        return;
    }
    echo "Dépôt effectué avec succès !\n";
}

function controllerFaireRetrait(): void {
    $telephone = readline("Veuillez entrez un numéro de téléphone : ");
    $montant   = (int) readline("Veuillez entrez un montant à retirer : ");
    $resultat  = faireRetrait($telephone, $montant);
    if ($resultat < 2) {
        echo "Erreur : " . message($resultat) . "\n";
        return;
    }
    echo "Retrait effectué avec succès !\n";
}

function controllerListerTransactions(): void {
    $choix = readline("1 - Toutes les transactions\n 2 - Par téléphone\nVotre choix : ");
    if ($choix === '1') {
        $transactions = listerTransactions();
        afficherTransactions($transactions);
        return;
    }
    if ($choix === '2') {
        $telephone    = readline("Veuillez entrez un numéro de téléphone : ");
        $transactions = listerTransactionsParTelephone($telephone);
        afficherTransactions($transactions);
        return;
    }
    echo "Choix invalide\n";
}