<?php


namespace App\Entities;


class Answer extends \App\Template\Entity
{
    public $id;
    public $content;
    public $question_id;
    public $next_position;
    public $next_path;

}