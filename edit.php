<?php
    if(isset($_POST['edit_add'])){
        $edit_id=$_POST['edit_id'];
        $edit_title=$_POST['edit_title'];
        $conn=mysqli_connect('localhost','root','','to-do list');
        if($conn){
            $query="update data set title='$edit_title' where id=$edit_id";
            $result=mysqli_query($conn,$query);
            if($result){
                header("Location: index.php");
            }
        }
    }
?>