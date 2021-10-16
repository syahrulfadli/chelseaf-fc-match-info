<?php
include "head.php";

$competition_fixture = $_GET['competitions'];

include "navbar.php"
?>

<h4>Standings</h4>

<div class="card border-2 rounded-0 border-primary mx-5">
    <div class="bg-primary text-white pt-3 pb-2 px-5">
        <h5>Premier League</h5>
    </div>
    <div class="row px-4">
    <?php
    
    $curl = curl_init();
    
    curl_setopt($curl, CURLOPT_URL, 'https://api.football-data.org/v2/competitions/2021/standings?standingType=HOME');
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        'X-Auth-Token: 2b398d505b0746d180ef28fbfec38b03',
    ));
    
    $result = curl_exec($curl);
    curl_close($curl);
    
    $result = json_decode($result, true);
    
    $standing = $result ['standings'][0]['table'];
    
    print "
        <div class='col-1 border-bottom text-center fw-bold'>Pos</div>
        <div class='col-4 border-bottom fw-bold'>Club</div>
        <div class='col-1 border-bottom text-center fw-bold'>Play</div>
        <div class='col-1 border-bottom text-center fw-bold'>Won</div>
        <div class='col-1 border-bottom text-center fw-bold'>Draw</div>
        <div class='col-1 border-bottom text-center fw-bold'>Lost</div>
        <div class='col-2 border-bottom text-center fw-bold'>Goal Difference</div>
        <div class='col-1 border-bottom text-center fw-bold'>Points</div>
        ";
    
    foreach ($standing as $list){
        $position = $list["position"];
        $team = $list["team"]["name"];
        $MP = $list ["playedGames"];
        $WIN = $list ["won"];
        $DRAW = $list ["draw"];
        $LOSE = $list ["lost"];
        $GD = $list ["goalDifference"];
        $points = $list ["points"];
        if ($team == "Chelsea FC"){
            $class = " border-0 bg-primary text-white fw-bold";
        } else {
            $class = "";
        }
        print "
        <div class='col-1 border-bottom text-center $class'>$position</div>
        <div class='col-4 border-bottom $class'>$team</div>
        <div class='col-1 border-bottom text-center $class'>$MP</div>
        <div class='col-1 border-bottom text-center $class'>$WIN</div>
        <div class='col-1 border-bottom text-center $class'>$DRAW</div>
        <div class='col-1 border-bottom text-center $class'>$LOSE</div>
        <div class='col-2 border-bottom text-center $class'>$GD</div>
        <div class='col-1 border-bottom text-center $class'>$points</div>
        ";
    }
    
    ?>
    
    </div>  
</div>

<?php
include "footer.php";
?>