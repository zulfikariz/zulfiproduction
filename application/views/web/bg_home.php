<div id="content-center">
<h1>Kami Hadir Untuk Anda | Harmonis Grosir Sandal Online</h1>
Assalamualaikum wr. Wb<br />
<p align="justify">SELAMAT DATANG di Harmonis Grosir sandal.com.  grosir sandal  Termurah dan Terlengkap.
Kami menyadari Indonesia begitu luas, untuk itulah kami hadir sebagai solusi untuk anda yang belum menjadi pelanggan atau yang sudah menjadi pelanggan kami dari uar kota agar tidak di repotkan dengan pemilihan model sandal .</p>
<p align="justify">Dengan prinsip bisnis JUJUR dan Amanah kami memulai bisnis ini, dari yang dahulu menjual dor to dor kemudian mulai nganvas ke pasar-pasar dan Alhamdulillah sekarang udah ke Online. Harapan kami semoga produk  kami bisa diterima di pasaran dalam dan luar negeri. Amien..</p>
<p align="justify">Untuk melakukan order Anda harus menjadi member terlebih dahulu jika belum Anda dengan mudah bisa mendaftar sebagai member dengan cara mengklik <a href="<?php echo base_url(); ?>member">"<strong>Member Area</strong>"</a>. Untuk keterangan lebih detail dengan cara belanja anda bisa melihat bagian halaman <a href="<?php echo base_url(); ?>cara_belanja">"<strong>Cara Belanja</strong>"</a>. Bila anda menemui kesulitan jangan sungkan untuk menghubungi bagian costumer service kami via YM atau Anda juga bisa menghubungi Hotline kami di 081916675856. Kepuasan Anda adalah bagian dari kebanggan kami.</p>
Selamat berbelanja...<br /><br />
Salam owner<br />
HERI KUSWANTO

<div class="cleaner_h20"></div>
<?php
foreach($slide_produk_home->result_array() as $sph)
{
$tss = "";
$mati = "";
if($sph['stok']>0)
{
	$tss = '<span style="margin:0px auto; padding:0px; font-size:12px;"><b>Ada</b></span>';
	$mati = "";
}
else
{
	$tss = '<span style="margin:0px auto; padding:0px; font-size:12px; color:red;"><b>Habis</b></span>';
	$mati = "disabled";
}
	$link_mentah = str_replace(' ','-',$sph['nama_produk']);
	$link = strtolower($link_mentah);
	echo '
<form method="post" action="'.base_url().'keranjang/tambah_barang">
<input type="hidden" name="kode_produk" value="'.$sph['kode_produk'].'">
<input type="hidden" name="banyak" value="5">
<input type="hidden" name="harga" value="'.$sph['harga'].'">
<input type="hidden" name="nama_produk" value="'.$sph['nama_produk'].'">
<div class="thumb-produk">
<p style="text-align:center; height:40px; margin:0px auto;"><strong>'.$sph['nama_produk'].'</strong></p><p style="text-align:center; margin:0px auto;"><img src="'.base_url().'asset/produk/'.$sph['gbr_kecil'].'" width="100" /><br />Rp. '.number_format($sph['harga'],2,',','.').' | Stok : '.$tss.'<div style="width:152px; margin:0px auto; padding:0px;"><input type="submit" class="tombol-beli" value="" '.$mati.'><a href="'.base_url().'produk/detail/'.$sph['kode_produk'].'-'.$link.'" class="vtip" title="'.$sph['nama_produk'].' - Harga Rp.'.number_format($sph['harga'],2,',','.').'"><img src="'.base_url().'asset/images/bar-detail.png" border=0 style="float:right;" /></a></div></p></div></form>';
}
?>
<p style="text-align:center;"><a href="<?php echo base_url(); ?>produk"><img src="<?php echo base_url(); ?>asset/images/semua-produk.png" border="0" /></a></p>
</div>
