<?php

/**
 * @package myblog
 * @file index.php created 10.04.2018 12:56:35
 * 
 * @copyright Copyright (C) 2018 Sergio Codev <codev>
 * @license This program is free software: GNU General Public License
 */

/* @var $urls */
/* @var $host */
 
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo PHP_EOL;
?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
    <channel>
        <?php if(isset($channel['atom:link']) && $channel['atom:link']): ?>
        <atom:link href="<?= $channel['atom:link']; ?>" rel="self" type="application/rss+xml" />
        <?php endif; ?>
        <title><?= $channel['title']; ?></title>
        <link><?= $channel['link']; ?></link>
        <description><?= $channel['description']; ?></description>
        <language><?= $channel['language']; ?></language>
        <?php if($channel['image']): ?>
        <guid><?= $channel['image']; ?></guid>
        <?php endif; ?>
        <?php if($items): ?>
        <?php foreach($items as $k => $item): ?>
        <item>
            <title><![CDATA[ <?= $item['title']; ?> ]]></title>
            <link><?= $item['link']; ?></link>
            <description><![CDATA[ <?= $item['description']; ?> ]]></description>
            <pubDate><?= $item['pubDate']; ?></pubDate>
            <?php if($item['guid']): ?>
            <guid><?= $item['guid']; ?></guid>
            <?php endif; ?>
            <?php if(isset($item['author']) && $item['author']): ?>
            <author><?= $item['author']; ?></author>
            <?php endif; ?>
            <?php if($item['category']): ?>
            <category><?= $item['category']; ?></category>
            <?php endif; ?>
        </item>    
        <?php endforeach; ?>
        <?php endif; ?>
    </channel>
</rss>
