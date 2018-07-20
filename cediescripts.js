function fncPresent() {
    var studregno=$("#studregno").val();
    var present=$("#submitpresent").val();
    var classid=$("#classid").val();
    var subjectdesc=$("#subject").val();
    var classcode=$("#classcode").val();
    $.post("classaction.php", {pstudregno:studregno, btnpresent:present, pclassid:classid, vsubjectdesc:subjectdesc, classcode:classcode},
        function (data19) {
            $("#att").html(data19);
        });
}

function fncAbsent() {
    var studregno=$("#studregno").val();
    var absent=$("#submitabsent").val();
    var classid=$("#classid").val();
    var subjectdesc=$("#subject").val();
    var classcode=$("#classcode").val();
    $.post("classaction.php", {astudregno:studregno, btnabsent:absent, aclassid:classid, vsubjectdesc:subjectdesc, classcode:classcode},
        function (data13) {
            $("#att").html(data13);
        });
}


function fncvalidate() {
    var studregno=$("#vstudregno").val();
    var classid=$("#vclassid").val();
    var validate=$("#vvalidate").val();
    $.post("gsprocessing.php", {vstudregno:studregno, vclassid:classid, vvalidate:validate},
        function (data) {
            $("#printinfo").html(data);
        });
}

function fnccancel() {
    var cancel=$("#cancel").val();
    $.post("gsprocessing.php", {cancel:cancel},
        function (data) {
            $("#printinfo").html(data);
        });
    document.getElementById('vstudregno').disabled = false;
    document.getElementById('vstudregno').value = '';
    document.getElementById('gradingblock').style.display='none';
    document.getElementById('attend').value='';
    document.getElementById('assignment').value='';
    document.getElementById('seatwork').value='';
    document.getElementById('quiz').value='';
    document.getElementById('termexam').value='';
    document.getElementById('project').value='';
    document.getElementById('averagehere').style.display='none';
}
function fncevaluate() {
    var studregno=$("#vstudregno").val();
    var classid=$("#vclassid").val();
    var assignment1=$("#assignment").val();
    var assignment2=$("#assignment2").val();
    var attendance1=$("#attend").val();
    var attendance2=$("#attend2").val();
    var quiz1=$("#quiz").val();
    var quiz2=$("#quiz2").val();
    var seatwork1=$("#seatwork").val();
    var seatwork2=$("#seatwork2").val();
    var termexam1=$("#termexam").val();
    var termexam2=$("#termexam2").val();
    var project1=$("#project").val();
    var project2=$("#project2").val();
    var selectterm=$("#selectterm").val();
    var evaluate=$("#evaluate").val();
    $.post("gsprocessing.php", {
            vstudregno:studregno,
            vclassid:classid,
            assignment1:assignment1,
            assignment2:assignment2,
            attendance1:attendance1,
            attendance2:attendance2,
            quiz1:quiz1,
            quiz2:quiz2,
            seatwork1:seatwork1,
            seatwork2:seatwork2,
            termexam1:termexam1,
            termexam2:termexam2,
            project1:project1,
            project2:project2,
            evaluate:evaluate,
            selectterm:selectterm},
        function (data2) {
            $("#printave").html(data2);
        });
}


function fncfvalidate() {
    var studregno=$("#fstudregno").val();
    var classid=$("#fclassid").val();
    var validate=$("#fvalidate").val();
    $.post("finalization.php", {fstudregno:studregno, fclassid:classid, fvalidate:validate},
        function (data4) {
            $("#fprintinfo").html(data4);
        });
}

function fnccancel2() {
    var cancel=$("#cancel2").val();
    $.post("finalization.php", {cancel:cancel},
        function (data4) {
            $("#fprintinfo").html(data4);
        });
    document.getElementById('fstudregno').disabled = false;
    document.getElementById('fstudregno').value = '';
    document.getElementById('finalizedgradeblock').style.display='none';
    document.getElementById('midres').value='';
    document.getElementById('finres').value='';
    document.getElementById('resulthere').style.display='none';

}

function finalizegrade() {
    var fclassid=$("#fclassid").val();
    var fstudregno=$("#fstudregno").val();
    var midtermresult=$("#midres").val();
    var fintermresult=$("#finres").val();
    var midtermperc=$("#midtermp").val();
    var fintermperc=$("#fintermp").val();
    var finalize=$("#finalize").val();
    $.post("finalization.php", {
            fclassid:fclassid,
            fstudregno:fstudregno,
            midtermresult:midtermresult,
            fintermresult:fintermresult,
            midtermperc:midtermperc,
            fintermperc:fintermperc,
            finalize:finalize},
        function (data6) {
            $("#finalresult").html(data6);
        });
}



function fncinc() {
    var incomplete=$("#inc").val();
    var istudregno=$("#fstudregno").val();
    var iclassid=$("#fclassid").val();

    $.post("finalization.php", {inc:incomplete, istudregno:istudregno, iclassid:iclassid},
        function (data12) {
        $("#finalresult").html(data12);
        });
}

function fncdrop() {
    var ddrop=$("#inc").val();
    var dstudregno=$("#fstudregno").val();
    var dclassid=$("#fclassid").val();

    $.post("finalization.php", {drop:ddrop, dstudregno:dstudregno, dclassid:dclassid},
        function (data14) {
            $("#finalresult").html(data14);
        });
}

function fnccount() {
    var classid=$("#classid").val();
    var studregno=$("#studregno").val();
    var count=$("#count").val();
    $.post("classaction.php", {cclassid:classid, cstudregno:studregno, count:count},
        function (data19) {
            $("#viewhere").html(data19);
        });
    $('#showhere').modal('show');

}


function hidemod() {
    $('#showhere').modal('hide');
    document.getElementById('studregno').value='';
}


function hidemod2() {
    $('#changepmodal').modal('hide');
    document.getElementById('currentp').value='';
    document.getElementById('newp').value='';
    document.getElementById('confirmnewp').value='';

}

function fncchangep() {
    var currentp=$("#currentp").val();
    var newp=$("#newp").val();
    var confirmnewp=$("#confirmnewp").val();
    var changep=$("#changepass").val();
    var insregno=$("#insregnop").val();
    $.post("editinstructoraccount.php", {
        currentp:currentp,
        newp:newp,
        confirmnewp:confirmnewp,
        changep:changep,
        insregnop:insregno},
        function (data19) {
            $("#show").html(data19);
        });
}


function hidemod3() {
    $('#editaccountmodal').modal('hide');
    document.getElementById('nfname').value='';
    document.getElementById('nmname').value='';
    document.getElementById('nlname').value='';
    document.getElementById('naddress').value='';
    document.getElementById('nbirthyear').value='';
    document.getElementById('ncontact').value='';


}


function fnceditinfo() {
    var insregnoup=$("#insregnoup").val();
    var nfname=$("#nfname").val();
    var nmname=$("#nmname").val();
    var nlname=$("#nlname").val();
    var naddress=$("#naddress").val();
    var nbirthmonth=$("#nbirthmonth").val();
    var nbirthday=$("#nbirthday").val();
    var nbirthyear=$("#nbirthyear").val();
    var ncontact=$("#ncontact").val();
    var updateinfo=$("#updateinfo").val();
    $.post("editinstructoraccount.php", {
            insregnoup:insregnoup,
            nfname:nfname,
            nmname:nmname,
            nlname:nlname,
            naddress:naddress,
            nbirthmonth:nbirthmonth,
            nbirthday:nbirthday,
            nbirthyear:nbirthyear,
            ncontact:ncontact,
            updateinfo:updateinfo
        },
        function (data191) {
            $("#show2").html(data191);
        });
}

function hidemod4() {
    $('#changepmodal').modal('hide');
    document.getElementById('currentp').value='';
    document.getElementById('newp').value='';
    document.getElementById('confirmnewp').value='';

}


function fncchangepstud() {
    var currentp=$("#currentp").val();
    var newp=$("#newp").val();
    var confirmnewp=$("#confirmnewp").val();
    var changep=$("#changepass").val();
    var studregno=$("#studregnop").val();
    $.post("editstudentaccount.php", {
            currentp:currentp,
            newp:newp,
            confirmnewp:confirmnewp,
            changep:changep,
            studregno:studregno},
        function (data130) {
            $("#show").html(data130);
        });
}

function fnceditinfostud() {
    var studregno=$("#studregnop").val();
    var nfname=$("#nfname").val();
    var nmname=$("#nmname").val();
    var nlname=$("#nlname").val();
    var naddress=$("#naddress").val();
    var nbirthmonth=$("#nbirthmonth").val();
    var nbirthday=$("#nbirthday").val();
    var nbirthyear=$("#nbirthyear").val();
    var ncontact=$("#ncontact").val();
    var ngcontact=$("#ngcontact").val();
    var updateinfo=$("#updateinfo").val();
    $.post("editstudentaccount.php", {
            studregno:studregno,
            nfname:nfname,
            nmname:nmname,
            nlname:nlname,
            naddress:naddress,
            nbirthmonth:nbirthmonth,
            nbirthday:nbirthday,
            nbirthyear:nbirthyear,
            ncontact:ncontact,
            ngcontact:ngcontact,
            updateinfo:updateinfo
        },
        function (data1291) {
            $("#show2").html(data1291);
        });
}

function hidemod9() {
    $('#editaccountmodal').modal('hide');
    document.getElementById('nfname').value='';
    document.getElementById('nmname').value='';
    document.getElementById('nlname').value='';
    document.getElementById('naddress').value='';
    document.getElementById('nbirthyear').value='';
    document.getElementById('ncontact').value='';
    document.getElementById('ngcontact').value='';


}


function hidemod0() {
    $('#changepmodalparent').modal('hide');
    document.getElementById('currentp').value='';
    document.getElementById('newp').value='';
    document.getElementById('confirmnewp').value='';

}


function fncchangepparent() {
    var currentp=$("#currentp").val();
    var newp=$("#newp").val();
    var confirmnewp=$("#confirmnewp").val();
    var changep=$("#changepass").val();
    var parentregno=$("#parentregnop").val();
    $.post("editparentaccount.php", {
            currentp:currentp,
            newp:newp,
            confirmnewp:confirmnewp,
            changep:changep,
            parentregnop:parentregno},
        function (data19) {
            $("#show").html(data19);
        });
}

function hidemod89() {
    $('#editaccountmodal').modal('hide');
    document.getElementById('nfname').value='';
    document.getElementById('nmname').value='';
    document.getElementById('nlname').value='';
    document.getElementById('naddress').value='';
    document.getElementById('nbirthyear').value='';
    document.getElementById('ncontact').value='';
}

function fnceditinfo56() {
    var parentregnoup=$("#parentregnoup").val();
    var nfname=$("#nfname").val();
    var nmname=$("#nmname").val();
    var nlname=$("#nlname").val();
    var naddress=$("#naddress").val();
    var nbirthmonth=$("#nbirthmonth").val();
    var nbirthday=$("#nbirthday").val();
    var nbirthyear=$("#nbirthyear").val();
    var ncontact=$("#ncontact").val();
    var updateinfo=$("#updateinfo").val();
    $.post("editparentaccount.php", {
            parentregnoup:parentregnoup,
            nfname:nfname,
            nmname:nmname,
            nlname:nlname,
            naddress:naddress,
            nbirthmonth:nbirthmonth,
            nbirthday:nbirthday,
            nbirthyear:nbirthyear,
            ncontact:ncontact,
            updateinfo:updateinfo
        },
        function (data191) {
            $("#show2").html(data191);
        });
}


function postthis() {
    var postbody=$("#postbody").val();
    var type=$("#type").val();
    var classcodep=$("#classcodep").val();
    var post=$("#post").val();
    var insregno=$("#insregnopost").val();
    $.post("posting.php", {
            postbody:postbody,
            type:type,
            classcodep:classcodep,
            post:post,
            insregno:insregno},
        function (data1923) {
            $("#posting").html(data1923);
        });
}

//show password hover button
$('#show_password').hover(function functionName() {
        //Change the attribute to text
        $('#password').attr('type', 'text');
        $('#currentp').attr('type', 'text');
        $('#newp').attr('type', 'text');
        $('#confirmnewp').attr('type', 'text');
        $('.glyphicon').removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close');
    }, function () {
        //Change the attribute back to password
        $('#password').attr('type', 'password');
        $('#currentp').attr('type', 'password');
        $('#newp').attr('type', 'password');
        $('#confirmnewp').attr('type', 'password');
        $('.glyphicon').removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open');
    }
);


function chooseopt() {

        var opt = document.querySelector('input[name="acoptions"]:checked').value;
        if (opt === 'asq') {
            window.top.location = 'secquestion.php';
        } else if (opt === 'ssc') {
            window.top.location = 'sendsmscode.php';
        }
}

function unchecked() {
    document.getElementById('next1').disabled=false;
}

function returnlogin() {
    window.top.location = 'loginpage.php';
}

function acviasecquest() {
    var secquestion=$("#secquestion").val();
    var answer=$("#scanswer").val();
    var nextsq=$("#nextsq").val();
    var user=$("#username").val();
    $.post("acaction.php", {
         secquestion:secquestion,
         answer:answer,
         user:user,
         nextsq:nextsq},
        function (data77) {
            $("#sec").html(data77);
        });
}

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
    $(".maxlen3").prop('maxLength', 3);
    $(".maxlen11").prop('maxLength', 11);
    $(".maxlen2").prop('maxLength', 2);
});

$('.mobile').keypress(function (event) {
    var keycode = event.which;
    if (!(event.shiftKey === false && (keycode === 46 || keycode === 8 || keycode === 37 || keycode === 39 || (keycode >= 48 && keycode <= 57)))) {
        event.preventDefault();
    }
});

//date table
$(document).ready( function () {
    $('#table_id').DataTable({
        "order": [[ 2, "desc" ], [ 3, 'desc' ]],
        "scrollY":        "200px",
        "scrollCollapse": true,
    } );
} );

$(document).ready( function () {
    $('#table_id2').DataTable();
} );



//data table


//CODE's By CEDIE