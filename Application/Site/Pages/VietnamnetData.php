<?php

class VietnamnetData extends PagesFactory
{
    public function creatWebsite(): InterfaceGetData
    {
        return new Vietnamnet($this->html);
    }
}
