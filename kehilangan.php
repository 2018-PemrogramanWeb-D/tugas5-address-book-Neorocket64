<?php
session_start();
?>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

    <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "address_book";
        $db_id = "";
        $sql = "";

        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if ($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $db_id = $_POST["db_id"];
            $sql = "DELETE FROM the_book WHERE id= $db_id";
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
                    echo "Removed successfully!";
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

        function db_droplist($conn, $sql)
        {
            $sql = "SELECT id, name, city, phone, email FROM the_book";
            $result = $conn->query($sql);
            if ($result->num_rows > 0)
            {
                while($row = $result->fetch_assoc())
                {
                    ?>
                    <option value="<?php echo $row['id']?>"><?php echo $row['id']?></option>
                    <?php
                }
            } 
        }
    ?>

    <head>
        <title>What</title>
        <link rel='stylesheet' type='text/css' href='style.css'>
        <p>
            <a href="apakah.php">Insert Data</a> | <a href="ini.php">Update Data</a> | Delete Data
        </p>
    </head>

    <body>
        <div id="insertion">
            <b>Delete Data from Address Book</b> <br />
            <form id="pointing" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <select name="db_id">
                    <?php db_droplist($conn, $sql) ?>
                </select> <br />
                <input type="submit" name="remove" value="Remove">      
            </form>
            Message: <?php db_inserting($conn, $sql) ?><br />
        </div>

        <div>   
            <?php db_search($conn, $sql) ?>
        </div>
    </body>
</html>