<?php

namespace Site\Functions;

class MatchesData
{
    function matchesImage($regex, $contentHTML)
    {
        preg_match($regex, $contentHTML, $image);
        return $image[1];
    }

    function matchesDate($regex, $key, $contentHTML)
    {
        preg_match($regex, $contentHTML, $date);
        return $date[$key];
    }

    function matchesContent($regexParent, $regexChild, $contentHTML)
    {
        preg_match_all($regexParent, $contentHTML, $matches, PREG_SET_ORDER, 1);

        preg_match_all($regexChild, $matches[0][1], $content, PREG_SET_ORDER, 1);

        $output = '';
        foreach ($content as $para) {
            $output .= $para[1];
        }
        return $output;
    }
}
