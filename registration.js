function educatorsignup() {
    var fname=$("#fname").val();
    var mname=$("#mname").val();
    var lname=$("#lname").val();
    var address=$("#address").val();
    var birthmonth=$("#birthmonth").val();
    var birthday=$("#birthday").val();
    var birthyear=$("#birthyear").val();
    var username=$("#username").val();
    var password=$("#password").val();
    var confirm=$("#confirm").val();
    var contact=$("#contact").val();
    var secquestion=$("#secquestion").val();
    var answer=$("#answer").val();
    var register=$("#register").val();
    $.post("registration.php", {
        fname:fname,
        mname:mname,
        lname:lname,
        address:address,
        birthmonth:birthmonth,
        birthday:birthday,
        birthyear:birthyear,
        username:username,
        password:password,
        confirm:confirm,
        contact:contact,
        secquestion:secquestion,
        answer:answer,
        register:register
        },
        function (data19) {
            $("#showhere").html(data19);
        });
}



function studentsignup() {
    var fname=$("#fname").val();
    var mname=$("#mname").val();
    var lname=$("#lname").val();
    var address=$("#address").val();
    var birthmonth=$("#birthmonth").val();
    var birthday=$("#birthday").val();
    var birthyear=$("#birthyear").val();
    var username=$("#username").val();
    var password=$("#password").val();
    var confirm=$("#confirm").val();
    var contact=$("#contact").val();
    var guardiancontact=$("#guardiancontact").val();
    var secquestion=$("#secquestion").val();
    var answer=$("#answer").val();
    var register2=$("#register2").val();
    $.post("registration.php", {
            fname:fname,
            mname:mname,
            lname:lname,
            address:address,
            birthmonth:birthmonth,
            birthday:birthday,
            birthyear:birthyear,
            username:username,
            password:password,
            confirm:confirm,
            contact:contact,
            guardiancontact:guardiancontact,
            secquestion:secquestion,
            answer:answer,
            register2:register2
        },
        function (data191) {
            $("#showhere").html(data191);
        });
}

function parentsignup() {
    var fname=$("#fname").val();
    var mname=$("#mname").val();
    var lname=$("#lname").val();
    var address=$("#address").val();
    var birthmonth=$("#birthmonth").val();
    var birthday=$("#birthday").val();
    var birthyear=$("#birthyear").val();
    var username=$("#username").val();
    var password=$("#password").val();
    var confirm=$("#confirm").val();
    var contact=$("#contact").val();
    var secquestion=$("#secquestion").val();
    var answer=$("#answer").val();
    var register3=$("#register3").val();
    $.post("registration.php", {
            fname:fname,
            mname:mname,
            lname:lname,
            address:address,
            birthmonth:birthmonth,
            birthday:birthday,
            birthyear:birthyear,
            username:username,
            password:password,
            confirm:confirm,
            contact:contact,
            secquestion:secquestion,
            answer:answer,
            register3:register3
        },
        function (data193) {
            $("#showhere").html(data193);
        });
}

//show password hover button
$('#show_password').hover(function functionName() {
        //Change the attribute to text
        $('#password').attr('type', 'text');
        $('#confirm').attr('type', 'text');
        $('.glyphicon').removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close');
    }, function () {
        //Change the attribute back to password
        $('#password').attr('type', 'password');
        $('#confirm').attr('type', 'password');
        $('.glyphicon').removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open');
    }
);


$(document).on('keypress', '.letters', function (event) {
    var regex = new RegExp("^[a-zA-Z ]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
        event.preventDefault();
        return false;
    }
});


$(function() {
    $(".maxlen25").prop('maxLength', 25);
    $(".maxlen6").prop('maxLength', 6);
    $(".maxlen30").prop('maxLength', 30);
    $(".maxlen70").prop('maxLength', 70);
    $(".maxlen20").prop('maxLength', 20);
    $(".maxlen40").prop('maxLength', 40);
    $(".maxlen4").prop('maxLength', 4);
    $(".maxlen11").prop('maxLength', 11);
});

$('.mobile').keypress(function (event) {
    var keycode = event.which;
    if (!(event.shiftKey === false && (keycode === 46 || keycode === 8 || keycode === 37 || keycode === 39 || (keycode >= 48 && keycode <= 57)))) {
        event.preventDefault();
    }
});
//CODE's By CEDIE