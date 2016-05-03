

<div id="content-center">
<div style="padding:5px; border:1px solid #ccc; margin-bottom:10px;"><a href="<?php echo base_url(); ?>">Beranda</a> > Index Intermezzo</div>
<iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo base_url(); ?>intermezzo/cari
&layout=standard&show_faces=false&width=500&action=recommend&colorscheme=light&height=40" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:500px; height:40px; color:#FFFFFF;" allowTransparency="true"></iframe> 
<h1>Index Intermezzo - Harmonis Grosir Sandal Online</h1>
<div class="cleaner_h10"></div>

<?php
if(count($berita->result_array())>0){
foreach($berita->result_array() as $in)
{
			$c = array (' ');
    		$d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+');
			$s = strtolower(str_replace($d,"",$in['judul']));
			$link = strtolower(str_replace($c, '-', $s));
	echo "<h2><a href='".base_url()."intermezzo/baca/".$in['id_berita']."-".$link."'>".$in['judul']."</a></h2>";
	echo "<h5>Diposting pada : ".$in['tanggal']." | ".$in['jam']." - Oleh : Admin - Dibaca : ".$in['dibaca']." kali</h5>";
	//echo '<img src="'.base_url().'asset/intermezzo/'.$in['gambar'].'">'.nl2br($in['isi_berita']); //aktifkan jika admin sudah tersedia
	echo '<img src="'.base_url().'asset/intermezzo/'.$in['gambar'].'" width="150" class="gambar" title="'.$in['judul'].'">'.substr($in['isi_berita'],0,300).'...<a href="'.base_url().'intermezzo/baca/'.$in["id_berita"].'-'.$link.'">[Baca Selengkapnya]</a>';
	echo '<div class="cleaner_h20"></div>';
}
}
else{
echo "Maaf, belum ada Testimonial. <br>Silahkan mengisi Testimonial dan Pengalaman anda selama berbelanja di website kami.";
}
?>
<div class="cleaner_h5"></div>
<table align="center"><tr><td><?php echo $paginator; ?></td></tr></table>
</div>
