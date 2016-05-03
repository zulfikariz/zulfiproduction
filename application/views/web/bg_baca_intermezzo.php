<div id="content-center">
<div style="padding:5px; border:1px solid #ccc; margin-bottom:10px;"><a href="<?php echo base_url(); ?>">Beranda</a> > <a href="<?php echo base_url(); ?>intermezzo"> Intermezzo</a> > <?php echo $baca; ?></div>

<iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo base_url(); ?>intermezzo/baca/<?php echo $id.'-'.$link; ?>
&layout=standard&show_faces=false&width=500&action=like&colorscheme=light&height=40" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:500px; height:40px; color:#FFFFFF;" allowTransparency="true"></iframe>

<?php
foreach($detail->result_array() as $in)
{
	echo "<h2>".$in['judul']."</h2>";
	echo "<h5>Diposting pada : ".$in['tanggal']." | ".$in['jam']." - Oleh : Admin - Dibaca : ".$in['dibaca']." kali</h5>";
	//echo '<img src="'.base_url().'asset/intermezzo/'.$in['gambar'].'">'.nl2br($in['isi_berita']); //aktifkan jika admin sudah tersedia
	echo '<div class="share">Bagikan Tulisan ini ke : ';
	?>
	<script language="javascript">
document.write("<a href='http://twitter.com/home/?status=" + document.URL + "' target='_blank'> Twitter</a> | <a href='http://www.facebook.com/share.php?u=" + document.URL + "' target='_blank'> Facebook</a> | <a href='http://www.reddit.com/submit?url=" + document.URL + "' target='_blank'> Reddit</a> | <a href='http://digg.com/submit?url=" + document.URL + "' target='_blank'> Digg</a>");
</script>
	<?php
	echo '</div><div class="cleaner_h5"></div>';
	echo '<img src="'.base_url().'asset/intermezzo/'.$in['gambar'].'" width="260" class="gambar" title="'.$in['judul'].'">'.$in['isi_berita'];
}
?>
<div class="cleaner_h20"></div>
<h1>Baca Juga Intermezzo Menarik Lainnya</h1>
<ul>
	<?php
		foreach($intermezzo_acak->result_array() as $in)
		{
			$c = array (' ');
    		$d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+');
			$s = strtolower(str_replace($d,"",$in['judul']));
			$link = strtolower(str_replace($c, '-', $s));
			echo '<li><a href="'.base_url().'intermezzo/baca/'.$in['id_berita'].'-'.$link.'">'.$in['judul'].'</a></li>';
		}
	?>
</ul>
</div>
