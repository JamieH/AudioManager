<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Audio Manager</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="../css/simple-sidebar.css" rel="stylesheet">
    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.js"></script>
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
          <li class="sidebar-brand"><a href="../index.php">Home</a></li>
          <li><a href="index.php">Manage</a></li>
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
            <div class="col-md-12">
              <h3 id="title">Title:<h3>
              <img src="" class="ytimg img-rounded">

              <form METHOD=GET action="go.php">
              <fieldset>
                <legend>Download new song</legend>
                <label>URL: </label>
                <input name="yturl" id="yturl" type="text" placeholder="Youtube Link">
                <button type="submit" class="btn">Submit</button>
              </fieldset>
            </form>
            </div>
                        <div class="col-md-12">

            <h3><span class="label label-default">All Music</span></h3>
                        </div>
            <?php
            include '../audioinfo.class.php';
            include '../class.String.php';

            $dirname = "../downloads";
            $dh = opendir($dirname) or die("couldn't open directory");


            while (!(($file = readdir($dh)) === false ) ) {
              if (!is_dir("$dirname/$file")) {
                            $au = new AudioInfo();      
                $metaData = $au->Info("../downloads/" . $file);
                        
                $tooltipPlace = "Format: {0} |\n
                Length: {1}
                ";

                $tooltipinfo = String::FormatSimpler($tooltipPlace, $metaData['format_name'], round($metaData['playing_time'] / 60). " minutes");
                echo "<div class='col-md-4'>
            <p class='well'><a rel='tooltip' data-toggle='tooltip' title='$tooltipinfo' href='../downloads/$file'>$file</a></p>
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
  <script>
/**
 * JavaScript function to match (and return) the video Id 
 * of any valid Youtube Url, given as input string.
 * @author: Stephan Schmitz <eyecatchup@gmail.com>
 * @url: http://stackoverflow.com/a/10315969/624466
 */
function ytVidId(url) {
  var p = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
  return (url.match(p)) ? RegExp.$1 : false;
}
      $('input[type=text]').bind('input propertychange', function() {

        $value = document.getElementById('yturl').value;
        if (ytVidId($value))
        {
            $.getJSON("http://gdata.youtube.com/feeds/api/videos/" + ytVidId($value) + "?v=2&alt=json&callback=?", function(json){
            $("#title").text("Title: " + json.entry['title']['$t']);
            $(".ytimg").attr("src", json.entry['media$group']['media$thumbnail'][3]['url']);
                    });

        }

        
    });
      </script>
</html>
