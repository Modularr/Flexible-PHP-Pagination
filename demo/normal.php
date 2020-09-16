<?php
include('config.php');

$max = 6;
$select = "SELECT * FROM test";
$query1 = mysql_query($select) or die( mysql_error() ); 
$total = mysql_num_rows($query1);

$nav = new Pagination($max, $total, $_GET['p']);

$nav->url = 'normal.php?p=';

$query2 = mysql_query($select." LIMIT ".$nav->start().",".$max) or die(mysql_error()); 
while($item = mysql_fetch_object($query2)) 
{ 
    echo $item->id . ' - <b>' . $item->name . '</b><br />';
}

echo $nav->get_html();