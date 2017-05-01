<head>

<script type="text/javascript" src="//wow.zamimg.com/widgets/power.js"></script>
<script>var wowhead_tooltips = { "colorlinks": true, "iconizelinks": true, "renamelinks": true }</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style type="text/css">
    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    /* Modal Content/Box */
    .modal-content {
        background-color: #fefefe;
        margin: 15% auto; /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 80%; /* Could be more or less, depending on screen size */
    }

    /* The Close Button */
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>
</head>

<script type="text/javascript">
    $(function() {
        $("#update").click( function() {
            $.ajax({
                type: "GET",
                url: "update.php"
            });
            alert("Database updated.");
            // $().load("update.php", function(data){
            //     alert("Database updated.");
            // });
        });
    });

</script>

<body>

    <div id="main" style="width:100%; display:inline-block; text-align:center;">

        <div id="update">
            <button>Update Database</button>
        </div>

        <div>
            <!-- Trigger/Open The Modal -->
            <button id="additem">Add Item</button>

            <!-- The Modal -->
            <div id="myModal" class="modal">

                <!-- Modal content -->
                <div class="modal-content">
                    <span class="close">&times;</span>
                    <p>Some text in the Modal..</p>
                </div>

            </div>

        </div>

        <script type="text/javascript">    
            // Get the modal
            var modal = document.getElementById('myModal');

            // Get the button that opens the modal
            var btn = document.getElementById("additem");

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks on the button, open the modal 
            btn.onclick = function() {
                modal.style.display = "block";
            }

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal.style.display = "none";
            }

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>


<?

// in this area your need to fill all variables

$servername = 'localhost';
$username = 'userDBhere';
$password = 'userDBpasshere';
$schema = 'DBName';
$apiKey = 'yourBlizzardApiKey';
$realmName = 'YourRealmName';
$realmRegion = 'YourRealRegion'

$conn = new mysqli($servername, $username, $password, $schema); $conn->set_charset('utf8');
if ($conn->connect_error) { die('Connection failed: ' . $conn->connect_error); }


// Dynamic DB Queries:
// SELECT from entries database and save as array
// then loop through entries to get prices

$list = array();
$query = "SELECT * from entries";
$result = $conn->query($query);
while($row = $result->fetch_assoc()) {
    $list[] = $row;
};

foreach($list as $item) {
    $id = $item['item'];
    $amount = $item['amount'];
    $query = "SELECT buyout/10000 as MIN, quantity as QTY FROM auctions where item = '$id' ORDER BY buyout ASC LIMIT 1";
    $result = $conn->query($query);

    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $lowest = floatval($row["MIN"]);
            $qty = intval($row["QTY"]);
            $final = $lowest / $qty;
        };
        echo $final;
    } else {
        echo "0 results";
    };
};

// in this part i'm making all SQL queries

$sql_herb1 = "SELECT MIN(buyout)/10000/200 as MIN FROM auctions where item=124105 and quantity=200"; //Starlight Rose cheapest price x200 stack
$result_herb1 = $conn->query($sql_herb1);

if ($result_herb1->num_rows > 0) {
    // output data of each row
    while($row = $result_herb1->fetch_assoc()) {

     $Starlight_Rose=$row["MIN"];

    }
} else {
    echo "0 results";
}

$sql_herb2 = "SELECT MIN(buyout)/10000/200 as MIN FROM auctions where item=124104 and quantity=200"; //Fjarnskaggl cheapest price x200 stack
$result_herb2 = $conn->query($sql_herb2);

if ($result_herb2->num_rows > 0) {
    // output data of each row
    while($row = $result_herb2->fetch_assoc()) {

     $Fjarnskaggl=$row["MIN"];

    }
} else {
    echo "0 results";
}


$sql_herb3 = "SELECT MIN(buyout)/10000/200 as MIN FROM auctions where item=72092"; //Fjarnskaggl cheapest price x200 stack
$result_herb3 = $conn->query($sql_herb3);

if ($result_herb3->num_rows > 0) {
    // output data of each row
    while($row = $result_herb3->fetch_assoc()) {

     $Dreamleaf=$row["MIN"];

    }
} else {
    echo "0 results";
}


$sql_flask1 = "SELECT owner, MIN(buyout)/10000 as MIN FROM auctions where item=127847 and quantity=1"; //Flask of the Wispered Pact cheapest price x1 stack
$result_flask1 = $conn->query($sql_flask1);

if ($result_flask1->num_rows > 0) {
    // output data of each row
    while($row = $result_flask1->fetch_assoc()) {

     $Wispered_Pact=$row["MIN"];
         $Wispered_Last_Seller=$row["owner"];

    }
} else {
    echo "0 results";
}

$sql_flask2 = "SELECT sum(quantity) as SUM FROM auctions where item=127847 and quantity=1"; // Flask of the Wispered Pact show all x1 quantity
$result_flask2 = $conn->query($sql_flask2);

if ($result_flask2->num_rows > 0) {
    // output data of each row
    while($row = $result_flask2->fetch_assoc()) {

     $Wispered_Pact_Q=$row["SUM"];


    }
} else {
    echo "0 results";
}



// Calculates here


$Wisper_Crafting_Cost=round((($Dreamleaf*10)+($Fjarnskaggl*10)+($Starlight_Rose)*7),2)/1.4802; 
$Wisper_Profit=($Wispered_Pact-$Wisper_Crafting_Cost)-($Wispered_Pact-$Wisper_Crafting_Cost)*0.05;


// closing connection to SQL 

$conn->close();
mysqli_close($conn);


// let's show our data


?>


<? echo "Starlight Rose x200 price=".$Starlight_Rose.'</br> Fjarnskaggl x200 price='.$Fjarnskaggl.'</br> Dreamleaf x200 price='.$Dreamleaf.'</br> Flask of the Wispered Pact x1 price='.$Wispered_Pact.'</br> Flask of the Wispered Pact crafting cost='.$Wisper_Crafting_Cost.'</br> Profit='.$Wisper_Profit.'</br> Who sell cheapest one? '.$Wispered_Last_Seller ?>

<html>
<center><h2> Category: Alchemy</h2>
<center>
<style type="text/css">
.tg  {border-collapse:collapse;border-spacing:0;border-color:#ccc;}
.tg td{font-family:Arial, sans-serif;font-size:16px;padding:1px 5px;border-style:none;border-width:1px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#fff;}
.tg th{font-family:Arial, sans-serif;font-size:16px;font-weight:normal;padding:2px 2px;border-style:none;border-width:1px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#f0f0f0;}
.tg .tg-9nbt{font-size:12px;font-family:"Arial Black", Gadget, sans-serif !important;;text-align:center;vertical-align:top;}
.tg .tg-9right{font-size:12px;font-family:"Arial Black", Gadget, sans-serif !important;;text-align:right;vertical-align:top}
.tg .tg-9left{font-size:12px;font-family:"Arial Black", Gadget, sans-serif !important;;text-align:left;vertical-align:top;}
.tg .tg-9center{font-size:12px;font-family:"Arial Black", Gadget, sans-serif !important;;text-align:center;vertical-align:top}

a, u {
    text-decoration: none;
}
</style>
<table class="tg" style="undefined;table-layout: fixed; width: 980px">
<colgroup>
<col style="width: 15px">
<col style="width: 150px">
<col style="width: 31px">
<col style="width: 55px">
<col style="width: 50px">
<col style="width: 60px">
<col style="width: 40px">
<col style="width: 70px">
<col style="width: 120px">
</colgroup>
  <tr>
    <th class="tg-9nbt">!</th>
    <th class="tg-9nbt">Item name:</th>
    <th class="tg-9right">Stack:</th>
    <th class="tg-9right">Low buy:</th>
    <th class="tg-9right">$/1:</th>
<th class="tg-9right">Craft 200:</th>
<th class="tg-9right">Available:</th>
<th class="tg-9center">Profit:</th>
<th class="tg-9left">Seller:</th>
  </tr>Alchemy: Legion Flasks

<tr> <td>

<? if ($Wisper_Profit>10) {if ($Wispered_Last_Seller=="Yoshyoka") echo '<img src="2.gif"'; else echo '<img src="1.gif"';};?></td>
<td><a href="//www.wowhead.com/item=127847" class="q3" rel="gems=23121&amp;ench=2647&amp;pcs=25695:25696:25697"></td>
<td align="right">1</td><td align="right"><? echo round($Wispered_Pact,2)?><img src="gold.png"><td align="right"><? echo round($Wispered_Pact,2) ?><img src="gold.png"><td align="right"><? echo round($Wisper_Crafting_Cost,2). '<img src="gold.png">'?></td>
<td align="right"><? echo $Wispered_Pact_Q?></td>
<td align="right"><? if ($Wisper_Profit>0)  echo '<b><font color=green> +' .round($Wisper_Profit,2).'<img src="gold.png">'; else echo '<b><font color=red>' .round($Wisper_Profit,2).'<img src="gold.png">' ?><td><? if ($Wispered_Last_Seller==Yoshyoka) echo "<font color=green>" . $Wispered_Last_Seller; else echo "<font color=red>".$Wispered_Last_Seller ?></td></td>


</table>

    </div>
</body>