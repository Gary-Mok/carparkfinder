<html>

<head>
    <link type='text/css' rel='stylesheet' href='/style/backend.css'/>

    <script src="https://code.jquery.com/jquery-3.1.0.js"></script>
    <script src="script.js"></script>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <title>
        Holding Requests
    </title>
</head>

<body>

<?php

include 'bootstrap.php';

if (!isset($_SESSION['username'])) {
    header("Location: search.php");
    exit();
}

if ($_SESSION['type'] !== "admin") {
    echo 'You do not have the administrative right to view this page. Please return to the <a href="search.php">main page</a>.';
    return '';
}

?>

<div>

    <h1>Car Park Finder</h1>

</div>

<?php include 'navigation.php' ?>

<div>

    <h2>All user requests:</h2>

</div>

<div>

    <?php

    $sql = 'SELECT holding.id, members.username, holding_type.type, holding.name, holding.owner, holding.location, holding.postcode, holding.vacancies, holding.credit, transaction_type.description, holding.update_id FROM holding
            INNER JOIN members ON holding.member_id=members.id
            INNER JOIN holding_type ON holding.holding_type_id=holding_type.id
            INNER JOIN transaction_type ON holding.transaction_type_id=transaction_type.id
            ORDER BY holding.id ASC';
    $query = $db->prepare($sql);
    $check = $query->execute();

    if ($check === false) {
        die('There was an error running the query [' . $db->errorInfo() . ']'); //error message if query fails
    }

    echo '<form method="post" id="request">';

    echo '<strong><label for="ckbCheckAll">Select all</label></strong> <input type="checkbox" id="ckbCheckAll" name="all" value="">';

    echo '<table><tr>
                    <th>ID</th>
                    <th>Member</th>
                    <th>Request Type</th>
                    <th>Name</th>
                    <th>Owner</th>
                    <th>Location</th>
                    <th>Postcode</th>
                    <th>Vacancies</th>
                    <th>Request Cost</th>
                    <th>Transaction Type</th>
                    <th>ID of Updated Car Park</th>
                 </tr>';

    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr class="tableContents">
                <td>' . $row['id'] . '</td>
                <td>' . $row['username'] . '</td>
                <td>' . $row['type'] . '</td>
                <td>' . $row['name'] . '</td>
                <td>' . $row['owner'] . '</td>
                <td>' . $row['location'] . '</td>
                <td>' . $row['postcode'] . '</td>
                <td>' . $row['vacancies'] . '</td>
                <td>' . $row['credit'] . '</td>
                <td>' . $row['description'] . '</td>
                <td>' . $row['update_id'] . '</td>
                <td><input type="checkbox" class="checkBoxClass" id="Checkbox' . $row['id'] . '" name="list[]" value="' . $row['id'] . '"></td>
              </tr>';
    }

    echo '</table><br/>';

    echo '<input type="submit" name="requestAccept" id="requestButton" value="Accept"> <input type="submit" name="requestReject" id="requestButton" value="Reject">';

    echo '</form>';

    if (!isset($_POST['requestAccept']) && !isset($_POST['requestReject'])) {
        return '';
    }

    if (empty($_POST['list'])) {
        return '';
    }

    if (isset($_POST['requestAccept'])) {

        foreach ($_POST['list'] as $request_id) {
            $sql = 'SELECT holding.id, holding.member_id, holding_type.type, holding.name, holding.owner, holding.location, holding.postcode, holding.vacancies, holding.credit, holding.transaction_type_id, holding.update_id FROM holding
                INNER JOIN holding_type ON holding.holding_type_id=holding_type.id
                WHERE holding.id = ' . $request_id;
            $query = $db->prepare($sql);
            $trans = $query->execute();
            $row = $query->fetch(PDO::FETCH_ASSOC);

            if ($trans === false) {
                die('There was an error running the query [' . $db->errorInfo() . ']'); //error message if query fails
            }

            if ($row['type'] == 'create') {

                $sql = 'INSERT INTO car_parks (name, owner, location, postcode, vacancies, member_id)
                    VALUES (:name, :owner, :location, :postcode, :vacancies, :id)';
                $query = $db->prepare($sql);
                $check = $query->execute(['name' => $row['name'], 'owner' => $row['owner'], 'location' => $row['location'], 'postcode' => $row['postcode'], 'vacancies' => $row['vacancies'], 'id' => $row['member_id']]);

                if ($check === false) {
                    die('There was an error running the query [' . $db->errorInfo() . ']'); //error message if query fails
                }

                $sql = 'INSERT INTO transactions (member_id, transaction_type_id, credit, create_at)
                    VALUES (:id , :type_id , :payment , NOW())';
                $query = $db->prepare($sql);
                $check = $query->execute(['id' => $row['member_id'], 'type_id' => $row['transaction_type_id'], 'payment' => $row['credit']]);

                if (false === $check) {
                    die('There was an error running the query [' . $db->errorInfo() . ']'); //error message if query fails
                }

                $sql = 'DELETE FROM holding WHERE id = :id';
                $query = $db->prepare($sql);
                $check = $query->execute(['id' => $row['id']]);

                if ($trans === false) {
                    die('There was an error running the query [' . $db->errorInfo() . ']'); //error message if query fails
                }
            }

            if ($row['type'] == 'update') {

                $keysList = array(); //define list of columns to update as array

                $valuesList = array(); //define list of fields to update as array

                foreach ($row as $key => $value) {
                    if ($key !== 'id' &&
                        $key !== 'member_id' &&
                        $key !== 'type' &&
                        $key !== 'credit' &&
                        $key !== 'transaction_type_id' &&
                        $key !== 'update_id' &&
                        $value !== '0' &&
                        strlen($value) !== 0
                    ) {

                        array_push($keysList, $key);

                        array_push($valuesList, $value);
                    }
                }

                $queryArray = array(); //define empty array

                for ($i = 0; $i <= count($keysList) - 1; ++$i) {
                    $queryArray[$i] = $keysList[$i] . " = '" . $valuesList[$i] . "' "; //merge both arrays into one
                }

                $query = implode(', ', $queryArray); //form mysql query code by imploding merged array with commas

                $sqlUpdate = 'UPDATE car_parks SET ' . $query . 'WHERE id= :id';
                $queryUpdate = $db->prepare($sqlUpdate);
                $update = $queryUpdate->execute(['id' => $row['update_id']]);

                if ($update === false) {
                    echo 'Error: ' . $sqlUpdate . '<br>';
                    var_dump($db->errorInfo()); //error message if request fails
                    return;
                }

                $sql = 'DELETE FROM holding WHERE id = :id';
                $query = $db->prepare($sql);
                $check = $query->execute(['id' => $row['id']]);

                if ($trans === false) {
                    die('There was an error running the query [' . $db->errorInfo() . ']'); //error message if query fails
                }

            }

        }

    } elseif (isset($_POST['requestReject'])) {

        foreach ($_POST['list'] as $request_id) {

            $sql = 'DELETE FROM holding WHERE id = :id';
            $query = $db->prepare($sql);
            $check = $query->execute(['id' => $request_id]);

            if ($trans === false) {
                die('There was an error running the query [' . $db->errorInfo() . ']'); //error message if query fails
            }

        }

    }

    ?>

    <?php

    header("Location: holding.php");

    ?>

</div>

</body>

</html>
