<?
try {
    $conn = new PDO("sqlsrv:server = tcp:olezhka.database.windows.net,1433; Database = Prime", "Skaylans", "Lgj231997");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "CREATE TABLE registration_tbl(
    id INT NOT NULL IDENTITY(1,1), 
    PRIMARY KEY(id),
    name VARCHAR(30),
    email VARCHAR(30),
    date DATE,
    sex VARCHAR(30))";
    $conn->query($sql);
}
catch (PDOException $e) {
    print("Error connecting to SQL Server.");
    die(print_r($e));
}
echo "<h3>Table created.</h3>";
?>
