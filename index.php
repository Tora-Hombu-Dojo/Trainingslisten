<!DOCTYPE html>
<html>
<head>
<title>Tora Hombu Dojo Trainigsliste</title>
<style type="text/css">
@media print{
@page {
margin: 5mm;
size: landscape
}
div {display: none;}
}
table {
border-collapse: collapse;
margin: 5px 0px;
width: 100%;
}
td {
border: 1px solid #000;
font-size: 9px;
text-align: center;
}
.name {
font-size: 12px;
width: 10%;
}
</style>
</head>
<body>
<?php

$number_of_trainees = 15;
$training_days = [1, 4];

$year = date('Y');

if(isset($_REQUEST['year']) && preg_match('/^[0-9]{4}$/', $_REQUEST['year'])) {
    $year = $_REQUEST['year'];
}

$next_year = $year + 1;

echo "<div><a href=\"?year=$year\">$year</a> <a href=\"?year=$next_year\">$next_year</a></div>";
echo "<h1>Tora Hombu Dojo Trainingsliste<br>Karate Oberstufe $year</h1>";

$date = new DateTime("$year-01-01");
$date->add(new DateInterval('P1D'));

$trainings = [];

while($date->format('Y') == $year) {
    if(in_array($date->format('w'), $training_days)) {
         $trainings[] = clone $date;
    }
    $date->add(new DateInterval('P1D'));
}

$trainings = array_chunk($trainings, ceil(count($trainings)/2));
foreach($trainings as $table_row) {
    render_table($table_row, $number_of_trainees);
}

function render_table($trainings, $number_of_trainees) {
echo "<table>";
echo "<tr><td class=\"name\">Name</td>";
foreach($trainings as $date) {
    echo "<td>" . $date->format('d.') . "<br>". $date->format('m.') ."</td>";
}
echo "</tr>";
for($line = 0; $line < $number_of_trainees; $line++) {
    echo "<tr><td class=\"name\">&nbsp;</td>";
    for($column = 0; $column < count($trainings); $column++) {
        echo "<td>&nbsp;</td>";
    }
    echo "</tr>";
}

echo "</table>";
}
?>
</body>
</html>
