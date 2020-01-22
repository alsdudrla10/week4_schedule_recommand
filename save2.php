<?php
echo"<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
echo" savdee";
session_start();
if(!isset($_SESSION['id']))
{
    header('location: ./signin.html');
}
$userid=$_SESSION['id'];

$conn = mysqli_connect("localhost", "root", "sksmssksms", "schedule_recommand");

$q_reset_find="Select * from schedule_recommand.reset where user_id='$id'";// 리셋 상태 확인
$r_reset_find=mysqli_query($conn,$q_reset_find);
while($d_reset_find=mysqli_fetch_array($r_reset_find)){
    if(strcmp($d_reset_find[reset],"1")){//user의 reset이 0인경우 -> schedule.php로 넘어가야함
        header('location: ./schedule.php');
    }
}

$q_reset="UPDATE schedule_recommand.reset SET reset='0' WHERE user_id='$userid'"; //리셋상태 변경
$r_reset=mysqli_query($conn,$q_reset);

for($i=0 ; $i<count($_GET['class']); $i++ ){
    $position= $_GET['class'];
    echo $position[$i];
    $test=explode('/',$position[$i]);
    echo"$test[0]";
    echo"$test[1]<br>";
    $query3="insert into schedule_recommand.lecture_has_user values('$test[0]','$test[1]','$userid','0')";
    $result3=mysqli_query($conn,$query3);
    if($result3){
        echo"success<br>";
    }
    else{
        echo"fail<br>";
    }
    $query4="insert into schedule_recommand.lecture_has_user values('$test[0]','$test[1]','$userid','1')";
    $result4=mysqli_query($conn,$query4);
    if($result4){
        echo"success<br>";
    }
    else{
        echo"fail<br>";
    }
}
echo"<br>";

//수업 개수 정하기
$num_a=$_GET[a];
$num_b=$_GET[b];
$num_c=$_GET[c];

//유저정보 받아오기
$query7="select * from schedule_recommand.user where id='$userid'";
echo"$userid";

$result7=mysqli_query($conn,$query7);
$data7=mysqli_fetch_array($result7);
$major1=$data7[major];
$major2=$data7[additionalMajor];
echo"$major1";
echo"$major2<br>";

$query5= "select * from schedule_recommand.lecture_has_user where classify='1' and user_id='$userid'"; //  이미 듣기로 한 과목 check
$result5=mysqli_query($conn,$query5);
while($data5=mysqli_fetch_array($result5)){
    echo"$data5[lecture_Code]";
    echo"$data5[lecture_Class]";
    $query6="select * from schedule_recommand.lecture where Code= '$data5[lecture_Code]' and Class='$data5[lecture_Class]'";
    $result6=mysqli_query($conn,$query6);
    $data6=mysqli_fetch_array($result6);
    echo"$data6[Kind]<br>";
    if($data6[Department]==$major1){
        $num_a=$num_a-1;
    }
    if($data6[Department]==$major2){
        $num_b=$num_b-1;
    }
    if($data6[Kind]=='교양'){
        $num_c=$num_c-1;
    }
}

echo"<br>주전:$num_a<br>";
echo"부전:$num_b<br>";
echo"교양:$num_c<br>";



echo"<br>";
//초기 가능한 시간 구성
echo"ecgge";
echo"<br>";
$time=[100,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]; // 1이 되면 할당 된것
$query8="select * from schedule_recommand.lecture_has_user where user_id='$userid' and classify='1'";
$result8=mysqli_query($conn,$query8);
if($result8){
    echo"re8 suc";
}
else{
    echo"re8 fail";
}
while($data8=mysqli_fetch_array($result8)) {
    $query9="select * from schedule_recommand.time_has_lecture where lecture_Code='$data8[lecture_Code]' and lecture_Class='$data8[lecture_Class]'";
    $result9=mysqli_query($conn,$query9);
    if($result9){
        echo"re9 suc";
    }
    else{
        echo"re9 fail";
    }
    while($data9=mysqli_fetch_array($result9)) {
        $time[$data9[time_time]]=1;
        echo"abc";
    }
}

echo"<br> time array:";
for($i=0 ; $i < 26 ; ++$i){
    echo"$time[$i] ";
}


echo"<br>";
//추천 과목을 1로 저장!
$grade=$_GET[d]; // 학년




echo"<br><br><br><br><br><br><br>";

//주 전공 전필 과목 추천
$query10="select * from schedule_recommand.lecture where Department='$major1' and Kind='전필' order by Code, prefer DESC ";

$result10=mysqli_query($conn,$query10);
if($result10){
    echo"re10 successs<br><br>";
}
else{
    echo"re10 fails<br><br>";
}
while($data10=mysqli_fetch_array($result10)) {
    echo "과목이름 시작$data10[Code] ";
    echo "$data10[Class] ";
    $query11 = "select * from schedule_recommand.time_has_lecture where lecture_Code='$data10[Code]' and lecture_Class='$data10[Class]'"; //시간확인을 위한 쿼리
    $result11 = mysqli_query($conn, $query11);
    $checktime = 1; // 시간이 되면 1 안되면 0
    while ($data11 = mysqli_fetch_array($result11)) {
        echo " $data11[time_time] ";
        if ($time[(int)$data11[time_time]] == 1) {
            $checktime = 0;
        }
    }

     //이미 추천되었는지 확인을 위한 플래그

    echo" 체크타임 : $checktime";
    echo"남은 전공: $num_a<br>";
    if($checktime==1 && $num_a >0) {
        $query12 = "select * from schedule_recommand.lecture_has_user where lecture_Code= '$data10[Code]' and lecture_Class='$data10[Class]' and user_id='$userid'"; //이미 들었는지 체크를 위한 쿼리
        $checktake = 1; // 수강을 안했으면 1 했으면 0

        $result12 = mysqli_query($conn, $query12);
        while ($data12 = mysqli_fetch_array($result12)) {
            if ($data12[classify] == 0)
                $checktake = 0;
        }
        if ($checktake == 1) {
            $flag=0;
            echo"$flag";
            $query20="SELECT * FROM schedule_recommand.lecture where Code='$data10[Code]' and Class='$data10[Class]'";
            $result20=mysqli_query($conn, $query20);
            $data20=mysqli_fetch_array($result20);


            $query21="select * FROM schedule_recommand.lecture_has_user where user_id='$userid'";
            $result21=mysqli_query($conn, $query21);
            while($data21=mysqli_fetch_array($result21)) {
                $query22 = "select * from schedule_recommand.lecture where Code='$data21[lecture_Code]' and Class= '$data21[lecture_Class]'";
                $result22 = mysqli_query($conn, $query22);
                $data22 = mysqli_fetch_array($result22);
                echo "<br>f$data22[Name]f";
                echo "f$data20[Name]f<br>";
                if (!strcmp("$data22[Name]" , "$data20[Name]")){
                    echo "<br>$data22[Name]";
                    echo "$data20[Name]<br>";
                    $flag = 1;
                    echo "$flag";
                    echo"aefi;ljeageorisoir";
                }
            }


            if($flag==0){

                $query13="insert into schedule_recommand.lecture_has_user values('$data10[Code]','$data10[Class]','$userid',0)";
                $query14="insert into schedule_recommand.lecture_has_user values('$data10[Code]','$data10[Class]','$userid',1)";
                $result13 = mysqli_query($conn, $query13);
                $result14 = mysqli_query($conn, $query14);
                if($result13){
                    echo" re13 success<br> ";
                }
                else{
                    echo" re13 fail <br>";
                }
                $num_a--;
                $query15="select * from schedule_recommand.time_has_lecture where lecture_Code= '$data10[Code]' and lecture_Class='$data10[Class]'"; // 추가한 과목 시간 배열 추가를 위한 쿼리
                $result15 = mysqli_query($conn, $query15);
                while ($data15 = mysqli_fetch_array($result15)) {
                    $time[$data15[time_time]]=1;
                }

            }

        }
    }
}

//주 전공 전선 과목 추천
$query10="select * from schedule_recommand.lecture where Department='$major1' and Kind='전선' order by prefer DESC ";
$result10=mysqli_query($conn,$query10);
if($result10){
    echo"re10 successs<br><br>";
}
else{
    echo"re10 fails<br><br>";
}
while($data10=mysqli_fetch_array($result10)) {
    echo "과목이름 시작$data10[Code] ";
    echo "$data10[Class] ";
    $query11 = "select * from schedule_recommand.time_has_lecture where lecture_Code='$data10[Code]' and lecture_Class='$data10[Class]'"; //시간확인을 위한 쿼리
    $result11 = mysqli_query($conn, $query11);
    $checktime = 1; // 시간이 되면 1 안되면 0
    while ($data11 = mysqli_fetch_array($result11)) {
        echo " $data11[time_time] ";
        if ($time[(int)$data11[time_time]] == 1) {
            $checktime = 0;
        }
    }
    echo" 체크타임 : $checktime";
    echo"남은 전공: $num_a<br>";
    if($checktime==1 && $num_a >0) {
        $query12 = "select * from schedule_recommand.lecture_has_user where lecture_Code= '$data10[Code]' and lecture_Class='$data10[Class]' and user_id='$userid'"; //이미 들었는지 체크를 위한 쿼리
        $checktake = 1; // 수강을 안했으면 1 했으면 0
        $result12 = mysqli_query($conn, $query12);
        while ($data12 = mysqli_fetch_array($result12)) {
            if ($data12[classify] == 0)
                $checktake = 0;
        }
        if ($checktake == 1) {

            $query20="SELECT * FROM schedule_recommand.lecture where Code='$data10[Code]' and Class='$data10[Class]'";
            $result20=mysqli_query($conn, $query20);
            $data20=mysqli_fetch_array($result20);
            $flag=0;

            $query21="select * FROM schedule_recommand.lecture_has_user where user_id='$userid'";
            $result21=mysqli_query($conn, $query21);
            while($data21=mysqli_fetch_array($result21)){
                $query22="select * from schedule_recommand.lecture where Code='$data21[lecture_Code]' and Class= '$data21[lecture_Class]'";
                $result22=mysqli_query($conn, $query22);
                $data22=mysqli_fetch_array($result22);
                echo "<br>f$data22[Name]f";
                echo "f$data20[Name]f<br>";
                if (!strcmp("$data22[Name]" , "$data20[Name]")){
                    echo "<br>$data22[Name]";
                    echo "$data20[Name]<br>";
                    $flag = 1;
                    echo "$flag";
                    echo"aefi;ljeageorisoir";
                }
            }
            if($flag==0){

                $query13="insert into schedule_recommand.lecture_has_user values('$data10[Code]','$data10[Class]','$userid',0)";
                $query14="insert into schedule_recommand.lecture_has_user values('$data10[Code]','$data10[Class]','$userid',1)";
                $result13 = mysqli_query($conn, $query13);
                $result14 = mysqli_query($conn, $query14);
                if($result13){
                    echo" re13 success<br> ";
                }
                else{
                    echo" re13 fail <br>";
                }
                $num_a--;
                $query15="select * from schedule_recommand.time_has_lecture where lecture_Code= '$data10[Code]' and lecture_Class='$data10[Class]'"; // 추가한 과목 시간 배열 추가를 위한 쿼리
                $result15 = mysqli_query($conn, $query15);
                while ($data15 = mysqli_fetch_array($result15)) {
                    $time[$data15[time_time]]=1;
                }


            }

        }
    }
}

echo"<br><br><br><br><br><br><br>";
//부 전공 전필과목 추천
$query10="select * from schedule_recommand.lecture where Department='$major2' and Kind='전필' order by Code, prefer DESC ";
$result10=mysqli_query($conn,$query10);
if($result10){
    echo"re10 successs<br><br>";
}
else{
    echo"re10 fails<br><br>";
}
while($data10=mysqli_fetch_array($result10)) {
    echo "과목이름 시작$data10[Code] ";
    echo "$data10[Class] ";
    $query11 = "select * from schedule_recommand.time_has_lecture where lecture_Code='$data10[Code]' and lecture_Class='$data10[Class]'"; //시간확인을 위한 쿼리
    $result11 = mysqli_query($conn, $query11);
    $checktime = 1; // 시간이 되면 1 안되면 0
    while ($data11 = mysqli_fetch_array($result11)) {
        echo " $data11[time_time] ";
        if ($time[(int)$data11[time_time]] == 1) {
            $checktime = 0;
        }
    }
    echo" 체크타임 : $checktime";
    echo"남은부 전공: $num_b<br>";
    if($checktime==1 && $num_b >0) {
        $query12 = "select * from schedule_recommand.lecture_has_user where lecture_Code= '$data10[Code]' and lecture_Class='$data10[Class]' and user_id='$userid'"; //이미 들었는지 체크를 위한 쿼리
        $checktake = 1; // 수강을 안했으면 1 했으면 0
        $result12 = mysqli_query($conn, $query12);
        while ($data12 = mysqli_fetch_array($result12)) {
            if ($data12[classify] == 0)
                $checktake = 0;
        }
        if ($checktake == 1) {

            $query20="SELECT * FROM schedule_recommand.lecture where Code='$data10[Code]' and Class='$data10[Class]'";
            $result20=mysqli_query($conn, $query20);
            $data20=mysqli_fetch_array($result20);
            $flag=0;

            $query21="select * FROM schedule_recommand.lecture_has_user where user_id='$userid'";
            $result21=mysqli_query($conn, $query21);
            while($data21=mysqli_fetch_array($result21)){
                $query22="select * from schedule_recommand.lecture where Code='$data21[lecture_Code]' and Class= '$data21[lecture_Class]'";
                $result22=mysqli_query($conn, $query22);
                $data22=mysqli_fetch_array($result22);
                echo "<br>f$data22[Name]f";
                echo "f$data20[Name]f<br>";
                if (!strcmp("$data22[Name]" , "$data20[Name]")){
                    echo "<br>$data22[Name]";
                    echo "$data20[Name]<br>";
                    $flag = 1;
                    echo "$flag";
                    echo"aefi;ljeageorisoir";
                }
            }

            if($flag==0){
                $query13="insert into schedule_recommand.lecture_has_user values('$data10[Code]','$data10[Class]','$userid',0)";
                $query14="insert into schedule_recommand.lecture_has_user values('$data10[Code]','$data10[Class]','$userid',1)";
                $result13 = mysqli_query($conn, $query13);
                $result14 = mysqli_query($conn, $query14);
                if($result13){
                    echo" re13 success<br> ";
                }
                else{
                    echo" re13 fail <br>";
                }
                $num_b--;
                $query15="select * from schedule_recommand.time_has_lecture where lecture_Code= '$data10[Code]' and lecture_Class='$data10[Class]'"; // 추가한 과목 시간 배열 추가를 위한 쿼리
                $result15 = mysqli_query($conn, $query15);
                while ($data15 = mysqli_fetch_array($result15)) {
                    $time[$data15[time_time]]=1;
                }
            }

        }
    }
}



//부 전공 전선과목 추천
$query10="select * from schedule_recommand.lecture where Department='$major2' and Kind='전선' order by prefer DESC ";
$result10=mysqli_query($conn,$query10);
if($result10){
    echo"re10 successs<br><br>";
}
else{
    echo"re10 fails<br><br>";
}
while($data10=mysqli_fetch_array($result10)) {
    echo "과목이름 시작$data10[Code] ";
    echo "$data10[Class] ";
    $query11 = "select * from schedule_recommand.time_has_lecture where lecture_Code='$data10[Code]' and lecture_Class='$data10[Class]'"; //시간확인을 위한 쿼리
    $result11 = mysqli_query($conn, $query11);
    $checktime = 1; // 시간이 되면 1 안되면 0
    while ($data11 = mysqli_fetch_array($result11)) {
        echo " $data11[time_time] ";
        if ($time[(int)$data11[time_time]] == 1) {
            $checktime = 0;
        }
    }
    echo" 체크타임 : $checktime";
    echo"남은부 전공: $num_b<br>";
    if($checktime==1 && $num_b >0) {
        $query12 = "select * from schedule_recommand.lecture_has_user where lecture_Code= '$data10[Code]' and lecture_Class='$data10[Class]' and user_id='$userid'"; //이미 들었는지 체크를 위한 쿼리
        $checktake = 1; // 수강을 안했으면 1 했으면 0
        $result12 = mysqli_query($conn, $query12);
        while ($data12 = mysqli_fetch_array($result12)) {
            if ($data12[classify] == 0)
                $checktake = 0;
        }
        if ($checktake == 1) {

            $query20="SELECT * FROM schedule_recommand.lecture where Code='$data10[Code]' and Class='$data10[Class]'";
            $result20=mysqli_query($conn, $query20);
            $data20=mysqli_fetch_array($result20);
            $flag=0;

            $query21="select * FROM schedule_recommand.lecture_has_user where user_id='$userid'";
            $result21=mysqli_query($conn, $query21);
            while($data21=mysqli_fetch_array($result21)){
                $query22="select * from schedule_recommand.lecture where Code='$data21[lecture_Code]' and Class= '$data21[lecture_Class]'";
                $result22=mysqli_query($conn, $query22);
                $data22=mysqli_fetch_array($result22);
                echo "<br>f$data22[Name]f";
                echo "f$data20[Name]f<br>";
                if (!strcmp("$data22[Name]" , "$data20[Name]")){
                    echo "<br>$data22[Name]";
                    echo "$data20[Name]<br>";
                    $flag = 1;
                    echo "$flag";
                    echo"aefi;ljeageorisoir";
                }
            }

            if($flag==0){

                $query13="insert into schedule_recommand.lecture_has_user values('$data10[Code]','$data10[Class]','$userid',0)";
                $query14="insert into schedule_recommand.lecture_has_user values('$data10[Code]','$data10[Class]','$userid',1)";
                $result13 = mysqli_query($conn, $query13);
                $result14 = mysqli_query($conn, $query14);
                if($result13){
                    echo" re13 success<br> ";
                }
                else{
                    echo" re13 fail <br>";
                }
                $num_b--;
                $query15="select * from schedule_recommand.time_has_lecture where lecture_Code= '$data10[Code]' and lecture_Class='$data10[Class]'"; // 추가한 과목 시간 배열 추가를 위한 쿼리
                $result15 = mysqli_query($conn, $query15);
                while ($data15 = mysqli_fetch_array($result15)) {
                    $time[$data15[time_time]]=1;
                }

            }


        }
    }
}


//교양과목 추천
$query10="select * from lecture where Department='HSS' order by prefer DESC";
$result10=mysqli_query($conn,$query10);
if($result10){
    echo"re10 successs<br><br>";
}
else{
    echo"re10 fails<br><br>";
}
while($data10=mysqli_fetch_array($result10)) {
    echo "과목이름 시작$data10[Code] ";
    echo "$data10[Class] ";
    $query11 = "select * from schedule_recommand.time_has_lecture where lecture_Code='$data10[Code]' and lecture_Class='$data10[Class]'"; //시간확인을 위한 쿼리
    $result11 = mysqli_query($conn, $query11);
    $checktime = 1; // 시간이 되면 1 안되면 0
    while ($data11 = mysqli_fetch_array($result11)) {
        echo " $data11[time_time] ";
        if ($time[(int)$data11[time_time]] == 1) {
            $checktime = 0;
        }
    }
    echo" 체크타임 : $checktime";
    echo"남은 교양개수: $num_c<br>";
    if($checktime==1 && $num_c >0) {
        $query12 = "select * from schedule_recommand.lecture_has_user where lecture_Code= '$data10[Code]' and lecture_Class='$data10[Class]' and user_id='$userid'"; //이미 들었는지 체크를 위한 쿼리
        $checktake = 1; // 수강을 안했으면 1 했으면 0
        $result12 = mysqli_query($conn, $query12);
        while ($data12 = mysqli_fetch_array($result12)) {
            if ($data12[classify] == 0)
                $checktake = 0;
        }
        if ($checktake == 1) {

            $query20="SELECT * FROM schedule_recommand.lecture where Code='$data10[Code]' and Class='$data10[Class]'";
            $result20=mysqli_query($conn, $query20);
            $data20=mysqli_fetch_array($result20);
            $flag=0;

            $query21="select * FROM schedule_recommand.lecture_has_user where user_id='$userid'";
            $result21=mysqli_query($conn, $query21);
            while($data21=mysqli_fetch_array($result21)){
                $query22="select * from schedule_recommand.lecture where Code='$data21[lecture_Code]' and Class= '$data21[lecture_Class]'";
                $result22=mysqli_query($conn, $query22);
                $data22=mysqli_fetch_array($result22);
                echo "<br>f$data22[Name]f";
                echo "f$data20[Name]f<br>";
                if (!strcmp("$data22[Name]" , "$data20[Name]")){
                    echo "<br>$data22[Name]";
                    echo "$data20[Name]<br>";
                    $flag = 1;
                    echo "$flag";
                    echo"aefi;ljeageorisoir";
                }
            }

            if($flag==0){

                $query13="insert into schedule_recommand.lecture_has_user values('$data10[Code]','$data10[Class]','$userid',0)";
                $query14="insert into schedule_recommand.lecture_has_user values('$data10[Code]','$data10[Class]','$userid',1)";
                $result13 = mysqli_query($conn, $query13);
                $result14 = mysqli_query($conn, $query14);
                if($result13){
                    echo" re13 success<br> ";
                }
                else{
                    echo" re13 fail <br>";
                }
                $num_c--;
                $query15="select * from schedule_recommand.time_has_lecture where lecture_Code= '$data10[Code]' and lecture_Class='$data10[Class]'"; // 추가한 과목 시간 배열 추가를 위한 쿼리
                $result15 = mysqli_query($conn, $query15);
                while ($data15 = mysqli_fetch_array($result15)) {
                    $time[$data15[time_time]]=1;
                }

            }



        }
    }
}



echo"<br> time array:";
for($i=0 ; $i < 26 ; ++$i){
    echo"$time[$i] ";
}


echo("<script>location.href='schedule.php';</script>");






?>