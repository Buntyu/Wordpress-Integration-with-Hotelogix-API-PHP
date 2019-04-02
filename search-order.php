<?php
include("LIB/lib.php");
#201201160211 #1631:sougata
?>
        <script>
            $(document).ready(function() { 
                $("#frm").validate({ 
                    rules: { 
                        orderId: "required"
                    }, 
                    messages: { 
                        orderId: "Please enter Order ID."
                    } 
                }); 
            }); 
        </script>   
		<div class="table-style table-responsive">	
			<form method="get" action="<?php echo site_url(); ?>/view-order" name="frm" id="frm">
				<div class="table-order">
					<div>
						<h3>Order ID</h3>
						<input class="input-fild" type="text" name="orderId" id="orderId" value=""/>
						<input class="table-button" type="submit" name="subOs" value="Search"/>
					</div>
				</div>
			</form>
		</div>

