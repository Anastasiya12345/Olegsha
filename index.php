
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
    <form method ="post" action ="index.php" enctype="multipart/form-data">
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
      <table>
        <tr>
          <td>Name</td>
          <td>Email</td>
          <td>Gender</td>
          <td>Date</td>
        </tr>
        <?php echo $tableContent; ?>
      </table>

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
      $tableContent = '';
      $sql_select = "SELECT * FROM registration_tb";
      $stmt = $conn->query($sql_select);
      $registrants = $stmt->fetchAll();

        foreach($registrants as $registrant) {
          $tableContent = $tableContent.'<tr>'.
                  '<td>'.$registrant['name'].'</td>'
                  .'<td>'.$registrant['email'].'</td>'
                  .'<td>'.$registrant['gender'].'</td>'
                  .'<td>'.$registrant['data'].'</td>';
        }

        if(isset($_POST['filter']) {
          $sql_select = $con->prepare('SELECT * FROM registration_tb WHERE gender like :gender');
          $sql_select->execute(array(':gender'=>$gender.'%'));
          $registrants = $stmt->fetchAll()
          foreach($registrants as $registrant) {
            $tableContent = $tableContent.'<tr>'.
                    '<td>'.$registrant['name'].'</td>'
                    .'<td>'.$registrant['email'].'</td>'
                    .'<td>'.$registrant['gender'].'</td>'
                    .'<td>'.$registrant['data'].'</td>';
            }
      }
      ?>
  </body>
</html>
