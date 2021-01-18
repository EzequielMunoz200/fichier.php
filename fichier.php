<?php

//Script à executer
//$php fichier.php "Console"


function searchProduct($argv)
{
    if (!isset($argv[1])) {
        return 'Vous devez fournir le nom du produit. Ex :  "Cuisine conviviale "' . "\n";
    }
    $myFile = fopen('famille.csv', 'r+');

    /* format type
    Meuble,,
    ,Chambre / Literie,
    ,,Armoire
    ,,Commode
    ,,Lit
    ,,Matelas
    ,,Sommier
    ,Cuisine - salle à manger,
    ,,Cuisine conviviale
    ,,Vaisselle
    ,,Linge de table
    ,,Bouilloire
    ,Salon,
    ,,Canapé 
    
    */

    $families = [];
    $product = $argv[1];
    for ($i = 0; $i <= 10000; $i++) {
        // 2 : read
        $line = fgets($myFile);
        if (preg_match('/^[a-zA-Z](.*\,{2}$)/', $line)) {
            $line = trim(str_replace(',', '', $line));
            if (strlen($line) > 0) {
                $lastFamilyLine = $line;
            }
        }
        if (isset($lastFamilyLine)) {
            if (preg_match('/^,{1}[\w\W\s]*\,{1}$/', $line)) {
                $line = trim(str_replace(',', '', $line));
                if (strlen($line) > 0) {
                    $lastSubFamilyLine = $line;
                }
            }

            if (isset($lastSubFamilyLine)) {
                if (preg_match('/^,{2}[\w\W\s][^,]*$/', $line)) {
                    $line = trim(str_replace(',', '', $line));
                    if (strlen($line) > 0) {
                        $families[] = [$lastFamilyLine => [$lastSubFamilyLine => $line]];
                    }
                }
            }
        }
    }

    fclose($myFile);

    foreach ($families as $familyArray) {
        foreach ($familyArray as $family => $subFamily) {
            if (in_array(ucfirst($product), $subFamily)) {
                return  "\n famille =>   $family  \n sous-famille =>  " . key($subFamily) . "\n sous-sous-famille =>  $product \n\n";
            }
        }
    }
}

print_r(searchProduct($argv));
