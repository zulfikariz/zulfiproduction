<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('captcha','date','text_helper'));
		$this->load->library('email');
		session_start();
	}
	
	function index()
	{
		$session=isset($_SESSION['username_grosir_sandal']) ? $_SESSION['username_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data['menu'] = $this->sandal_model->menu_kategori('0','0');
			$data['judul'] = "Member Area - Grosir Sandal Online, Toko Sandal Online Termurah dan Terlengkap di Indonesia - Harmonis Grosir Sandal";
			$data['slide_atas'] = $this->sandal_model->tampil_slide_produk(10);
			$data['slide_laris'] = $this->sandal_model->tampil_slide_produk_terlaris_kiri(5);
			$data['slide_baru'] = $this->sandal_model->tampil_produk(5);
			$data['slide_rekomendasi'] = $this->sandal_model->tampil_slide_produk(6);
			$data['intermezzo'] = $this->sandal_model->tampil_semua_berita(5,0);
			$data['testimonial'] = $this->sandal_model->tampil_testimonial(10,0);
			$data['banner'] = $this->sandal_model->tampil_banner();
			
			$this->load->view('web/bg_top',$data);
			$this->load->view('web/bg_left',$data);
			$this->load->view('web/bg_member');
			$this->load->view('web/bg_right');
			$this->load->view('web/bg_bottom');
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."member/login'>";
		}
	}

	function login()
	{
		$session=isset($_SESSION['username_grosir_sandal']) ? $_SESSION['username_grosir_sandal']:'';
		if($session!=""){
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."member'>";
		}
		else{
			$data['menu'] = $this->sandal_model->menu_kategori('0','0');
			$data['judul'] = "Log In Member - Grosir Sandal Online, Toko Sandal Online Termurah dan Terlengkap di Indonesia - Harmonis Grosir Sandal";
			$data['slide_atas'] = $this->sandal_model->tampil_slide_produk(10);
			$data['slide_laris'] = $this->sandal_model->tampil_slide_produk_terlaris_kiri(5);
			$data['slide_baru'] = $this->sandal_model->tampil_produk(5);
			$data['slide_rekomendasi'] = $this->sandal_model->tampil_slide_produk(6);
			$data['intermezzo'] = $this->sandal_model->tampil_semua_berita(5,0);
			$data['testimonial'] = $this->sandal_model->tampil_testimonial(10,0);
			$data['banner'] = $this->sandal_model->tampil_banner();
			
			$vals = array(
			'img_path' => './captcha/',
			'img_url' => base_url().'captcha/',
			'font_path' => './system/fonts/impact.ttf',
			'img_width' => '200',
			'img_height' => 60,
			'expiration' => 90
			);
			$cap = create_captcha($vals);
		 
			$datamasuk = array(
				'captcha_time' => $cap['time'],
				'ip_address' => $this->input->ip_address(),
				'word' => $cap['word']
				);
			$expiration = time()-900;
			$this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);
			$query = $this->db->insert_string('captcha', $datamasuk);
			$this->db->query($query);
			$data['gbr_captcha'] = $cap['image'];
			
			$this->load->view('web/bg_top',$data);
			$this->load->view('web/bg_left',$data);
			$this->load->view('web/bg_login',$data);
			$this->load->view('web/bg_right');
			$this->load->view('web/bg_bottom');
		}
	}

	function daftar()
	{
		$session=isset($_SESSION['username_grosir_sandal']) ? $_SESSION['username_grosir_sandal']:'';
		if($session!=""){
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."member'>";
		}
		else{
			$data['menu'] = $this->sandal_model->menu_kategori('0','0');
			$data['judul'] = "Register Member - Grosir Sandal Online, Toko Sandal Online Termurah dan Terlengkap di Indonesia - Harmonis Grosir Sandal";
			$data['slide_atas'] = $this->sandal_model->tampil_slide_produk(10);
			$data['slide_laris'] = $this->sandal_model->tampil_slide_produk_terlaris_kiri(5);
			$data['slide_baru'] = $this->sandal_model->tampil_produk(5);
			$data['slide_rekomendasi'] = $this->sandal_model->tampil_slide_produk(6);
			$data['intermezzo'] = $this->sandal_model->tampil_semua_berita(5,0);
			$data['testimonial'] = $this->sandal_model->tampil_testimonial(10,0);
			$data['banner'] = $this->sandal_model->tampil_banner();
			
			$vals = array(
			'img_path' => './captcha/',
			'img_url' => base_url().'captcha/',
			'font_path' => './system/fonts/impact.ttf',
			'img_width' => '200',
			'img_height' => 60,
			'expiration' => 90
			);
			$cap = create_captcha($vals);
		 
			$datamasuk = array(
				'captcha_time' => $cap['time'],
				'ip_address' => $this->input->ip_address(),
				'word' => $cap['word']
				);
			$expiration = time()-900;
			$this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);
			$query = $this->db->insert_string('captcha', $datamasuk);
			$this->db->query($query);
			$data['gbr_captcha'] = $cap['image'];
			
			$this->load->view('web/bg_top',$data);
			$this->load->view('web/bg_left',$data);
			$this->load->view('web/bg_daftar',$data);
			$this->load->view('web/bg_right');
			$this->load->view('web/bg_bottom');
		}
	}
	
	function kirimregister()
	{
		$session=isset($_SESSION['username_grosir_sandal']) ? $_SESSION['username_grosir_sandal']:'';
		if($session!=""){
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."member'>";
		}
		else{
			$data['menu'] = $this->sandal_model->menu_kategori('0','0');
			$data['judul'] = "Log In Member - Grosir Sandal Online, Toko Sandal Online Termurah dan Terlengkap di Indonesia - Harmonis Grosir Sandal";
			$data['slide_atas'] = $this->sandal_model->tampil_slide_produk(10);
			$data['slide_laris'] = $this->sandal_model->tampil_slide_produk_terlaris_kiri(5);
			$data['slide_baru'] = $this->sandal_model->tampil_produk(5);
			$data['slide_rekomendasi'] = $this->sandal_model->tampil_slide_produk(6);
			$data['intermezzo'] = $this->sandal_model->tampil_semua_berita(5,0);
			$data['testimonial'] = $this->sandal_model->tampil_testimonial(10,0);
			$data['banner'] = $this->sandal_model->tampil_banner();
			
			
			$datapesan['username_user'] = mysql_real_escape_string($this->input->post('username'));
			$datapesan['pass_user'] = md5($this->input->post('password'));
			$datapesan['nama'] = mysql_real_escape_string($this->input->post('nama'));
			$datapesan['email'] = mysql_real_escape_string($this->input->post('email'));
			$datapesan['alamat'] = mysql_real_escape_string($this->input->post('alamat'));
			$datapesan['telpon'] = mysql_real_escape_string($this->input->post('telpon'));
			$datapesan['propinsi'] = mysql_real_escape_string($this->input->post('propinsi'));
			$datapesan['kota'] = mysql_real_escape_string($this->input->post('kota'));
			$datapesan['kode_pos'] = mysql_real_escape_string($this->input->post('kodepos'));
			$tgl = $this->input->post('tgl');
			$bln = $this->input->post('bln');
			$thn = $this->input->post('thn');
			$datapesan['tgl_lahir'] = $tgl.'-'.$bln.'-'.$thn;
			$datapesan['stts'] = 0;
			$datapesan['kode_aktivasi'] = md5($datapesan['username_user']);
			
			
			$expiration = time()-900;
			$this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);
			
			$sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
			$binds = array($_POST['captcha'], $this->input->ip_address(), $expiration);
			$query = $this->db->query($sql, $binds);
			$row = $query->row();
			
			$data['pesan'] = "";
			if ($row->count == 0)
			{
				$data['pesan'] = "Kode Captcha yang anda masukkan tidak Valid...!!!";
			}
			else
			{
				
					$q = $this->sandal_model->cek_username($datapesan['username_user'],$datapesan['email']);
					if (count($q->result())>0){
						$data['pesan'] =  "Username atau Email yang anda masukkan sudah terpakai. Silahkan pilih yang lainnya";
					}
					else{
						$sql_hapus  = "delete FROM captcha";
						$query = $this->db->query($sql_hapus);
							$this->sandal_model->register_member($datapesan);
						//$format_pesan = "Nama : ".$datapesan['nama']."".$this->email->clear()." Email : ".$datapesan['email']."".$this->email->clear()." Telpon : ".$datapesan['telpon']."".$this->email->clear()." Alamat : ".$datapesan['alamat']."".$this->email->clear()."  
						//Kota : ".$datapesan['kota']."".$this->email->clear()." Negara : ".$datapesan['negara']."".$this->email->clear()." Pesan : ".$datapesan['pesan'];
						$this->email->from("admin@harmonisgrosirsandal.com", "Admin Grosir Sandal Online");
						$this->email->to($datapesan['email']);
						
						$this->email->set_mailtype('html');
						$this->email->subject('Aktivasi Keanggotaan - Harmonis Grosir Sandal');
						$this->email->message('Terima kasih telah menjadi member di website kami. Klik link berikut ini untuk mengaktifkan akun anda. 
						<br>http://harmonisgrosirsandal.com/member/aktivasi/'.$datapesan['kode_aktivasi'].'');	
						//$ml = $this->email->send();
						$ml = true;
						if($ml==TRUE)
						{
							$data['pesan'] = "Email aktivasi telah dikirimkan ke email anda. Silahkan login ke akun email anda, periksa pada folder inbox atau pesan dan klik link aktivasi.";
							?>
							<script>
							alert('Email aktivasi telah dikirimkan ke email anda. Silahkan login ke akun email anda, periksa pada folder inbox atau pesan dan klik link aktivasi.');
							</script>
							<?php
							echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
						}
						else
						{
							$data['pesan'] = "Gagal membuat akun. Silahkan ulangi kembali.";
							?>
							<script>
							alert('Gagal membuat akun. Silahkan ulangi kembali.');
							</script>
							<?php
							echo "<meta http-equiv='refresh' content='0; url=".base_url()."member/daftar'>";
						}
					
				}
			}
			
			$this->load->view('web/bg_top',$data);
			$this->load->view('web/bg_left',$data);
			$this->load->view('web/bg_hasil_daftar',$data);
			$this->load->view('web/bg_right');
			$this->load->view('web/bg_bottom');
		}
	}
	
	function logout()
	{
		session_destroy();
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
	}
	
	function aktivasi()
	{
		$kode='';		
		if ($this->uri->segment(3) === FALSE)
		{
    			$kode='gagal';
		}
		else
		{
    			$kode = $this->uri->segment(3);
		}
		$session=isset($_SESSION['username_grosir_sandal']) ? $_SESSION['username_grosir_sandal']:'';
		if($session!=""){
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."member'>";
		}
		else{
			$data['menu'] = $this->sandal_model->menu_kategori('0','0');
			$data['judul'] = "Register Member - Grosir Sandal Online, Toko Sandal Online Termurah dan Terlengkap di Indonesia - Harmonis Grosir Sandal";
			$data['slide_atas'] = $this->sandal_model->tampil_slide_produk(10);
			$data['slide_laris'] = $this->sandal_model->tampil_slide_produk_terlaris_kiri(5);
			$data['slide_baru'] = $this->sandal_model->tampil_produk(5);
			$data['slide_rekomendasi'] = $this->sandal_model->tampil_slide_produk(6);
			$data['intermezzo'] = $this->sandal_model->tampil_semua_berita(5,0);
			$data['testimonial'] = $this->sandal_model->tampil_testimonial(10,0);
			$data['banner'] = $this->sandal_model->tampil_banner();
			
			$nama="";
			$id="";
			$cari = $this->sandal_model->aktivasi_member($kode);
			if (count($cari->result())>0){
				foreach($cari->result() as $c){
					$nama = $c->nama;
					$id = $c->kode_user;
				}
				$data['pesan'] =  "Selamat, ".$nama.". Akun anda berhasil diaktifkan.<br>Silahkan login melalui menu member dengan username dan password anda.";
				$this->sandal_model->update_aktivasi($id);
			}
			else{
				$data['pesan'] =  "Error....!!!! User aktivasi tidak ditemukan.";
			}
			
			$this->load->view('web/bg_top',$data);
			$this->load->view('web/bg_left',$data);
			$this->load->view('web/bg_aktivasi',$data);
			$this->load->view('web/bg_right');
			$this->load->view('web/bg_bottom');
		}
	}

	function set_profil()
	{
		$session=isset($_SESSION['username_grosir_sandal']) ? $_SESSION['username_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd_user"]=$pecah[2];
			$data['menu'] = $this->sandal_model->menu_kategori('0','0');
			$data['judul'] = "Member Area - Grosir Sandal Online, Toko Sandal Online Termurah dan Terlengkap di Indonesia - Harmonis Grosir Sandal";
			$data['slide_atas'] = $this->sandal_model->tampil_slide_produk(10);
			$data['slide_laris'] = $this->sandal_model->tampil_slide_produk_terlaris_kiri(5);
			$data['slide_baru'] = $this->sandal_model->tampil_produk(5);
			$data['slide_rekomendasi'] = $this->sandal_model->tampil_slide_produk(6);
			$data['intermezzo'] = $this->sandal_model->tampil_semua_berita(5,0);
			$data['testimonial'] = $this->sandal_model->tampil_testimonial(10,0);
			$data['det_member'] = $this->sandal_model->pilih_member($data["kd_user"]);
			$data['banner'] = $this->sandal_model->tampil_banner();
			
			$vals = array(
			'img_path' => './captcha/',
			'img_url' => base_url().'captcha/',
			'font_path' => './system/fonts/impact.ttf',
			'img_width' => '200',
			'img_height' => 60,
			'expiration' => 90
			);
			$cap = create_captcha($vals);
		 
			$datamasuk = array(
				'captcha_time' => $cap['time'],
				'ip_address' => $this->input->ip_address(),
				'word' => $cap['word']
				);
			$expiration = time()-900;
			$this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);
			$query = $this->db->insert_string('captcha', $datamasuk);
			$this->db->query($query);
			$data['gbr_captcha'] = $cap['image'];
			
			$this->load->view('web/bg_top',$data);
			$this->load->view('web/bg_left',$data);
			$this->load->view('web/bg_set_profil',$data);
			$this->load->view('web/bg_right');
			$this->load->view('web/bg_bottom');
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."member/login'>";
		}
	}

	function lupa()
	{
		$session=isset($_SESSION['username_grosir_sandal']) ? $_SESSION['username_grosir_sandal']:'';
		if($session==""){
			$data['menu'] = $this->sandal_model->menu_kategori('0','0');
			$data['judul'] = "Lupa Password - Grosir Sandal Online, Toko Sandal Online Termurah dan Terlengkap di Indonesia - Harmonis Grosir Sandal";
			$data['slide_atas'] = $this->sandal_model->tampil_slide_produk(10);
			$data['slide_laris'] = $this->sandal_model->tampil_slide_produk_terlaris_kiri(5);
			$data['slide_baru'] = $this->sandal_model->tampil_produk(5);
			$data['slide_rekomendasi'] = $this->sandal_model->tampil_slide_produk(6);
			$data['intermezzo'] = $this->sandal_model->tampil_semua_berita(5,0);
			$data['testimonial'] = $this->sandal_model->tampil_testimonial(10,0);
			$data['banner'] = $this->sandal_model->tampil_banner();
			
			$vals = array(
			'img_path' => './captcha/',
			'img_url' => base_url().'captcha/',
			'font_path' => './system/fonts/impact.ttf',
			'img_width' => '200',
			'img_height' => 60,
			'expiration' => 90
			);
			$cap = create_captcha($vals);
		 
			$datamasuk = array(
				'captcha_time' => $cap['time'],
				'ip_address' => $this->input->ip_address(),
				'word' => $cap['word']
				);
			$expiration = time()-900;
			$this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);
			$query = $this->db->insert_string('captcha', $datamasuk);
			$this->db->query($query);
			$data['gbr_captcha'] = $cap['image'];
			
			$this->load->view('web/bg_top',$data);
			$this->load->view('web/bg_left',$data);
			$this->load->view('web/bg_lupa',$data);
			$this->load->view('web/bg_right');
			$this->load->view('web/bg_bottom');
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."member/'>";
		}
	}
	
	function reset_pass()
	{
		$session=isset($_SESSION['username_grosir_sandal']) ? $_SESSION['username_grosir_sandal']:'';
		if($session!=""){
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."member'>";
		}
		else{
			$data['menu'] = $this->sandal_model->menu_kategori('0','0');
			$data['judul'] = "Log In Member - Grosir Sandal Online, Toko Sandal Online Termurah dan Terlengkap di Indonesia - Harmonis Grosir Sandal";
			$data['slide_atas'] = $this->sandal_model->tampil_slide_produk(10);
			$data['slide_laris'] = $this->sandal_model->tampil_slide_produk_terlaris_kiri(5);
			$data['slide_baru'] = $this->sandal_model->tampil_produk(5);
			$data['slide_rekomendasi'] = $this->sandal_model->tampil_slide_produk(6);
			$data['intermezzo'] = $this->sandal_model->tampil_semua_berita(5,0);
			$data['testimonial'] = $this->sandal_model->tampil_testimonial(10,0);
			$data['banner'] = $this->sandal_model->tampil_banner();
			
			$datapesan['email'] = mysql_real_escape_string($this->input->post('email'));
			$q = $this->sandal_model->pilih_email($datapesan['email']);
			$acak           = rand(1,999999999);
			$kode_reset = md5($acak.$datapesan['email']);
			
			$expiration = time()-900;
			$this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);
			
			$sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
			$binds = array($_POST['captcha'], $this->input->ip_address(), $expiration);
			$query = $this->db->query($sql, $binds);
			$row = $query->row();
			
			$data['pesan'] = "";
			if ($row->count == 0)
			{
				$data['pesan'] = "Kode Captcha yang anda masukkan tidak Valid...!!!";
			}
			else
			{
				if($datapesan['email']=="")
				{
					$data['pesan'] = "Field belum lengkap. Mohon diisi dengan selengkap-lengkapnya.";
				}
				else
				{
					if (count($q->result())<1){
						$data['pesan'] =  "Email yang anda masukkan tidak terdapat di dalam database kami.";
					}
					else{
						$sql_hapus  = "delete FROM captcha";
						$query = $this->db->query($sql_hapus);
						//$format_pesan = "Nama : ".$datapesan['nama']."".$this->email->clear()." Email : ".$datapesan['email']."".$this->email->clear()." Telpon : ".$datapesan['telpon']."".$this->email->clear()." Alamat : ".$datapesan['alamat']."".$this->email->clear()."  
						//Kota : ".$datapesan['kota']."".$this->email->clear()." Negara : ".$datapesan['negara']."".$this->email->clear()." Pesan : ".$datapesan['pesan'];
						$q_update = "update tbl_user set kode_aktivasi='".$kode_reset."' where email='".$datapesan['email']."'";
						$this->sandal_model->update_profil_member($q_update);
						
						$this->email->set_mailtype('html');
						$this->email->from("admin@harmonisgrosirsandal.com", "Admin Grosir Sandal Online");
						$this->email->to($datapesan['email']);
						
						$this->email->subject('Reset Password - Member Harmonis Grosi Sandal Online');
						$this->email->message('Klik link berikut ini untuk memperbaharui password akun anda. 
						<br>http://harmonisgrosirsandal.com/member/ubah_pass/'.$kode_reset.'');	
						$ml = $this->email->send();
						if($ml==TRUE)
						{
							$data['pesan'] = "Email reset password telah dikirimkan ke email anda. Silahkan login ke akun email anda, periksa pada folder inbox atau spam dan klik link reset password.";
							?>
							<script>
							alert('Email reset password telah dikirimkan ke email anda. Silahkan login ke akun email anda, periksa pada folder inbox atau spam dan klik link reset password.');
							</script>
							<?php
							echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
						}
						else
						{
							$data['pesan'] = "Gagal mengirimkan link reset password. Silahkan ulangi kembali.";
							?>
							<script>
							alert('Gagal mengirimkan link reset password. Silahkan ulangi kembali.');
							</script>
							<?php
							echo "<meta http-equiv='refresh' content='0; url=".base_url()."member/lupa'>";
						}
					}
				}
			}
			
			$this->load->view('web/bg_top',$data);
			$this->load->view('web/bg_left',$data);
			$this->load->view('web/bg_hasil_reset',$data);
			$this->load->view('web/bg_right');
			$this->load->view('web/bg_bottom');
		}
	}
	
	function ubah_pass()
	{
		$kode='';		
		if ($this->uri->segment(3) === FALSE)
		{
    			$kode='gagal';
		}
		else
		{
    			$kode = $this->uri->segment(3);
		}
		$session=isset($_SESSION['username_grosir_sandal']) ? $_SESSION['username_grosir_sandal']:'';
		if($session!=""){
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."member'>";
		}
		else{
			$data['menu'] = $this->sandal_model->menu_kategori('0','0');
			$data['judul'] = "Register Member - Grosir Sandal Online, Toko Sandal Online Termurah dan Terlengkap di Indonesia - Harmonis Grosir Sandal";
			$data['slide_atas'] = $this->sandal_model->tampil_slide_produk(10);
			$data['slide_laris'] = $this->sandal_model->tampil_slide_produk_terlaris_kiri(5);
			$data['slide_baru'] = $this->sandal_model->tampil_produk(5);
			$data['slide_rekomendasi'] = $this->sandal_model->tampil_slide_produk(6);
			$data['intermezzo'] = $this->sandal_model->tampil_semua_berita(5,0);
			$data['testimonial'] = $this->sandal_model->tampil_testimonial(10,0);
			$data['banner'] = $this->sandal_model->tampil_banner();
			$data['kode'] = $kode;
			
			$this->load->view('web/bg_top',$data);
			$this->load->view('web/bg_left',$data);
			
			$cari = $this->sandal_model->aktivasi_member($kode);
			if (count($cari->result())>0){
				$this->load->view('web/bg_input_reset_pass',$data);
			}
			else{
				$data['pesan'] =  "Error....!!!! Kode reset password tidak ditemukan.";
				$this->load->view('web/bg_hasil_reset',$data);
			}
			
			$this->load->view('web/bg_right');
			$this->load->view('web/bg_bottom');
		}
	}
	
	function update_profil()
	{
		$session=isset($_SESSION['username_grosir_sandal']) ? $_SESSION['username_grosir_sandal']:'';
		if($session==""){
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."member'>";
		}
		else{
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd_user"]=$pecah[2];
			$data["email"]=$pecah[3];
			$data['menu'] = $this->sandal_model->menu_kategori('0','0');
			$data['judul'] = "Log In Member - Grosir Sandal Online, Toko Sandal Online Termurah dan Terlengkap di Indonesia - Harmonis Grosir Sandal";
			$data['slide_atas'] = $this->sandal_model->tampil_slide_produk(10);
			$data['slide_laris'] = $this->sandal_model->tampil_slide_produk_terlaris_kiri(5);
			$data['slide_baru'] = $this->sandal_model->tampil_produk(5);
			$data['slide_rekomendasi'] = $this->sandal_model->tampil_slide_produk(6);
			$data['intermezzo'] = $this->sandal_model->tampil_semua_berita(5,0);
			$data['testimonial'] = $this->sandal_model->tampil_testimonial(10,0);
			$data['banner'] = $this->sandal_model->tampil_banner();
			
			
			$datapesan['nama'] = mysql_real_escape_string($this->input->post('nama'));
			$datapesan['email'] = mysql_real_escape_string($this->input->post('email'));
			$datapesan['alamat'] = mysql_real_escape_string($this->input->post('alamat'));
			$datapesan['telpon'] = mysql_real_escape_string($this->input->post('telpon'));
			$datapesan['propinsi'] = mysql_real_escape_string($this->input->post('propinsi'));
			$datapesan['kota'] = mysql_real_escape_string($this->input->post('kota'));
			$datapesan['kodepos'] = mysql_real_escape_string($this->input->post('kodepos'));
			$tgl = $this->input->post('tgl');
			$bln = $this->input->post('bln');
			$thn = $this->input->post('thn');
			$datapesan['tgl_lahir'] = $tgl.'-'.$bln.'-'.$thn;
			
			
			$expiration = time()-900;
			$this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);
			$sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
			$binds = array($_POST['captcha'], $this->input->ip_address(), $expiration);
			$query = $this->db->query($sql, $binds);
			$row = $query->row();
			
			$data['pesan'] = "";
			if ($row->count == 0)
			{
				$data['pesan'] = "Kode Captcha yang anda masukkan tidak Valid...!!!";
			}
			else
			{
				if($datapesan['nama']=="" && $datapesan['email']=="" && $datapesan['alamat']=="" && $datapesan['telpon']=="" && $datapesan['propinsi']=="" && $datapesan['kota']=="" && $datapesan['tgl_lahir']=="" && $datapesan['kodepos']=="")
				{
					$data['pesan'] = "Field belum lengkap. Mohon diisi dengan selengkap-lengkapnya.";
				}
				else
				{
					$sql_hapus  = "delete FROM captcha";
					$query = $this->db->query($sql_hapus);
					if($datapesan['email']==$data["email"])
					{
						$q_update = "update tbl_user set nama='".$datapesan['nama']."',email='".$datapesan['email']."',alamat='".$datapesan['alamat']."',telpon='".$datapesan['telpon']."',propinsi='".$datapesan['propinsi']."',kota='".$datapesan['kota']."',tgl_lahir='".$datapesan['tgl_lahir']."',kode_pos='".$datapesan['kodepos']."' where kode_user='".$pecah[2]."'";
						$this->sandal_model->update_profil_member($q_update);
						$data['pesan'] = "Berhasil memperbaharui data profil anda.";
						?>
							<script>
							alert('Berhasil memperbaharui data profil anda.');
							</script>
						<?php
						echo "<meta http-equiv='refresh' content='0; url=".base_url()."member'>";
					}
					else
					{
						$q = $this->sandal_model->cek_email($datapesan['email']);
						if (count($q->result())>0){
							$data['pesan'] =  "Email yang anda masukkan sudah terpakai. Silahkan pilih yang lainnya";
						}
						else
						{
							$q_update = "update tbl_user set nama='".$datapesan['nama']."',email='".$datapesan['email']."',alamat='".$datapesan['alamat']."',telpon='".$datapesan['telpon']."',propinsi='".$datapesan['propinsi']."',kota='".$datapesan['kota']."',tgl_lahir='".$datapesan['tgl_lahir']."' where kode_user='".$pecah[2]."'";
							$this->sandal_model->update_profil_member($q_update);
							$data['pesan'] = "Berhasil memperbaharui data profil anda.";
							?>
								<script>
								alert('Berhasil memperbaharui data profil anda.');
								</script>
							<?php
							echo "<meta http-equiv='refresh' content='0; url=".base_url()."member'>";
						}
					}
				}
			}
			
			$this->load->view('web/bg_top',$data);
			$this->load->view('web/bg_left',$data);
			$this->load->view('web/bg_hasil_update_member',$data);
			$this->load->view('web/bg_right');
			$this->load->view('web/bg_bottom');
		}
	}
	
	function update_pass()
	{
		$session=isset($_SESSION['username_grosir_sandal']) ? $_SESSION['username_grosir_sandal']:'';
		if($session==""){
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."member'>";
		}
		else{
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd_user"]=$pecah[2];
			$data['menu'] = $this->sandal_model->menu_kategori('0','0');
			$data['judul'] = "Log In Member - Grosir Sandal Online, Toko Sandal Online Termurah dan Terlengkap di Indonesia - Harmonis Grosir Sandal";
			$data['slide_atas'] = $this->sandal_model->tampil_slide_produk(10);
			$data['slide_laris'] = $this->sandal_model->tampil_slide_produk_terlaris_kiri(5);
			$data['slide_baru'] = $this->sandal_model->tampil_produk(5);
			$data['slide_rekomendasi'] = $this->sandal_model->tampil_slide_produk(6);
			$data['intermezzo'] = $this->sandal_model->tampil_semua_berita(5,0);
			$data['testimonial'] = $this->sandal_model->tampil_testimonial(10,0);
			$data['banner'] = $this->sandal_model->tampil_banner();
			
			
			$datapesan['username'] = $this->input->post('username');
			$datapesan['passlama'] = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($this->input->post('passlama'),ENT_QUOTES))));
			$datapesan['passbaru'] = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($this->input->post('passbaru'),ENT_QUOTES))));
			$datapesan['ulangi'] = mysql_real_escape_string($this->input->post('ulangi'));
			$bersih = md5($datapesan['passbaru']);
			
			
			$expiration = time()-900;
			$this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);
			$sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
			$binds = array($_POST['captcha'], $this->input->ip_address(), $expiration);
			$query = $this->db->query($sql, $binds);
			$row = $query->row();
			
			$data['pesan'] = "";
			if ($row->count == 0)
			{
				$data['pesan'] = "Kode Captcha yang anda masukkan tidak Valid...!!!";
			}
			else
			{
				if($datapesan['passlama']=="" && $datapesan['passbaru']=="" && $datapesan['ulangi']=="")
				{
					$data['pesan'] = "Field belum lengkap. Mohon diisi dengan selengkap-lengkapnya.";
				}
				else
				{
					$sql_hapus  = "delete FROM captcha";
					$query = $this->db->query($sql_hapus);
					$cek = $this->sandal_model->data_login_member($datapesan['username'],$datapesan['passlama']);
					if($datapesan['ulangi']==$datapesan['passbaru']){
						if(count($cek->result())>0){
							$q_update = "update tbl_user set pass_user='".$bersih."' where kode_user='".$pecah[2]."'";
							$this->sandal_model->update_profil_member($q_update);
							$data['pesan'] = "Berhasil memperbaharui data profil anda.";
							?>
								<script>
								alert('Berhasil memperbaharui data profil anda.');
								</script>
							<?php
							echo "<meta http-equiv='refresh' content='0; url=".base_url()."member'>";
						}
						else{
							$data['pesan'] = "Password Lama Salah. Gagal memperbaharui data password anda.";
							?>
								<script>
								alert('Password Lama Salah. Gagal memperbaharui data password anda.');
								</script>
							<?php
							echo "<meta http-equiv='refresh' content='0; url=".base_url()."member/set_pass'>";
						}
					}
					else{
						$data['pesan'] = "Password Tidak Sama/Sinkron. Gagal memperbaharui data password anda.";
						?>
							<script>
							alert('Password Tidak Sama/Sinkron. Gagal memperbaharui data password anda.');
							</script>
						<?php
						echo "<meta http-equiv='refresh' content='0; url=".base_url()."member/set_pass'>";
						
					}
				}
			}
			
			$this->load->view('web/bg_top',$data);
			$this->load->view('web/bg_left',$data);
			$this->load->view('web/bg_hasil_update_pass',$data);
			$this->load->view('web/bg_right');
			$this->load->view('web/bg_bottom');
		}
	}

	function set_pass()
	{
		$session=isset($_SESSION['username_grosir_sandal']) ? $_SESSION['username_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd_user"]=$pecah[2];
			$data['menu'] = $this->sandal_model->menu_kategori('0','0');
			$data['judul'] = "Member Area - Grosir Sandal Online, Toko Sandal Online Termurah dan Terlengkap di Indonesia - Harmonis Grosir Sandal";
			$data['slide_atas'] = $this->sandal_model->tampil_slide_produk(10);
			$data['slide_laris'] = $this->sandal_model->tampil_slide_produk_terlaris_kiri(5);
			$data['slide_baru'] = $this->sandal_model->tampil_produk(5);
			$data['slide_rekomendasi'] = $this->sandal_model->tampil_slide_produk(6);
			$data['intermezzo'] = $this->sandal_model->tampil_semua_berita(5,0);
			$data['testimonial'] = $this->sandal_model->tampil_testimonial(10,0);
			$data['det_member'] = $this->sandal_model->pilih_member($data["kd_user"]);
			$data['banner'] = $this->sandal_model->tampil_banner();
			
			$vals = array(
			'img_path' => './captcha/',
			'img_url' => base_url().'captcha/',
			'font_path' => './system/fonts/impact.ttf',
			'img_width' => '200',
			'img_height' => 60,
			'expiration' => 90
			);
			$cap = create_captcha($vals);
		 
			$datamasuk = array(
				'captcha_time' => $cap['time'],
				'ip_address' => $this->input->ip_address(),
				'word' => $cap['word']
				);
			$expiration = time()-900;
			$this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);
			$query = $this->db->insert_string('captcha', $datamasuk);
			$this->db->query($query);
			$data['gbr_captcha'] = $cap['image'];
			
			$this->load->view('web/bg_top',$data);
			$this->load->view('web/bg_left',$data);
			$this->load->view('web/bg_set_pass',$data);
			$this->load->view('web/bg_right');
			$this->load->view('web/bg_bottom');
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."member/login'>";
		}
	}
	
	function update_reset_pass()
	{
		$session=isset($_SESSION['username_grosir_sandal']) ? $_SESSION['username_grosir_sandal']:'';
		if($session!=""){
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."member'>";
		}
		else{
			$data['menu'] = $this->sandal_model->menu_kategori('0','0');
			$data['judul'] = "Set Password - Grosir Sandal Online, Toko Sandal Online Termurah dan Terlengkap di Indonesia - Harmonis Grosir Sandal";
			$data['slide_atas'] = $this->sandal_model->tampil_slide_produk(10);
			$data['slide_laris'] = $this->sandal_model->tampil_slide_produk_terlaris_kiri(5);
			$data['slide_baru'] = $this->sandal_model->tampil_produk(5);
			$data['slide_rekomendasi'] = $this->sandal_model->tampil_slide_produk(6);
			$data['intermezzo'] = $this->sandal_model->tampil_semua_berita(5,0);
			$data['testimonial'] = $this->sandal_model->tampil_testimonial(10,0);
			$data['banner'] = $this->sandal_model->tampil_banner();
			
			$datapesan['passbaru'] = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($this->input->post('passbaru'),ENT_QUOTES))));
			$datapesan['ulangi'] = mysql_real_escape_string($this->input->post('ulangi'));
			$datapesan['kode'] = mysql_real_escape_string($this->input->post('kode'));
			$bersih = md5($datapesan['passbaru']);
			
			if($datapesan['passbaru']=="" && $datapesan['ulangi']=="")
			{
				$data['pesan'] = "Field belum lengkap. Mohon diisi dengan selengkap-lengkapnya.";
			}
			else
			{
				$kd_user = "";
				$cek = $this->sandal_model->aktivasi_member($datapesan['kode']);
				foreach($cek->result() as $ka)
				{
					$kd_user = $ka->kode_user;
				}
				if($datapesan['ulangi']==$datapesan['passbaru']){
					if(count($cek->result())>0){
						$q_update = "update tbl_user set pass_user='".$bersih."', kode_aktivasi='' where kode_user='".$kd_user."'";
						$this->sandal_model->update_profil_member($q_update);
						$data['pesan'] = "Berhasil memperbaharui data profil anda.";
						?>
							<script>
							alert('Berhasil memperbaharui data profil anda.');
							</script>
						<?php
						echo "<meta http-equiv='refresh' content='0; url=".base_url()."member'>";
					}
					else{
						$data['pesan'] = "Kode tidak ada di dalam database. Gagal memperbaharui data password anda.";
						?>
							<script>
							alert('Kode tidak ada di dalam database. Gagal memperbaharui data password anda.');
							</script>
						<?php
						echo "<meta http-equiv='refresh' content='0; url=".base_url()."member/ubah_pass/".$datapesan['kode']."'>";
					}
				}
				else{
					$data['pesan'] = "Password Tidak Sama/Sinkron. Gagal memperbaharui data password anda.";
					?>
						<script>
						alert('Password Tidak Sama/Sinkron. Gagal memperbaharui data password anda.');
						</script>
						<?php
					echo "<meta http-equiv='refresh' content='0; url=".base_url()."member/ubah_pass/".$datapesan['kode']."'>";
				}
			}
			
			$this->load->view('web/bg_top',$data);
			$this->load->view('web/bg_left',$data);
			$this->load->view('web/bg_hasil_reset_pass',$data);
			$this->load->view('web/bg_right');
			$this->load->view('web/bg_bottom');
		}
	}
	
	function history()
	{
		$session=isset($_SESSION['username_grosir_sandal']) ? $_SESSION['username_grosir_sandal']:'';
		if($session==""){
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."member'>";
		}
		else{
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd_user"]=$pecah[2];
			$data['menu'] = $this->sandal_model->menu_kategori('0','0');
			$data['judul'] = "History Transaksi - Grosir Sandal Online, Toko Sandal Online Termurah dan Terlengkap di Indonesia - Harmonis Grosir Sandal";
			$data['slide_atas'] = $this->sandal_model->tampil_slide_produk(10);
			$data['slide_laris'] = $this->sandal_model->tampil_slide_produk_terlaris_kiri(5);
			$data['slide_baru'] = $this->sandal_model->tampil_produk(5);
			$data['slide_rekomendasi'] = $this->sandal_model->tampil_slide_produk(6);
			$data['intermezzo'] = $this->sandal_model->tampil_semua_berita(5,0);
			$data['testimonial'] = $this->sandal_model->tampil_testimonial(10,0);
			$data['banner'] = $this->sandal_model->tampil_banner();
			
			$page=$this->uri->segment(3);
			$limit=15;
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;	
			
			$data['history'] = $this->sandal_model->tampil_semua_history($data["kd_user"],$limit,$offset);
			$tot_hal = $this->sandal_model->hitung_isi_1tabel('tbl_transaksi_header','group by substring(kode_transaksi,1,8)');
			
			$config['base_url'] = base_url() . 'member/history/';
				$config['total_rows'] = $tot_hal->num_rows();
				$config['per_page'] = $limit;
				$config['uri_segment'] = 3;
				$config['first_link'] = 'Awal';
				$config['last_link'] = 'Akhir';
				$config['next_link'] = 'Selanjutnya';
				$config['prev_link'] = 'Sebelumnya';
				$this->pagination->initialize($config);
			$data["paginator"] =$this->pagination->create_links();
			
			$this->load->view('web/bg_top',$data);
			$this->load->view('web/bg_left',$data);
			$this->load->view('web/bg_history',$data);
			$this->load->view('web/bg_right');
			$this->load->view('web/bg_bottom');
		}
	}
	
	function dethistory()
	{
		$kode='';		
		if ($this->uri->segment(3) === FALSE)
		{
    			$kode='';
		}
		else
		{
    			$kode = $this->uri->segment(3);
		}
		$session=isset($_SESSION['username_grosir_sandal']) ? $_SESSION['username_grosir_sandal']:'';
		if($session==""){
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."member'>";
		}
		else{
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd_user"]=$pecah[2];
			$data['menu'] = $this->sandal_model->menu_kategori('0','0');
			$data['judul'] = "History Transaksi - Grosir Sandal Online, Toko Sandal Online Termurah dan Terlengkap di Indonesia - Harmonis Grosir Sandal";
			$data['slide_atas'] = $this->sandal_model->tampil_slide_produk(10);
			$data['slide_laris'] = $this->sandal_model->tampil_slide_produk_terlaris_kiri(5);
			$data['slide_baru'] = $this->sandal_model->tampil_produk(5);
			$data['slide_rekomendasi'] = $this->sandal_model->tampil_slide_produk(6);
			$data['intermezzo'] = $this->sandal_model->tampil_semua_berita(5,0);
			$data['testimonial'] = $this->sandal_model->tampil_testimonial(10,0);
			$data['banner'] = $this->sandal_model->tampil_banner();
			
			$page=$this->uri->segment(4);
			$limit=15;
			if(!$page):
			$offset = 0;
			else:
			$offset = $page;
			endif;	
			
			$data['history'] = $this->sandal_model->tampil_det_history($data["kd_user"],$kode,$limit,$offset);
			$tot_hal = $this->sandal_model->hitung_isi_1tabel("tbl_transaksi_detail","where kode_transaksi like '%$kode%'");
			
			$config['base_url'] = base_url() . 'member/dethistory/'.$kode;
				$config['total_rows'] = $tot_hal->num_rows();
				$config['per_page'] = $limit;
				$config['uri_segment'] = 4;
				$config['first_link'] = 'Awal';
				$config['last_link'] = 'Akhir';
				$config['next_link'] = 'Selanjutnya';
				$config['prev_link'] = 'Sebelumnya';
				$this->pagination->initialize($config);
			$data["paginator"] =$this->pagination->create_links();
			
			$this->load->view('web/bg_top',$data);
			$this->load->view('web/bg_left',$data);
			$this->load->view('web/bg_det_history',$data);
			$this->load->view('web/bg_right');
			$this->load->view('web/bg_bottom');
		}
	}



	function aksilogin()
	{
		$username = mysql_real_escape_string($this->input->post('usrname'));
		$pwd = mysql_real_escape_string($this->input->post('pwd'));
		$hasil = $this->sandal_model->data_login_member($username,$pwd);
		
		$expiration = time()-9000;
		$this->db->query("DELETE FROM captcha WHERE captcha_time < ".$expiration);
		
		$sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
		$binds = array($_POST['captcha'], $this->input->ip_address(), $expiration);
		$query = $this->db->query($sql, $binds);
		$row = $query->row();
		
		if ($row->count == 0)
		{
			?>
			<script type="text/javascript">
			alert("Captcha salah. Ulangi lagi...!!!");			
			</script>
			<?php
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."member/login'>";
		}
		else
		{
			if (!ctype_alnum($username) OR !ctype_alnum($pwd)){
				?>
				<script type="text/javascript">
				alert("Protected....!!!");			
				</script>
				<?php
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."member/login'>";
			}
			else{
				if (count($hasil->result_array())>0){
					$sql_hapus  = "delete FROM captcha";
					$query = $this->db->query($sql_hapus);
					foreach($hasil->result() as $items){
						$session_username=$items->username_user."|".$items->nama."|".$items->kode_user."|".$items->email;
					}
					$_SESSION['username_grosir_sandal']=$session_username;
					echo "<meta http-equiv='refresh' content='0; url=".base_url()."member'>";
				}
				else{
					?>
					<script type="text/javascript">
					alert("Username atau Password Yang Anda Masukkan Salah atau Anda Belum Mengaktifkan Link Aktivasi Yang Telah Kami Kirimkan Via Email..!!!");			
					</script>
					<?php
					echo "<meta http-equiv='refresh' content='0; url=".base_url()."member/login'>";
				}
			}
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
