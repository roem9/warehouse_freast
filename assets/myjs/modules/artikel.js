$(".btnAdd").click(function(){
    $(".ukuranAlphabet").hide();
    $(".ukuranAngka").hide();
})

$("#addArtikel .btnTambah").click(function(){
    Swal.fire({
        icon: 'question',
        text: 'Yakin akan menambahkan artikel baru?',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then(function (result) {
        if (result.value) {
            let form = "#addArtikel";
            let formData = {};
            $(form+" .form").each(function(index){
                formData = Object.assign(formData, {[$(this).attr("name")]: $(this).val()})
            })

            ukuran = new Array();
            $.each($("input[name='ukuran']"), function(){
                if($(this).prop('checked') == true){
                    ukuran.push($(this).val());
                }
            });

            formData = Object.assign(formData, {ukuran:ukuran});

            let eror = required(form);
            
            if( eror == 1){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'lengkapi isi form terlebih dahulu'
                })
            } else {
                let result = ajax(url_base+"artikel/add_artikel", "POST", formData);

                if(result == 1){
                    loadData();
                    $("#formAddArtikel").trigger("reset");

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        text: 'Berhasil menambahkan data artikel',
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

$(document).on("click",".detailArtikel", function(){
    let form = "#detailArtikel";
    let id_artikel = $(this).data("id");

    let data = {id_artikel: id_artikel};
    let result = ajax(url_base+"artikel/get_artikel", "POST", data);
    
    $.each(result, function(key, value){
        $(form+" [name='"+key+"']").val(value)
    })
})

// menyimpan hasil edit data
$("#detailArtikel .btnEdit").click(function(){
    Swal.fire({
        icon: 'question',
        text: 'Yakin akan merubah data artikel?',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then(function (result) {
        if (result.value) {
            let form = "#detailArtikel";
            
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
                let result = ajax(url_base+"artikel/edit_artikel", "POST", formData);

                if(result == 1){
                    loadData();

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        text: 'Berhasil merubah data artikel',
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

$(document).on("click", ".arsipArtikel", function(){
    let id_artikel = $(this).data("id");

    Swal.fire({
        icon: 'question',
        text: 'Yakin akan mengarsipkan data artikel ini?',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then(function (result) {
        if (result.value) {
            data = {id_artikel: id_artikel}
            let result = ajax(url_base+"artikel/arsip_artikel", "POST", data);

            if(result == 1){
                loadData();

                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    text: 'Berhasil mengarsipkan data artikel',
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

$(document).on("click", ".bukaArsipArtikel", function(){
    let id_artikel = $(this).data("id");

    Swal.fire({
        icon: 'question',
        text: 'Yakin akan membuka arsip data artikel ini?',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then(function (result) {
        if (result.value) {
            data = {id_artikel: id_artikel}
            let result = ajax(url_base+"artikel/buka_arsip_artikel", "POST", data);

            if(result == 1){
                loadData();

                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    text: 'Berhasil membuka arsip data artikel',
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

$("#addProduk .btnTambah").click(function(){
    Swal.fire({
        icon: 'question',
        text: 'Yakin akan menambahkan produk baru?',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then(function (result) {
        if (result.value) {
            let form = "#addProduk";
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
                let result = ajax(url_base+"artikel/add_produk", "POST", formData);

                if(result == 1){
                    loadData();
                    $("#formAddProduk").trigger("reset");
                    $(form).modal("hide");

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        text: 'Berhasil menambahkan data produk',
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

$(document).on("click",".detailProduk", function(){
    let form = "#detailProduk";
    let id_produk = $(this).data("id");

    let data = {id_produk: id_produk};
    let result = ajax(url_base+"artikel/get_produk", "POST", data);
    
    $.each(result, function(key, value){
        $(form+" [name='"+key+"']").val(value)
    })
})

// menyimpan hasil edit data
$("#detailProduk .btnEdit").click(function(){
    Swal.fire({
        icon: 'question',
        text: 'Yakin akan merubah data produk?',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then(function (result) {
        if (result.value) {
            let form = "#detailProduk";
            
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
                let result = ajax(url_base+"artikel/edit_produk", "POST", formData);

                if(result == 1){
                    loadData();

                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        text: 'Berhasil merubah data produk',
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

$(document).on("click", ".arsipProduk", function(){
    let id_produk = $(this).data("id");

    Swal.fire({
        icon: 'question',
        text: 'Yakin akan menghapus produk ini?',
        showCloseButton: true,
        showCancelButton: true,
        confirmButtonText: 'Ya',
        cancelButtonText: 'Tidak'
    }).then(function (result) {
        if (result.value) {
            data = {id_produk: id_produk}
            let result = ajax(url_base+"artikel/arsip_produk", "POST", data);

            if(result == 1){
                loadData();

                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    text: 'Berhasil menghapus produk',
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

$("[name='tipe_ukuran'").click(function(){
    let data = $(this).val();

    if(data == "Tanpa Ukuran" || data == ""){
        $(".ukuranAlphabet").hide();
        $(".ukuranAngka").hide();

        $("[name='nomor_terkecil']").removeClass("required")
        $("[name='nomor_terbesar']").removeClass("required")
    } else if(data == "Ukuran Alphabet"){
        $(".ukuranAlphabet").show();
        $(".ukuranAngka").hide();
        
        $("[name='nomor_terkecil']").removeClass("required")
        $("[name='nomor_terbesar']").removeClass("required")
    } else if(data == "Ukuran Angka"){
        $(".ukuranAlphabet").hide();
        $(".ukuranAngka").show();
        
        $("[name='nomor_terkecil']").addClass("required")
        $("[name='nomor_terbesar']").addClass("required")
    }
})