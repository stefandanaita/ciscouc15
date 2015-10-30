<!DOCTYPE html>
<html>
  <head>
    <title>Fill Me App</title>

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
  </head>
  <body>
    <div class="container menubar">
      <div class="row">
        <div class="col-lg-6 text-left">
          <img class="logo-img" src="<?php echo asset('img/myfitnesspal.png')?>" />
        </div>

        <div class="col-lg-6 text-right user-menu">
          <h4><i class="fa fa-user"></i> {{$userName}}</h4>
        </div>
      </div>
    </div>
  </body>
</html>
