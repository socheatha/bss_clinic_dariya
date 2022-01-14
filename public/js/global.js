var getCambodiaChildUrl = '/address/getFullAddress';
var getProvinceChildUrl = '/address/getProvinceChileSelection';
var getDistrictChileUrl = '/address/getDistrictChileSelection';
var getCommuneChileUrl = '/address/getCommuneChileSelection';
var _patientRequestUrl = '/patient/getSelectDetail';
var temp_address_code = '';

function bss_number(number) {
    return (!number || typeof number == 'undefined' || number == 'undefined' || number == '0') ? 0 : parseInt(number);
}

function bss_string(txt) {
    return (!txt || typeof txt == 'undefined' || txt == 'undefined') ? '' : txt;
}

// calculate sum
function bss_sum_number() {
    let sum = 0;
    for (let i = 0; i < arguments.length; i++) {
        sum += bss_number(arguments[i]);
    }

    return bss_number(sum);
}

function bss_call_function(fc_name, clear_called = false) {
    if (typeof fc_name == 'function') {
        fc_name();
        if (clear_called) fc_name = function () { };
    }
}

function bss_swal_Success(title = '', text = '', fcCallBack) {
    Swal.fire({
        icon: 'success',
        title: bss_string(title),
        confirmButtonText: bss_string(text),
        timer: 1500
    }).then(() => {
        fcCallBack();
    });
}

function bss_swal_Error(txt) {
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: bss_string(txt),
    });
}

function bss_swal_Warning(title = '', text = '', fcCallBack) {
    Swal.fire({
        icon: 'warning',
        title: bss_string(title),
        confirmButtonText: bss_string(text),
        // timer: 1500
    }).then(() => {
        fcCallBack();
    });
}

function bss_openPrintWindow(url, name) {
    var printWindow = window.open(url, name, "width="+ screen.availWidth +",height="+ screen.availHeight +",_blank");
    var printAndClose = function () {
        if (printWindow.document.readyState == 'complete') {
            clearInterval(sched);
            printWindow.print();
            printWindow.close();
        }
    }  
    var sched = setInterval(printAndClose, 2000);
};

// prepare form AJAX submission
$(document).ready(function () {
    $(document).on('click', '.submitFormAjx', function (e) {
        e.preventDefault(); // prevent form native submission
        let _form = $(this).parents('form');

        $.ajax({
            url: _form.attr('action'),
            method: bss_string(_form.attr('method')),
            data: bss_string(_form.serialize()),
            success: function (res) {
                if (typeof onAjaxSuccess == 'string') {
                    bss_swal_Success(onAjaxSuccess);
                    onAjaxSuccess = '';
                } else if (typeof onAjaxSuccess == 'function') {
                    onAjaxSuccess(res); onAjaxSuccess = function () { };
                }
            },
            error: function (request, status, error) {
                bss_swal_Error(bss_string(request.responseText) + ' : ' + bss_string(status) + ' : ' + bss_string(error));
            }
        });
    });

    // date picker
    if ($('.bssDateRangePicker').length >= 1) {
        $('.bssDateRangePicker').daterangepicker(
            {
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                startDate: moment().startOf('month'),
                endDate: moment().endOf('month')
            },
            function (start, end) {
                $('#from').val(start.format('YYYY-MM-DD'));
                $('#to').val(end.format('YYYY-MM-DD'));
                getDatatable(start.format('YYYY-MM-DD'), end.format('YYYY-MM-DD'))
            }
        )
    }

    if ($('[name="patient_id"]').length >= 1) {
        $(document).on('change', '[name="patient_id"]', function () {
            $('[name="pt_district_id"], [name="pt_commune_id"], [name="pt_village_id"]').html('<option value=""></option>');

            if ($(this).val() != '') {
                $.ajax({
                    url: bss_string(_patientRequestUrl),
                    type: 'post',
                    data: { 
                        id: bss_number($(this).val()),
                        with_address_selection : true
                    },
                }).done(function (result) {
                    // $('[name="pt_no"]').val(result.patient.no);
                    $('[name="pt_name"]').val(bss_string(result.patient.name));
                    $('[name="pt_phone"]').val(bss_string(result.patient.phone));
                    $('[name="pt_age"]').val(bss_string(result.patient.age));
                    $('[name="pt_age_type"]').val(bss_string(result.patient.age_type));
                    $('[name="pt_gender"]').val(bss_string(result.patient.pt_gender));
                    $('[name="pt_village"]').val(bss_string(result.patient.address_village));
                    $('[name="pt_commune"]').val(bss_string(result.patient.address_commune));

                    if (result && result.address) {
                        let _adddressLevel = result.address;
                        $('[name="pt_province_id"]').html(_adddressLevel[0]);
                        $('[name="pt_district_id"]').html(_adddressLevel[1]);
                        $('[name="pt_commune_id"]').html(_adddressLevel[2]);
                        $('[name="pt_village_id"]').html(_adddressLevel[3]);
                    }
                });
            }
        });
    }

    if ($('[name="pt_province_id"]').length >= 1) {
        $(document).on('change', '[name="pt_province_id"]', function (e) {            
            $('[name="pt_district_id"], [name="pt_commune_id"], [name="pt_village_id"]').html('<option value=""></option>');
            
            let targetObj = $('[name="pt_district_id"]');
            $.ajax({
                url: bss_string(getProvinceChildUrl),
                method: 'post',
                data: { parent_code: bss_string($(this).val()) },
                success: function (data) { targetObj.html(data); }
            });
        });
    }

    if ($('[name="pt_district_id"]').length >= 1) {
        $(document).on('change', '[name="pt_district_id"]', function (e) {
            $('[name="pt_commune_id"], [name="pt_village_id"]').html('<option value=""></option>');
            
            let targetObj = $('[name="pt_commune_id"]');
            $.ajax({
                url: bss_string(getDistrictChileUrl),
                method: 'post',
                data: { parent_code: bss_string($(this).val()) },
                success: function (data) { targetObj.html(data); }
            });
        });
    }

    if ($('[name="pt_commune_id"]').length >= 1) {
        $(document).on('change', '[name="pt_commune_id"]', function (e) {
            $('[name="pt_village_id"]').html('<option value=""></option>');

            let targetObj = $('[name="pt_village_id"]');
            $.ajax({
                url: bss_string(getCommuneChileUrl),
                method: 'post',
                data: { parent_code: bss_string($(this).val()) },
                success: function (data) { targetObj.html(data); }
            });
        });
    }

    $('#btn_upload').click(function () {
        $('#btn_upload').html('uploading data to BSS FTP server, please wait. <i class="fa fa-spinner fa-pulse"></i>');
        $.ajax({
            url: bss_string('/uplaoddb'),
            method: 'post',
            // async: false,
            complete: function(xhr, textStatus) {
                if (xhr.status == 200) {
                    $('#btn_upload').html('<p class="text-success">already <i class="fa fa-check"></i></p>');
                } else {
                    $('#btn_upload').html('<p class="text-danger">problem while uploading process. <i class="fa fa-times"></i></p>');
                }
            } 
        });
    });

    $('#btn_complement_field').click(function () {
        $('#btn_complement_field').html('updating missing fiels or data. <i class="fa fa-spinner fa-pulse"></i>');
        $.ajax({
            url: bss_string('/updatedb'),
            method: 'post',
            // async: false,
            complete: function(xhr, textStatus) {
                if (xhr.status == 200) {
                    $('#btn_complement_field').html('<p class="text-success">already <i class="fa fa-check"></i></p>');
                } else {
                    $('#btn_complement_field').html('<p class="text-danger">problem while updating process. <i class="fa fa-times"></i></p>');
                }
            } 
        });
    });

    // @Socheatha
    $list_much_text = [];
    $('.js_load_dynamic_content').each(function (i, e) {
        $list_much_text[i] = $(e).html();
        $(e).data('eq', i)
        $(e).html('<button class="load_dynamic_content btn btn-xs btn-info btn-flat" data-eq="' + i + '">' + $(e).data('btn_name') + '</button>');
    });

    $('.load_dynamic_content').on('click', function () {
        $('#modal_dynamic_content').find('.modal-body').html($list_much_text[$(this).data('eq')]);
        $('#modal_dynamic_content').modal('show');
    });
});