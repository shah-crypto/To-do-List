<?php
    $connection=mysqli_connect('localhost','root','','to-do list');
    if(isset($_GET['delete'])){
        $del_id=$_GET['delete'];
        $query="delete from data where id= '$del_id'";
        $result=mysqli_query($connection,$query);
        header("Location: index.php");
    }

    // if(isset($_GET['delete'])){
    //     $note_id_del=$_GET['delete'];
    //     $query="delete from data where note_id = '$note_id_del'";
    //     $result=mysqli_query($conn,$query);
    //     header("Location: homepage.php");
    //   }
?>

<?php
    if(isset($_GET['completed'])){
        $completed_id=$_GET['completed'];
        $conn=mysqli_connect('localhost','root','','to-do list');
        if($conn){
            $query="update data set status='Completed' where id=$completed_id";
            $result=mysqli_query($conn,$query);
            if($result){
                header("Location: index.php");
            }
        }
    }
?>

<?php
    if(isset($_POST['add'])){
        $title=$_POST['title'];
        $date=date('Y-m-d');
        $conn=mysqli_connect('localhost','root','','to-do list');
        if($title=="" || empty($title))
        echo "Title is mandatory";
        else{
            if($conn){
                $query="insert into data (title,date) values ('$title',now())";
                $result=mysqli_query($conn,$query); 
                if($result){
                    ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert"> <strong>Success!</strong> Your to-do list is now updated.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
            <?php 
                }
            }
        }
        // header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.    min.css">
    <script src="https://kit.fontawesome.com/421ca813ee.js" crossorigin="anonymous"></script>
    <style>
        .table {
            width: 90%;
            margin: auto;
            text-align: center;
        }

        .nodecoration{
            text-decoration: none;
        }

        .table{
            margin-top: 2%;
        }

        h1,h3{
            font-family: courier,arial,helvetica;
            /* background-color: #0d96f2;
            display: inline-block; */
        }

        h3{
            width: 40%;
            margin-top: 2%;
            padding-top: 2%;
            border-top: 1px solid black;
        }

        .fa-check{
            color: #4BB543;
        }

        .edit_container{
            margin-top: 1%;
            margin-left: 9%;
        }

        #lname{
            display: inline-block;
            width: 5%;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Add into your to-do list</h1>
        <form action="index.php" method="post" class="row g-3">
            <div class="col-3">
                <input type="text" class="form-control" name="title" id="staticEmail2" placeholder="Start typing here...">
            </div>
            <div class="col-auto">
                <input class="btn btn-outline-primary" type="submit" name="add" value="Add">
                <input class="btn btn-outline-primary" type="reset" value="Reset">
            </div>
        </form>
    </div>

<?php
if(isset($_GET['edit'])){
    $edit_id=$_GET['edit'];
    $conn=mysqli_connect('localhost','root','','to-do list');
        if($conn){
            $query="select title from data where id=$edit_id";
            $result1=mysqli_query($conn,$query);
        }
    ?>
    <div class="edit_container">
        <h3>Edit here</h3>
        <form action="edit.php" method="post" class="row g-3">
        <input type="hidden" id="lname" name="edit_id" value="<?php echo $edit_id; ?>">
            <div class="col-3">
                <input type="text" class="form-control" name="edit_title" id="staticEmail2" placeholder="Start typing here...">
            </div>
            <div class="col-auto">
                <input class="btn btn-outline-primary" type="submit" name="edit_add" value="Save Changes">
            </div>
        </form>
    </div>
<?php
}
?>

    <section>
        <table class="table border table-bordered table-hover">
            <thead>
                <tr>
                    <th class="col-2 table-dark">Status</th>
                    <th class="col-6 table-dark">Title</th>
                    <th class="col-2 table-dark">Mark as done</th>
                    <th class="col-2 table-dark">Date</th>
                    <th class="col-1 table-dark">Edit</th>
                    <th class="col-1 table-dark">Delete</th>
                </tr>
            </thead>
            <?php
    $conn=mysqli_connect('localhost','root','','to-do list');
    if($conn){
        $query="select * from data";
        $result=mysqli_query($conn,$query);
        if(!$result){
            echo "Query failed".mysqli_error($conn);
        }
        elseif(mysqli_num_rows($result) == 0){
            echo "Nothing found to be shown"."<br>"."Try adding something";
        }
        else{          
            while($row=mysqli_fetch_assoc($result)){
                $status=$row['status'];
                $id=$row['id'];
                $title=$row['title'];
                $date=$row['date'];
?>

            <tbody>
                <tr>
                    <td><?php 
                    if($status=='Incomplete')
                    echo "<font color=#ff0033> $status </font>"; 
                    else
                    echo "<font color=#39DB80> $status </font>"; 
                    ?></td>
                    <td><?php echo $title; ?></td>
                    <td><a href="index.php?completed=<?php echo $id; ?>"><i class="fas fa-check"></i></i></a></td>
                    <td><?php echo $date; ?></td>
                    <td><a href="index.php?edit= <?php echo $id; ?>">Edit</a></td>
                    <td><a href="index.php?delete= <?php echo $id; ?>"><i class="fas fa-trash"></i></i></a></td>
                </tr>
                
            </tbody>
        <?php
            }
        }
    }
        ?>
        </table>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js"
        integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js"
        integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG"
        crossorigin="anonymous"></script>
</body>
</html>