<?php

class VietnamnetData extends PagesFactory
{
    public function makePages(): InterfaceGetData
    {
        return new Vietnamnet($this->html);
    }
}
