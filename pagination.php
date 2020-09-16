<?php
/**
 * The Flexible PHP pagination class was designed to be the easiest to use PHP Pagination system without losing any customization options.
 */
class Pagination
{
	public $max, $total, $value, $start = 0;
	public $url, $theme = '../themes/default';
	public $i = 0;
	
	/**
	* Class Constructor, Accepts 3 parameters. The minimum that any pagination requires.
	* @param int $max maximum amount of results per page
	* @param int $total total number of results in data source
	* @param int $page The value used to determine what page we're currently on
	* @param int $max_items If set to 7 then a maximum of 7 page numbers are shown. The previous 3 pages, the current page and the next 3 pages shown. (Set to false for all page numbers)
	*/
	public function __construct($max, $total, $page = 1, $max_items = 10)
	{ 
		$this->max	  		= $max;
		$this->total		= $total;
		$this->max_items 	= $max_items;

		# Set the page as a number, bypassing GET
		$this->page = (!empty($page) && ($page <= $this->pages()) && is_numeric($page)) ? $page : 1;
	}
	
	/**
	 * A pre-formatted string of html to display general pagination links. Use this if you don't care too much about
	 * The html includes links to first, last, next, previous and numbered pages.
	 * @param int $url the url to be used in the links
	 * @return string HTML
	 */
	public function get_html($theme_file=null)
	{
		if($theme_file != null)
		{
			$this->theme = $theme_file;
		}
		$theme = include $this->theme.'.php';
		
		$links = $theme['pre'];
		$links .= $this->first($theme['first'][0], $theme['first'][1]);
		$links .= $this->previous($theme['previous'][0], $theme['previous'][1]);
		$links .= $this->numbers($theme['numbers'][0], $theme['numbers'][1]);
		$links .= $this->next($theme['next'][0], $theme['next'][1]);
		$links .= $this->last($theme['last'][0], $theme['last'][1]);
		$links .= $theme['post'];
		return $links;
	}
	
	/**
	* This calculates the start of our result set, based on our current page
	* @return int Final Calculation of where our result set should begin
	*/
	public function start()
	{
		# Computers Calculate From 0 thus, page1 must start results from 0
		$start = $this->page - 1;
		
		# Calculate Our Starting Point (0x6=0(start from 0, page1), 1x6=6(start from 6, page2), etc)
		$calc = $start*$this->max;
		
		# return our final outcome
		return $calc;
	}
	
	/**
	* This calculates the end of our result set, based on our current page
	* @return int Final Calculation of where our result set should end
	*/
	public function end()
	{
		# Calculate the Beginning + The maximum amount of results
		$calc = $this->start() + $this->max;
		
		# Only return this if it is not above the total otherwise return our maximum
		# example, 24 + 6 = 30, but with only 26 reselts it will display the total results istead (26)
		$r = ($calc > $this->total) ? $this->total : $calc;
		
		# return the result
		return $r;
	}
	
	/**
	* This calculates the total pages in our result set
	* @return int return Rounds Up the total results / maximum per page
	*/
	public function pages()
	{
		return ceil($this->total/$this->max);
	}
	
	/**
	* Based on which page you are this returns informations like, start result, end result, total results, current page, total pages
	* @param string $html The HTML you wish to use to display the link
	* @return mixed return information we may need to display
	*/
	public function info($html)
	{
		$tags = array('{total}', '{start}', '{end}', '{page}', '{pages}');
		$code = array($this->total, $this->start()+1, $this->end(), $this->page, $this->pages());
		
		return str_replace($tags, $code, $html);
	}
	
	/**
	* This shows the 'first' link with custom html
	* @param string $html The HTML you wish to use to display the link
	* @return string The Same HTML replaced the tags with the proper number
	*/
	public function first($html, $html2='')
	{
		# Only show if you are not on page 1, otherwise show HTML2
		$value = ($this->page != 1) ? $html : $html2;
		return str_replace(array('{nr}','{url}'), array(1,$this->url), $value);
	}
	

	/**
	* This shows the 'previous' link with custom html
	* @param string $html The HTML you wish to use to display the link
	* @return string The Same HTML replaced the tags with the proper number
	*/
	public function previous($html, $html2='')
	{
		# Only show if you are not on page 1, otherwise show HTML2
		$value = ($this->page != 1) ? $html : $html2;
		return str_replace(array('{nr}','{url}'), array($this->page-1,$this->url), $value);
	}
	
	/**
	* This shows the 'next' link with custom html
	* @param string $html The HTML you wish to use to display the link
	* @return string The Same HTML replaced the tags with the proper number
	*/
	public function next($html, $html2='')
	{
		# Only show if you are not on the last page
		$value = ($this->page < $this->pages()) ? $html : $html2;
		return str_replace(array('{nr}','{url}'), array($this->page+1,$this->url), $value);
	}
	
	/**
	* This shows the 'last' link with custom html
	* @param string $html The HTML you wish to use to display the link
	* @return string The Same HTML replaced the tags with the proper number
	*/
	public function last($html, $html2='')
	{
		# Only show if you are not on the last page
		$value = ($this->page < $this->pages()) ? $html : $html2;
		return str_replace(array('{nr}','{url}'), array($this->pages(),$this->url), $value);
	}
	
	/**
	* This shows an loop of 'numbers' with their appropriate link in custom html
	* @param string $link The HTML to display a number with a link
	* @param string $current The HTML to display a the current page number without a link
	* @param string $reversed Optional Parameter, set to true if you want the numbers reversed (align to right for designs)
	* @return string The Same HTML replaced the tags with the proper numbers and links
	*/
	public function numbers($link, $current, $reversed=false)
	{
		$r = '';
		$range = floor(($this->max_items-1)/2);
		if (!$this->max_items)
		{
			$page_nums = range(1, $this->pages());
		}
		else
		{
			$lower_limit = max($this->page - $range, 1);
			$upper_limit = min($this->pages(), $this->page + $range);
			$page_nums = range($lower_limit, $upper_limit);
		}

		if($reversed)
		{
			$page_nums = array_reverse($page_nums);
		}

		foreach ($page_nums as $i)
		{
			$tags = array('{nr}','{url}');
			$code = array($i,$this->url);
			
			if($this->page == $i)
			{
				$r .= str_replace($tags, $code, $current);
			}
			else
			{
				$r .= str_replace($tags, $code, $link);
			}
		}
		return $r;
	}
	
	/**
	 * This function allows you to limit the loop without using a limit inside another query. Or if you are using arrays / xml.
	 */
	public function paginator()
	{
		$this->i = $this->i+1;
		if( $this->i > $this->start() && $this->i <= $this->end() )
		{
			return true;
		}
	}
}