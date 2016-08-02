<html>

<body>

<p>

<div>

    <h1>Create new data.</h1>

<?php

echo 'Enter data for the following fields:';

?>

</div>

<div>

    <form action="carparkfinderbackend.php" method="post">
        Name: <input type="text" name="name"><br>
        Owner: <input type="text" name="owner"><br>
        Location: <input type="text" name="location"><br>
        Postcode: <input type="text" name="postcode"><br>
        Vacancies: <input type="text" name="vacancies"><br>
        <input type="submit">
    </form>

</div>

</p>

</body>

</html>
