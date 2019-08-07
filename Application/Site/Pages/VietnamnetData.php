<?php

class VietnamnetData extends PagesFactory
{
    public function makeWebsite($param): InterfaceGetData
    {
        $page = NULL;
        switch ($param) {
            case 'vietnamnet':
                $page =  new Vietnamnet($this->html);
                break;
            default:
                $page = NULL;
                break;
        }
        return $page;
    }
}
