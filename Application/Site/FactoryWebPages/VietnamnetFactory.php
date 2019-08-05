<?php

class VietnamnetFactory extends PagesFactory
{
    public function makePages(): InterfaceGetData
    {
        return new Vietnamnet($this->html);
    }
}
