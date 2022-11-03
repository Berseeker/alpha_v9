/*=========================================================================================
    File Name: app-user-list.js
    Description: User List page
    --------------------------------------------------------------------------------------
    Item Name: Vuexy  - Vuejs, HTML & Laravel Admin Dashboard Template
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent

==========================================================================================*/
$(function () {
    ('use strict');

    var dtUserTable = $('.cotizacion-list-table'),
        newUserSidebar = $('.new-user-modal'),
        newUserForm = $('.add-new-user'),
        select = $('.select2'),
        dtContact = $('.dt-contact'),
        statusObj = {
            'Pendiente': { title: 'Pendiente', class: 'badge-light-warning' },
            "Aprobada": { title: "Aprobada", class: 'badge-light-success' },
            'Cancelada': { title: 'Cancelada', class: 'badge-light-danger' }
        };

    var assetPath = '../../../app-assets/',
        userView = 'app-user-view-account.html';

    if ($('body').attr('data-framework') === 'laravel') {
        assetPath = $('body').attr('data-asset-path');
        userView = assetPath + 'app/user/view/account';
    }

    select.each(function () {
        var $this = $(this);
        $this.wrap('<div class="position-relative"></div>');
        $this.select2({
            // the following code is used to disable x-scrollbar when click in select input and
            // take 100% width in responsive also
            dropdownAutoWidth: true,
            width: '100%',
            dropdownParent: $this.parent()
        });
    });
    //console.log(assetPath);
    // Users List datatable
    if (dtUserTable.length) {
        dtUserTable.DataTable({
            ajax: {
                'url': assetPath + 'api/all-cotizaciones', // JSON file to add data,
                'dataSrc': ''
            },
            columns: [
                // columns according to JSON
                { data: 'id' },
                { data: 'id' },
                { data: 'nombre' },
                { data: 'email' },
                { data: 'status' },
                { data: '' },
            ],
            columnDefs: [
                {
                    // For Responsive
                    className: 'control',
                    orderable: false,
                    responsivePriority: 2,
                    targets: 0,
                    render: function (data, type, full, meta) {
                        return '';
                    }
                },
                {
                    // User full name and username
                    targets: 1,
                    responsivePriority: 4,
                    render: function (data, type, full, meta) {
                        //console.log(full);
                        var id = 'Id: '+full['id'];

                        // Creates full output for row
                        var $row_output =
                            '<div class="d-flex justify-content-left align-items-center">' +
                            '<div class="d-flex flex-column">' +
                            '<a href="#" class="user_name text-truncate text-body"><span class="fw-bolder">' +
                            id +
                            '</span></a>'
                            '</div>' +
                            '</div>';
                        return $row_output;
                    }
                },
                {
                    targets: 2,
                    render: function (data, type, full, meta) {
                        var name = full['nombre'] + ' ' + full['apellidos'],

                        return '<span class="text-nowrap">' + $name + '</span>';
                    }
                },
                {
                    // User Role
                    targets: 3,
                    render: function (data, type, full, meta) {
                        var $email = full['email'];
                        var roleBadgeObj = {
                            1: feather.icons['cpu'].toSvg({ class: 'font-medium-3 text-primary me-50' }),
                            2: feather.icons['pen-tool'].toSvg({ class: 'font-medium-3 text-warning me-50' }),
                            3: feather.icons['database'].toSvg({ class: 'font-medium-3 text-success me-50' }),
                            4: feather.icons['send'].toSvg({ class: 'font-medium-3 text-info me-50' }),
                            5: feather.icons['copy'].toSvg({ class: 'font-medium-3 text-danger me-50' }),
                            6: feather.icons['slack'].toSvg({ class: 'font-medium-3 text-danger me-50' }),
                            7: feather.icons['slack'].toSvg({ class: 'font-medium-3 text-danger me-50' }),
                            8: feather.icons['droplet'].toSvg({ class: 'font-medium-3 text-blue me-50' }),
                            9: feather.icons['home'].toSvg({ class: 'font-medium-3 text-danger me-50' }),
                            10: feather.icons['clipboard'].toSvg({ class: 'font-medium-3 alert alert-warning me-50' }),
                            11: feather.icons['slack'].toSvg({ class: 'font-medium-3 text-danger me-50' }),
                            12: feather.icons['slack'].toSvg({ class: 'font-medium-3 text-danger me-50' }),
                            13: feather.icons['slack'].toSvg({ class: 'font-medium-3 text-danger me-50' }),
                            14: feather.icons['coffee'].toSvg({ class: 'font-medium-3 alert alert-primary me-50' }),
                            15: feather.icons['slack'].toSvg({ class: 'font-medium-3 text-danger me-50' }),
                            16: feather.icons['slack'].toSvg({ class: 'font-medium-3 text-danger me-50' }),
                            17: feather.icons['slack'].toSvg({ class: 'font-medium-3 text-danger me-50' }),
                            18: feather.icons['slack'].toSvg({ class: 'font-medium-3 text-danger me-50' }),
                            19: feather.icons['calendar'].toSvg({ class: 'font-medium-3 text-danger me-50' }),
                            20: feather.icons['briefcase'].toSvg({ class: 'font-medium-3 text-danger me-50' }),
                        };
                        return "<span class='text-truncate align-middle'>" + $email + '</span>';
                    }
                },
                {
                    // User Status
                    targets: 4,
                    render: function (data, type, full, meta) {
                        var $status = full['status'];
                        //console.log($status)
                        return (
                            '<span class="badge rounded-pill ' +
                            statusObj[$status].class +
                            '" text-capitalized>' +
                            statusObj[$status].title +
                            '</span>'
                        );
                    }
                },
                {
                    // Actions
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                    render: function (data, type, full, meta) {
                        var id = full['id'];
                        return (
                            '<div class="btn-group">' +
                            '<a class="btn btn-sm dropdown-toggle hide-arrow" data-bs-toggle="dropdown">' +
                            feather.icons['more-vertical'].toSvg({ class: 'font-small-4' }) +
                            '</a>' +
                            '<div class="dropdown-menu dropdown-menu-end">' +
                            '<a href="#" onclick="fireModal(' + id + ');" class="dropdown-item">' +
                            feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) +
                            'Edicion Rapida</a>' +
                            '<a href="'+
                            assetPath + 'dashboard/edit-cotizacion/' + id +
                            '" class="dropdown-item">' +
                            feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) +
                            'Editar</a>' +
                            '<a href="' +
                            assetPath + 'dashboard/show-cotizacion/' + id +
                            '" class="dropdown-item">' +
                            feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) +
                            'Visualizar</a>' +
                            '<a href="' +
                            assetPath + 'dashboard/download-cotizacion/' + id +
                            '" class="dropdown-item">' +
                            feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) +
                            'Descargar</a>' +
                            '<button class="dropdown-item delete-cotizacion" onclick="deleteConfirmation('+id+')">' +
                            feather.icons['trash-2'].toSvg({ class: 'font-small-4 me-50' }) +
                            'Borrar</button></div>' +
                            '</div>' +
                            '</div>'
                        );
                    }
                }
            ],
            order: [[1, 'desc']],
            dom:
                '<"d-flex justify-content-between align-items-center header-actions mx-2 row mt-75"' +
                '<"col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start" l>' +
                '<"col-sm-12 col-lg-8 ps-xl-75 ps-0"<"dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap"<"me-1"f>B>>' +
                '>t' +
                '<"d-flex justify-content-between mx-2 row mb-1"' +
                '<"col-sm-12 col-md-6"i>' +
                '<"col-sm-12 col-md-6"p>' +
                '>',
            language: {
                sLengthMenu: 'Show _MENU_',
                search: 'Search',
                searchPlaceholder: 'Search..'
            },
            // Buttons with Dropdown
            buttons: [
                {
                    extend: 'collection',
                    className: 'btn btn-outline-secondary dropdown-toggle me-2',
                    text: feather.icons['external-link'].toSvg({ class: 'font-small-4 me-50' }) + 'Exportar',
                    buttons: [
                        {
                            extend: 'print',
                            text: feather.icons['printer'].toSvg({ class: 'font-small-4 me-50' }) + 'Print',
                            className: 'dropdown-item',
                            exportOptions: { columns: [1, 2, 3, 4, 5] }
                        },
                        {
                            extend: 'csv',
                            text: feather.icons['file-text'].toSvg({ class: 'font-small-4 me-50' }) + 'Csv',
                            className: 'dropdown-item',
                            exportOptions: { columns: [1, 2, 3, 4, 5] }
                        },
                        {
                            extend: 'excel',
                            text: feather.icons['file'].toSvg({ class: 'font-small-4 me-50' }) + 'Excel',
                            className: 'dropdown-item',
                            exportOptions: { columns: [1, 2, 3, 4, 5] }
                        },
                        {
                            extend: 'pdf',
                            text: feather.icons['clipboard'].toSvg({ class: 'font-small-4 me-50' }) + 'Pdf',
                            className: 'dropdown-item',
                            exportOptions: { columns: [1, 2, 3, 4, 5] }
                        },
                        {
                            extend: 'copy',
                            text: feather.icons['copy'].toSvg({ class: 'font-small-4 me-50' }) + 'Copy',
                            className: 'dropdown-item',
                            exportOptions: { columns: [1, 2, 3, 4, 5] }
                        }
                    ],
                    init: function (api, node, config) {
                        $(node).removeClass('btn-secondary');
                        $(node).parent().removeClass('btn-group');
                        setTimeout(function () {
                            $(node).closest('.dt-buttons').removeClass('btn-group').addClass('d-inline-flex mt-50');
                        }, 50);
                    }
                }
            ],
            // For responsive popup
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function (row) {
                            var data = row.data();
                            return 'Details of ' + data['full_name'];
                        }
                    }),
                    type: 'column',
                    renderer: function (api, rowIdx, columns) {
                        var data = $.map(columns, function (col, i) {
                            return col.columnIndex !== 6 // ? Do not show row in modal popup if title is blank (for check box)
                                ? '<tr data-dt-row="' +
                                col.rowIdx +
                                '" data-dt-column="' +
                                col.columnIndex +
                                '">' +
                                '<td>' +
                                col.title +
                                ':' +
                                '</td> ' +
                                '<td>' +
                                col.data +
                                '</td>' +
                                '</tr>'
                                : '';
                        }).join('');
                        return data ? $('<table class="table"/>').append('<tbody>' + data + '</tbody>') : false;
                    }
                }
            },
            language: {
                paginate: {
                    // remove previous & next text from pagination
                    previous: '&nbsp;',
                    next: '&nbsp;'
                }
            }
        });
    }

    // Form Validation
    if (newUserForm.length) {
        newUserForm.validate({
            errorClass: 'error',
            rules: {
                'user-fullname': {
                    required: true
                },
                'user-name': {
                    required: true
                },
                'user-email': {
                    required: true
                }
            }
        });

        newUserForm.on('submit', function (e) {
            var isValid = newUserForm.valid();
            e.preventDefault();
            if (isValid) {
                newUserSidebar.modal('hide');
            }
        });
    }

    // Phone Number
    if (dtContact.length) {
        dtContact.each(function () {
            new Cleave($(this), {
                phone: true,
                phoneRegionCode: 'US'
            });
        });
    }
});

function fireModal(id)
{
    $.ajax({
        url: "/api/get-users",
        method: "GET",
        dataType: "json",
        success: function (data) {
            var template = '';
            data.forEach(function (empleado, indice, array) {
                console.log(empleado);
                template = template + '<option value="'+empleado.id+'">'+empleado.name+'</option>';
            });
            $('#empleados-alpha').html('');
            $('#empleados-alpha').html(template)
            //var template = '<a class="dropdown-item" href="#"><img src="'+data.img+'" style="width:50px;margin-right:20px;" alt="'+data.nombre+'">'+data.nombre+'</a>';
            //$(".items-hooked").append(template);
        }
    });

    $('#cotizacion-id').html('');
    $('#cotizacion-id').html(id);

    $('#cotizacion_id').val(id);
    $('#edicion-rapida').modal('show');

}