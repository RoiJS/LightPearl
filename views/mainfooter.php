		<script src="public/js/processFunctions.js" type="text/javascript" ></script>
		<script src="js/bootstrap/bootbox.min.js" type="text/javascript" ></script>
		<script src="bootstrap/js/bootstrap.min.js" type="text/javascript" ></script>
		<script src="js/bootstrap/bootstrap-transition.js" type="text/javascript" ></script>
        <script src="js/bootstrap/bootstrap-alert.js" type="text/javascript" ></script>
        <script src="js/bootstrap/bootstrap-modal.js" type="text/javascript" ></script>
        <script src="js/bootstrap/bootstrap-dropdown.js" type="text/javascript" ></script>
        <script src="js/bootstrap/bootstrap-scrollspy.js" type="text/javascript" ></script>
        <script src="js/bootstrap/bootstrap-tab.js" type="text/javascript" ></script>
        <script src="js/bootstrap/bootstrap-tooltip.js" type="text/javascript" ></script>
        <script src="js/bootstrap/bootstrap-popover.js" type="text/javascript" ></script>
        <script src="js/bootstrap/bootstrap-button.js" type="text/javascript" ></script>
        <script src="js/bootstrap/bootstrap-collapse.js" type="text/javascript" ></script>
        <script src="js/bootstrap/bootstrap-carousel.js" type="text/javascript" ></script>
        <script src="js/bootstrap/bootstrap-typeahead.js" type="text/javascript" ></script>
        <script src="js/bootstrap/bootstrap-affix.js" type="text/javascript" ></script>
        <script src="js/bootstrap/bootstrap-datepicker.js" type="text/javascript" ></script>
        <!-- <script src="js/bootstrap/shortcut.js" type="text/javascript" ></script> -->
        <script src="js/jquery/jquery-tablesorter.js" type="text/javascript" ></script>
        <!-- <script src="js/jquery/jquery-chosen.js" type="text/javascript" ></script> -->
        <script src="js/jquery/virtual-tour.js" type="text/javascript" ></script>
		
		<script src="js/jquery/jquery-ui.min.js"></script>
		<script src="js/jquery/jquery.select-to-autocomplete.js" type="text/javascript" ></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js" type="text/javascript"></script>
		
		
		<script>
		$(function() {
            $('#sample-table').tablesorter();
            $('#datepicker').datepicker({format: 'mm/dd/yyyy'});
            // $(".chosen").chosen();
			$('select.select-items, select.customer-name, select.invoice-no').selectToAutocomplete();
			
			//monitorAccountAccess = setInterval(function(){validateAcountAccess();},5000);
       
			bootbox.setDefaults({
				onEscape : true
			});
		});
		</script>
	</body>
</html>