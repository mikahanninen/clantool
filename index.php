<?php
session_start();

include 'functions.php';

$request = 'SELECT * from clan_data where owner = true';

$received = QueryMySQL($request);
$row = mysql_fetch_assoc($received);
    if ($row['owner'] == 1) {
        $_SESSION['clan_id'] = $row['clan_id'];
        $_SESSION['clan_tag'] = $row['clan_tag'];
        $_SESSION['clan_name'] = $row['clan_name'];
        $_SESSION['clan_update'] = $row['last_update'];
        } else {
            $_SESSION['clan_id'] = '';
            $_SESSION['clan_tag'] = '';
            $_SESSION['clan_tag'] = '';
            $_SESSION['clan_update'] = '';
            }
?>

<!DOCTYPE html>
<html>
    <head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Clan War Battle Management</title>
	<link rel="shortcut icon" href="favicon.ico">
        <link rel="stylesheet" type="text/css" href="css/dark-hive/jquery-ui-1.8.21.custom.css" />
        <link rel="stylesheet" type="text/css" href="css/default.css" />
        <link rel="stylesheet" type="text/css" href="css/uploadify.css" />

        <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui-1.8.24.custom.min.js"></script>
        <script type="text/javascript" src="js/jquery.dataTables-1.9.4.js"></script>
        <script type="text/javascript" src="js/FixedColumns.min.js"></script>
        <script type="text/javascript" src="js/ColVis.min.js"></script>
        <script type="text/javascript" src="js/jquery.uploadify-3.1.min.js"></script>
	<script type="text/javascript">

            $(function(){

                $("input:submit, a, button", ".button" ).button();

                $('#upload_replay_link').click(function(){
                        $('#upload').dialog('open');
			return false;
			});
                        
                $(function() {
                    $('#file_upload').uploadify({
                        'buttonText' : 'Upload Replay',
                        'removeCompleted' : false,
                        'fileObjName' : 'file',
                        'swf'      : 'uploadify.swf',
                        'uploader' : 'upload.php'
                    // Put your options here
                    });
                });
/*
		$('#upload').dialog({
			autoOpen: false,
			width: 1200,
			buttons: {
                            "Upload": function() {
                                $('#upload_file').submit();
                            },
                            "Close": function() {
				$(this).dialog("close");
                            }
                    }
		});
*/                
            });
            
            function init() {
                
                $("#indextabs").tabs();                        

                function createTab_Members() {
                $("#indextabs").tabs("add","members.php", "Members " + '<span class="ui-icon ui-icon-person"></span>');
                }

                function createTab_Statistics() {
                $("#indextabs").tabs("add","blablah", "Statistics " + '<span class="ui-icon ui-icon-unlocked"></span>');
                }

                function createTab_Vehicles() {
                $("#indextabs").tabs("add","vehicles.php", "Vehicles " + '<span class="ui-icon ui-icon-unlocked"></span>');
                }

                function createTab_Configuration() {
                $("#indextabs").tabs("add","config.php", "Configuration "  + '<span class="ui-icon ui-icon-wrench"></span>');
                }

                createTab_Members();
                createTab_Vehicles();
//                createTab_Statistics();
                createTab_Configuration();

                $("#indextabs").css("display","block");
            }
            
            $(document).ready(init);
                        
        </script>
</head>
<body>
<div class="content">
<div class="header"><h2>World of Tanks Clan War Battle Management</h2></div>
 <div id="indextabs" style="display:none">
 <ul>
 <li><a href="#home">Home <span class="ui-icon ui-icon-home"></span></a></li>
 </ul> 
     <div id="home" class="button">
     <div id="upload" >  
     <input type="file" name="file_upload" id="file_upload" />     
     </div>
    </div>

 </div>
</div>
<div class="push"></div>
<div class="footer"></div>

</body>
</html>


