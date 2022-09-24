$(document).ready(function(){
// Form input to add item
$('#addTask').submit(function(e){
e.preventDefault();

formData = $(this).serialize();


$.ajax({
    type:"POST",
    url:"todolist_post_get.php",
    data:formData,
}).then(
    
    function(response){
        console.log("data");
          response = JSON.parse(response);
        // Check item added to DB
        console.log( response);
        if(response.message=="success"){
            $(".task-list").append('<li> <input type="checkbox" name="checkbox" id="list-1" />'+ response.data.title +' <i class= "fa-solid fa-trash-can"> </i> <i class="fa-solid fa-pencil"></i> </li>');
           
        }else {
            alert ("Not Successful####" + "\n" + response);
        }
    },
    function (){
        alert("ERROR:Ajax did not execute");
    }
)
})

})