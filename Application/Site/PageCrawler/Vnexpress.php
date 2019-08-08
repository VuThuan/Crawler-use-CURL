<?php

class Vnexpress extends MatchesData implements InterfaceGetData
{
    private $html;

    public function __construct($html)
    {
        $this->html = $html;
    }

    public function getTitle()
    {
        preg_match("/<title>(.*?)<\/title>/", $this->html, $title);
        return $title[1];
    }
    public function getDate()
    {
        return $this->matchesDate("/<span+\s+class=\"time\sleft\">(.*?)<\/span>/", 1, $this->html);
    }
    public function getContent()
    {
        preg_match_all("/<p class=\"Normal\">\n(.*?)<\/p>/", $this->html, $content, PREG_SET_ORDER, 0);
        $output = '';
        foreach ($content as $para) {
            $output = $output . $para[0];
        }
        return $output;
    }

    public function getImage()
    {
        return $this->matchesImage("/<meta name=\"twitter:image\" content=\"(.*?)\"(\/)?>/", $this->html);
    }
}
