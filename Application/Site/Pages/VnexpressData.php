<?php

class VnexpressData extends PagesFactory
{
    public function creatWebsite(): InterfaceGetData
    {
        return new Vnexpress($this->html);
    }
}
