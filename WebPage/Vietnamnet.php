<?php
class Vietnamnet extends Vnexpress
{
    public function getDate()
    {
        $date = '';
        $para = $this->domDocument->getElementsByTagName('p');
        foreach ($para as $p) {
            if ($p->getAttribute('class') == 'time-zone') {
                $date = mysqli_real_escape_string($this->connectDB, $p->nodeValue);
            }
        }
        $dateText = str_replace('\n', '<br>', $date);
        return $dateText;
    }

    public function getContent()
    {
        $content = '';
        $articleTag = $this->domDocument->getElementById('ArticleContent');
        $content = mysqli_real_escape_string($this->connectDB, $articleTag->nodeValue);
        $contentText = str_replace('\n', '<br>', $content);
        return $contentText;
    }
    public function getImage()
    {
        $image = '';
        $metaTags = $this->domDocument->getElementsByTagName('meta');
        foreach ($metaTags as $tag) {
            if ($tag->getAttribute('property') == 'og:image') {
                $image = mysqli_real_escape_string($this->connectDB, $tag->getAttribute('content'));
            }
        }
        return $image;
    }
}
