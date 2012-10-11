<?php
session_start();
include 'functions.php';
VehicleTable();
//if(!isset($_SESSION['clan_vehicle'])) {


?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript">
        $(function(){
        
        $( "input:submit, a, button", ".button" ).button();
        $( "#HT10_Switch, #MT10_Switch, #MT9_Switch, #LT8_Switch, #LT7_Switch, #LT6_Switch, #LT5_Switch, #TD10_Switch, #TD9_Switch, #SPG8_Switch, #SPG7_Switch" ).buttonset();
        
        $('#Filter_Vehicles').click(function(){
                        $('#Filter_Vehicles_Dialog').dialog('open');
        });
        
        $('#Filter_Vehicles_Dialog').dialog({
        			resizable: false,
                                autoOpen: false,
                                width: 525,
				buttons: {
                                    "Set": function() {
					$(this).dialog("close");
                                        },
                                    "Cancel": function() {
					$(this).dialog("close");
					}
                                    }
                        }); 
        
        });

        $(document).ready(function() {
            
           $('#vehicles').dataTable( {
                "aoColumnDefs": [
                    { "sWidth": "200px", "aTargets": [ 0 ] }
                ],
                "bJQueryUI": true,
                "bAutoWidth": false,
                "sScrollY": "400px",
                "sScrollX": "100%",
                "bPaginate": false,
                "bLengthChange": false,
                "bScrollCollapse": true,
                "bFilter": false
            } );
/*            
            new FixedColumns( vTable, {
                 "sHeightMatch": "none"
            } );
        
/*            
            function fn_T10_ShowHide() {
            
            var bTable = $('#vehicles').dataTable();

            var bVis = bTable.fnSettings().aoColumns[iCol].bVisible;
            bTable.fnSetColumnVis( iCol, bVis ? false : true );
            }
            

            
            $('#test').click(function(){
                        fn_T10_ShowHide();
                        
            });
*/        } );

    </script>
</head>
<body>
<p><div class=button align=center><button id="Filter_Vehicles">Show/Hide Vehicles</button><button id="test">Upload Replay</button><button>Refresh</button></div></p>

<div id="Filter_Vehicles_Dialog" title="Show/Hide vehicles classes">
    <table border="0">
    <tr align="center"><td>Heavy Tanks</td></tr>
    <tr align="center"><td>10</td></tr>
    <tr align="center">
        <td>
            <div id="HT10_Switch">
                <input type="radio" id="HT10_Show" name="radio" /><label for="HT10_Show">Show</label>
                <input type="radio" id="HT10_Hide" name="radio" /><label for="HT10_Hide">Hide</label>
            </div>
        </td>
    </tr>
    
    <tr align="center"><td>Medium Tanks</td></tr>
    <tr align="center"><td>10</td><td>9</td></tr>
    <tr align="center">
        <td>
            <div id="MT10_Switch">
                <input type="radio" id="MT10_Show" name="radio" /><label for="MT10_Show">Show</label>
                <input type="radio" id="MT10_Hide" name="radio" /><label for="MT10_Hide">Hide</label>
            </div>
        </td>
        <td>
            <div id="MT9_Switch">
                <input type="radio" id="MT9_Show" name="radio" /><label for="MT9_Show">Show</label>
                <input type="radio" id="MT9_Hide" name="radio" /><label for="MT9_Hide">Hide</label>
            </div>
        </td>
    </tr>
    
    <tr align="center"><td>Light Tanks</td></tr>
    <tr align="center"><td>8</td><td>7</td><td>6</td><td>5</td></tr>
    <tr align="center">
        <td>
            <div id="LT8_Switch">
                <input type="radio" id="LT8_Show" name="radio" /><label for="LT8_Show">Show</label>
                <input type="radio" id="LT8_Hide" name="radio" /><label for="LT8_Hide">Hide</label>
            </div>
        </td>
        <td>
            <div id="LT7_Switch">
                <input type="radio" id="LT7_Show" name="radio" /><label for="LT7_Show">Show</label>
                <input type="radio" id="LT7_Hide" name="radio" /><label for="LT7_Hide">Hide</label>
            </div>
        </td>
         <td>
            <div id="LT6_Switch">
                <input type="radio" id="LT6_Show" name="radio" /><label for="LT6_Show">Show</label>
                <input type="radio" id="LT6_Hide" name="radio" /><label for="LT6_Hide">Hide</label>
            </div>
        </td>
        <td>
            <div id="LT5_Switch">
                <input type="radio" id="LT5_Show" name="radio" /><label for="LT5_Show">Show</label>
                <input type="radio" id="LT5_Hide" name="radio" /><label for="LT5_Hide">Hide</label>
            </div>
        </td>
    </tr>

    <tr align="center"><td>Tank Destroyers</td></tr>
    <tr align="center"><td>10</td><td>9</td></tr>
    <tr align="center">
        <td>
            <div id="TD10_Switch">
                <input type="radio" id="TD10_Show" name="radio" /><label for="TD10_Show">Show</label>
                <input type="radio" id="TD10_Hide" name="radio" /><label for="TD10_Hide">Hide</label>
            </div>
        </td>
        <td>
            <div id="TD9_Switch">
                <input type="radio" id="TD9_Show" name="radio" /><label for="TD9_Show">Show</label>
                <input type="radio" id="TD9_Hide" name="radio" /><label for="TD9_Hide">Hide</label>
            </div>
        </td>
    </tr>
    
    <tr align="center"><td>Artillery</td></tr>
    <tr align="center"><td>8</td><td>7</td></tr>
    <tr align="center">
        <td>
            <div id="SPG8_Switch">
                <input type="radio" id="SPG8_Show" name="radio" /><label for="SPG8_Show">Show</label>
                <input type="radio" id="SPG8_Hide" name="radio" /><label for="SPG8_Hide">Hide</label>
            </div>
        </td>
        <td>
            <div id="SPG7_Switch">
                <input type="radio" id="SPG7_Show" name="radio" /><label for="SPG7_Show">Show</label>
                <input type="radio" id="SPG7_Hide" name="radio" /><label for="SPG7_Hide">Hide</label>
            </div>
        </td>
    </tr>
    </table>

</div>
</body>
</html>