<?php

namespace App\Repositories;

use App\Template\Repository as Repository;

class QuestionRepository extends Repository
{

    protected $table_name = "questions";
    protected $entity_path = "App\\Entities\\Question";

}