<?php
//echo" save <br>";
echo"<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
session_start();
if(!isset($_SESSION['id']))
{
    header('location: ./signin.html');
}
$id=$_SESSION['id'];

$conn = mysqli_connect("localhost", "root", "sksmssksms", "schedule_recommand");
$query = "DELETE FROM schedule_recommand.lecture_has_user where user_id='$id'";
$result= mysqli_query($conn,$query);
//if($result){
//    echo"result success<br>";
//}
//else{
//    echo"result fail<br>";
//}
//echo count($_GET['class']);
echo "<br>";
$flag=0;
for($i=0 ; $i<count($_GET['class']); $i++ ){
    $position= $_GET['class'];
//    echo $position[$i];
    $test=explode('/',$position[$i]);
   echo"$test[0]";
   echo"$test[1]";
    $query3="insert into schedule_recommand.lecture_has_user values('$test[0]','$test[1]','$id','0')";
    $result3=mysqli_query($conn,$query3);
    if($result3){
//        echo success;
        $flag++;
    }
    else {
//        echo fail;
    }
}
if($flag==count($_GET['class'])){
    echo("<script>
    alert('성공적으로 저장되었습니다.');
    location.href='main.php';</script>");
}
else{
    echo("<script>
    alert('저장에 오류발생');
    location.href='settinglecture.php';</script>");
}
?>

