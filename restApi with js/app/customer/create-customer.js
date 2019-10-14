$(document).ready(function(){
 
    // Muestra el formulario hatml cuando el botón create-customer fue clicado
    $(document).on('click', '.create-customer-button', function(){
        // load list of categories
		$.getJSON("http://localhost/api/category/read.php", function(data){
			// build categories option html
			// loop through returned list of data
			var categories_options_html="<select name='category_id' class='form-control'>";
			$.each(data.records, function(key, val){
				categories_options_html+="<option value='" + val.id + "'>" + val.name + "</option>";
			});
			categories_options_html+="</select>";
			// we have our html form here where customer information will be entered
			// we used the 'required' html5 property to prevent empty fields
			var create_customer_html= `
			<!-- 'read customers' button to show list of customers -->
			<div id='read-customers' class='btn btn-primary pull-right m-b-15px read-customers-button'>
			<span class='glyphicon glyphicon-list'></span> Read Customers</div>
			<!-- 'create customer' html form -->
	<form id='create-customer-form' action='#' method='post' border='0'>
		<table class='table table-hover table-responsive table-bordered'>
	 
			<!-- name field -->
			<tr>
				<td>Name</td>
				<td><input type='text' name='name' class='form-control' required /></td>
			</tr>
	 
			<!-- price field -->
			<tr>
				<td>Price</td>
				<td><input type='number' min='1' name='price' class='form-control' required /></td>
			</tr>
	 
			<!-- description field -->
			<tr>
				<td>Description</td>
				<td><textarea name='description' class='form-control' required></textarea></td>
			</tr>
	 
			<!-- categories 'select' field -->
			<tr>
				<td>Category</td>
				<td>` + categories_options_html + `</td>
			</tr>
	 
			<!-- button to submit form -->
			<tr>
				<td></td>
				<td>
					<button type='submit' class='btn btn-primary'>
						<span class='glyphicon glyphicon-plus'></span> Create Customer
					</button>
				</td>
			</tr>
	 
		</table>
	</form>`;
	// inject html to 'page-content' of our app
	$("#page-content").html(create_customer_html);
 
	// chage page title
	changePageTitle("Create Customer");
		});
    });
 
    // will run if create customer form was submitted
	$(document).on('submit', '#create-customer-form', function(){
		// get form data
		var form_data=JSON.stringify($(this).serializeObject());
		// submit form data to api
		$.ajax({
			url: "http://localhost/api/customer/create.php",
			type : "POST",
			contentType : 'application/json',
			data : form_data,
			success : function(result) {
				// customer was created, go back to customers list
				showCustomers();
			},
			error: function(xhr, resp, text) {
				// show error to console
				console.log(xhr, resp, text);
			}
		});
		return false;
	});
});