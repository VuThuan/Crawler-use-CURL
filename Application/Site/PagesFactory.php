<?php

abstract class PagesFactory
{
    public $html;
    abstract function makeWebsite($param): InterfaceGetData;
}
