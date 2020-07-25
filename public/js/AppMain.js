$(function () {
    //TIPS
    $('[toggle="tips"]').tooltip({container: 'body'});
    //Popover
    $('[data-toggle="popover"]').popover();
})

// Model 谈层 消息
$(".run").click(function(){
    var url  = $(this).attr('data-url');
    var text = $(this).attr('data-text');
    if(text=="" || text==undefined)
    {
        $.get(url,function(data){
            var result=eval('('+data+')');
            swal("执行完成!", result.msg, result.code==10000 ? "success" : "error");
            setTimeout(function(){ window.location.reload(); }, 2000);
        });
    }else{
        swal({
            title: "现在执行吗?",
            text:  text,
            type:  "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "是的, 执行!",
            closeOnConfirm: false
        }, function () {
            $.get(url,function(data){
                var result=eval('('+data+')');
                swal("执行完成!", result.msg, result.code==10000 ? "success" : "error");
                setTimeout(function(){ window.location.reload(); }, 2000);
            });
        });
    }
})

// Notify 弹框
$(".run_notify").click(function(){
    var url  = $(this).attr('data-url');
    var text = $(this).attr('data-text');
    if(text=="" || text==undefined)
    {
        $.get(url,function(data){
            var result=eval('('+data+')');
            showNotification(result.code=='1' ? "alert-success" : "alert-danger", result.msg, "top", "center", "", "");
            setTimeout(function(){ window.location.reload(); }, 2000);
        });
    }else{
        swal({
            title: "现在执行吗?",
            text:  text,
            type:  "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "是的, 执行!",
            closeOnConfirm: false
        }, function () {
            $.get(url,function(data){
                var result=eval('('+data+')');
                sweetAlert.close();
                showNotification(result.code=='1' ? "alert-success" : "alert-danger", result.msg, "top", "center", "", "");
                setTimeout(function(){ window.location.reload(); }, 2000);
            });
        });
    }
})



function showNotification(colorName, text, placementFrom, placementAlign, animateEnter, animateExit)
{
    if (colorName === null || colorName === '') { colorName = 'bg-black'; }
    if (text === null || text === '') { text = 'Turning standard Bootstrap alerts'; }
    if (animateEnter === null || animateEnter === '') { animateEnter = 'animated fadeInDown'; }
    if (animateExit === null || animateExit === '') { animateExit = 'animated fadeOutUp'; }
    var allowDismiss = true;

    $.notify({
        message: text
    },{
        type: colorName,
        allow_dismiss: allowDismiss,
        newest_on_top: true,
        timer: 1000,
        placement: {
            from: placementFrom,
            align: placementAlign
        },
        animate: {
            enter: animateEnter,
            exit: animateExit
        },
        template: '<div data-notify="container" class="bootstrap-notify-container alert alert-dismissible {0} ' + (allowDismiss ? "p-r-35" : "") + '" role="alert">' +
        '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
        '<span data-notify="icon"></span> ' +
        '<span data-notify="title">{1}</span> ' +
        '<span data-notify="message">{2}</span>' +
        '<div class="progress" data-notify="progressbar">' +
        '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
        '</div>' +
        '<a href="{3}" target="{4}" data-notify="url"></a>' +
        '</div>'
    });
}
