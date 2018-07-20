function fncLate() {
    var studregno=$("#studregno").val();
    var present=$("#submitlate").val();
    var classid=$("#classid").val();
    var subjectdesc=$("#subject").val();
    var classcode=$("#classcode").val();
    $.post("classaction.php", {lstudregno:studregno, btnlate:present, lclassid:classid, vsubjectdesc:subjectdesc,classcode:classcode},
        function (data195) {
            $("#att").html(data195);
        });
}

function submitgs(){
    var insregno=$("#insregnogs").val();
    var attendance=$("#attendance").val();
    var assignment=$("#assignment").val();
    var seatwork=$("#seatwork").val();
    var quiz=$("#quiz").val();
    var termexam=$("#termexam").val();
    var project=$("#project").val();
    var classcode=$("#classcode").val();
    var btngradingsetting=$("#btngradingsetting").val();

    $.post("configuration.php", {
            insregno:insregno,
            attendance:attendance,
            assignment:assignment,
            seatwork:seatwork,
            quiz:quiz,
            termexam:termexam,
            project:project,
            classcode:classcode,
            btngradingsetting:btngradingsetting
        },
        function (data4) {
            $("#gs").html(data4);
        });
}

function submitss(){
    var insregno=$("#insregnoss").val();
    var iattendance=$("#iattendance").val();
    var iassignment=$("#iassignment").val();
    var iseatwork=$("#iseatwork").val();
    var iquiz=$("#iquiz").val();
    var itermexam=$("#itermexam").val();
    var iproject=$("#iproject").val();
    var iclasscode=$("#iclasscode").val();
    var btnsetscoreboard=$("#btnsetscoreboard").val();
    var selectterm=$("#selectterm").val();

    $.post("configuration.php", {
            insregno:insregno,
            iattendance:iattendance,
            iassignment:iassignment,
            iseatwork:iseatwork,
            iquiz:iquiz,
            itermexam:itermexam,
            iproject:iproject,
            iclasscode:iclasscode,
            btnsetscoreboard:btnsetscoreboard,
            selectterm:selectterm
        },
        function (data44) {
            $("#ss").html(data44);
        });
}

function submitsp() {
    var insregno=$("#insregnosp").val();
    var mipercent=$("#midpercent").val();
    var finalpercent=$("#finalpercent").val();
    var sclasscode=$("#sclasscode").val();
    var submissiondate=$("#submissiondate").val();
    var setpercentage=$("#setpercentage").val();
    var passinggrade=$("#passinggrade").val();
    $.post("configuration.php", {
            insregno:insregno,
            midpercent:mipercent,
            finalpercent:finalpercent,
            sclasscode:sclasscode,
            submissiondate:submissiondate,
            setpercentage:setpercentage,
            passinggrade:passinggrade
        },
        function (data1935) {
            $("#sp").html(data1935);
        });
}


$(document).ready( function () {
    $('#table_id3').DataTable({
        "scrollY":        "200px",
        "scrollCollapse": true,
    } );
} );


$(document).ready( function () {
    $('#table_id4').DataTable({
        "bSort": false,
        "scrollY":         "260px",
        "scrollCollapse": true,
    });

} );

$(document).ready( function () {
    $('#table_id8').DataTable({
        "order": [[ 1, "desc" ], [ 2, 'desc' ]],
        "scrollY":         "260px",
        "scrollCollapse": true,
    });

} );

$(document).ready( function () {
    $('#table_id78').DataTable({
        "scrollY":         "260px",
        "scrollCollapse": true,
    });

} );

$(document).ready( function () {
    $('#table_id5').DataTable({
        "bSort": false,
        "scrollY":        "380px",
        "scrollCollapse": true,
    });

} );

$(document).ready( function () {
    $('#table_id6').DataTable(
        {
            "scrollY":         "380px",
            "scrollCollapse": true,
        }
    );

} );

function pic() {
    var pic = $("#profilepic").val();
    if(pic !== ''){
        document.getElementById('upload').disabled = false;
    }
}

function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#blah').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#profilepic").change(function() {
    readURL(this);
});

function attendancebtns() {
    var studregno = $("#studregno").val();
    if(studregno !== ''){
        document.getElementById('submitpresent').disabled = false;
        document.getElementById('submitabsent').disabled = false;
        document.getElementById('submitlate').disabled = false;
    }else{
        document.getElementById('submitpresent').disabled = true;
        document.getElementById('submitabsent').disabled = true;
        document.getElementById('submitlate').disabled = true;
    }
}


$(document).ready( function () {

    $("#loginform").fadeIn(2000);

    var  words = [
        ' keep learning',
        ' bridge education'
    ], i = 0;

     setInterval(function () {
         $("#secondarytext").fadeOut(function () {
             $(this).html(words[i = (i+1)%words.length]).fadeIn();
         });
     },3000);
})();

function sendsms() {
    var insname=$("#insname").val();
    var contact=$("#contact").val();
    var msgbox=$("#msgbox").val();
    var btnsend=$("#btnsend").val();
    $.post("messaging.php", {insname:insname, contact:contact, msgbox:msgbox, btnsend:btnsend},
        function (data135) {
            $("#msg").html(data135);
        });
}

function sendbtn() {
    var msgbox = $("#msgbox").val();
    if(msgbox !== ''){
        document.getElementById('btnsend').disabled = false;
    }else{
        document.getElementById('btnsend').disabled = true;
    }
}

function updatepost() {
    var updatepost=$("#btnupdatepost").val();
    var postbody=$("#postbody").val();
    var type=$("#type").val();
    var postid=$("#postid").val();
    $.post("posting.php",{updatepost:updatepost, postbody:postbody, type:type, postid:postid},
        function (data1923) {
            $("#posting").html(data1923);
        }
    );
}

function fterm() {
    var selectterm = $("#selectterm").val();
    var vclassid = $("#vclassid").val();
    $.post("gsprocessing.php", {selectterm:selectterm, vclassid:vclassid},
        function (data2) {
            $("#printave").html(data2);
        });
}


function refreshgr(){
    var refreshgr = $("#refreshgr").val();
    var classcode = $("#classcoderfr").val();
    $.post("refreshtable.php", {refresh:refreshgr, classcode:classcode},
        function (data16){
            $("#refresh").html(data16);
        });
}

