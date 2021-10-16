<?php
include "partial/head.php";

$matchid = $_GET['matchid'];

$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, "https://api.football-data.org/v2/matches/$matchid");
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'X-Auth-Token: 2b398d505b0746d180ef28fbfec38b03',
));

$result = curl_exec($curl);
curl_close($curl);

$result = json_decode($result, true);


$competition_name = $result ['match']['competition']['name'];
$status = $result ['match']['status'];
$stage = $result ['match']['stage'];
$group = $result ['match']['group'];
$stadium = $result ['match']['venue'];
$scoreHome = $result ['match']['score']['fullTime']['homeTeam'];
$scoreAway = $result ['match']['score']['fullTime']['awayTeam'];
$homeTeam = $result ['match']['homeTeam']['name'];
$awayTeam = $result ['match']['awayTeam']['name'];
$homeTeam_ID = $result ['match']['homeTeam']['id']; 
$awayTeam_ID = $result ['match']['awayTeam']['id'];
$matchWinner = $result ['match']['score']['winner'];
$matchday = $result ['match']['matchday'];
$head2head = $result ['head2head']['numberOfMatches'];
$matchdate = $result ['match']['utcDate'];
// $referees = $result ['match']['referees'];

if ($stage == "GROUP_STAGE"){
    $stage = "Group Stage";
} else {
    $stage = "";
}

$group = substr($group,6,5);


if ($competition_name == "Premier League"){
    $badge="#460086";
    $text_color = "text-white";
} elseif ($competition_name == "UEFA Champions League"){
    $badge = "#0173ea";
    $text_color = "text-white";
} else {
    $badge = "#fff";
    $text_color = "text-dark";
}

date_default_timezone_set('Europe/London');

$slicestringdate = substr($matchdate,0,10);

$slicestringtime = substr($matchdate,11,16);

$datetime = new DateTime($slicestringdate. $slicestringtime);
$UKtime = $datetime->format('l, d F Y H:i');

$indo1_time = new DateTimeZone('Asia/Jakarta');
$datetime->setTimezone($indo1_time);
$WIB = $datetime->format('l, d F Y H:i');


$indo2_time = new DateTimeZone('Asia/Hong_Kong');
$datetime->setTimezone($indo2_time);
$WITA = $datetime->format('l, d F Y H:i');

$indo3_time = new DateTimeZone('Asia/Seoul');
$datetime->setTimezone($indo3_time);
$WIT = $datetime->format('l, d M Y H:i');

if ($status == "FINISHED"){
    $final = "FT";
} else {
    $final = "-";
}

include "partial/navbar.php";
?>

<div class='row'>
    <div class='col-md-8'>
        <div class='card text-center rounded-0 border-2' style="border-color:<?= $badge ?>">
            <h3 class='card-title py-2'>Match Info Matchday <?= $matchday ?> of <?= $competition_name ?></h3>
            <h4><?php echo "$homeTeam VS $awayTeam";?></h4>
            <?php
            if ($stage != null){
                echo "<p>$stage</p>";
                echo "Group $group";
            }
            ?>
            <div class='card-body'>
                <h5>Kick Off</h5>
                <div class='row border-bottom mb-3 pb-3'>
                    <div class='col-3'>UK/London (UTC-6)</br><?= $UKtime?></div>
                    <div class='col-3'>WIB (GMT+7)</br><?= $WIB?></div>
                    <div class='col-3'>WITA (GMT+8)</br><?= $WITA?></div>
                    <div class='col-3'>WITA (GMT+9)</br><?= $WIT?></div>
                </div>
                <h5>Stadium (Venue)</h5>
                <div class='row border-bottom  mb-3'>
                    <p><?= $stadium ?></p>
                </div>
                <h5>Referees</h5>
                <div class='row border-bottom  mb-3'>
                    <div class='col-6 border-end border-bottom fw-bold'>Name</div>
                    <div class='col-6 border-bottom fw-bold'>Role</div>
                    <?php
                    $curl = curl_init();
                    $matchesid = $_GET['matchesid'];
                    curl_setopt($curl, CURLOPT_URL, 'http://api.football-data.org/v2/teams/61/matches');
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                        'X-Auth-Token: 2b398d505b0746d180ef28fbfec38b03',
                        ));

                    $result = curl_exec($curl);
                    curl_close($curl);

                    $result = json_decode($result, true);
                    $referees = $result ['matches'][$matchesid]['referees'];
                    
                    foreach ($referees as $person){
                        print "<div class='col-6 border-end'>";
                        print $person['name'];
                        print " </div>  <div class='col-6'>";
                        $role = $person ['role'];
                        if ($role == "ASSISTANT_REFEREE_N1"){
                            $role = "Assistant Referee 1";
                        } elseif ($role == "ASSISTANT_REFEREE_N2"){
                            $role = "Assistant Referee 2";
                        } elseif ($role == "FOURTH_OFFICIAL"){
                            $role = "Fourth Official";
                        } elseif ($role == "REFEREE"){
                            $role = "Referee";
                        } elseif ($role == "VIDEO_ASSISANT_REFEREE_N1"){
                            $role = "VAR 1";
                        } else {
                            $role = "VAR 2";
                        }
                        
                        print $role;
                        print "</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class='col-md-4'>
        <div class='card text-center  rounded-0 <?= $text_color ?>' style="background-color:<?= $badge ?>">
            <h3 class='card-title py-2'>Result</h3>
            <div class='card-body'>
                <div class='row align-items-center'>
                    <div class='col-5'>
                        <img src="https://crests.football-data.org/<?= $homeTeam_ID ?>.svg" alt="home team" width="64" height="auto"/>
                    </div>
                    <div class='col-2 fw-bold'>VS</div>
                    <div class='col-5'>
                        <img src="https://crests.football-data.org/<?= $awayTeam_ID ?>.svg" alt="away team" width="64" height="auto"/></div>
                    <!--hehehe-->
                    <div class='w-100 mt-2'></div>
                    <div class='col-5 fs-4'><?= $scoreHome ?></div>
                    <div class='col-2'><?= $final ?></div>
                    <div class='col-5 fs-4'><?= $scoreAway ?></div>
                </div>
            </div>
        </div>
        <a class='btn btn-primary w-100 mt-3 rounded-0 border-0' href='/chelsea#fixture'>View all fixtures</a>
    </div>
</div>

<?php include "partial/footer.php";?>
