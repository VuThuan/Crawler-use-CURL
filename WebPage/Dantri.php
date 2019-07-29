<?php
class Dantri extends AbstractAllWebPage
{
    public function getTitle()
    {
        $title = '';
        $titleTags = $this->domDocument->getElementsByTagName('title');
        if (count($titleTags) > 0) {
            $title = mysqli_real_escape_string($this->connectDB, $titleTags[0]->nodeValue);
        }
        return $title;
    }
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
    public function getImage()
    {
        $image = '';
        $metaTags = $this->domDocument->getElementsByTagName('meta');
        foreach ($metaTags as $tag) {
            if ($tag->getAttribute('itemprop') == 'image') {
                $image = mysqli_real_escape_string($this->connectDB, $tag->getAttribute('content'));
            }
        }
        return $image;
    }
    public function doAction()
    {
        $url_host = $this->host;
        $url_path = $this->path;
        if ($url_host == 'dantri.com.vn') {
            $title = $this->getTitle();
            $dateText = $this->getDate();
            $image = $this->getImage();
            $contentText = $this->getContent();
            echo '<h1> "' . $title . '"</h1> <br> "' . $dateText . '" <br> <img src="' . $image . '"> <br> "' . $contentText . '"';
            //Insert/Update Page Data
            $query = "INSERT IGNORE INTO pages (path, host, title, image, content, download_time) VALUES (\"" . mysqli_real_escape_string($this->connectDB, $url_path) . "\", \"$url_host \", \"$title\", \"$image\", \"$contentText\",  \"$dateText\") ON DUPLICATE KEY UPDATE host=\"$url_host \", title=\"$title\",image=\"$image\", content=\"$contentText\",  download_time=\"$dateText\"";
            if (!mysqli_query($this->connectDB, $query)) {
                die("<br>Error: Unable to perform Insert Query\n");
            }
        }
    }
}
