<?php
class DantriCrawler extends VnexpressCrawler
{
    function getDate()
    {
        return matchesDate("/<span class=\"fr fon7 mr2 tt-capitalize\">(\n|\r)\s+(.*?)(\n|\r)\s+<\/span>/", 0, $this->html);
    }
    function getContent()
    {
        return matchesContent("/<div id=\"divNewsContent\" class=\"fon34 mt3 mr2 fon43 detail-content\">(.*?)<div id=\"div_tamlongnhanai\"><\/div>/s", "/<p>(.*?)<\/p>/s", $this->html);
    }
}
