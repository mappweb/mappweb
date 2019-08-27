;(function (global, $) {
    "use strict";

    //variable global
    let ADMIN = global.ADMIN = global.ADMIN || {};

    //elementos globales
    ADMIN.ELEMENTS = {};
    ADMIN.ELEMENTS.body = $('body');
    ADMIN.ELEMENTS.mensajes = $('#messages');
    ADMIN.ELEMENTS.notificaciones = $('#notifications');

    //eventos
    ADMIN.ELEMENTS.body.on('form.init', initFloatingLabels);
    ADMIN.ELEMENTS.body.on('datatable.refresh', refreshDatatable);
    ADMIN.ELEMENTS.body.on('tooltips.init', initTooltips);
    ADMIN.ELEMENTS.body.on('wysihtml5.init', initWysihtml5);
    ADMIN.ELEMENTS.body.on('summernote.init', initSummernote);
    ADMIN.ELEMENTS.body.on('dropify.init', initDropify);
    ADMIN.ELEMENTS.body.on('multipleDropify.init', initMultipleAttached);
    ADMIN.ELEMENTS.body.on('datepicker.init', initDatePicker);
    ADMIN.ELEMENTS.body.on('switcher.init', initSwitcher);
    ADMIN.ELEMENTS.body.on('select2.init', initSelect2);
    ADMIN.ELEMENTS.body.on('select2.ajax', initSelect2Ajax);
    ADMIN.ELEMENTS.body.on('formatValueMoney.init', formatValueMoney);
    ADMIN.ELEMENTS.body.on('toLowerCaseInput.init', toLowerCaseInput);
    ADMIN.ELEMENTS.body.on('hideSelect.init', hideSelect);

    function initFloatingLabels() {
        //On focus event
        $('.form-control').focus(function () {
            $(this).parent().addClass('focused');
        });

        //On focusout event
        $('.form-control').focusout(function () {
            var $this = $(this);
            if ($this.parents('.form-group').hasClass('form-float')) {
                if ($this.val() == '') { $this.parents('.form-line').removeClass('focused'); }
            }
            else {
                $this.parents('.form-line').removeClass('focused');
            }
        });

        //On label click
        $('body').on('click', '.form-float .form-line .form-label', function () {
            $(this).parent().find('input').focus();
        });

        //Not blank form
        $('.form-control').each(function () {
            if ($(this).val() !== '') {
                $(this).parents('.form-line').addClass('focused');
            }
        });
    }

    function refreshDatatable() {
        window.LaravelDataTables.dataTableBuilder.ajax.reload();
    }

    function initTooltips() {
        $('[data-toggle="tooltip"]').tooltip({
            container:'table'
        })

    }

    function initWysihtml5() {
        $('.wysihtml5').wysihtml5({
            "stylesheets": [] //CSS stylesheets to load
        });
    }

    function initSummernote() {
        $('.summernote').summernote({
            height: 300, // set editor height
            focus: false // set focus to editable area after initializing summernote
        });
    }

    function initDropify() {
        $('.dropify').each(function() {
            var ms_default = $( this ).data('message-default');
            var ms_replace = $( this ).data('message-replace');
            var ms_remove = $( this ).data('message-remove');
            var ms_error = $( this ).data('message-error');
            $(this).dropify({
                messages: {
                    'default': (ms_default != undefined)?ms_default:'Drag and drop a file here or click',
                    'replace': (ms_replace != undefined)?ms_replace:'Drag and drop or click to replace',
                    'remove':  (ms_remove != undefined)?ms_remove:'Remove',
                    'error':   (ms_error != undefined)?ms_error:'Ooops, something wrong happended.'
                }
            });
        });
    }

    function initMultipleAttached() {
        var counter = 0;    
        $('.add_file').click(function() {
            counter += 1;
            var appendDiv = '<div class="col-sm-6 attached_'+ counter +'"><div class="form-group form-float"><label for="attached">Adjuntos</label><div class="form-line" data-message="attached"><input type="file" class="dropify" name="attached[]"></div><span class="error" data-message="attached"><small></small></span></div><div><a class="btn btn-danger remove_attached" id="attached_'+ counter +'"> Eliminar</a></div></div>';
            $('.attached_div').append(appendDiv);
            ADMIN.ELEMENTS.body.trigger("dropify.init");
        })
        
        $(document).on("click", ".remove_attached" , function() {
            var id = $('.remove_attached').attr('id');
            $('.'+id).remove();
        });
    }

    function initDatePicker() {
        $('.datepicker').bootstrapMaterialDatePicker({ weekStart : 0, time: false });
    }

    function initSelect2() {
        $('.select2').select2({
            width: '100%',
            placeholder: 'Seleccionar Institución',
            minimumResultsForSearch: 'infinity',
            dropdownCssClass: 'font-14',
        });
    }

    function initSwitcher(object, csrf_token, url, type, table_name, table_ref){


        $('input[type=checkbox]').unbind();
        $('input[type=checkbox]').on('change',function(event){

            event.preventDefault();

            let _val = $(this).is(':checked') ? 1 : 0;
            let _id =  $(this).attr('name').split("_")[1];

            let options = {
                url: url,
                type: type,
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': csrf_token},
                success: function (respuesta) {
                    if (respuesta.success) {
                        showToast(respuesta.toast.tipo, respuesta.toast.titulo, respuesta.toast.mensaje);
                        window.LaravelDataTables[table_name].ajax.reload();
                        window.LaravelDataTables[table_ref].ajax.reload();
                    }
                    else{
                        showToast('error', 'Error!', 'Fatal Error');
                    }
                },
                error: function () {
                    showToast('error', 'Error!', 'Fatal Error');
                }
            };

            options.data = {
                'id': _id,
                'val': _val,
            };

            $.ajax(options);

        });
    }

    function initSelect2Ajax(event, object) {

        $(object).select2({
            width: '100%',
            placeholder: $(object).data('placeholder'),
            minimumResultsForSearch: 'infinity',
            dropdownCssClass: 'font-14',
            minimumInputLength: 3,
            language: "es",
            ajax: {
                url: $(object).data('url'),
                type: "GET",
                dataType: 'json',
                data: function(params) {
                    return {
                        term: params.term
                    }
                },
                processResults: function (data, params) {
                    return {
                        results: data.data,
                    };
                },
            }
        });
    }

    function formatValueMoney() {
        $("input[data-type='currency']").on({

            keyup: function () {
                formatCurrency($(this));
            },
            /*blur: function () {
                formatCurrency($(this), "blur");
            }*/
        });


        function formatNumber(n) {
            // format number 1000000 to $1,234,567
            return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        }


        function formatCurrency(input, blur) {
            // appends $ to value, validates decimal side
            // and puts cursor back in right position.

            // get input value
            var input_val = input.val();

            // don't validate empty input
            if (input_val === "") {
                return;
            }

            // original length
            var original_len = input_val.length;

            // initial caret position
            var caret_pos = input.prop("selectionStart");

            // check for decimal
            if (input_val.indexOf(".") >= 0) {

                // get position of first decimal
                // this prevents multiple decimals from
                // being entered
                var decimal_pos = input_val.indexOf(".");

                // split number by decimal point
                var left_side = input_val.substring(0, decimal_pos);
                var right_side = input_val.substring(decimal_pos);

                // add commas to left side of number
                left_side = formatNumber(left_side);

                // validate right side
                right_side = formatNumber(right_side);

                // On blur make sure 2 numbers after decimal
                if (blur === "blur") {
                    right_side += "00";
                }

                // Limit decimal to only 2 digits
                right_side = right_side.substring(0, 2);

                // join number by .
                input_val = "$" + left_side + "." + right_side;

            } else {
                // no decimal entered
                // add commas to number
                // remove all non-digits
                input_val = formatNumber(input_val);
                input_val = "$" + input_val;

                // final formatting
                if (blur === "blur") {
                    input_val += ".00";
                }
            }

            // send updated string to input
            input.val(input_val);

            // put caret back in the right position
            var updated_len = input_val.length;
            caret_pos = updated_len - original_len + caret_pos;
            input[0].setSelectionRange(caret_pos, caret_pos);
        }
    }

    function toLowerCaseInput() {
        $('input[name=name]').keyup(function () {

            var text = $('input[name=name]').val();

            $('div[id=slug_]').addClass('focused');
            $('input[name=slug]').val(text.toLowerCase().replace(/ /g, ''));

        });
    }

    function hideSelect() {
        $('select[name=role_id]').change(function () {

            if (
                $('select[name=role_id]').val() == 4) {

                $('#select_plan').removeClass('d-none');
            }else {
                $('#select_plan').addClass('d-none');
            }
        });
    }

})(window, jQuery);
