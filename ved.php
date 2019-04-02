 <?php
#20111213 #1581:sougata
#20111214 #1581:sougata
#20111216 #1581:sougata
#201201160211 #1631:sougata
include("LIB/lib.php");

$curDate = date("Y-m-d");
$hapiObj = new HAPI(CH_KEY, CH_SEC);

//$hapiObj = new HAPI();


//print_r($_COOKIE['hotelogixkey']);
?>

        <script>
            // http://jqueryui.com/demos/datepicker/

            //var dateArr = new Array('2011-09-22','2011-09-10');


            jQuery(function() {
                var dates = jQuery( "#from, #to" ).datepicker({
                    numberOfMonths: 2
                    ,changeMonth: true
                    ,changeYear: true
                    ,dateFormat: 'yy-mm-dd'
                    ,defaultDate: '<?php echo $curDate ?>'
                    ,minDate: '<?php echo $curDate ?>'
                    //,beforeShowDay: highlightOdds
                    ,onSelect: function( selectedDate ) {

                        var selectedDateObj = new Date(selectedDate);
                        // Adding 1 day
                        selectedDateObj.setDate(selectedDateObj.getDate()+1);
                        checkDate= jQuery.datepicker.formatDate('yy-mm-dd', selectedDateObj);

                        var option = this.id == "from" ? "minDate" : "maxDate",
                        instance = jQuery( this ).data( "datepicker" ),
                        date = jQuery.datepicker.parseDate(
                        instance.settings.dateFormat ||
                            jQuery.datepicker._defaults.dateFormat,
                        checkDate, instance.settings );
                        dates.not( this ).datepicker( "option", option, date );
                    }
                });
            });

    jQuery(document).ready(function() {
          jQuery("#frm").validate({
            rules: {
              from: "required",// simple rule, converted to {required:true}
              to: "required"
            },
            messages: {
              from: "Please enter  Check-In Date.",
              to: "Please enter  Check-Out Date."
            }
          });
        });
        </script>
<style>
.vhome {
    display: none;
}
    .modal-dialog {
    margin-top: 100px !important;
}
</style>


<form method="POST" action="<?php echo site_url(); ?>/search-result"  target="_blank" name="frm" id="frm">
<div class="fusion-builder-row fusion-row vcsearchmain ">

<div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_4  fusion-one-fourth fusion-column-first 1_4" style="margin-top:0px;margin-bottom:20px;width:25%;width:calc(25% - ( ( 4% + 4% + 4% ) * 0.25 ) );margin-right: 1%;">
<div class="fusion-column-wrapper" style="background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
<span class="search-names">Check-In Date:</span>
<input class="field-input vinput" type="text" value="" name="from" id="from" autocomplete="off">
<div class="fusion-clearfix"></div>
</div>
</div>

<div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_4  fusion-one-fourth 1_4" style="margin-top:0px;margin-bottom:20px;width:25%;width:calc(25% - ( ( 4% + 4% + 4% ) * 0.25 ) );margin-right: 1%;">
<div class="fusion-column-wrapper" style="background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
 <span class="search-names"> Check-Out Date:</span>
<input class="field-input vinput" type="text" value="" name="to" id="to" autocomplete="off">
<div class="fusion-clearfix"></div>
</div>
</div>

<div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_4  fusion-one-fourth 1_4" style="margin-top:0px;margin-bottom:20px;width:25%;width:calc(29% - ( ( 4% + 4% + 4% ) * 0.25 ) );margin-right: 0%;">
<div class="fusion-column-wrapper" style="background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
    <div class="vselctions">
  <span class="search-names vselnames"> Adult:</span> <select class="select-box vselect" name="adult" id="adult">
                                <?php
                                for ($i = 1; $i <= 10; $i++)
                                {
                                    echo "<option>" . $i . "</option>";
                                }
                                ?>

                            </select>
    </div>
        <div class="vselctions">
                        <span class="search-names vselnames">Child:</span> <select class="select-box vselect" name="child" id="child">
                                <?php
                                for ($i = 0; $i <= 10; $i++)
                                {
                                    echo "<option>" . $i . "</option>";
                                }
                                ?>

                            </select>
    </div>
<div class="fusion-clearfix"></div>
</div>
</div>

<div class="fusion-layout-column fusion_builder_column fusion_builder_column_1_4  fusion-one-fourth fusion-column-last 1_4" style="margin-top:0px;margin-bottom:20px;width:25%;width:calc(29% - ( ( 4% + 4% + 4% ) * 0.25 ) );">
<div class="fusion-column-wrapper" style="background-position:left top;background-repeat:no-repeat;-webkit-background-size:cover;-moz-background-size:cover;-o-background-size:cover;background-size:cover;" data-bg-url="">
     <span class="search-names vselnames ">&nbsp;</span>
<input class="table-button  vsubmit" type="submit" value="Search Rooms >" name="submit" />
    <a href="http://www.hotelpalacio.net/search-order/" style="font-size: 11px;color: blue;text-decoration: underline;word-wrap: break-word;width: 88px;display: inline-block;text-align: center;line-height: 15px;vertical-align: middle;">Check reservation</a>
<div class="fusion-clearfix"></div>
</div>
</div>

</div>

<div id="datepicker"></div>
 </form>
