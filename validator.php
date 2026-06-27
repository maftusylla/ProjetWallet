<?php

function validerChampObligatoire(string $valeur): int {
    if ($valeur === '') {
        return -9;
    }
    return 2;
}

function validerLongueur(string $valeur, int $longueur): int {
    $chiffres = array_filter(str_split($valeur), fn($c) => $c >= '0' && $c <= '9');
    if (count($chiffres) !== strlen($valeur)) {
        return -1;
    }
    if (strlen($valeur) !== $longueur) {
        return -1;
    }
    return 2;
}

function validerPrefixe(string $telephone): int {
    $prefixesValides = ['70', '75', '76', '77', '78'];
    $prefixe = substr($telephone, 0, 2);
    $trouve = array_filter($prefixesValides, fn($p) => $p === $prefixe);
    if (count($trouve) === 0) {
        return -2;
    }
    return 2;
}

function validerUnicite(string $telephone, int $code): int {
    global $wallets;
    $telExiste = array_filter($wallets, fn($w) => $w['telephone'] === $telephone);
    if (count($telExiste) > 0) {
        return -3;
    }
    $codeExiste = array_filter($wallets, fn($w) => $w['code'] === $code);
    if (count($codeExiste) > 0) {
        return -4;
    }
    return 2;
}

function validerSoldeInitial(int $solde): int {
    if ($solde < 0) {
        return -5;
    }
    return 2;
}

function validerMontant(int $montant): int {
    if ($montant <= 0) {
        return -6;
    }
    return 2;
}

function validerExistenceTelephone(string $telephone): int {
    global $wallets;
    $trouve = array_filter($wallets, fn($w) => $w['telephone'] === $telephone);
    if (count($trouve) === 0) {
        return -7;
    }
    return 2;
}

function validerSoldeSuffisant(string $telephone, int $montant): int {
    global $wallets;
    $trouve = array_filter($wallets, fn($w) => $w['telephone'] === $telephone);
    if (count($trouve) === 0) {
        return -7;
    }
    $wallet = array_values($trouve)[0];
    $frais = calculerFrais($montant);
    if ($wallet['solde'] < $montant + $frais) {
        return -8;
    }
    return 2;
}