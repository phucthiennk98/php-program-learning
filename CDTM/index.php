<?php
require './config/database.php';
if (isset($_POST['submit-delete-id'])) {
    echo "aaaa";
}
//Add employee:

$firstname = $lastname = $age = $title = '';
$firstname_err = $lastname_err = $age_err = $title_err = '';
$connection1 = null;

try {
    $connection1 = new PDO(
        "mysql:host=" . DATABASE_SERVER . ";dbname=" . DATABASE_NAME,
        DATABASE_USER,
        DATABASE_PASSWORD
    );
    $connection1->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "mysql:host".DATABASE_SERVER.";dbname=".DATABASE_NAME;
    //echo "Connected";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    $connection1 = null;
}
if (isset($_POST['submit-add'])) {
    if (empty($_POST['firstname'])) {
        $firstname_err = 'Firstname required';
    } else {
        $firstname = htmlspecialchars($_POST['firstname']);
    }
    if (empty($_POST['lastname'])) {
        $lastname_err = 'Lastname required';
    } else {
        $lastname = htmlspecialchars($_POST['lastname']);
    }
    if (empty($_POST['age'])) {
        $age_err = 'Age required';
    } else {
        $age = htmlspecialchars($_POST['age']);
    }
    if (empty($_POST['title'])) {
        $title_err = 'Title required';
    } else {
        $title = htmlspecialchars($_POST['title']);
    }
    /*
       echo $firstname_err;
       echo $lastname_err;
       echo $age_err;
       echo $title_err;
       */


    $validate_suc = empty($firstname_err) && empty($lastname_err) && empty($age_err) && empty($title_err);
    if ($validate_suc) {
        $sql_insert = "INSERT INTO employee(firstname, lastname, age, title) VALUES(?,?,?,?)";
        try {
            $statement1 = $connection1->prepare($sql_insert);
            $statement1->bindParam(1, $firstname);
            $statement1->bindParam(2, $lastname);
            $statement1->bindParam(3, $age);
            $statement1->bindParam(4, $title);
            $statement1->execute();
            echo "<script>alert('Added successfully')</script>";
            //echo "Completed";
            header("index.php");
        } catch (PDOException $e) {
            echo "Failed" . $e->getMessage();
        }
    }
}

//End add employee

//Delete employee:
$connection2 = null;
try {
    $connection2 = new PDO(
        "mysql:host=" . DATABASE_SERVER . ";dbname=" . DATABASE_NAME,
        DATABASE_USER,
        DATABASE_PASSWORD
    );
    $connection2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "mysql:host".DATABASE_SERVER.";dbname=".DATABASE_NAME;
    //echo "Connected";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    $connection2 = null;
}
$id_err = '';
$id_epl = '';
if (isset($_POST['submit-delete'])) {
    if (empty($_POST['id_epl'])) {
        $id_err = 'ID of employee required';
    } else {
        $id_epl = htmlspecialchars($_POST['id_epl']);
    }



    $validate_id = empty($id_err);
    if ($validate_id) {
        $sql_delete = "DELETE FROM employee WHERE id='{$id_epl}'";
        //echo $sql_delete;
        try {
            $statement2 = $connection2->prepare($sql_delete);
            $statement2->execute();
            //echo "Completed";
            echo "<script>alert('Deleted successfully')</script>";
            header("index.php");
        } catch (PDOException $e) {
            echo "Failed" . $e->getMessage();
        }
    }
}



//End delete employee

?>
<!DOCTYPE html>
<html lang="en">

<?php require './css.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CDTM</title>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

<body>

    <div class="header">
        <img id="logo" src="./img/cdtm_logo.jpg" alt="Logo CDTM">
        <p id="header-title">CÔNG TY CỔ PHẦN CÔNG NGHỆ, DỊCH VỤ TÀI NGUYÊN & MÔI TRƯỜNG</p>
    </div>
    <h3> </h3>
    <p id="header-title">Enter new employee</p>
    <!-- Form add -->
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
        <div class="mb-3">
            <input type="text" class="form-control <?php echo $firstname_err ? 'is-invalid' : ''; ?>" name="firstname" placeholder="Enter firstname">
            <p class="text-danger"><?php echo $firstname_err; ?></p>
        </div>
        <div class="mb-3">
            <input type="text" class="form-control <?php echo $lastname_err ? 'is-invalid' : ''; ?>" name="lastname" placeholder="Enter lastname">
            <p class="text-danger"><?php echo $lastname_err; ?></p>
        </div>
        <div class="mb-3">
            <input type="text" class="form-control <?php echo $age_err ? 'is-invalid' : ''; ?>" name="age" placeholder="Enter age">
            <p class="text-danger"><?php echo $age_err; ?></p>
        </div>
        <div class="mb-3">
            <input type="text" class="form-control <?php echo $title_err ? 'is-invalid' : ''; ?>" name="title" placeholder="Enter title">
            <p class="text-danger"><?php echo $title_err; ?></p>
        </div>
        <div class="d-grid gap-2">
            <input type="submit" class="btn btn-primary" name="submit-add" value="Add">
        </div>

    </form>
    <!-- Form delete -->
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
        <div class="mb-3">
            <input type="text" class="form-control <?php echo $id_err ? 'is-invalid' : ''; ?>" name="id_epl" placeholder="Enter ID">
            <p class="text-danger"><?php echo $id_err; ?></p>
        </div>
        <div class="d-grid gap-2">
            <input type="submit" class="btn btn-primary" name="submit-delete" value="Delete">
        </div>
    </form>
    <p id="header-title">DANH SÁCH NHÂN VIÊN</p>

    <?php
    $sql = "SELECT id, firstname, lastname, age, title from employee;";
    //$sql =" SELECT * FROM employee;";

    if ($connection != null) {
        try {
            $statement = $connection->prepare($sql);
            $statement->execute();
            $result = $statement->setFetchMode(PDO::FETCH_ASSOC);
            $employees = $statement->fetchAll();
            echo "<div class='list-group'>";
            foreach ($employees as $employee) {
                $id = $employee['id'] ?? '';
                $firstname = $employee['firstname'] ?? '';
                $lastname = $employee['lastname'] ?? '';
                $age = $employee['age'] ?? '';
                $title = $employee['title'] ?? '';
                echo "<a href ='#' id='id_{$id}' class='list-group-item list-group-item-action' aria-current='true'>";
                echo "<div class='d-flex w-100 justify-content-between'>";
                echo "<h5 class='mb-1'>{$firstname} - {$lastname}</h5>";
                echo "<small>{$title}</small>";
                echo "</div>";
                echo "<p class='mb-1'>Age: {$age}</p>";
                echo "<div class='d-flex w-100 justify-content-between'>";
                echo "<small>ID: {$id}</small>";
                echo "<span class='closebtn' onclick='test({$id})'>&times</span>";
                echo "</div>";
                echo "</a>";
            }
            echo "</div>";
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    ?>
    <footer class="bg-light text-center text-lg-start">
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2)">
            Nguyen Phuc Thien - CTMD test
        </div>

    </footer>
</body>
<script>
    function test(id_delete) {
        //alert(id_delete);
        var text = "id_" + String(id_delete);
        const box = document.getElementById(text);
        box.style.display = 'none';
        var data = {
            id_del: String(id_delete)
        };

        fetch('script.php', {
            method: "POST",
            body: JSON.stringify(data),
            headers: {
                "Content-Type": "application/json; charset=UTF-8"
            }

        })


    }
</script>

</html>