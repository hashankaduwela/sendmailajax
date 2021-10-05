$( document ).ready(function() {
 $( "#fcf-button" ).click(function() {

var name = $("#Name").val();
var email = $("#Email").val();
var message = $("#Message").val();

 $.ajax({
  method: "POST",
  url: "mail.php",
  data: { name: name, email: email, message: message }
})
  .done(function( msg ) {
    alert( msg );
    $("#Name").val("");
    $("#Email").val("");
    $("#Message").val("");

  });
   
});
 
});