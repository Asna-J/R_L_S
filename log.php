<?php
session_start();
$uname=$_POST['email'];
$_session['email']=$uname;
if (isset($_POST['submit'])) {
    
        
        require "../config.php";
        require "../common.php";
        try  {
        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "SELECT * 
                        FROM customer
                        WHERE Email= :email and Password= :pass";

        $email = $_POST['email'];
        $pass = $_POST['pass'];
        $statement = $connection->prepare($sql);
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
		 $statement->bindParam(':pass', $pass, PDO::PARAM_STR);
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
			 
		   echo "Login Sucessfully ";
		   echo $_session['email'];
		 }
		 else
		 {
			 echo "Incorrect email and password"; 
		 } 

    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>
		

<?php if (isset($_POST['login']) && $statement) { ?>
    <blockquote><?php echo $_POST['name']; ?> successfully added.</blockquote>
<?php } ?>



<h2>Login</h2>
<form method="post" >
    <label for="email">Email Address</label>
    <input type="text" name="email" id="email">
    <label for="pass">Password</label>
    <input type="text" name="pass" id="pass">
	<input type="submit" name="submit" value="login">
    
</form>

