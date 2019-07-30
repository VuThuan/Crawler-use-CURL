<?php

class VnexpressController extends AbstractAllWebPage
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
        $headerTag = $this->domDocument->getElementsByTagName('header');
        if (count($headerTag) > 0) {
            $date = mysqli_real_escape_string($this->connectDB, $headerTag[2]->nodeValue);
        }
        $dateText = str_replace('\n', '<br>', $date);
        return $dateText;
    }
    public function getContent()
    {
        $content = '';
        $articleTag = $this->domDocument->getElementsByTagName('article');
        if (count($articleTag) > 0) {
            $content = mysqli_real_escape_string($this->connectDB, $articleTag[0]->nodeValue);
        }
        $contentText = str_replace('\n', '<br>', $content);
        return $contentText;
    }
    public function getImage()
    {
        $image = '';
        $metaTags = $this->domDocument->getElementsByTagName('meta');
        foreach ($metaTags as $tag) {
            if ($tag->getAttribute('name') == 'twitter:image') {
                $image = mysqli_real_escape_string($this->connectDB, $tag->getAttribute('content'));
            }
        }
        return $image;
    }

    public function actionForWebsite()
    {
        $url_host = $this->host;
        $url_path = $this->path;
        $title = $this->getTitle();
        $dateText = $this->getDate();
        $image = $this->getImage();
        $contentText = $this->getContent();
        echo '<h2> "' . $title . '"</h2> <br> "' . $dateText . '" <br> <img src="' . $image . '"> <br> "' . $contentText . '"';
        //Insert/Update Page Data
        $query = "INSERT IGNORE INTO pages (path, host, title, image, content, download_time) VALUES (\"" . mysqli_real_escape_string($this->connectDB, $url_path) . "\", \"$url_host \", \"$title\", \"$image\", \"$contentText\",  \"$dateText\") ON DUPLICATE KEY UPDATE host=\"$url_host \", title=\"$title\",image=\"$image\", content=\"$contentText\",  download_time=\"$dateText\"";
        if (!mysqli_query($this->connectDB, $query)) {
            die("<br>Error: Unable to perform Insert Query\n");
        }
    }
}
