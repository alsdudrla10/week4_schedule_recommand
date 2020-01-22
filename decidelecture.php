<html>
<head>
    <meta charset="UTF-8">
    <title>Decide Lecture</title>

</head>
<body>


<?php
session_start();
if(!isset($_SESSION['id']))
{
    header('location: ./signin.html');
}
$id=$_SESSION['id'];
$conn = mysqli_connect("localhost", "root", "sksmssksms", "schedule_recommand");

$q_reset_find="Select * from schedule_recommand.reset where user_id='$id'";// 리셋 상태 확인
$r_reset_find=mysqli_query($conn,$q_reset_find);
while($d_reset_find=mysqli_fetch_array($r_reset_find)){
    if(strcmp($d_reset_find[reset],"1")){//user의 reset이 0인경우 -> schedule.php로 넘어가야함
        header('location: ./schedule.php');
    }
}
echo "<a href=\"main.php\" style=\"text-decoration:none; color: black; align: center; \"> <h1> Recommend Schedule </h1></a>";

echo"<table border='1'> <tr><td colspan='3'>듣고싶은 과목의 수를 입력하시오</td></tr>";
echo"<form action='save2.php' method='get'>
<tr><td colspan='1'>
 주전공과목 : <input type='text' name='a'></td>";

$query4="select * from schedule_recommand.user where id='$id'";
$result4= mysqli_query($conn,$query4);
$data4=mysqli_fetch_array($result4);


    echo"<td colspan='1'> $data4[additional] 과목 : <input type='text' name='b'></td>";


echo"<td colspan='1'>교양과목 : <input type='text' name='c'></td></tr>";


$q="select * from schedule_recommand.user where id='$id'";

$result = mysqli_query($conn,$q);
$data = mysqli_fetch_array($result);
//    if($result){
//        echo "result success<br>";
//    }
//    else{
//        echo "result fail<br>";
//    }
$name=$data[name];
$major1=$data[major];
$major2=$data[additionalMajor];
//echo $name;
//echo $major1;
//echo $major2;
//echo "<br>";

$q2="select * from schedule_recommand.lecture_has_user where user_id='$id' and classify='0' ";
$result2= mysqli_query($conn,$q2);
if($result2){
//    echo "result2 success";
    $array = array();
    echo "<br>";
    while($data3=mysqli_fetch_array($result2)) { //내가 들은 lecture code 만 배열에 넣음
        $query100="select * from schedule_recommand.lecture where Code='$data3[lecture_Code]' and Class='$data3[lecture_Class]'";
        $result100=mysqli_query($conn,$query100);
        $data100=mysqli_fetch_array($result100);

        array_push($array,$data100[Name]);
    }

    foreach($array as $key=>$value){ //배열 확인
//        echo $key . " : " . $value . "</br>"; 이미 들은 목록 확인
    }
}


//else{
//    echo "result2 fail";
//}
$flag1=0;
$flag2=0;


echo"<tr>";
echo"<td>";
$q3="select * from schedule_recommand.lecture where Department in ('$major1') ";
$result3= mysqli_query($conn,$q3);

while($data2=mysqli_fetch_array($result3)) {
    if(!in_array($data2[Name],$array)){

        echo" <input type=checkbox name='class[]' value='$data2[Code]/$data2[Class]'>";
        echo "$data2[Code]";
        echo" $data2[Class]";
        echo " $data2[Name]";
        $query5="select * from schedule_recommand.time_has_lecture where lecture_Code='$data2[Code]' and lecture_Class='$data2[Class]'";
        $result5= mysqli_query($conn,$query5);
        while($data5=mysqli_fetch_array($result5)){
            table_day($data5[time_time]);
            table_time($data5[time_time]);
        }
        echo "<br>";
        $flag1++;
    }
    $flag2++;
}
echo"</td>";

echo"<td>";
$q3="select * from schedule_recommand.lecture where Department in ('$major2') ";
$result3= mysqli_query($conn,$q3);
echo"<br>";

while($data2=mysqli_fetch_array($result3)) {
    if(!in_array($data2[Name],$array)){
        echo" <input type=checkbox name='class[]' value='$data2[Code]/$data2[Class]'>";
        echo "$data2[Code]";
        echo" $data2[Class]";
        echo " $data2[Name]";
        $query5="select * from schedule_recommand.time_has_lecture where lecture_Code='$data2[Code]' and lecture_Class='$data2[Class]'";
        $result5= mysqli_query($conn,$query5);
        while($data5=mysqli_fetch_array($result5)){
            table_day($data5[time_time]);
            table_time($data5[time_time]);
        }
        echo "<br>";
        $flag1++;
    }
    $flag2++;
}
echo"</td>";


echo"<br>";
echo"<td>";
$q3="select * from schedule_recommand.lecture where Department in ('HSS') ";
$result3= mysqli_query($conn,$q3);

while($data2=mysqli_fetch_array($result3)) {
    if(!in_array($data2[Name],$array)){
        echo" <input type=checkbox name='class[]' value='$data2[Code]/$data2[Class]'>";
        echo "$data2[Code]";
        echo" $data2[Class]";
        echo " $data2[Name]";
        $query5="select * from schedule_recommand.time_has_lecture where lecture_Code='$data2[Code]' and lecture_Class='$data2[Class]'";
        $result5= mysqli_query($conn,$query5);
        while($data5=mysqli_fetch_array($result5)){
            table_day($data5[time_time]);
            table_time($data5[time_time]);
        }
        $flag1++;
        echo "<br>";

    }
    $flag2++;

}

echo"</td>";
echo"</tr>";
echo"</table>";

echo" <button type='submit' >확인</button>";
echo "전체: $flag2 / 수강가능과목: $flag1 ";
echo"</form>";

function table_time($time){
    if(time<=25) {
        if ($time % 5 == 1) {
            echo "09:00~10:30";
        }
        if ($time % 5 == 2) {
            echo "10:30~12:00";
        }
        if ($time % 5 == 3) {
            echo "13:00~14:30";
        }
        if ($time % 5 == 4) {
            echo "14:30~16:00";
        }
        if ($time % 5 == 0) {
            echo "16:00~17:30";
        }
    }
    else{
        echo "17:30~19:00";
    }
}
function table_day($time){
    if($time>=1 && $time <=5){
        echo " 월 ";
    }
    if($time>=6 && $time <=10){
        echo " 월 ";
    }
    if($time>=11 && $time <=15){
        echo " 수 ";
    }
    if($time>=16 && $time<=20){
        echo " 목 ";
    }
    if($time>=21 && $time <=25){
        echo " 금 ";
    }
    if($time==26){
        echo " 월 ";
    }
    if($time==27){
        echo " 화 ";
    }
    if($time==28){
        echo " 수 ";
    }
    if($time==29){
        echo " 목 ";
    }
    if($time==30){
        echo " 금 ";
    }
}


    ?>
</body>
</html>