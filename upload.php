<?php

include 'functions.php';

$replay_file = file_get_contents($_FILES["file"]["tmp_name"]);

$part1 = 'LSignature/' .
         'LMatch_blocks/' .
         'LMatch_start_length/';
$part2 = 'LMatch_end_length/';

$file_info_part1 = unpack($part1, $replay_file);

$file_info_part2 = unpack($part2, (substr($replay_file, 12 + $file_info_part1['Match_start_length'], 4)));
$file_info = array_merge($file_info_part1, $file_info_part2);

if (($file_info_part1['Match_blocks'] > 1) AND ($file_info_part1['Signature']=288633362)) {

$match_info = json_decode(substr($replay_file, 12, $file_info['Match_start_length']), true);
$match_result = json_decode(substr($replay_file, 12 + $file_info['Match_start_length'] + 4, $file_info['Match_end_length']),true);    

$match_location = $match_info['mapDisplayName'];
$match_map = $match_info['mapName'];
$match_time = $match_result['0']['arenaCreateTime'];
$match_type = $match_result['0']['arenaTypeID'];

foreach (($match_info['vehicles']) as $vehicle_id => $vehicle_player_data){
	if ($match_info['playerName'] == $vehicle_player_data['name']) {
		if ($match_result['0']['isWinner'] == 1) {
			$winner = $vehicle_player_data['team'];
		} elseif ($vehicle_player_data['team'] == 1) { 
        $winner = 2;
		} else {
        $winner = 1;
		}
	}
}

foreach(($match_result['1']) as $players_data => $player_data){
    $vehicle = (explode(":", $player_data['vehicleType']));
    $frags = 0;
    
    if($player_data['team'] == $winner) { 
        $result = 1;
    } else {
        $result = 0;
    }
    
    if($player_data['isAlive'] == 0) {
        $update_lock = 'UPDATE vehicle_data
                        SET locked_on = "' . $match_time . '"
                        WHERE player_name = "' . $player_data['name'] . '" AND name = "' . $vehicle['1'] . '" AND locked_on < "' . $match_time . '"';
    QueryMySQL($update_lock);
    }
    
    foreach(($match_result['2']) as $match_stats => $player_stats) {
        if($players_data == $match_stats) {
            $frags = $player_stats['frags'];
        }
    }
    
    InsertBattleLog($match_type,$player_data['name'],$player_data['clanAbbrev'],$player_data['team'], $match_time, $vehicle['1'], $player_data['isAlive'], $frags , $result, $match_map, $match_location);
}

    InsertReplay($_FILES["file"]["name"],
                $file_info['Signature'],
                $match_type,
                $match_time,
                $match_map,
                $match_location,
                $file_info['Match_blocks'],
                $file_info['Match_start_length'],
                substr($replay_file, 12, $file_info['Match_start_length']),
                $file_info['Match_end_length'],
                substr($replay_file, 12 + $file_info['Match_start_length'] + 4, $file_info['Match_end_length']),
                mysql_real_escape_string($replay_file));

} else {
    
    echo 'This Replay file is not complete, only completed replay files can be uploaded !';
}

?> 