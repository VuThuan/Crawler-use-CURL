<?php

class DantriFactory extends PagesFactory
{
    public function makePages(): InterfaceGetData
    {
        return new Dantri($this->html);
    }
}
