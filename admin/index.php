<?php
session_start();
include 'config.php';
include 'class.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title><?php echo $title; ?></title>
    <meta name="description" content="Book-Search Info">
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
     <link href="../css/style.css" rel="stylesheet" type="text/css">
    <script src="../js/jquery-2.0.2.min.js" type="text/javascript">
</script>
</head>

<body>
      <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"></a> <a class="brand" href="#">Bookpedia</a>
                <div class="nav-collapse">
                    <ul class="nav">
                        <li><a href="../index.php">Home</a></li>
                        <li class="active"><a href="#">Admin</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="container well" style="padding:60px;">
    <h2>Admin Panel</h2>
  	  	<div class='well'>

	  	  	<?php if(isset($_SESSION['username'])&&$_SESSION['username']==='admin'){ ?>

	  	  			<h4>Update Details Here</h4>
	  	  			<a href='index.php?logout' class='pull-right btn btn-danger logout'>Logout</a>

	  	  			<?php if(isset($_GET['updated'])){ echo '<div class="alert alert-success"><h5><center>Updated Successfully!</center></h5></div>'; }

	  	  			if(isset($_GET['file-error'])){ echo '<div class="alert alert-danger"><h5><center>Error :
	  	  			 Config.php is not writable. Please Change Its Permission to 777.</center></h5></div>'; }


	  	  			?>

	  	  			<form action="index.php" method="post" class="admin" >

		  	  			<label class='admin'>Change Website Title Here</label>
	  	  			<input type="text" class="span5" placeholder="<?php echo $title; ?>" name="title">

	  	  			<label class='admin'>Username</label>
	  	  			<input type="text" class="span5" placeholder="<?php echo $username; ?>" disabled>

	  	  			<label class='admin'>Change Password Here</label>
	  	  			<input type="text" class="span5" placeholder="Change Password" name="newpassword">

	  	  			<label class='admin'>Enter Google API Key</label>
	  	  			<input type="text" class="span5" placeholder="<?php echo $api_key; ?>" name="api_key">
	  	  			<br/>

	  	  			<label class='admin'>Enter Amazon Id Here</label>
	  	  			<input type="text" class="span5" placeholder="<?php echo $amazon_id; ?>" name="amazon_id">
	  	  			<br/>
	  	  			<input type="hidden" name="update">
	  	  			<input type="submit"  class="btn btn-inverse" value="Update">

	  	  			</form>

	 	<?php }else{

		  	  	if(isset($_GET['error'])){ echo '<div class="alert alert-danger"><h5><center>Wrong Username And Password</center></h5></div>'; }

	  	  	 ?>

		  	    <form method="post" action="index.php" >
			        <h3>Please sign in</h3>
			        <input type="text" name="username" class="span4" placeholder="Username">
			        <input type="password"  name="password" class="span4" placeholder="Password">
			        <button class="btn btn-primary login"  type="submit">Sign in</button>
			    </form>

	  	  	<?php } ?>

	  	  </div>
  </div>

  <script src='../js/app.js' type="text/javascript"></script>
    </div><script src="../js/bootstrap.min.js" type="text/javascript">
</script>
</body>
</html>
