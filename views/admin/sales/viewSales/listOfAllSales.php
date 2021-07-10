<?php if(!empty($dailySales)){?>
	<?php for($i = 0; $i < count($dailySales); $i++):?>
	<tr <?php if($dailySales[$i][1] <= 0){echo "style='background-color:#FF7C7C;'";}?>>
		<?php 
			if($i < 10){
				$dateSales[] = date('M d, Y',strtotime($dailySales[$i][0]));
				$sales[] = number_format($dailySales[$i][1],2,".","");	
			}
		?>
		
		<td style="width:400px;text-align:center;"><?php echo date('F d, Y',strtotime($dailySales[$i][0]));?></td>	
		<td style="width:400px;text-align:center;"><?php echo "Php ".number_format($dailySales[$i][1],2,".",",");?></td>
	</tr>
	<?php endfor;?>
	<tr hidden>
		<td>
			<span id="no-of-days" ><?php echo $noOfdays; ?></span>
			<span id="total-sales" ><?php echo number_format($totalSales,2,".",","); ?></span>
		</td>
	</tr>
<?php }else{?>
	<tr>
		<td colspan=2>
			<div class="box-body" style="margin-top:30px;">
				<div class="box-body">
					<div class="callout callout-danger">
						Empty sales list.
					</div>
				</div>
			</div>
		</td>
	</tr>
<?php } ?>
<tr hidden>
	<td><span class="dates"><?php echo json_encode($dateSales);?></span></td>
	<td><span class="sales"><?php echo json_encode($sales);?></span></td>
	<td><span class="start-date"><?php echo $dateSort != "" ? date("M d, Y", strtotime($dateSort["dateFrom"])) : "none"; ?></span></td>
	<td><span class="end-date"><?php echo $dateSort != "" ? date("M d, Y", strtotime($dateSort["dateTo"])) : "none"; ?></span></td>
</tr>



