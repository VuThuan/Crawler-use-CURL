<?php
require_once APP . "/Site/Functions/MatchesData.php";

interface InterfaceGetData
{
    public function getTitle();
    public function getDate();
    public function getContent();
    public function getImage();
}
