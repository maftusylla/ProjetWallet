<?php

function calculerFrais(int $montant): int {
    if ($montant <= 10000) {
        return 200;
    }
    if ($montant <= 100000) {
        return 500;
    }
    $frais = (int)($montant * 0.01);
    if ($frais > 5000) {
        return 5000;
    }
    return $frais;
}

function creerWallet(string $client, string $telephone, int $code, int $solde): int {
    $nomValide = validerChampObligatoire($client);
    if ($nomValide < 2) {
        return -9;
    }
    $longueurTel = validerLongueur($telephone, 9);
    if ($longueurTel < 2) {
        return $longueurTel;
    }
    $prefixe = validerPrefixe($telephone);
    if ($prefixe < 2) {
        return $prefixe;
    }
    $longueurCode = validerLongueur((string)$code, 4);
    if ($longueurCode < 2) {
        return $longueurCode;
    }
    $unicite = validerUnicite($telephone, $code);
    if ($unicite < 2) {
        return $unicite;
    }
    $soldeInitial = validerSoldeInitial($solde);
    if ($soldeInitial < 2) {
        return $soldeInitial;
    }
    ajouterWallet([
        'client'    => $client,
        'telephone' => $telephone,
        'code'      => $code,
        'solde'     => $solde
    ]);
    return 2;
}

