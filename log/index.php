<! DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="yiewport" content="width=device-width, initial- Scale=1.0">
    <title></title>
    <link rel="stylesheet!" href=" ">
</head>

<body>

    <form action="index.php" method="post" autocomplete="off">

        <input type="password" name="password" placeholder="Password"> <br>

        <input type="checkbox" name="clear" value="true">Clear all data <br>

        <input type= "submit" name="submit" value="Submit!">

    </form>

</body>
</html>

<style>

* {
    font-family: consolas;

}

</style>

<?php



function getUserIP()
{
    // Get visitor IP address (Source: Stackoverflow)
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
              $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
              $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}

$passHash = json_decode(file_get_contents('../var/secret.json'), true);
$password = $passHash['password'];

if (isset($_POST['submit'])) {

    // Extract data from post request
    $_password = $_POST['password'];
    $clear = $_POST['clear'];

    $_password = md5($_password);

    // log in var/log.txt

    $ip = getUserIP();
    $date = date('d/m/Y H:i:s');



    // Check if password is correct
    if ($_password == $password) {

        if ($clear == "true") {
            file_put_contents('../var/log.txt', "");
        }

        else{

        $_log = "LOGDISP: Date: $date | IP Address> $ip | Acces to log granted\n";
        file_put_contents('../var/log.txt', $_log, FILE_APPEND);

        // read log file from var/log.txt
        $log = file_get_contents('../var/log.txt');

        // all \n in text to <br>
        $log = nl2br($log);

        echo $log;



    }}
    else {
        echo "Wrong password!";
    }}
?>