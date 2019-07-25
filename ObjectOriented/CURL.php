<?php

class CURL
{
    private $sql;

    function __construct(Databases $sql)
    {
        $this->sql = $sql;
    }

    function httpRequest($target, $referer)
    {
        //Initialize Handle
        $handle = curl_init();
        //Define settings
        curl_setopt($handle, CURLOPT_HTTPGET, true);
        curl_setopt($handle, CURLOPT_HEADER, true);
        curl_setopt($handle, CURLOPT_URL, $target);
        curl_setopt($handle, CURLOPT_REFERER, $referer);
        curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($handle, CURLOPT_MAXREDIRS, 4);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

        //Execute Request
        $output = curl_exec($handle);
        //Close cURL handle
        curl_close($handle);

        //Separate Header and body 
        $separator = "\r\n\r\n";
        $header = substr($output, 0, strpos($output, $separator));
        $body_start = strlen($header) + strlen($separator);
        $body = substr($output, $body_start, strlen($output) - $body_start);

        //Parse Header
        $header_array = array();
        $split_header = explode("\r\n", $header);
        foreach ($split_header as $i => $line) {
            if ($i === 0) {
                $header_array['http_code'] = $line;
                $status_info = explode(" ", $line);
                $header_array['status_info'] = $status_info;
            } else {
                list($key, $value) = explode(': ', $line);
                $header_array[$key] = $value;
            }
        }

        //From Return Structure 
        $ret = array("headers" => $header_array, "body" => $body);
        return $ret;
    }

    //Relative to Absolute URL
    function relativeToAbsolute($relative, $base)
    {
        if ($relative == "" || $base == "") return "";
        //Check Base
        $base_parsed = parse_url($base);
        if (!array_key_exists('scheme', $base_parsed) || !array_key_exists('host', $base_parsed) || !array_key_exists('path', $base_parsed)) {
            echo "Base Path \"$base\" Not Absolute Link\n";
            return "";
        }
        //Parse Relative
        $relative_parsed = parse_url($relative);
        //If relative URL already has a scheme, it's already absolute
        if (array_key_exists('scheme', $relative_parsed) && $relative_parsed['scheme'] != '') {
            return $relative;
        }
        //If only a query or a fragment, return base (without any fragment or query) + relative
        if (!array_key_exists('scheme', $relative_parsed) && !array_key_exists('host', $relative_parsed) && !array_key_exists('path', $relative_parsed)) {
            return $base_parsed['scheme'] . '://' . $base_parsed['host'] . $base_parsed['path'] . $relative;
        }
        //Remove non-directory portion from path
        $path = preg_replace('#/[^/]*$#', '', $base_parsed['path']);
        //If relative path already points to root, remove base return absolute path
        if ($relative[0] == '/') {
            $path = '';
        }
        //Working Absolute URL
        $abs = '';
        //If user in URL
        if (array_key_exists('user', $base_parsed)) {
            $abs .= $base_parsed['user'];
            //If password in URL as well
            if (array_key_exists('pass', $base_parsed)) {
                $abs .= ':' . $base_parsed['pass'];
            }
            //Append location prefix
            $abs .= '@';
        }
        //Append Host
        $abs .= $base_parsed['host'];
        //If port in URL
        if (array_key_exists('port', $base_parsed)) {
            $abs .= ':' . $base_parsed['port'];
        }
        //Append New Relative Path
        $abs .= $path . '/' . $relative;
        //Replace any '//' or '/./' or '/foo/../' with '/'
        $regex = array('#(/\.?/)#', '#/(?!\.\.)[^/]+/\.\./#');
        for ($n = 1; $n > 0; $abs = preg_replace($regex, '/', $abs, -1, $n)) { }
        //Return Absolute URL
        return $base_parsed['scheme'] . '://' . $abs;
    }

    function getConnectDatabase()
    {
        return $this->sql->mysqlConnect();
    }

    function parsePage($target, $referer)
    {
        $mysql_conn = $this->getConnectDatabase();
        //Parse URL and get Components
        $url_components = parse_url($target);
        if ($url_components === false) {
            die('Unable to Parse URL');
        }
        $url_host = $url_components['host'];
        $url_path = '';
        if (array_key_exists('path', $url_components) == false) {
            //If not a valid path, mark as done
            $query = "INSERT INTO pages (path, download_time) VALUES (\"" . mysqli_real_escape_string($mysql_conn, $target) . "\", NOW()) ON DUPLICATE KEY UPDATE download_time=NOW()";
            if (!mysqli_query($mysql_conn, $query)) {
                die("Error: Unable to perform Download Time Update Query (path)\n");
            }
            return false;
        } else {
            $url_path = $url_components['path'];
        }
        //Download Page
        echo "Downloading: $target\n";
        $contents = $this->httpRequest($target, $referer);
        echo "Done<br>";
        //Check Status
        if ($contents['headers']['status_info'][1] != 200) {
            //If not ok, mark as downloaded but skip
            $query = "INSERT INTO pages (path, download_time) VALUES (\"" . mysqli_real_escape_string($mysql_conn, $url_path) . "\", NOW()) ON DUPLICATE KEY UPDATE download_time=NOW()";
            if (!mysqli_query($mysql_conn, $query)) {
                die("Error: Unable to perform Download Time Update Query (http status)\n");
            }
            return false;
        }
        //Parse Contents
        $doc = new DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($contents['body']);
        //Get title
        $title = '';
        $titleTags = $doc->getElementsByTagName('title');
        if (count($titleTags) > 0) {
            $title = mysqli_real_escape_string($mysql_conn, $titleTags[0]->nodeValue);
        }
        //Get Description
        $description = '';
        $metaTags = $doc->getElementsByTagName('meta');
        foreach ($metaTags as $tag) {
            if ($tag->getAttribute('name') == 'description') {
                $description = mysqli_real_escape_string($mysql_conn, $tag->getAttribute('content'));
            }
        }
        //Insert/Update Page Data
        $query = "INSERT INTO pages (path, title, description, download_time) VALUES (\"" . mysqli_real_escape_string($mysql_conn, $url_path) . "\", \"$title\", \"$description\", NOW()) ON DUPLICATE KEY UPDATE title=\"$title\", description=\"$description\", download_time=NOW()";
        if (!mysqli_query($mysql_conn, $query)) {
            die("Error: Unable to perform Insert Query\n");
        }
        //Get Links
        $links = array();
        $link_tags = $doc->getElementsByTagName('a');
        foreach ($link_tags as $tag) {
            if (($href_value = $tag->getAttribute('href'))) {
                $link_absolute = $this->relativeToAbsolute($href_value, $target);
                $link_parsed = parse_url($link_absolute);
                if ($link_parsed === null || $link_parsed === false) {
                    die('Unable to Parse Link URL');
                }
                if ((!array_key_exists('host', $link_parsed) || $link_parsed['host'] == "" || $link_parsed['host'] == $url_host) && array_key_exists('path', $link_parsed) && $link_parsed['path'] != "" && array_search($link_parsed['path'], $links) === false) {
                    $links[] = $link_parsed['path'];
                }
            }
        }
        //Insert Links
        foreach ($links as $link) {
            $link_escaped = mysqli_real_escape_string($mysql_conn, $link);
            $query = "INSERT IGNORE INTO pages (path, referer, download_time) VALUES (\"$link_escaped\", \"" . mysqli_real_escape_string($mysql_conn, $target) . "\", NULL)";
            if (!mysqli_query($mysql_conn, $query)) {
                die("Error: Unable to perform Insert Link Value Query\n");
            }
        }
        return true;
    }
}
