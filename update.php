<?php
session_start();
set_time_limit(60);

$bulk_players = array();
$bulk_vehicles = array();

include 'functions.php';

$clan_data = GetClanData($_SESSION['clan_id']);
// CTLogging("GetClanData (response): ".print_r($clan_data, true));
$_SESSION['member_count'] = count($clan_data);
session_write_close();

$current_member = 1;
foreach ($clan_data as $player) {
    $player_data = GetPlayerData($player['account_id']);
    // CTLogging("GetPlayerData (response): ".print_r($player_data, true));
    $bulk_players[] = '(' . time() . ',
		' . $player_data['clan']['clan']['id'] . ',
        "' . $player_data['clan']['clan']['abbreviation'] . '",
        ' . $player['account_id'] . ',
        "' . $player['name'] . '",
        "' . $player['role'] . '",
        ' . $player['member_since'] . ')';
//                            "' . (GetPlayerHistory($player['name'])) . '")';
   
    session_start();
    $_SESSION['member_current'] = $current_member;
    $_SESSION['player_name'] = $player['name'];
    session_write_close();
    
    $current_member = $current_member + 1;

    foreach ($player_data['vehicles'] as $vehicle_data) {
        if (($vehicle_data['level'] > 8) OR 
           ($vehicle_data['class'] == 'SPG' AND $vehicle_data['level'] > 6 ) OR
           ($vehicle_data['class'] == 'lightTank' AND $vehicle_data['level'] > 4 )) {  
                $bulk_vehicles[] = '(' . time() . ',
					' .$player['account_id'] . ',
                    "' . $player['name'] . '",
                    "' . $vehicle_data['class'] . '",
                    ' . $vehicle_data['level'] . ',
                    "' . $vehicle_data['nation'] . '",
                    "' . $vehicle_data['name'] . '",
                    "' . $vehicle_data['localized_name'] . '",
                    ' . '0' . ')';
           }
    }

}
InsertPlayers($bulk_players);
InsertVehicles($bulk_vehicles);
$updatetime = time();
session_start();
$_SESSION['clan_update'] = $updatetime;
session_write_close();
QueryMySQL("UPDATE clan_data SET last_update = ".$updatetime);
?>