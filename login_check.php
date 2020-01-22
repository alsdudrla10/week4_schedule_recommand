<?php
session_start();
$id=$_POST['id'];
$pwd=$_POST['pwd'];
if($id==NULL || $pwd==NULL ){
    $flag="빈칸을 모두 채워주세요";
    echo "<script>alert('{$flag}');
    document.location.href=\"signin.html\";
</script>";
    exit();
}

$mysqli=mysqli_connect("localhost","root","sksmssksms","schedule_recommand");

$q="SELECT * FROM schedule_recommand.user WHERE id='$id'";
$result=$mysqli-> query($q);
if($result->num_rows==1){
    $row=$result->fetch_array(MYSQLI_ASSOC);
    if($row['pwd']==$pwd){
        $_SESSION['id']=$id;
        if(isset($_SESSION['id'])){
            header('Location: main.php');
        }
        else{
            echo "세션 저장 실패";
        }
    }
    else{
        echo "wrong id or pw";
    }
}
else{
    echo "wrong id or pw";
}
?>
