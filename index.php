<html>
  <head>
    <meta charset="utf-8">
    <title>Registration Form</title>
    <link rel="stylesheet" href="/style.css">
    <link rel="stylesheet" href="/form.css">
  </head>
  <body>
    <h1>Register here!</h1>
    <p>Fill in your name and email address, then click <strong>Submit</strong> to register.</p>
    <form method="post" action="index.php" enctype="multipart/form-data">
      <div>
        <input type="text" id="name" placeholder="Ваше имя">
        <input type="email" id="email" placeholder="Email..">
        <input type="submit" name="submit" class="btn" value="Отправить">
      </div>
      <div>
        <select id="email" class="gen">
          <option>Выберите пол</option>
          <option value="S1">Муж</option>
          <option value="S2">Жен</option>
        </select>
      </div>
    </form>

    <?php
    try {
      $conn = new PDO("sqlsrv:server = tcp:olezhka.database.windows.net,1433; Database = Prime", "Skaylans", "Lgj231997");
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) {
      print("Error connecting to SQL Server.");
      die(print_r($e));
    }
    if(!empty($_POST)) {
    try {
      $name = $_POST['name'];
      $email = $_POST['email'];
      $date = date("Y-m-d");
        // Insert data
      $sql_insert = "INSERT INTO registration_tbl (name, email, date) VALUES (?,?,?)";
      $stmt = $conn->prepare($sql_insert);
      $stmt->bindValue(1, $name);
      $stmt->bindValue(2, $email);
      $stmt->bindValue(3, $date);
      $stmt->execute();
    }
    catch(Exception $e) {
      die(var_dump($e));
    }
    echo "<h3>Your're registered!</h3>";
    }
    $sql_select = "SELECT * FROM registration_tbl";
    $stmt = $conn->query($sql_select);
    $registrants = $stmt->fetchAll();
    if(count($registrants) > 0) {
      echo "<h2>People who are registered:</h2>";
      echo "<table>";
      echo "<tr><th>Name</th>";
      echo "<th>Email</th>";
      echo "<th>Date</th></tr>";
      foreach($registrants as $registrant) {
        echo "<tr><td>".$registrant['name']."</td>";
        echo "<td>".$registrant['email']."</td>";
        echo "<td>".$registrant['date']."</td></tr>";
        }
        echo "</table>";
    } else {
      echo "<h3>No one is currently registered.</h3>";
    }
    ?>

  </body>
</html>
