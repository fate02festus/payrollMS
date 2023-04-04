<?php include 'db_connect.php';

$sql="";
if(ISSET($_POST['search']))
	{
		 $dept=$_POST['dept'];
		 $sql ="  where hrd_approved='$dept' ";
		 $_SESSION['sql']=$sql;
	}
 ?>
<style>
	.on-print{
		display: none;
	}
</style>
<noscript>
	<style>
		.text-center{
			text-align:center;
		}
		.text-right{
			text-align:right;
		}
		table{
			width: 100%;
			border-collapse: collapse
		}
		tr,td,th{
			border:1px solid black;
		}
	</style>
</noscript>
<div class="container-fluid">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<div class="col-md-12">
					<b>LEAVE REPORT</b>
					<hr>
						<div class="row">
							<div class="col-md-12 mb-2">
								<form id = "form_user" method = "POST" enctype = "multi-part/form-data">
								 <label for="exampleInputEmail1">Leave Status:</label>
					                 <select name = "dept" >
					               
								<option value="0">Pending</option>
								<option value="1">Approved</option>
								<option value="2">Rejected</option>
					               </select>              
					              <button type="submit" name = "search" ><i class="fa fa-search"></i> Search</button>
								</form>
							<a href="pdf.php?id=<?php echo $sql ?>" class="btn btn-sm btn-block btn-success col-md-2 ml-1 float-right" > <i class="fa fa-print"></i>Print </a>
							
							</div>
						</div>
					<div id="report">
						<div class="on-print">
							<center>BROLAZ ANGOLA</center><
							<center>198 West 21th Street</center>
							<center>LUANDA - ANGOLA</center>
							<br/>
							<center>Employee Leave List</center>
							<center>As of <b><?php echo date('F ,Y') ?></b></center>
						</div>
						<div class="row">
							<table class="table table-bordered">
								<thead>
									<tr>
										<th>#</th>
										<th>Date</th>
										<th>EmpNo#</th>
										<th>Name#</th>
										<th>Leave#</th>
										<th>From#</th>
										<th>To#</th>
										<th>Status#</th>										
										
									</tr>
								</thead>
								<tbody>
									<?php 
									$i = 1;
									// $tamount = 0;
									$employee =$conn->query("SELECT employee.empno,concat(firstname,' ',middlename,' ',lastname) as ename,date,leave_master.name ,leave_trans.description,start_date,end_date,hrd_approved as approved FROM `leave_trans` left join  employee on employee.empno=leave_trans.empno left join leave_master on leave_master.id=leave_trans.leave_type ". $sql."");

									while($row=$employee->fetch_assoc()):  //if($employees->num_rows > 0):
									
										$app="PENDING";
										if($row['approved']=="0")
											$app="PENDING";
										else if($row['approved']=="1")
											$app="APPROVED";
										else if($row['approved']=="2")
											$app="REJECTED";
									?>
									<tr>
										<td><?php echo $i++ ?></td>
										<td><?php echo $row['date'] ?></td>
										<td><?php echo $row['empno'] ?></td>
										<td><?php echo $row['ename'] ?></td>
										<td><?php echo $row['description'] ?></td>
								        <td><?php echo $row['start_date'] ?></td>
								        <td><?php echo $row['end_date'] ?></td>
										<td><?php echo $app  ?></td>
									</tr>
								<?php endwhile; ?>
								
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$('#print').click(function(){
		var _style = $('noscript').clone()
		var _content = $('#report').clone()
		var nw = window.open("","_blank","width=800,height=700");
		nw.document.write(_style.html())
		nw.document.write(_content.html())
		nw.document.close()
		nw.print()
		setTimeout(function(){
		nw.close()
		},500)
	})
	$('#filter-report').submit(function(e){
		e.preventDefault()
		location.href = 'index.php?page=payment_report&'+$(this).serialize()
	})
</script>