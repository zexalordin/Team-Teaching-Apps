<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title; ?></title>
    <link href="<?=base_url('assets/css/')?>lib/chartist/chartist.min.css" rel="stylesheet">
    <link href="<?=base_url('assets/css/')?>lib/owl.carousel.min.css" rel="stylesheet" />
    <link href="<?=base_url('assets/css/')?>lib/owl.theme.default.min.css" rel="stylesheet" />
    <!-- Bootstrap Core CSS -->
    <link href="<?=base_url('assets/css/')?>lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="<?=base_url('assets/css/')?>bootstrap-select.min.css" rel="stylesheet">
    <link href="<?=base_url('assets/css/')?>bootstrap-table-expandable.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?=base_url('assets/css/')?>helper.css" rel="stylesheet">
    <link href="<?=base_url('assets/css/')?>style.css" rel="stylesheet">
    <link href="<?=base_url('assets/css/')?>pagination.css" rel="stylesheet">
    <link href="<?=base_url('assets/css/')?>bootstrap-multiselect.css" rel="stylesheet">
    <!-- Dropdown -->
    <link href="<?=base_url('assets/css/')?>dropdown.css" rel="stylesheet">
    <link href="<?=base_url('assets/css/')?>datepicker.css" rel="stylesheet">
    <link href="<?=base_url('assets/css/')?>material-bootstrap-wizard.css" rel="stylesheet">
    
    
    <script src="<?php echo base_url()."assets/js/"?>jquery-3.2.1.js"></script>
    <script src="<?=base_url('assets/js/')?>bootstrap.min.js"></script>
    <!-- dropdown search -->
    <script src="<?php echo base_url()."assets/js/"?>bootstrap-select.min.js"></script>
    <!-- datetimepicker -->
    <script src="<?=base_url('assets/js/')?>moment-with-locales.js"></script>
    <script src="<?=base_url('assets/js/')?>bootstrap-datepicker.min.js"></script>
    <script src="<?=base_url('assets/js/')?>sweetalert.min.js"></script>
    <!-- CKeditor -->
    <script src="<?=base_url('assets/ck/ckeditor/')?>ckeditor.js"></script>
    <!-- Canvas-->
    <script src="<?=base_url('assets/js/canvasjs/')?>canvasjs.min.js"></script>

</head>

<body class="fix-header fix-sidebar">
    <!-- Main wrapper  -->
    <div id="main-wrapper">
        <?php echo $header; ?>
        <?php echo $sidebar; ?>
        <?php echo $content; ?>
    </div>
    <!-- End Wrapper -->
    <!-- All Jquery -->

    <!-- Bootstrap tether Core JavaScript -->
    <script src="<?=base_url('assets/js/')?>lib/bootstrap/js/popper.min.js"></script>
    <script src="<?=base_url('assets/js/')?>bootstrap-multiselect.js"></script>
    <script src="<?=base_url('assets/js/')?>bootstrap3-typeahead.min.js"></script>
    
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?=base_url('assets/js/')?>jquery.slimscroll.js"></script>
    <!--Menu sidebar -->
    <script src="<?=base_url('assets/js/')?>sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="<?=base_url('assets/js/')?>lib/sticky-kit-master/dist/sticky-kit.min.js"></script>


    <script src="<?=base_url('assets/js/')?>lib/datamap/d3.min.js"></script>
    <script src="<?=base_url('assets/js/')?>lib/datamap/topojson.js"></script>

    <script src="<?=base_url('assets/js/')?>lib/weather/jquery.simpleWeather.min.js"></script>
    <script src="<?=base_url('assets/js/')?>lib/weather/weather-init.js"></script>
    <script src="<?=base_url('assets/js/')?>lib/owl-carousel/owl.carousel.min.js"></script>
    <script src="<?=base_url('assets/js/')?>lib/owl-carousel/owl.carousel-init.js"></script>
    <!--Custom JavaScript -->
    <script src="<?=base_url('assets/js/')?>custom.min.js"></script>
    
        <!-- table -->
    <script src="<?php echo base_url()."assets/js/"?>jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()."assets/js/"?>dataTables.bootstrap.min.js"></script>
    <script src="<?php echo base_url()."assets/js/"?>bootstrap-table-expandable.js"></script>

    

    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>
    <script type="text/javascript">
        var colours = ["#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e", "#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50", "#f1c40f", "#e67e22", "#e74c3c", "#95a5a6", "#f39c12", "#d35400", "#c0392b", "#bdc3c7", "#7f8c8d"];

        var name = "<?php echo strtoupper($this->session->userdata('nama')); ?>",
            nameSplit = name.split(" "),
            initials = nameSplit[0].charAt(0).toUpperCase() + nameSplit[1].charAt(0).toUpperCase();

        var charIndex = initials.charCodeAt(0) - 65,
            colourIndex = charIndex % 19;

        if (document.getElementById("user-icon")) {
            var canvas = document.getElementById("user-icon");
            var context = canvas.getContext("2d");
            var canvasWidth = $(canvas).attr("width"),
            canvasHeight = $(canvas).attr("height"),
            canvasCssWidth = canvasWidth,
            canvasCssHeight = canvasHeight;

            if (window.devicePixelRatio) {
                $(canvas).attr("width", canvasWidth * window.devicePixelRatio);
                $(canvas).attr("height", canvasHeight * window.devicePixelRatio);
                $(canvas).css("width", canvasCssWidth);
                $(canvas).css("height", canvasCssHeight);
                context.scale(window.devicePixelRatio, window.devicePixelRatio);
            }

            context.fillStyle = colours[colourIndex];
            context.fillRect (0, 0, canvas.width, canvas.height);
            context.font = "80px Arial";
            context.textAlign = "center";
            context.fillStyle = "#FFF";
            context.fillText(initials, canvasCssWidth / 2, canvasCssHeight / 1.5);
        }

        
        var canvasMini = document.getElementById("user-icon-mini");
        
        var contextMini = canvasMini.getContext("2d");

        
        var canvasMiniWidth = $(canvasMini).attr("width"),
            canvasMiniHeight = $(canvasMini).attr("height"),
            canvasMiniCssWidth = canvasMiniWidth,
            canvasMiniCssHeight = canvasMiniHeight;

        

        if (window.devicePixelRatio) {
            $(canvasMini).attr("width", canvasMiniWidth * window.devicePixelRatio);
            $(canvasMini).attr("height", canvasMiniHeight * window.devicePixelRatio);
            $(canvasMini).css("width", canvasMiniCssWidth);
            $(canvasMini).css("height", canvasMiniCssHeight);
            contextMini.scale(window.devicePixelRatio, window.devicePixelRatio);
        }

        

        contextMini.fillStyle = colours[colourIndex];
        contextMini.fillRect (0, 0, canvasMini.width, canvasMini.height);
        contextMini.font = "20px Arial";
        contextMini.textAlign = "center";
        contextMini.fillStyle = "#FFF";
        contextMini.fillText(initials, canvasMiniCssWidth / 2, canvasMiniCssHeight / 1.5);
    </script>
    <script>
        var allEditors = document.querySelectorAll('#editorC');
        for (var i = 0; i < allEditors.length; ++i) {
            CKEDITOR.replace(allEditors[i]);
        }
        
        var allEditors = document.querySelectorAll('#opsi');
        for (var i = 0; i < allEditors.length; ++i) {
            CKEDITOR.disableAutoInline = true;
            CKEDITOR.inline(allEditors[i]);
        }
    </script>

</body>

</html>