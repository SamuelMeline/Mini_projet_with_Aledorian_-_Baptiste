<?php

namespace Libraries\Database;

use PDO;

class Database
{
    protected PDO $pdo;
    
    public function __construct(array $config)
    {
        $this->pdo = new PDO(
            "mysql:host={$config['host']};dbname={$config['dbname']};charset=UTF8",
            $config['user'],
            $config['password'],
            [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }
    
    /**
     * Récupère tous les résultats d'une requête SELECT
     * 
     * @param string $sql
     * @param ?array $parameters
     * @return array
     */
    public function getAll(string $sql, ?array $parameters = null): array
    {
        $query = $this->pdo->prepare($sql);
        $query->execute($parameters);
        return $query->fetchAll();
    }
    
    /**
     * Récupère le premier résultat d'une requête SELECT
     * 
     * @param string $sql
     * @param ?array $parameters
     * @return ?array
     */
    public function getOne(string $sql, ?array $parameters = null): ?array
    {
        $query = $this->pdo->prepare($sql);
        $query->execute($parameters);
        
        $result = $query->fetch();
        
        // Si aucun résultat n'a été trouvé on renvoie la valeur null
        if ($result === false) {
            return null;
        }
        
        return $result;
    }
    
    /**
     * Exécuter une requête INSERT, UPDATE ou DELETE
     * 
     * @param string $sql
     * @param ?array $parameters
     */
    public function execute(string $sql, ?array $parameters = null): void
    {
        $query = $this->pdo->prepare($sql);
        $query->execute($parameters);
    }
}