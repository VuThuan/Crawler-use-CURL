<?php
class VietnamnetCrawler extends VnexpressCrawler
{
    public function getDate()
    {
        return matchesDate("/<p class=\"time-zone\">(.*?)+(\n|\r)\s+<\/p>/", 0, $this->html);
    }
    public function getImage()
    {
        return matchesImage("/<meta property=\"og:image\" content=\"(.*?)\" \/>/s", $this->html);
    }
    function getContent()
    {
        return matchesContent("/<div id=\"ArticleContent\" class=\"ArticleContent\">(.*?)<div class=\"inner-article\">/s", "/<p>(.*?)<\/p>/s", $this->html);
    }
}
