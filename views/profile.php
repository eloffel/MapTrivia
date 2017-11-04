<div class='main'>
    <div id='incontent'>
        
        <table width="80%" border = 1 BORDERCOLOR=WHITE> <!-- NICE BORDER-->
            <tr>
                <th rowspan="2"><center><h1><?php print(strtoupper($data["full_user"]))?></h1></center></th> <!-- full username (with title)-->
                <th><center><h3>Name: <?php print($data["full_name"])?></h3></center></th> <!-- full name-->
            </tr>
            <tr>
                <td><center><h3>Email: <?php print($data["email"])?></h3></center></td> <!--email-->
            </tr>
        </table>

        <br><h3>Achievements (<?php print($data["total_ach"])?>/16)</h3>
        
        <table width="80%" border = 1 BORDERCOLOR=WHITE> <!-- unlocked achievements - white, locked - gray, number of achievements defines the html lines that will be displayed -->
            <tr valign="top">
                <td width="512">
                <center>
                    <b><h4>Places</h4></b>
                    <?php
                        $pu1 = "<div id=unlocked>Add your first place to the map</div>";
                        $pu2 = "<div id=unlocked>Add 5 new places to the map</div>";
                        $pu3 = "<div id=unlocked>Add 15 new places to the map</div>";
                        $pu4 = "<div id=unlocked>Add 50 new places to the map</div>";
                        $pu5 = "<div id=unlocked>Add 100 new places to the map</div>";
                        $pl1 = "<div id=locked>Add your first place to the map</div>";
                        $pl2 = "<div id=locked>Add 5 new places to the map</div>";
                        $pl3 = "<div id=locked>Add 15 new places to the map</div>";
                        $pl4 = "<div id=locked>Add 50 new places to the map</div>";
                        $pl5 = "<div id=locked>Add 100 new places to the map</div>";
                        if($data["place_ach"] == 0)
                        {
                            print($pl1.$pl2.$pl3.$pl4.$pl5);
                        }
                        if($data["place_ach"] == 1)
                        {
                            print($pu1.$pl2.$pl3.$pl4.$pl5);
                        }
                        if($data["place_ach"] == 2)
                        {
                            print($pu1.$pu2.$pl3.$pl4.$pl5);
                        }
                        if($data["place_ach"] == 3)
                        {
                            print($pu1.$pu2.$pu3.$pl4.$pl5);
                        }
                        if($data["place_ach"] == 4)
                        {
                            print($pu1.$pu2.$pu3.$pu4.$pl5);
                        }
                        if($data["place_ach"] == 5)
                        {
                            print($pu1.$pu2.$pu3.$pu4.$pu5);
                        }
                    ?>
                </center>
                </td>
                <td width="512" height="180">
                <center>
                    <b><h4>Trivia</h4></b>
                    <?php
                        $tu1 = "<div id=unlocked>Add your first trivia to the map</div>";
                        $tu2 = "<div id=unlocked>Add 5 new trivia to the map</div>";
                        $tu3 = "<div id=unlocked>Add 15 new trivia to the map</div>";
                        $tu4 = "<div id=unlocked>Add 50 new trivia to the map</div>";
                        $tu5 = "<div id=unlocked>Add 100 new trivia to the map</div>";
                        $tu6 = "<div id=unlocked>Add 250 new trivia to the map</div>";
                        $tl1 = "<div id=locked>Add your first trivia to the map</div>";
                        $tl2 = "<div id=locked>Add 5 new trivia to the map</div>";
                        $tl3 = "<div id=locked>Add 15 new trivia to the map</div>";
                        $tl4 = "<div id=locked>Add 50 new trivia to the map</div>";
                        $tl5 = "<div id=locked>Add 100 new trivia to the map</div>";
                        $tl6 = "<div id=locked>Add 250 new trivia to the map</div>";
                        if($data["trivia_ach"] == 0)
                        {
                            print($tl1.$tl2.$tl3.$tl4.$tl5.$tl6);
                        }
                        if($data["trivia_ach"] == 1)
                        {
                            print($tu1.$tl2.$tl3.$tl4.$tl5.$tl6);
                        }
                        if($data["trivia_ach"] == 2)
                        {
                            print($tu1.$tu2.$tl3.$tl4.$tl5.$tl6);
                        }
                        if($data["trivia_ach"] == 3)
                        {
                            print($tu1.$tu2.$tu3.$tl4.$tl5.$tl6);
                        }
                        if($data["trivia_ach"] == 4)
                        {
                            print($tu1.$tu2.$tu3.$tu4.$tl5.$tl6);
                        }
                        if($data["trivia_ach"] == 5)
                        {
                            print($tu1.$tu2.$tu3.$tu4.$tu5.$tl6);
                        }
                        if($data["trivia_ach"] == 6)
                        {
                            print($tu1.$tu2.$tu3.$tu4.$tu5.$tu6);
                        }
                        ?>
                </center>
                </td>
                <td width="512">
                <center>
                    <b><h4>Upvotes</h4></b>
                    <?php
                        $uu1 = "<div id=unlocked>Receive 5 upvotes in your trivia</div>";
                        $uu2 = "<div id=unlocked>Receive 20 upvotes in your trivia</div>";
                        $uu3 = "<div id=unlocked>Receive 50 upvotes in your trivia</div>";
                        $uu4 = "<div id=unlocked>Receive 150 upvotes in your trivia</div>";
                        $uu5 = "<div id=unlocked>Receive 300 upvotes in your trivia</div>";
                        $ul1 = "<div id=locked>Receive 5 upvotes in your trivia</div>";
                        $ul2 = "<div id=locked>Receive 20 upvotes in your trivia</div>";
                        $ul3 = "<div id=locked>Receive 50 upvotes in your trivia</div>";
                        $ul4 = "<div id=locked>Receive 150 upvotes in your trivia</div>";
                        $ul5 = "<div id=locked>Receive 300 upvotes in your trivia</div>";
                        if($data["upvote_ach"] == 0)
                        {
                            print($ul1.$ul2.$ul3.$ul4.$ul5);
                        }
                        if($data["upvote_ach"] == 1)
                        {
                            print($uu1.$ul2.$ul3.$ul4.$ul5);
                        }
                        if($data["upvote_ach"] == 2)
                        {
                            print($uu1.$uu2.$ul3.$ul4.$ul5);
                        }
                        if($data["upvote_ach"] == 3)
                        {
                            print($uu1.$uu2.$uu3.$ul4.$ul5);
                        }
                        if($data["upvote_ach"] == 4)
                        {
                            print($uu1.$uu2.$uu3.$uu4.$ul5);
                        }
                        if($data["upvote_ach"] == 5)
                        {
                            print($uu1.$uu2.$uu3.$uu4.$uu5);
                        }
                        ?>
                </center>
                </td>
            </tr>
        </table>
        
        <br>
        
        <table width="80%">
            <tr valign="top" colspan="3">
                <td width="768" height="75">
                    <br><h3>My Places (<?php print($data["places"])?>)</h3>
                </td>
                <td width="768">
                    <br><h3>My Trivia (<?php print($data["trivia"])?>)</h3>
                </td>
            </tr>
        </table>
        
        <table width="80%" border = 1 BORDERCOLOR=WHITE>
            <tr valign="top">
                <td width="768">
                    <center><br> <!-- prints all the places created by the user, their coordinates (for Google Search) and the number of trivia (how they are sorted)-->
                        <?php foreach ($places as $place){ 
                            print("<b>".$place["title"]."</b><br>");
                            print("Coordinates: ".$place["latitude"].", ".$place["longitude"]."<br>");
                            print("Number of Trivia: ".$place["number_facts"]."<br><br>");
                        }?>
                    </center>
                </td>
                <td width="768">
                    <center><br> <!-- prints all the trivia written by the user, their places and the number of upvotes (how they are sorted)-->
                        <?php foreach ($trivias as $trivia){
                            print("<b>".$trivia["title"]."</b><br>");
                            print("Trivia: ".htmlspecialchars_decode($trivia["text"])."<br>");
                            print("Number of upvotes: ".$trivia["rate"]."<br><br>");
                        }?>
                    </center>
                </td>
            </tr>
        </table>
        <br>
    </div>
</div>