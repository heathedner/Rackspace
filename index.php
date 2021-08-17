<?php
$servername = "localhost";
$username = "root";
$password = 'root$plinzedous0n';
$db = "dixie";

try {
$conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
die("Could not connect to the database $dbname :" . $e->getMessage());
}

$query = 'SELECT * FROM rack WHERE rack_name = "mdf"';
$stmt = $conn->prepare($query);
$exec = $stmt->execute();
$result = $stmt->fetchAll();
?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Rackspace</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/custom.css">
</head>

<body>      
<div class="racks">
<?php 
foreach ($result as $row){ ?>
    <div class="rackContainer">
        <h3 class="rackTitle"><span style="font-size: 14px"><?php echo $row['school_id']?></span> DMS - <?php echo $row['rack_name']?></h3>
        <div class="shelf">
            <div class="device blank">
                <img id="u1" src="assets/<?php echo $row['u1']?>" width="100%">
            </div>
            <div class="buttons">
                <input type="submit" name='u1swap' value='u1swap' class="button" />
                <span onclick="deviceNotes(1)" class="button"><img src="assets/note.png"></span>
            </div>
        </div>
        <div class="shelf">
            <div class="device blank">
                <img id="u2" src="assets/<?php echo $row['u2']?>" width="100%">
            </div>
            <div class="buttons">
                <span onclick="swapDevice(2)" class="button"><img src="assets/swap.png"></span>
                <span onclick="deviceNotes(2)" class="button"><img src="assets/note.png"></span>
            </div>
        </div>
        <div class="shelf">
            <div class="device blank">
                <img id="u3" src="assets/<?php echo $row['u3']?>" width="100%">
            </div>
            <div class="buttons">
                <span onclick="swapDevice(3)" class="button"><img src="assets/swap.png"></span>
                <span onclick="deviceNotes(3)" class="button"><img src="assets/note.png"></span>
            </div>
        </div>
        <div class="shelf">
            <div class="device blank">
                <img id="u4" src="assets/<?php echo $row['u4']?>" width="100%">
            </div>
            <div class="buttons">
                <span onclick="swapDevice(4)" class="button"><img src="assets/swap.png"></span>
                <span onclick="deviceNotes(4)" class="button"><img src="assets/note.png"></span>
            </div>
        </div>
        <div class="shelf">
            <div class="device blank">
                <img id="u5" src="assets/<?php echo $row['u5']?>" width="100%">
            </div>
            <div class="buttons">
                <span onclick="swapDevice(5)" class="button"><img src="assets/swap.png"></span>
                <span onclick="deviceNotes(5)" class="button"><img src="assets/note.png"></span>
            </div>
        </div>
    </div>
    <hr style="margin: 20px 0 20px 0; width: 100%;">
<?php } ?>
</div>

<div class="closetInfo">
    <div class="timestamp">
        <h2>Timestamps</h2>
        <table id="timeTable"></table>
    </div>
    <hr>
</div>



<!-- Device Swap Modal -->
<div id="deviceSwapModal" class="modal">
  <div class="modal-content">
    <span onclick="closeSwapModal()" class="close">&times;</span>
    <h4>General</h4>
        <input type="submit" name='btnRemove' value='Remove Unit'/>
        <button onclick="setUnit('assets/fiber.png')">Fiber Tray</button>
        <button onclick="setUnit('assets/pc.png')">Computer Shelf</button>

    <h4>Patch Panels</h4>
    <button onclick="setUnit('assets/patchpanels/24patch.png')">24 Port Panel </button>
    <button onclick="setUnit('assets/patchpanels/24patch_staggered.png')">24 Port Panel Staggered</button>
    <button onclick="setUnit('assets/patchpanels/48patch.png')">48 Port Panel 1U</button>
    <button onclick="setUnit('assets/patchpanels/48patch_2U.png')">48 Port Panel 2U</button>
    <button onclick="setUnit('assets/patchpanels/32patch_empty.png')">32 Empty Port Panel</button>

    <h4>Cisco</h4>
    <button onclick="setUnit('assets/cisco/3550.png')">Catalyst 3550</button>
    <button onclick="setUnit('assets/cisco/2800.png')">2000 Series Router</button>

    <h4>Juniper</h4>
    <button onclick="setUnit('assets/juniper/mx150.png')">MX 150</button>

  </div>

</div> 

<!-- Device Notes Modal -->
<div id="deviceNotesModal" class="modal">
    <div class="modal-content">
        <span onclick="closeNotesModal()" class="close">&times;</span>
        <h3>Device Notes</h3>
        <textarea id="deviceNote" name="deviceNote" rows="10">  </textarea>
        <br>
        <button onclick="updateNote()">Update</button>
    </div>
</div> 


            
</body>
<script>
var currentUnit = "u0";

//Temp Data

var notesArray = ["Unit 1 Notes","Unit 2 Notes", "Unit 3 Notes","Unit 4 Notes","Unit 5 Notes"];
var fakeTimestamps = ["1/2/3@2:30,Igniting Pilot Lights","4/5/6@1:10,Mowed the Grass","7/8/9@1:50,Constructed Additional Pylons"]
const date = new Date();
var timestamp = date.getDay() + "/" + date.getMonth() + "/" + date.getYear() + "@" + date.getHours()+":"+date.getMinutes()+", no comment <textarea></textarea>";
fakeTimestamps.unshift(timestamp);
getTimestamps('~');

function getTimestamps(note){
    for (var i = 0; i < fakeTimestamps.length; i++){
        var timeStampSplit = fakeTimestamps[i].split(',');
        document.getElementById("timeTable").innerHTML += '<tr><td>'+timeStampSplit[0]+'</td><td>'+timeStampSplit[1]+'</td></tr>';
    }
}

function swapDevice(unit){
    
  currentUnit = "u"+unit;
  document.getElementById("deviceSwapModal").style.display = "block";
}

function deviceNotes(unit){
  currentUnit = unit;
  document.getElementById("deviceNotesModal").style.display = "block";
  document.getElementById("deviceNote").value = notesArray[currentUnit-1];
}


function closeSwapModal(){
    document.getElementById("deviceSwapModal").style.display = "none";
}
function closeNotesModal(){
    document.getElementById("deviceNotesModal").style.display = "none";
}

function updateNote(){
    console.log(notesArray[currentUnit])
    notesArray[currentUnit-1] = document.getElementById("deviceNote").value;
}

window.onclick = function(event) {
  if (event.target == document.getElementById("deviceSwapModal")) {
    deviceSwapModal.style.display = "none";
  }
  if (event.target == document.getElementById("deviceNotesModal")) {
    deviceNotesModal.style.display = "none";
  }
}

$('.button').click(function() {
  $.ajax({
    type: "POST",
    url: "index.php",
    data: { name: "John" }
  }).done(function( msg ) {
    alert( "Data Saved: " + msg );
  });
});

</script>

<?php
    function abc($name){
        // Your code here
    }
?>

<?php
    if(isset($_POST['u1swap'])) {
        echo 'u1';
    }


if(isset($_POST['btnRemove'])) {
                $sql = "UPDATE rack SET $device='placeholder.png' WHERE rack_name='mdf'";
            
                // Prepare statement
                $stmt = $conn->prepare($sql);
                
                // execute the query
                $stmt->execute();
                
                // echo a message to say the UPDATE succeeded
        $conn = null;
    }
?>
</html>