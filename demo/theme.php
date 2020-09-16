<?php
include('config.php');

echo '<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>';

$max = 6;
$select = "SELECT * FROM test";
$query1 = mysql_query($select) or die( mysql_error() ); 
$total = mysql_num_rows($query1);

$nav = new Pagination($max, $total, $_GET['p']);

$nav->url = 'theme.php?p=';

$query2 = mysql_query($select." LIMIT ".$nav->start().",".$max) or die(mysql_error()); 
while($item = mysql_fetch_object($query2)) 
{ 
    echo $item->id . ' - <b>' . $item->name . '</b><br />';
}

echo $nav->get_html('../themes/bootstrap');