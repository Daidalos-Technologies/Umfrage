<?php

namespace App\Core;

use App\Controller\PageController as PageController;
use App\Repositories\PollRepository as PollRepository;
use PDO;
use App\Controller\PollController as PollController;
use App\Repositories\QuestionRepository as QuestionRepository;
use App\Controller\AdminController as AdminController;
use App\Repositories\ResultRepository as ResultRepository;

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
                            'mysql:host=antondereroberer.lima-db.de;dbname=db_390976_15;charset=utf8',
                            'USER390976_bot',
                            'AntonderEroberer333#Archimedes333#'
                        );
                    } catch (PDOException $e) {
                        echo "Die Verbindung zur Datenbank konnte nicht hergestellt werden.";
                        die();
                    }
                    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                    return $pdo;
                },

                "pollController" => function () {
                    return new PollController($this->make("questionRepository"), $this->make("resultRepository"), $this->make("pollRepository"));
                },
                "questionRepository" => function () {
                    return new QuestionRepository($this->make("pdo"));
                }, "resultRepository" => function () {
                return new ResultRepository($this->make("pdo"));
            }, "adminController" => function () {
                return new AdminController($this->make("questionRepository"), $this->make("resultRepository"), $this->make("pollRepository"));
            },
                "pollRepository" => function() {
                    return new PollRepository($this->make("pdo"));
                }, "pageController" => function () {
                return new PageController($this->make("questionRepository"), $this->make("resultRepository"), $this->make("pollRepository"));
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

