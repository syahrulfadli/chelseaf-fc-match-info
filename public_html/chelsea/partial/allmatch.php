<?php
$competition_fixture = $_GET['competitions'];

if ($competition_fixture == "Premier League"){
    $competitions = $competition_fixture;
} elseif ($competition_fixture == "UEFA Champions League") {
    $competitions = $competition_fixture;
} else {
    $competitions = "All";
}

?>
<h4 id='fixture'>
Fixtures
<span class="dropdown">
  <button class="btn dropdown-toggle btn-outline-primary rounded-0" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
    <?= $competitions ?>
  </button>
  <ul class="dropdown-menu border-primary rounded-0" aria-labelledby="dropdownMenuButton1">
    <li><a class="dropdown-item" href="/chelsea#fixture">All</a></li>
    <li>
        <form action="/chelsea#fixture" method="GET">
            <input type="hidden" name="competitions" value="Premier League"/>
            <input class="dropdown-item" type="submit" value="Premier League"/>
        </form>
        
    </li>
    <li>
        <form action="/chelsea#fixture" method="GET">
            <input type="hidden" name="competitions" value="UEFA Champions League"/>
            <input class="dropdown-item" type="submit" value="UEFA Champions League"/>
        </form>
    </li>
  </ul>
</span>
</h4>

<?php
$competition_fixture = $_GET['competitions'];
$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, 'http://api.football-data.org/v2/teams/61/matches');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'X-Auth-Token: 2b398d505b0746d180ef28fbfec38b03',
));

$result = curl_exec($curl);
curl_close($curl);

$result = json_decode($result, true);
$n=0;

$color;

$match = $result ['matches'];

echo '<div class="row row-cols-1 row-cols-md-3 g-4">';
$i=0;
foreach ($match as $list) {
    $competition_name = $result['matches'][$i]['competition']['name'];
    $match_id = $result['matches'][$i]['id'];
    $competition_id = $result['matches'][$i]['competition']['id'];
    $matchday = $result ['matches'][$i]['matchday'];
    $homeTeam = $result ['matches'][$i]['homeTeam']['name'];
    $awayTeam = $result ['matches'][$i]['awayTeam']['name'];
    $matchdate = $result ['matches'][$i]['utcDate'];
    $status = $result ['matches'][$i]['status'];
    $homeTeam_ID = $result ['matches'][$i]['homeTeam']['id']; 
    $awayTeam_ID = $result ['matches'][$i]['awayTeam']['id'];
    $scoreHome = $result ['matches'][$i]['score']['fullTime']['homeTeam'];
    $scoreAway = $result ['matches'][$i]['score']['fullTime']['awayTeam'];
    $matchWinner = $result ['matches'][$i]['score']['winner'];
    
    if ($competition_fixture == "Premier League" && $competition_name == "Premier League"){
        $hide=" style='display:block'"; 
    } elseif ($competition_fixture == "UEFA Champions League" && $competition_name == "UEFA Champions League") {
        $hide=" style='display:block'";
    } elseif ($competition_fixture == null) {
        $hide=" style='display:block'";
    }    else {
        $hide = " style='display:none'";
    }
    
    if ($competition_name == "Premier League"){
        $badge="#460086"; 
    } elseif ($competition_name == "UEFA Champions League"){
        $badge = "#0173ea";
    } else {
        $badge = "#fff";
    }
    
    if (($homeTeam == "Chelsea FC" && $matchWinner == "HOME_TEAM") || ($awayTeam == "Chelsea FC" && $matchWinner == "AWAY_TEAM")) {
        $color = "success";
        $status = "WIN";
    } elseif ($matchWinner == "DRAW") {
        $color = "primary";
        $status = "DRAW";
    } elseif ($status == "SCHEDULED") {
        $color = "dark";
    } else {
        $color = "danger";
        $status = "LOSE";
    }
    
    //time and date conversion
    date_default_timezone_set('Europe/London');

    $slicestringdate = substr($matchdate,0,10);
    
    $slicestringtime = substr($matchdate,11,16);
    
    $datetime = new DateTime($slicestringdate. $slicestringtime);
    $UKtime = $datetime->format('d M Y H:i');
    
    $indo1_time = new DateTimeZone('Asia/Jakarta');
    $datetime->setTimezone($indo1_time);
    $WIB = $datetime->format('d M Y H:i');
    
    
    $indo2_time = new DateTimeZone('Asia/Hong_Kong');
    $datetime->setTimezone($indo2_time);
    $WITA = $datetime->format('d M Y H:i');
    
    $indo3_time = new DateTimeZone('Asia/Seoul');
    $datetime->setTimezone($indo3_time);
    $WIT = $datetime->format('d M Y H:i');
    
    
    echo '
    <div class="col" ' .$hide. '>
    <div class="card h-100 rounded-0 border-2" style="border-color:' .$badge. '">
        <div class="card-body">
            <h5 class="card-title">' . $competition_name . ' <div class="rounded-pill float-end" style="background:' .$badge. ';width:24px;height:24px"/></h5>
            <h6 class="card-subtitle mb-2 text-muted"> Matchday ' .$matchday. ' - <span class="bg-'.$color.' text-white rounded-pill px-2">' .$status. '</span></h6>
            <div class="row">
            <div class="col-sm-8">' .$homeTeam. '</div>
            <div class="col-sm-4 text-end">' .$scoreHome. '</div>
              <div class="w-100 border-bottom"></div>
            <div class="col-sm-8">' .$awayTeam. '</div>
            <div class="col-sm-4 text-end">' .$scoreAway. '</div>
            </div>
        </div>
        <div class="card-footer text-muted bg-transparent border-0 fs-sm text-light">
            UK/London: ' .$UKtime. '<br/>
            WIB: ' .$WIB. '</br/>
            WITA: ' .$WITA. '<br/>
            WIT: ' .$WIT. '</br/>
            <form action="match-details.php" method="GET">
            <input type="hidden" name="matchid" value="' .$match_id. '">
            <input type="hidden" name="matchesid" value="' .$i. '">
            <input class="btn btn-primary w-100 mb-2 rounded-0 border-0" type="submit" value="Details">
            </form>
        </div>
    </div>
    </div>
    ';
    $i++;
}

echo '</div>';

?>