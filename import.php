<?php

//database connection
include_once 'config/connection.php';

//validation
if(empty($_POST['name']) || empty($_POST['date'])){
    echo json_encode([
        'status' => 'error',
        'message' => 'Lütfen zorunlu alanları doldurunuz.'
    ]);
    exit;
}

//insert campaigns
try{
    //insert query
    $stmt = $pdo->prepare("INSERT INTO campaigns (name, date) VALUES (?, ?)");
    $stmt->execute([
        $_POST['name'],
        $_POST['date']
    ]);
//get last inserted id
    $last_id = $pdo->lastInsertId();
}catch (PDOException $e){
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage()
    ]);
}

//Get the file
ini_set('auto_detect_line_endings', TRUE);
$fh = fopen($_FILES['csv']['tmp_name'], 'r');
if (!$fh) {
    die("Dosya açılamadı");
}

//Import csv data
$flag = true;
while (($row = fgetcsv($fh, 0, ';')) !== FALSE) {
    //Skip the first row
    if ($flag) {
        $flag = false;
        continue;
    }

    //rename
    $row = [
        "name" => $row[0],
        "surname" => $row[1],
        "email" => $row[2],
        "employee_id" => $row[3],
        "phone" => $row[4],
        "point" => $row[5],
    ];

    //validate email if not valid skip
    if (!filter_var($row["email"], FILTER_VALIDATE_EMAIL)) {
        continue;
    }
    //phone validation if not valid replace format
    if (!preg_match('/^[5][0-9]{9}$/', $row["phone"])) {
        //purge special characters
        $row["phone"] = preg_replace('/[^0-9]/', '', $row["phone"]);
        //remove 0 from the beginning
        $row["phone"] = ltrim($row["phone"], '0');
    }

    try {
        //insert all data
        $stmt = $pdo->prepare("INSERT INTO employees (`campaign_id`, `name`, `surname`, `email`, `employee_id`, `phone`, `point`) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $last_id,
            $row["name"],
            $row["surname"],
            $row["email"],
            $row["employee_id"],
            $row["phone"],
            $row["point"]
        ]);

        //remove duplicate emails to database
        $stmt = $pdo->prepare("DELETE FROM employees WHERE email IN (SELECT a.email FROM (
            SELECT COUNT(*) AS cnt, email FROM employees GROUP BY email HAVING cnt>1) AS a);");
        $stmt->execute();
        //remove duplicate employee_id to database
        $stmt = $pdo->prepare("DELETE FROM employees WHERE employee_id IN (SELECT a.employee_id FROM (
            SELECT COUNT(*) AS cnt, employee_id FROM employees GROUP BY employee_id HAVING cnt>1) AS a);");
        $stmt->execute();
        //remove duplicate phone to database
        $stmt = $pdo->prepare("DELETE FROM employees WHERE phone IN (SELECT a.phone FROM (
            SELECT COUNT(*) AS cnt, phone FROM employees GROUP BY phone HAVING cnt>1) AS a);");
        $stmt->execute();
    } catch (PDOException $e) {
        echo json_encode([
            "status" => "error",
            "message" => $e->getMessage()
        ]);
    }
}

//Close the file
ini_set('auto_detect_line_endings', FALSE);
fclose($fh);

echo json_encode([
    "status" => "success",
    "message" => "Veriler başarıyla eklendi"
]);