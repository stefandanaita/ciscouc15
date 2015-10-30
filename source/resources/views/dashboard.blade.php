<!DOCTYPE html>
<html>
  <head>
    <title>Internet of Health</title>

    <!-- Lato Google Font -->
    <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="<?php echo asset('css/fa-animated.min.css')?>" type="text/css">
    <link rel="stylesheet" href="<?php echo asset('css/style.css')?>" type="text/css">

    <meta name="author" content="Andreea-Camelia-Simona Bertea">
  	<script src="https://maps.googleapis.com/maps/api/js"></script>

    <script src="http://maps.google.com/maps/api/js?sensor=false"></script>






    <script type="text/javascript">
      function showCurrentLocation(position)
      {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;
        var coords = new google.maps.LatLng(latitude, longitude);

        var mapOptions = {
          zoom: 12,
          center: coords,
          mapTypeControl: true,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        //create the map, and place it in the HTML map div
        map = new google.maps.Map(document.getElementById("mapPlaceholder"), mapOptions);

        var marker = new google.maps.Marker({
          label: "Y",
          position: coords,
          map: map,
          title: "You are here!"
        });
      }

      if (navigator.geolocation){
        navigator.geolocation.getCurrentPosition(showCurrentLocation);
      } else {
        alert("Geolocation API is not supported.");
      }


      // Your Client ID can be retrieved from your project in the Google
      // Developer Console, https://console.developers.google.com
      var CLIENT_ID = '470495590508-93e91fhc6l2sp53romjs1q061q25jfi6.apps.googleusercontent.com';

      var SCOPES = ["https://www.googleapis.com/auth/calendar.readonly"];

      /**
       * Check if current user has authorized this application.
       */
      function checkAuth() {
        gapi.auth.authorize(
          {
            'client_id': CLIENT_ID,
            'scope': SCOPES.join(' '),
            'immediate': true
          }, handleAuthResult);
      }

      /**
       * Handle response from authorization server.
       *
       * @param {Object} authResult Authorization result.
       */
      function handleAuthResult(authResult) {
        var authorizeDiv = document.getElementById('authorize-div');
        if (authResult && !authResult.error) {
          // Hide auth UI, then load client library.
          authorizeDiv.style.display = 'none';
          loadCalendarApi();
        } else {
          // Show auth UI, allowing the user to initiate authorization by
          // clicking authorize button.
          authorizeDiv.style.display = 'inline';
        }
      }

      /**
       * Initiate auth flow in response to user clicking authorize button.
       *
       * @param {Event} event Button click event.
       */
      function handleAuthClick(event) {
        gapi.auth.authorize(
          {client_id: CLIENT_ID, scope: SCOPES, immediate: false},
          handleAuthResult);
        return false;
      }

      /**
       * Load Google Calendar client library. List upcoming events
       * once client library is loaded.
       */
      function loadCalendarApi() {
        gapi.client.load('calendar', 'v3', listUpcomingEvents);
      }

      /**
       * Print the summary and start datetime/date of the next ten events in
       * the authorized user's calendar. If no events are found an
       * appropriate message is printed.
       */
      function listUpcomingEvents() {
        var tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        var request = gapi.client.calendar.events.list({
          'calendarId': 'primary',
          'timeMin': (new Date()).toISOString(),
          'showDeleted': false,
          'singleEvents': true,
          'maxResults': 10,
          'orderBy': 'startTime',
          'timeMax': tomorrow.toISOString()
        });

        request.execute(function(resp) {
          var events = resp.items;
          appendPre('Today\'s Events:');

          function addZero(i) {
            if (i < 10) {
              i = "0" + i;
            }
            return i;
          }
          if (events.length > 0) {
            for (i = 0; i < events.length; i++) {
              var event = events[i];
              var when = event.start.dateTime;
              var whenEnd = event.end.dateTime;
              if (!when) {
                when = event.start.date;
                appendPre(' - '+ event.summary + ' (' + when + ')')
              } else {
                var whenDate = new Date(when);
                var whenEndDate = new Date(whenEnd);
                var startHour = addZero(whenDate.getHours());
                var startMin = addZero(whenDate.getMinutes());
                var endHour = addZero(whenEndDate.getHours());
                var endMin = addZero(whenEndDate.getMinutes());
                appendPre(' - '+ event.summary + ' (' + startHour+':'+startMin+' - '+endHour+':'+endMin + ')')
              }

              if (event.location != undefined) {
                var geocoder = new google.maps.Geocoder();
                geocodeAddress(event.location, geocoder, map);
              }
            }

          } else {
            appendPre('No upcoming events found.');
          }
        });
      }

      function geocodeAddress(address, geocoder, resultsMap, i) {
        geocoder.geocode({'address': address}, function(results, status) {
          if (status === google.maps.GeocoderStatus.OK) {
            resultsMap.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
              map: resultsMap,
              position: results[0].geometry.location,
            });
            marker.setIcon('http://maps.google.com/mapfiles/ms/micons/green.png');
          }
        });
      }

      /**
       * Append a pre element to the body containing the given message
       * as its text node.
       *
       * @param {string} message Text to be placed in pre element.
       */
      function appendPre(message) {
        var pre = document.getElementById('output');
        var textContent = document.createTextNode(message + '\n');
        pre.appendChild(textContent);
      }

    </script>
    <script src="https://apis.google.com/js/client.js?onload=checkAuth">
    </script>
  </head>
  <body>
    <div class="container menubar">
      <div class="row">
        <div class="col-lg-3 text-left">
          <img class="logo-img" src="<?php echo asset('img/myfitnesspal.png')?>" />
        </div>

        <div class="col-lg-6 text-center appname">
          <p>Internet of Health</p>
        </div>

        <div class="col-lg-3 text-right user-menu">
          <p><i class="fa fa-user"></i> {{$userName}}</p>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="col-lg-4">
          <div class="list-group" id="mapPlaceholder"></div>
        </div>

        <div class="col-lg-4">
          <div class="list-group">
            <div id="authorize-div" class="img-rounded" style="display: none">
              <span>Authorize access to Google Calendar API</span>
              <!--Button for the user to click to initiate auth sequence -->
              <button type="button" class="btn btn-success" id="authorize-button" onclick="handleAuthClick(event)">
                Authorize Calendar
              </button>
            </div>
          </div>
          <pre id="output"></pre>
        </div>

        <div class="col-lg-4">
          <img style="width: 100%;" src="<?php echo asset('img/mfp.jpg')?>" />
        </div>
      </div>
    </div>

    <div class="container footer text-center">
      <p>CISCO University Challenge 2015</p>
    </div>
  </body>
</html>
