<?php
	require_once('dbconfig.php');
	require_once('function.php');


	$tableName = 'add_product';

	$getData = get($tableName);

?>


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
	      
	        <h2 class="mt-4">View Products</h2>
	        <div class="">
		  		<div id="message" class="alert mb-10"></div>
		  	</div>
	        <div class="mt-2">
		       	<table class="table table-striped table-responsive-lg" id="myTable">
				  	<thead>
					    <tr>
					      <th scope="col">ID#</th>
					      <th scope="col">Product Name</th>
					      <th scope="col">Price</th>
					      <th scope="col">Discount</th>
					      <th scope="col">Expiry Date</th>
					      <th scope="col">ESL MAC</th>
					      <th scope="col">Action</th>
					    </tr>
				  	</thead>
				  	<tbody>
				  		<?php 
				  			foreach ($getData as $key => $value) {
				  		 ?>
					    <tr id="<?= $value['id']?>">
					      <th scope="row"><?=$value['id']?></th>
					      <td><?=$value['name']?></td>
					      <td><?=$value['price']?></td>
					      <td><?=$value['discount']?></td>
					      <td><?= !empty($value['expiry_date']) && $value['expiry_date'] !='0' ? date('d-m-Y',$value['expiry_date']) :'' ?></td>
					      <td> 
					      	<?= !empty($value['esl_mac']) ? '<span class="badge badge-info">'.$value['esl_mac'].'</span>' : "Not Displayed"?> </td>
					      <td>
					      <a class="delete-item btn btn-sm btn-danger" href="#" data-id="<?= $value['id'] ?>"><i class="la la-trash-o"></i> Delete</a></td>
					    </tr>

					    <?php 
					    	}
					     ?>
				  	</tbody>
				</table>
	        </div>
		</div>
    </div>

    <!-- /#page-content-wrapper -->

  </div>
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" charset="utf8" src="vendor/js/jquery.dataTables.min.js"></script>

  <!-- Menu Toggle Script -->
  <script>
  	$(document).ready( function () {
    	$('#myTable').DataTable();
	});
   $('canvas').hide();
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });

    $('.delete-item').on('click',function(){

    	$id = $(this).attr('data-id');
    	
    	var x = confirm("Are you sure you want to delete?");
		if (x){
			$.get('product.php?id='+$id+'&action=delete',function(data){
    			console.log(data);
	    		if (data != '' ) {
	    			$("#message").removeClass("alert-danger").addClass("alert-success")
	             	.html("Successfully Deleted").hide().fadeIn();
	             	setInterval(function(){$("#message").fadeOut(); }, 2000);
	             	$("#"+$id).fadeOut();
	    		}
	    		else{
	    			$("#message").removeClass("alert-success").addClass("alert-danger")
	             	.html("Something went wrong").hide().fadeIn();
	             	setInterval(function(){$("#message").fadeOut(); }, 2000);	
	    		}
    		});
		}

    });


  </script>
</body>

</html>

