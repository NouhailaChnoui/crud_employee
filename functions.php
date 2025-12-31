<?php
function updateEmployeeDataByIndex($index, $updated_data, $file_path) {
    $data_array = read_json_file($file_path);
    if ($data_array !== false) {
        $data_array[$index] = $updated_data;
        $json_data = json_encode($data_array, JSON_PRETTY_PRINT);
        file_put_contents($file_path, $json_data);
        return true;
    } else {
        return false;
    }
}

function reads_json_file($file_path)
{
    // Chouf wach fichier kayn
    if (!file_exists($file_path)) {
        // Ma kaynsh fichier, dir false
        return false;
    }
    
    // Lire data men fichier
    $json_data = file_get_contents($file_path);

    // Chouf wach llecture kayna
    if ($json_data === false) {
        // Ma kaynsh lecture, dir false
        return false;
    }

    // Rja3 data li ktebna
    return $json_data;
}

function read_json_file($file_path)
{
    // Chouf wach fichier kayn
    if (!file_exists($file_path)) {
        // Ma kaynsh fichier, dir false
        return false;
    }

    // Lire data men fichier
    $json_data = file_get_contents($file_path);
    
    // kn7awlo fil json ltableau associatif
    $formatted_data_array = json_decode($json_data, true);

    // Chouf wach  data kayna
    if ($formatted_data_array === null) {
        // Ma kaynsh  dir false
        return false;
    }

    // Rja3 data 
    return $formatted_data_array;
}
// ktchof lina lse donnees fi fichier json kola whd bi index dyalo 
function getEmployeeDataByIndex($index, $file_path) {
    // NAkhod data m fichier
    $data_array = read_json_file($file_path);
    // Chouf wach data kayna
    if ($data_array !== false) {
        // Chouf wach kayna index 
        if (isset($data_array[$index])) {
            // Rja3 data dyal l index
            return $data_array[$index];
        } else {
            // Ma kaynsh index  dir false
            return false; 
        }
    } else {
        // Ma kaynsh data, dir false
        return false;
}
}

function traduire_elements_en_francais($element)
{
    return match ($element) {
        "first_name" => "prénom",
        "last_name" => "nom",
        "email" => "email",
        "age" => "âge",
        "phone" => "téléphone",
        "marital_status" => "état civil",
        "gender" => "genre",
        "city" => "ville",
        "street" => "rue",
        "zip" => "code postal",
        "title" => "titre",
        "company" => "entreprise",
        "industry" => "industrie",
        default => $element
    };
}