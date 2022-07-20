$("#addStore .btnTambah").click(function(){
    Swal.fire({
        icon: 'question',
        text: 'Yakin akan menambahkan store baru?',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then(function (result) {
        if (result.value) {
            let form = "#addStore";
            let formData = {};
            $(form+" .form").each(function(index){
                formData = Object.assign(formData, {[$(this).attr("name")]: $(this).val()})
            })

            let eror = required(form);
            
            if( eror == 1){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'lengkapi isi form terlebih dahulu'
                })
            } else {
                let result = ajax(url_base+"store/add_store", "POST", formData);

                if(result == 1){
                    loadData();
                    $("#formAddStore").trigger("reset");

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        text: 'Berhasil menambahkan data store',
                        showConfirmButton: false,
                        timer: 1500
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'terjadi kesalahan, silahkan mulai ulang halaman'
                    })
                }
            }
        }
    })
})

$(document).on("click",".detailStore", function(){
    let form = "#detailStore";
    let id_store = $(this).data("id");

    let data = {id_store: id_store};
    let result = ajax(url_base+"store/get_store", "POST", data);
    
    $.each(result, function(key, value){
        $(form+" [name='"+key+"']").val(value)
    })
})

// menyimpan hasil edit data
$("#detailStore .btnEdit").click(function(){
    Swal.fire({
        icon: 'question',
        text: 'Yakin akan merubah data store?',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then(function (result) {
        if (result.value) {
            let form = "#detailStore";
            
            let formData = {};
            $(form+" .form").each(function(){
                formData = Object.assign(formData, {[$(this).attr("name")]: $(this).val()})
            })

            let eror = required(form);
            
            if( eror == 1){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'lengkapi isi form terlebih dahulu'
                })
            } else {
                let result = ajax(url_base+"store/edit_store", "POST", formData);

                if(result == 1){
                    loadData();

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        text: 'Berhasil merubah data store',
                        showConfirmButton: false,
                        timer: 1500
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'terjadi kesalahan, silahkan mulai ulang halaman'
                    })
                }
            }
        }
    })
})


// modal consigment 
let id_urut = 0;
let nomor_urut = 0;

$("[name='cari_artikel']").on('keyup', function(){
    var value = $(this).val().toLowerCase();
    if(value == "") $(".listOfArtikelSelect").hide();
    else $(".listOfArtikelSelect").show();

    $(".listOfArtikelSelect li").each(function () {
        if ($(this).text().toLowerCase().search(value) > -1) {
            $(this).show();
            $(this).prev('.subjectName').last().show();
        } else {
            $(this).hide();
        }
    });
})

function listOfArtikel(class_artikel){
    let result = ajax(url_base+"artikel/get_all_artikel", "POST");
    let html = "";

    result.forEach(artikel => {
        html += `
        <li class="list-group-item list-group-item-light text-dark">
            <div class="d-flex justify-content-between">
                `+ artikel.nama_artikel + ` `+ artikel.ukuran + ` (` + artikel.stok + `)
                <a href="javascript:void(0)" class="`+class_artikel+` text-success" data-id="`+artikel.id_artikel+`">
                    `+tablerIcon("square-plus", "me-1")+`
                </a>
            </div>
        </li>
        `
    })

    $(".listOfArtikelSelect").html(html);
}

$(".btnAddKonsinyasi").click(function(){
    $("#listOfArtikel").html("");

    id_store = $(this).data("id");
    $("[name='id_store']").val(id_store)

    id_urut = 0;
    nomor_urut = 0;

    listOfArtikel('artikel');
})

$(document).on("click", ".artikel", function(){
    id_urut++;
    nomor_urut++;

    let id_artikel = $(this).data("id");
    let result = ajax(url_base+"artikel/get_artikel", "POST", {id_artikel : id_artikel});
    $("#listOfArtikel").append(`
        <tr id="`+id_urut+`">
            <td>
                <input type="hidden" name="id_artikel" value="`+result.id_artikel+`">
                <span class="urut">`+nomor_urut+`</span>
            </td>
            <td><a href="javascript:void(0)" class="hapusArtikel text-danger" data-form="#formKonsinyasi" data-id="`+id_urut+`" data-nama="`+result.nama_artikel+` `+result.ukuran+`">`+result.nama_artikel+` `+result.ukuran+`</a></td>
            <td class="text-right"><input type="number" name="qty" class="form form-control form-control-md required"></td>
            <td class="text-right"><input type="number" name="diskon" class="form form-control form-control-md required"></td>
            <td class="text-right"><input type="number" name="disc_sale" class="form form-control form-control-md required"></td>
        </tr>
    `)

    $("#addKonsinyasi #btnSimpan").show();

    $("[name='cari_artikel']").val("");
    $(".listOfArtikelSelect").hide();
})

$(document).on("click", ".artikelDetail", function(){
    id_urut++;
    nomor_urut++;

    let id_artikel = $(this).data("id");
    let result = ajax(url_base+"artikel/get_artikel", "POST", {id_artikel : id_artikel});
    $("#listOfArtikelDetail").append(`
        <tr id="`+id_urut+`">
            <td>
                <input type="hidden" name="id_artikel" value="`+result.id_artikel+`">
                <span class="urut">`+nomor_urut+`</span>
            </td>
            <td><a href="javascript:void(0)" class="hapusArtikel text-danger" data-form="#formDetailKonsinyasi" data-id="`+id_urut+`" data-nama="`+result.nama_artikel+` `+result.ukuran+`">`+result.nama_artikel+` `+result.ukuran+`</a></td>
            <td class="text-right"><input type="number" name="qty" class="form form-control form-control-md required"></td>
            <td class="text-right"><input type="number" name="diskon" class="form form-control form-control-md required"></td>
            <td class="text-right"><input type="number" name="disc_sale" class="form form-control form-control-md required"></td>
        </tr>
    `)

    $("#detailKonsinyasi #btnSimpan").show();

    $("[name='cari_artikel']").val("");
    $(".listOfArtikelSelect").hide();
})

$(document).on("click", ".hapusArtikel", function(){
    let id = $(this).data("id");
    let nama = $(this).data("nama");
    let form = $(this).data("form");

    Swal.fire({
        icon: 'question',
        text: 'Yakin menghapus '+nama+'?',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then(function (result) {
        if (result.value) {
            nomor_urut--;
            $(form+" #"+id).remove();
            let index = 1;
            $.each($(form+" .urut"), function(){
                $(this).html(index)
                index++
            })

            if(nomor_urut == 0){
                $("#btnEdit").hide();
                $("#btnSimpan").hide();
            }
        }
    })
})

$("#addKonsinyasi #btnSimpan").click(function(){
    Swal.fire({
        icon: 'question',
        text: 'Yakin akan menambahkan consigment baru?',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then(function (result) {
        if (result.value) {
            let form = "#formKonsinyasi";
            let formData = {};
            $(form+" .form").each(function(){
                formData = Object.assign(formData, {[$(this).attr("name")]: $(this).val()})
            })

            id_artikel = new Array();
            $.each($(form+" [name='id_artikel']"), function(){
                id_artikel.push($(this).val());
            });

            qty = new Array();
            $.each($(form+" [name='qty']"), function(){
                qty.push($(this).val());
            });

            diskon = new Array();
            $.each($(form+" [name='diskon']"), function(){
                diskon.push($(this).val());
            });

            disc_sale = new Array();
            $.each($(form+" [name='disc_sale']"), function(){
                disc_sale.push($(this).val());
            });

            formData = Object.assign(formData, {id_artikel:id_artikel});
            formData = Object.assign(formData, {qty:qty});
            formData = Object.assign(formData, {diskon:diskon});
            formData = Object.assign(formData, {disc_sale:disc_sale});

            let eror = required(form);

            if( eror == 1){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'lengkapi isi form terlebih dahulu'
                })
            } else {
                let id_store = $("[name='id_store']").val();

                let result = ajax(url_base+"store/add_konsinyasi", "POST", formData);

                if(result == 1){
                    urut = 0;
                    $("#btnSimpan").hide();
                
                    $(form).trigger('reset');
                    $("#addKonsinyasi").modal('hide');

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        text: 'Berhasil menambahkan data consigment',
                        showConfirmButton: false,
                        timer: 1500
                    })

                    id_urut = 0;
                    nomor_urut = 0;

                    updateKonsinyasi(id_store);
                    assetStore(id_store);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'terjadi kesalahan, silahkan mulai ulang halaman'
                    })
                }
            }
        }
    })
})

$(document).on("click", ".btnDetailKonsinyasi", function(){
    id_urut = 0;
    nomor_urut = 0;

    let id_konsinyasi = $(this).data("id");
    let result = ajax(url_base+"store/detail_konsinyasi", "POST", {id_konsinyasi:id_konsinyasi});

    let  form = "#formDetailKonsinyasi";

    $(form+" [name='id_store']").val(result.konsinyasi.id_store);
    $(form+" [name='id_konsinyasi']").val(result.konsinyasi.id_konsinyasi);
    $(form+" [name='tgl_konsinyasi']").val(result.konsinyasi.tgl_konsinyasi);
    $(form+" [name='keterangan']").html(result.konsinyasi.keterangan);

    html_detail = "";

    result.detail_konsinyasi.forEach(detail => {
        id_urut++;
        nomor_urut++;

        html_detail += `
        <tr id="`+id_urut+`">
            <td>
                <input type="hidden" name="id_artikel" value="`+detail.id_artikel+`">
                <span class="urut">`+nomor_urut+`</span>
            </td>
            <td>
                <a href="javascript:void(0)" class="hapusArtikel text-danger" data-form="`+form+`" data-id="`+id_urut+`" data-nama="`+detail.nama_artikel+` `+detail.ukuran+`">`+detail.nama_artikel+` `+detail.ukuran+`</a>
            </td>
            <td class="text-right">
                <input type="number" name="qty" class="form form-control form-control-md required" value="`+detail.qty+`">
            </td>
            <td class="text-right">
                <input type="number" name="diskon" class="form form-control form-control-md required" value="`+detail.diskon+`">
            </td>
            <td class="text-right">
                <input type="number" name="disc_sale" class="form form-control form-control-md required" value="`+detail.disc_sale+`">
            </td>
        </tr>
        `
    })

    $("#listOfArtikelDetail").html(html_detail);

    listOfArtikel('artikelDetail');
})

$("#detailKonsinyasi #btnEdit").click(function(){
    Swal.fire({
        icon: 'question',
        text: 'Yakin akan mengubah data consigment?',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then(function (result) {
        if (result.value) {
            let form = "#formDetailKonsinyasi";
            let formData = {};
            $(form+" .form").each(function(){
                formData = Object.assign(formData, {[$(this).attr("name")]: $(this).val()})
            })

            id_artikel = new Array();
            $.each($("input[name='id_artikel']"), function(){
                id_artikel.push($(this).val());
            });

            qty = new Array();
            $.each($("input[name='qty']"), function(){
                qty.push($(this).val());
            });

            diskon = new Array();
            $.each($("input[name='diskon']"), function(){
                diskon.push($(this).val());
            });

            disc_sale = new Array();
            $.each($("input[name='disc_sale']"), function(){
                disc_sale.push($(this).val());
            });

            formData = Object.assign(formData, {id_artikel:id_artikel});
            formData = Object.assign(formData, {qty:qty});
            formData = Object.assign(formData, {diskon:diskon});
            formData = Object.assign(formData, {disc_sale:disc_sale});

            let eror = required(form);

            if( eror == 1){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'lengkapi isi form terlebih dahulu'
                })
            } else {
                let result = ajax(url_base+"store/edit_konsinyasi", "POST", formData);

                if(result == 1){
                    
                    id_store = $(form+" [name='id_store']").val();
                    listOfArtikel('artikelDetail');
                    updateKonsinyasi(id_store);
                    assetStore(id_store);

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        text: 'Berhasil mengubah data konsinyasi',
                        showConfirmButton: false,
                        timer: 1500
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'terjadi kesalahan, silahkan mulai ulang halaman'
                    })
                }
            }
        }
    })
})

function updateKonsinyasi(id_store) {
    let result = ajax(url_base+"store/get_all_konsinyasi", "POST", {id_store:id_store});

    html = ""
    no = 1;
    result.forEach(data => {
        html += `
            <tr>
                <td>`+no+`</td>
                <td>`+data.tgl_konsinyasi+`</td>
                <td>`+data.item+`</td>
                <td>`+rupiah(data.total)+`</td>
                <td>`+data.keterangan+`</td>
                <td><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#detailKonsinyasi" data-id="`+data.id_konsinyasi+`" class="btn btn-info btnDetailKonsinyasi">`+tablerIcon("info-circle", "")+`</a></td>
                <td><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#addRetur" data-id="`+data.id_konsinyasi+`" class="btn btn-warning btnReturKonsinyasi">`+tablerIcon("truck-return", "")+`</a></td>
            </tr>
        `
        no++;
    });

    $("#listKonsinyasi").html(html);
}

// modal retur 
$(".btnAddRetur").click(function(){
    $("#listOfArtikel").html("");

    id_store = $(this).data("id");
    $("[name='id_store']").val(id_store)

    id_urut = 0;
    nomor_urut = 0;

    listOfArtikel('artikelRetur');
})

$(document).on("click", ".btnReturKonsinyasi", function(){
    id_urut = 0;
    nomor_urut = 0;

    let id_konsinyasi = $(this).data("id");
    let result = ajax(url_base+"store/detail_konsinyasi", "POST", {id_konsinyasi:id_konsinyasi});

    let  form = "#formRetur";

    $(form+" [name='id_store']").val(result.konsinyasi.id_store);

    html_detail = "";

    result.detail_konsinyasi.forEach(detail => {
        id_urut++;
        nomor_urut++;

        html_detail += `
        <tr id="`+id_urut+`">
            <td>
                <input type="hidden" name="id_artikel" value="`+detail.id_artikel+`">
                <span class="urut">`+nomor_urut+`</span>
            </td>
            <td>
                <a href="javascript:void(0)" class="hapusArtikel text-danger" data-form="`+form+`" data-id="`+id_urut+`" data-nama="`+detail.nama_artikel+` `+detail.ukuran+`">`+detail.nama_artikel+` `+detail.ukuran+`</a>
            </td>
            <td class="text-right">
                <input type="number" name="qty" class="form form-control form-control-md required" value="`+detail.qty+`">
            </td>
            <td class="text-right">
                <input type="number" name="diskon" class="form form-control form-control-md required" value="`+detail.diskon+`">
            </td>
            <td class="text-right">
                <input type="number" name="disc_sale" class="form form-control form-control-md required" value="`+detail.disc_sale+`">
            </td>
        </tr>
        `
    })

    $("#listOfArtikelRetur").html(html_detail);

    listOfArtikel('artikelRetur');
})

$(document).on("click", ".artikelRetur", function(){
    id_urut++;
    nomor_urut++;

    let id_artikel = $(this).data("id");
    let result = ajax(url_base+"artikel/get_artikel", "POST", {id_artikel : id_artikel});
    $("#listOfArtikelRetur").append(`
        <tr id="`+id_urut+`">
            <td>
                <input type="hidden" name="id_artikel" value="`+result.id_artikel+`">
                <span class="urut">`+nomor_urut+`</span>
            </td>
            <td><a href="javascript:void(0)" class="hapusArtikel text-danger" data-form="#formRetur" data-id="`+id_urut+`" data-nama="`+result.nama_artikel+` `+result.ukuran+`">`+result.nama_artikel+` `+result.ukuran+`</a></td>
            <td class="text-right"><input type="number" name="qty" class="form form-control form-control-md required"></td>
            <td class="text-right"><input type="number" name="diskon" class="form form-control form-control-md required"></td>
            <td class="text-right"><input type="number" name="disc_sale" class="form form-control form-control-md required"></td>
        </tr>
    `)

    $("#addRetur #btnSimpan").show();

    $("[name='cari_artikel']").val("");
    $(".listOfArtikelSelect").hide();
})

$(document).on("click", ".artikelReturDetail", function(){
    id_urut++;
    nomor_urut++;

    let id_artikel = $(this).data("id");
    let result = ajax(url_base+"artikel/get_artikel", "POST", {id_artikel : id_artikel});
    $("#listOfArtikelReturDetail").append(`
        <tr id="`+id_urut+`">
            <td>
                <input type="hidden" name="id_artikel" value="`+result.id_artikel+`">
                <span class="urut">`+nomor_urut+`</span>
            </td>
            <td><a href="javascript:void(0)" class="hapusArtikel text-danger" data-form="#formDetailRetur" data-id="`+id_urut+`" data-nama="`+result.nama_artikel+` `+result.ukuran+`">`+result.nama_artikel+` `+result.ukuran+`</a></td>
            <td class="text-right"><input type="number" name="qty" class="form form-control form-control-md required"></td>
            <td class="text-right"><input type="number" name="diskon" class="form form-control form-control-md required"></td>
            <td class="text-right"><input type="number" name="disc_sale" class="form form-control form-control-md required"></td>
        </tr>
    `)

    $("#detailRetur #btnSimpan").show();

    $("[name='cari_artikel']").val("");
    $(".listOfArtikelSelect").hide();
})

$("#addRetur #btnSimpan").click(function(){
    Swal.fire({
        icon: 'question',
        text: 'Yakin akan menambahkan retur baru?',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then(function (result) {
        if (result.value) {
            let form = "#formRetur";
            let formData = {};
            $(form+" .form").each(function(){
                formData = Object.assign(formData, {[$(this).attr("name")]: $(this).val()})
            })

            id_artikel = new Array();
            $.each($(form+" [name='id_artikel']"), function(){
                id_artikel.push($(this).val());
            });

            qty = new Array();
            $.each($(form+" [name='qty']"), function(){
                qty.push($(this).val());
            });

            diskon = new Array();
            $.each($(form+" [name='diskon']"), function(){
                diskon.push($(this).val());
            });

            disc_sale = new Array();
            $.each($(form+" [name='disc_sale']"), function(){
                disc_sale.push($(this).val());
            });

            formData = Object.assign(formData, {id_artikel:id_artikel});
            formData = Object.assign(formData, {qty:qty});
            formData = Object.assign(formData, {diskon:diskon});
            formData = Object.assign(formData, {disc_sale:disc_sale});

            let eror = required(form);

            if( eror == 1){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'lengkapi isi form terlebih dahulu'
                })
            } else {
                let id_store = $("#formRetur [name='id_store']").val();

                let result = ajax(url_base+"store/add_retur", "POST", formData);

                if(result == 1){

                    $(form).trigger('reset');
                    $("#addRetur").modal('hide');

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        text: 'Berhasil menambahkan data retur',
                        showConfirmButton: false,
                        timer: 1500
                    })

                    id_urut = 0;
                    nomor_urut = 0;

                    updateRetur(id_store);
                    assetStore(id_store);

                    $(".btnRetur").removeClass("btn-primary");
                    $(".btnRetur").removeClass("btn-secondary");
                    $(".btnRetur").addClass("btn-primary");

                    $(".btnConsigment").removeClass("btn-primary");
                    $(".btnConsigment").removeClass("btn-secondary");
                    $(".btnConsigment").addClass("btn-secondary");
                    
                    $(".btnPencairan").removeClass("btn-primary");
                    $(".btnPencairan").removeClass("btn-secondary");
                    $(".btnPencairan").addClass("btn-secondary");

                    $("#menuConsigment").hide();
                    $("#menuPencairan").hide();
                    $("#menuRetur").show();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'terjadi kesalahan, silahkan mulai ulang halaman'
                    })
                }
            }
        }
    })
})

$(document).on("click", ".btnDetailRetur", function(){
    id_urut = 0;
    nomor_urut = 0;

    let id_retur = $(this).data("id");
    let result = ajax(url_base+"store/detail_retur", "POST", {id_retur:id_retur});

    let  form = "#formDetailRetur";

    $(form+" [name='id_store']").val(result.retur.id_store);
    $(form+" [name='id_retur']").val(result.retur.id_retur);
    $(form+" [name='tgl_retur']").val(result.retur.tgl_retur);
    $(form+" [name='keterangan']").html(result.retur.keterangan);

    html_detail = "";

    result.detail_retur.forEach(detail => {
        id_urut++;
        nomor_urut++;

        html_detail += `
        <tr id="`+id_urut+`">
            <td>
                <input type="hidden" name="id_artikel" value="`+detail.id_artikel+`">
                <span class="urut">`+nomor_urut+`</span>
            </td>
            <td>
                <a href="javascript:void(0)" class="hapusArtikel text-danger" data-form="`+form+`" data-id="`+id_urut+`" data-nama="`+detail.nama_artikel+` `+detail.ukuran+`">`+detail.nama_artikel+` `+detail.ukuran+`</a>
            </td>
            <td class="text-right">
                <input type="number" name="qty" class="form form-control form-control-md required" value="`+detail.qty+`">
            </td>
            <td class="text-right">
                <input type="number" name="diskon" class="form form-control form-control-md required" value="`+detail.diskon+`">
            </td>
            <td class="text-right">
                <input type="number" name="disc_sale" class="form form-control form-control-md required" value="`+detail.disc_sale+`">
            </td>
        </tr>
        `
    })

    $("#listOfArtikelReturDetail").html(html_detail);

    listOfArtikel('artikelReturDetail');
})

$("#detailRetur #btnEdit").click(function(){
    Swal.fire({
        icon: 'question',
        text: 'Yakin akan mengubah data retur?',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then(function (result) {
        if (result.value) {
            let form = "#formDetailRetur";
            let formData = {};
            $(form+" .form").each(function(){
                formData = Object.assign(formData, {[$(this).attr("name")]: $(this).val()})
            })

            id_artikel = new Array();
            $.each($("input[name='id_artikel']"), function(){
                id_artikel.push($(this).val());
            });

            qty = new Array();
            $.each($("input[name='qty']"), function(){
                qty.push($(this).val());
            });

            diskon = new Array();
            $.each($("input[name='diskon']"), function(){
                diskon.push($(this).val());
            });

            disc_sale = new Array();
            $.each($("input[name='disc_sale']"), function(){
                disc_sale.push($(this).val());
            });

            formData = Object.assign(formData, {id_artikel:id_artikel});
            formData = Object.assign(formData, {qty:qty});
            formData = Object.assign(formData, {diskon:diskon});
            formData = Object.assign(formData, {disc_sale:disc_sale});

            let eror = required(form);

            if( eror == 1){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'lengkapi isi form terlebih dahulu'
                })
            } else {
                let result = ajax(url_base+"store/edit_retur", "POST", formData);

                if(result == 1){
                    
                    id_store = $(form+" [name='id_store']").val();
                    listOfArtikel('artikelDetailRetur');
                    updateRetur(id_store);
                    assetStore(id_store);

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        text: 'Berhasil mengubah data retur',
                        showConfirmButton: false,
                        timer: 1500
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'terjadi kesalahan, silahkan mulai ulang halaman'
                    })
                }
            }
        }
    })
})

function updateRetur(id_store) {
    let result = ajax(url_base+"store/get_all_retur", "POST", {id_store:id_store});

    html = ""
    no = 1;
    result.forEach(data => {
        html += `
            <tr>
                <td>`+no+`</td>
                <td>`+data.tgl_retur+`</td>
                <td>`+data.item+`</td>
                <td>`+rupiah(data.total)+`</td>
                <td>`+data.keterangan+`</td>
                <td><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#detailRetur" data-id="`+data.id_retur+`" class="btn btn-info btnDetailRetur">`+tablerIcon("info-circle")+`</a></td>
            </tr>
        `
        no++;
    });

    $("#listRetur").html(html);
}

$(document).on("click", ".btnAddPencairan", function(){
    let id_store = $(this).data("id");

    $("[name='id_store']").val(id_store);
})

$("#addPencairan .btnTambah").click(function(){
    Swal.fire({
        icon: 'question',
        text: 'Yakin akan menambahkan pencairan baru?',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then(function (result) {
        if (result.value) {
            let form = "#formAddPencairan";
            let formData = {};
            $(form+" .form").each(function(index){
                formData = Object.assign(formData, {[$(this).attr("name")]: $(this).val()})
            })

            let eror = required(form);
            
            if( eror == 1){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'lengkapi isi form terlebih dahulu'
                })
            } else {
                let result = ajax(url_base+"store/add_pencairan", "POST", formData);

                if(result == 1){
                    let id_store = $("[name='id_store']").val();
                    $("#formAddPencairan").trigger("reset");

                    $("[name='id_store']").val(id_store);

                    updatePencairan(id_store);
                    assetStore(id_store);

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        text: 'Berhasil menambahkan data pencairan',
                        showConfirmButton: false,
                        timer: 1500
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'terjadi kesalahan, silahkan mulai ulang halaman'
                    })
                }
            }
        }
    })
})

$(document).on("click",".detailPencairan", function(){
    let form = "#detailPencairan";
    let id_pencairan = $(this).data("id");

    let data = {id_pencairan: id_pencairan};
    let result = ajax(url_base+"store/get_pencairan", "POST", data);
    
    $.each(result, function(key, value){
        $(form+" [name='"+key+"']").val(value)
    })
})

$("#detailPencairan .btnEdit").click(function(){
    Swal.fire({
        icon: 'question',
        text: 'Yakin akan merubah data pencairan?',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then(function (result) {
        if (result.value) {
            let form = "#detailPencairan";
            
            let formData = {};
            $(form+" .form").each(function(){
                formData = Object.assign(formData, {[$(this).attr("name")]: $(this).val()})
            })

            let eror = required(form);
            
            if( eror == 1){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'lengkapi isi form terlebih dahulu'
                })
            } else {
                let id_store = $(form+" [name='id_store']").val();
                let result = ajax(url_base+"store/edit_pencairan", "POST", formData);

                if(result == 1){
                    updatePencairan(id_store);
                    assetStore(id_store);

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        text: 'Berhasil merubah data pencairan',
                        showConfirmButton: false,
                        timer: 1500
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'terjadi kesalahan, silahkan mulai ulang halaman'
                    })
                }
            }
        }
    })
})

function updatePencairan(id_store) {
    let result = ajax(url_base+"store/get_all_pencairan", "POST", {id_store:id_store});

    html = ""
    no = 1;
    result.forEach(data => {
        html += `
            <tr>
                <td>`+no+`</td>
                <td>`+data.tgl_pencairan+`</td>
                <td>`+rupiah(data.nominal)+`</td>
                <td>`+data.catatan+`</td>
                <td><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#detailPencairan" data-id="`+data.id_pencairan+`" class="btn btn-info detailPencairan">`+tablerIcon("info-circle")+`</a></td>
            </tr>
        `
        no++;
    });

    $("#listPencairan").html(html);
}


// menu navigasi 
$(".btnConsigment").click(function(){
    $(".btnConsigment").removeClass("btn-primary");
    $(".btnConsigment").removeClass("btn-secondary");
    $(".btnConsigment").addClass("btn-primary");
    
    $(".btnRetur").removeClass("btn-primary");
    $(".btnRetur").removeClass("btn-secondary");
    $(".btnRetur").addClass("btn-secondary");
    
    $(".btnPencairan").removeClass("btn-primary");
    $(".btnPencairan").removeClass("btn-secondary");
    $(".btnPencairan").addClass("btn-secondary");

    $("#menuConsigment").show();
    $("#menuPencairan").hide();
    $("#menuRetur").hide();
})

$(".btnRetur").click(function(){
    $(".btnRetur").removeClass("btn-primary");
    $(".btnRetur").removeClass("btn-secondary");
    $(".btnRetur").addClass("btn-primary");

    $(".btnConsigment").removeClass("btn-primary");
    $(".btnConsigment").removeClass("btn-secondary");
    $(".btnConsigment").addClass("btn-secondary");
    
    $(".btnPencairan").removeClass("btn-primary");
    $(".btnPencairan").removeClass("btn-secondary");
    $(".btnPencairan").addClass("btn-secondary");

    $("#menuConsigment").hide();
    $("#menuPencairan").hide();
    $("#menuRetur").show();
})

$(".btnPencairan").click(function(){
    $(".btnPencairan").removeClass("btn-primary");
    $(".btnPencairan").removeClass("btn-secondary");
    $(".btnPencairan").addClass("btn-primary");

    $(".btnConsigment").removeClass("btn-primary");
    $(".btnConsigment").removeClass("btn-secondary");
    $(".btnConsigment").addClass("btn-secondary");
    
    $(".btnRetur").removeClass("btn-primary");
    $(".btnRetur").removeClass("btn-secondary");
    $(".btnRetur").addClass("btn-secondary");

    $("#menuConsigment").hide();
    $("#menuPencairan").show();
    $("#menuRetur").hide();
})

function assetStore(id_store) {
    let result = ajax(url_base+"store/get_asset_store", "POST", {id_store:id_store});

    $("#assetStore").html(rupiah(result));
}