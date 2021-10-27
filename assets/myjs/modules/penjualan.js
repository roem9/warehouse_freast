$("[name='cari_artikel']").on('keyup', function(){
    var value = $(this).val().toLowerCase();
    if(value == "") $("#listOfArtikel").hide();
    else $("#listOfArtikel").show();

    $("#listOfArtikel li").each(function () {
        if ($(this).text().toLowerCase().search(value) > -1) {
            $(this).show();
            $(this).prev('.subjectName').last().show();
        } else {
            $(this).hide();
        }
    });
})

$(document).on("click", ".artikel", function(){
    urut++;
    index++;
    let id_artikel = $(this).data("id");
    let result = ajax(url_base+"artikel/get_artikel", "POST", {id_artikel : id_artikel});
    // console.log(result)
    $(".listOfArtikel").append(`
        <tr id="`+urut+`">
            <td>
                <a href="javascript:void(0)" class="hapusArtikel text-danger" data-id="`+index+`" data-nama="`+result.nama_artikel+` `+result.ukuran+`">`+result.nama_artikel+` `+result.ukuran+`</a> <br>
                <small>
                    Harga : `+formatRupiah(result.harga, "Rp")+` <br>
                    Sub Total : <span id="sub_total-`+index+`">Rp 0</span>
                </small>
            </td>
            <td class="text-right"><input type="number" name="qty" id="qty-`+index+`" class="form form-control form-control-md required number" data-id="`+index+`" style="padding-left: 5px; padding-right: 5px"></td>
            <td class="text-right">
                <input type="hidden" name="harga" value="`+result.harga+`" id="harga-`+index+`">
                <input type="hidden" name="sub_total" id="sub-`+index+`" value="0">
                <input type="hidden" name="id_artikel" value="`+result.id_artikel+`">
                <input type="number" name="diskon" value="`+result.diskon+`" class="form form-control form-control-md required number" id="diskon-`+index+`" data-id="`+index+`" style="padding-left: 5px; padding-right: 5px">
            </td>
        </tr>
    `)
    $("#btnSimpan").show();
    
    $("[name='cari_artikel']").val("");
    $("#listOfArtikel").hide();
})

$(document).on("keyup change", "input[name='qty']", function(){
    let urut = $(this).data("id");
    let form = "#formPenjualan";
    let qty = $(this).val();
    let diskon = $(form+" #diskon-"+urut).val();
    let harga = $(form+" #harga-"+urut).val();

    
    if(diskon == ""){
        diskon = 0
    }
    
    let sub_total = (harga - (harga * (diskon / 100))) * qty;

    $(form+" #sub-"+urut).val(sub_total);
    $(form+" #sub_total-"+urut).html(formatRupiah(sub_total.toString(), "Rp."));

    let total = 0;
    $.each($(form+" [name='sub_total']"), function(){
        total = parseInt(total) + parseInt($(this).val());
    })

    $("[name='total']").val(total);
    $("[name='total_belanja']").val(formatRupiah(total.toString(), "Rp."));

    $("[name='cash']").val("");
    $("[name='kembali']").val("");
})

$(document).on("keyup change", "input[name='diskon']", function(){
    let urut = $(this).data("id");
    let form = "#formPenjualan";
    let diskon = $(this).val();
    let qty = $(form+" #qty-"+urut).val();
    let harga = $(form+" #harga-"+urut).val();

    
    if(qty == ""){
        qty = 0
    }
    
    let sub_total = (harga - (harga * (diskon / 100))) * qty;

    $(form+" #sub-"+urut).val(sub_total);
    $(form+" #sub_total-"+urut).html(formatRupiah(sub_total.toString(), "Rp."));

    let total = 0;
    $.each($(form+" [name='sub_total']"), function(){
        total = parseInt(total) + parseInt($(this).val());
    })

    $("[name='total']").val(total);
    $("[name='total_belanja']").val(formatRupiah(total.toString(), "Rp."));

    $("[name='cash']").val("");
    $("[name='kembali']").val("");
})

$("[name='cash']").keyup(function(){
    let cash = $(this).val();
    cash = cash.replace("Rp.", "");
    cash = cash.replace(".", "");

    let total = $("[name='total']").val();
    let kembali = parseInt(cash) - parseInt(total);

    $("[name='kembali']").val(formatRupiah(kembali.toString(), "Rp."));
    if(kembali < 0){
        $("[name='kembali']").addClass("bg-red-lt")
    } else {
        $("[name='kembali']").removeClass("bg-red-lt")
    }
})

$(document).on("click", ".hapusArtikel", function(){
    let form = "#formPenjualan";
    let id = $(this).data("id");
    let nama = $(this).data("nama");
    // console.log(id, nama);

    Swal.fire({
        icon: 'question',
        text: 'Yakin menghapus '+nama+'?',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then(function (result) {
        if (result.value) {
            urut--;
            index--;
            $("#"+id).remove();
            let no = 1;
            $.each($(".container-xl .urut"), function(){
                $(this).html(no)
                no++
            })

            let total = 0;
            $.each($(form+" [name='sub_total']"), function(){
                total = parseInt(total) + parseInt($(this).val());
            })

            $("[name='total']").val(total);
            $("[name='total_belanja']").val(formatRupiah(total.toString(), "Rp."));

            $("[name='cash']").val("");
            $("[name='kembali']").val("");

            if(urut == 0){
                $("#btnSimpan").hide();
            }
        }
    })
})

$("#formPenjualan #btnSimpan").click(function(){
    Swal.fire({
        icon: 'question',
        text: 'Yakin akan menambahkan penjualan baru?',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then(function (result) {
        if (result.value) {
            let form = "#formPenjualan";
            let formData = {};
            $(form+" .form").each(function(index){
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

            sub_total = new Array();
            $.each($("input[name='sub_total']"), function(){
                sub_total.push($(this).val());
            });

            formData = Object.assign(formData, {id_artikel:id_artikel, qty:qty, diskon:diskon, sub_total:sub_total});

            let eror = required(form);

            if( eror == 1){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'lengkapi isi form terlebih dahulu'
                })
            } else {
                total = $("[name='total']").val();
                cash = $("[name='cash']").val();
                cash = cash.replace("Rp.", "");
                cash = cash.replace(".", "");

                let kembali = parseInt(cash) - parseInt(total);

                if(kembali < 0){
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'transaksi gagal, uang pelanggan kurang'
                    })
                } else {

                    let result = ajax(url_base+"penjualan/add_penjualan", "POST", formData);
    
                    if(result == 1){
                        urut = 0;
                        $("#btnSimpan").hide();
                    
                        $(form).trigger('reset');
                        $(".listOfArtikel").html("");
                        listOfArtikel();
    
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            text: 'Berhasil menambahkan data penjualan',
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
        }
    })
})

function listOfArtikel(){
    let result = ajax(url_base+"artikel/get_all_artikel", "POST");
    let html = "";

    result.forEach(artikel => {
        html += `
        <li class="list-group-item list-group-item-light text-dark">
            <div class="d-flex justify-content-between">
                `+ artikel.nama_artikel + ` ` + artikel.ukuran + ` (` + artikel.stok + `)
                <a href="javascript:void(0)" class="artikel text-success" data-id="`+artikel.id_artikel+`">
                    `+tablerIcon("square-plus", "me-1")+`
                </a>
            </div>
        </li>
        `
    })

    $("#listOfArtikel").html(html);
}

listOfArtikel();

$(document).on("click", ".arsipPenjualan", function(){
    let id_penjualan = $(this).data("id");

    Swal.fire({
        icon: 'question',
        text: 'Yakin akan mengarsipkan data penjualan ini?',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then(function (result) {
        if (result.value) {
            data = {id_penjualan: id_penjualan}
            let result = ajax(url_base+"penjualan/arsip_penjualan", "POST", data);

            if(result == 1){
                loadData();

                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    text: 'Berhasil mengarsipkan data',
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
    })
})

$(document).on("click", ".bukaArsipPenjualan", function(){
    let id_penjualan = $(this).data("id");

    Swal.fire({
        icon: 'question',
        text: 'Yakin akan membuka arsip data penjualan ini?',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then(function (result) {
        if (result.value) {
            data = {id_penjualan: id_penjualan}
            let result = ajax(url_base+"penjualan/buka_arsip_penjualan", "POST", data);

            if(result == 1){
                loadData();

                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    text: 'Berhasil membuka arsip data',
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
    })
})

$("#formPenjualan #btnEdit").click(function(){
    Swal.fire({
        icon: 'question',
        text: 'Yakin akan mengubah data penjualan?',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then(function (result) {
        if (result.value) {
            let form = "#formPenjualan";
            let formData = {};
            $(form+" .form").each(function(index){
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

            sub_total = new Array();
            $.each($("input[name='sub_total']"), function(){
                sub_total.push($(this).val());
            });

            formData = Object.assign(formData, {id_artikel:id_artikel, qty:qty, diskon:diskon, sub_total:sub_total});

            let eror = required(form);

            if( eror == 1){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'lengkapi isi form terlebih dahulu'
                })
            } else {
                let result = ajax(url_base+"penjualan/edit_penjualan", "POST", formData);

                if(result == 1){
                    listOfArtikel();

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        text: 'Berhasil mengubah data penjualan',
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