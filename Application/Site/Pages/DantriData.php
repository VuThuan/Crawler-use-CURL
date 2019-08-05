<?php

class DantriData extends PagesFactory
{
    public function makePages(): InterfaceGetData
    {
        return new Dantri($this->html);
    }
}
