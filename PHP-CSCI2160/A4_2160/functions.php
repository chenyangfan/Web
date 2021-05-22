<!-- CSCI2170 Author:YangfanChen Assignment2 Description: this piece of code will be used as a placeholder for assginemnt 3 -->
<?php
include_once 'serverLogin.php';
// This function connects to the db, and returns the connection object.
function connectToDB()
{
    global $db_hostname;
    global $db_username;
    global $db_password;
    global $db_database;
    $conn = new mysqli($db_hostname, $db_username, $db_password, $db_database);
    if ($conn->connect_error) {
        die("Connection Failed!" . mysqli_connect_error());
    }
    mysqli_select_db($conn, $db_database) or die("Unable to select database:" . mysql_error());
    return $conn;
}

// This function closes the connection.
function closeConnection($conn)
{
    $conn->close();
}

// handles general select queries and return the result
function selectQuery($conn, $query,$param)
{
    $stmt = $conn -> prepare($query);
    if($param != null){
        $stmt -> bind_param("s",$param);
    }
    $stmt -> execute();
    $result = $stmt -> get_result();
    return $result;
}

// this function will handle or the insertion query.
function insertQuery($conn, $query)
{
    $conn->query($query);
}

// this will return the user object.
function getUserInfo($conn, $userID = 1)
{
    $query = "SELECT * FROM Users WHERE UserID =?";
    $stmt =$conn -> prepare($query);
    $stmt -> bind_param("i",$userID);
    $stmt -> execute();
    $result = $stmt->get_result();
    $userInfo = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $userInfo["Name"] = $row["Name"];
            $userInfo["About"] = $row["About"];
            $userInfo["Image"] = $row["AboutImage"];
            $userInfo["Image"] = "img/" . $userInfo["Image"];
        }
    }
    return $userInfo;
}
?>