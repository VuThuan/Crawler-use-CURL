<?php
class VietnamnetController extends VnexpressController
{
    public function getDate()
    {
        preg_match("/<p class=\"time-zone\">(.*?)+(\n|\r)\s+<\/p>/", $this->html, $date);
        return $date[0];
    }
    public function getImage()
    {
        preg_match_all("/<meta property=\"og:image\" content=\"(.*?)\" \/>/s", $this->html, $image, PREG_SET_ORDER, 0);
        return $image[0][1];
    }
    function getContent()
    {
        preg_match_all("/<div id=\"ArticleContent\" class=\"ArticleContent\">(.*?)<div class=\"inner-article\">/s", $this->html, $matches, PREG_SET_ORDER, 1);

        preg_match_all("/<p>(.*?)<\/p>/s", $matches[0][1], $content, PREG_SET_ORDER, 1);

        $output = '';
        foreach ($content as $para) {
            $output .= $para[0];
        }
        return $output;
    }
}
