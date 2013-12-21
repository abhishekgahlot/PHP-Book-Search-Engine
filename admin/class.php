<?php


if(isset($_SESSION['username'])){


	class OverWrite{

		private $title;
		private $amazon_id;
		private $password;
		private $username;
		private $api_key;

		function Write($title,$amazon_id,$password,$username,$api_key){

			$this->title=$title;

			$this->amazon_id=$amazon_id;

			$this->password=$password;

			$this->username=$username;

			$this->api_key=$api_key;


			if(!empty($_POST['title'])){

				$this->title=$_POST['title'];

			}
			if(!empty($_POST['newpassword'])){

				$this->password=$_POST['newpassword'];


			}
			if(!empty($_POST['amazon_id'])){

				$this->amazon_id=$_POST['amazon_id'];

			}

			if(!empty($_POST['api_key'])){

				$this->api_key=$_POST['api_key'];

			}


			$data = '<?php /* Dont Enter Anything Here!  */  $password="'.$this->password.'"; $amazon_id="'.$this->amazon_id.'"; $username="'.$this->username.'"; $title="'.$this->title.'"; $api_key="'.$this->api_key.'";  ?>';

			file_put_contents('config.php', $data);


		}

	}

}


if(!empty($_POST['username'])&&!empty($_POST['password']))
{
	if($_POST['username']===$username&&$_POST['password']===$password){
		$_SESSION['username']=$username;

	}else{

		header('Location:index.php?error');
	}

}
if(isset($_GET['logout'])){
	unset($_SESSION['username']);
	header('Location:index.php');
	exit;
}

if(isset($_POST['update'])){

	if (is_writable('config.php')) {

			$object=new OverWrite;
			$object->Write($title,$amazon_id,$password,$username,$api_key);
			header("Location:index.php?updated");

			} else {
				header('Location:index.php?file-error');
			}
}



?>