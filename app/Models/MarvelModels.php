<?php

namespace App\Models;
use CodeIgniter\Model;
use mysqli;

error_reporting(E_ALL);
ini_set('display_errors', 1);

class MarvelModels extends Model
    {
    public function insertCharacterData($character, $host, $username, $password, $database, $tableName) {
        $conn = new mysqli($host, $username, $password, $database);
        if ($conn->connect_error) {
            return "Connection failed: " . $conn->connect_error;
        }
        
        $stmt = $conn->prepare("INSERT INTO $tableName (id, nombre, descripcion) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $id, $name, $description);
        $id = $character['id'];
        $name = $character['name'];
        $description = $character['description'];
        $insertado = false;
        if ($stmt->execute()) {
            $insertado = true;
        }        
        $stmt->close();
        $conn->close();
        return $insertado;
    }


    public function deleteCharacterData($id, $host, $username, $password, $database, $tableName) {
        $conn = new mysqli($host, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("DELETE FROM $tableName WHERE id = ?");
        $stmt->bind_param("i", $id);
        $eliminado = false;
        if ($stmt->execute()) {
            $eliminado = true;
        }       
        $stmt->close();
        $conn->close();
        return $eliminado;
    }

    public function validarMySQL($id, $host, $username, $password, $database, $tableName) {
        $conn = new mysqli($host, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("SELECT * FROM $tableName WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $character = $result->fetch_assoc();
        $stmt->close();
        $conn->close();

        return $character;
    }
    public function buscarMySQL($searchTerm, $host, $username, $password, $database, $tableName) {
        $conn = new mysqli($host, $username, $password, $database);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $stmt = $conn->prepare("SELECT * FROM $tableName WHERE LOWER(nombre) LIKE LOWER(?)");
        $searchTerm = '%' . $searchTerm . '%';
        $stmt->bind_param("s", $searchTerm);
        $stmt->execute();
        $result = $stmt->get_result();
        $characters = [];
        while ($row = $result->fetch_assoc()) {
            if(isset($row['ID'])) {
                $characters[] = [
                    'id' => $row['ID'],
                    'nombre' => $row['Nombre'],
                    'descripcion' => $row['Descripcion'],
                ];
            }
        }
        $stmt->close();
        $conn->close();
        
        return $characters;
    }



    
    public function searchMarvelApi($timestamp, $publicKey, $privateKey, $searchTerm) {
    
            $keys = $privateKey . $publicKey;
            $string = $timestamp . $keys;
            $md5 = hash('md5', $string);
            $url = "http://gateway.marvel.com/v1/public/characters?ts=$timestamp&apikey=$publicKey&hash=$md5&nameStartsWith=$searchTerm";
            $ch = curl_init();
        
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        
            $output = curl_exec($ch) or die(curl_error($ch));
            curl_close($ch);
            $data = json_decode($output, true);
        
            return isset($data['data']['results']) ? $data['data']['results'] : array();
    }
    public function ejecutarModelo($data,$metodo)
    {
        $publicKey= '1a95e84b5b775fe6acf71f03b0ad24dc';
        $privateKey= '0a97efd3b1c43a76dfa683923116b2a2fac0384b';
        $timestamp = time();
        $host = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'marvel';
        $tableName = 'personajes';

        switch ($metodo) {
            case 1:
                if (!empty($data)) {
                    $searchResults = MarvelModels::searchMarvelApi($timestamp, $publicKey, $privateKey, $data);

                    if (!empty($searchResults)) {
                        $characters = array_map(function($character) {
                            return array('id' => $character['id'], 'name' => $character['name'], 'description' => $character['description']);
                        }, $searchResults);
                        return $characters;
                    }
                }
                break;
            case 2:
                if(MarvelModels::insertCharacterData($data, $host, $username, $password, $database, $tableName)){
                    return 'Personaje insertado correctamente';
                }
                return 'Error al insertar personaje';
            case 3:
                if(MarvelModels::deleteCharacterData($data, $host, $username, $password, $database, $tableName)){
                    return 'Personaje eliminado correctamente';
                }
                return 'Error al eliminar personaje';
            case 4:
                $characters = MarvelModels::validarMySQL($data, $host, $username, $password, $database, $tableName);
                $existe = false;
                if(!empty($characters)){
                    $existe = true;
                }
                return $existe;
            case 5:
                if (!empty($data)) {
                    $searchResults = MarvelModels::buscarMySQL($data, $host, $username, $password, $database, $tableName);
                    if (!empty($searchResults)) {
                        $characters = array_map(function($character) {
                            return array('id' => $character['id'], 'name' => $character['nombre'], 'description' => $character['descripcion']);
                        }, $searchResults);
                        return $characters;
                    }
                }
                break;
        }
    }
    
}