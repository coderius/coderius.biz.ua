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
?>
 
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <?php foreach($urls as $url): ?>
        <url>
            <loc><?= $host . $url['loc']; ?></loc>
            <?php if(isset($url['lastmod'])): ?>
            <lastmod><?= $url['lastmod']; ?></lastmod>
            <?php endif; ?>
            <changefreq><?= $url['changefreq']; ?></changefreq>
            <priority><?= $url['priority']; ?></priority>
        </url>
    <?php endforeach; ?>
</urlset>
