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
    $pay = $conn->query("SELECT * FROM payroll where id = ".$_GET['id'])->fetch_array();
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
            <center>Payroll : <?php echo $pay['ref_no'] ?></center>
            <br />
            <br />
            <label>Date:
                <?php echo "<u>".
                       date("d-m-Y")."</u>";
                    ?>
            <br />
            <br />
            <center>
                <table>
                        <tr>
                            
                            <th style = "padding-right:20px;padding-left:20px;"><center>Employee ID</center></th>
                            <th style = "padding-right:70px;padding-left:70px;"><center>Name.</center></th>
                            <th style = "padding-right:20px;padding-left:20px;"><center>Absent</center></th>
                            <th style = "padding-right:20px;padding-left:20px;"><center>Late</center></th>
                            <th style = "padding-right:40px;padding-left:40px;"><center>Total Allowance</center></th>
                            <th style = "padding-left:40px; padding-right:40px;"><center>Total Deduction</center></th>
                            <th style = "padding-left:40px; padding-right:40px;"><center>Net</center></th>
                        </tr>
                <?php
                 // if(isset($_POST['print_patient'])){
       
          $query = $conn->query("SELECT p.*,concat(e.lastname,', ',e.firstname,' ',e.middlename) as ename,e.employee_no,e.salary FROM payroll_items p inner join employee e on e.id = p.employee_id ") or die(mysqli_error());

        
        $cnt=$query->num_rows;
                    for($a = 1; $a <= $cnt; $a++){
                        $fetch = $query->fetch_array();
                        
                ?>
                    <tr>
                        <td><center><?php echo $fetch['employee_no']?></center></td>
                        <td><center><?php  echo ucwords($fetch['ename']) ?></center></td>
                        <td><center><?php echo $fetch['absent']?></center></td>
                        <td><center><?php echo $fetch['late']?></center></td>
                        <td><center><?php echo number_format($fetch['allowance_amount'],2) ?></center></td>
                        <td><center><?php echo number_format($fetch['deduction_amount'],2)?></center></td>
                        <td><center><?php echo  number_format($fetch['net'],2)?></center></td>
                    </tr>
                <?php
                    }//}
                    $conn->close();
                ?>
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