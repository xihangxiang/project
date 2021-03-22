<?php

$arr = array("value1", "value2", "value3", "value4", "value5", "value6");
$str1 = $str2 = $str3 = $str4 = $str5 = $str6 = $str7 = $str8 = $str9 = "";
if (isset($_POST['submit'])) {
    if ($_FILES["file"]["type"] == "text/plain") {
        $fileName = basename($_FILES['file']['name']);
        $tempName = $_FILES['file']['tmp_name'];
        $str = file_get_contents($_FILES['file']['tmp_name']);
        $array = explode("\r\n", $str);
        foreach ($array as $value) {
            $str1 .= $value . "<br>";
            $str2 .= substr_count($value, ',') . "<br>";
            $str3 .= getMarkCount($value) . "<br>";
            $str4 .= getOrderString($value) . "<br>";
            $str5 .= ucwords($value) . "<br>";
            $str6 .=getMiddleString($value) . "<br>";
            if (isset($_POST['search']) && $_POST['search'] != "") {
                $k = 0;
                $array2 = explode(" ", $str);
                foreach ($array2 as $value1) {

                    if (strpos($value1, $_POST['search']) > 0 || strpos($value1, $_POST['search']) === 0) {
                        $str8 .= $value1 . " ";
                    } else {
                        $k++;
                    }
                }
                $str9 = "Did not have the term:" . $k;
            }
        }

    }
    if (isset($_POST['content']) && $_POST['content']!="") {
        $content=$_POST['content'];
        $str1=$content;
        $str2=substr_count($content, ',');
        $str3=getMarkCount($content);
        $str4=getOrderString($content);
        $str5 .= ucwords($content);
        $str6 .=getMiddleString($content);
    }

    if (isset($_POST['search']) && isset($_POST['content'])) {
        $str7 = str_replace($_POST['search'], "<font color=red>" . $_POST

            ['search'] . "</font>", $_POST['content']);
    }
}


//  characters with an ascii value between 32-47
function getMarkCount($str) {
    $len = strlen($str);
    $num = 0;
    for ($i = 0; $i < $len; $i ++){
        if (ord($str[$i]) >= '32' && ord($str[$i]) <= '47') {
            $num ++;
        }
    }
    return $num;
}

// re-ordered
function getOrderString($str) {
    $arr = explode(" ", $str);
    array_multisort($arr, SORT_DESC, SORT_NATURAL|SORT_FLAG_CASE);
    return implode(" ", $arr);
}

//get middle string
function getMiddleString($str) {
    $array = explode(" ", $str);
    $arr = array_chunk($array, ceil(count($array) / 3));
    return implode(' ', $arr[1]);
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Question #1</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>

<body>

<form action="index.php" method="post" class="btn" enctype="multipart/form-data">
    <table>
        <tr>
            <td>Search:</td>
            <td><input type="text" name="search"></td>
        </tr>
        <tr>
            <td> content:</td>
            <td><textarea name="content" rows="5" cols="30"></textarea></td>
        </tr>
        <tr>
            <td>file:</td>
            <td><input type="file" name="file"></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" name="submit" value="submit"></td>
        </tr>
    </table>

</form>

<table>
    <tr>
        <td>Question</td>
        <td>Result</td>
    </tr>
    <tr>
        <td>The original string</td>
        <td><?= $str1; ?></td>
    </tr>
    <tr>
        <td>The number of commas in each string</td>
        <td><?= $str2; ?></td>
    </tr>
    <tr>
        <td>The number of common punctuation characters in each string</td>
        <td><?= $str3; ?></td>
    </tr>
    <tr>
        <td>The string re-ordered</td>
        <td><?= $str4; ?></td>
    </tr>
    <tr>
        <td>The string as a proper title</td>
        <td><?= $str5; ?></td>
    </tr>
    <tr>
        <td>The middle-third characters of the string</td>
        <td><?= $str6; ?></td>
    </tr>
    <tr>
        <td>For the single string</td>
        <td><?= $str7; ?></td>
    </tr>
    <tr>
        <td>For the file upload</td>
        <td><?= $str8; ?><br><?= $str9; ?></td>
    </tr>
    <tr>
        <td></td>
        <td></td>
    </tr>
</table>

</body>
</html>
