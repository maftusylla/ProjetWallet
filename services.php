<?php

namespace EWallet\Services;

use function EWallet\Validator\validerChampObligatoire;
use function EWallet\Validator\validerLongueur;
use function EWallet\Validator\validerPrefixe;
use function EWallet\Validator\validerUnicite;
use function EWallet\Validator\validerSoldeInitial;
use function EWallet\Validator\validerMontant;
use function EWallet\Validator\validerExistenceTelephone;
use function EWallet\Validator\validerSoldeSuffisant;
use function EWallet\Repository\ajouterWallet;
use function EWallet\Repository\trouverIndexParTelephone;
use function EWallet\Repository\trouverWalletParTelephone;
use function EWallet\Repository\mettreAJourSolde;
use function EWallet\Repository\ajouterTransaction;
use function EWallet\Repository\obtenirTransactions;
use function EWallet\Repository\obtenirTransactionsParTelephone;
use function EWallet\Repository\obtenirTelephoneParIndex;

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

function faireDepot(string $telephone, int $montant): int {
    $existence = validerExistenceTelephone($telephone);
    if ($existence < 2) {
        return $existence;
    }
    $montantValide = validerMontant($montant);
    if ($montantValide < 2) {
        return $montantValide;
    }
    $wallet = trouverWalletParTelephone($telephone);
    $nouveauSolde = $wallet['solde'] + $montant;
    mettreAJourSolde($telephone, $nouveauSolde);
    $index = trouverIndexParTelephone($telephone);
    ajouterTransaction([
        'montant'     => $montant,
        'frais'       => 0,
        'indexClient' => $index
    ]);
    return 2;
}

function faireRetrait(string $telephone, int $montant): int {
    $existence = validerExistenceTelephone($telephone);
    if ($existence < 2) {
        return $existence;
    }
    $montantValide = validerMontant($montant);
    if ($montantValide < 2) {
        return $montantValide;
    }
    $solde = validerSoldeSuffisant($telephone, $montant);
    if ($solde < 2) {
        return $solde;
    }
    $frais = calculerFrais($montant);
    $wallet = trouverWalletParTelephone($telephone);
    $nouveauSolde = $wallet['solde'] - $montant - $frais;
    mettreAJourSolde($telephone, $nouveauSolde);
    $index = trouverIndexParTelephone($telephone);
    ajouterTransaction([
        'montant'     => -$montant,
        'frais'       => $frais,
        'indexClient' => $index
    ]);
    return 2;
}

function listerTransactions(): array {
    $transactions = obtenirTransactions();
    return array_map(function($t) {
        $telephone = obtenirTelephoneParIndex($t['indexClient']);
        $wallet = trouverWalletParTelephone($telephone);
        $type = $t['montant'] > 0 ? 'Dépôt' : 'Retrait';
        return [
            'type'    => $type,
            'montant' => $t['montant'],
            'frais'   => $t['frais'],
            'client'  => $wallet['client']
        ];
    }, $transactions);
}

function listerTransactionsParTelephone(string $telephone): array {
    $existence = validerExistenceTelephone($telephone);
    if ($existence < 2) {
        return [];
    }
    $transactions = obtenirTransactionsParTelephone($telephone);
    $wallet = trouverWalletParTelephone($telephone);
    return array_map(function($t) use ($wallet) {
        $type = $t['montant'] > 0 ? 'Dépôt' : 'Retrait';
        return [
            'type'    => $type,
            'montant' => $t['montant'],
            'frais'   => $t['frais'],
            'client'  => $wallet['client']
        ];
    }, $transactions);
}