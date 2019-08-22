<?php

namespace lib;

class Crawler
{
    private $curl;

    function __construct(Curl $curl)
    {
        $this->curl = $curl;
    }

    //We parse the URL and download if the status is 200, then we set the value and get the data, insert to database
    function parsePage($url)
    {
        $url = trim($url);

        $url_components = parse_url($url);
        if ($url_components === false) {
            die('Unable to Parse URL');
        }
        $url_host = $url_components['host'];
        $url_path = $url_components['path'];

        //Download Page
        $contents = $this->curl->httpRequest($url);

        return array(
            "host" => $url_host,
            "path" => $url_path,
            "html" => $contents['body']
        );
    }
}
