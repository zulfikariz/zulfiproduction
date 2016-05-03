<div id="content-center">
<div style="padding:5px; border:1px solid #ccc; margin-bottom:10px;"><a href="<?php echo base_url(); ?>">Beranda</a> > Log In Member</div>
<iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo base_url(); ?>member/login
&layout=standard&show_faces=false&width=500&action=recommend&colorscheme=light&height=40" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:500px; height:40px; color:#FFFFFF;" allowTransparency="true"></iframe> 
<h1>Log In Member - Harmonis Grosir Sandal Online</h1>
<div class="cleaner_h10"></div>
<form method="post" action="<?php echo base_url(); ?>member/aksilogin">
<table width="100%">
<tr><td width="150">Username</td><td>: </td><td><input type="text" name="usrname" size="40" class="input-teks" /></td></tr>
<tr><td>Password</td><td>: </td><td><input type="password" name="pwd" size="40" class="input-teks" /></td></tr>
<tr><td></td><td></td><td><?php echo $gbr_captcha; ?></td></tr>
<tr><td>Kode Captcha</td><td>: </td><td><input type="text" name="captcha" size="40" class="input-teks" /></td></tr>
<tr><td></td><td></td><td><input type="submit" value="Log In" class="input-tombol" /> <input type="reset" value="Hapus" class="input-tombol" /></td></tr>
</table>
</form>
<div style="width:230px; text-align:center; float:left; padding:10px;">
<a href="<?php echo base_url(); ?>member/lupa">Lupa dengan password anda..???<br /><img src="<?php echo base_url(); ?>asset/images/lupa-pass.png" border="0" /></a>
</div>
<div style="width:230px;text-align:center; float:left; padding:10px;">
<a href="<?php echo base_url(); ?>member/daftar">Belum menjadi member..???<br /><img src="<?php echo base_url(); ?>asset/images/reg-member.png" border="0" /></a>
</div>
<div class="cleaner_h20"></div>
</div>
