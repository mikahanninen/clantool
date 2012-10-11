<?php
session_start();

include 'functions.php';

//if(!isset($_SESSION['clan_member'])) {
MemberTable('clan_members');
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript">
        $(function() {
            $( "input:submit, a, button", ".button" ).button();
            $( "#set_away" ).datepicker();
        
        });
        
        function fnShowHide( iCol ) {
        /* Get the DataTables object again - this is not a recreation, just a get of the object */
            var oTable = $('#clan_members').dataTable();
     
            var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
            oTable.fnSetColumnVis( iCol, bVis ? false : true );
        }
        
        $(document).ready(function(){

	$('#clan_members').dataTable( {
                "aoColumnDefs": [
                    { "sWidth": "200px", "aTargets": [ 1 ] },
                    { "bSearchable": false, "bVisible": false, "aTargets": [ 0 ] },
                    //{ "bSearchable": false, "bVisible": false, "aTargets": [ 13 ] },
                    { "bSearchable": false, "bVisible": false, "aTargets": [ 14 ] }
                    ],
                "bJQueryUI": true,
                "bLengthChange": false,
                "iDisplayLength": 20,
                "aaSorting": [[ 1, "asc" ]],
                "bAutoWidth": true,
                "sScrollX": "100%",
                "sScrollXInner": "100%"
                /*"aoColumns": [{ "sWidth": "80px" },
                                { "sWidth": "250px" },
                                { "sWidth": "150px" },
                                { "sWidth": "100px" },
                                { "sWidth": "100px" },
                                { "sWidth": "200px" },
                                { "sWidth": "100px" },
                                { "sWidth": "200px" },
                                { "sWidth": "200px" }
                             ]*/
            });	
        });
    </script>
</head>    
</html>
