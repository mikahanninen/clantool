<?php session_start(); 
if(!isset($_SESSION['member_current'])){
$_SESSION['member_current'] = 0;
$_SESSION['member_count'] = 0;
$_SESSION['player_name'] = 'N/A';
$_SESSION['vehicle_current'] = 0;
$_SESSION['vehicle_count'] = 0;
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script type="text/javascript">
		$(function(){

                    $( "input:submit, a, button", ".button" ).button();
                    $( "button", ".input" ).click(function() { return false; });
                    
                    $('#retrieve_clan_link').click(function(){
                        $('#retrieve_clan').dialog('open');
			$("#succes").hide();
                        $(".ui-dialog-buttonpane button:contains('Update')").attr("disabled", false).removeClass("ui-state-disabled");
                        return false;
			});
        
			$('#retrieve_clan').dialog({
        			resizable: false,
                                autoOpen: false,
                                width: 600,
				buttons: {
                                    "Update": function() {
                                        $(".ui-dialog-buttonpane button:contains('Update')").attr("disabled", true).addClass("ui-state-disabled");
                                        auto_status = setInterval(function() {
                                            $('#update_status').load('config.php #update_status');
                                            }, 1000);
                                        $.ajax({
                                        type: "GET",
                                        url: "update.php",
                                        error: function(){
                                            $("#error").show();
                                            clearInterval(auto_status);
                                        },
                                        success: function() {
                                            $('#update_status').load('config.php #update_status');
                                            $("#succes").show();
//                                            $(".ui-dialog-buttonpane button:contains('Update')").attr("disabled", true).addClass("ui-state-disabled");
                                            clearInterval(auto_status);
                                        }
                                        });
                                    },
                                    "Close": function() {
					$(this).dialog("close");
					}
                                    }
			}); 
		});
                        
                    $("#set_clan_link").click(function() {
                        $("#retrieve_clan").dialog('open');
                    });

                        //Tabs
                        function init() {
                        $("#configtabs").tabs();
        
                        function createTab_Tank_Freeze() {
                        $("#configtabs").tabs("add","tank_freeze.php", "Lock Time " + '<span class="ui-icon ui-icon-minus"></span>', 0);
                        }
                        
                        function createTab_Replay_Manager() {
                        $("#configtabs").tabs("add","replay_manager.php", "Replay Manager" + '<span class="ui-icon ui-icon-play"></span>',2);
                        }

                        createTab_Tank_Freeze();

                        $("#configtabs").css("display","block");
                        }                        
                        
                        $(document).ready(init);
                        
		</script>
</head>
<body>
    <!-- Tabs -->
    <div id="configtabs" style="display:none;">
        <ul>
        <li><a href="#config_tool">Settings <span class="ui-icon ui-icon-gear"></span></a></li>
        <li><a href="#replay_manager">Replay Manager <span class="ui-icon ui-icon-play"></span></a></li>
        <li><a href="#about_tool">About <span class="ui-icon ui-icon-info"></span></a></li>
        </ul>                        
        <div id="config_tool" class="button">
            Clan Id         : <?php echo $_SESSION['clan_id'] ?><br>
            Clan Tag        : <?php echo $_SESSION['clan_tag'] ?><br>
            Clan Name       : <?php echo $_SESSION['clan_name'] ?><br>
            Last update on  : <?php echo date('d-M-Y H:i',($_SESSION['clan_update'])) ?><br>

            <p><a href="#" id="retrieve_clan_link" class="ui-state-default ui-corner-all">Update Clan<span class="ui-icon ui-icon-transferthick-e-w"></span></a></p>
        </div>
        
            <div id="retrieve_clan" title="Update Clan">
                <div id="update_status">
                    This will retrieve all players and all vehicles data and update the MySQL database!<br>
                    Please be patient, this can take a while.<br>
                    <p>Member : <?php echo $_SESSION['member_current']; ?> of <?php echo $_SESSION['member_count']; ?><br>
                    Name : <?php echo $_SESSION['player_name']; ?><br>
                    </p>
                </div>
                
                <div id ="error" style="display:none;">
                    <div class="ui-widget">
                    <div class="ui-state-error ui-corner-all" style="padding: 0 .7em;">
                    <p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>
                    <strong>Alert:</strong> Error in updating clan.</p>
                    </div>
                    </div>
                </div>
                
                <div id ="succes" style="display:none;">
                    <div class="ui-widget">
                    <div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;">
                    <p><span class="ui-icon ui-icon-check" style="float: left; margin-right: .3em;"></span>
                    Clan has been succesfully updated</p>
                    </div>
                    </div>
                </div>
                
            </div>
        <div id="about_tool">
        </div>
        <div id="replay_manager">

        </div>
    </div>
</body>
</html>


