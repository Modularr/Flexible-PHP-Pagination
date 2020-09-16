<style>
#tnt_pagination {
	display:block;
	text-align:left;
	height:22px;
	line-height:21px;
	clear:both;
	padding-top:3px;
	font-family:Arial, Helvetica, sans-serif;
	font-size:12px;
	font-weight:normal;
}

#tnt_pagination a:link, #tnt_pagination a:visited{
	padding:7px;
	padding-top:2px;
	padding-bottom:2px;
	border:1px solid #EBEBEB;
	margin-left:10px;
	text-decoration:none;
	background-color:#F5F5F5;
	color:#0072bc;
	width:22px;
	font-weight:normal;
}

#tnt_pagination a:hover {
	background-color:#DDEEFF;
	border:1px solid #BBDDFF;
	color:#0072BC;	
}

#tnt_pagination .active_tnt_link {
	padding:7px;
	padding-top:2px;
	padding-bottom:2px;
	border:1px solid #BBDDFF;
	margin-left:10px;
	text-decoration:none;
	background-color:#DDEEFF;
	color:#0072BC;
	cursor:default;
}

#tnt_pagination .disabled_tnt_pagination {
	padding:7px;
	padding-top:2px;
	padding-bottom:2px;
	border:1px solid #EBEBEB;
	margin-left:10px;
	text-decoration:none;
	background-color:#F5F5F5;
	color:#D7D7D7;
	cursor:default;
}
#embed {
padding-top:7px;
}
</style>

Note: This CSS design is freely available here:<a href="http://www.thewebhelp.com/css/pagination-style-template/">Pagination Style Template</a><br />
And does not belong to me. All credit for the design goes to this author.<br />
<br />
<?php
include('config.php');

$max = 6;
$select = "SELECT * FROM test";
$query1 = mysql_query($select) or die( mysql_error() ); 
$total = mysql_num_rows($query1);

$nav = new Pagination($max, $total);

$query2 = mysql_query($select." LIMIT ".$nav->start().",".$max) or die(mysql_error()); 
while($item = mysql_fetch_object($query2)) 
{ 
    echo $item->id . ' - <b>' . $item->name . '</b><br />';
}

$link = 'customdesign.php?p=';

echo '<div id="tnt_pagination">';
echo $nav->first('<a href="'.$link.'{nr}">First</a>') . $nav->previous('<a href="'.$link.'{nr}">&laquo; prev</a>');

echo $nav->numbers('<a href="'.$link.'{nr}">{nr}</a>', '<span class="active_tnt_link">{nr}</span>');

echo $nav->next('<a href="'.$link.'{nr}">Next &raquo;</a>') . $nav->last('<a href="'.$link.'{nr}">Last</a>') . 
$nav->info('<br /><div id="embed"><span class="active_tnt_link">Result {start} to {end} of {total}</span>') . $nav->info('<span class="active_tnt_link">Page {page} of {pages}</span></div>');

echo '</div>';
