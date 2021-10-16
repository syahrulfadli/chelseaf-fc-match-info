<?php
include "partial/head.php";

$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, 'https://api.football-data.org/v2/teams/61/matches?status=SCHEDULED');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'X-Auth-Token: 2b398d505b0746d180ef28fbfec38b03',
));

$result = curl_exec($curl);
curl_close($curl);

$result = json_decode($result, true);
$n=0;

$competition_name = $result['matches'][$n]['competition']['name'];
$competition_id = $result['matches'][$n]['competition']['id'];
$matchday = $result ['matches'][$n]['matchday'];
$homeTeam = $result ['matches'][$n]['homeTeam']['name'];
$awayTeam = $result ['matches'][$n]['awayTeam']['name'];
$matchdate = $result ['matches'][$n]['utcDate'];
$homeTeam_ID = $result ['matches'][$n]['homeTeam']['id']; 
$awayTeam_ID = $result ['matches'][$n]['awayTeam']['id'];

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
$UKtime = $datetime->format('l, d M Y H:i');

$indo1_time = new DateTimeZone('Asia/Jakarta');
$datetime->setTimezone($indo1_time);
$WIB = $datetime->format('l, d M Y H:i');


$indo2_time = new DateTimeZone('Asia/Hong_Kong');
$datetime->setTimezone($indo2_time);
$WITA = $datetime->format('l, d M Y H:i');

$indo3_time = new DateTimeZone('Asia/Seoul');
$datetime->setTimezone($indo3_time);
$WIT = $datetime->format('l, d M Y H:i');

?>

<?php include "partial/navbar.php"?>

<div class="container my-5 py-2">
</div>
<h4>Upcomming Match</h4>
<div class="card text-center mb-5 rounded-0 border-2 <?= $text_color?>" style="background-color:<?= $badge?>;">
  <div class="card-header bg-transparent border-0">
    <!-- test -->
  </div>
  <div class="card-body">
    <h5 class="card-title"><?php echo $competition_name . " - Matchday " . $matchday; ?></h5>
    
    <div class="row align-items-center">
    <div class="col">
        <img src="https://crests.football-data.org/<?= $homeTeam_ID ?>.svg" alt="home team" width="100" height="auto"/>
        <span class="ms-3 fs-4"><?= $homeTeam ?></span>
    </div>
    <div class="col fs-3">
      VS
    </div>
    <div class="col">
        <span class="me-3 fs-4"><?= $awayTeam ?></span>
        <img src="https://crests.football-data.org/<?= $awayTeam_ID ?>.svg" alt="away team" width="100" height="auto"/>
    </div>
  </div>
    <a href="#" class="btn btn-outline-light rounded-0">Head to Head</a>
  </div>
  <div class="card-footer text-light bg-transparent border-0">
    <div class="row align-items-center">
        <div class="col">UK/London<br/><?= $UKtime ?></div>
        <div class="col">WIB<br/><?= $WIB ?></div>
        <div class="col">WITA<br/><?= $WITA ?></div>
        <div class="col">WIT<br/><?= $WIT ?></div>
    </div>
   
  </div>
</div>


<?php include "partial/allmatch.php"?>

<?php
include "partial/footer.php"
?>