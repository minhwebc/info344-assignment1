<html>
  <head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.css">
    <link rel="stylesheet" type="text/css" href="page.css">
    <script type="text/javascript" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.js"></script>
    <script
	  src="https://code.jquery.com/jquery-3.1.1.min.js"
	  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
	  crossorigin="anonymous"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			// Variable to hold request
			var request;

			// Bind to the submit event of our form
			$("#searchForm").submit(function(event){

			    // Prevent default posting of form - put here to work in case of errors
			    event.preventDefault();

			    // Abort any pending request
			    if (request) {
			        request.abort();
			    }

			    // setup some local variables
			    var $form = $(this);

			    // Let's select and cache all the fields
			    var $inputs = $form.find("input, select, button, textarea");

			    // Serialize the data in the form
			    var serializedData = $form.serialize();

			    // Let's disable the inputs for the duration of the Ajax request.
			    // Note: we disable elements AFTER the form data has been serialized.
			    // Disabled form elements will not be serialized.
			    $inputs.prop("disabled", true);
			    // Fire off the request to /form.php
			    request = $.ajax({
			        url: "/form.php",
			        type: "post",
			        data: serializedData
			    });

			    // Callback handler that will be called on success
			    request.done(function (response, textStatus, jqXHR){
			        var players = JSON.parse(response); //translate the data into json that can be processed by javascript
			        $("#result").empty();
			        if(players[0] != "player's name is blank"){
				        players.forEach(function(player){
				        	var url = 'https://nba-players.herokuapp.com/players/'+player.Lname.toLowerCase()+'/'+player.Fname.toLowerCase();
				        	var row = document.createElement("div");
				        	row.setAttribute("class", "row");
				    		var div = document.createElement("div");
				    		div.setAttribute("class", "row");
				    		var imageDiv = document.createElement("div");
				    		imageDiv.setAttribute("class", "col s4");
				    		var image = document.createElement("img");
				    		image.src = url;
				    		image.alt = "player picture not found";
				    		imageDiv.appendChild(image);
				    		div.appendChild(imageDiv);
				    		var contentDiv = document.createElement("div");
				    		contentDiv.setAttribute("class", "col s7 content")
				    		var name = document.createElement("h2");
				    		name.innerHTML = player.Name;
				    		contentDiv.appendChild(name);
				    		var team = document.createElement("h4");
				    		team.innerHTML = "Team: "+player.Team;
				    		contentDiv.appendChild(team);
				    		contentDiv.appendChild(createParagraphElement("<b>GP:</b> <br><span class='score'>"+player.GP+"</span>"));
				    		contentDiv.appendChild(createParagraphElement("<b>FGM:</b> <br><span class='score'>"+player.FG_M+"</span>"));
				    		contentDiv.appendChild(createParagraphElement("<b>PPG:</b> <br><span class='score'>"+player.PPG+"</span>"));
				    		contentDiv.appendChild(createParagraphElement("<b>FTM:</b> <br><span class='score'>"+player.FTM+"</span>"));
				    		contentDiv.appendChild(createParagraphElement("<b>PF:</b> <br><span class='score'>"+player.PF+"</span>"));
				    		div.appendChild(contentDiv);
				    		row.appendChild(div);
				    		document.getElementById('result').appendChild(row);
				        });
				    }else{
				    	document.getElementById('result').appendChild(createParagraphElement("player's name can't be blank"));
				    }

			    });

			    //create a paragraph element with the innerHTML being the phrase passing in
			    function createParagraphElement(phrase){
			    	var element = document.createElement("p");
			    	element.innerHTML = phrase;
			    	return element;
			    }

			    // Callback handler that will be called on failure
			    request.fail(function (jqXHR, textStatus, errorThrown){
			        // Log the error to the console
			        console.error(
			            "The following error occurred: "+
			            textStatus, errorThrown
			        );
			    });

			    // Callback handler that will be called regardless
			    // if the request failed or succeeded
			    request.always(function () {
			        // Reenable the inputs
			        $inputs.prop("disabled", false);
			    });

			});
		});
	</script>
	</head>
	<body>
		<nav>
			<div class="nav-wrapper container">
			  <a href="#" class="brand-logo">Player database</a>
			  <ul id="nav-mobile" class="right hide-on-med-and-down">
			    <li><a href="">PHP</a></li>
			    <li><a href="">HTML/CSS</a></li>
			    <li><a href="">JavaScript</a></li>
			  </ul>
			</div>
		</nav>
		<div class="container">
			<br>
			<form id="searchForm" action="form.php" method="POST">
				<div class="form-group">
					<label for="InputName">Search your player</label>
					<input type="text" name="player_name" placeholder="Enter player name here...">
				</div>
			  <button type="submit" class="btn btn-default">Submit</button>
			</form>
			<div id="result">
				<!-- found players go in here -->
			</div>
		</div>
	</body>
</html>
