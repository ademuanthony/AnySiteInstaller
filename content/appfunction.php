<?php 
	include("connect.php");

/*	//this will save u from server wahala
	if(!isset($_SESSION))
	{
		session_start();
	}
*/
	//handle login

	if (isset($_POST["login"]) && $_POST["login"]=="1" ) 
	{

		$sql = "SELECT * FROM users WHERE Username = '".$_POST["Username"]."' && Password = '".$_POST["Password"]."' ";
		$query = mysql_query($sql, $connect) or die("Could not fetch records");
		$row = mysql_fetch_assoc($query);

		//mysql_num_rows indicates that the mysql query was executed and that results were found
		if(mysql_num_rows($query)<1)
		{
			$msg = "<div class='alert alert-dismissable alert-danger'><button class='close' data-dismiss='alert'>&times;</button>
						Sorry, the username or password you entered is incorrect!
					</div>";
		}
		else
		{	
			
			$_SESSION["firstname"] = $row["Firstname"]; 
			$_SESSION["email"] =  $row["Email"];
			$_SESSION["duid"] = $row["ID"];
			$_SESSION["picture"] = $row["Picture"];
			$_SESSION["AccessLevel"] = $row["AccessLevel"];
			//header("Location: AccessLevel.php");

			//move user to admin
			/*if($_SESSION["AccessLevel"]=="1")
			{
				header("Location: dashboard.php");
			}
			//move to member
			else if($_SESSION["AccessLevel"]=="2")
			{
				header("Location: member.php");
			}
			else if(isset($_SESSION["AccessLevel"]) && $_SESSION["AccessLevel"]="3"){

				$msg = "<div class='alert alert-danger alert-dismissable' align = 'center'>
						<button class='close' data-dismiss='alert'>&times;</button>
						
						<p>You have been block from using this forum due to rule violation </p>
					</div>";

				}
			*/
		}

	}




	//handles signup page

	if (isset($_POST["INSERT"]) && $_POST["INSERT"]=="1" )
	
		{
			$firstname = $_POST["first_name"]; 
			$lastname= $_POST["last_name"]; 
			$email = $_POST["email"];
			$phone = $_POST["phone"];
			$fax = $_POST["fax"];
			$company = $_POST["company"];
			$companyid = $_POST["company_id"];
			$address = $_POST["address"];
			$address2 = $_POST["address2"];
			$city = $_POST["city"];
			$postcode = $_POST["postcode"];
			$contury = $_POST["contury"];
			$region = $_POST["region"];
			$password = $_POST["password"];
			$password_again = $_POST["password_again"];
			$activationLink = md5(uniqid($email,true));
			

			
			//sql to check if user already exists

			$sql = "SELECT * FROM users WHERE email = '$email' ";
			$query = mysql_query($sql, $connect) or die("could not fetch records");
			if(mysql_num_rows($query) ==0)
			{
			    //sql to insert new user record
				$sql = "INSERT INTO users (first_name, last_name, email, phone, fax, company,company_id , address, address2, city, post_code , contury, region,password,password_again,access_level, active_status, activationLink)
						 VALUES ('".$firstname."', '".$lastname."', '".$email."', '".$phone."', '".$fax."', '".$company."', '".$companyid."',
						 		'".$address."', '".$address2."', '".$city."', '".$post_code."','".$contury."','".$region."','".$password."','".$password_again."', '1', '2', $activationLink ) ";

				$query = mysql_query($sql, $connect) or die("could not insert records". mysql_error());

				$the_id_of_record = mysql_insert_id(); //this is the id of the record that was just inserted

				if(!$query)
				{
					$msg = "<div class='alert alert-danger alert-dismissable'>
								<button class='close' data-dismiss='alert'>&times;</button>
								<p>Sorry! Your signup was not successful. Please try again later!</p>

							</div>";
				}

				else
				{
					//session holds a value and persists it across all pages of the application
					$_SESSION["firstname"] = $firstname; 
					$_SESSION["email"] =  $email;
					$_SESSION["duid"] = $the_id_of_record;


					//send activation link to user
					SendMail($email, //to
							 "Your Activation Link at www.forum.com", //subject
							 "Hello $Firstname, \n\n 
							  Thank you for signing up at www.forum.com. Please click this activation link to activate your account.\n\n
							  <a href='www.forum.com/confirmemail.php?email=".$email."'&aclink='".$ActivationLink."' "); //message

					$msg = "<div class='alert alert-success alert-dismissable'>
								<button class='close' data-dismiss='alert'>&times;</button>
								<p>Congratulations $firstname! Your signup was successful. We have sent you an email containing an activation link
								, Please check your email inbox and click the activation link to activate your account.</p>

							</div>";
				}
			}
			else
			{
				//i counted something
						$msg = "<div class='alert alert-danger alert-dismissable'>
									<button class='close' data-dismiss='alert'>&times;</button>
									<p>Sorry! The username you specified is already in use by another member, please enter another!</p>

								</div>";
			}
		}
	


	//handle adding of products

	if(isset($_POST["INSERT"]) && $_POST["INSERT"]=="2")
	{ 
		$mfile = $_FILES["product_pictures"]["size"];
		$processform = 0;


		if(isset($mfile))
		{
			//if picture is greater than 50kb i.e 1kb = 1024 bytes therefore 50kb = 50*1024 bytes
			if($mfile > (50*1024))
			{	
				$msg = "<div class='alert alert-dismissable alert-danger'><button class='close' data-dismiss='alert'>&times;</button>
							The File you uploaded is too large. maximum size allowed is 50kb!
						</div>";
				$processform = 0;
			}
			else
			{
				$processform =1;
			}
		}

		//process the form if successful
		if($processform==1)
		{

			$product_name = $_POST["product_name"];
			$product_price = $_POST["product_price"];
			$product_description = $_POST["product_description"];
			$product_pictures = $_FILES["product_pictures"]["name"];

			if(isset($product_pictures))
				{
					$product_pictures = $_FILES["product_pictures"]["name"];
					move_uploaded_file($_FILES["product_pictures"]["tmp_name"], "img/preview/product/".$product_pictures );
				}
				else
				{
					$product_pictures ="";
				}

			//check if product name already exists
			$sql = "SELECT * FROM products WHERE product_name = '$product_name' ";
			$query = mysql_query($sql, $connect) or die("Could not fetch records");
			if(mysql_num_rows($query)>0)
			{
				$row = mysql_fetch_assoc($query);
				$msg = "<div class='alert alert-danger alert-dismissable'>
							<button class='close' data-dismiss='alert'>&times;</button>
							<p>Sorry! This topic already exists, please enter another product or modify the product name.</p>
						</div>"; 
			}
			else 
			{
				$sql ="INSERT INTO products (product_name, product_price, product_description, product_pictures)
						VALUES ('$product_name,'$product_price', '$product_description', '$product_pictures')";

				//	echo $sql;

				$query = mysql_query($sql, $connect) or die("Could not insert records");
				if(!$query)
				{
					$msg = "<div class='alert alert-danger alert-dismissable'>
										<button class='close' data-dismiss='alert'>&times;</button>
										<p>Sorry! The product could not be added at this time! Please try again later.</p>

							</div>";
				}
				else
				{
					$msg = "<div class='alert alert-success alert-dismissable'>
										<button class='close' data-dismiss='alert'>&times;</button>
										<p>Done! The Product was added successfully.</p>

							</div>";
				}
			}
		}
	}



	//handles editing signup details

	if(isset($_POST["INSERT"]) && $_POST["INSERT"]=="3")
	{ 
		$mfile = $_FILES["product_pictures"]["size"];
		$processform = 0;


		if(isset($mfile))
		{
			//if picture is greater than 50kb i.e 1kb = 1024 bytes therefore 50kb = 50*1024 bytes
			if($mfile > (3200*4000))
			{	
				$msg = "<div class='alert alert-dismissable alert-danger'><button class='close' data-dismiss='alert'>&times;</button>
							The File you uploaded is too large. maximum size allowed is 50kb!
						</div>";
				$processform = 0;
			}
			else
			{
				$processform =1;
			}
		}

		//process the form if successful
		if($processform==1)
		{
			$product_name = $_POST["product_name"];
			$product_price = $_POST["product_price"];
			$product_description = $_POST["product_description"];
			$product_pictures = $_FILES["product_pictures"]["name"];

			if(isset($product_pictures))
				{
					$product_pictures = $_FILES["product_pictures"]["name"];
					move_uploaded_file($_FILES["product_pictures"]["tmp_name"], "img/preview/product/".$product_pictures );
				}
				else
				{
					$product_pictures ="";
				}


			$sql = "UPDATE product SET   product_name = '".$product_name."', 
										 product_price = '".$product_price."', 
										 product_descriptio = '".$product_descriptio."', 
										 product_pictures = '".$product_pictures."', 

										 WHERE id = '".$_POST["UPDATE_PRODUCT"]."'

										  ";

			$query = mysql_query($sql, $connect) or die("could not insert records");

			$the_id_of_record = mysql_insert_id(); //this is the id of the record that was just updated

			if(!$query)
			{
				$msg = "<div class='alert alert-danger alert-dismissable'>
							<button class='close' data-dismiss='alert'>&times;</button>
							<p>Sorry! Your update was not successful. Please try again later!</p>

						</div>";
			}

			else
			{
				
				$msg = "<div class='alert alert-success alert-dismissable'>
							<button class='close' data-dismiss='alert'>&times;</button>
							<p>Congratulations $firstname! Your product update were saved sucessfully. </p>

						</div>";
			}
		}
	}






	//function to send mail
	function SendMail($to, $subject, $message)
	{
		$from = "ForumWebsite<info@forum.com>";
		mail($to, $subject, $message, $from);

	}


	//function to get users name from CreatedBy
	function GetTheUserFromCreatedBy($createdbyid)
	{
		global $connect;
		$sql = "SELECT * FROM USERS WHERE ID = '$createdbyid' ";
		$query = mysql_query($sql, $connect) or die("could not fetch records");
		$row = mysql_fetch_assoc($query);

		return $row["Firstname"] . " " . $row["Surname"];

	}

	//function to count categories
	function CountCategories()
	{
		global $connect;
		$sql = "SELECT COUNT(ID) as TotalCount FROM categories  ";
		$query = mysql_query($sql, $connect) or die("could not fetch records");
		$row = mysql_fetch_assoc($query);
		return $row["TotalCount"];
	}

	//function to count topices
	function Counttopics()
	{
		global $connect;
		$sql = "SELECT COUNT(ID) as TotalCount FROM topics  ";
		$query = mysql_query($sql, $connect) or die("could not fetch records");
		$row = mysql_fetch_assoc($query);
		return $row["TotalCount"];
	}


	//function to show category from id
	function ShowCategoriesFomID($getcategory)
	{
		global $connect;
		$sql = "SELECT Category FROM categories WHERE ID = '$getcategory' ";
		$query = mysql_query($sql, $connect) or die("could not fetch records");
		$row = mysql_fetch_assoc($query);
		return $row["Category"];
	}

	function GetUserPicture($theuserid)
	{
		global $connect;
		$sql ="SELECT * FROM users WHERE ID = '$theuserid' ";
		$query = mysql_query($sql, $connect) or die ("error occoured");
		$row = mysql_fetch_assoc($query);

		if($row["Picture"]=="")
		{
			return "<img src='images/default_large.png' width='80' height='80' class='pull-left thumbnail' style='margin-right:10px;'>";
		}
		else
		{
			return "<img src='profilepics/".$row["Picture"]."' width='80' height='80' class='pull-left thumbnail'  style='margin-right:10px;'>";
		}
	}

	//function to count specific topics from a particular ID
	function CountSpecifictopics($thecategoryid)
	{
		global $connect;
		$sql = "SELECT COUNT(ID) as TotalCount FROM topics WHERE Category = '$thecategoryid'  ";
		$query = mysql_query($sql, $connect) or die("could not fetch records");
		$row = mysql_fetch_assoc($query);
		return $row["TotalCount"];
	}

?>