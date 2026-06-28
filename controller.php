<?php

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
    for ($i = -1; $i >= -9; $i--) {
        if ($i === $code) {
            return $messages[$i];
        }
    }
    return "Erreur inconnue";
}

function controllerCreerWallet(): void {
    $client    = readline("Veuillez entrez le nom du client : ");
    $telephone = readline("Veuillez entrez un numéro de téléphone : ");
    $code      = (int) readline("Veuillez saisir votre code secret (4 chiffres) : ");
    $solde     = (int) readline("Veuillez entrez votre solde initial : ");

    $resultat = creerWallet($client, $telephone, $code, $solde);

    if ($resultat < 2) {
        echo "Erreur : " . message($resultat) . "\n";
        return;
    }
    echo "Wallet créé avec succès !\n";
}

