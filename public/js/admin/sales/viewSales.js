$(document).ready(function(){
	
	var boxSortSalesByDate = {};
	var sql = {};
	
	var sortOrderForAllWalkInTransactions = 'DESC';
	var dateSortForAllWalkInTransactions = {};
	
	showComponents('viewSales','.displayAllSalesTransactions',"", "", sortOrderForAllWalkInTransactions,"", "","",dateSortForAllWalkInTransactions);
	refreshSalesStatus();
	viewSalesGraph();
	displayDateStatus();
	//===================================== Sales Functions ========================================
	
	$("body").delegate(".menu-sort-most-recent-existing-transaction","click",function(){
		sortOrderForAllWalkInTransactions = "DESC";
		$(".option-sort-most-previous-existing-transaction").removeClass("disabled");
		$(".option-sort-most-recent-existing-transaction").addClass("disabled");
		showComponents('viewSales','.displayAllSalesTransactions',"", "", sortOrderForAllWalkInTransactions,"", "","",dateSortForAllWalkInTransactions);
	});
	
	$("body").delegate(".menu-sort-most-previous-existing-transaction","click",function(){
		sortOrderForAllWalkInTransactions = "ASC";
		$(".option-sort-most-previous-existing-transaction").addClass("disabled");
		$(".option-sort-most-recent-existing-transaction").removeClass("disabled");
		showComponents('viewSales','.displayAllSalesTransactions',"", "", sortOrderForAllWalkInTransactions,"", "","",dateSortForAllWalkInTransactions);
	});
	
	$("body").delegate(".menu-sort-by-date-existing-transaction","click",function(){
		sortform = ajax({sortSalesByDate : 1},true);
		boxSortSalesByDate = modalForm("Sort Sales Information", sortform);
		$(".transaction-date-from").val(dateSortForAllWalkInTransactions.dateFrom)
		$(".transaction-date-to").val(dateSortForAllWalkInTransactions.dateTo)
	});
	
	
	$("body").delegate(".btn-close-sort-existing-transaction-by-date-form","click",function(){
		boxSortSalesByDate.modal("hide");
	});
	
	$("body").delegate(".btn-sort-existing-transaction-by-date-form","click",function(){
		dateSortForAllWalkInTransactions.dateFrom = $.trim($(".transaction-date-from").val());
		dateSortForAllWalkInTransactions.dateTo = $.trim($(".transaction-date-to").val());
		
		if(dateSortForAllWalkInTransactions.dateTo !=0 && dateSortForAllWalkInTransactions.dateFrom != 0){
			showComponents('viewSales','.displayAllSalesTransactions',"", "", sortOrderForAllWalkInTransactions,"", "","",dateSortForAllWalkInTransactions);
			boxSortSalesByDate.modal("hide");
			refreshSalesStatus();
			viewSalesGraph();
			displayDateStatus();
		}else{
			bootbox.alert({
				title : "No dates specified",
				message : messageBody("warning", "Please select date from and date to sort order transactions.")
			});
		}
	});
	
	$("body").delegate(".menu-refresh-expenses-list","click", function(){
		dateSortForAllWalkInTransactions = {};
		showComponents('viewSales','.displayAllSalesTransactions',"", "", sortOrderForAllWalkInTransactions,"", "","",dateSortForAllWalkInTransactions);
		refreshSalesStatus();
		viewSalesGraph();
		displayDateStatus();
	});
	
	function refreshSalesStatus(){
		var days = $("#no-of-days").html();
		var sales = $("#total-sales").html();
		$(".noOfDays").html(days);
		$(".totalSales").html(sales);
	}
	
	function viewSalesGraph(){
		
		var dates = JSON.parse($(".dates").html());
		var sales = JSON.parse($(".sales").html());
		var pointColor = [];
		
		for(i in sales){
			if(sales[i] <= 0)
				pointColor[i] = "red"; 
			else 
				pointColor[i] = "green"; 
		}
		
		var chartdata = {
			labels : dates.reverse(),
			datasets :[
				{
					label : "Sales 10 days forecast",
					pointBackgroundColor : pointColor.reverse(),
					borderColor : '#9cce38',
					data : sales.reverse()
				}
			]
		};
		
		var ctx = $("#sales-chart");
		
		var barGraph = new Chart(ctx, {
			type : 'line',
			data : chartdata,
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true,
							callback: function(label, index, labels) {
								return number_format(parseFloat(label),2,".",",");
							}
						}
					}]
				}
			}
		});
		
		$(".sales-date").html(dates[0] + " to " + dates[(dates.length-1)]);
	}
	
	function displayDateStatus(){
		if($.trim($(".start-date").html()) != "none" && $.trim($(".end-date").html()) != "none"){
			$(".view-start-end-date").removeAttr("hidden");
		}else{
			$(".view-start-end-date").attr("hidden","hidden");
		}
		$(".startDate").html($.trim($(".start-date").html()) != "none" ? $(".start-date").html() : "-----------------------");
		$(".endDate").html($.trim($(".end-date").html()) != "none" ? $(".end-date").html() : "-----------------------");
	}
})
