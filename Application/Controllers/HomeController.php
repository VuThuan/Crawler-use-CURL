<?php

class HomeController
{
    public function index()
    {
        include APP . "/views/_templace/header.php";
        include APP . "/views/home/index.php";
        include APP . "/views/_templace/footer.php";
    }
}
