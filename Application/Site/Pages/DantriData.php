<?php

class DantriData extends PagesFactory
{
    public function creatWebsite(): InterfaceGetData
    {
        return new Dantri($this->html);
    }
}
