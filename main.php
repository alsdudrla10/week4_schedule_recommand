<?php
session_start();
if(!isset($_SESSION['id']))
{

    header('location: ./signin.html');
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>


    <style>
        input,textarea:focus {
            outline: none;
        }

        h, td, tr, input, textarea, select, FORM
        {
            font-family:고딕;
            font-size:1em;
            font-weight: bold;
            border-radius:5px;


        }

        table, FORM
        {
            border:1px solid rgb(0, 0, 0);
            border-spacing:15px;
        }



    </style>


</head>
<body style="background-color:#f0f5f3">
<script>

</script>
<center>
    <br><br><br><br>
    <a href="main.php" style="text-decoration:none; color: black; align: center; "> <h1> Recommend Schedule </h1></a>
    <table boder = "" bgcolor = "#FFFFFF" cellspacing = "1" >
            <tr></tr>
            <tr>
                <td></td>
                <td text-align="center">
                    <?php
                    $mysqli=mysqli_connect("localhost","root","sksmssksms","schedule_recommand");
                    $id=$_SESSION['id'];
                    $q="SELECT * FROM schedule_recommand.user WHERE id='$id'";
                    $result=$mysqli-> query($q);
                    if($result->num_rows==1){
                        $row=$result->fetch_array(MYSQLI_ASSOC);
                        $name=$row['name'];
                        $student_id=$row['student_id'];
                        $major=$row['major'];
                        $additional=$row['additional'];
                        $additionalMajor=$row['additionalMajor'];
                    }
                    else{
                        echo "wrong";
                    }
                    echo "$name 님";
                    ?>
                </td>
                <td>
                </td>
                <td>
                    <a href=logout.php> Sign Out </a>
                </td>
                <td></td>
            </tr>
            <tr></tr>

            <tr>
                <td></td>
                <td>Student_id: </td>
                <td></td>
                <td> <?php
                    echo "$student_id";
                    ?>
                </td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td>Major:</td>
                <td></td>
                <td> <?php
                    echo "$major";
                    ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td> <?php
                    echo "$additional";
                    ?>
                </td>
                <td></td>
                <td> <?php
                    echo "$additionalMajor";
                    ?>
                </td>
            </tr>

            <tr>
            </tr>
        <tr>
        </tr>
        <tr>
            <td></td>
            <td>
                <a href=settinglecture.php id="settingtext" style="text-decoration:none; color: black;" onmouseover="colorChange1(this)" onmouseout="colorChange2(this)" > Setting Lecture </a>
            </td>
            <td>
            </td>
            <td>
                <a href=decidelecture.php id="recommendtext" style="text-decoration:none; color: black;" onmouseover="colorChange1(this)" onmouseout="colorChange2(this)"> Recommend </a>
            </td>
            <td></td>
        </tr>


    </table>

    <br/>
<SCRIPT>
    function colorChange1(src){
        src.style.color="Gray";
    }

    function colorChange2(src) {
        src.style.color="Black";
    }
</SCRIPT>



</center>
</body>
</html>
