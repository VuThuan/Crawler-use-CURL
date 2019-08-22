<?php

namespace model;

use Exception;

class Model
{
    /**
     * @param $db Connection database
     */
    public function __construct($db)
    {
        try {
            $this->db = $db;
        } catch (Exception $e) {
            exit('Database connection could not be established.');
        }
    }

    public function addPage($path, $host, $title, $content, $image, $date)
    {
        $sql = "INSERT IGNORE INTO pages (path, host, title, image, content, download_time) VALUES (\"" . mysqli_real_escape_string($this->db, $path) . "\",\"" . mysqli_real_escape_string($this->db, $host) . "\" , \"" . mysqli_real_escape_string($this->db, $title) . "\", \"$image\", \"" . mysqli_real_escape_string($this->db, $content) . "\",  \"" . mysqli_real_escape_string($this->db, $date) . "\")";

        if (!mysqli_query($this->db, $sql)) {
            die("<br>Error: Unable to perform Insert Query<br>");
        }
    }
}
