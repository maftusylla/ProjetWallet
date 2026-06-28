<?php

function ajouterWallet(array $wallet): void {
    global $wallets;
    $wallets[] = $wallet;
}

function trouverIndexParTelephone(string $telephone): int {
    global $wallets;
    for ($i = 0; $i < count($wallets); $i++) {
        if ($wallets[$i]['telephone'] === $telephone) {
            return $i;
        }
    }
    return -7;
}

function trouverWalletParTelephone(string $telephone): array {
    global $wallets;
    $index = trouverIndexParTelephone($telephone);
    return $wallets[$index];
}

function mettreAJourSolde(string $telephone, int $nouveauSolde): void {
    global $wallets;
    $index = trouverIndexParTelephone($telephone);
    $wallets[$index]['solde'] = $nouveauSolde;
}

function ajouterTransaction(array $transaction): void {
    global $transactions;
    $transactions[] = $transaction;
}

function obtenirTransactions(): array {
    global $transactions;
    return $transactions;
}

function obtenirTransactionsParTelephone(string $telephone): array {
    global $transactions;
    $index = trouverIndexParTelephone($telephone);
    $resultat = [];
    for ($i = 0; $i < count($transactions); $i++) {
        if ($transactions[$i]['indexClient'] === $index) {
            $resultat[] = $transactions[$i];
        }
    }
    return $resultat;
}

function obtenirTelephoneParIndex(int $index): string {
    global $wallets;
    return $wallets[$index]['telephone'];
}