<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Регистрационная форма</title>
    <link rel ="stylesheet" href ="/style.css">
    <link rel ="stylesheet" href ="/form.css">
  </head>
  <body>
    <h1>Зарегистрироваться здесь!</h1>
    <p>Введите свое имя и адрес электронной почты и нажмите кнопку <strong>Отправить</strong> для регистрации.</p>
    <form method ="post" action ="index.php">
      <div>
        <input type ="text" name ="name" id ="name" placeholder ="Введите ваше имя">
        <input type ="text" name ="email" id ="email" placeholder ="Ваш еmail..">
        <input type ="submit" name ="submit" class ="btn" value ="Отправить">
        <br>
        <input type ="submit" name ="clear" class ="btn" value ="Очистить">
      </div>
      <div>
        <select name ="gender" id ="gender" class ="gen">
          <option value ="">All</option>
          <option value ="Man" <?php if($gender == 'Man'){echo 'selected';}?>>Man</option>
          <option value ="Woman" <?php if($gender == 'Woman'){echo 'selected';}?>>Woman</option>
        </select>
          <br>
        <input type ="submit" name ="filter" class ="btn" value ="Фильтр">
      </div>
      
      <?php
      try {
        $conn = new PDO("sqlsrv:server = tcp:olezhka.database.windows.net,1433; Database = Prime", "Skaylans", "Lgj231997");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if(isset($_POST['filter'])) {
        $gender = $_POST['gender'];
        $sql_select = 'SELECT * FROM registration_tb WHERE gender like :gender';
        $stmt = $conn->query($sql_select);
        $stmt->execute(array(':gender'=>$gender.'%'));
        $registrants = $stmt->fetchAll();
      
        foreach($registrants as $registrant) {
          "<tr><td>".$registrant['name']."</td>";
          "<td>".$registrant['email']."</td>";
          "<td>".$registrant['gender']."</td>";
          "<td>".$registrant['date']."</td></tr>";
      }
    }
      }
      catch (PDOException $e) {
        print("Ошибка подключения к SQL Server.");
        die(print_r($e));
      }
       
      ?>
      <?php
      try {
        $conn = new PDO("sqlsrv:server = tcp:olezhka.database.windows.net,1433; Database = Prime", "Skaylans", "Lgj231997");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if(isset($_POST["clear"])) {
          $sql1 = "DELETE FROM registration_tb";
          $conn->query($sql1);
        }
      }
      catch (PDOException $e) {
        print("Ошибка подключения к SQL Server.");
        die(print_r($e));
      }
      ?>
    </form>
    <?php
    try {
      $conn = new PDO("sqlsrv:server = tcp:olezhka.database.windows.net,1433; Database = Prime", "Skaylans", "Lgj231997");
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) {
      print("Ошибка подключения к SQL Server.");
      die(print_r($e));
    }
    if(!empty($_POST)) {
      try {
        $name   = $_POST['name'];
        $email  = $_POST['email'];
        $date   = date("Y-m-d");
        $gender = $_POST['gender'];
                
        // Insert data
        $sql_insert ="INSERT INTO registration_tb (name, email, date, gender) VALUES (?,?,?,?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $email);
        $stmt->bindValue(3, $date);
        $stmt->bindValue(4, $gender);
        $stmt->execute();
      }
      catch(Exception $e) {
        die(var_dump($e));
      }
      echo "<h3>Вы зарегистрировались!</h3>";
    }

      $sql_select = "SELECT * FROM registration_tb";
      $stmt = $conn->query($sql_select);
      $stmt->execute();
      $registrants = $stmt->fetchAll();
      if(count($registrants) > 0) {
        echo "<h2>Люди, которые зарегистрированы:</h2>";
        echo "<table>";
        echo "<tr><th>Name</th>";
        echo "<th>Email</th>";
        echo "<th>Gender</th>";
        echo "<th>Date</th></tr>";
        foreach($registrants as $registrant) {
          echo "<tr><td>".$registrant['name']."</td>";
          echo "<td>".$registrant['email']."</td>";
          echo "<td>".$registrant['gender']."</td>";
          echo "<td>".$registrant['date']."</td></tr>";
        }
        
        echo "</table>";
      }
      else {
        echo "<h3>В настоящее время никто не зарегистрирован.</h3>";
      }
    
   
    
      ?>
    
  </body>
</html>
