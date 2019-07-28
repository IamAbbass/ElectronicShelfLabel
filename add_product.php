<!DOCTYPE html>		
<html>

<?php 
  include "header.php";
 ?>
<body>
	<div class="d-flex" id="wrapper">

    <!-- Sidebar -->
    <?php 
      include "sidebar.php";
     ?>
    <!-- /#sidebar-wrapper -->

    <!-- Page Content -->
    <div id="page-content-wrapper">

		<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
			<button class="navbar-toggler-icon btn btn-default" id="menu-toggle"></button>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
		</nav>

		<div class="container-fluid">
	        <h2 class="mt-3">Add Products</h2>
	        <div>
	        	<div>
			  		<div id="message" class="alert "></div>
			  	</div>
		        <form class="row">
				  	<div class="form-group col-md-3">
					    <label for="">Product Name</label>
					    <input type="text" class="form-control" id="name" name="name" placeholder="Apple sidra">
				  	</div>
				  	<div class="form-group col-md-3">
					    <label for="">Product Price</label>
					    <input type="number" class="form-control" id="price" name="price" placeholder="123">
				  	</div>
				  	<div class="form-group col-md-3">
				    	<label for="">Discount</label>
				    	<input type="number" class="form-control" id="discount" name="discount" placeholder="10">
				  	</div>
				    <div class="form-group col-md-3">
					    <label for="">Expiry Date</label>
					    <input type="date" class="form-control" name="date" id="date">
				  	</div>
				  	<div class="ml-3">
				  		<button type="submit" class="btn btn-primary" id="">Add Product</button>
				  	</div>
				</form>
	        </div>
		</div>
		
    </div>

    <!-- /#page-content-wrapper -->


  </div>
	<script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Menu Toggle Script -->
  <script>
  	
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });

    $('form').on('submit',function(e){
    	e.preventDefault();
    	$data = $(this).serializeArray();
    	$.post('product.php?',{ data : $data , 'action' : 'insert' },function(data){
			console.log(data);
			if(data !== ''){
				$("#message").removeClass("alert-danger").addClass("alert-success")
             	.html("Successfully Inserted!").hide().fadeIn();
             	setInterval(function(){$("#message").fadeOut(); }, 2000);
             	$('#name,#price,#discount,#date').val("");
			}
			else{
				$("#message").removeClass("alert-success").addClass("alert-danger")
             	.html("Not Inserted. Please try again").hide().fadeIn();
             	setInterval(function(){$("#message").fadeOut(); }, 2000);
			}

    	});

    });	


  </script>
</body>

</html>

