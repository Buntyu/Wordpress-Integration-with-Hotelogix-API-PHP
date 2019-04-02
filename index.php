<?php
#20111213 #1581:sougata
#20111214 #1581:sougata
#20111216 #1581:sougata
#201201160211 #1631:sougata
include("LIB/lib.php");
$curDate = date("Y-m-d");
$hapiObj = new HAPI(CH_KEY, CH_SEC);
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
<style>#ssb-container {
    display: none !important;
}

</style>
        <div class="table-style table-responsive">
            <form method="POST" action="<?php echo site_url(); ?>/search-result" name="frm" id="frm">
                <table align="center" cellspacing="10" width="100%">
                    <tr class="field-from">
                        <td>
                            Check-In Date:
                        </td>
                        <td>
                            <input class="field-input" type="text" value="" name="from" id="from" autocomplete="off">
                        </td>
                    </tr>
                    <tr class="field-from">
                        <td>
                            Check-Out Date:
                        </td>
                        <td>
                            <input class="field-input" type="text" value="" name="to" id="to" autocomplete="off">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            Adult: <select class="select-box" name="adult" id="adult">
                                <?php
                                for ($i = 1; $i <= 10; $i++)
                                {
                                    echo "<option>" . $i . "</option>";
                                }
                                ?>

                            </select>

                            Child <select class="select-box" name="child" id="child">
                                <?php
                                for ($i = 0; $i <= 10; $i++)
                                {
                                    echo "<option>" . $i . "</option>";
                                }
                                ?>

                            </select>
                            <input class="table-button btn-right" type="submit" value="Search Rooms >" name="submit" />

                        </td>
                    </tr>
                </table>
                <div id="datepicker"></div>


            </form>
        </div><!-- End demo -->
