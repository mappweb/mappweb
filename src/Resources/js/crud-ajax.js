$(document).ready(function () {
    ADMIN.ELEMENTS.body.on('click', '.open-modal', openModal);
    ADMIN.ELEMENTS.body.on('submit', '.save-ajax', saveAjax);
    ADMIN.ELEMENTS.body.on('submit', '.delete-ajax', deleteAjax);
    ADMIN.ELEMENTS.body.on('click', '.delete-modal', showDeleteModal);

    function openModal(event) {
        event.preventDefault();

        let target = $(event.target), container = $('#modal-add');
        let url = target.attr('href') || target.data('url');

        if (url === undefined) target = $(event.currentTarget);

        url = target.attr('href') || target.data('url');

        $.ajax({
            url: url, dataType: 'html',
            beforeSend: function () {
                spinner(true);
            },
            success: function (response) {
                spinner(false);
                container.html(response);
                ADMIN.ELEMENTS.body.trigger('form.init');
                container.find('.modal').modal('show');
            },
            error: function (response) {
                let json = JSON.parse(response.responseText);
                spinner(false);
                showToast('error', 'Error!', json.error);
            }
        })
    }

    function saveAjax(evento) {
        evento.preventDefault();

        let form = $(evento.currentTarget);
        let data = form.serialize();

        let options = {
            url: form.attr('action'), type: form.attr('method'), dataType: 'json',
            beforeSend: function () {
                removeErrors();
                spinner(true);
            },
            success: function (response) {
                spinner(false);
                showToast(response.toast.type, response.toast.title, response.toast.message);
                if (response.success) {
                    $('button[data-dismiss="modal"]', form).trigger('click');

                    if(response.reset_form){
                        form.trigger('reset');
                    }

                    if(response.refresh_table) {
                        ADMIN.ELEMENTS.body.trigger('datatable.refresh');
                    }

                    if (response.reload_page){
                        location.reload();
                    }

                    if (response.redirect_to !== undefined){
                        location.href = response.redirectTo;
                    }
                }

                if (response.show_modal){
                    let container = $('#modal-add');
                    container.find('.modal').modal('hide');
                    setTimeout(function () {
                        container.html(response.view).find('.modal').modal('show');
                    }, 500);
                }
            },
            error: function (response) {
                spinner(false);
                switch (response.status) {
                    case 422:
                        showErrors(response);
                        break;

                    default:
                        let json = JSON.parse(response.responseText);
                        showToast('error', 'Error!', json.error);
                        break;
                }
            }
        };

        if (form.data('has-files')){
            data = new FormData(form[0]);
            options.contentType = false;
            options.processData = false;
            options.headers = {'X-CSRF-TOKEN': form.find('input[name=_token]').val()};
        }

        options.data = data;

        $.ajax(options);
    }

    function deleteAjax(event){
        event.preventDefault();

        let form = $(event.target);

        let options = {
            url: form.attr('action'), type: 'DELETE', dataType: 'json', headers: {'X-CSRF-TOKEN': form.find('input[name=_token]').val()},
            beforeSend: function () {
                spinner(true);
            },
            success: function (response) {
                spinner(false);
                if (response.success) {
                    form.find('.modal').modal('hide');
                    showToast(response.toast.type, response.toast.title, response.toast.message);
                    ADMIN.ELEMENTS.body.trigger('datatable.refresh');
                }
                else{
                    let json = JSON.parse(response.responseText);
                    showToast('error', 'Error!', json.error);
                }
            },
            error: function (response) {
                spinner(false);
                switch (response.status) {
                    case 422:
                        showErrors(response);
                        break;

                    default:
                        let json = JSON.parse(response.responseText);
                        showToast('error', 'Error!', json.error);
                        break;
                }
            }
        };

        $.ajax(options);
    }

    function showDeleteModal(event) {
        event.preventDefault();

        let target = $(event.currentTarget);

        if (target.data('url') === undefined) target = $(event.currentTarget);

        if (target.data('confirmation-message') !== undefined){
            $('#form-delete').attr('action', target.data('url'));
            $('#confirmation-message').text(target.data('confirmation-message'));
            $('#delete-modal').modal('show');
        }
    }

    function showErrors(response) {
        let errors = JSON.parse(response.responseText).errors;

        $.each(errors, function (element, index) {
            $('[name=' + element + ']').addClass('is-invalid');
            $('div[data-feedback="' + element + '"]').addClass('invalid-feedback').text(index);
        });
    }

    function removeErrors() {
        $('.is-invalid').removeClass('is-invalid');
    }
});

function showToast(type, title, message){
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    toastr[type](message, title);
}

function spinner(show){
    if (show){
        NProgress.start();
       // $('#loader').fadeIn();
    } else {
        //$('#loader').fadeOut();
        NProgress.done();
    }
}
