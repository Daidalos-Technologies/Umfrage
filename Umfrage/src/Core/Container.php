<?php

namespace App\Core;

class Container
{

    private $receipts = [];
    private $instances = [];

    public function __construct()
    {
        $this->receipts =
            [
                'pdo' => function () {
                    try {
                        $pdo = new PDO(
                            'mysql:host=antondereroberer.lima-db.de;dbname=db_390976_12;charset=utf8',
                            'USER390976_bot',
                            'AntonderEroberer333#Archimedes333#'
                        );
                    } catch (PDOException $e) {
                        echo "Die Verbindung zur Datenbank konnte nicht hergestellt werden.";
                        die();
                    }
                    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                    return $pdo;
                }
            ];
    }

    public function make($name)
    {
        if (!empty($this->instances[$name])) {
            return $this->instances[$name];
        }

        if (isset($this->receipts[$name])) {
            $this->instances[$name] = $this->receipts[$name]();
        }

        return $this->instances[$name];

    }


}

