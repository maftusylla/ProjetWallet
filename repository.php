<?php

namespace EWallet\Repository;

function ajouterWallet(array $wallet): void {
    global $wallets;
    array_push($wallets, $wallet);
}

function trouverIndexParTelephone(string $telephone): int {
    global $wallets;
    $index = array_search(
        $telephone,
        array_column($wallets, 'telephone')
    );
    if ($index === false) {
        return -7;
    }
    return $index;
}

function trouverWalletParTelephone(string $telephone): array {
    global $wallets;
    $trouve = array_filter($wallets, fn($w) => $w['telephone'] === $telephone);
    return array_values($trouve)[0];
}

function mettreAJourSolde(string $telephone, int $nouveauSolde): void {
    global $wallets;
    $index = trouverIndexParTelephone($telephone);
    $wallets[$index]['solde'] = $nouveauSolde;
}

function ajouterTransaction(array $transaction): void {
    global $transactions;
    array_push($transactions, $transaction);
}

function obtenirTransactions(): array {
    global $transactions;
    return $transactions;
}

function obtenirTransactionsParTelephone(string $telephone): array {
    global $transactions;
    $index = trouverIndexParTelephone($telephone);
    return array_values(
        array_filter($transactions, fn($t) => $t['indexClient'] === $index)
    );
}

function obtenirTelephoneParIndex(int $index): string {
    global $wallets;
    return $wallets[$index]['telephone'];
}