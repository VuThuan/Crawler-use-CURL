<?php

namespace core;

use model\Model;

class Controller
{
    /**
     * @var null Database Connection
     */
    public $db = null;

    /**
     * @var null model
     */
    public $model = null;

    public function __construct()
    {
        $this->openDatabaseConnection();
        $this->loadModel();
    }

    public function openDatabaseConnection()
    {
        $this->db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    public function loadModel()
    {
        require APP . "/model/model.php";

        $this->model = new Model($this->db);
    }
}
