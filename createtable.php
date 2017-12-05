<?
try {
    $conn = new PDO("sqlsrv:server = tcp:olezhka.database.windows.net,1433; Database = Prime", "Skaylans", "Lgj231997");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if($sql == "") {
        echo "<h3>Таблица уже создана.</h3>"
    }
    else {
    $sql = "CREATE TABLE registration_tb(
    id INT NOT NULL IDENTITY(1,1), 
    PRIMARY KEY(id),
    name VARCHAR(30),
    email VARCHAR(30),
    gender VARCHAR(10),
    date DATE)";
    $conn->query($sql);
    }
    
}
catch (PDOException $e) {
    print("Ошибка подключения к SQL Server.");
    die(print_r($e));
}
echo "<h3>Таблица создана.</h3>";
?>
