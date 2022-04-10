<?php
if(!defined('_VALID_ACCESS')) { header ("location: index.php"); die; }

$adjacents = 2;

/* Setup page vars for display. */
if(isset($_GET["page"]))
{
	$page=$_GET["page"];
} else {
	$page=1;
}
$prev = $page - 1;							//previous page is page - 1
$next = $page + 1;							//next page is page + 1
$lastpage = ceil($total_no_of_records/$records_per_page);		//lastpage is = total pages / items per page, rounded up.
$lpm1 = $lastpage - 1;						//last page minus 1
/*
	Now we apply our rules and draw the pagination object.
	We're actually saving the code to a variable in case we want to draw it more than once.
*/
$pagination = "";
if($lastpage > 1)
{
	$pagination .= "<ul class=\"pagination\">";
	//previous button
	if ($page > 1)
		$pagination.= "<li><a href=\"$self&page=$prev\"><< prev</a></li>";
	else
		$pagination.= "<li><span class=\"disabled\"><< prev</span></li>";

		//pages
	if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
	{
		for ($counter = 1; $counter <= $lastpage; $counter++)
		{
			if ($counter == $page)
				$pagination.= "<li><span class=\"current\">$counter</span></li>";
			else
				$pagination.= "<li><a href=\"$self&page=$counter\">$counter</a></li>";
		}
	}
	elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
	{
		//close to beginning; only hide later pages
		if($page < 1 + ($adjacents * 2))
		{
			for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
			{
				if ($counter == $page)
					$pagination.= "<li><span class=\"current\">$counter</span></li>";
				else
					$pagination.= "<li><a href=\"$self&page=$counter\">$counter</a></li>";
			}
			$pagination.= "<li><span>...</span></li>";
			$pagination.= "<li><a href=\"$self&page=$lpm1\">$lpm1</a></li>";
			$pagination.= "<li><a href=\"$self&page=$lastpage\">$lastpage</a></li>";
		}
		//in middle; hide some front and some back
		elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
		{
			$pagination.= "<li><a href=\"$self&page=1\">1</a></li>";
			$pagination.= "<li><a href=\"$self&page=2\">2</a></li>";
			$pagination.= "<li><span>...</span></li>";
			for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<li><span class=\"current\">$counter</span></li>";
				else
					$pagination.= "<li><a href=\"$self&page=$counter\">$counter</a></li>";
			}
			$pagination.= "<li><span>...</span></li>";
			$pagination.= "<li><a href=\"$self&page=$lpm1\">$lpm1</a></li>";
			$pagination.= "<li><a href=\"$self&page=$lastpage\">$lastpage</a></li>";
		}
		//close to end; only hide early pages
		else
		{
			$pagination.= "<li><a href=\"$self&page=1\">1</a></li>";
			$pagination.= "<li><a href=\"$self&page=2\">2</a></li>";
			$pagination.= "<li><span>...</span></li>";
			for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<li><span class=\"current\">$counter</span></li>";
				else
					$pagination.= "<li><a href=\"$self&page=$counter\">$counter</a></li>";
			}
		}
	}

	//next button
	if ($page < $counter - 1)
		$pagination.= "<li><a href=\"$self&page=$next\">next >></a></li>";
	else
		$pagination.= "<li><span class=\"disabled\">next >></span></li>";
	$pagination.= "</ul>\n";
}

echo $pagination;

?>
