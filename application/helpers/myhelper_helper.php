<?php
    function tablerIcon($icon, $margin = ""){
        return '
            <svg width="24" height="24" class="'.$margin.'">
                <use xlink:href="'.base_url().'assets/tabler-icons-1.39.1/tabler-sprite.svg#tabler-'.$icon.'" />
            </svg>';
    }

    function hari_indo($hari){
        switch($hari){
            case 'Sun':
                $hari_ini = "Minggu";
            break;

            case 'Mon':			
                $hari_ini = "Senin";
            break;
    
            case 'Tue':
                $hari_ini = "Selasa";
            break;
    
            case 'Wed':
                $hari_ini = "Rabu";
            break;
    
            case 'Thu':
                $hari_ini = "Kamis";
            break;
    
            case 'Fri':
                $hari_ini = "Jumat";
            break;
    
            case 'Sat':
                $hari_ini = "Sabtu";
            break;
            
            default:
                $hari_ini = "Tidak di ketahui";
            break;
        }
        return $hari_ini;
    }

    function tgl_indo($tgl, $day = ""){
        $data = explode("-", $tgl);
        $hari = $data[2];
        $bulan = $data[1];
        $tahun = $data[0];

        if($bulan == "01") $bulan = "Januari";
        if($bulan == "02") $bulan = "Februari";
        if($bulan == "03") $bulan = "Maret";
        if($bulan == "04") $bulan = "April";
        if($bulan == "05") $bulan = "Mei";
        if($bulan == "06") $bulan = "Juni";
        if($bulan == "07") $bulan = "Juli";
        if($bulan == "08") $bulan = "Agustus";
        if($bulan == "09") $bulan = "September";
        if($bulan == "10") $bulan = "Oktober";
        if($bulan == "11") $bulan = "November";
        if($bulan == "12") $bulan = "Desember";

        if($day == TRUE){
            $hari_indo = hari_indo(date("D", strtotime($tgl)));

            return $hari_indo . ", " . $hari . " " . $bulan . " " . $tahun;
        } else {
            return $hari . " " . $bulan . " " . $tahun;
        }
    }

    function tgl_waktu($tgl, $day = ""){
        
        $tgl = date("Y-m-d-H-i", strtotime($tgl));
        $data = explode("-", $tgl);
        $hari = $data[2];
        $bulan = $data[1];
        $tahun = $data[0];
        $jam = $data[3];
        $menit = $data[4];

        if($bulan == "01") $bulan = "Januari";
        if($bulan == "02") $bulan = "Februari";
        if($bulan == "03") $bulan = "Maret";
        if($bulan == "04") $bulan = "April";
        if($bulan == "05") $bulan = "Mei";
        if($bulan == "06") $bulan = "Juni";
        if($bulan == "07") $bulan = "Juli";
        if($bulan == "08") $bulan = "Agustus";
        if($bulan == "09") $bulan = "September";
        if($bulan == "10") $bulan = "Oktober";
        if($bulan == "11") $bulan = "November";
        if($bulan == "12") $bulan = "Desember";

        if($day == TRUE){
            $hari_indo = hari_indo(date("D", strtotime($tgl)));

            return $hari_indo . ", " . $hari . " " . $bulan . " " . $tahun . " " . $jam . ":" . $menit;
        } else {
            return $hari . " " . $bulan . " " . $tahun . " " . $jam . ":" . $menit;
        }
    }

    function stok_artikel($id_artikel){
        $CI =& get_instance();

        $CI->db->select("SUM(qty) as stok");
        $CI->db->from("detail_penyetokan");
        $CI->db->where(["id_artikel" => $id_artikel]);
        $CI->db->where(["hapus" => 0]);
        $penyetokan = $CI->db->get()->row_array();
        
        $CI->db->select("SUM(qty) as stok");
        $CI->db->from("detail_penjualan");
        $CI->db->where(["id_artikel" => $id_artikel]);
        $CI->db->where(["hapus" => 0]);
        $penjualan = $CI->db->get()->row_array();

        $CI->db->select("SUM(qty) as stok");
        $CI->db->from("detail_konsinyasi");
        $CI->db->where(["id_artikel" => $id_artikel]);
        $CI->db->where(["hapus" => 0]);
        $konsinyasi = $CI->db->get()->row_array();

        $CI->db->select("SUM(qty) as stok");
        $CI->db->from("detail_retur");
        $CI->db->where(["id_artikel" => $id_artikel]);
        $CI->db->where(["hapus" => 0]);
        $retur = $CI->db->get()->row_array();

        return $penyetokan['stok'] - $penjualan['stok'] - $konsinyasi['stok'] + $retur['stok'];
    }

    function produk(){
        $CI =& get_instance();
        $CI->db->from("produk");
        $CI->db->where("hapus", "0");
        $CI->db->order_by("produk");
        return $CI->db->get()->result_array();
    }

    function list_artikel(){
        $CI =& get_instance();
        $CI->db->from("artikel");
        $CI->db->where("hapus", "0");
        $CI->db->order_by("nama_artikel");
        return $CI->db->get()->result_array();
    }

    function rupiah_to_int($data){
        $data = str_replace("Rp. ", "", $data);
        $data = str_replace(".", "", $data);
        return $data;
    }

    function rupiah($angka){
        $hasil_rupiah = "Rp. " . number_format($angka,0,',','.');
        return $hasil_rupiah;
    }

    function item_penyetokan($id_penyetokan){
        $CI =& get_instance();
        $CI->db->select("SUM(qty) as stok");
        $CI->db->from("detail_penyetokan");
        $CI->db->where(["id_penyetokan" => $id_penyetokan]);
        
        $stok = $CI->db->get()->row_array();

        if($stok) return $stok['stok'];
        else return 0;
    }

    function item_penjualan($id_penjualan){
        $CI =& get_instance();
        $CI->db->select("SUM(qty) as stok");
        $CI->db->from("detail_penjualan");
        $CI->db->where(["id_penjualan" => $id_penjualan]);
        
        $stok = $CI->db->get()->row_array();

        if($stok) return $stok['stok'];
        else return 0;
    }

    function assetStore($id_store){
        $CI =& get_instance();

        $CI->db->from("konsinyasi");
        $CI->db->where(["hapus" => 0, "id_store" => $id_store]);
        $konsinyasi = $CI->db->get()->result_array();

        $assetKonsinyasi = 0;
        if($konsinyasi){
            foreach ($konsinyasi as $i => $konsinyasi) {
                $CI->db->from("detail_konsinyasi");
                $CI->db->where(["id_konsinyasi" => $konsinyasi['id_konsinyasi']]);
                $detail_konsinyasi = $CI->db->get()->result_array();
    
                foreach ($detail_konsinyasi as $detail) {
                    $detail_konsinyasi = $detail['qty'] * (($detail['harga'] - ($detail['harga'] * ($detail['disc_sale'] / 100))) - (($detail['harga'] - ($detail['harga'] * ($detail['disc_sale'] / 100))) * ($detail['diskon'] / 100)));
                }
    
                $assetKonsinyasi += $detail_konsinyasi;
            }
        }

        $CI->db->from("retur");
        $CI->db->where(["hapus" => 0, "id_store" => $id_store]);
        $retur = $CI->db->get()->result_array();

        $assetRetur = 0;
        if($retur){
            foreach ($retur as $i => $retur) {
                $CI->db->from("detail_retur");
                $CI->db->where(["id_retur" => $retur['id_retur']]);
                $detail_retur = $CI->db->get()->result_array();
    
                foreach ($detail_retur as $detail) {
                    $detail_retur = $detail['qty'] * (($detail['harga'] - ($detail['harga'] * ($detail['disc_sale'] / 100))) - (($detail['harga'] - ($detail['harga'] * ($detail['disc_sale'] / 100))) * ($detail['diskon'] / 100)));
                }
    
                $assetRetur += $detail_retur;
            }
        }

        $CI->db->select("SUM(nominal) as nominal");
        $CI->db->from("pencairan_store");
        $CI->db->where(["id_store" => $id_store]);
        $pencairan = $CI->db->get()->row_array();

        return $assetKonsinyasi - $assetRetur - $pencairan['nominal'];
    }