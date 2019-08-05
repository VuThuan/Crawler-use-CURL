<?php

class VnexpressFactory extends PagesFactory
{
    public function makePages(): InterfaceGetData
    {
        return new Vnexpress($this->html);
    }
}
