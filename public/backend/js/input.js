$(".next").keydown(function(event){
    var key = (event.keyCode ? event.keyCode : event.which);
    // console.log(key);
    if(key=='13'){
        event.preventDefault()

        id=$(this).data('next');
        console.log("next id",id);
        $('#'+id).focus();
    }
});

$('.modal').each(function(){
    _id=$(this).data('ff');
    console.log(_id);
    $(this).on('shown.bs.modal', function (e) {
        _id=$(this).data('ff');
        console.log('shown',_id);
        $('#'+_id).focus();
    });
});

$('.href').click(function(){
    window.location.href=$(this).data('target');
});

function exists(selector){
    return $(selector).length > 0;
}

$('.checkfarmer').focusout(function(){
    no=$(this).val();
    if(no!=""){
        if(!exists('#farmer-'+no)){
            alert('Farmer with farmer no-'+no+' doesnot exist;')
            $(this).focus();
            $(this).select();
        }
    }
});

function CheckFarmer(no){
    return exists('#farmer-'+no);
}

$('connectmax').change(function(){
    connected=$(this).data('connected');
    $('#'+connected).attr('max',$(this).val());
});




$('.checkitem').focusout(function(){
    id=$(this).val();
    console.log('running',id);
    if(id!=""){

        if(!exists('#item-'+id)){
            alert('Farmer with farmer no-'+id+' doesnot exist;')
            $(this).focus();
            $(this).select();
        }else{
            rate_id=$(this).data('rate');
            rate=$('#item-'+id).data('rate');
            $('#'+rate_id).val(rate);
        }
    }
});

$('.focus-select').focusin(function(){
    $(this).select();
})
function CheckItem(id){
    return exists('#item-'+id);
}

function printDiv(id)
{
        var divToPrint=document.getElementById(id);

        var newWin=window.open('','Report');
        newWin.document.open();
        newWin.document.write('<html><head><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous"><link rel="stylesheet" href="'+printcss+'"></head><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

        newWin.document.close();

}

function closeModal(modal){
    $('#'+modal).modal('close');
}

function setData(id,value){
    $('#'+id).val(value).change();

}

function closeModal(id,value){
    $('#'+id).val(value).change();
}

function showProgress(title){
    $('#xxx_123').addClass('active');
    $('#yyy_123').html(title);
}

function hideProgress(){
    $('#xxx_123').removeClass('active');

}


