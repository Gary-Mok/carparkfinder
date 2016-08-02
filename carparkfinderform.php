<html>

<body>

<div>

    <h1>Car Park Finder</h1>

    <?php

    echo 'Input location or postcode.';

    ?>

</div>

<div>

    <form action="carparkfinder.php" method="post">
        Location: <input type="text" name="location"><br>
        Postcode: <input type="text" name="postcode"><br>
        <input type="submit">
    </form>

</div>

</body>

</html>
