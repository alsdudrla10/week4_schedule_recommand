<?php
session_start();
if(!isset($_SESSION['id']))
{
    header('location: ./signin.html');
}



$id=$_SESSION['id'];
$conn = mysqli_connect("localhost", "root", "sksmssksms", "schedule_recommand");
$query = "select * from schedule_recommand.user where id = '$id'";
$result = mysqli_query($conn,$query);
$data = mysqli_fetch_array($result);

$name=$data[name];
$major1=$data[major];
$major2=$data[additionalMajor];
$kind=$data[additional];
echo "<a href=\"main.php\" style=\"text-decoration:none; color: black; align: center; \"> <h1> Recommend Schedule </h1></a>";
echo"<table border='3' width='1500' style='border-collapse:collapse;' >";
echo"<form method='get' action='save.php'>";
echo "<tr><td colspan='2' style='border-right: 0px solid black' >이미 들은 강좌들을 선택해주세요</td><td style='border-left: 0px solid black' align='right'> <button type='submit' >저장</button></td></tr>";
echo"<tr><td>주전공 과목</td><td>";
echo"$kind";
echo"과목";
echo"</td><td>교양</td>";
$query2= "select * from schedule_recommand.lecture where Department in ('$major1') ";
$result2= mysqli_query($conn,$query2);
echo"<tr>";
echo"<td valign='top'>";
echo"<form method='get' action='save.php'>";
$temp='abc';
while($data2=mysqli_fetch_array($result2)) {
    if($temp != $data2[Name]){
        echo" <input type=checkbox name='class[]' value='$data2[Code]/$data2[Class]'>";
        echo "$data2[Code]";
        echo " $data2[Name]<br>";
    }
    $temp="$data2[Name]";
}
echo"</td>";
echo"<td valign='top'>";
$query2= "select * from schedule_recommand.lecture where Department in ('$major2') ";
$result2= mysqli_query($conn,$query2);


$temp='abc';
while($data2=mysqli_fetch_array($result2)) {
    if($temp != $data2[Name]){
        echo" <input type=checkbox name='class[]' value='$data2[Code]/$data2[Class]'>";
        echo "$data2[Code]";
        echo " $data2[Name]<br>";
    }
    $temp="$data2[Name]";
}
echo"</td>";
echo"<td valign='top'>";

$query2= "select * from schedule_recommand.lecture where Department in ('HSS') ";
$result2= mysqli_query($conn,$query2);
echo"<form method='get' action='save.php'>";
$temp='abc';
while($data2=mysqli_fetch_array($result2)) {
    if($temp != $data2[Name]){
        echo" <input type=checkbox name='class[]' value='$data2[Code]/$data2[Class]'>";
        echo "$data2[Code]";
        echo " $data2[Name]<br>";
    }
    $temp="$data2[Name]";
}
echo"</td>";
echo"</tr>";



//echo" <button type='submit' >저장</button>";
echo"</form>";

?>