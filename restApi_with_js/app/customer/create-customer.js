$(document).ready(function(){
 
    // Muestra el formulario hatml cuando el botón create-customer fue clicado
    $(document).on('click', '.create-customer-button', function(){
                	// we have our html form here where customer information will be entered
			// we used the 'required' html5 property to prevent empty fields
                        
			var create_customer_html= `
			<!-- 'read customer' button to show list of customer -->
			<div id='read-customer' class='btn btn-primary pull-right m-b-15px read-customer-button'>
			<span class='glyphicon glyphicon-list'></span> Read Customers</div>
			<!-- 'create customer' html form -->
	<form id='create-customer-form' action='#' method='post' border='0'>
		<table class='table table-hover table-responsive table-bordered'>
	 
			<!-- firstName field -->
			<tr>
				<td>firstName</td>
				<td><input type='text' firstName='firstName' class='form-control' required /></td>
			</tr>
        
                        <!-- lastName field -->
			<tr>
				<td>lastName</td>
				<td><input type='text' lastName='lastName' class='form-control' required /></td>
			</tr>
        
                        <!-- username field -->
			<tr>
				<td>username</td>
				<td><input type='text' username='username' class='form-control' required /></td>
			</tr>  
        
                        <!-- password field -->
			<tr>
				<td>password</td>
				<td><input type='password' password='password' class='form-control' required /></td>
			</tr>
	 
			<!-- Country field -->
			<tr>
				<td>country</td>
				<td><input type='text' country='country' class='form-control' required /></td>
			</tr>
        
                        <!-- Region field -->
			<tr>
				<td>Region</td>
				<td><input type='text' region='region' class='form-control' required /></td>
			</tr> 
        
                        <!-- City field -->
			<tr>
				<td>City</td>
				<td><input type='text' city='city' class='form-control' required /></td>
			</tr> 
        
                        <!-- Address field -->
			<tr>
				<td>Address</td>
				<td><input type='text' address='address' class='form-control' required /></td>
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
 
	// change page title
	changePageTitle("Create Customer");
		});
    });
 
    // will run if create customer form was submitted
	$(document).on('submit', '#create-customer-form', function(){
		// get form data
		var form_data=JSON.stringify($(this).serializeObject());
		// submit form data to api
		$.ajax({
			url: "http://localhost/restApi_with_js/api/customer/create.php",
			type : "POST",
			contentType : 'application/json',
			data : form_data,
			success : function(result) {
				// customer was created, go back to customer list
				showCustomer();
			},
			error: function(xhr, resp, text) {
				// show error to console
				console.log(xhr, resp, text);
			}
		});
		return false;
	});
