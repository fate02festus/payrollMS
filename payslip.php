<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/jquery-ui.css" />
    <script src="js/jquery.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script>
    $(function() {
        $( "#datepicker" ).datepicker();
    });
    </script>
    <style>
        @media print{
            @page{
                size: 8.5in 11in;
            }
        }
        
        #print{
            border:2px solid #000;
            width:800px;
            height:850px;
            max-width:800px;
            max-height:800px;
            margin:auto;
            font-size:12px;
        }
        table {
            border-collapse: collapse;
            }

        table, td, th {
            border: 1px solid black;
        }
    </style>
</head> 
<body> 
<button onclick="printContent('print')">Print Content</button>
<button><a style = "text-decoration:none; color:#000;" href = "index.php?page=payroll">Back</a></button>
<?php
error_reporting(0);
    $_SESSION['dt'] = date("d-m-Y");
    include('db_connect.php');
    $payroll=$conn->query("SELECT p.*,concat(e.lastname,', ',e.firstname,' ',e.middlename) as ename,e.employee_no FROM payroll_items p inner join employee e on e.id = p.employee_id  where p.id=".$_GET['id']);
    foreach ($payroll->fetch_array() as $key => $value) {
        $$key = $value;
    }
    $pay = $conn->query("SELECT * FROM payroll where id = ".$payroll_id)->fetch_array();
    $pt = array(1=>"Monhtly",2=>"Semi-Monthly");

   
?>

<br />
<br />
    <div id="print">
        <div style = "margin:10px;">    <br />  
          <center><img src="ap.png"></center>
           <center><b>Utee Estate Limited</b></center>
            <center><b>Black Tulip Flowers LLC></b></center>                           
            <center><b>P.O. Box: 231771</b></center>
            <center><b>DUBAI - U.A.E</b></center>
            <br/>
            <center>Employee Payroll</center>
            <br />
            <br />
            <label>Date:
                <?php echo "<b>".
                       date("d-m-Y")."</b>";
                    ?>
            <br />
            <label>Employee ID:
                <?php echo "<b>".
                       $employee_no."</b>";
                    ?>
                   &emsp;&emsp;&emsp; Employee Name:
                <?php echo "<b>".
                       ucwords($ename)."</b>";
                    ?>
            <br />
           -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
           <br />
            <br />
            <label>Payroll Ref:
                <?php echo "<b>".
                       $pay['ref_no']."</b>";
                    ?>
                     &emsp;&emsp;&emsp; payroll Range:
                <?php echo "<b>".
                        date("M d, Y",strtotime($pay['date_from'])). " - ".date("M d, Y",strtotime($pay['date_to']))."</b>";
                    ?>
                     &emsp;&emsp;&emsp; Employee Type:
                <?php echo "<b>".
                       $pt[$pay['type']] ."</b>";
                    ?>
                      <br /><br />
            -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
             <br /><br />
            <label>Days Absent:
                <?php echo "<b>".
                       $absent."</b>";
                    ?>
                     &emsp;&emsp;&emsp; Undertime(mins):
                <?php echo "<b>".
                       $late."</b>";
                    ?>
                                         <br />
                                         <br/>
           
                <label>Total Allowance Amount:
                <?php echo "<b>".
                        number_format($allowance_amount,2)."</b>";
                    ?>
                     &emsp;&emsp;&emsp; Total Deduction Amount:
                <?php echo "<b>".
                       number_format($deduction_amount,2)."</b>";
                    ?>
                     &emsp;&emsp;&emsp; Net Pay:
                <?php echo "<b>".
                       number_format($net,2)."</b>";
                    ?>
                      <br /><br />
            -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------<br />
ALLOWANCES<br />
             -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
           
            <br />
            <br />
            <center>
                <table>
                    <?php
                            $all_qry = $conn->query("SELECT * from allowances ");
                            $t_arr = array(1=>"Monthly",2=>"Semi-Monthly",3=>"Once");
                            while($row=$all_qry->fetch_assoc()):
                                $all_arr[$row['id']] = $row['allowance'];
                            endwhile; 
                            foreach(json_decode($allowances) as $k => $val):

                            ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                           <?php echo $all_arr[$val->aid] ?> Allowance
                        <span class="badge badge-primary badge-pill"><?php echo number_format($val->amount,2) ?></span>
                      </li>
                          
                        <?php endforeach; ?>
                       
                </table>
            </center>
              -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------<br />
DEDUCTIONS<br />
             -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
                <br />
            <center>
                <table>
                       <?php
                            $all_qry = $conn->query("SELECT * from deductions ");
                            $t_arr = array(1=>"Monthly",2=>"Semi-Monthly",3=>"Once");
                            while($row=$all_qry->fetch_assoc()):
                                $ded_arr[$row['id']] = $row['deduction'];
                            endwhile; 
                            foreach(json_decode($deductions) as $k => $val):

                            ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                           <?php echo $ded_arr[$val->did] ?>
                        <span class="badge badge-primary badge-pill"><?php echo number_format($val->amount,2) ?></span>
                      </li>
                          
                        <?php endforeach; ?>
                        
                       
                </table>
            </center>
        </div>
    </div>
<script>
function printContent(el){
    var restorepage = document.body.innerHTML;
    var printcontent = document.getElementById(el).innerHTML;
    document.body.innerHTML = printcontent;
    window.print();
    document.body.innerHTML = restorepage;
}
</script>
</html>