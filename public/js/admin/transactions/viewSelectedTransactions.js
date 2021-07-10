$(document).ready(function(){
	
	$(".btn-print-as-invoice").click(function(){
		id = $(this).attr("id");
		bootbox.confirm({
			title : "Print Transaction Details",
			message : messageBody("question", "Are sure transaction to print transaction as invoice?"),
			callback : function(result){
				if(result){
					generateOutput(id, "","", 'invoice')
				}
			}
		});
	})
	
	$(".btn-print-as-delivery-report").click(function(){
		id = $(this).attr("id");
		
		bootbox.confirm({
			title : "Print delivery report",
			message : messageBody("question", "Are you sure to print transaction as delivery report?"),
			callback : function(result){
				if(result){
					generateOutput(id, "","", 'dr');
				}
			}
		});
	})
})