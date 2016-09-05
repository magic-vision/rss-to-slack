<?php

namespace Rts;

class RssReader
{
    public function readFeed($feedUrl)
    {
        $rss = \Feed::loadRss($feedUrl)->toArray();
        $result = [];
        foreach ($rss['item'] as $item) {
            if (!isset($item['guid'])) {
                continue;
            }
            $guid = $item['guid'];
            $result[$guid] = $item;
        }
        return $result;
    }


}