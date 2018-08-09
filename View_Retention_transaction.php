<?php
    session_start();  
    $pgTitle="Contractor Retention";
    require('../comp/pg_header.php');
    require('../class/mysql_connection.php'); 
?>
<head>
    <meta charset="utf-8"><!-- Datatables -->
      <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    
    <!-- Custom Theme Scripts -->
    <script src="../build/js/custom.min.js"></script>
    <!-- Datatables -->
    <script src="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.js"></script>
    <script src="../vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="../vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="../vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="../vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="../vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="../vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="../vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="../vendors/datatables.net-scroller/js/datatables.scroller.min.js"></script>
    <script src="../vendors/jszip/dist/jszip.min.js"></script>
    <script src="../vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="../vendors/pdfmake/build/vfs_fonts.js"></script>
    <script src="../vendors/jQuery-Plugin-For-Custom-Searchable-Select-List-Customselect/css/jquery-customselect-1.9.1.css"></script>
    <script src="../vendors/jQuery-Plugin-For-Custom-Searchable-Select-List-Customselect/js/jquery-customselect-1.9.1,js"></script>
    <script src="../vendors/jQuery-Plugin-For-Custom-Searchable-Select-List-Customselect/js/jquery-customselect-1.9.1.min.js"></script>
    <script src="../vendors/jQuery-Plugin-For-Custom-Searchable-Select-List-Customselect/src/jquery-customselect.css"></script>
    <script src="../vendors/jQuery-Plugin-For-Custom-Searchable-Select-List-Customselect/src/jquery-customselect.js"></script>

    <script>
        function formOperation(opVal){
            if(opVal == 2){ 
                var x = document.getElementById("selected_retention_id").value; 
                if(x==""){ 
                alert("Please select a record to edit.");               
                }else{
                document.form_s.action = "retention_edit.php";
                document.form_s.submit();   
              }
            }
            
           if(opVal == 3){             
                var c = confirm("Are you sure you want to delete the record?");
                if (c == true){     
                    var x = document.getElementById("selected_retention_id").value;
                    if(x==""){ 
                    alert("Please select a record to delete.");
                
                }else{
                
                  document.form_s.action = "Retention_process.php";
                  document.form_s.submit();
                
                }
              }
            }

               if(opVal == 4){
               var x = document.getElementById("selected_retention_id").value;
              
              if(x==""){
                
                alert("Please select a record and add surety bond details.");


                
              }else{
              
                document.form_s.action = "Surety_bond.php";
                document.form_s.submit();
                
              }
            }

            if(opVal == 5){
              var x=document.getElementById("selected_retention_id").value;
              if(x==""){
                alert("Please select a record and add details for cash bond transaction");
              }else{
                document.form_s.action = "cash_bond.php";
                document.form_s.submit();
              }
              }


            }        
            
          function setValue(){
            var radElements = document.getElementsByName("sel_val_rad");
            for(var i=0; i < radElements.length; i ++){
              if(radElements[i].checked == true){
                document.getElementById("selected_retention_id").value = radElements[i].value;
              }
            }
          }
    </script>
</head>

<body>
    <div class="container">
        <?php require('../comp/pg_banner.php'); ?>
        <?php
        if(isset($_POST['selected_retention_id'])){         
          $id=$_POST['selected_retention_id'];
          $sql = "SELECT * FROM tbl_retention a JOIN tbl_transaction b ON a.T_ID=b.T_ID WHERE dv_num_R='$id';";
          $result = mysql_query($sql);
          
          if($result){
            if(mysql_num_rows($result) == 1){
              $userdata = mysql_fetch_array($result);
            }else{
              die("No Record Found!");
            }
          }else{
            die("Error in sql query ".mysql_error());
          }
        }
        if(isset($_POST['selected_transaction_id'])){         
          $id=$_POST['selected_transaction_id'];
          $sql = "SELECT * FROM tbl_transaction WHERE T_Id='$id';";
          $result = mysql_query($sql);
          
          if($result){
            if(mysql_num_rows($result) == 1){
              $userdata = mysql_fetch_array($result);
            }else{
              die("No Record Found!");
            }
          }else{
            die("Error in sql query ".mysql_error());
          }
        }
    ?>
        <center><h3><strong>Create Retention Information</strong></h3></center>
        <a href="../login/contractor_transaction.php" class="btn btn-info btn-md active" role="button" aria-pressed="true" style="font-size=30px;">Return to Transaction</a><br><br>
        <div class = "panel panel-danger panel-lg active">
        <form method="post" action="Retention_Transaction_Process.php" name="form_retention_add ">       
            <div class="row form-group">
                <div class="col-md-2">
                    <label class="form-label">Retention Date:</label>
                </div>
                <div class="col-md-4">
                    <input type="date" date-format="YYYY/DD/MM" name="ddate" required class="form-control"/>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Company/Contractor:</label>
                </div>
                <div class="col-md-4">
                    <select name="Link_Id" required class="form-control ">
                            <option ><?php echo isset($_POST['id'] ) && isset($_POST['Company_name']) && isset ($_POST['Representative']) ? $_POST['id']: '' ?></option>
                            <?php 
                            include '../class/db_class.php'; 
                            $sql2=mysql_query("select * from tbl_contractor ") or die(mysql_error());
                            while($row=mysql_fetch_array($sql2)){
                            ?>
                            <option value="<?php echo $row['id']  ?>"  ><?php echo $row['Company_name'] ?></option> <?php } ?>"
                        </select>                  
                </div>

                <div class="col-md-2">
                    <label class="form-label">Retention DV #:</label>
                </div>
                <div class="col-md-4">
                    <input type="text" name="dv_num_R" required class="form-control"/>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Project Title:</label>
                </div>
                <div class="col-md-4" >
                    <input type="text" name="project_name" required class="form-control" value="<?=$userdata['project_name'] ?>" />
                </div>

                <div class="col-md-2">
                    <label class="form-label">Retention amount:</label>
                </div>
                <div class="col-md-4" >
                    <input type="text" name="Retention_Amount" class="form-control"  />                   
                </div>

                <div class="col-md-2">
                    <label class="form-label">Insurance Company:</label>
                </div>
                <div class="col-md-4">
                    <input type="text" name="Insurance_company" required class="form-control"/>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Surety Bond #:</label>
                </div>
                <div class="col-md-4">
                    <input type="text" name="Surety_bond_no" class="form-control"/>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Cash Bond #:</label>
                </div>
                <div class="col-md-4">
                    <input type="text" name="ORN" class="form-control"/>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Start of Validity:</label>
                </div>
                <div class="col-md-4">
                    <input type="date" name="date_of_Receipt" required class="form-control"/>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Warranty Period:</label>
                </div>
                <div class="col-md-4">
                    <input type="text" name="Warranty_Period" required class="form-control"/>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Structure Type:</label>
                </div>
                <div class="col-md-4">
                    <input type="text" name="structureType" required class="form-control"/>
                </div>    

            </div>
            <center>   
            <input type="submit" name="submit" value="SAVE" class="btn btn-success"/>
            <input type="reset" value="CLEAR" class="btn btn-danger"/>
            </center><br>
        </form>
        </div>
            <a href="view_surety.php" class="btn btn-default btn-md active" role="button" aria-pressed="true">View Surety Bond Details</a>
            <a href="view_cash.php" class="btn btn-default btn-md active" role="button" aria-pressed="true">View Cash Bond Details</a><br><br>
            <?php
                if(isset($_SESSION['errmsg'])){
                  echo '<font color="red">'.$_SESSION['errmsg'].'</font>';
                  unset($_SESSION['errmsg']);
                }
            ?>
        <div class="panel panel-danger">
        <center><h4><strong>List of Contractor Retention</strong></h4></center>
        <form method = "POST" action = "#" name = "form_s">
            <input type = "hidden" name = "selected_retention_id" id = "selected_retention_id" />
            <input type="hidden" name="form_activity" id="form_activity" value="3" />
            <?php    
                $sql="SELECT 
                b.Link_Id, 
                a.Retention_Amount,
                b.dv_num_R,
                a.project_name,
                b.ddate,
                b.T_Id,
                ORN,
                cashbonddate,
                Surety_bond_no,
                Official_Receipt_no,
                date_of_Receipt,
                Insurance_company,
                structureType,
                b.enddate,
                c.Company_name,
                concat(if(a.Warranty_Period=1,'1 year',''),if(a.Warranty_Period=2,'2 years',''),if(a.Warranty_Period=3,'3 years',''),if(a.Warranty_Period=4,'4 years',''),if(a.Warranty_Period=5,'5 years','')) as Warranty_Period
                -- (else if(b.Warranty_Period=2,'Others',''),if(b.Warranty_Period=5,'Semi','')) as structureType
                FROM tbl_transaction a JOIN tbl_retention b on a.T_ID=b.T_Id join tbl_contractor c on b.Link_Id=c.id;";
                
                $result=mysql_query($sql);
                if($result){
                    echo "<table class = 'datatable-1 table table-striped table-bordered'>";          
                    echo"<thead>
                    <tr>
                        <th bgcolor='#F49854'><center>select</th>
                        <th bgcolor='#F49854'><center>Retention Date</th>  
                        <th bgcolor='#F49854'><center>Contractor/Company</th>
                        <th bgcolor='#F49854'><center>DV Number</th> 
                        <th bgcolor='#F49854'><center>Project Title</th>
                        <th bgcolor='#F49854'><center>Retention amount</th>

                        <th bgcolor='#F49854'><center>Insurance company</th>
                        
                        
                        <th bgcolor='#F49854'><center>Surety bond #</th>
                        
                        <th bgcolor='#F49854'><center>Cash bond #</th>
                       
                        <th bgcolor='#F49854'><center>Start of validity</th>
                        <th bgcolor='#F49854'><center>Warranty Period</th>

                        <th bgcolor='#F49854'><center>Structure Type</th>

                        <th bgcolor='#F49854'><center>End date</th>
                                
                    </tr></thead>";

                    while($row=mysql_fetch_array($result)){
                        echo'<tr>
                        <td><input type="radio" name="sel_val_rad" value="'.$row['dv_num_R'].'" onclick="setValue()"/></td>
                        <td>'.$row['ddate'].'</td>                 
                        <td>'.$row['Company_name'].'</td>
                        <td>'.$row['dv_num_R'].'</td>                      
                        <td>'.$row['project_name'].'</td>
                        <td>'.$row['Retention_Amount'].'</td>
                        
                        <td>'.$row['Insurance_company'].'</td>

                        <td>'.$row['Surety_bond_no'].'</td>
                        
                        <td>'.$row['ORN'].'</td>
                       
                        <td>'.$row['date_of_Receipt'].'</td>
                        <td>'.$row['Warranty_Period'].'</td>

                        <td>'.$row['structureType'].'</td>

                        <td>'.$row['enddate'].'</td>'.'
                        
                        </tr>';
                    }
                        echo"</table>";
                }else{
                    die(mysql_error());
                }
            ?>
            <script>
                  $(document).ready(function() {
                    $('.datatable-1').dataTable({
                    "order": [[ 3, "desc" ]]
                } );
                        
                    });
            </script>

            <?php
                if(isset($_SESSION['errmsg'])){
                  echo '<font color="red">'.$_SESSION['errmsg'].'</font>';
                  unset($_SESSION['errmsg']);
                }
            ?>
            <center>
            <input type = "button" value="EDIT" onclick="formOperation(2)" class="btn btn-info" />
            <input type = "button" value="DELETE" onclick="formOperation(3)" class="btn btn-danger" />
            <input type = "button" value="Add/Edit Surety Bond" onclick="formOperation(4)" class="btn btn-default" />
            <input type = "button" value="Add/Edit Cash Bond" onclick="formOperation(5)" class="btn btn-default" />
            </center><br><br>
        <?php
            require('../comp/pg_footer.php');
        ?>
        </div>
    </div>
</body>
</html>