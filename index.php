<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Audio Manager</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("active");
    });
    </script>
    <script type="text/javascript">
    $(function () {
        $("[rel='tooltip']").tooltip();
    });
  </script>

  </head>

  <body>
    <div id="wrapper">
      
      <!-- Sidebar -->
      <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
          <li class="sidebar-brand"><a href="#">Home</a></li>
          <li><a href="admin/index.php">Manage</a></li>
        </ul>
      </div>
          
      <!-- Page content -->
      <div id="page-content-wrapper">
        <div class="content-header">
          <h1>
            <a id="menu-toggle" href="#" class="btn btn-default"><i class="icon-reorder"></i></a>
            Audio Storage!
          </h1>
        </div>
        <!-- Keep all page content within the page-content inset div! -->
        <div class="page-content inset">
          <div class="row">
            <div class="col-md-12">
              <p class="lead">This stores all of the music I listen too. Enjoy!</p>
            </div>
          </div>
            <?php
            include 'audioinfo.class.php';
            include 'class.String.php';

            $dirname = "downloads";
            $dh = opendir($dirname) or die("couldn't open directory");


            while (!(($file = readdir($dh)) === false ) ) {
              if (!is_dir("$dirname/$file")) {
                            $au = new AudioInfo();      
                $metaData = $au->Info("downloads/" . $file);
                        
                $tooltipPlace = "Format: {0} |\n
                Length: {1}
                ";

                $tooltipinfo = String::FormatSimpler($tooltipPlace, $metaData['format_name'], round($metaData['playing_time'] / 60). " minutes");
                echo "<div class='col-md-4'>
            <p class='well'><a rel='tooltip' data-toggle='tooltip' title='$tooltipinfo' href='downloads/$file'>$file</a></p>
            </div>";
              }
            }
            closedir($dh);
            ?>
          </div>
        </div>
      </div>
      
    </div>
  </body>
</html>