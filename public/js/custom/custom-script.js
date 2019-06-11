$(document).ready(function() {
    "use strict";

    $('#supplier-list').DataTable({
        "responsive": true,
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
                    return '<a class="waves-effect waves-light btn" href="/supplier/edit/'+data+'"><i class="material-icons right">edit</i> Edit</a>';
                }
            },
        ],

    });

});