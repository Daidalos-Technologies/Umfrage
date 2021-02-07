<?php


namespace App\Controller;


class PageController extends \App\Template\Controller
{

    private $question_repository;
    private $result_repository;
    private $poll_repository;

    public function __construct($question_repository, $result_repository, $poll_repository)
    {
        $this->question_repository = $question_repository;
        $this->result_repository = $result_repository;
        $this->poll_repository = $poll_repository;
    }

    public function index()
    {

        $this->render("index", []);

    }
}