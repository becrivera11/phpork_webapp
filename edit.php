<!--
    * PROTOTYPE PORK TRACEABILITY SYSTEM
    * Copyright © 2014 UPLB.

-->
<!DOCTYPE HTML>
<html lang="en"> 
    <?php
        require_once "connect.php";
        
        include "inc/functions.php";
        include "inc/pigdet.php";
        $pig = new pigdet_functions();
        $db = new phpork_functions ();
        
    ?>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Pork Traceability System</title>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap-theme.css">
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/style2.css">
        <script src="js/jquery.js"></script>
    </head>
    <body>

            <div class="page-header col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <img class="img-responsive" src="css/images/new_letterhead.png">
            </div>
        <div class="container">
            <div class="row">
                <?php 
                        $h = $_GET['house'];
                        $l = $_GET['location'];
                        $p = $_GET['pen'];
                        echo "<input type = 'hidden' value= '$h' name = 'house' id = 'houseid'/>";
                        echo "<input type = 'hidden' value= '$l' name = 'loc' id = 'locid'/>";
                        echo "<input type = 'hidden' value= '$p' name = 'pen' id = 'penid'/>";
                    ?>
                <div id="columnchart_values"> 
                    </div> 
                    <div id="linechart_values"> 
                    </div>

                <div class="pig-det col-xs-3 col-sm-3 col-md-3 col-lg-3">
                    <div class="pig-image col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <img src="images/<?php echo $_GET['pig'];?>/1.jpg" style="width:100px; heigh:100px; max-width:100%;" />
                    </div>
                    <span class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><b><?php echo $pig->getLabel($_GET['pig']);?></b></span>
                    <span class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><?php echo $pig->getRFID($_GET['pig']);?></span>
                    <span class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><?php echo $pig->getGender($_GET['pig']);?></span>
                    <span class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><?php echo $pig->getBreed($_GET['pig']);?></span>
                </div>

                <div class="pig-details col-xs-9 col-sm-9 col-md-9 col-lg-9">
                    <form method="post" action="pigDetails.php?pig=<?php echo $_GET['pig']?>&location=<?php echo $_GET['location'];?>&pen=<?php echo $_GET['pen'];?>&house=<?php echo $_GET['house'];?>">
                        <hr class="details-hr" />
                        <span class="pig-det-label col-xs-1 col-sm-1 col-md-1 col-lg-1">FARM: </span> &nbsp; <span class="pig-det-details col-xs-3 col-sm-3 col-md-3 col-lg-3"><input type="text" id="ed_loc" value="<?php echo  $pig->getLocation($_GET['pig']);?>"/></span> &nbsp;
                        <span class="pig-det-label col-xs-7 col-sm-7 col-md-7 col-lg-7" style="text-align:right;"><a href="edit.php?pig=<?php echo $_GET['pig']?>&location=<?php echo $_GET['location'];?>&pen=<?php echo $_GET['pen'];?>&house=<?php echo $_GET['house'];?>">Save details</a></span>

                        <hr class="details-hr" />
                        <span class="pig-det-label col-xs-1 col-sm-1 col-md-1 col-lg-1">BIRTH: </span>
                        <span class="pig-det-details col-xs-3 col-sm-3 col-md-3 col-lg-3"><input type="text" id="ed_birth" value="<?php echo $pig->getBirthDate($_GET['pig']);?>"/></span>
                        <span class="pig-det-label col-xs-1 col-sm-1 col-md-1 col-lg-1">AGE: </span> 
                        <span class="pig-det-details col-xs-3 col-sm-3 col-md-3 col-lg-3"><?php echo $pig->getAge($_GET['pig']);?></span>
                        <span class="pig-det-label">WEIGHT: </span>
                        <span class="pig-det-details"><input type="text" id="ed_weight" value="<?php echo $pig->getWeight($_GET['pig']);?>"/></span>
                        <hr class="details-hr" />
                        <span class="pig-det-label col-xs-1 col-sm-1 col-md-1 col-lg-1">PARENTS  </span>
                        <br />
                        <span class="pig-det-label col-xs-1 col-sm-1 col-md-1 col-lg-1">BOAR: </span><span class="pig-det-details col-xs-3 col-sm-3 col-md-3 col-lg-3"><a href="?pig=<?php echo $pig->getBoar($_GET['pig']);?>&location=<?php echo $_GET['location'];?>&pen=<?php echo $_GET['pen'];?>&house=<?php echo $_GET['house'];?>"><?php echo $pig->getBoar($_GET['pig']);?></a></span>
                        <span class="pig-det-label">SOW: </span><span class="pig-det-details"><a href="?pig=<?php echo $pig->getSow($_GET['pig']);?>"><?php echo $pig->getSow($_GET['pig']); ?></a></span>
                        <hr class="details-hr" />
                    </form>
                    
                </div>

                <div class=" col-xs-12 col-sm-12 col-md-12 col-lg-12">
                </div>
            </div>
            <div class="row">
                <div class="record-container col-xs-3 col-sm-3 col-md-3 col-lg-3">
                    <hr class="details-hr" />
                    <div><a id="movementRecord" class="" href="?pig=<?php echo $_GET['pig'];?>&record=1&location=<?php echo $_GET['location'];?>&pen=<?php echo $_GET['pen'];?>&house=<?php echo $_GET['house'];?>">Movement</a></div>
                    <div><a id="medsRecord" class="" href="?pig=<?php echo $_GET['pig'];?>&record=2&location=<?php echo $_GET['location'];?>&pen=<?php echo $_GET['pen'];?>&house=<?php echo $_GET['house'];?>">Meds</a></div>
                    <div><a id="feedsRecord" class="" href="?pig=<?php echo $_GET['pig'];?>&record=3&location=<?php echo $_GET['location'];?>&pen=<?php echo $_GET['pen'];?>&house=<?php echo $_GET['house'];?>">Feeds</a></div>
                    <div><a id="weightRecord" class="" href="?pig=<?php echo $_GET['pig'];?>&record=4&location=<?php echo $_GET['location'];?>&pen=<?php echo $_GET['pen'];?>&house=<?php echo $_GET['house'];?>">Weight</a></div>
                    <div><a id="back" style="cursor:pointer;">Back</a></div>
                </div>
                <div id="record-details" class="record-details col-xs-9 col-sm-9 col-md-9 col-lg-9">
                    <?php
                        if(!isset($_GET['record']) || $_GET['record']=='1'){
                    ?>
                    <script>
                        $('#movementRecord').addClass("active-nav");
                    </script>
                    <div id="move" class="">
                            
                            <form class ="form-horizontal" method = "post" action = "visualize.php"> 
                                <input type=hidden name=pig value= $_GET['pig'] /> 
                                <div class ="form-group"> 
                                    <div id="again" style="display:none;">

                                    </div>
                                    <label class="control-label col-sm-2 col-md-2 col-lg-2" style="text-align:left;">Currently:</label> 
                                    <label id = "currently" class="control-label col-sm-4 label-default" style = "text-align: center;background-color: white;"> 
                                        <?php 
                                            echo "<label id='h' style='cursor:pointer;' onmouseover='pop('house')' onmouseout='hideprompt()'> House ";echo $pig->getCurrentHouse($_GET['pig']);echo "</label>"; echo "<label id='p' style='cursor:pointer;' onmouseover='pop(pen)' onmouseout='hideprompt()'> Pen ";echo $pig->getCurrentPen($_GET['pig']);echo "</label>";
                                        ?>
                        
                                    </label> 
                                    <div class="col-sm-4 col-md-4 col-lg-4"> 
                                        <?php

                                            $last = $db->getLastMovement($_GET['pig']);
                                            $first = $db->getFirstMovement($_GET['pig']);
                                            $diff  = ($last - $first) + 1;
                                            $db->getWeekDateMvmnt($_GET['pig'], $first);
                                            $db->getPigMvmnt($_GET['pig']);
                                        ?>
                                        <button type="button" onclick="drawVisualization()" title="Click this button to view weight details of selected pig." class="btn btn-default btn-sm" id="btnVisualize">Visualize</button> 
                                    </div> 
                                </div> 
                            </form> 

                            <div id="movement_tbl" style="width:60%; height:150px; overflow:auto;float:left;"> 
                                <table class="table table-striped table-bordered" > 
                                    <thead> 
                                        <tr> 
                                            <th>Date</th> 
                                            <th>Time</th> 
                                            <th>Location</th> 
                                        </tr> 
                                    </thead> 
                                    <tbody id = "data">
                                        <?php
                                            $pig->ddl_locations_edit($_GET['pig']);
                                        ?>
                       
                                    </tbody>
                                </table> 
                            </div>
                            <div id="pig_tbl" style="width:35%; height:150px; overflow:auto; float:right; top:0;"> 
                                <table class="table table-striped table-bordered" > 
                                    <thead> 
                                        <tr> 
                                            <th>Pig ID</th> 
                                            <th>Info</th> 
                                        </tr> 
                                    </thead> 
                                    <tbody id = "data">
                                        <?php
                                            $pig->ddl_pigpen($_GET['pig'],$_GET['pen'],$_GET['house'],$_GET['location'],$_GET['pen']);
                                        ?>
                       
                                    </tbody>
                                </table> 
                            </div>
                                
                        </div>
                    <?php
                        }else if($_GET['record']=='2'){
                    ?>
                    <script>
                        $('#medsRecord').addClass("active-nav");
                    </script>
                    <div id="meds" class="tab-pane"> 
                        <div class ="form-group"> 
                            <label class="control-label col-sm-3 col-md-3">Last medication given:</label> 
                            <label id = "last_med" class="control-label col-sm-4 label-default" style = "text-align: center;background-color: white;"> 
                                <?php 
                                    $lastmed = $pig->getLastMed($_GET['pig']);
                                    $last = split("-", "$lastmed");
                                    echo "Name: ".$last[0]."<br>";
                                    echo "Type: ".$last[1];
                                ?>
                
                            </label> 
                            <div id="meds_tbl" style="width:70%; height:150px; overflow:auto;"> 
                                <table class="table table-striped table-bordered" > 
                                    <thead> 
                                        <tr> 
                                            <th>Medication Name</th> 
                                            <th>Medication Type</th> 
                                        </tr> 
                                    </thead> 
                                    <tbody id = "data">
                                        <?php
                                            $pig->ddl_medRecord($_GET['pig']);
                                        ?>
                       
                                    </tbody>
                                </table> 
                            </div>
                        </div>
                        </div>
                    <?php
                        }else if($_GET['record']=='3'){
                    ?>
                    <script>
                        $('#feedsRecord').addClass("active-nav");
                    </script>
                    <div id="feeds" class="tab-pane"> 
                           <label class="control-label col-sm-3 col-md-3">Last feed type:</label> 
                            <label id = "last_feed" class="control-label col-sm-4 label-default" style = "text-align: center;background-color: white;"> 
                                <?php 
                                    $lastfeed = $pig->getLastFeed($_GET['pig']);
                                    $last = split("-", "$lastfeed");
                                    echo "Feed name: ".$last[0]."<br>";
                                    echo "Feed type: ".$last[1];
                                ?>
                
                            </label> 
                            <div id="feeds_tbl" style="width:70%; height:150px; overflow:auto;"> 
                                <table class="table table-striped table-bordered" > 
                                    <thead> 
                                        <tr> 
                                            <th>Feed Name</th> 
                                            <th>Feed Type</th> 
                                            <th>Production Date</th> 
                                        </tr> 
                                    </thead> 
                                    <tbody id = "data">
                                        <?php
                                            $pig->ddl_feedRecord($_GET['pig']);
                                        ?>
                       
                                    </tbody>
                                </table> 
                            </div>
                        </div>
                    <?php
                        }else if($_GET['record']=='4'){
                            
                                    $last = $db->getLastWeight ( $_GET['pig']);
                                    $first = $db->getFirstWeight ($_GET['pig']);
                                    $diff = ($last - $first) + 1;
                                    $db->getWeekDateWeight ( $_GET['pig'], $first );
                                    $db->getPigWeight ($_GET['pig']);
                                    
                    ?>
                    <script>
                        $('#weightRecord').addClass("active-nav");
                        drawBasic();
                    </script>
                    <?php
                        }
                    ?>


                </div>
                
            </div>
            

            <div class="page-footer col-xs-12 col-sm-12 col-md-12 col-lg-12">
                Prototype Pork Traceability System <br> Copyright &copy; 2014 - <?php echo date("Y");?> UPLB  <br>
                funded by PCAARRD
            </div>
            
            
        </div>
        <script src="js/jquery-2.1.4.js" type="text/javascript"></script>
        <script src="js/jquery-latest.js" type="text/javascript"></script>
        <script src="js/jquery.min.js" type="text/javascript"></script>
        <script src="js/jquery.js"></script>
        <script src="js/javascript.js"></script>
        <script src="js/jquery.min-1.js"></script>
        <script type="text/javascript" src="js/jsapi.js"></script>
        <script type="text/javascript">

            $(document).ready(function () {
              //your code here
                
            });
        </script>
         <script type="text/javascript"> 
        google.load('visualization', '1', {
            packages: ['corechart', 'bar']
        }); 
        google.setOnLoadCallback(drawBasic); 
        $( document ).ready(function() {
            $("#columnchart_values").click(function(){
                $("#columnchart_values").hide(); 
            }); 
            $(".closeButton").click(function(){
                $("#columnchart_values").hide(); 
            }); 
        }); 
        function drawBasic() {
            var dts = $("#dts").val().split("%%%"); 
            var weeks = $("#wks").val().split("%%%"); 
            var ds = $("#ds").val().split("%%%"); 
            var weight = $("#wts").val().split("%%%"); 
            var i=0; 
            var initArray = new Array("Week","Weight"); 
            var graphData = new Array(initArray); 
            for(i=0;i<dts.length;i++){
                var graphD = new Array(ds[i],parseFloat(weight[i])); 
                graphData.push(graphD); 
            } 
            console.log(graphData); 
            var data = google.visualization.arrayToDataTable(graphData,false); 
            var view = new google.visualization.DataView(data); 
            var options = {
                title: "Weight Record", 
                width: 400, 
                height: 200, 
                bar: {
                    groupWidth: "95%"
                }, 
                legend: { 
                    position: "none" 
                }, 
            }; 
            var chart = new google.visualization.ColumnChart(document.getElementById("record-details2")); 
            //$("#columnchart_values").show(); 
            chart.draw(view, options); 
            $("#columnchart_values div").css("z-index","-1"); 
            $("#columnchart_values").css("opacity","0.9 "); 
            $("#columnchart_values").css("height","64.5%"); 
            //$("#columnchart_values" ).append( "<p style='cursor:pointer;color:#b44230;font-weight:bold;' onclick='hide()' class='closeButton'>Close</p>" ); 
        } 
        function hide() {
            $("#columnchart_values").hide(); 
            $(".pig_det").css("opacity","1"); 
        } 
        function drawVisualization() {
            var xaxis = $("#dsMvmnt").val().split("%%%"); 
            var housepen = $("#housepen").val().split("%%%"); 
            var i=0; 
            var graphData = new Array(); 
            var dataTable = new google.visualization.DataTable(); 
            dataTable.addColumn('number', 'Week'); 
            dataTable.addColumn('number', 'Location'); 
            dataTable.addColumn({type: 'string', role: 'tooltip'}); 
            var ylength = xaxis.length; 
            var n = (xaxis[ylength-1] - xaxis[0])+1; 
            var stat = 0; 
            var loc = 0; 
            var flag_counter = 0; 
            if(housepen[loc]==""){
                alert("There are no movements yet."); 
            }else{
                for(i=1;i<=n;i++){
                    if(i==1){
                        if(housepen[loc].indexOf("Q")>-1){
                            stat--; 
                        }else{
                            stat++; 
                            flag_counter++; 
                        } 
                        var graphD = new Array(i,parseInt(stat),housepen[loc]); 
                    }else if(i==xaxis[flag_counter]){
                        if(housepen[loc].indexOf("Q")>-1){
                            stat--; 
                        }else{
                            stat++; 
                            flag_counter++; 
                        } 
                        loc++; 
                        var graphD = new Array(i,parseInt(stat),housepen[loc]); 
                    }else{
                        var graphD = new Array(i,parseInt(stat),housepen[loc]); 
                    } 
                    graphData.push(graphD); 
                } 
                dataTable.addRows(graphData); 
                console.log(graphData); 
                var options = {
                    hAxis: {
                        title: 'Week'
                    }, 
                    vAxis: {
                        title: 'Location'
                    }, 
                    chartArea: {
                        backgroundColor: {
                            stroke: '#4322c0', 
                            strokeWidth: 3 
                        } 
                    } 
                }; 
                var chart = new google.visualization.LineChart(document.getElementById("columnchart_values"));
                document.getElementById("columnchart_values").style.display = "block"; 
                chart.draw(dataTable, options); 
                $("#columnchart_values div").css("z-index","-1"); 
                $("#columnchart_values").css("opacity","0.9"); 
                $( "#columnchart_values" ).append( "<p style='margin-top:-30px;cursor:pointer;color:#b44230;font-weight:bold;' onclick='hide()' class='closeButton'>CLOSE</p>" ); 
            } 
        } 
    </script>
    <script type="text/javascript">

            $(document).ready(function () {
              //your code here
                $('#h').on("click",function() {
                    var location =$("#locid").val();
                    window.location = "rf11.php?location="+location;
                });
                $('#p').on("click",function() {
                    var location =$("#locid").val();
                    var house = $("#houseid").val();
                    window.location = "pen.php?location="+location+"&houseno="+house;
                });
                $('#previous').on("click",function() {
                    var location = $("#locid").val();
                    window.location = "rf11.php?location="+location;
                });
                $('#back').on("click",function() {
                    var location =$("#locid").val();
                    var house = $("#houseid").val();
                    var pen = $("#penid").val();
                    window.location = "pig.php?location="+location+"&houseno="+house+"&penno="+pen;
                });
                
            });
        </script>
        <script>
            function pop(sel){
                var div = document.getElementById('again');

               if(sel==house){
                     div.style.display ="block";
                    div.style.position ="absolute";
                    div.innerHTML = "Click here to select new house.";  
                
               }else if(sel==pen){
                     div.style.display ="block";
                    div.style.position ="absolute";
                    div.innerHTML = "Click here to select new house.";  
               }
                   
            }
            function hideprompt(){
                document.getElementById('again').style.display = 'none';
            }
        </script>
    </body>

    
</html>