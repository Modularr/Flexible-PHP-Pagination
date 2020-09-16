<?php
error_reporting(E_WARNING);

# Connect To Database
mysql_connect('localhost', 'root', 'root')or die(mysql_error());
mysql_select_db('test')or die(mysql_error());

# Include Pagination Class
include('../pagination.php');

# Display Links for Demo Purposes (not required)
include('links.html');
