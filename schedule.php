<html>
<?php
session_start();

if(!isset($_SESSION['id']))
{
    header('location: ./signin.html');
}
$k=0;
$id=$_SESSION['id'];
$conn = mysqli_connect("localhost", "root", "sksmssksms", "schedule_recommand");
$query = "select * from schedule_recommand.lecture_has_user where classify = '1' and user_id='$id'";
$result = mysqli_query($conn,$query);
$schedule_arr=array();
$name_arr=array();
while($data = mysqli_fetch_array($result)){
//    echo "data[lecture_Code]= $data[lecture_Code] <br>";
    $q="select * from schedule_recommand.lecture where Code='$data[lecture_Code]' and Class='$data[lecture_Class]'";
    $r=mysqli_query($conn,$q);
    while($d=mysqli_fetch_array($r)){
        //       echo "d[Code]= $d[Code] <br>";
        $time=$d[Time];
        $timeArr=explode(',',$time);
        array_unshift($timeArr,$data[lecture_Code]);
        array_push($schedule_arr,$timeArr);

        array_push($name_arr,$d[Name]);
    }
}
$row_num= count($schedule_arr);
//$col_num= count($schedule_arr,COUNT_RECURSIVE)-row_num;
//echo "$row_num <br>";

?>


<head>
    <meta charset="UTF-8">
    <title>Recommend Schedule</title>
    <style>
        table
        {
            border:2px solid rgb(0, 0, 0);
            border-collapse:separate;


        }
        td
        {
        <!-- border:1px solid black; -->

        <!--width:120px; -->
        <!--height:120px;-->
            font-family:고딕;
            font-size:1em;
            text-align: center;
            width:110px;


        }
        th
        {
            height:80px;
            font-family:고딕;
            font-size:1em;
            text-align: center;
            width:110px;
        }
        tr{
            font-weight:bold;
        }
        .left{
            height:120px;
        }
    </style>
</head>
<body>

<?php
//echo "<br>";
//foreach($schedule_arr as $v1){
//    echo "$v1 &nbsp;";
//    foreach($v1 as $v2){
//        echo "$v2 &nbsp;&nbsp;&nbsp;";
//    }
//    echo "<br>";
//}

?>
<center>
<a href="main.php" style="text-decoration:none; color: black; align: center; "> <h1> Recommend Schedule </h1></a>
</center>
<table  bgcolor = "#FFFFFF"  align="center" cellspacing="10" cellpadding="5">

    <tr >
        <th style="border-right: 1px solid black; border-bottom: 1px solid black"></th>
        <th style="border-bottom: 1px solid black">월요일</th><th style="border-bottom: 1px solid black">화요일</th><th style="border-bottom: 1px solid black">수요일</th>
        <th style="border-bottom: 1px solid black">목요일</th><th style="border-bottom: 1px solid black">금요일</th>
    </tr>
    <tr>
        <td class="left" style="border: 1px solid black"> 9:00<br>-<br>10:30 </td>
        <td id="1" name="1"></td> <td id="6" name="6"></td> <td id="11" name="11"></td> <td id="16" name="16"></td> <td id="21" name="21"></td>
    </tr>

    <tr >
        <td class="left" style="border: 1px solid black"> 10:30<br>-<br>12:00 </td>
        <td id="2" name="2"></td> <td id="7" name="7"></td> <td id="12" name="12"></td> <td id="17" name="17"></td> <td id="22" name="22"></td>
    </tr>

    <tr>
        <td class="left" style="border: 1px solid black"> 12:00<br>-<br>13:00 </td>
        <td style="border-bottom:1px dashed black; border-top: 1px dashed black"></td>
        <td style="border-bottom:1px dashed black; border-top: 1px dashed black; font-size:2em; font-weight:bold;"></td>
        <td style="border-bottom:1px dashed black; border-top: 1px dashed black"><br></td>
        <td style="border-bottom:1px dashed black; border-top: 1px dashed black; font-size:2em; font-weight:bold;"></td>
        <td style="border-bottom:1px dashed black; border-top: 1px dashed black"></td>
    </tr>

    <tr>
        <td class="left"  style="border: 1px solid black"> 13:00<br>-<br>14:30 </td>
        <td id="3" name="3"></td> <td id="8" name="8"></td> <td id="13" name="13" ></td> <td id="18" name="18"></td> <td id="23" name="23"></td>
    </tr>

    <tr>
        <td class="left" style="border: 1px solid black"> 14:30<br>-<br>16:00 </td>
        <td id="4" name="4" ></td> <td id="9" name="9"></td> <td id="14" name="14"></td> <td id="19" name="19" ></td> <td id="24" name="24"></td>
    </tr>

    <tr>
        <td class="left" style="border: 1px solid black"> 16:00<br>-<br>17:30 </td>
        <td id="5" name="5"></td> <td id="10" name="10"></td> <td id="15" name="15"></td> <td id="20" name="20"></td> <td id="25" name="25"></td>
    </tr>
    <tr>
        <td class="left" style="border: 1px solid black"> 17:30<br>-<br>19:00 </td>
        <td id="26" name="26"></td> <td id="27" name="27"></td> <td id="28" name="28"></td> <td id="29" name="29"></td> <td id="30" name="30"></td>
    </tr>

</table>
<form action="reset.php" method="get">
    <input type="submit" value="다시 추천받기" >
</form>


<Script>

    var js_array=<?php echo json_encode($schedule_arr) ?>;
    var js_array2=<?php echo json_encode($name_arr) ?>;
    // document.write(js_array);    document.write("<br>");
    // document.write(js_array2);    document.write("<br>");
    // document.write(js_array.length);
    // document.write("<br>");

    for(var i=0;i<js_array.length;i++){
        for(var j=0;j<js_array[i].length;j++){
            if(j==0){
                var class_name=js_array2[i];
            }
            else {
                var temp = document.getElementById(js_array[i][j]);
//                document.write(js_array[i][j]+"<br>")
                temp.innerText = class_name;
                temp.style.backgroundColor="#000000"
                temp.style.color="#FFFFFF"
            }
        }

    }
</Script>
</body>
</html>