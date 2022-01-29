$("#ReservationForm").validator().on("submit", function (event) {
    if (event.isDefaultPrevented()) {
        // handle the invalid form...
        formError();
        submitMSG(false, "Did you fill in the form properly?");
    } else {
        // everything looks good!
        event.preventDefault();
        submitForm();
    }
});


function submitForm(){
    // Initiate Variables With Form
    var name = $("#name").val();
    var email = $("#email").val();
    var phone = $("#phone").val();
    var person = $("#person").val();
    var date = $("#input_date").val();
    var time = $("#input_time").val();


    $.ajax({
        type: "POST",
        url: "libraries/php/resevertion-form.php",
        data: "name=" + name + "&email=" + email + "&phone=" + phone + "&person=" + person + "$date" + date + "&time" + time,
        success : function(text){
            if (text == "success"){
                formSuccess();
            } else {
                formError();
                submitMSG(false,text);
            }
        }
    });
}

function formSuccess(){
    $("#ReservationForm")[0].reset();
    submitMSG(true, "Message Submitted!")
}

function formError(){
    $("#ReservationForm").removeClass().addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
        $(this).removeClass();
    });
}

function submitMSG(valid, msg){
    if(valid){
        var msgClasses = "h3 text-center tada animated text-success";
    } else {
        var msgClasses = "h3 text-center text-danger";
    }
    $("#msgSubmit").removeClass().addClass(msgClasses).text(msg);
}