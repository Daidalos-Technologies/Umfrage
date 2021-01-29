<?php

namespace App\Entities;

use App\Template\Entity as Entity;

class Question extends Entity
{
       public $id;
       public $title;
       public $content;
       public $answers;
       public $position;
       public $optional;
       public $special;

}