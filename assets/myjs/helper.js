// class rupiah untuk format rupiah 
$(document).on("keyup", ".rupiah", function(){
    $(this).val(formatRupiah(this.value, 'Rp. '))
})

// data table custom 
$('.table-responsive').on('show.bs.dropdown', function () {
    $('.table-responsive').css( "overflow", "inherit" );
});

$('.table-responsive').on('hide.bs.dropdown', function () {
    $('.table-responsive').css( "overflow", "auto" );
})
// data table custom 

// number only 
$(".number").inputFilter(function(value) {
    return /^\d*$/.test(value);    // Allow digits only, using a RegExp
});

$(document).on("keyup", "input[name='search']", function(){
    loadMobile(0);
})

// pagination 
$('#pagination').on('click','a',function(e){
    e.preventDefault(); 
    var pageno = $(this).attr('data-ci-pagination-page');
    page = pageno;
    $("#skeleton").show()
    loadMobile(pageno);
});