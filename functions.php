<?php

// ***** Request data from multiple external sources ***** //

function GetClanData($clan_id, $data_type = 'members', $url = 'worldoftanks.eu') {

    $tempfile = fsockopen($url, 80, $errno, $errstr, 30);

    if (!$tempfile) {
        echo "$errstr ($errno)<br />\n";
    } else {

        $request = "GET /uc/clans/" . $clan_id . "/" . $data_type ."/?type=table HTTP/1.0\r\n";
        $request.= "X-Requested-With: XMLHttpRequest\r\n";
        $request.= "Host: " . $url . "\r\n";
        $request.= "Connection: Keep-Alive\r\n";
        $request.= "\r\n";

        fwrite($tempfile, $request);

        while (!feof($tempfile)) {
            $clan = fgets($tempfile);
        }

        fclose($tempfile);
    }
    $clan_data = (json_decode($clan, true));
    
    return $clan_data['request_data']['items'];
}

function GetPlayerData($player_id, $url = 'api.worldoftanks.eu') {
    $tempfile = fopen("http://" . $url . "/uc/accounts/" . $player_id . "/api/1.5/?source_token=Intellect_Soft-WoT_Mobile-unofficial_stats", "r");

    $player = stream_get_contents($tempfile);
    
    fclose($tempfile);

    $player_data = (json_decode($player, true));

    return $player_data['data'];
    
}

function GetPlayerHistory($player_name) {

    $tempfile = fopen("http://td82.ru/site/wotka_json?nickname="."$player_name"."&server=EU","r");

    $player_history = stream_get_contents($tempfile);
    
    fclose($tempfile);

    return $player_history;
    
}

// ***** Request data from MySQL database ***** //

function SQLClanMembers($clan_id){
    $players = '';
    $request = 'SELECT player_id, player_name, player_role, member_date, last_update, clan_history FROM player_data where clan_id = '. $clan_id;
    
    $received = QueryMySQL($request);
    while($row = mysql_fetch_array($received,MYSQL_ASSOC)) {
        $players[] = $row;
    } 
    return $players;
}

function SQLClanVehicles($clan_id) {

    $request_player = 'SELECT player_name, player_id FROM player_data WHERE clan_id = '. $clan_id;
    
    $player_list = QueryMySQL($request_player);
    
    while($row = mysql_fetch_array($player_list,MYSQL_ASSOC)){
	$player[] = $row;
    }
    
    if(!empty($player)) {
        $player_vehicles = array();

        foreach ($player as $player_data){
            $request_vehicles = 'SELECT name, locked_on FROM vehicle_data WHERE player_id =' . $player_data['player_id'] . ' ORDER BY vehicle_tier DESC';          
            $vehicle_list = QueryMySQL($request_vehicles);
            $selection = array();
            
            while($row_vehicle_list = mysql_fetch_array($vehicle_list,MYSQL_ASSOC)){
                $selection = array_merge($selection, array($row_vehicle_list['name'] => $row_vehicle_list['locked_on']));
            }

            if (!empty($selection)) {
                $player_vehicles = array_merge($player_vehicles, array($player_data['player_name'] => $selection));
                unset($selection);
            }
        }
    return $player_vehicles;
    }
}    

// ***** Build tables ***** //

function VehicleRow($player, $vehicles) {
    
    $row = '<tr id="player_name"><td>'.$player.'</td>';
    $empty = '<td></td>';
    
// Add Tier 10 Heavy Tanks
    $heavytank = array('Maus','E-100','IS-7','IS-4','T110','F10_AMX_50B');
//  $heavytank = array('Maus','E-100','IS-7','IS-4','T110','F10_AMX_50B','UKHT10');    
    foreach ($heavytank as $name){
        if (array_key_exists($name,$vehicles)) $row .= LockTime($name, $vehicles, 'heavyTank', 10); else $row .= $empty;
    }
    
        
// Add Tier 10 Medium Tanks
    $mediumtank = array('E50_Ausf_M','T62A','M48A1','Bat_Chatillon25t');
//  $mediumtank = array('E50_Ausf_M','T62A','M48A1','Bat_Chatillon25t','UKMT10');    
    foreach ($mediumtank as $name){
        if (array_key_exists($name,$vehicles)) $row .= LockTime($name, $vehicles, 'mediumTank', 10); else $row .= $empty;
    }

// Add Tier 9 Medium Tanks
    $mediumtank = array('E-50','T-54','M46_Patton','Lorraine40t');
//  $mediumtank = array('E-50','T-54','M46_Patton','Lorraine40t','UKMT9');    
    foreach ($mediumtank as $name){
        if (array_key_exists($name,$vehicles)) $row .= LockTime($name, $vehicles, 'mediumTank', 9); else $row .= $empty;
    }

// Add Tier 8 Light Tanks    
    $lighttank = array('AMX_13_90');
    foreach ($lighttank as $name){
        if (array_key_exists($name,$vehicles)) $row .= LockTime($name, $vehicles, 'lightTank', 8); else $row .= $empty;
    }
        
// Add Tier 7 Light Tanks            
    $lighttank = array('AMX_13_75');
    foreach ($lighttank as $name){
        if (array_key_exists($name,$vehicles)) $row .= LockTime($name, $vehicles, 'lightTank', 7); else $row .= $empty;
    }
    
// Add Tier 6 Light Tanks            
    $lighttank = array('AMX_12t');
    foreach ($lighttank as $name){
        if (array_key_exists($name,$vehicles)) $row .= LockTime($name, $vehicles, 'lightTank', 6); else $row .= $empty;
    }    
        
// Add Tier 5 Light Tanks            
    $lighttank = array('VK2801','T_50_2','M24_Chaffee','ELC_AMX');
//  $lighttank = array('VK2801','T_50_2','M24_Chaffee','ELC_AMX','UKLT5');    
    foreach ($lighttank as $name){
        if (array_key_exists($name,$vehicles)) $row .= LockTime($name, $vehicles, 'lightTank', 5); else $row .= $empty;
    }
   
// Add Tier 10 Tank Destroyers
    $tankdestroyer = array('JagdPz_E100','Obj268','T110E3','T110E4','AMX_50Fosh_155');
//  $tankdestroyer = array('JagdPz_E100','Obj268','T110E3','T110E4','AMX_50Fosh_155','UKTD10');    
    foreach ($tankdestroyer as $name){
        if (array_key_exists($name,$vehicles)) $row .= LockTime($name, $vehicles, 'AT-SPG', 10); else $row .= $empty;
    }
    
// Add Tier 9 Tank Destroyers
    $tankdestroyer = array('JagdTiger','Obj_704','T95','T30','AMX50_Foch');
//  $tankdestroyer = array('JagdTiger','Obj_704','T95','T30','AMX50_Foch','UKTD9');    
    foreach ($tankdestroyer as $name){
        if (array_key_exists($name,$vehicles)) $row .= LockTime($name, $vehicles, 'AT-SPG', 9); else $row .= $empty;
    }

// Add Tier 8 Artillery
    $artillery = array('G_E','Obj_261','T92','Bat_Chatillon155');
//  $artillery = array('G_E','Obj_261','T92','Bat_Chatillon155','UKSPG8');    
    foreach ($artillery as $name){
        if (array_key_exists($name,$vehicles)) $row .= LockTime($name, $vehicles, $vehicles, 'SPG', 8); else $row .= $empty;
    }

// Add Tier 7 Artillery
    $artillery = array('G_Tiger','Obj_212','M40M43','Lorraine155_51');
//  $artillery = array('G_Tiger','Obj_212','M40M43','Lorraine155_51','UKSPG7');    
    foreach ($artillery as $name){
        if (array_key_exists($name,$vehicles)) $row .= LockTime($name, $vehicles, $vehicles, 'SPG', 7); else $row .= $empty;
    }
    
    $row .= '</tr>';
    
    return $row;
}


function LockTime($name, $vehicle, $class, $level){
    
    $locked_time = QueryMySQL('SELECT lock_time FROM tool_config WHERE vehicle_tier = "' . $level . '" AND vehicle_class = "' . $class . '"');
    $time = mysql_fetch_array($locked_time,MYSQL_ASSOC);
    
    foreach ($vehicle as $vehicle_name => $locked_on){
        if ($name == $vehicle_name){
            if (($locked_on == 0) or (($locked_on + $time['lock_time']) < time() ))   {
                return '<td align="center">.</td>'; 
            } else {
                    $locked = ($locked_on + $time['lock_time'])-time();
                    $days = floor(($locked)/86400);
                    $hours = floor(($locked-($days*86400))/3600);
                    $min = floor(($locked-(($days*86400)+($hours*3600)))/60);
                    return '<td align="center">' . $days . 'd ' . $hours . 'h ' . $min . 'm</td>';
            }
        }
    }
}

function VehicleTable(){
    
    $table = '';
    $players = SQLClanVehicles($_SESSION['clan_id']);
    
    if(!empty($players)){
        foreach ($players as $player_name => $vehicle_list) {
            $table .= VehicleRow($player_name, $vehicle_list);
        }
    }        

echo '<table id="vehicles" border="0">' .
     '<thead>' .
     '<tr align="center">' .
        '<th>Player Name: </th>' .
        // Tier 10 Heavy Tanks
        '<th title="Maus"><img src="images/germany-maus.png"></th>' . 
        '<th title="E-100"><img src="images/germany-e-100.png"></th>' . 
        '<th title="IS-7"><img src="images/ussr-is-7.png"></th>' . 
        '<th title="IS-4"><img src="images/ussr-is-4.png"></th>' . 
        '<th title="T110E5"><img src="images/usa-t110.png"></th>' . 
        '<th title="AMX 50B"><img src="images/france-f10_amx_50b.png"></th>' . 
//        '<th>' . $gb . '</th>' .
        // Tier 10 Medium Tanks
        '<th title="E-50 Ausf. M"><img src="images/germany-e50_ausf_m.png"></th>' . 
        '<th title="T-62-A"><img src="images/ussr-t62a.png"></th>' . 
        '<th title="M48A1"><img src="images/usa-m48a1.png"></th>' . 
        '<th title="Bat Chatillon 25 t"><img src="images/france-bat_chatillon25t.png"></th>' . 
//        '<th>' . $gb . '</th>' .
        // Tier 9 Medium Tanks
        '<th title="E-50"><img src="images/germany-e-50.png"></th>' . 
        '<th title="T-54"><img src="images/ussr-t-54.png"></th>' . 
        '<th title="M46 Patton"><img src="images/usa-m46_patton.png"></th>' . 
        '<th title="Lorraine 40 t"><img src="images/france-lorraine40t.png"></th>' . 
//        '<th>' . $gb . '</th>' .
        // Tier 8 Light Tanks
        '<th title="AMX 13 90"><img src="images/france-amx_13_90.png"></th>' .
        // Tier 7 Light Tanks
        '<th title="AMX 13 75"><img src="images/france-amx_13_75.png"></th>' .
        // Tier 6 Light Tanks
        '<th title="AMX 12t"><img src="images/france-elc_amx.png"></th>' .
        // Tier 5 Light Tanks
        '<th title="VK 2801"><img src="images/germany-vk2801.png"></th>' . 
        '<th title="T-50-2"><img src="images/ussr-t_50_2.png"></th>' . 
        '<th title="M24 Chaffee"><img src="images/usa-m24_chaffee.png"></th>' . 
        '<th title="ECL AMX"><img src="images/france-elc_amx.png"></th>' . 
//        '<th>' . $gb . '</th>' .
        // Tier 10 Tank Destroyer
        '<th title="JagdPz. E-100"><img src="images/germany-jagdpz_e100.png"></th>' .
        '<th title="Object 268"><img src="images/ussr-object268.png"></th>' .
        '<th title="T110E3"><img src="images/usa-t110e3.png"></th>' .
        '<th title="T110E4"><img src="images/usa-t110e4.png"></th>' .
        '<th title="AMX-50 Foch (155)"><img src="images/france-amx_50fosh_155.png"></th>' .
//        '<th>' . $gb . '</th>' .
        // Tier 9 Tank Destroyer
        '<th title="JagdTiger"><img src="images/germany-jagdtiger.png"></th>' .
        '<th title="Object 704"><img src="images/ussr-object_704.png"></th>' .
        '<th title="T95"><img src="images/usa-t95.png"></th>' .
        '<th title="T30"><img src="images/usa-t30.png"></th>' .
        '<th><img src="images/france-amx50_foch.png"></th>' .
//        '<th>' . $gb . '</th>' .
        // Tier 8 Artillery
        '<th title="GW Typ E"><img src="images/germany-g_e.png"></th>' .
        '<th title="Object 261"><img src="images/ussr-object_261.png"></th>' .
        '<th title="T92"><img src="images/usa-t92.png"></th>' .
        '<th title="Bat Chatillon 155"><img src="images/france-bat_chatillon155.png"></th>' .
//        '<th>' . $gb . '</th>' .
        // Tier 7 Artillery
        '<th title="GW Tiger"><img src="images/germany-g_tiger.png"></th>' .
        '<th title="Object 212"><img src="images/ussr-object_212.png"></th>' .
        '<th title="M40/M43"><img src="images/usa-m40m43.png"></th>' .
        '<th title="Lorraine 155 51"><img src="images/france-lorraine155_51.png"></th>' .
//        '<th>' . $gb . '</th>' .
     '</tr>' .
     '</thead>';

echo '<tbody>' .
     $table .
     '</tbody>';

echo '<tfoot>' .
     '<tr>' .
        '<th>' .'Class :'. '</th>' .
        '<th colspan = 6>' . 'Heavy Tanks' . '</th>' .
        '<th colspan = 8>' . 'Medium Tanks' . '</th>' . 
        '<th colspan = 7>' . 'Light Tanks' . '</th>' . 
        '<th colspan = 10>' . 'Tank Destroyers' . '</th>' . 
        '<th colspan = 8>' . 'Artillery' . '</th>' . 
     '</tr>' .
     '</tfoot>' .
     '</table>';

echo '<div align=right>Last update on : '.date('d-M-Y H:i',($_SESSION['clan_update'])).'</div>';
}

function MemberRow($player){

//    $row = '';
    $total_battles = '';
    $last_battle = '';
    $won = '';
    $frags = '';
    $survived = '';
    $battles = array();
    $roles = array('leader' => 'Commander',
                'vice_leader' => 'Deputy Commander',
                'diplomat' => 'Diplomat',
                'treasurer' => 'Treasurer',
                'recruiter' => 'Recruiter',
                'commander' => 'Field Commander',
                'private' => 'Soldier',
                'recruit' => 'Recruit'
                );
        
    if (((time()-$player['last_update'])/86400) > 1) {
            $left_on = date('d-M-Y',($player['last_update']));
    } else {
        $left_on = '';
    }
        
    $proper_role = $roles[$player['player_role']];
    $battle_log = QueryMySQL('SELECT match_time, alive, frags, match_result FROM battle_log WHERE player_name = "'. $player['player_name'].'" ORDER BY match_time DESC');
    while($row = mysql_fetch_array($battle_log,MYSQL_ASSOC)) {
        $battles[] = $row;
    }
        if (count($battles) > 0) {
            $total_battles = count($battles);
            $last_battle = date('d-m-Y H:i',$battles['0']['match_time']);
            foreach($battles as $battle => $battle_data) {
                $won = $won + $battle_data['match_result'];
                $frags = $frags + $battle_data['frags'];
                $survived = $survived + $battle_data['alive'];
            }
            unset($battles);
        }

    $line = '<tr>' . 
                '<td>' . $player['player_id'] . '</td>' .
                '<td id="player_name">' . $player['player_name'] . '</td>' . 
                '<td>' . $proper_role . '</td>' . 
                '<td>' . '' . '</td>' .    
                '<td>' . '' . '</td>' .
                '<td>' . '' . '</td>' .
                '<td align = "center">' . $total_battles . '</td>' .
                '<td align = "center">' . $won . '</td>' .
                '<td align = "center">' . $frags . '</td>' .
                '<td align = "center">' . $survived . '</td>' .
                '<td align = "center">' . $last_battle . '</td>' .
                '<td></td>' .
                '<td align = "center">' . floor(($player['last_update'] - $player['member_date'])/86400) . '</td>' .
                '<td align = "center">' . $left_on . '</td>' .
                '<td align = "center">' . date('d-m-Y H:i',($player['last_update'])) . '</td>' .
            '</tr>';

    return $line;
}

function MemberTable($tableid) {
    
    $table = '';
    $clan_member = SQLClanMembers($_SESSION['clan_id']);
    
    if (!empty($clan_member)) {
        foreach ($clan_member as $player) {
            $table .= MemberRow($player);
        }
    }

echo '<table id="' . $tableid . '">';
echo '<thead>';
echo '<tr>' .
        '<th colspan = "3">' . 'Player Info' . '</th>' .
        '<th colspan = "3">' . 'blah blah blah' . '</th>' .
        '<th colspan = "5">' . 'Battle Performance' . '</th>' .
        '<th colspan = "4">' . 'Membership Info' . '</th>' .
     '</tr>';
echo '<tr>' .
        '<th>' . 'Player ID' . '</th>' .
        '<th>' . 'Name' . '</th>' . 
        '<th>' . 'Position' . '</th>' . 
        '<th>' . 'blah blah' . '</th>' . 
        '<th>' . 'blah blah' . '</th>' . 
        '<th>' . 'blah blah' . '</th>' . 
        '<th>' . 'Total' . '</th>' .
        '<th>' . 'Won' . '</th>' .
        '<th>' . 'Frags' . '</th>' .
        '<th>' . 'Died' . '</th>' .
        '<th>' . 'Last' . '</th>' .
        '<th>' . 'Away till' . '</th>' .
        '<th>' . 'Days in clan' . '</th>' . 
        '<th>' . 'Left since' . '</th>' . 
        '<th>' . 'Last update on' . '</th>' . 
     '</tr>';
echo '</thead>';
echo '<tbody>';
echo $table;
echo '</tbody>';
echo '</table>';
echo '<div align=right>Last update on : '.date('d-M-Y H:i',($_SESSION['clan_update'])).'</div>';
echo '<p><div align=center class=button><a href="#" id="showhidemembers">Show / Hide columns</a><button>Hide blah</button><button>Refresh</button></div></p>';    
}

// ***** Insert data into MySQL database ***** //

function InsertClan($clan_id, $clan_tag, $clan_name, $clan_logo, $owner) {
   
   $last_update = time();
   $request = "INSERT INTO clan_data
                  (clan_id, clan_tag, clan_name, clan_logo, last_update, owner) 
                VALUES
                    ('$clan_id','$clan_tag', '$clan_name', '$clan_logo', '$last_update', '$owner')
                ON DUPLICATE KEY 
                    update last_update = '$last_update'";
   
   QueryMySQL($request);
}

function InsertPlayer($clan_id, $clan_tag, $player_id, $player_name, $player_role, $member_date, $clan_history) {
    
    $last_update = time();
    $request = "INSERT INTO player_data
                    (clan_id, clan_tag, player_id, player_name, player_role, member_date, clan_history, last_update) 
                VALUES
                    ('$clan_id','$clan_tag', '$player_id', '$player_name', '$player_role', '$member_date', '$clan_history', '$last_update')
                ON DUPLICATE KEY 
                    update last_update = '$last_update', clan_history = '$clan_history'";
    
    QueryMySQL($request);
}

function InsertPlayers($bulk_data) {
    
    $request = "INSERT INTO player_data
                    (last_update, clan_id, clan_tag, player_id, player_name, player_role, member_date) 
                VALUES " . implode(',', $bulk_data) . "
				ON DUPLICATE KEY 
                    UPDATE last_update = VALUES(last_update)";
    
    QueryMySQL($request);
}

function InsertVehicle($player_id, $player_name, $vehicle_class, $vehicle_tier, $vehicle_nation, $name, $localized_name, $locked_on) {
    
    $last_update = time();
    $request =  "INSERT INTO vehicle_data
                    (player_id, player_name, vehicle_class, vehicle_tier, nation, name, localized_name, locked_on, last_update)
                VALUES
                    ('$player_id', '$player_name', '$vehicle_class', '$vehicle_tier', '$vehicle_nation', '$name', '$localized_name', '$locked_on', '$last_update')
                ON DUPLICATE KEY 
                    update last_update = '$last_update'";

    QueryMySQL($request);
}


function InsertVehicles($bulk_data) {
    
    $request =  "INSERT INTO vehicle_data
                    (last_update, player_id, player_name, vehicle_class, vehicle_tier, nation, name, localized_name, locked_on)
                VALUES " . implode(',', $bulk_data) ."
				ON DUPLICATE KEY 
                    UPDATE last_update = VALUES(last_update)";

    QueryMySQL($request);
}

function InsertBattleLog($match_type, $player_name, $clan_tag, $team, $match_time, $name, $alive, $frags, $match_result, $map_location, $match_location) {
    
    $last_update = time();
    $request =  "INSERT INTO battle_log
                    (match_type, player_name, clan_tag, team, match_time, name, alive, frags, match_result, map_location, match_location, last_update)
                VALUES
                    ('$match_type', '$player_name', '$clan_tag', '$team', '$match_time', '$name', '$alive', '$frags', '$match_result', '$map_location', '$match_location', '$last_update')
                ON DUPLICATE KEY 
                    update last_update = '$last_update'";

    QueryMySQL($request);
}

function InsertReplay($name, $signature, $type, $time, $map, $location, $blocks, $start_length, $start_data, $end_length, $end_data, $replay_file) {

    $last_update = time();
    $request = "INSERT INTO replay_data 
                    (filename, signature, match_type, match_time, match_map, match_location, match_blocks, match_start_length, match_start_data, match_end_length, match_end_data, replay_file, last_update)
                VALUES
                    ('$name', '$signature', '$type', '$time', '$map', '$location',  '$blocks', '$start_length', '$start_data', '$end_length', '$end_data', '$replay_file', '$last_update')
                ON DUPLICATE KEY 
                    update last_update = '$last_update'";
    
    QueryMySQL($request);
    
}

function ShowReplay(){
    $team = 'SELECT team1,team2,match_location from replay_data where match_time = 1337368457';
    $data = QueryMySQL($team);

    $team1='';
    $team2='';
    $map = mysql_result($data,0,2);
    foreach ((json_decode(mysql_result($data,0,0),true)) as $player => $vehicle ) {
        if (current($vehicle) > 0) $alive = 'Destroyed'; else $alive ='Alive';
        $team1 .=  '<tr>'.'<td>'.$player.'</td>'.'<td>'.key($vehicle).'</td>'.'<td>'.$alive.'</td>'.'</tr>';
    }

    foreach ((json_decode(mysql_result($data,0,1),true)) as $player => $vehicle ) {
        if (current($vehicle) > 0) $alive = 'Destroyed'; else $alive ='Alive';
        $team2 .=  '<tr>'.'<td>'.$player.'</td>'.'<td>'.key($vehicle).'</td>'.'<td>'.$alive.'</td>'.'</tr>';
    }
    
}

// ***** Generic Functions ***** //

function QueryMySQL($query) {
    
    $connected = mysql_connect("localhost", "cwinfo", "cwinfo");  // <--- Insert credentials for SQL Connection here !
	// $connected = mysql_connect("SQL-Server", "SQL-Username", "SQL-Password");

    if (!$connected) die;

    mysql_select_db("clanwar_data", $connected);
    
    $result = mysql_query($query) or die(mysql_error());
    
    mysql_close($connected);
    
    return $result;
}
/* Example of SQL connection with proper error management <-- still needs to be implementd


   function showerror(  )
   {
      die("Error " . mysql_errno(  ) . " : " . mysql_error(  ));
   }
   function connect()
   // (1) Open the database connection
   if (!($connection = @ mysql_connect("localhost",
                                       "fred","shhh")))
      die("Could not connect");
   // NOTE : 'winestore' is deliberately misspelt to
   // cause an error
   if (!(mysql_select_db("winestor", $connection)))
      showerror(  );
   // (2) Run the query on the winestore through the
   //  connection
   if (!($result = @ mysql_query ("SELECT * FROM wine",
                                   $connection)))
      showerror(  );
   // (3) While there are still rows in the result set,
   // fetch the current row into the array $row
   while ($row = mysql_fetch_row($result))
   {
      // (4) Print out each element in $row, that is,
     // print the values of the attributes
      for ($i=0; $i<mysql_num_fields($result); $i++)
         echo $row[$i] . " ";
      // Print a carriage return to neaten the output
      echo "\n";
   }
   // (5) Close the database connection
   if (!mysql_close($connection))
      showerror(  );
*/
?>