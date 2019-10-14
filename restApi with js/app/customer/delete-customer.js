$(document).ready(function(){
	//Se ejecuta si el botón delete fue clicado
	$(document).on("click",".delete-customer-button", function(){
		// Obtenemos la id del customer
		var customer_id = $(this).attr("data-id");
		// bootbox "confirm pop up"
		bootbox.confirm({
			message: "<h4>¿Estás seguro?</h4>",
			buttons: {
				confirm: {
					label: "<span class='glyphicon glyphicon-ok'></span> Si",
					className: "btn-primary"
				},
				cancel: {
					label: "<span class='glyphicon glyphicon-remove'></span> No",
					classname: "btn-primary"
				}
			},
			callback: function (result){
				if(result==true){
					// Enviamos la consulta a la API
					$.ajax({
						url: "http://localhost/api/customer/delete.php",
						type: "POST",
						dataType: "json",
						data: JSON.stringify({ id: customer_id}),
						succes : function(result){
							// recargamos lista de customers
							showCustomers();		
						},
						error: function(xhr, resp, text){
							console.log(xhr, resp, text);
						}
					});
					
				}
			}			
		});
	});
	
});


