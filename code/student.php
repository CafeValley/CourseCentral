<?php
require_once "config.php";

//here need to add number of rows return !!!!!
// if its less than 1 then return 0 !
$TheCurrentStandOutNumber = GetMaxID();
$StdId = '';

if (isset($_POST['Year']) && $_POST['Year'] == 'Year') {
    $FYI = 'Fyear';
    header('Location:RegisFrom.php?FYI=' . $FYI . '');
}

if (isset($_POST['chkBoxId']) && $_POST['chkBoxId'] == 'on')
{
    if (isset($_POST['txtBoxId']) && $_POST['txtBoxId'] != '' )
    {
        $IdFromForm = $_POST['txtBoxId'];
        $SqlExistID = mysqli_query($link,"SELECT count(ST_Gid) as CountNumber FROM `student` where ST_Gid = $IdFromForm ") or die(mysqli_error());
        $CountSqlExistID = mysqli_fetch_array($SqlExistID);
        // New Id
        //check if this id is in or not !!!

        if($CountSqlExistID['CountNumber'] >= 1)
        {
            $resultSNC = mysqli_query ($link , "SELECT `s_id` , CONCAT(UCASE(LEFT(`S_firstname`, 1)), SUBSTRING(`S_firstname`, 2)) as S_firstname ,CONCAT(UCASE(LEFT(`S_midname1`, 1)), SUBSTRING(`S_midname1`, 2)) as S_midname1 ,CONCAT(UCASE(LEFT(`S_midname2`, 1)), SUBSTRING(`S_midname2`, 2)) as S_midname2 ,CONCAT(UCASE(LEFT(`S_lastname1`, 1)), SUBSTRING(`S_lastname1`, 2)) as S_lastname1  FROM `student` WHERE `ST_Gid` = "
                . $IdFromForm . " ");
            $rowSNC  = mysqli_fetch_array ($resultSNC);
            $Fname   = $rowSNC['S_firstname'] . " " . $rowSNC['S_midname1'];
            $Sirname = " " . $rowSNC['S_midname2'] . " " . $rowSNC['S_lastname1'];
            $FullName = $Fname ." ". $Sirname;

            $vars = array('FullName' => $FullName, 'IdDuplication' => $IdFromForm);
            $querystring = http_build_query($vars);
            $url = 'Location:RegisFrom.php?' . $querystring;
            header($url);
        }else
        {
            $StdId = $IdFromForm;
            $Regfee  = 0;
        }
    }
    else
    {
        // Checked but Empty.
        header('Location:RegisFrom.php?IDEE=' . $IDEE . '');
    }
}
else
{
    //if the check box its not pressed !
    ///here some codes were removed why i dont know , the code seem to work without them
    /*
    $sqlFindStaticId = mysqli_query($link,"SELECT count(*) as Redured  FROM `student` where  ST_Gid > '$TheCurrentStandOutNumber' ") or die(mysqli_error());
    $countFindStaticId = mysqli_fetch_array($sqlFindStaticId);*/


    $sqlFindStaticId = mysqli_query($link,"SELECT count(*) as Redured  FROM `student` where ST_Gid = '$TheCurrentStandOutNumber'  ") or die(mysqli_error());
    $countFindStaticId = mysqli_fetch_array($sqlFindStaticId);
    if ($countFindStaticId['Redured'] > 0)
    {
        $sqlFindMaxId = mysqli_query($link,"SELECT max(ST_Gid) as MaxId  FROM `student` ") or die(mysqli_error());
        $countFindMaxId = mysqli_fetch_array($sqlFindMaxId);
        $StdId = $countFindMaxId['MaxId'] + 1 ;
    }
    else
    {
        $StdId = $TheCurrentStandOutNumber;
    }
    $Regfee  = isset($_POST['Regis_Fees']) ? $_POST['Regis_Fees'] : 0;
}

    $SGIDUS  = $StdId;
    $FNF     = isset($_POST['firstname']) ? $_POST['firstname'] : '';
    $MD1F    = isset($_POST['MiddleNameI']) ? $_POST['MiddleNameI'] : '';
    $MD2F    = isset($_POST['MiddleNameII']) ? $_POST['MiddleNameII'] : '';
    $LNF     = isset($_POST['LastName']) ? $_POST['LastName'] : '';
    $P1F     = isset($_POST['PhoneI']) ? $_POST['PhoneI'] : '';
    $P2F     = isset($_POST['PhoneII']) ? $_POST['PhoneII'] : '';
    $SFaceN  = isset($_POST['FaceBookName']) ? $_POST['FaceBookName'] : '';
    $Email   = isset($_POST['E_mail']) ? $_POST['E_mail'] : '';



    if (isset($_POST['Month']) && $_POST['Month'] == 'Month') {
        $month = 1;
    } else {
        $month = isset($_POST['Month']) ? $_POST['Month'] : 1;
    }
    if (isset($_POST['Day']) && $_POST['Day'] == 'Day') {
        $day = 1;
    } else {
        $day = isset($_POST['Day']) ? $_POST['Day'] : 1;
    }

    $BF = (isset($_POST['Year']) ? $_POST['Year'] : date('Y')) . "-" . $month . "-" . $day;

    // Ensure $SGIDUS has a valid value to prevent SQL syntax error
    if (empty($SGIDUS) || !is_numeric($SGIDUS)) {
        // If somehow $StdId is still empty, generate a new ID
        $sqlFindMaxId = mysqli_query($link,"SELECT max(ST_Gid) as MaxId FROM `student` ") or die(mysqli_error());
        $countFindMaxId = mysqli_fetch_array($sqlFindMaxId);
        $SGIDUS = isset($countFindMaxId['MaxId']) && $countFindMaxId['MaxId'] > 0 ? $countFindMaxId['MaxId'] + 1 : 1;
    }

    echo $query = "INSERT INTO `student`(`s_id`, `S_firstname`, `S_midname1`, `S_midname2`, `S_lastname1`, `S_phone1`, `S_phone2`, `S_Birthdate`,`S_Regis_Fees`, `ST_Gid`,`facebookname`, `S_e_mail` , `S_date_On`)
              VALUES (NULL , '$FNF' , '$MD1F', '$MD2F', '$LNF', '$P1F', '$P2F', '$BF',$Regfee, $SGIDUS,'$SFaceN','$Email',NOW())";
    echo "<br>".$query;
    mysqli_query($link,$query);
    header('Location:RegisFrom.php?SID=' . $SGIDUS . '');

?>