<!DOCTYPE html>
<html>
    <head>
        <title>Tora Hombu Dojo Trainigsliste</title>
        <style type="text/css">
            @media print {
                @page {
                    margin: 5mm;
                    size: landscape
                }
                div {
                    display: none;
                }
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

// Anzahl der leeren Zeilen, in die Namen der Schüler eingetragen werden können.
$number_of_trainees = 15;

// Trainingspläne
$training_names = ['Karate Oberstufe', 'Karate Unterstufe'];

// Wochentage in denen Training stattfindet (1=Montag, 2=Dienstag, usw.)
$training_days = [1, 4];

// Jahr ermitteln
// Default ist das aktuelle Jahr
$year = date('Y');
if(isset($_REQUEST['year']) && preg_match('/^[0-9]{4}$/', $_REQUEST['year'])) {
    $year = $_REQUEST['year'];
}
$next_year = $year + 1;

// Training ermitteln
// Default ist der erste Eintrag
$selected_training = $training_names[0];
if(isset($_REQUEST['training']) && in_array($_REQUEST['training'], $training_names)) {
    $selected_training = $_REQUEST['training'];
}

// Header zur Auswahl von Jahr und Training anzeigen
echo "<div>";
echo "<a href=\"?year=$year&training=$training_name\">$year</a> ";
echo "<a href=\"?year=$next_year&training=$training_name\">$next_year</a> ";
foreach($training_names as $training_name) {
    echo "<a href=\"?year=$year&training=$training_name\">$training_name</a> ";
}
echo "</div>";

// Überschrift
echo "<h1>Tora Hombu Dojo Trainingsliste<br>$selected_training $year</h1>";

// Liste der Trainingstage erstellen
// Beginn am 01.01.
$date = new DateTime("$year-01-01");
$trainings = [];
while($date->format('Y') == $year) {
    if(in_array($date->format('w'), $training_days)) {
         $trainings[] = clone $date;
    }
    $date->add(new DateInterval('P1D'));
}

// Aufteilung der Termine auf mehrere Reihen und Ausgabe
$trainings = array_chunk($trainings, ceil(count($trainings)/2));
foreach($trainings as $table_row) {
    render_table($table_row, $number_of_trainees);
}

// Ausgabe einer Trainingsreihe/Tabelle
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
