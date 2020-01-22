<!DOCTYPE HTML>
<html>
<head>
    <title> Sign Up Success </title>
    <meta charset="UTF-8"/>
</head>
<body>
<?php
$db=new mysqli("localhost","root","sksmssksms","schedule_recommand");
if(mysqli_connect_errno()){
print "Error: Could not connect to database server.";
exit;}
mysqli_set_charset($db,"utf8");
$id=$_POST["id"];
$pwd=$_POST["pwd"];
$name=$_POST["name"];
$student_id=$_POST["student_id"];
$major=$_POST["major"];
$additional=$_POST["additional"];
$additionalMajor=$_POST["additionalMajor"];


if($id==NULL || $pwd==NULL || $name==NULL || $student_id==NULL || $major==NULL || $additional==NULL || $additionalMajor==NULL){
    $flag="빈칸을 모두 채워주세요";
    echo "<script>alert('{$flag}');
    document.location.href=\"signup2.html\";
</script>";
//    header('location: ./signup2.html');
//    echo "<a href=signup2.html>Back Page</a>";
    exit();
}

$check="SELECT * from schedule_recommand.user WHERE id='$id'";
$ch=mysqli_query($db,$check);
if($ch->num_rows==1){
    $flag="중복된 id 입니다.";
    echo "<script>alert('{$flag}');
    document.location.href=\"signup2.html\";
</script>";
//    header('location: ./signup2.html');
//    echo "<a href=signup2.html>Back Page</a>";
    exit();
}


$q= "insert into schedule_recommand.user (id,pwd,name,student_id,major,additional,additionalMajor) values('$id','$pwd','$name','$student_id','$major','$additional','$additionalMajor') ";
$result= mysqli_query($db,$q);
if($result){
    $qu="insert into schedule_recommand.reset (user_id,reset) values('$id','1')";
    $qu_result= mysqli_query($db,$qu);
    $flag="회원가입이 정상적으로 완료되었습니다";
    echo "<script>alert('{$flag}');
    document.location.href=\"main.php\";
</script>";
 //   header('location: ./main.php');
 //   echo "<a href=signin.html>Back Page</a>";

}
else{
    echo "Sign In Fail";
}
//TODO: 꾸미기
?>

</body>
</html>