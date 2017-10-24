<?php
include "SQLConnection.php";
require_once 'PHPExcel-1.8/Classes/PHPExcel.php';

$newSQL = new SQLConnection();
$conn = $newSQL->makeConn();

$letters = "ABCDEFGHIJKLMNOPQRSTUVWZYZ";

$objPHPExcel = new PHPExcel();

$query = "select p.firstname, p.middlename, p.lastname, dob, p.phone, email, housenumber, street, citycounty, stateabb, countryabb, "
            . "zipcode, teamname, apstatus, ec.firstname as 'ECfirstname', ec.lastname as 'EClastname', ec.relationship as 'ECrelationship', "
            . "ec.phone as 'ECphone' from team t inner join teamstatus ts on t.teamid = ts.teamid inner join person p on ts.personid = p.personid "
            . "inner join login l on p.personid = l.personid inner join emergcontact ec on p.personid = ec.personid";
$stmt = $conn->prepare($query);
$stmt->execute();
$i = 1;
$j = 0;
if ($result = $stmt->get_result()) {

    /* Get field information for all columns */
    $fieldInfo = $result->fetch_fields();

    foreach ($fieldInfo as $val) {
        $objPHPExcel->getActiveSheet()->setCellValue((string)(substr($letters, $j, 1).$i), $val->name);
        $j++;
    }
    $result->free();
}
$query = "select p.firstname, p.middlename, p.lastname, dob, p.phone, email, housenumber, street, citycounty, stateabb, countryabb, "
    . "zipcode, teamname, apstatus, ec.firstname as 'ECfirstname', ec.lastname as 'EClastname', ec.relationship as 'ECrelationship', "
    . "ec.phone as 'ECphone' from team t inner join teamstatus ts on t.teamid = ts.teamid inner join person p on ts.personid = p.personid "
    . "inner join login l on p.personid = l.personid inner join emergcontact ec on p.personid = ec.personid";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$i++;
while ($row = $result->fetch_assoc()) {
    $j = 0;
    $objPHPExcel->getActiveSheet()->setCellValue((string)(substr($letters, $j, 1).$i), $row["firstname"]);
    $j++;
    $objPHPExcel->getActiveSheet()->setCellValue((string)(substr($letters, $j, 1).$i), $row["middlename"]);
    $j++;
    $objPHPExcel->getActiveSheet()->setCellValue((string)(substr($letters, $j, 1).$i), $row["lastname"]);
    $j++;
    $objPHPExcel->getActiveSheet()->setCellValue((string)(substr($letters, $j, 1).$i), $row["dob"]);
    $j++;
    $objPHPExcel->getActiveSheet()->setCellValue((string)(substr($letters, $j, 1).$i), $row["phone"]);
    $j++;
    $objPHPExcel->getActiveSheet()->setCellValue((string)(substr($letters, $j, 1).$i), $row["email"]);
    $j++;
    $objPHPExcel->getActiveSheet()->setCellValue((string)(substr($letters, $j, 1).$i), $row["housenumber"]);
    $j++;
    $objPHPExcel->getActiveSheet()->setCellValue((string)(substr($letters, $j, 1).$i), $row["street"]);
    $j++;
    $objPHPExcel->getActiveSheet()->setCellValue((string)(substr($letters, $j, 1).$i), $row["citycounty"]);
    $j++;
    $objPHPExcel->getActiveSheet()->setCellValue((string)(substr($letters, $j, 1).$i), $row["stateabb"]);
    $j++;
    $objPHPExcel->getActiveSheet()->setCellValue((string)(substr($letters, $j, 1).$i), $row["countryabb"]);
    $j++;
    $objPHPExcel->getActiveSheet()->setCellValue((string)(substr($letters, $j, 1).$i), $row["zipcode"]);
    $j++;
    $objPHPExcel->getActiveSheet()->setCellValue((string)(substr($letters, $j, 1).$i), $row["teamname"]);
    $j++;
    $objPHPExcel->getActiveSheet()->setCellValue((string)(substr($letters, $j, 1).$i), $row["apstatus"]);
    $j++;
    $objPHPExcel->getActiveSheet()->setCellValue((string)(substr($letters, $j, 1).$i), $row["ECfirstname"]);
    $j++;
    $objPHPExcel->getActiveSheet()->setCellValue((string)(substr($letters, $j, 1).$i), $row["EClastname"]);
    $j++;
    $objPHPExcel->getActiveSheet()->setCellValue((string)(substr($letters, $j, 1).$i), $row["ECrelationship"]);
    $j++;
    $objPHPExcel->getActiveSheet()->setCellValue((string)(substr($letters, $j, 1).$i), $row["ECphone"]);
    $i++;
}
$stmt->close();

$objPHPExcel->getActiveSheet()->setTitle('Volunteers');

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Volunteers.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

?>