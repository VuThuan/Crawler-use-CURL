<?php

class VnexpressData extends PagesFactory
{
    public function makeWebsite($param): InterfaceGetData
    {
        $page = NULL;
        switch ($param) {
            case 'vnexpress':
                $page =  new Vnexpress($this->html);
                break;
            default:
                $page = NULL;
                break;
        }
        return $page;
    }
}
