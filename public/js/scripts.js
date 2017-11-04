
/* global google */
/* global _ */
/**
 * scripts.js
 *
 * Computer Science 50
 * FINAL PROJECT
 *
 * Global JavaScript.
 */

var map;

var markers = [];

var info;

// function that calls the origin of the map through a .php file that sends a request to a MySql table
function callOrigin(){ 
    $.getJSON("origin.php")
    .done(function(data, textStatus, jqXHR) {
        var LatLng =[];
        LatLng["lat"] = data[0]["initialLat"];
        LatLng["lng"] = data[0]["initialLong"];
        initAutocomplete(LatLng);
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
        // log error to browser's console
        console.log(errorThrown.toString());
    });
}

// "initial" function
function initAutocomplete(LatLng) {
    
    var styles = [
    {
        featureType: "road",
        elementType: "labels",
        stylers: [
                    { visibility: "off" }
                ]
    }];
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: parseFloat(LatLng["lat"]), lng: parseFloat(LatLng["lng"])}, //initial coordinated defined by callOrigin()
        zoom: 13,
        styles:styles,
        streetViewControl: false
    });
    
    // Create the search box and link it to the UI element.
    var input = document.getElementById('pac-input');
    var searchBox = new google.maps.places.SearchBox(input);
    map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

    // Bias the SearchBox results towards current map's viewport.
    map.addListener('bounds_changed', function() {
        searchBox.setBounds(map.getBounds());
    });
    
    // Listen for the event fired when the user selects a prediction and retrieve
    // more details for that place.
    searchBox.addListener('places_changed', function() {
        var places = searchBox.getPlaces();

        if (places.length == 0) {
            return;
        }

        // Clear out the old markers.
        markers.forEach(function(marker) {
            marker.setMap(null);
        });
        markers = [];

        // For each place, get the icon, name and location.
        var bounds = new google.maps.LatLngBounds();
        places.forEach(function(place) {
        var icon = {
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(25, 25)
        };

        // Create a marker for each place.
        markers.push(new google.maps.Marker({
            map: map,
            icon: icon,
            title: place.name,
            position: place.geometry.location
        }));

        if (place.geometry.viewport) {
            // Only geocodes have viewport.
            bounds.union(place.geometry.viewport);
        }
        else {
            bounds.extend(place.geometry.location);
        }
    });
map.fitBounds(bounds);
});
  
    // event listeners related to the context menu
    google.maps.event.addListener(map, "rightclick",function(event){showContextMenu(event.latLng);});
    google.maps.event.addListener(map, "click",function(event){hideContextMenu();});
    google.maps.event.addListener(map, "dragend", function() {hideContextMenu();});
    google.maps.event.addListener(map, "zoom_changed", function() {hideContextMenu();});
    google.maps.event.addListener(map, "dragstart", function() {hideContextMenu();});
    google.maps.event.addListenerOnce(map, "idle", configure);
}

function configure()
{
    update();
    // update UI after map has been dragged
    google.maps.event.addListener(map, "dragend", function() {
        update();
    });

    // update UI after zoom level changes
    google.maps.event.addListener(map, "zoom_changed", function() {
        update();
    });

    // remove markers whilst dragging
    google.maps.event.addListener(map, "dragstart", function() {
        removeMarkers();
    });
    
        $("#q").focus(function(eventData) {
        hideInfo();
    });
}

function update() 
{
    // get map's bounds
    var bounds = map.getBounds();
    var ne = bounds.getNorthEast();
    var sw = bounds.getSouthWest();

    // get places within bounds (asynchronously)
    var parameters = {
        ne: ne.lat() + "," + ne.lng(),
        q: $("#q").val(),
        sw: sw.lat() + "," + sw.lng()
    };
    $.getJSON("update.php", parameters)
    .done(function(data, textStatus, jqXHR) {
        
        removeMarkers();
        // add new markers to map
        for (var i = 0; i < data.length; i++)
        {
            showMarker(data[i]);
        }
    })
    .fail(function(jqXHR, textStatus, errorThrown) {

        // log error to browser's console
        console.log(errorThrown.toString());
    });
}

//////////////////////// CONTEXT MENU (http://googleapitips.blogspot.com/2010/06/how-to-add-context-menu-to-google-maps.html)

function showContextMenu(currentLatLng) {
    
    var projection;
    var contextmenuDir;
    projection = map.getProjection() ;
    $('.contextmenu').remove();
    contextmenuDir = document.createElement("div");
    contextmenuDir.className  = 'contextmenu';
    contextmenuDir.innerHTML = '<a id="add"><div class="context">Add new Place<\/div><\/a>'
                               + '<a id="set_origin"><div class="context">Set as Origin<\/div><\/a>';

    $(map.getDiv()).append(contextmenuDir);
         
    document.getElementById("add").addEventListener("click", function(){newPlace(currentLatLng);});
    document.getElementById("set_origin").addEventListener("click", function(){setOrigin(currentLatLng);});
    setMenuXY(currentLatLng);
    contextmenuDir.style.visibility = "visible";
}
        
function getCanvasXY(currentLatLng){
    var scale = Math.pow(2, map.getZoom());
    var nw = new google.maps.LatLng(
        map.getBounds().getNorthEast().lat(),
        map.getBounds().getSouthWest().lng()
    );
    var worldCoordinateNW = map.getProjection().fromLatLngToPoint(nw);
    var worldCoordinate = map.getProjection().fromLatLngToPoint(currentLatLng);
    var currentLatLngOffset = new google.maps.Point(
        Math.floor((worldCoordinate.x - worldCoordinateNW.x) * scale),
        Math.floor((worldCoordinate.y - worldCoordinateNW.y) * scale)
    );
    return currentLatLngOffset;
}
   
    function setMenuXY(currentLatLng){
        var mapWidth = $('#map_canvas').width();
        var mapHeight = $('#map_canvas').height();
        var menuWidth = $('.contextmenu').width();
        var menuHeight = $('.contextmenu').height();
        var clickedPosition = getCanvasXY(currentLatLng);
        var x = clickedPosition.x ;
        var y = clickedPosition.y ;

    if((mapWidth - x ) < menuWidth) //if to close to the map border, decrease x position
        x = x - menuWidth;
    if((mapHeight - y ) < menuHeight) //if to close to the map border, decrease y position
        y = y - menuHeight;

    $('.contextmenu').css('left',x  );
    $('.contextmenu').css('top',y );
    }
     
function hideContextMenu()
    {
        $('.contextmenu').remove();
    }
    
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////    

// request from comments.php the position of 15 "places" within the bounds of the map as all as their contents
function showMarker(place)
{
    var id = place.id_place;
    var marker = new google.maps.Marker({
        position: {lat: parseFloat(place.latitude), lng: parseFloat(place.longitude)},
        map: map,
        title: place.title,
        icon: {
            url: 'img/marker.png',
        },
    });
 
    markers.push(marker);
 
    // most important piece of code in this file, it took me a few hours to write it
    google.maps.event.addListener(marker, 'click', function(){
      
    hideInfo();
    
    $.getJSON("comments.php", {id_place: place.id_place, id_user: place.id_user}) // gets the trivia
 
        .done(function(data, textStatus, jqXHR) 
        {    
            // Organize the trivia that will be displayed
            var contentString = '<div id="triviaWindow">'+
                '<h1 id="firstHeading" class="firstHeading">'+place.title+'</h1>'+
                '<h5 id="place_user">Created by '+data[0]+'</h6>'+
                '<div id="triviaContent">';
                
            for (var i = 1; i < data.length; i++)
            {
                contentString += '<div id = "trivia">' + '<div id = "upper_border"><div id = "trivia_user">' + data[i].username + "</div></div>";
                contentString += '<div id = "trivia_text">' + data[i].text + '</div><div id = "trivia_rate">';
                
                if(data[i].rate >= 0)
                {
                    contentString += '<div id = "pos_rate">'; // green
                }
                else
                {
                    contentString += '<div id = "neg_rate">'; // red
                }
                
                //data[i].downvote and data[i].upvote can be either equal "" or equal "disabled", in the second case, they will disable the button if the user has already voted in that option
            
                contentString += data[i].rate+'</div><div id = "buttons">';
                contentString += '<input type="button" onclick=upvote('+data[i].id_comment+') id="upvote" '+ data[i].upvote +' >';
                contentString += '<input type="button" onclick=downvote('+data[i].id_comment+') id="downvote" '+data[i].downvote+' ></div></div>';
                contentString += '</div>';
            }
            if (data.length <= 1)
            {
                contentString += '<div id="no_trivia">There is no trivia about '+place.title+'. You can add yours by clicking on "Add Trivia".</div>';
            }
            contentString += '<div class="form-group">';
            contentString += '<textarea class=form" rows="2" placeholder="Write your trivia" id="new_trivia"></textarea>';
            contentString += '<input type="button" id="add_trivia" class="btn btn-primary" onclick= "addTrivia('+id+')" value="Add Trivia" style="float: right;"></div>';
            contentString += '</div>'+'</div>';
            showInfo(marker,contentString);
        })
 
        .fail(function(jqXHR, textStatus, errorThrown) 
        {
            // log error to browser's console
            console.log(errorThrown.toString());
        });  
    });
    
}

function removeMarkers()
{
    // iterate through markers, deleting one by one
    for (var i = 0; i < markers.length; i++) {
        markers[i].setMap(null);
        markers[i] = null;
    }
    // empty array
    markers.length = 0;
}

// creates a infowindow that shows all the trivia from a place
function showInfo(marker,contentString) 
{
    info = new google.maps.InfoWindow({
        content: contentString,
    });
    // open info window (if not already open)
    info.open(map, marker);
    google.maps.event.addListener(map, 'click', function() {
        hideInfo();
    });
}

function hideInfo()
{
    if (info) {
        info.close();
    }
}

// called by the "Add" option in the context menu, creates a new place by sending data to a .php file
function newPlace(currentLatLng){
    hideContextMenu();
    var name = prompt("Please enter the name of the place");
    if (!(name == '' || name[0] === ' ')) {
        $.post('newplace.php', {lat : currentLatLng.lat, lng : currentLatLng.lng, name : name});
    }
    else{
        window.alert("Invalid name for a place");
    }
}

// called by the "Set Origin" option in the context menu, stores the coordinates of the point in the map in a sql table
function setOrigin(currentLatLng){ 
    hideContextMenu();
    $.post('origin.php', {lat : currentLatLng.lat, lng : currentLatLng.lng});
}

// called by the "Add Trivia" button in the infowindow, sends to a .php file the information about the new trivia
function addTrivia(id_place){

    var trivia = document.getElementById("new_trivia").value;
    if (!(trivia == '' || trivia[0] === ' ')) {
        $.post('newtrivia.php', {place : id_place, trivia : trivia});
        update();
    }
    else{
        window.alert("Invalid trivia");
    }
}

// called by the "Thumbs up" png in each trivia, also sends voting data to a .php file
function upvote(id_comment)
{
    $.post('vote.php', {id_comment : id_comment, vote : "1"});
    update();
}

// called by the "Thumbs down" png in each trivia, also sends voting data to a .php file
function downvote(id_comment)
{
    $.post('vote.php', {id_comment : id_comment, vote : "-1"});
    update();
}