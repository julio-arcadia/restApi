$(document).ready(function(){
	// Mostrar formulario HTML cuando el botón 'actualizar customer' fue clicado 
	$(document).on("click",".update-customer-button", function(){
		// Obtener la ID del customer
		var id = $(this).attr("data-id");
		// Leer los resultados basados en la id del customer
		$.getJSON("http://localhost/api/customer/read_one.php?id=" + id, function(data){
			// Valores que se usaran para completar nuestro formulario
			var firstName = data.firstName;
			var lastName = data.lastName;
			var username = data.username;
			// var password = data.password;
			var country = data.country;
			var region = data.region;
			var city = data.city;
			var address = data.address;
			
			// Almacenamos el html de 'update customer' en una variable
			var update_customer_html= `
    <div id='read-customers' class='btn btn-primary pull-right m-b-15px read-customers-button'>
        <span class='glyphicon glyphicon-list'></span> Read Customers
    </div>
	<!-- Construímos 'update customer' formulario en HTML  -->
	<!-- Usamos la propiedad 'required' de HTML5 para prevenir los campor vacíos -->
	<form id='update-customer-form' action='#' method='post' border='0'>
		<table class='table table-hover table-responsive table-bordered'>
	 
			<!-- firstName field -->
			<tr>
				<td>FirstName</td>
				<td><input value=\"` + firstName + `\" type='text' name='firstName' class='form-control' required /></td>
			</tr>
	 
			<!-- lastName field -->
			<tr>
				<td>LastName</td>
				<td><input value=\"` + lastName + `\" type='text' name='lastName' class='form-control' required /></td>
			</tr>
			
			<!-- username field -->
			<tr>
				<td>Username</td>
				<td><input value=\"` + username + `\" type='text' name='username' class='form-control' required /></td>
			</tr>
			
			<!-- PASSWORD field?? -->
			
			<!-- country field -->
			<tr>
				<td>Country</td>
				<td><input value=\"` + country + `\" type='text' name='country' class='form-control' required /></td>
			</tr>
			
			<!-- region field -->
			<tr>
				<td>Region</td>
				<td><input value=\"` + region + `\" type='text' name='region' class='form-control' required /></td>
			</tr>
			
			<!-- city field -->
			<tr>
				<td>City</td>
				<td><input value=\"` + city + `\" type='text' name='city class='form-control' required /></td>
			</tr>
			
			<!-- address field -->
			<tr>
				<td>Address</td>
				<td><input value=\"` + address + `\" type='text' name='address' class='form-control' required /></td>
			</tr>

			<tr>
	 
				<!-- hidden 'product id' to identify which record to delete -->
				<td><input value=\"` + id + `\" name='id' type='hidden' /></td>
	 
				<!-- Botón para enviar el formulario -->
				<td>
					<button type='submit' class='btn btn-info'>
						<span class='glyphicon glyphicon-edit'></span> Update customer
					</button>
				</td>
	 
			</tr>
	 
		</table>
	</form>`;

	// Insertamos al 'page-content' de nuestra appCodeName
	$("#page-content").html(update_customer_html);
	// Cambiar título de la página
	changePageTitle("Update Customer");

		});
	});
	// Se ejecutará si el formulario 'create customer' fue enviado
	$(document).on("submit", "#update-customer-form", function(){
		// Obtener datos del formulario
		var form_data=JSON.stringify($(this).serializeObject());
		// Enviamos los datos del formulario a la API
		$.ajax({
			url: "http://localhost/api/customer/update.php",
			type : "POST",
			contentType : "application/json",
			data : form_data,
			success : function(result){
				// Customer fue creado, vamos atrás a la lista de customers
				showCustomers();
			},
			error: function(xhr, resp, text){
				// Mostramos error por consola
				console.log(xhr, resp, text);
			}
		});
		
		return false;
	}); 
});

