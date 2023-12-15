<?php


class Conexao {
    private $pdo;

    public function __construct() {
        try {
            $dsn = 'pgsql:dbname=postgres;host=' . getenv('TESTEPHP_POSTGRES_HOST');
            $user = 'postgres';
            $password = getenv('TESTEPHP_POSTGRES_PASSWORD');
            $this->pdo = new PDO($dsn, $user, $password);
        } catch (PDOException $e) {
            echo "Erro de Conexão " . $e->getMessage() . "\n";
            exit;
        }
    }

    public function getPdo() {
        return $this->pdo;
    }
}
