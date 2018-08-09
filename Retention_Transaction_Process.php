<?php
	session_start();
	require('../login/class_retention.php');
	require('../class/db_class.php');
	$retention= new retention();
	$conn= new MySQLConnection();
	$conn->connect();

		if (isset($_POST['submit'])){
			if(isset($_POST['dv_num_R']) && isset ($_POST['ddate']) && isset ($_POST['T_Id']) && isset($_POST['Link_Id']) && isset($_POST['Insurance_company']) && isset($_POST['structureType']) && isset ($_POST['Surety_bond_no']) && isset ($_POST['ORN']) && isset ($_POST['date_of_Receipt']) && isset($_POST['Warranty_Period'])){
				if(!empty($_POST['dv_num_R']) && !empty($_POST['ddate']) && !empty($_POST['T_Id']) &&  !empty($_POST['Link_Id']) &&  !empty($_POST['Insurance_company'])  &&  !empty($_POST['structureType']) && !empty($_POST['Surety_bond_no']) && !empty($_POST['ORN']) && !empty($_POST['date_of_Receipt']) && !empty($_POST['Warranty_Period']) && isset($_GET['project_name'])){

					$dv_num_R=$_POST['dv_num_R'];
					$ddate=$_POST['ddate'];
					$Link_Id=$_POST['Link_Id'];
					$T_Id=$_POST['T_Id'];
					$structureType=$_POST['structureType'];
					$Insurance_company=$_POST['Insurance_company'];
					$Surety_bond_no=$_POST['Surety_bond_no'];    
					$ORN=$_POST['ORN'];
					$date_of_Receipt=$_POST['date_of_Receipt'];
					$Warranty_Period=$_POST['Warranty_Period'];
					$project_name=$_GET['project_name'];
					
					if($retention->checkifUsertypeExists($conn->clean_data($_POST['$Vset']))){
					
						$sql="INSERT INTO tbl_retention SET 
						dv_num_R='$dv_num_R',
						Surety_bond_no='Surety_bond_no',
						ddate='$ddate',
						project_name='$project_name', 
						T_Id='$T_Id',
						structureType='$structureType',
						Insurance_company='$Insurance_company',
						Surety_bond_no='$Surety_bond_no',
						ORN='$ORN',
						date_of_Receipt='$date_of_Receipt',
						Warranty_Period='$Warranty_Period',
						Link_Id='$Link_Id';";
						$result=mysql_query($sql);
						if($result){
							$_SESSION['infomsg']="Record Created";
							echo "records Created";
							gotoAddPage();
						}else{
								die(mysql_error());
						}
				    }else{
						$_SESSION['errmsg']="record already exists.";
						gotoAddPage();
					}
			    }else{
						$_SESSION['errmsg']="please fill in all fields.";
						gotoAddPage();
				}
			}else{
					   $_SESSION['errmsg']="error in fields";
					   gotoAddPage();
			}
		}else{
					$_SESSION['errmsg']="error inserting";
					gotoAddPage();

		}break;

		function gotoAddPage(){
			header('location:View_Retention_transaction.php');
		}
		    			
?>