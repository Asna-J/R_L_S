<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */


if (isset($_POST['submit'])) {
    require "../config.php";
    require "../common.php";

    try  {
        $connection = new PDO($dsn, $username, $password, $options);
        
        $new_user = array(
            "Username" => $_POST['username'],
            "Name"  => $_POST['name'],
            "Email"     => $_POST['email'],
            "Password"  => $_POST['pass'],
            "Mobile"  => $_POST['mobile']
        );
		//SERVER SIDE
		$x=0;
		 
		
			if($_POST['username']=="")
			{
				echo "Username is not entered <br>";
				$x++;
			}
	       
			
			if(preg_match("/^[a-zA-Z -]+$/",$_POST['name'])===0)
			{
				echo "name is not entered <br>";
				$x++;
			}
			if($_POST['email']=="")
			{
				echo "Email is not entered <br>";
				$x++;
			}
			 if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
			{//
		    }
			
			else {
		
				echo "Email is not Valid <br>";
				$x++;
			}
			if($_POST['pass']=="")
			{
				echo "password entered <br>";
				$x++;
			}
			
			if($_POST['mobile']=="")
			{
				echo "enter the mobile no<br>";
				$x++;
			}
			 else if(!is_numeric($_POST['mobile']))
			{
				echo"Invalid mobile number,Check it is number <br>";
				$x++;
			}
	
		$sql = "SELECT * FROM customer WHERE Username = :username";
        $statement= $connection->prepare($sql);
        $statement->bindValue(':username',$_POST['username']);
         $statement->execute();

		 if($row = $statement->fetch(PDO::FETCH_ASSOC)) 
		 {
			$usernameExists = 1;
		 } 
		 else 
		 {
			$usernameExists = 0;
		 }
		 $statement->closeCursor();
		 if ($usernameExists) 
		 {
		   echo "Username already Exist";
		   $x++;
		 }	
			
      
		$sql = "SELECT * FROM customer WHERE email = :email";
        $statement= $connection->prepare($sql);
        $statement->bindValue(':email',$_POST['email']);
         $statement->execute();

		 if($row = $statement->fetch(PDO::FETCH_ASSOC)) 
		 {
			$usernameExists = 1;
		 } 
		 else 
		 {
			$usernameExists = 0;
		 }
		 $statement->closeCursor();
		 if ($usernameExists) 
		 {
		   echo "Email already Exist";
		   $x++;
		 }
        		  
		if($x<1)
		{
        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "customer",
                implode(", ", array_keys($new_user)),
                ":" . implode(", :", array_keys($new_user))
        );
        
		
        $statement = $connection->prepare($sql);
        $statement->execute($new_user);
		}
		else
		{
			echo "ENTERED DETAILS ARE INCORRECT";
		}
		 
	}
	catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    } 
	
	
}

?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) { ?>
    <blockquote><?php echo $_POST['name']; ?> successfully added.</blockquote>
<?php } ?>

<h2>Add a user</h2>

<script>
//CLIENT SIDE

function validate()
{
	var Uname=document.forms["register"]["username"].value;
	if(Uname=="")
	{
	 	alert("Enter your Username");
		document.forms["register"]["username"].focus();
		return false;
	}
	
	var name=document.forms["register"]["name"].value;
	if(name=="")
	{
		alert("Enter your Name");
		document.forms["register"]["name"].focus();
		return false;
	}
	
	var eml=document.forms["register"]["email"].value;
	var atposition=eml.indexOf("@");  
	var dotposition=eml.lastIndexOf(".");  
	if(eml=="")
	{
		alert("Enter your email");
		document.forms["register"]["email"].focus();
		return false;
	}
	if (atposition<1 || dotposition<atposition+2 || dotposition+2>=eml.length)
	{
		alert("please check the format of email joe@gmail.com");
		document.forms["register"]["email"].focus();
		return false;
	}
	var mob = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/;
     if((inputtxt.value.match(mob))
        {
			alert("invalid phone number");
			document.forms["register"]["email"].focus();
        return false;
		}
	  else if(mob=="")
	{
	 	alert("Enter your Mobile no");
		document.forms["register"]["mobile"].focus();
		return false;
	}
	var pass=document.forms["register"]["pass"].value;
	if(pass=="")
	{
		alert("Enter your password");
		document.forms["register"]["pass"].focus();
		return false;
	}
	
return true;
	

}
</script>


<form method="post" onsubmit="return validate()" name="register">
    <label for="Username">Username</label>
    <input type="text" name="username" id="username">
    <label for="text">Name</label>
    <input type="text" name="name" id="name">
    <label for="email">Email Address</label>
    <input type="text" name="email" id="email">
    <label for="pass">Password</label>
    <input type="text" name="pass" id="pass">
    <label for="mobile">Mobile</label>
    <input type="text" name="mobile" id="mobile">
    <input type="submit" name="submit" value="Submit">
</form>

<a href="log.php">Login</a>

<?php require "templates/footer.php"; ?>
