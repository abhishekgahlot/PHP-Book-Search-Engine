<?php
include_once('admin/config.php');


?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">

    <title><?php echo $title; ?></title>
    <meta name="description" content="Book-Search Info">
     <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
     <link href="css/bootstrap-modal.css" rel="stylesheet" type="text/css">
     <link href="css/style.css" rel="stylesheet" type="text/css">
     <script src="js/jquery-2.0.2.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="//www.google.com/jsapi"></script>
</head>

<body>
      <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
            <div class="container">
                <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"></a> <a class="brand">Bookpedia</a>

                <div class="nav-collapse">
                    <ul class="nav">
                        <li class="active"><a href="#">Home</a></li>
                        <li><a href="admin/index.php">Admin</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class='main'>
    <div class="container well" style="padding:60px;">
        <h2>Search And Buy Books here</h2><input type="text" id="search" class="span10 search-query" placeholder="Search" required="required"> <input type="button" value="Search" id="submit" class="btn btn-primary">


  <div class='books-well'>
  		 <!-- Loader -->
  		 <div class='loader'>
	  			<center><img src="img/loader.gif">
                <h4>Loading</h4></center>
          </div>
         <div class='well'><button id="sort" class="btn btn-danger" >Sort By New Books</button></div>
		    <div id="books-well">

		    </div>
		    <div class="pagination pagination-centered">
				  <ul class="paginate">
				    <li class="active" id="1" ><a href="#">1</a></li>
				    <li id="2"><a href="#">2</a></li>
				    <li id="3"><a href="#">3</a></li>
				    <li id="4"><a href="#">4</a></li>
				    <li id="5"><a href="#">5</a></li>
				    <li id="6"><a href="#">6</a></li>
				    <li id="7"><a href="#">7</a></li>
				    <li id="8"><a href="#">8</a></li>
				    <li id="9"><a href="#">9</a></li>
				  </ul>
			 </div>
    	</div>
    </div>
  </div>

  <div id="previewModal" class="modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="booktitle">Book Preview</h3>
  </div>
  <div class="modal-body">
  		<div id="previewBody" frameborder='0' ></div>
  </div>
</div>

    <script src="js/bootstrap.min.js" type="text/javascript"></script>
    <script src="js/app.js" type="text/javascript"></script>
</body>
</html>
