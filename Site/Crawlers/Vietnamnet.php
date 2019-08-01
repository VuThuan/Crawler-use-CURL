<?php
class VietnamnetCrawler extends VnexpressCrawler
{
    public function getDate()
    {
        return $this->matchesDate("/<p class=\"time-zone\">(.*?)+(\n|\r)\s+<\/p>/", 0);
    }
    public function getImage()
    {
        return $this->matchesImage("/<meta property=\"og:image\" content=\"(.*?)\" \/>/s");
    }
    function getContent()
    {
        return $this->matchesContent("/<div id=\"ArticleContent\" class=\"ArticleContent\">(.*?)<div class=\"inner-article\">/s", "/<p>(.*?)<\/p>/s");
    }
}
