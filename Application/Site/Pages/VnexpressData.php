<?php

class VnexpressData extends PagesFactory
{
    public function makePages(): InterfaceGetData
    {
        return new Vnexpress($this->html);
    }
}
