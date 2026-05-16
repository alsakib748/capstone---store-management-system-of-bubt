"use strict";
$(document).ready(function() {
    // Main datatable with responsive enabled
    $("#datatable").DataTable({
        responsive: {
            details: {
                type: "column",
                target: -1
            }
        },
        columnDefs: [
            {
                className: "dtr-control",
                orderable: false,
                targets: -1
            }
        ]
    });

    // Datatable with buttons
    var a = $("#datatable-buttons").DataTable({
        lengthChange: false,
        buttons: ["copy", "print"],
        responsive: {
            details: {
                type: "column",
                target: -1
            }
        },
        columnDefs: [
            {
                className: "dtr-control",
                orderable: false,
                targets: -1
            }
        ]
    });

    // Key table
    $("#key-table").DataTable({
        keys: true,
        responsive: true
    });

    // Responsive datatable (already has responsive)
    $("#responsive-datatable").DataTable({
        responsive: {
            details: {
                type: "column",
                target: -1
            }
        },
        columnDefs: [
            {
                className: "dtr-control",
                orderable: false,
                targets: -1
            }
        ]
    });

    // Selection datatable
    $("#selection-datatable").DataTable({
        select: {
            style: "multi"
        },
        responsive: {
            details: {
                type: "column",
                target: -1
            }
        },
        columnDefs: [
            {
                className: "dtr-control",
                orderable: false,
                targets: -1
            }
        ]
    });

    // Alternative page datatable
    $("#alternative-page-datatable").DataTable({
        pagingType: "full_numbers",
        responsive: true
    });

    // Scroll vertical datatable
    $("#scroll-vertical-datatable").DataTable({
        scrollY: "350px",
        scrollCollapse: true,
        paging: false,
        responsive: true
    });

    // Scroll horizontal datatable
    $("#scroll-horizontal-datatable").DataTable({
        scrollX: true,
        responsive: true
    });

    // Complex header datatable
    $("#complex-header-datatable").DataTable({
        columnDefs: [
            {
                visible: false,
                targets: -1
            }
        ],
        responsive: {
            details: {
                type: "column",
                target: -1
            }
        },
        columnDefs: [
            {
                className: "dtr-control",
                orderable: false,
                targets: -1
            }
        ]
    });

    // Row callback datatable
    $("#row-callback-datatable").DataTable({
        createdRow: function(a, e, t) {
            15e4 < +e[5].replace(/[\$,]/g, "") && $("td", a).eq(5).addClass("text-danger")
        },
        responsive: true
    });

    // State saving datatable
    $("#state-saving-datatable").DataTable({
        stateSave: true,
        responsive: true
    });

    // Fixed columns datatable
    $("#fixed-columns-datatable").DataTable({
        scrollY: 300,
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        fixedColumns: true,
        responsive: true
    });

    // Fixed header datatable
    $("#fixed-header-datatable").DataTable({
        responsive: true
    });

    // Append buttons wrapper
    a.buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)");

    // Style fixes for Bootstrap 5
    $("#datatable_length select[name*='datatable_length']").addClass("form-select form-select-sm");
    $("#datatable_length select[name*='datatable_length']").removeClass("custom-select custom-select-sm");
    $(".dataTables_length label").addClass("form-label");

    // Add responsive wrapper class to datatable containers
    $(".dataTables_wrapper").each(function() {
        $(this).addClass("position-relative");
    });
});