<?php

namespace EWallet\Controller;

use function EWallet\Services\creerWallet;
use function EWallet\Services\faireDepot;
use function EWallet\Services\faireRetrait;
use function EWallet\Services\listerTransactions;
use function EWallet\Services\listerTransactionsParTelephone;

function message(int $code): string {
    $messages = [
        -1 => "Longueur invalide",
        -2 => "Préfixe invalide",
        -3 => "Téléphone déjà utilisé",
        -4 => "Code déjà utilisé",
        -5 => "Solde invalide",
        -6 => "Montant invalide",
        -7 => "Téléphone inexistant",
        -8 => "Solde insuffisant",
        -9 => "Nom du client obligatoire"
    ];
    $trouve = array_filter($messages, fn($v, $k) => $k === $code, ARRAY_FILTER_USE_BOTH);
    if (count($trouve) === 0) {
        return "Erreur inconnue";
    }
    return array_values($trouve)[0];
}

function afficherTransactions(array $transactions): void {
    if (count($transactions) === 0) {
        echo "Aucune transaction trouvée\n";
        return;
    }
    for ($i = 0; $i < count($transactions); $i++) {
        echo "----------------------------\n";
        echo "Type      : " . $transactions[$i]['type'] . "\n";
        echo "Montant   : " . $transactions[$i]['montant'] . " CFA\n";
        echo "Titulaire : " . $transactions[$i]['client'] . "\n";
        echo "Frais     : " . $transactions[$i]['frais'] . " CFA\n";
    }
}

function controllerCreerWallet(): void {
    $client    = readline("Nom du client : ");
    $telephone = readline("Numéro de téléphone : ");
    $code      = (int) readline("Code secret (4 chiffres) : ");
    $solde     = (int) readline("Solde initial : ");
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
    $telephone = readline("Numéro de téléphone : ");
    $montant   = (int) readline("Montant à retirer : ");
    $resultat  = faireRetrait($telephone, $montant);
    if ($resultat < 2) {
        echo "Erreur : " . message($resultat) . "\n";
        return;
    }
    echo "Retrait effectué avec succès !\n";
}

function controllerListerTransactions(): void {
    $choix = readline("1 - Toutes les transactions\n2 - Par téléphone\nVotre choix : ");
    if ($choix === '1') {
        $transactions = listerTransactions();
        afficherTransactions($transactions);
        return;
    }
    if ($choix === '2') {
        $telephone    = readline("Numéro de téléphone : ");
        $transactions = listerTransactionsParTelephone($telephone);
        afficherTransactions($transactions);
        return;
    }
    echo "Choix invalide\n";
}