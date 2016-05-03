<div id="content-center">
<div style="padding:5px; border:1px solid #ccc; margin-bottom:10px;"><a href="<?php echo base_url(); ?>">Beranda</a> > Testimonial Pengunjung</div>
<iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo base_url(); ?>testimonial/cari
&layout=standard&show_faces=false&width=500&action=recommend&colorscheme=light&height=40" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:500px; height:40px; color:#FFFFFF;" allowTransparency="true"></iframe> 
<h1>Testimonial Pengunjung - Harmonis Grosir Sandal Online</h1>
<div class="cleaner_h10"></div>
<?php
if(count($testi->result_array())>0){
foreach($testi->result_array() as $tst)
{
	echo '<div class="tampil-testi">
	<table celpadding=5 width=100%>
	<tr><td valign="top" width=60>Nama</td><td valign="top" width=5>:</td><td valign="top">'.$tst['nama'].'</td></tr>
	<tr><td valign="top" width=60>Waktu</td><td valign="top" width=5>:</td><td valign="top">'.$tst['waktu'].'</td></tr>
	<tr><td valign="top" width=60>Email</td><td valign="top" width=5>:</td><td valign="top">'.$tst['email'].'</td></tr>
	<tr><td valign="top" width=60>Pesan</td><td valign="top" width=5>:</td><td valign="top">'.$tst['pesan'].'</td></tr>
	</table>
	</div>';
}
}
else{
echo "Maaf, belum ada Testimonial. <br>Silahkan mengisi Testimonial dan Pengalaman anda selama berbelanja di website kami.";
}
?>
<div class="cleaner_h20"></div>
<table align="center"><tr><td><?php echo $paginator; ?></td></tr></table>
</div>
