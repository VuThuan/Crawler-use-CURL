<?php
class DantriController extends VnexpressController
{
    public function getDate()
    {
        $date = '';
        $para = $this->domDocument->getElementsByTagName('span');
        foreach ($para as $p) {
            if ($p->getAttribute('class') == 'fr fon7 mr2 tt-capitalize') {
                $date = mysqli_real_escape_string($this->connectDB, $p->nodeValue);
            }
        }
        $dateText = str_replace('\n', '<br>', $date);
        return $dateText;
    }
    public function getContent()
    {
        $content = '';
        $articleTag = $this->domDocument->getElementById('divNewsContent');
        $content = mysqli_real_escape_string($this->connectDB, $articleTag->nodeValue);
        $contentText = str_replace('\n', '<br>', $content);
        return $contentText;
    }
}
