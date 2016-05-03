<div id="content-center">
<div style="padding:5px; border:1px solid #ccc; margin-bottom:10px;"><a href="<?php echo base_url(); ?>">Beranda</a> > Download Katalog Produk</div>
<iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo base_url(); ?>katalog/lihat
&layout=standard&show_faces=false&width=500&action=recommend&colorscheme=light&height=40" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:500px; height:40px; color:#FFFFFF;" allowTransparency="true"></iframe> 
<h1>Download Katalog Produk - Harmonis Grosir Sandal Online</h1>
<div class="cleaner_h10"></div>
<?php
if(count($katalog->result_array())>0){
foreach($katalog->result_array() as $kt)
{
echo "<div id='download'><img src='".base_url()."asset/images/download.png' border='0' class='image2'>
<table>
<tr><td width='100'><b>File</b></td><td width='10'> : </td><td>".$kt['judul_file']."</td></tr>
<tr><td><b>Tanggal</b></td><td> : </td><td>".$kt['tgl_posting']."</td></tr>
<tr><td><b>Diposting oleh</b></td><td> : </td><td>Administrator</td></tr>
<tr><td></td><td></td><td><a href='".base_url()."asset/download/".$kt['nama_file']."'><span class='submitButton2'>Download File</span></a></td></tr>
</table>
</div>";
}
}
else{
echo "Maaf, belum ada file katalog yang bisa di download.";
}
?>
<div class="cleaner_h20"></div>
<table align="center"><tr><td><?php echo $paginator; ?></td></tr></table>
</div>
