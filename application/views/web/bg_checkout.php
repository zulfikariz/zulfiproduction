<script type="text/javascript">
function setPaymentInfo(isChecked)
{
	with (window.document.frmCheckout) {
		if (isChecked) {
			namapen.value = namapem.value;
			emailpen.value = emailpem.value;
			alamatpen.value = alamatpem.value;
			telponpen.value = telponpem.value;
			propinsipen.value = propinsipem.value;
			kotapen.value = kotapem.value;			
			kodepospen.value = kodepospem.value;
			
			namapem.readOnly  = true;
			emailpem.readOnly  = true;
			alamatpem.readOnly  = true;
			telponpem.readOnly  = true;
			propinsipem.readOnly  = true;
			kotapem.readOnly  = true;	
			kodepospem.readOnly  = true;	
		} else {
			namapen.value = "";
			emailpen.value = "";
			alamatpen.value = "";
			telponpen.value = "";
			propinsipen.value = "";
			kotapen.value = "";	
			kodepospen.value = "";	
		}
	}
}
</script>
<div id="content-center">
<div style="padding:5px; border:1px solid #ccc; margin-bottom:10px;"><a href="<?php echo base_url(); ?>">Beranda</a> > <a href="<?php echo base_url(); ?>keranjang">Keranjang Belanja</a> > Selesai Belanja</div>
<h1>Selesai Belanja - Harmonis Grosir Sandal Online</h1>
<?php if(!$this->cart->contents()){
	echo 'Maaf, Keranjang Belanja Anda Masih Kosong.';
	}
else{
?>
<?php
foreach($det_member->result_array() as $dm)
{

?>
<?php echo form_open('checkout/update_keranjang'); ?>
<fieldset style="border:1px solid #00BFFF; width:495px; padding:5px;">
    <legend align="left"><strong>Detail Keranjang Belanja :</strong></legend>
<table width="100%" cellpadding="0" cellspacing="0" class="table-keranjang">
		<tr align="center">
			<td class="td-keranjang">Jumlah</td>
			<td class="td-keranjang">Nama Barang</td>
			<td class="td-keranjang">Harga</td>
			<td class="td-keranjang">Sub Total</td>
			<td class="td-keranjang">Hapus</td>
		</tr>
		<?php $i = 1; ?>
		<?php foreach($this->cart->contents() as $items): ?>
		
		<?php echo form_hidden('rowid[]', $items['rowid']); ?>
		<tr <?php if($i&1){ echo 'class="alt"'; }?>>
	  		<td class="td-keranjang">
	  			<?php echo form_input(array('name' => 'qty[]', 'value' => $items['qty'], 'maxlength' => '2', 'size' => '1', 'class' => 'input-teks')); ?>
	  		</td>
	  		
	  		<td class="td-keranjang"><?php echo $items['name']; ?></td>
	  		
	  		<td class="td-keranjang">Rp. <?php echo $this->cart->format_number($items['price']); ?></td>
	  		<td class="td-keranjang">Rp. <?php echo $this->cart->format_number($items['subtotal']); ?></td>
 		 	<td class="td-keranjang" align="center"><a href="<?php echo base_url(); ?>checkout/hapus_keranjang/<?php echo $items['rowid']; ?>"><img src="<?php echo base_url(); ?>asset/images/hapus.png" border="0"></a></td>
	  	</tr>
	  	
	  	<?php $i++; ?>
		<?php endforeach; ?>
		
		<tr>
			<td class="td-keranjang" colspan=3><b>Total Belanja</b></td>
 		 	<td class="td-keranjang" colspan=2>Rp. <?php echo $this->cart->format_number($this->cart->total()); ?></td>
		</tr>
</table>
	</fieldset>
<?php echo "<input type='submit' class='input-tombol' value='Update Keranjang Belanja'>";?>
<?php 
echo form_close(); 
}
?>
<div class="cleaner_h20"></div>

<form method="post" action="<?php echo base_url(); ?>checkout/kirim_invoice" name="frmCheckout" id="frmCheckout">
<fieldset style="border:1px solid #00BFFF; width:495px; padding:5px;">
<legend align="left"><strong>Detail Data Pembeli :</strong></legend>
<table width="100%" cellpadding="3" cellspacing="0">
<tr><td width="120">Nama Pembeli</td><td width="5">:</td><td><input type="text" size="50" class="input-teks" name="namapem" readonly="readonly" value="<?php echo $dm['nama']; ?>" /></td></tr>
<tr><td width="120">Email Pembeli</td><td width="5">:</td><td><input type="text" size="50" class="input-teks" name="emailpem" readonly="readonly" value="<?php echo $dm['email']; ?>" /></td></tr>
<tr><td width="120" valign="top">Alamat Pembeli</td><td width="5" valign="top">:</td><td><textarea name="alamatpem" cols="60" readonly="readonly" rows="6" class="input-teks"><?php echo $dm['alamat']; ?></textarea></td></tr>
<tr><td width="120">No. Telpon</td><td width="5">:</td><td><input type="text" size="50" class="input-teks" name="telponpem" readonly="readonly" value="<?php echo $dm['telpon']; ?>" /></td></tr>
<tr><td width="120">Propinsi</td><td width="5">:</td><td><input type="text" size="50" class="input-teks" name="propinsipem" readonly="readonly" value="<?php echo $dm['propinsi']; ?>" /></td></tr>
<tr><td width="120">Kota</td><td width="5">:</td><td><input type="text" size="50" class="input-teks" name="kotapem" readonly="readonly" value="<?php echo $dm['kota']; ?>" /></td></tr>
<tr><td width="120">Kode Pos</td><td width="5">:</td><td><input type="text" size="50" class="input-teks" name="kodepospem" readonly="readonly" value="<?php echo $dm['kode_pos']; ?>" /></td></tr>
</table>
	</fieldset>
<div class="cleaner_h20"></div>
<fieldset style="border:1px solid #00BFFF; width:495px; padding:5px;">
<legend align="left"><strong>Detail Data Pengiriman / Penerima :</strong></legend>
<table width="100%" cellpadding="3" cellspacing="0">
<tr><td colspan="3"><input type="checkbox" name="chkSame" id="chkSame" value="checkbox" onClick="setPaymentInfo(this.checked);"><label for="chkSame" style="cursor:pointer">Sama Dengan Data Pembeli</label></td></tr>
<tr><td width="120">Nama Penerima</td><td width="5">:</td><td><input type="text" size="50" class="input-teks" name="namapen" /></td></tr>
<tr><td width="120">Email Penerima</td><td width="5">:</td><td><input type="text" size="50" class="input-teks" name="emailpen" /></td></tr>
<tr><td width="120" valign="top">Alamat Penerima</td><td width="5" valign="top">:</td><td><textarea name="alamatpen" cols="60" rows="6" class="input-teks"></textarea></td></tr>
<tr><td width="120">No. Telpon</td><td width="5">:</td><td><input type="text" size="50" class="input-teks" name="telponpen" /></td></tr>
<tr><td width="120">Propinsi</td><td width="5">:</td><td><input type="text" size="50" class="input-teks" name="propinsipen" /></td></tr>
<tr><td width="120">Kota</td><td width="5">:</td><td><input type="text" size="50" class="input-teks" name="kotapen" /></td></tr>
<tr><td width="120">Kode Pos</td><td width="5">:</td><td><input type="text" size="50" class="input-teks" name="kodepospen" /></td></tr>
</table>
	</fieldset>
<div class="cleaner_h20"></div>
<fieldset style="border:1px solid #00BFFF; width:495px; padding:5px;">
<legend align="left"><strong>Metode Pembayaran dan Pengiriman Paket :</strong></legend>
<table width="100%" cellpadding="3" cellspacing="0">
	<tr><td width=120>Bank Tujuan</td><td>:</td><td>
	<select name="bank" class="input-teks">
		 <option value="Bank Central Asia - No. Rek 1800658299">Bank Central Asia - No. Rek 1800658299</option>
		<option value="Bank Mandiri - No. Rek 143-00-1170047-1">Bank Mandiri - No. Rek 143-00-1170047-1</option>
		<option value="Bank BRI - No. Rek 6125-01-003271-53-9">Bank BRI - No. Rek 6125-01-003271-53-9</option>
		<option value="Bank Mandiri Syariah - No. Rek 2857027105">Bank Mandiri Syariah - No. Rek 2857027105</option>
	</select>
	</td></tr>
	<tr><td width=120>Metode Pembayaran</td><td>:</td><td>
	<select name="metode" class="input-teks"><option value="Setoran Tunai, Transfer Bank">Setoran Tunai, Transfer Bank</option>
		<option value="Setoran Tunai, Transfer Antar Bank">Setoran Tunai, Transfer Antar Bank</option>
		<option value="ATM">ATM</option>
		<option value="ATM - Antar Bank">ATM - Antar Bank</option>
		<option value="Internet Banking">Internet Banking</option>
		<option value="Internet Banking - Antar Bank">Internet Banking - Antar Bank</option>
		<option value="SMS Banking">SMS Banking</option>
		<option value="SMS Banking - Antar Bank">SMS Banking - Antar Bank</option>
	</select>
	</td></tr>
<tr><td width=120>Paket Pengiriman</td><td>:</td><td>
	<select name="paket" class="input-teks">
		<option value="TIKI">TIKI</option>
		<option value="JNE">JNE</option>
		<option value="ESL Express">ESL Express</option>
	</select>
	</td></tr>
<tr><td width="120" valign="top">Pesan (jika ada)</td><td width="5" valign="top">:</td><td><textarea name="pesan" cols="60" rows="6" class="input-teks"></textarea></td></tr>
<tr><td width="120" valign="top"></td><td width="5" valign="top"></td><td><input type="submit" value="Kirim Data Pesanan" class="input-tombol" /></td></tr>
</table>
	</fieldset>
</form>
<?php
}
?>


<div class="cleaner_h20"></div>


</div>
