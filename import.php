<?php

//Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mivento";

// Create connection
$pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
// set the PDO error mode to exception
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//Get the file
$fh = fopen($_FILES['csv']['tmp_name'], 'r');
if (!$fh) {
    die("Dosya açılamadı");
}

//Import row by row
$stored = [];
$flag = true;
while (($row = fgetcsv($fh, 0, ';')) !== FALSE) {
    //Skip the first row
    if ($flag) {
        $flag = false;
        continue;
    }

    $stored[] = [
        "name" => $row[0],
        "surname" => $row[1],
        "email" => $row[2],
        "employee_id" => $row[3],
        "phone" => $row[4],
        "point" => $row[5],
    ];

    try {
//        $stmt = $pdo->prepare("INSERT INTO employees (`name`, `surname`, `email`, `employee_id`, `phone`, `point`) VALUES (?, ?, ?, ?, ?, ?)");
//        $stmt->execute([
//            $row[0],
//            $row[1],
//            $row[2],
//            $row[3],
//            $row[4],
//            $row[5]
//        ]);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function unique_multidim_array($array, $key)
{
    $i = 0;
    $temp_array = [];
    $key_array = [];

    foreach ($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
}

$unique_field = ['email', 'employee_id', 'phone'];
//foreach ($unique_field as $field) {
//    $stored = unique_multidim_array($stored, $field);
//}
//print_r($stored);

function remove_duplicate_multidim_array($array, $keys){
    $result = array_map("unserialize", array_unique(array_map("serialize", $array)));
    foreach($result as $key => $value){
        foreach($keys as $k){
            unset($result[$key][$k]);
        }
    }
    return $result;
}

//remove_duplicate_multidim_array($stored, $unique_field);
print_r(remove_duplicate_multidim_array($stored, $unique_field));

//Close the file
fclose($fh);
echo "Dosya başarıyla yüklendi";