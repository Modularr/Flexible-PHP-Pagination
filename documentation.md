# Flexible PHP Pagination Documentation
					
The pagination class was designed to make PHP pagination easier without sacrificing any of the possibilities.

Flexible PHP Pagination can be used to paginate any type of data set, any Languages, it supports any type of HTML structure, any type of SEO Link Structure. And much more, no longer are you bound by the rules or complexities that Pagination presents.


This script does not have CSS Styles and Preselected Display Styles. In other words, the pagination can fit your design, or custom format.

___

### Installation

This is a basic PHP Class. So to use this, all you have to do is the following:

- Download and Unzip File
- Copy **pagination.php** to your directory of choosing.
- Use PHP to include the file.

Because of this class's Flexibility, it may be harder to understand how to use it, but we assume Basic Knowledge of PHP is present. A file include would go as followed:

	include('flexible-php-pagination.php');
	
### Composer Users

Composer users can use this package by using Composer's default autoloading feature. Just use the namespace **Modularr**.

Then call the class like defined in this guide.
I am new to composer, so please if you see anything you can improve. Feel free to pitch in.

___

### Basic Usage

Before you can paginate information, you must understand how pagination works. Any type of Pagination requires a minimum of **2 parameters** and **1 optional parameter**.

- Maxmum Results Per Page
- Total Number of Results from your Data Source
- Optional: A **$_GET** parameter name (defaults to **P**)

The Pagination Class is Generic, this means is that we use Pagination without a Data Source (like MySQL for example). That allows you to paginate any data sources you may have.

Basic Setup Example:

	// Connect To Database - Edit Details for your own Database
	mysql_connect('localhost', 'root', 'root');
	mysql_select_db('test');
	
	// Include Pagination Class
	include('pagination.php');

Maximum Per Page, Total number of results and optionally a Get Parameter.

	// Maximum Items Per Page
	$max = 6;
	
	// Maximum Numbers Per Page
	$maxNum = 7;
	
	// Number of Total Results in our Table
	$numQuery = mysql_query("SELECT * FROM test") or die( mysql_error() ); 
	$total = mysql_num_rows($numQuery);
	
	// We Need to know for pagination, our Maximum per page, our Total per page, our Maximum numbers to show (false to disable), and an optional Parameter
	$nav = new Pagination($max, $total, $maxNum, 'page');
	
	// Here we run the Query and Limit our Results based on the pagination
	$query = mysql_query("SELECT * FROM test LIMIT ".$nav->start().",".$max) or die( mysql_error() ); 
	while($result = mysql_fetch_object($query))
	{
		echo $result->title . ' <br /> ' . $result->article ; 
	}
	
	// Show the Previous Link, Custom HTML is accepted
	echo $nav->previous(' <a href="index.php?page={nr}">Previous</a> | ');
	
	// Show the Numbers, Custom HTML is accepted
	// Parameter1: For Loop Number with a Link
	// Parameter2: Loop Number of Current Page (no link)
	echo $nav->numbers(' <a href="index.php?page={nr}">{nr}</a> | ', ' <b>{nr}</b> | ');
	
	// Show the Previous Link, Custom HTML is accepted
	echo $nav->next(' <a href="index.php?page={nr}">Next</a> | ');

That's all there is to it. You may have noticed we allow custom HTML. This gives you full flexibility. We have integrated an easy system that allows you to access information you need to design your own custom Navigation. Here we will list all possible combinations.

**Link Functions List:**

- $obj->first( active, inactive )
- $obj->previous( active, inactive )
- $obj->next( active, inactive )
- $obj->last( active, inactive )
- $obj->info( html )
- $obj->numbers( link, current, reversed = false )

Active refers to custom HTML for the Active Link. Inactive is optional HTML and when ignored the link simply will not display. However, if you want to show an Inactive link. You can use the HTML there to display an  Inactive Link. 

As you can see our Functions all work similarly, when you call $obj->previous and use {nr} it wil display the previous number. There is one exeption that allows multiple inputs, this one is for the numbers itself.

The $obj->numbers accepts 3 parameters. Each have their own use.

**Numbers Method:**

Parameter 1:
> Required - a number WITH A LINK. This is used for all numbers except for the current page

Parameter 2:
> Required - a number WITHOUT A LINK. This is used for the current page you are on

Parameter 3:
> Optional - this accepts only TRUE and FALSE. When set to TRUE it will reverse *only the order of the numbers* backwards.

Next up are tags. Because we wanted to make it easy to use we added easy to use tags. Much like template engines use them. There are only the tags we created and they are **Case Sensetive**.

**Tag List:**

{nr}
> Returns the appropriate number for the function. Works in all functions

{page}
> Returns the current page you are on &#8211; Only in $obj->info();

{pages}
> Returns the total number of pages &#8211; Only in $obj->info();

{start}
> Returns the start of your result set within a page &#8211; Only in $obj->info();

{end}
> Returns the end of your result set within a page &#8211; Only in $obj->info();

{total}
> Returns the total number of results &#8211; Only in $obj->info();

The method **$obj->info();** allows a lot more tags then the others. This method was specifically designed to return these particular results so you can use this function multiple times. For example if your pagination is in seperated divs etc. Here is an example usage of the info method:

	echo $nav->info(' Page {page} of {pages} | ');
	
	echo $nav->info(' Result {start} to {end} of {total} | ');

___

### Full Flexibility

Here are some examples of how you can use this Pagination class in different ways.

**Full Pagination:**

	// Show the First Link
	echo $nav->first(' <a href="file.php?page={nr}">First</a> | ');
	
	// Show the Previous Link
	echo $nav->previous(' <a href="file.php?page={nr}">Previous</a> | ');
	
	// Show Numbers
	echo $nav->numbers(' <a href="file.php?page={nr}">{nr}</a> | ', ' <b>{nr}</b> | ');
	
	// Show the Next Link
	echo $nav->next(' <a href="file.php?page={nr}"&>Next</a> | ');
	
	// Show the Last Link
	echo $nav->last(' <a href="file.php?page={nr}">Last</a> | ');
	
	echo $nav->info(' Page {page} of {pages} | ');
	echo $nav->info(' Result {start} to {end} of {total} | ');

**Search Engine Optimized Links:**

	// Show the First Link
	echo $nav->first(' <a href="./page-{nr}/">First</a> | ');
	
	// Show the Previous Link
	echo $nav->previous(' <a href="./page-{nr}/">Previous</a> | ');
	
	// Show Numbers
	echo $nav->numbers(' <a href="./page-{nr}/">{nr}</a> | ', ' <b>{nr}</b> | ');
	
	// Show the Next Link
	echo $nav->next(' <a href="./page-{nr}/">Next</a> | ');
	
	// Show the Last Link
	echo $nav->last(' <a href="./page-{nr}/">Last</a> | ');

**Custom Styled HTML:**

    // That's right, if we want to we can display this information before we show the links.
    echo $nav->info('<div id="result-info"> Result {start} to {end} of {total} </div>');
    
    // Show the First Link
    echo $nav->first('<div id="first"> <a href="index.php?p={nr}">First</a> </div>');
    
    // Show the Previous Link
    echo $nav->previous('<div id="previous"> <a href="index.php?p={nr}">Previous</a> </div>');
    
    // Show Numbers
    echo $nav->numbers('<div id="number"> <a href="index.php?p={nr}">{nr}</a>', ' <div id="current">{nr}</div>');
    
    // Show the Next Link
    echo $nav->next('<div id="next"> <a href="index.php?p={nr}">Next</a> </div>');
    
    // Show the Last Link
    echo $nav->last('<div id="last"> <a href="index.php?p={nr}">Last</a> </div>');
    echo $nav->info('<div id="page-info"> Page {page} of {pages} </div>');

**Reversed Numbers:**

	echo $nav->numbers(' <a href="index.php?p={nr}">{nr}</a> | ', ' <b> {nr} </b>', true);

**Translated Text:**

    // Show the First Link
    echo $nav->first(' <a href="./page-{nr}/">Begin</a> | ');
    
    // Show the Previous Link
    echo $nav->previous(' <a href="./page-{nr}/">Vorige</a> | ');
    
    // Show Numbers
    echo $nav->numbers(' <a href="./page-{nr}/">{nr}</a> | ', ' <b>{nr}</b> | ');
    
    // Show the Next Link
    echo $nav->next(' <a href="./page-{nr}/">Volgende</a> | ');
    
    // Show the Last Link
    echo $nav->last(' <a href="./page-{nr}/">Einde</a> | ');