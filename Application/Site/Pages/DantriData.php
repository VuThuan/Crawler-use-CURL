<?php

class DantriData extends PagesFactory
{
    public function makeWebsite($param): InterfaceGetData
    {
        $page = NULL;
        switch ($param) {
            case 'dantri':
                $page = new Dantri($this->html);
                break;
            default:
                $page = NULL;
                break;
        }
        return $page;
    }
}
