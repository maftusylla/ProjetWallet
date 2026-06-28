<?php

function validerChampObligatoire(string $valeur): int {
    if ($valeur === '') {
        return -9;
    }
    return 2;
}

function validerLongueur(string $valeur, int $longueur): int {
    $compteur = 0;
    for ($i = 0; $i < strlen($valeur); $i++) {
        if ($valeur[$i] < '0' || $valeur[$i] > '9') {
            return -1;
        }
        $compteur++;
    }
    if ($compteur !== $longueur) {
        return -1;
    }
    return 2;
}

function validerPrefixe(string $telephone): int {
    $prefixesValides = ['70', '75', '76', '77', '78'];
    $prefixe = $telephone[0] . $telephone[1];
    for ($i = 0; $i < 5; $i++) {
        if ($prefixesValides[$i] === $prefixe) {
            return 2;
        }
    }
    return -2;
}

function validerUnicite(string $telephone, int $code): int {
    global $wallets;
    for ($i = 0; $i < count($wallets); $i++) {
        if ($wallets[$i]['telephone'] === $telephone) {
            return -3;
        }
        if ($wallets[$i]['code'] === $code) {
            return -4;
        }
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
    for ($i = 0; $i < count($wallets); $i++) {
        if ($wallets[$i]['telephone'] === $telephone) {
            return 2;
        }
    }
    return -7;
}

