<?php
# Function can be found at https://gist.github.com/3636901
$topics = fetchTopics(1); # Returns an XML resultset using simplexml_load_string (works like an array)

$max = 5; # Set the maximum number of results per page
$total = count($topics); # Count the amount of returned results
$maxNum = 7;

# We Need to know for pagination, our Maximum per page, and our Total, and an optional Parameter
$nav = new Pagination($max, $total, $maxNum, 'page');
$link = 'forum.php?id='.htmlspecialchars($_GET['id']).'&page={nr}';
?>
<table cellspacing="0" width="100%">
    <thead>
        <tr>
        <th align="left">Subject</th>
        <th class="center">Autor</th>
        <th class="center">Replies</th>
        <th>Date</th>
        </tr>
    </thead>
<tfoot>
    <tr>
    <td colspan="5">
        <span>Showing <?php echo $nav->info('{start} - {end} of {total}'); ?> threads</span>
        <?php
        echo $nav->first(' <a href="'.$link.'">First</a> ', ' <strong>First</strong> ');
        echo $nav->previous(' <a href="'.$link.'">&laquo;</a> ', ' <strong>&laquo;</strong> ');
        echo $nav->numbers(' <a href="'.$link.'">{nr}</a> ', ' <strong>{nr}</strong> ');
        echo $nav->next(' <a href="'.$link.'">&raquo;</a> ', ' <strong>&raquo;</strong> ');
        echo $nav->last(' <a href="'.$link.'">Last</a> ', ' <strong>Last</strong> ');
        ?>
        </td>
    </tr>
</tfoot>
<tbody>
<?php
foreach($topics as $topic)
{
	# This code limits the returned results to fit the navigation
    if( $nav->paginator() )
    {
        echo '<tr>
            <td> <img src="css/images/icons/knewstuff.png"> &nbsp; <strong><a class="title" href="topic.php?id='.$topic->id.'">'.$topic->title.'</a></strong></td>
            <td class="center"><font color="#FF0000">'.username($topic->author).'</font></td>
            <td class="center">0</td>
            <td class="thread_lastentry">
            <small>08-07-2012 12:28:57</small>
            </td>
        </tr>';
    }
}
?>
</tbody>
</table>
