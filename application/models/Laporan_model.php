<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends MY_Model {
    public function downloadLaporan(){
        $laporan = $this->input->post("laporan");

        date_default_timezone_set('Asia/Makassar');

        if($laporan == "Stok Artikel"){
            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-P', 'margin_top' => '15', 'margin_left' => '25', 'margin_right' => '25', 'margin_bottom' => '30']);

            $mpdf->setHTMLFooter("<div style='text-align: right;'>".date('H:i:s d-M-Y')."</div>");
            $mpdf->setHTMLHeader("<div style='text-align: right;'>{PAGENO}</div>");
            $mpdf->SetTitle("Laporan Stok Artikel");
            $mpdf->WriteHTML('
                <table border="1" style="border-collapse:collapse">
                    <thead>
                        <tr height="20">
                            <th colspan="4" style="padding: 10px; border: 0mm solid black;"><center>Laporan Stok Artikel</center></th>
                        </tr>
                        <tr>
                            <th style="padding: 5px; width: 5%">No</th>
                            <th style="padding: 5px; width: 65%">Nama Artikel</th>
                            <th style="padding: 5px; width: 20%">Ukuran</th>
                            <th style="padding: 5px; width: 10%">Stok</th>
                        </tr>
                    </thead>
                    <tbody>');
            
            $artikel = $this->get_all("artikel", "", "nama_artikel");
            
            $i = 1;
            foreach ($artikel as $artikel) {
                $artikel['stok'] = stok_artikel($artikel['id_artikel']);
                $mpdf->WriteHTML("
                    <tr>
                        <td style='padding: 5px'><center>{$i}</center></td>
                        <td style='padding: 5px'>{$artikel['nama_artikel']}</td>
                        <td style='padding: 5px'><center>{$artikel['ukuran']}</center></td>
                        <td style='padding: 5px'><center>{$artikel['stok']}</center></td>
                    </tr>");
                
                $i++;
            }
            $mpdf->WriteHTML('
                    </tbody>
                </table>
            ');
            $mpdf->Output("stok_".time().".pdf", "I");
        } else if($laporan == "Penyetokan"){
            $tgl_awal = $this->input->post("tgl_awal");
            $tgl_akhir = $this->input->post("tgl_akhir");

            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-P', 'margin_top' => '15', 'margin_left' => '25', 'margin_right' => '25', 'margin_bottom' => '30']);
            $mpdf->setHTMLFooter("<div style='text-align: right;'>".date('H:i:s d-M-Y')."</div>");
            $mpdf->setHTMLHeader("<div style='text-align: right;'>{PAGENO}</div>");
            $mpdf->SetTitle("Laporan Penyetokan " . tgl_indo($tgl_awal) . " s.d " . tgl_indo($tgl_akhir));
            $mpdf->WriteHTML('
                <table border="1" style="border-collapse:collapse">
                    <thead>
                        <tr height="20">
                            <th colspan="5" style="padding: 10px; border: 0mm solid black;"><center>Laporan Penyetokan ' . tgl_indo($tgl_awal) . " s.d " . tgl_indo($tgl_akhir) . '</center></th>
                        </tr>
                        <tr>
                            <th style="padding: 5px;">No</th>
                            <th style="padding: 5px;">Tgl</th>
                            <th style="padding: 5px;">User</th>
                            <th style="padding: 5px;">Keterangan</th>
                            <th style="padding: 5px;">Nama Artikel</th>
                            <th style="padding: 5px;">Ukuran</th>
                            <th style="padding: 5px;">QTY</th>
                        </tr>
                    </thead>
                    <tbody>');

            $penyetokan = $this->get_all("penyetokan", "tgl_penyetokan BETWEEN '$tgl_awal' AND '$tgl_akhir'", "tgl_penyetokan");
            
            $i = 1;
            foreach ($penyetokan as $penyetokan) {
                $admin = $this->get_one("admin", ["id_admin" => $penyetokan['id_admin']]);
                $artikel = $this->get_all("detail_penyetokan", ["id_penyetokan" => $penyetokan['id_penyetokan']]);
                $row = COUNT($artikel);

                foreach ($artikel as $z => $artikel) {
                    if($z == 0){
                        $mpdf->WriteHTML("
                            <tr>
                                <td style='padding: 5px' rowspan={$row}><center>{$i}</center></td>
                                <td style='padding: 5px' rowspan={$row}>".tgl_waktu($penyetokan['tgl_penyetokan'])."</td>
                                <td style='padding: 5px' rowspan={$row}>{$admin['nama']}</td>
                                <td style='padding: 5px' rowspan={$row}>{$penyetokan['keterangan']}</td>
                                <td style='padding: 5px'>{$artikel['nama_artikel']}</td>
                                <td style='padding: 5px'><center>{$artikel['ukuran']}</center></td>
                                <td style='padding: 5px'><center>{$artikel['qty']}</center></td>
                            </tr>");
                    } else {
                        $mpdf->WriteHTML("
                            <tr>
                                <td style='padding: 5px'>{$artikel['nama_artikel']}</td>
                                <td style='padding: 5px'><center>{$artikel['ukuran']}</center></td>
                                <td style='padding: 5px'><center>{$artikel['qty']}</center></td>
                            </tr>");
                    }
                }
                $i++;
            }
            $mpdf->WriteHTML('
                    </tbody>
                </table>
            ');
            $mpdf->Output("Laporan Penyetokan " . tgl_indo($tgl_awal) . " s.d " . tgl_indo($tgl_akhir) . time().".pdf", "I");
        } else if($laporan == "Penjualan"){
            $tgl_awal = $this->input->post("tgl_awal");
            $tgl_akhir = $this->input->post("tgl_akhir");

            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L', 'margin_top' => '15', 'margin_left' => '25', 'margin_right' => '25', 'margin_bottom' => '30']);
            $mpdf->setHTMLFooter("<div style='text-align: right;'>".date('H:i:s d-M-Y')."</div>");
            $mpdf->setHTMLHeader("<div style='text-align: right;'>{PAGENO}</div>");
            $mpdf->SetTitle("Laporan Penjualan " . tgl_indo($tgl_awal) . " s.d " . tgl_indo($tgl_akhir));
            $mpdf->WriteHTML('
                <table border="1" style="border-collapse:collapse">
                    <thead>
                        <tr height="20">
                            <th colspan="10" style="padding: 10px; border: 0mm solid black;"><center>Laporan Penjualan Tunai ' . tgl_indo($tgl_awal) . " s.d " . tgl_indo($tgl_akhir) . '</center></th>
                        </tr>
                        <tr>
                            <th style="padding: 5px;">No</th>
                            <th style="padding: 5px;">Tgl</th>
                            <th style="padding: 5px;">User</th>
                            <th style="padding: 5px;">Keterangan</th>
                            <th style="padding: 5px;">Nama Artikel</th>
                            <th style="padding: 5px;">Ukuran</th>
                            <th style="padding: 5px;">QTY</th>
                            <th style="padding: 5px;">Harga</th>
                            <th style="padding: 5px;">Diskon</th>
                            <th style="padding: 5px;">Sub Total</th>
                            <th style="padding: 5px;">Total</th>
                        </tr>
                    </thead>
                    <tbody>');

            $penjualan = $this->get_all("penjualan", ["tgl_penjualan BETWEEN '$tgl_awal' AND '$tgl_akhir'", "tipe_pembayaran" => "Tunai"], "tgl_penjualan");
            
            $i = 1;
            $total = 0;
            foreach ($penjualan as $penjualan) {
                $admin = $this->get_one("admin", ["id_admin" => $penjualan['id_admin']]);
                $artikel = $this->get_all("detail_penjualan", ["id_penjualan" => $penjualan['id_penjualan']]);
                $row = COUNT($artikel);

                foreach ($artikel as $z => $artikel) {
                    if($z == 0){
                        $mpdf->WriteHTML("
                            <tr>
                                <td style='padding: 5px' rowspan={$row}><center>{$i}</center></td>
                                <td style='padding: 5px' rowspan={$row}>".tgl_waktu($penjualan['tgl_penjualan'])."</td>
                                <td style='padding: 5px' rowspan={$row}>{$admin['nama']}</td>
                                <td style='padding: 5px' rowspan={$row}>{$penjualan['keterangan']}</td>
                                <td style='padding: 5px'>{$artikel['nama_artikel']}</td>
                                <td style='padding: 5px'><center>{$artikel['ukuran']}</center></td>
                                <td style='padding: 5px'><center>{$artikel['qty']}</center></td>
                                <td style='padding: 5px'>" . rupiah($artikel['harga']) . "</td>
                                <td style='padding: 5px'><center>{$artikel['diskon']}%</center></td>
                                <td style='padding: 5px'>" . rupiah($artikel['sub_total']) ."</td>
                                <td style='padding: 5px' rowspan={$row}>".rupiah($penjualan['total'])."</td>
                            </tr>");
                    } else {
                        $mpdf->WriteHTML("
                            <tr>
                                <td style='padding: 5px'>{$artikel['nama_artikel']}</td>
                                <td style='padding: 5px'><center>{$artikel['ukuran']}</center></td>
                                <td style='padding: 5px'><center>{$artikel['qty']}</center></td>
                                <td style='padding: 5px'>" . rupiah($artikel['harga']) . "</td>
                                <td style='padding: 5px'><center>{$artikel['diskon']}%</center></td>
                                <td style='padding: 5px'>" . rupiah($artikel['sub_total']) ."</td>
                            </tr>");
                    }

                    $total += $artikel['sub_total'];
                }
                $i++;
            }
            $mpdf->WriteHTML("
                        <tr>
                            <td style='padding: 5px' colspan='10'><b><center>Total</center></b></td>
                            <td style='padding: 5px'>" . rupiah($total) ."</td>
                        </tr>
                    </tbody>
                </table>
            ");
            
            $mpdf->AddPage();

            $mpdf->WriteHTML('
                <table border="1" style="border-collapse:collapse">
                    <thead>
                        <tr height="20">
                            <th colspan="10" style="padding: 10px; border: 0mm solid black;"><center>Laporan Penjualan Transfer ' . tgl_indo($tgl_awal) . " s.d " . tgl_indo($tgl_akhir) . '</center></th>
                        </tr>
                        <tr>
                            <th style="padding: 5px;">No</th>
                            <th style="padding: 5px;">Tgl</th>
                            <th style="padding: 5px;">User</th>
                            <th style="padding: 5px;">Keterangan</th>
                            <th style="padding: 5px;">Nama Artikel</th>
                            <th style="padding: 5px;">Ukuran</th>
                            <th style="padding: 5px;">QTY</th>
                            <th style="padding: 5px;">Harga</th>
                            <th style="padding: 5px;">Diskon</th>
                            <th style="padding: 5px;">Sub Total</th>
                            <th style="padding: 5px;">Total</th>
                        </tr>
                    </thead>
                    <tbody>');

            $penjualan = $this->get_all("penjualan", ["tgl_penjualan BETWEEN '$tgl_awal' AND '$tgl_akhir'", "tipe_pembayaran" => "Transfer"], "tgl_penjualan");
            
            $i = 1;
            $total = 0;
            foreach ($penjualan as $penjualan) {
                $admin = $this->get_one("admin", ["id_admin" => $penjualan['id_admin']]);
                $artikel = $this->get_all("detail_penjualan", ["id_penjualan" => $penjualan['id_penjualan']]);
                $row = COUNT($artikel);

                foreach ($artikel as $z => $artikel) {
                    if($z == 0){
                        $mpdf->WriteHTML("
                            <tr>
                                <td style='padding: 5px' rowspan={$row}><center>{$i}</center></td>
                                <td style='padding: 5px' rowspan={$row}>".tgl_waktu($penjualan['tgl_penjualan'])."</td>
                                <td style='padding: 5px' rowspan={$row}>{$admin['nama']}</td>
                                <td style='padding: 5px' rowspan={$row}>{$penjualan['keterangan']}</td>
                                <td style='padding: 5px'>{$artikel['nama_artikel']}</td>
                                <td style='padding: 5px'><center>{$artikel['ukuran']}</center></td>
                                <td style='padding: 5px'><center>{$artikel['qty']}</center></td>
                                <td style='padding: 5px'>" . rupiah($artikel['harga']) . "</td>
                                <td style='padding: 5px'><center>{$artikel['diskon']}%</center></td>
                                <td style='padding: 5px'>" . rupiah($artikel['sub_total']) ."</td>
                                <td style='padding: 5px' rowspan={$row}>".rupiah($penjualan['total'])."</td>
                            </tr>");
                    } else {
                        $mpdf->WriteHTML("
                            <tr>
                                <td style='padding: 5px'>{$artikel['nama_artikel']}</td>
                                <td style='padding: 5px'><center>{$artikel['ukuran']}</center></td>
                                <td style='padding: 5px'><center>{$artikel['qty']}</center></td>
                                <td style='padding: 5px'>" . rupiah($artikel['harga']) . "</td>
                                <td style='padding: 5px'><center>{$artikel['diskon']}%</center></td>
                                <td style='padding: 5px'>" . rupiah($artikel['sub_total']) ."</td>
                            </tr>");
                    }

                    $total += $artikel['sub_total'];
                }
                $i++;
            }
            $mpdf->WriteHTML("
                        <tr>
                            <td style='padding: 5px' colspan='10'><b><center>Total</center></b></td>
                            <td style='padding: 5px'>" . rupiah($total) ."</td>
                        </tr>
                    </tbody>
                </table>
            ");

            $mpdf->Output("Laporan Penjualan " . tgl_indo($tgl_awal) . " s.d " . tgl_indo($tgl_akhir) . time().".pdf", "I");
        } else if($laporan == "Penjualan Artikel"){
            $tgl_awal = $this->input->post("tgl_awal");
            $tgl_akhir = $this->input->post("tgl_akhir");

            $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-P', 'margin_top' => '15', 'margin_left' => '25', 'margin_right' => '25', 'margin_bottom' => '30']);

            $mpdf->setHTMLFooter("<div style='text-align: right;'>".date('H:i:s d-M-Y')."</div>");
            $mpdf->setHTMLHeader("<div style='text-align: right;'>{PAGENO}</div>");
            $mpdf->SetTitle("Laporan Penjualan Artikel " . tgl_indo($tgl_awal) . " s.d " . tgl_indo($tgl_akhir));
            $mpdf->WriteHTML('
                <table border="1" style="border-collapse:collapse">
                    <thead>
                        <tr height="20">
                            <th colspan="4" style="padding: 10px; border: 0mm solid black;"><center>Laporan Penjualan Artikel ' . tgl_indo($tgl_awal) . " s.d " . tgl_indo($tgl_akhir) . '</center></th>
                        </tr>
                        <tr>
                            <th style="padding: 5px; width: 5%">No</th>
                            <th style="padding: 5px; width: 20%">Produk</th>
                            <th style="padding: 5px; width: 50%">Nama Artikel</th>
                            <th style="padding: 5px; width: 20%">Ukuran</th>
                            <th style="padding: 5px; width: 10%">Penjualan</th>
                        </tr>
                    </thead>
                    <tbody>');
            
            $this->db->select("id_artikel, nama_artikel, ukuran, SUM(qty) as qty");
            $this->db->from("detail_penjualan as a");
            $this->db->join("penjualan as b", "a.id_penjualan = b.id_penjualan");
            $this->db->where("b.tgl_penjualan BETWEEN '$tgl_awal' AND '$tgl_akhir'");
            $this->db->group_by("id_artikel");
            $this->db->order_by("qty", "DESC");
            $artikel = $this->db->get()->result_array();
            
            $i = 1;
            foreach ($artikel as $artikel) {
                $produk = $this->get_one("artikel", ["id_artikel" => $artikel['id_artikel']]);
                $mpdf->WriteHTML("
                    <tr>
                        <td style='padding: 5px'><center>{$i}</center></td>
                        <td style='padding: 5px'>{$produk['produk']}</td>
                        <td style='padding: 5px'>{$artikel['nama_artikel']}</td>
                        <td style='padding: 5px'><center>{$artikel['ukuran']}</center></td>
                        <td style='padding: 5px'><center>{$artikel['qty']}</center></td>
                    </tr>");
                
                $i++;
            }
            $mpdf->WriteHTML('
                    </tbody>
                </table>
            ');
            $mpdf->Output("Laporan Penjualan Artikel " . tgl_indo($tgl_awal) . " s.d " . tgl_indo($tgl_akhir) . time().".pdf", "I");
        }
    }
}

/* End of file Laporan_model.php */
