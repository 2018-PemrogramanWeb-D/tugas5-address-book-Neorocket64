<?php
session_start();
?>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

    <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "address_book";
        $db_city = $db_email = $db_name = $db_phone = "";
        $sql = "";

        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $db_name = test_input($_POST["db_name"]);
            $db_city = test_input($_POST["db_city"]);
            $db_phone = test_input($_POST["db_phone"]);
            $db_email = test_input($_POST["db_email"]);

            $sql = "INSERT INTO the_book (name, city, phone, email)
            VALUES ('$db_name', '$db_city', '$db_phone', '$db_email')";
        }

        function test_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        function db_inserting($conn, $sql)
        {
            if ($_SERVER["REQUEST_METHOD"] == "POST")
            {
                if ($conn->query($sql) === TRUE)
                {
                    echo "Successfully created data!";
                }
                else
                {
                    echo "Error! " . $sql  . $conn->error;
                }  
            }
            else echo "None";
        }

        function db_search($conn, $sql)
        {
            $sql = "SELECT id, name, city, phone, email FROM the_book";
            $result = $conn->query($sql);
            if ($result->num_rows > 0)
            {
                ?><table id="foretable">
                    <?php echo"
                         <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>City</th>
                            <th>Phone Number</th>
                            <th>E-Mail</th>
                        </tr>";
                while($row = $result->fetch_assoc())
                {
                     echo "<tr><td>" . $row["id"]
                     . "</td><td>" . $row["name"]
                    . "</td><td>" . $row["city"]
                    . "</td><td>". $row["phone"]
                    . "</td><td>". $row["email"]. "</td></tr>";
                }
                echo "</table>";
            }
            
        }
    ?>

    <head>
        <title>What</title>
        <link rel='stylesheet' type='text/css' href='style.css'>
        <p>
            Insert Data | <a href="ini.php">Update Data</a> | <a href="kehilangan.php">Delete Data</a>
        </p>
    </head>

    <body>
        <div id="insertion">
            <b>Insert Data on Address Book</b> <br />
            <form id="pointing" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  
                Name:&emsp;<input type="text" name="db_name"> <br />
                City:&emsp;&emsp;<input type="text" name="db_city"> <br />
                Phone:&emsp;<input type="text" name="db_phone"> <br />
                E-Mail:&emsp;<input type="text" name="db_email"> <br />
                <input type="submit" name="submit" value="Submit">      
            </form>
            Message: <?php db_inserting($conn, $sql) ?><br />
        </div>

        <div>   
            <?php db_search($conn, $sql) ?>
        </div>
    </body>
</html>