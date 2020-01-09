<?php

$year = date('Y');

if(isset($_REQUEST['year']) && preg_match('/^[0-9]{4}$/')) {
    $year = $_REQUEST['year'];
}

$next_year = $year + 1;

echo "<div><a href=\"?year=$year\">$year</a><a href=\"?year=$next_year\">$next_year</a></div>";