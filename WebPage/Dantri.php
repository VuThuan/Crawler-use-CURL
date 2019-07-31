<?php
class DantriController extends VnexpressController
{
    function getDate()
    {
        preg_match("/<span class=\"fr fon7 mr2 tt-capitalize\">(\n|\r)\s+(.*?)(\n|\r)\s+<\/span>/", $this->html, $date);
        return $date[0];
    }
    function getContent()
    {
        preg_match_all("/<div id=\"divNewsContent\" class=\"fon34 mt3 mr2 fon43 detail-content\">(.*?)<div id=\"div_tamlongnhanai\"><\/div>/s", $this->html, $matches, PREG_SET_ORDER, 1);

        preg_match_all("/<p>(.*?)<\/p>/s", $matches[0][1], $content, PREG_SET_ORDER, 1);

        $output = '';
        foreach ($content as $para) {
            $output .= $para[0];
        }
        return $output;
    }
}
