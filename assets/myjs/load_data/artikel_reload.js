var pathArray = window.location.pathname.split("/").pop()

if(pathArray == "arsip"){
    var url = url_base+"artikel/load_artikel/arsip";
} else {
    var url = url_base+"artikel/load_artikel";
}

var datatable = $('#dataTable').DataTable({ 
    initComplete: function() {
        var api = this.api();
        $('#mytable_filter input')
            .off('.DT')
            .on('input.DT', function() {
                api.search(this.value).draw();
        });
    },
    oLanguage: {
    sProcessing: "loading..."
    },
    processing: true,
    serverSide: true,
    ajax: {"url": url, "type": "POST"},
    columns: [
        {"data": "nama_artikel"},
        {"data": "ukuran", render : function(data, row, iDisplayIndex){
            if(data == 0) data = "-"
            else data += "";

            if(jQuery.browser.mobile == true) return data
            else return "<center>"+data+"</center>"
        }},
        {"data": "produk"},
        {"data": "stok", render : function(data, row, iDisplayIndex){
            if(data == 0) data = "-"
            else data += "";

            if(jQuery.browser.mobile == true) return data
            else return "<center>"+data+"</center>"
        }},
        {"data": "harga", render: $.fn.dataTable.render.number( '.', '.', 0, 'Rp ' ) },
        {"data": "diskon", render : function(data, row, iDisplayIndex){
            if(data == 0) data = "-"
            else data += "%";

            if(jQuery.browser.mobile == true) return data
            else return "<center>"+data+"</center>"
        }},
        {"data": "menu"},
    ],
    order: [[0, 'asc']],
    rowCallback: function(row, data, iDisplayIndex) {
        var info = this.fnPagingInfo();
        var page = info.iPage;
        var length = info.iLength;
        $('td:eq(0)', row).html();
    },
    "columnDefs": [
    { "searchable": false, "targets": [""] },  // Disable search on first and last columns
    { "targets": [3, 6], "orderable": false},
    ],
    "rowReorder": {
        "selector": 'td:nth-child(0)'
    },
    "responsive": true,
});