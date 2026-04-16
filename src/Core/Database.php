<?php
namespace App\Core;
use PDO;

class Database {
    protected $pdo;
    
    public function __construct() {
        $env = parse_ini_file(__DIR__ . '/../../.env');
        
        $host = $env['DB_HOST'];
        $dbname = $env['DB_NAME'];
        $user = $env['DB_USER'];
        $pass = $env['DB_PASS'];

        $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}