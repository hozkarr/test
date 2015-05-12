<audio controls>
    <source src="voicemail/10000/msg_0770f99a-a897-11e4-a46a-b74370fb1d23.wav" type="audio/wav">
    Your browser does not support the audio element
</audio>

<?php
$path = "/var/www/html/homeinsted/voicemail/10000/";
$fp = popen("ls -t -1 --file-type " . $path, "r");

$path10001 = "/var/www/html/homeinsted/voicemail/10001/";
$fp10001 = popen("ls -t -1 --file-type " . $path10001, "r");

$vm_file_list = array();
$i = 0;
while ($rec = fgets($fp)) {
    $vm_file_list[$i]['date'] = date('Y-m-d H:i:s', filectime($path . trim($rec)));
    $vm_file_list[$i]['file'] = trim("10000::" . $rec);
    $i++;
}

while ($rec10001 = fgets($fp10001)) {
    $vm_file_list[$i]['date'] = date('Y-m-d H:i:s', filectime($path10001 . trim($rec10001)));
    $vm_file_list[$i]['file'] = trim("10001::" . $rec10001);
    $i++;
}
foreach ($vm_file_list as $key => $row) {
    $date[$key] = $row['date'];
}


array_multisort($date, SORT_DESC, $vm_file_list);

//print_r($vm_file_list);

$ua = getBrowser();
$browser = $ua['name'];

?>
<table width="100%">
    <?php
    for ($i = 0; $i < count($vm_file_list); $i++) {
        $explode_vm_file_list = explode("::", $vm_file_list[$i]['file']);
        ?>
        <tr>
            <td width="20%" style="text-align:center">
                <?php
                echo $vm_file_list[$i]['date'];
                ?>
            </td>

            <td width="20%">
                <?php if ($explode_vm_file_list[0] == '10000') { ?>
                    <div
                        style="background-color: #78399C; color: white; height: 22px; width: 80%; text-align: center; margin-top: -5px;">
                        HI
                    </div>
                <?php } else { ?>
                    <div
                        style="background-color: #22B14C; color: white; height: 22px; width: 80%; text-align: center; margin-top: -5px;">
                        VID
                    </div>
                <?php } ?>
            </td>
            <td style="vertical-align:none !important;" width="50%" style="text-align:center">
                <!-- 							    <img src="img/rec.png"> -->
                <?php
                $filepath = "voicemail/$explode_vm_file_list[0]/" . $explode_vm_file_list[1];
                ?>
                <audio controls preload="none" style="width: 100%;">
                    <source src='<?php echo $filepath; ?>' type="audio/wav">
                </audio>

            </td>

        </tr>
        <tr class="vc_text_separator">
            <td>
            </td>
        </tr>
    <?php
    }
    ?>
</table>

<?php
function getBrowser()
{
$u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version = "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    } elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }

    //Detect special conditions devices
    $iPhone = stripos($_SERVER['HTTP_USER_AGENT'], "iPhone");
    $iPad = stripos($_SERVER['HTTP_USER_AGENT'], "iPad");

    //do something with this information
    if ($iPhone) {
        $platform = 'IPHONE';
    } elseif ($iPad) {
        $platform = 'IPAD';
    }

    // Next get the name of the useragent yes seperately and for good reason
    if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    } elseif (preg_match('/Firefox/i', $u_agent)) {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    } elseif (preg_match('/Chrome/i', $u_agent)) {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    } elseif (preg_match('/Safari/i', $u_agent)) {
        $bname = 'Apple Safari';
        $ub = "Safari";
    } elseif (preg_match('/Opera/i', $u_agent)) {
        $bname = 'Opera';
        $ub = "Opera";
    } elseif (preg_match('/Netscape/i', $u_agent)) {
        $bname = 'Netscape';
        $ub = "Netscape";
    } else {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    }

    return array(
        'platform' => $platform,
        'name' => $bname,
    );
}
