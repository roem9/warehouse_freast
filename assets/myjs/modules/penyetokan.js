// let urut = 0;
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
    let id_artikel = $(this).data("id");
    let result = ajax(url_base+"artikel/get_artikel", "POST", {id_artikel : id_artikel});
    // console.log(result)
    $(".listOfArtikel").append(`
        <tr id="`+urut+`">
            <td>
                <input type="hidden" name="id_artikel" value="`+result.id_artikel+`">
                <span class="urut">`+urut+`</span>
            </td>
            <td><a href="javascript:void(0)" class="hapusArtikel text-danger" data-id="`+urut+`" data-nama="`+result.nama_artikel+` `+result.ukuran+`">`+result.nama_artikel+` `+result.ukuran+`</a></td>
            <td class="text-right"><input type="number" name="qty" class="form form-control form-control-md required"></td>
        </tr>
    `)

    $("#btnSimpan").show();

    $("[name='cari_artikel']").val("");
    $("#listOfArtikel").hide();
})

$(document).on("click", ".hapusArtikel", function(){
    let id = $(this).data("id");
    let nama = $(this).data("nama");

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
            $("#"+id).remove();
            let index = 1;
            $.each($(".container-xl .urut"), function(){
                $(this).html(index)
                index++
            })

            if(urut == 0){
                $("#btnSimpan").hide();
            }
        }
    })
})

$("#formPenyetokan #btnSimpan").click(function(){
    Swal.fire({
        icon: 'question',
        text: 'Yakin akan menambahkan penyetokan baru?',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then(function (result) {
        if (result.value) {
            let form = "#formPenyetokan";
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

            formData = Object.assign(formData, {id_artikel:id_artikel});
            formData = Object.assign(formData, {qty:qty});

            let eror = required(form);

            if( eror == 1){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'lengkapi isi form terlebih dahulu'
                })
            } else {
                let result = ajax(url_base+"penyetokan/add_penyetokan", "POST", formData);

                if(result == 1){
                    urut = 0;
                    $("#btnSimpan").hide();
                
                    $(form).trigger('reset');
                    $(".listOfArtikel").html("");
                    listOfArtikel();

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        text: 'Berhasil menambahkan data penyetokan',
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

$(document).on("click", ".arsipPenyetokan", function(){
    let id_penyetokan = $(this).data("id");

    Swal.fire({
        icon: 'question',
        text: 'Yakin akan mengarsipkan data penyetokan ini?',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then(function (result) {
        if (result.value) {
            data = {id_penyetokan: id_penyetokan}
            let result = ajax(url_base+"penyetokan/arsip_penyetokan", "POST", data);

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

$(document).on("click", ".bukaArsipPenyetokan", function(){
    let id_penyetokan = $(this).data("id");

    Swal.fire({
        icon: 'question',
        text: 'Yakin akan membuka arsip data penyetokan ini?',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then(function (result) {
        if (result.value) {
            data = {id_penyetokan: id_penyetokan}
            let result = ajax(url_base+"penyetokan/buka_arsip_penyetokan", "POST", data);

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

$("#formPenyetokan #btnEdit").click(function(){
    Swal.fire({
        icon: 'question',
        text: 'Yakin akan mengubah data penyetokan?',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then(function (result) {
        if (result.value) {
            let form = "#formPenyetokan";
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

            formData = Object.assign(formData, {id_artikel:id_artikel});
            formData = Object.assign(formData, {qty:qty});

            let eror = required(form);

            if( eror == 1){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'lengkapi isi form terlebih dahulu'
                })
            } else {
                let result = ajax(url_base+"penyetokan/edit_penyetokan", "POST", formData);

                if(result == 1){
                    listOfArtikel();

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        text: 'Berhasil mengubah data penyetokan',
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