
<link rel="stylesheet" href="{{ asset('calender/nepali.datepicker.v3.2.min.css') }}" />



<script src="{{ asset('calender/nepali.datepicker.v3.2.min.js') }}"></script>
<script>
    var months = Array.from(NepaliFunctions.GetBsMonths());
var year = NepaliFunctions.GetCurrentBsYear();
var month = NepaliFunctions.GetCurrentBsDate().month;
var day = NepaliFunctions.GetCurrentBsDate().day;
var start_y = 2070;
var now_yr = NepaliFunctions.GetCurrentBsYear();
var now_yr1 = now_yr;
for (let index = start_y; index < now_yr; index++) {
    $("#year").append(
        '<option value="' + now_yr1 + '">' + now_yr1 + "</option>"
    );
    now_yr1--;
}
//XXX load nepali calenders
$(".calender").each(function () {
    $("#" + $(this).attr("id")).nepaliDatePicker();
    $(this).val(
        NepaliFunctions.GetCurrentBsYear() +
            "-" +
            (month < 10 ? "0" + month : month) +
            "-" +
            (day < 10 ? "0" + day : day)
    );
});

//XXX set nepali calender
function setDate(id, current = false) {
    if(exists('#'+id)){
        var mainInput = document.getElementById(id);
        mainInput.nepaliDatePicker();
        if (current) {
            $("#" + id).val(
                NepaliFunctions.GetCurrentBsYear() +
                    "-" +
                    (month < 10 ? "0" + month : month) +
                    "-" +
                    (day < 10 ? "0" + day : day)
            );
        }
    }
}
//XXX toogle Date/Date Range selector type
function manageDisplay(element){
    type=$(element).val();
    $('.ct').addClass('d-none');
    $('.ct-'+type).removeClass('d-none');
}

//XXX Load months in select

$(".load-month").each(function () {
    for (let index = 0; index < months.length; index++) {
        const element = months[index];
        if (index + 1 == month) {
            $("#" + $(this).attr("id")).append(
                '<option selected value="' +
                    (index + 1) +
                    '">' +
                    element +
                    "</option>"
            );
        } else {
            $("#" + $(this).attr("id")).append(
                '<option value="' + (index + 1) + '">' + element + "</option>"
            );
        }
    }
});

//XXX Load years
$(".load-year").each(function () {
    for (let index = now_yr; index >= start_y; index--) {
        $("#" + $(this).attr("id")).append(
            '<option value="' + index + '">' + index + "</option>"
        );
    }
});

//XXX Load Session
$(".load-session").each(function () {
    if (day > 15) {
        $("#" + $(this).attr("id"))
            .val(2)
            .change();
    } else {
        $("#" + $(this).attr("id"))
            .val(1)
            .change();
    }
});
//XXX toogle Date/Date Range selector type
function manageDisplay(element){
    type=$(element).val();
    $('.ct').addClass('d-none');
    $('.ct-'+type).removeClass('d-none');
}

</script>
