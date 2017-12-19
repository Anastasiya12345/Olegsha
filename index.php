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
          <form action="index.php" method="post">
            <div>
             <input type ="text" name ="name" id ="name" placeholder ="Введите ваше имя">
             <input type ="text" name ="email" id ="email" placeholder ="Ваш еmail..">
             <input type ="date" name ="date" id ="date" placeholder ="Дата">
             <div>
              <input type ="submit" name ="submit"  class ="btn" value ="Отправить">     
              <input type ="submit" name ="clear" class ="btn" id = "clr" value ="Очистить"></pre>
             </div>
            </div>
            <div>
              <select name ="gender"  class ="gen">
                <option value ="">All</option>
                <option value ="Man" <?php if($gender == 'Man'){echo 'selected';}?>>Man</option>
                <option value ="Woman" <?php if($gender == 'Woman'){echo 'selected';}?>>Woman</option>
              </select>
              <input type="submit" name="filter" class="btn" value="Фильтр">
         </div>
         <div class="col-md-3">
          <input type="text" name="from_date" id="from_date" class="form-control" placeholder="From Date" />
         </div>
         <div class="col-md-3">
          <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date" />
         </div>
         <input type="submit" name="order_date" class="btn" value="Отбор">
            </form>
            </body>
      </html>     

<?php
    $dsn = "sqlsrv:server = tcp:olezhka.database.windows.net,1433; Database = Prime";
    $username = "Skaylans";
    $password = "Lgj231997";

    try {
      $conn = new PDO($dsn, $username, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      if(isset($_POST["clear"])) {
        $sql1 = "DELETE FROM registration_T1";
        $conn->query($sql1);
      }
    }
    catch (PDOException $e) {
      print("Ошибка подключения к SQL Server.");
      die(print_r($e));
    }

    $conn = null;

?>

<?php

$dsn = "sqlsrv:server = tcp:olezhka.database.windows.net,1433; Database = Prime";
$username = "Skaylans";
$password = "Lgj231997";


      try {
        $conn = new PDO($dsn, $username, $password);
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
          //$date  = date("D-m-y");
          $date  = $_POST['date'];
          $gender = $_POST['gender'];
          //$age  = $_POST['age'];
          //$country  = $_POST['country'];
          //$birthday = $_POST['birthday'];

          if ($name == "" || $email == "") {
           echo "<h3>Не заполнены поля name и email.</h3>";
          }
          else {
            $sql_insert ="INSERT INTO registration_T1 (name, email, date, gender) VALUES (?,?,?,?)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bindValue(1, $name);
            $stmt->bindValue(2, $email);
            $stmt->bindValue(3, $date);
            $stmt->bindValue(4, $gender);
            //$stmt->bindValue(5, $age);
            //$stmt->bindValue(6, $country);
            //$stmt->bindValue(5, $birthday);
            $stmt->execute();
         
            echo "<h3>Вы зарегистрировались!</h3>";
          }
        }
        catch(Exception $e) {
          die(var_dump($e));
        }
       
      }

      $conn = null;

?>

<?php

$dsn = "sqlsrv:server = tcp:olezhka.database.windows.net,1433; Database = Prime";
$username = "Skaylans";
$password = "Lgj231997";

          try {
            $conn = new PDO($dsn, $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          }
          catch (PDOException $e) {
            print("Ошибка подключения к SQL Server.");
            die(print_r($e));
          }


          $sql_select = "SELECT * FROM registration_T1";
          $stmt = $conn->query($sql_select);
          $stmt->execute();
          if(isset($_POST['filter'])) {
            $gender = $_POST['gender'];
            $sql_select = "SELECT * FROM registration_T1 WHERE gender like :gender";
            $stmt = $conn->prepare($sql_select);
            $stmt->execute(array(':gender'=>$gender.'%'));
          }
          if(isset($_POST['order_date'])) {
            $date = $_POST['date'];
            $sql_select = "SELECT * FROM registration_T1 WHERE date like '".$_POST["from_date"]."' AND '".$_POST["to_date"]."'";
            $stmt = $conn->query($sql_select);
            $stmt->execute(array(':date'=>$date.'%'));
          }
          
          $registrants = $stmt->fetchAll();
          
          if(count($registrants) > 0) {
            echo "<h2>Люди, которые зарегистрированы:</h2>";
            echo "<table>";
            echo "<tr><th>Name</th>";
            echo "<th>Email</th>";
            echo "<th>Gender</th>";
            //echo "<th>Age</th>";
            //echo "<th>Country</th>";
            //echo "<th>Birthday</th>";
            echo "<th>Date</th></tr>";
            foreach($registrants as $registrant) {
              echo "<td>".$registrant['name']."</td>";
              echo "<td>".$registrant['email']."</td>";
              echo "<td>".$registrant['gender']."</td>";
              //echo "<td>".$registrant['age']."</td>";
              //echo "<td>".$registrant['country']."</td>";
              //echo "<td>".$registrant['birthday']."</td>";
              echo "<td>".$registrant['date']."</td></tr>";
            }
            echo "</table>";
          }
          else {
            echo "<h3>В настоящее время никто не зарегистрирован.</h3>";
          }

?>
