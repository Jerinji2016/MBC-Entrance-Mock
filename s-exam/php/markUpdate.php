<?php 
    include '../../dbConnect.php';

    $user = $_GET['user'];

    $phytime = $_GET['phytime'];
    $chemtime = $_GET['chemtime'];
    $mathtime = $_GET['mathtime'];
    $gktime = $_GET['gktime'];

    $phy_sql = "SELECT COUNT(*) from `".$user."` WHERE topic='physics' AND result = 1";
    $chem_sql = "SELECT COUNT(*) from `$user` WHERE topic='chemistry' AND result = 1";
    $math_sql = "SELECT COUNT(*) from `$user` WHERE topic='maths' AND result = 1";
    $gk_sql = "SELECT COUNT(*) from `$user` WHERE topic='gk' AND result = 1";

    echo $phy_sql."\n";

    $phy_sql = ($phy_sql == null) ? 0 : $phy_sql;
    $chem_sql = ($chem_sql == null) ? 0 : $chem_sql;
    $math_sql = ($math_sql == null) ? 0 : $math_sql;
    $gk_sql = ($gk_sql == null) ? 0 : $gk_sql;

    $arr = array();
    $phymark = mysql_fetch_array(mysql_query($phy_sql))[0];
    $chemmark = mysql_fetch_array(mysql_query($chem_sql))[0];
    $mathmark = mysql_fetch_array(mysql_query($math_sql))[0];
    $gkmark = mysql_fetch_array(mysql_query($gk_sql))[0];

    $var_sql = "UPDATE student_list SET time_physics = $phytime,
                        time_chemistry = $chemtime,
                        time_maths = $mathtime,
                        time_gk = $gktime,
                        physics_marks = $phymark,
                        chemistry_marks = $chemmark,
                        maths_marks = $mathmark,
                        gk_marks = $gkmark,
                        exam_status = 2
                        WHERE user_id = '$user'";

    echo $var_sql."\n";
    $conn = mysql_query($var_sql);
?>