<?php

$id='20170133';

echo"  전필과목 : <select>
        <option selected value='default' name='must'>선택</option>
        <option value='1'>1</option>
        <option value='2'>2</option>
        <option value='3'>3</option>
        <option value='4'>4</option>
        <option value='5'>5</option>
        </select>
        
        전선과목 : <select>
        <option selected value='default' name='select'>선택</option>
        <option value='1'>1</option>
        <option value='2'>2</option>
        <option value='3'>3</option>
        <option value='4'>4</option>
        <option value='5'>5</option>
        </select>
        
        교양과목 : <select>
        <option selected value='default' name=''>선택</option>
        <option value='1'>1</option>
        <option value='2'>2</option>
        <option value='3'>3</option>
        <option value='4'>4</option>
        <option value='5'>5</option>
        </select>   
        ";
$conn = mysqli_connect("localhost", "root", "sksmssksms", "schedule_recommand");
$query = "select * from schedule_recommand.user where student_id = $id";
$result = mysqli_query($conn,$query);
$data = mysqli_fetch_array($result);

$name=$data[name];
$major1=$data[Major];
$major2=$data[additionalMajor];
echo $name;
echo $major1;
echo $major2;

$query2= "select * from schedule_recommand.lecture where Department in ('$major1','$major2','HSS') ";
$result2= mysqli_query($conn,$query2);

if($result2){
    echo "success";
}
else{
    echo"fail";
}
echo"<br>";
echo"<form method='get' action='save2.php'>";
$i=0;
while($data2=mysqli_fetch_array($result2)) {
    echo "$data2[Code]";
    echo "$data2[Class]";
    echo " $data2[Name]";
    echo" <input type=checkbox name='class[]' value='$data2[Code]/$data2[Class]'><br>";
}
echo" <button type='submit' >버튼</button>";
echo"</form>";

?>
