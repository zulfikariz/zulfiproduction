<?php
echo $scriptmce;
?>
<div class="clear"></div>
<div id="content-outer">
<!-- start content -->
<div id="content">
	<div id="page-heading">
	<?php if($lvl=="spradmn"){ $p = "Super Admin"; } else{ $p = "User Biasa"; } ?>
		<h1><?php echo $judul; ?></h1><br>
		<?php
		foreach($ls->result_array() as $d)
		{
		?>
		<table width="98%" cellpadding="10">
		<tr><td valign="top">
		<fieldset style="border:1px dashed #666666; width:98%; padding:10px;">
<legend align="left"><strong>Form Edit Banner :</strong></legend>
<form method="post" action="<?php echo base_url(); ?>aksesroot/update_banner" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?php echo $d['kode_banner']; ?>" />
<input type="hidden" name="gbr" value="<?php echo $d['gambar']; ?>" />
<table width="100%" border="0" cellspacing="0">
<tr><td width="120">Judul</td><td width="10">:</td><td><input type="text" class="login-inp" size="80" name="judul" value="<?php echo $d['judul']; ?>" /></td></tr>
<tr><td width="120" valign="top">Deskripsi</td><td width="10" valign="top">:</td><td valign="top"><textarea class="login-inp" rows="10" cols="80" name="deskripsi"><?php echo $d['deskripsi']; ?></textarea></td></tr>
<tr><td width="120" valign="top">Gambar</td><td width="10" valign="top">:</td><td><img src="<?php echo base_url(); ?>asset/banner/<?php echo $d['gambar']; ?>" width="600" /></td></tr>
<tr><td width="120">Ganti Gambar</td><td width="10">:</td><td><input type="file" class="login-inp" size="60" name="userfile" /></td></tr>
<tr><td width="120">Status</td><td width="10">:</td><td>
<select name="stts" class="login-inp">
<?php
if($d['stts']==1)
{
?>
<option value="1" selected="selected">Aktif</option><option value="0">Tidak Aktif</option>
<?php
} else{
?>
<option value="1">Aktif</option><option value="0" selected="selected">Tidak Aktif</option>
<?php
}
?>
</select></td></tr>
<tr><td width="120"></td><td width="10"></td><td><input type="submit" class="input-tombol" value="Simpan Data" /></td></tr>
</table>
</form>
	</fieldset>	
		</td>
		</tr>
		</table>
		<?php
		}
		?>
	</div>
	<div class="clear">&nbsp;</div>
</div>
<!--  end content -->
<div class="clear">&nbsp;</div>
</div>

