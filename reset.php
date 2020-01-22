<?php
session_start();
if(!isset($_SESSION['id']))
{
    header('location: ./signin.html');
}
$id=$_SESSION['id'];
$conn = mysqli_connect("localhost", "root", "sksmssksms", "schedule_recommand");


$q_reset="UPDATE schedule_recommand.reset SET reset='1' WHERE user_id='$id'";//리셋상태 변경 reset=1: 리셋된 상태
$r_reset=mysqli_query($conn,$q_reset);

$query = "select * from schedule_recommand.lecture_has_user where user_id='$id' and classify='1'";
$result = mysqli_query($conn,$query);
while($data = mysqli_fetch_array($result)) {
    $code=$data[lecture_Code];
    $class=$data[lecture_Class];
    $q="Delete from schedule_recommand.lecture_has_user where user_id='$id' and lecture_Code='$code' and lecture_Class='$class'";
    $r = mysqli_query($conn,$q);
}
if($r){
    echo("<script>
    alert('성공적으로 초기화 되었습니다.');
    location.href='main.php';</script>");
}
else{
    echo("<script>
    alert('오류발생');
    location.href='schedule.php';</script>");
}
?>