<?php
include('config.php');

$max = 6;
$select = "SELECT * FROM test";
$query1 = mysql_query($select) or die( mysql_error() ); 
$total = mysql_num_rows($query1);

$nav = new Pagination($max, $total);
$nav->page = $_GET['p'];

$query2 = mysql_query($select." LIMIT ".$nav->start().",".$max) or die(mysql_error()); 
while($item = mysql_fetch_object($query2)) 
{ 
    echo $item->id . ' - <b>' . $item->name . '</b><br />';
}

$nav->url = 'alloptions.php?p=';

echo $nav->first(' <a href="{url}{nr}"><<</a> | ', ' << | ');

echo $nav->previous(' <a href="{url}{nr}">Previous</a> | ', ' Previous | ');

echo $nav->numbers(' <a href="{url}{nr}">{nr}</a> | ', ' <b>{nr}</b> | ');

echo $nav->next(' <a href="{url}{nr}">Next</a> | ', ' Next | ');

echo $nav->last(' <a href="{url}{nr}">>></a> | ', ' >> | ');

echo $nav->info('Result {start} to {end} of {total} - ');

echo $nav->info('Page {page} of {pages} ');
