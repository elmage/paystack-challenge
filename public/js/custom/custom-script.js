$(document).ready(function() {
    "use strict";

    let suppliers = $('#supplier-list');

    if (suppliers.length) {
        suppliers.DataTable({
            "responsive": true,
            "searching": true,
            "lengthMenu": [
                [25, 50, -1],
                [25, 50, "All"]
            ],
            ajax: {
                url:'/suppliers/get-suppliers',
                dataSrc: "",
                mDataProp: ""
            },
            aoColumns: [
                { mData: "name" },
                { mData: "tel" },
                { mData: "email" },
                { mData: "account_no" },
                { mData: "bank_name" },
                {
                    mData: "id",
                    "render": function ( data, type, row, meta ) {
                        return '<a class="waves-effect waves-light btn" href="/supplier/edit/'+data+'"><i class="material-icons right">notes</i> Details</a>';
                    }
                },
            ],

        });
    }




    $(document).on('change','#supplier_bank', function (e) {
        retrieveAccount();
    });

    $(document).on('keyup','#supplier_account_no', function (e) {
        retrieveAccount();
    });

    function retrieveAccount() {
        let bank_code = $('#supplier_bank');
        let account_no = $('#supplier_account_no');
        let name = $('#resolved_account_name');
        let name_input = $('#supplier_account_name');

        let submit_btn = $('#submit-account-button');

        name.val('');
        name_input.val('');
        submit_btn.prop('disabled',true);

        if(/^\d{10}$/.test(account_no.val()) && bank_code.val()) {

            name.attr('placeholder','Retrieving account name...');

            $.get('/resolve/account/'+account_no.val()+'/'+bank_code.val(), function (response) {
                console.log(response);

                if (response.account_name)
                {
                    name.val(response.account_name);
                    name_input.val(response.account_name);
                    account_no.val(response.account_number);
                    submit_btn.prop('disabled',false);
                } else {
                    name.val('');
                    name_input.val('');
                    submit_btn.prop('disabled',true);
                }

                name.attr('placeholder','Account Name');
            });
        } else {
            name_input.val('');
            name.val('');
            submit_btn.prop('disabled',true);
        }
    }
});