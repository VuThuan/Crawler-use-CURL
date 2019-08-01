<?php

class VnexpressCrawler extends AbstractCrawler
{
    public function matchesImage($regex)
    {
        preg_match($regex, $this->html, $image);
        return $image[1];
    }
    public function matchesDate($regex, $key)
    {
        preg_match($regex, $this->html, $date);
        return $date[$key];
    }
    public function matchesContent($regexParent, $regexChild)
    {
        preg_match_all($regexParent, $this->html, $matches, PREG_SET_ORDER, 1);

        preg_match_all($regexChild, $matches[0][1], $content, PREG_SET_ORDER, 1);

        $output = '';
        foreach ($content as $para) {
            $output .= $para[0];
        }
        return $output;
    }

    public function getTitle()
    {
        preg_match("/<title>(.*?)<\/title>/", $this->html, $title);
        return $title[1];
    }
    public function getDate()
    {
        return $this->matchesDate("/<span+\s+class=\"time\sleft\">(.*?)<\/span>/", 1);
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
        return $this->matchesImage("/<meta name=\"twitter:image\" content=\"(.*?)\"(\/)?>/");
    }

    public function doActionforWebsite()
    {
        $url_host = $this->host;
        $url_path = $this->path;
        $title = $this->getTitle();
        $date = $this->getDate();
        $image = $this->getImage();
        $content = $this->getContent();

        echo '<h2> ' . $title . '</h2> ' . $date . ' <br> <img src=' . $image . '><br>' . $content . ' ';

        // Insert/Update Page Data
        $query = "INSERT IGNORE INTO pages (path, host, title, image, content, download_time) VALUES (\"" . mysqli_real_escape_string($this->connectDB, $url_path) . "\", \"$url_host \", \"$title\", \"$image\", \"$content\",  \"$date\") ON DUPLICATE KEY UPDATE host=\"$url_host \", title=\"$title\",image=\"$image\", content=\"$content\",  download_time=\"$date\"";
        if (!mysqli_query($this->connectDB, $query)) {
            die("<br>Error: Unable to perform Insert Query\n");
        }
    }
}
