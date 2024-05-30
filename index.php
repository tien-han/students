<?php

    /**
     * 328/students/index.php
     * Practice PDO
     */

    //Turn on error reporting
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require_once $_SERVER['DOCUMENT_ROOT'].'/../config.php';

    try {
        //Instantiate our PDO Database object
        $dbh = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
    } catch(PDOException $e) {
        //echo $e->getMEssage();
        die($e->getMessage());
    }

    include ('add-student.html');

    //PDO
    //Fetch All QUERY
    //1. Define the query
    $sql = 'SELECT * FROM student';

    //2. Prepare the statement
    $statement = $dbh->prepare($sql);

    //3. Bind the parameters
    //$id = 3;
    //$statement->bindParam(':id', $id, PDO::PARAM_INT);

    //4. Execute the query
    $statement->execute();

    //5. Process the results
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    echo "<h1>Student List</h1>";
    echo "<ol>";
    foreach ($result as $row) {
        echo "<li>" . $row['last'] . ', ' . $row['first'] . "</li>";
    }
    echo "</ol>";


    //INSERT QUERY
    //1. Define the query
    $sql = 'INSERT INTO student (sid, last, first, birthdate, gpa, advisor)
            VALUES (:sid, :last, :first, :birthdate, :gpa, :advisor)';

    //2. Prepare the statement
    $statement = $dbh->prepare($sql);

    //3. Bind the parameters

    //Note: Data should be in this format when submitting a form response
    $sid = '987-43-6554';
    $last = 'Casey';
    $first = 'Sam';
    $birthdate = '2024-05-23';
    $gpa = 4.0;
    $advisor = 3;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $sid = $_POST['sid'];
        $last = $_POST['last'];
        $first = $_POST['first'];
        $birthdate = $_POST['birthdate'];
        $gpa = $_POST['gpa'];
        $advisor = $_POST['advisor'];
    }

    $statement->bindParam(':sid', $sid);
    $statement->bindParam(':last', $last);
    $statement->bindParam(':first', $first);
    $statement->bindParam(':birthdate', $birthdate);
    $statement->bindParam(':gpa', $gpa);
    $statement->bindParam(':advisor', $advisor);

    //4. Execute the query
    $statement->execute();

    //5. Process the results
    $id = $dbh->lastInsertId();
    echo $id . "was inserted!";