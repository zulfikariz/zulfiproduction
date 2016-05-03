<div id="content-center">
<div style="padding:5px; border:1px solid #ccc; margin-bottom:10px;"><a href="<?php echo base_url(); ?>">Beranda</a> > <a href="<?php echo base_url(); ?>kategori/produk/<?php echo $link; ?>"><?php echo 'Kategori '.$nama_kategori; ?></a> > <?php echo $nama_produk; ?></div>

<?php
foreach($detail_produk->result_array() as $dp)
{
			$c = array (' ');
    		$d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+');
			$s = strtolower(str_replace($d,"",$dp['nama_produk']));
			$link = strtolower(str_replace($c, '-', $s));
?>
<iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo base_url(); ?>produk/detail/<?php echo strtolower($dp['kode_produk']); ?>-<?php echo $link; ?>
&layout=standard&show_faces=false&width=500&action=recommend&colorscheme=light&height=40" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:500px; height:40px; color:#FFFFFF;" allowTransparency="true"></iframe>
<?php
echo '<h1>'.$dp['nama_produk'].'</h1>';
?>
<div class="share">Bagikan Produk ini ke : 
	<script language="javascript">
document.write("<a href='http://twitter.com/home/?status=" + document.URL + "' target='_blank'> Twitter</a> | <a href='http://www.facebook.com/share.php?u=" + document.URL + "' target='_blank'> Facebook</a> | <a href='http://www.reddit.com/submit?url=" + document.URL + "' target='_blank'> Reddit</a> | <a href='http://digg.com/submit?url=" + document.URL + "' target='_blank'> Digg</a>");
</script>
</div>
<div class="cleaner_h10"></div>
<?php
$ts = "";
$tmati = "";
if($dp['stok']>0)
{
	$ts = '<span style="margin:0px auto; padding:0px; font-size:12px;"><b>Stok Barang Tersedia</b></span>';
	$tmati = "";
}
else
{
	$ts = '<span style="margin:0px auto; padding:0px; font-size:12px; color:red;"><b>Maaf, Stok Barang Habis</b></span>';
	$tmati = "disabled";
}
echo '<form method="post" action="'.base_url().'keranjang/tambah_barang">
<table width="100%">
<tr><td rowspan=5><img src='.base_url().'asset/produk/'.$dp['gbr_kecil'].' width=150></td>
<td>Harga </td><td>:</td><td><span style="margin:0px auto; padding:0px; font-size:15px;"><b>Rp.'.number_format($dp['harga'],2,',','.').'</b></span> -per pasang</td></tr>
<tr><td>Stok Barang </td><td>:</td><td>'.$ts.'</td></tr>
<tr><td>Ukuran Sandal </td><td>:</td><td>';

$kcl=0; $bsr=0;
if($dp['tipe_produk']=='wanita'){$kcl=36; $bsr=40;}
else if($dp['tipe_produk']=='pria'){$kcl=38; $bsr=42;}
else if($dp['tipe_produk']=='tanggung'){$kcl=31; $bsr=35;}
else if($dp['tipe_produk']=='anak'){$kcl=30; $bsr=34;}
else if($dp['tipe_produk']=='baby'){$kcl=25; $bsr=29;}

for($kcl;$kcl<=$bsr;$kcl++)
{
	echo $kcl.', ';
}
echo '</td></tr>

<tr><td>Jumlah Pesanan </td><td>:</td><td>
<select name="banyak">';
for($j=5;$j<=200;$j+=5)
{
	echo '<option value="'.$j.'">'.$j.'</option>';
}
$harga_5pasang = $dp['harga']*5;
echo '</select>
<input type="hidden" name="kode_produk" value="'.$dp['kode_produk'].'">
<input type="hidden" name="harga" value="'.$dp['harga'].'">
<input type="hidden" name="nama_produk" value="'.$dp['nama_produk'].'">
<tr><td colspan=3><input type="submit" value="" class="tombol-beli-produk" '.$tmati.'></td></tr>
<tr><td><a href="'.base_url().'asset/produk/imgoriginal/'.$dp['gbr_besar'].'" rel="example_group" title="'.$dp['nama_produk'].' - Harga Rp.'.number_format($dp['harga'],2,',','.').'"><div class="tombol-perbesar">Perbesar Gambar Produk</div></a></td><td colspan=3>NB : Order Minimal 5 pasang (seri) & berlaku kelipatannya</td></tr>
<tr><td colspan=4><b>Deskripsi Produk</b></td></tr>
<tr><td colspan=4>';
if($dp['deskripsi']==null)
{ 
	echo "Deskripsi produk masih kosong."; 
} 
else 
{ 
	echo $dp['deskripsi']; 
}
echo '</td></tr>
</table></form>';
}
?>
<div class="share">Bagikan Produk ini ke : 
	<script language="javascript">
document.write("<a href='http://twitter.com/home/?status=" + document.URL + "' target='_blank'> Twitter</a> | <a href='http://www.facebook.com/share.php?u=" + document.URL + "' target='_blank'> Facebook</a> | <a href='http://www.reddit.com/submit?url=" + document.URL + "' target='_blank'> Reddit</a> | <a href='http://digg.com/submit?url=" + document.URL + "' target='_blank'> Digg</a>");
</script>
</div>


<div class="cleaner_h30"></div>
<h1>Produk Lainnya Dengan Kategori "<?php echo $nama_kategori; ?>"</h1>
<?php
foreach($slide_produk_sejenis->result_array() as $sps)
{
$tss = "";
$mati = "";
if($sps['stok']>0)
{
	$tss = '<span style="margin:0px auto; padding:0px; font-size:12px;"><b>Ada</b></span>';
	$mati = "";
}
else
{
	$tss = '<span style="margin:0px auto; padding:0px; font-size:12px; color:red;"><b>Habis</b></span>';
	$mati = "disabled";
}
			$c = array (' ');
    		$d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+');
			$s = strtolower(str_replace($d,"",$sps['nama_produk']));
			$link = strtolower(str_replace($c, '-', $s));
	echo '
<form method="post" action="'.base_url().'keranjang/tambah_barang">
<input type="hidden" name="kode_produk" value="'.$sps['kode_produk'].'">
<input type="hidden" name="banyak" value="1">
<input type="hidden" name="harga" value="'.$sps['harga'].'">
<input type="hidden" name="nama_produk" value="'.$sps['nama_produk'].'">
<div style="border:1px solid #CCCCCC; margin-bottom:10px; padding:5px; width:152px; float:left; margin-right:6px; -moz-border-radius: 5px; -webkit-border-radius: 5px; z-index: 6666669 ;">
<p style="text-align:center; height:40px; margin:0px auto;"><strong>'.$sps['nama_produk'].'</strong></p><p style="text-align:center; margin:0px auto;"><img src="'.base_url().'asset/produk/'.$sps['gbr_kecil'].'" width="100" /><br />Rp.'.number_format($sps['harga'],2,',','.').' | Stok : '.$tss.'<div style="width:152px; margin:0px auto; padding:0px;"><input type="submit" class="tombol-beli" value="" '.$mati.'><a href="'.base_url().'produk/detail/'.strtolower($sps['kode_produk']).'-'.$link.'" class="vtip" title="'.$sps['nama_produk'].' - Harga Rp.'.number_format($sps['harga'],2,',','.').'"><img src="'.base_url().'asset/images/bar-detail.png" border=0 style="float:right;" /></a></div></p></div></form>';
}
?>
</div>
