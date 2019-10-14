$(document).ready(function(){
 
    // show list of customer on first load
    showCustomer();
 // when a 'read customer' button was clicked
$(document).on('click', '.read-customer-button', function(){
    showCustomer();
});
});
 
// function to show list of customer
function showCustomer(){
 // get list of customer from the API
$.getJSON("http://localhost/api/customer/read.php", function(data){
 // html for listing customer
var read_customer_html=`
    <!-- when clicked, it will load the create customer form -->
    <div id='create-customer' class='btn btn-primary pull-right m-b-15px create-customer-button'>
        <span class='glyphicon glyphicon-plus'></span> Create Customer
    </div>  
    <!-- start table -->
<table class='table table-bordered table-hover'>
 
    <!-- creating our table heading -->
    <tr>
        <th class='w-10-pct'>firstName</th>
        <th class='w-10-pct'>lastName</th>
        <th class='w-10-pct'>username</th>
        <th class='w-10-pct'>country</th>
        <th class='w-10-pct'>region</th>
        <th class='w-10-pct'>city</th>
        <th class='w-10-pct'>customerID</th>
        <th class='w-25-pct text-align-center'>Action</th>
    </tr>`;
     
    // loop through returned list of data
$.each(data.records, function(key, val) {
 
    // creating new table row per record
     read_customers_html+=`
        <tr>
 
            <td>` + val.firstName + `</td>
            <td>$` + val.lastName + `</td>
            <td>` + val.username + `</td>
            <td>` + val.country + `</td>
            <td>` + val.region + `</td>
            <td>` + val.city + `</td>
            <td>` + val.customerID + `</td>
 
            <!-- 'action' buttons -->
            <td>
                <!-- read customer button -->
                <button class='btn btn-primary m-r-10px read-one-customer-button' data-id='` + val.id + `'>
                    <span class='glyphicon glyphicon-eye-open'></span> Read
                </button>
 
                <!-- edit button -->
                <button class='btn btn-info m-r-10px update-customer-button' data-id='` + val.id + `'>
                    <span class='glyphicon glyphicon-edit'></span> Edit
                </button>
 
                <!-- delete button -->
                <button class='btn btn-danger delete-customer-button' data-id='` + val.id + `'>
                    <span class='glyphicon glyphicon-remove'></span> Delete
                </button>
            </td>
 
        </tr>`;
});
 
// end table
read_customer_html+=`</table>`;
// inject to 'page-content' of our app
$("#page-content").html(read_customers_html);
 
});
}