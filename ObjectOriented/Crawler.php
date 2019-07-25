<?php
class Crawler
{
    private $curl;

    function __construct(CURL $cURL)
    {
        $this->curl = $cURL;
    }

    function CrawlerAndSeparateData($url)
    {
        $seed_components = parse_url($url);
        if ($seed_components === false) {
            die('Unable to Seed Parse URL');
        }
        $seed_scheme = $seed_components['scheme'];
        $seed_host = $seed_components['host'];
        $url_start = $seed_scheme . '://' . $seed_host;
        //Download Seed URL
        $this->curl->parsePage($url, "");
        $this->loopAllThePages($url_start, $this->curl->getConnectDatabase());
    }

    function loopAllThePages($url_start, $mysql_conn)
    {
        while (1) {
            $counter = 0;
            $select_query = "SELECT * FROM pages WHERE download_time IS NULL";
            if (($select_result = mysqli_query($mysql_conn, $select_query)) !== false) {
                if (($rowCount = mysqli_num_rows($select_result)) > 0) {
                    for ($i = 0; $i < $rowCount; $i++) {
                        if (($row = mysqli_fetch_assoc($select_result)) !== false) {
                            $path = $row['path'];
                            $referer = $row['referer'];
                            //Check if first character isn't a '/'
                            if ($path[0] != '/') {
                                continue;
                            }
                            $path = $row['path'];
                            $referer = $row['referer'];
                            if ($this->curl->parsePage($url_start . $path, $referer)) {
                                $counter++;
                            }
                            sleep(1);
                        }
                    }
                } else {
                    break;
                }
            } else {
                die("Unable to select un-downloaded pages\n");
            }
            if ($counter == 0) {
                break;
            }
        }
    }
}
