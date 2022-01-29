$("#contactForm").validator().on("submit", function (event) {
    if (event.isDefaultPrevented()) {
        // handle the invalid form...
        formError();
        submitMSG(false, "Did you fill in the form properly?");
    } else {
        // everything looks good!
        event.preventDefault();
        submitContactForm();
    }
});


function submitContactForm(){
    // Initiate Variables With Form Content
    var name = $("#name").val();
    var email = $("#email").val();
    var message = $("#message").val();


    $.ajax({
        type: "POST",
        url: "libraries/php/form-process.php",
        data: "name=" + name + "&email=" + email  + "&message=" + message,
        success : function(text){
            if (text == "success"){
                formContactSuccess();
            } else {
                formContactError();
                submitContactMSG(false,text);
            }
        }
    });
}

function formContactSuccess(){
    $("#contactForm")[0].reset();
    submitMSG(true, "Message Submitted!")
}

function formContactError(){
    $("#contactForm").removeClass().addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
        $(this).removeClass();
    });
}

function submitContactMSG(valid, msg){
    if(valid){
        var msgClasses = "h3 text-center tada animated text-success";
    } else {
        var msgClasses = "h3 text-center text-danger";
    }
    $("#msgSubmit").removeClass().addClass(msgClasses).text(msg);
}