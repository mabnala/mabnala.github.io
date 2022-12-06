<?php

define("START_TIME", microtime(true));
$basename = basename(__FILE__);

if (php_sapi_name() != "cli") {
    echo "Command line: <code>$ php /home/user/public_html/$basename &lt;destination-file&gt; &lt;sitemap-base&gt;</code><br>";
    echo "Example: <code>$ php /home/user/public_html/$basename &quot;public/fafifu/sitemap.xml&quot; &quot;https://perfafifuan.web.app/fafifu/&quot;</code><br>";
    echo "Notes: <code>Taruh sitemap di dalam subfolder, jangan di public atau root directory.</code><br>";
    echo "Last modified: <code>".gmdate('Y-m-d H:i:s', filemtime(__FILE__)+(7*60*60))." GMT+7</code><hr>";
    highlight_file(__FILE__);
    exit;
}
if(count($argv) < 3) die("Error: incompleted parameter. Format: $ php {$argv[0]} <destination-file> <sitemap-base>\n");
list(, $destination, $base) = $argv;
$dirname = dirname($destination);

$xml = '<?'.'xml version="1.0" encoding="UTF-8"?'.'>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
';
foreach(glob($dirname.'/*.html') as $sitemap) {
    if(realpath($sitemap) != realpath($destination)) {
        echo "$sitemap found ...\n";
        $xml .= "\t<sitemap>\n\t\t<loc>".$base.basename($sitemap)."</loc>\n\t</sitemap>\n";
    }
}
$xml .= '</sitemapindex>';

file_put_contents($destination, $xml);
echo "Sitemap index successfully generated and saved to $destination.\n";