<?php

$out = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';


$sth = $PDO->prepare("SELECT * FROM `vacancy`");
$sth->execute();
$articles = $sth->fetchAll(PDO::FETCH_ASSOC);

foreach ($articles as $row) {

    $date = max(array(DateTime::createFromFormat('d.m.Y', $row['date'])->format('Y-m-d'), $row['last_up']));

    $out .= '
	<url>
		<loc>http://stgaujob.ru/job/?id=' . $row['id'] . '</loc>
		<lastmod>' . $date . '</lastmod>
		<priority>' . ((($date + 604800) > time()) ? '1' : '0.5') . '</priority>
	</url>';
}

$out .= '</urlset>';

header('Content-Type: text/xml; charset=utf-8');
echo $out;
exit();
