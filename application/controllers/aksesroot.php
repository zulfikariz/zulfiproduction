<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Aksesroot extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('captcha','date','text_helper'));
		$this->load->library(array('email'));
		$this->load->model('sandal_admin_model');
		session_start();
	}
	
	function index()
	{
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["lvl"]=$pecah[3];
			if($data["lvl"]=="spradmn")
			{
				$data["judul"] = "Dashboard - Harmonis Grosir Sandal Online";
				$this->load->view('admin/bg_top',$data);
				$this->load->view('admin/bg_home',$data);
				$this->load->view('admin/bg_footer',$data);
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}

	function login()
	{
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot'>";
		}
		else{
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
			
			$this->load->view('admin/bg_login',$data);
		}
	}
	
	function logout()
	{
		session_destroy();
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
	}
	
	function set_akun()
	{
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$data["judul"] = "Pengaturan Akun Admin - Harmonis Grosir Sandal Online";
				$data["det"] = $this->sandal_admin_model->pilih_admin($data["kd"]);
				$this->load->view('admin/bg_top',$data);
				$this->load->view('admin/bg_set_akun',$data);
				$this->load->view('admin/bg_footer',$data);
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}
	
	function set_banner()
	{
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$page=$this->uri->segment(3);
				$limit=10;
				if(!$page):
				$offset = 0;
				else:
				$offset = $page;
				endif;
				
	   			$data['scriptmce'] = $this->scripttiny_mce();
				$data["judul"] = "Pengaturan Banner - Harmonis Grosir Sandal Online";
				$data["det"] = $this->sandal_admin_model->tampil_banner($limit,$offset);
				$tot_hal = $this->sandal_model->hitung_isi_1tabel('tbl_banner','');
				
				$config['base_url'] = base_url() . 'aksesroot/lihat_semua_member/';
					$config['total_rows'] = $tot_hal->num_rows();
					$config['per_page'] = $limit;
					$config['uri_segment'] = 3;
					$config['first_link'] = 'Awal';
					$config['last_link'] = 'Akhir';
					$config['next_link'] = 'Selanjutnya';
					$config['prev_link'] = 'Sebelumnya';
					$this->pagination->initialize($config);
				$data["paginator"] =$this->pagination->create_links();
				
				$this->load->view('admin/bg_top',$data);
				$this->load->view('admin/bg_set_banner',$data);
				$this->load->view('admin/bg_footer',$data);
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}
	
	function tambah_admin()
	{
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$data["judul"] = "Tambah Admin - Harmonis Grosir Sandal Online";
				$data["ls"] = $this->sandal_admin_model->tampil_daftar_admin();
				$this->load->view('admin/bg_top',$data);
				$this->load->view('admin/bg_tambah_admin',$data);
				$this->load->view('admin/bg_footer',$data);
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}
	
	function lihat_semua_member()
	{
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$page=$this->uri->segment(3);
				$limit=15;
				if(!$page):
				$offset = 0;
				else:
				$offset = $page;
				endif;
				
				
				$data["judul"] = "Semua Member - Harmonis Grosir Sandal Online";
				$data["ls"] = $this->sandal_admin_model->tampil_daftar_member($limit,$offset);
				$tot_hal = $this->sandal_model->hitung_isi_1tabel('tbl_user','');
				
				$config['base_url'] = base_url() . 'aksesroot/lihat_semua_member/';
					$config['total_rows'] = $tot_hal->num_rows();
					$config['per_page'] = $limit;
					$config['uri_segment'] = 3;
					$config['first_link'] = 'Awal';
					$config['last_link'] = 'Akhir';
					$config['next_link'] = 'Selanjutnya';
					$config['prev_link'] = 'Sebelumnya';
					$this->pagination->initialize($config);
				$data["paginator"] =$this->pagination->create_links();
				
				$this->load->view('admin/bg_top',$data);
				$this->load->view('admin/bg_lihat_semua_member',$data);
				$this->load->view('admin/bg_footer',$data);
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}
	
	function lihat_semua_testimonial()
	{
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$page=$this->uri->segment(3);
				$limit=15;
				if(!$page):
				$offset = 0;
				else:
				$offset = $page;
				endif;
				
				
				$data["judul"] = "Semua Testimonial - Harmonis Grosir Sandal Online";
				$data["ls"] = $this->sandal_admin_model->tampil_testimonial($limit,$offset);
				$tot_hal = $this->sandal_model->hitung_isi_1tabel('tbl_testimonial','');
				
				$config['base_url'] = base_url() . 'aksesroot/lihat_semua_testimonial/';
					$config['total_rows'] = $tot_hal->num_rows();
					$config['per_page'] = $limit;
					$config['uri_segment'] = 3;
					$config['first_link'] = 'Awal';
					$config['last_link'] = 'Akhir';
					$config['next_link'] = 'Selanjutnya';
					$config['prev_link'] = 'Sebelumnya';
					$this->pagination->initialize($config);
				$data["paginator"] =$this->pagination->create_links();
				
				$this->load->view('admin/bg_top',$data);
				$this->load->view('admin/bg_lihat_testimonial',$data);
				$this->load->view('admin/bg_footer',$data);
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}
	
	function lihat_produk()
	{
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$page=$this->uri->segment(3);
				$limit=15;
				if(!$page):
				$offset = 0;
				else:
				$offset = $page;
				endif;	
				
				$data["judul"] = "Semua Produk - Harmonis Grosir Sandal Online";
				$data["tampil"] = $this->sandal_admin_model->tampil_semua_produk($limit,$offset);
				$tot_hal = $this->sandal_model->hitung_isi_1tabel('tbl_produk','');
				
				$config['base_url'] = base_url() . 'aksesroot/lihat_produk/';
					$config['total_rows'] = $tot_hal->num_rows();
					$config['per_page'] = $limit;
					$config['uri_segment'] = 3;
					$config['first_link'] = 'Awal';
					$config['last_link'] = 'Akhir';
					$config['next_link'] = 'Selanjutnya';
					$config['prev_link'] = 'Sebelumnya';
					$this->pagination->initialize($config);
				$data["paginator"] =$this->pagination->create_links();
				
				$this->load->view('admin/bg_top',$data);
				$this->load->view('admin/bg_lihat_produk',$data);
				$this->load->view('admin/bg_footer',$data);
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}
	
	function lihat_semua_intermezzo()
	{
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$page=$this->uri->segment(3);
				$limit=15;
				if(!$page):
				$offset = 0;
				else:
				$offset = $page;
				endif;	
				
				$data["judul"] = "Semua Intermezzo - Harmonis Grosir Sandal Online";
				$data["tampil"] = $this->sandal_admin_model->tampil_semua_berita($limit,$offset);
				$tot_hal = $this->sandal_model->hitung_isi_1tabel('tbl_intermezzo','');
				
				$config['base_url'] = base_url() . 'aksesroot/lihat_semua_intermezzo/';
					$config['total_rows'] = $tot_hal->num_rows();
					$config['per_page'] = $limit;
					$config['uri_segment'] = 3;
					$config['first_link'] = 'Awal';
					$config['last_link'] = 'Akhir';
					$config['next_link'] = 'Selanjutnya';
					$config['prev_link'] = 'Sebelumnya';
					$this->pagination->initialize($config);
				$data["paginator"] =$this->pagination->create_links();
				
				$this->load->view('admin/bg_top',$data);
				$this->load->view('admin/bg_lihat_intermezzo',$data);
				$this->load->view('admin/bg_footer',$data);
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}
	
	function transaksi_harian()
	{
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$page=$this->uri->segment(3);
				$limit=15;
				if(!$page):
				$offset = 0;
				else:
				$offset = $page;
				endif;	
				
				$data['kata']="";
				$tg = $this->input->post("tgl");
				$bl = $this->input->post("bln");
				$th = $this->input->post("thn");
				$tanggal = $th.$bl.$tg;
				if(!empty($tg))
				{
					$data['kata'] = $tanggal;
					$this->session->set_userdata('trans_harian', $data['kata']);
				} else {
					$data['kata'] = $this->session->userdata('trans_harian');
				}
				$data["judul"] = "Transaksi Harian - Harmonis Grosir Sandal Online";
				$data["tampil"] = $this->sandal_admin_model->tampil_trans_harian($data['kata'],$limit,$offset);
				$tot_hal = $this->sandal_model->hitung_isi_1tabel('tbl_transaksi_detail',"where kode_transaksi like '%".$data['kata']."%'");
				
				$config['base_url'] = base_url() . 'aksesroot/transaksi_harian/';
					$config['total_rows'] = $tot_hal->num_rows();
					$config['per_page'] = $limit;
					$config['uri_segment'] = 3;
					$config['first_link'] = 'Awal';
					$config['last_link'] = 'Akhir';
					$config['next_link'] = 'Selanjutnya';
					$config['prev_link'] = 'Sebelumnya';
					$this->pagination->initialize($config);
				$data["paginator"] =$this->pagination->create_links();
				
				$this->load->view('admin/bg_top',$data);
				$this->load->view('admin/bg_transaksi_harian',$data);
				$this->load->view('admin/bg_footer',$data);
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}
	
	function transaksi_bulanan()
	{
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$page=$this->uri->segment(3);
				$limit=15;
				if(!$page):
				$offset = 0;
				else:
				$offset = $page;
				endif;	
				
				$data['kata']="";
				$bl = $this->input->post("bln");
				$th = $this->input->post("thn");
				$tanggal = $th.$bl;
				if(!empty($bl))
				{
					$data['kata'] = $tanggal;
					$this->session->set_userdata('trans_bulanan', $data['kata']);
				} else {
					$data['kata'] = $this->session->userdata('trans_bulanan');
				}
				$data["judul"] = "Transaksi Bulanan - Harmonis Grosir Sandal Online";
				$data["tampil"] = $this->sandal_admin_model->tampil_trans_harian($data['kata'],$limit,$offset);
				$tot_hal = $this->sandal_model->hitung_isi_1tabel('tbl_transaksi_detail',"where kode_transaksi like '%".$data['kata']."%'");
				
				$config['base_url'] = base_url() . 'aksesroot/transaksi_bulanan/';
					$config['total_rows'] = $tot_hal->num_rows();
					$config['per_page'] = $limit;
					$config['uri_segment'] = 3;
					$config['first_link'] = 'Awal';
					$config['last_link'] = 'Akhir';
					$config['next_link'] = 'Selanjutnya';
					$config['prev_link'] = 'Sebelumnya';
					$this->pagination->initialize($config);
				$data["paginator"] =$this->pagination->create_links();
				
				$this->load->view('admin/bg_top',$data);
				$this->load->view('admin/bg_transaksi_bulanan',$data);
				$this->load->view('admin/bg_footer',$data);
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}
	
	function transaksi_tahunan()
	{
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$page=$this->uri->segment(3);
				$limit=15;
				if(!$page):
				$offset = 0;
				else:
				$offset = $page;
				endif;	
				
				$data['kata']="";
				$th = $this->input->post("thn");
				$tanggal = $th;
				if(!empty($th))
				{
					$data['kata'] = $tanggal;
					$this->session->set_userdata('trans_tahunan', $data['kata']);
				} else {
					$data['kata'] = $this->session->userdata('trans_tahunan');
				}
				$data["judul"] = "Transaksi Tahunan - Harmonis Grosir Sandal Online";
				$data["tampil"] = $this->sandal_admin_model->tampil_trans_harian($data['kata'],$limit,$offset);
				$tot_hal = $this->sandal_model->hitung_isi_1tabel('tbl_transaksi_detail',"where kode_transaksi like '%".$data['kata']."%'");
				
				$config['base_url'] = base_url() . 'aksesroot/transaksi_tahunan/';
					$config['total_rows'] = $tot_hal->num_rows();
					$config['per_page'] = $limit;
					$config['uri_segment'] = 3;
					$config['first_link'] = 'Awal';
					$config['last_link'] = 'Akhir';
					$config['next_link'] = 'Selanjutnya';
					$config['prev_link'] = 'Sebelumnya';
					$this->pagination->initialize($config);
				$data["paginator"] =$this->pagination->create_links();
				
				$this->load->view('admin/bg_top',$data);
				$this->load->view('admin/bg_transaksi_tahunan',$data);
				$this->load->view('admin/bg_footer',$data);
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}
	
	function lihat_kategori_produk()
	{
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$data["judul"] = "Semua Kategori Produk - Harmonis Grosir Sandal Online";
				$data["kat_level"] = $this->sandal_admin_model->menu_kategori(0,0);
				
				$this->load->view('admin/bg_top',$data);
				$this->load->view('admin/bg_lihat_kategori_produk',$data);
				$this->load->view('admin/bg_footer',$data);
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}
	
	function lihat_katalog()
	{
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$page=$this->uri->segment(3);
				$limit=15;
				if(!$page):
				$offset = 0;
				else:
				$offset = $page;
				endif;	
				
				$data["judul"] = "Semua Katalog Produk - Harmonis Grosir Sandal Online";
				$data["katalog"] = $this->sandal_admin_model->tampil_katalog($limit,$offset);
				$tot_hal = $this->sandal_model->hitung_isi_1tabel('tbl_katalog','');
				
				$config['base_url'] = base_url() . 'aksesroot/lihat_katalog/';
					$config['total_rows'] = $tot_hal->num_rows();
					$config['per_page'] = $limit;
					$config['uri_segment'] = 3;
					$config['first_link'] = 'Awal';
					$config['last_link'] = 'Akhir';
					$config['next_link'] = 'Selanjutnya';
					$config['prev_link'] = 'Sebelumnya';
					$this->pagination->initialize($config);
				$data["paginator"] =$this->pagination->create_links();
				
				$this->load->view('admin/bg_top',$data);
				$this->load->view('admin/bg_lihat_katalog',$data);
				$this->load->view('admin/bg_footer',$data);
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}
	
	

//===================Modul Insert==========================//

	
	function insert_admin()
	{
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$usr = mysql_real_escape_string($this->input->post('username'));
				$ps = mysql_real_escape_string($this->input->post('password'));
				$pass = md5($ps);
				$nama = mysql_real_escape_string($this->input->post('nama'));
				$email = mysql_real_escape_string($this->input->post('email'));
				$alamat = mysql_real_escape_string($this->input->post('alamat'));
				$tgl = $this->input->post('tgl');
				$lvl = $this->input->post('lvl');
				$stts = $this->input->post('stts');
				$q = "insert into tbl_spr_admn (username_admn,pass_admn,nama_admn,stts,lvl,email,alamat,tgl_lahir) values('".$usr."','".$pass."','".$nama."','".$stts."','".$lvl."','".$email."','".$alamat."','".$tgl."')";
				$data["upd"] = $this->sandal_admin_model->jalankan_query_manual($q);
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/tambah_admin'>";
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}
	
	function insert_kategori()
	{
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$nama = mysql_real_escape_string($this->input->post('nama'));
				$kategori = $this->input->post('kategori');
				$tingkat = $this->input->post('tingkat');
				$q = "insert into tbl_kategori (nama_kategori,kode_level,kode_parent) values('".$nama."','".$tingkat."','".$kategori."')";
				$data["upd"] = $this->sandal_admin_model->jalankan_query_manual($q);
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/lihat_kategori_produk'>";
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}
	
	function insert_katalog()
	{
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$nama = mysql_real_escape_string($this->input->post('nama'));
				$tgl = " %Y-%m-%d";
				$time = time();
				$tgl_posting = mdate($tgl,$time);
				
				$acak=rand(00000000000,99999999999);
				$bersih=$_FILES['userfile']['name'];
				
				$ext = end(explode('.', $bersih));
				$ext = substr(strrchr($bersih, '.'), 1);
				$ext = substr($bersih, strrpos($bersih, '.') + 1);
				$ext = preg_replace('/^.*\.([^.]+)$/D', '$1', $bersih);
				$exts = split("[/\\.]", $bersih);
				$n = count($exts)-1;
				$ext = $exts[$n];
				
				$nama_fl = $acak.'.'.$ext;
				
				$config["file_name"]=$acak;
				$config['upload_path'] = './asset/download/';
				$config['allowed_types'] = 'pdf|xls|zip|jpg|jpeg|png|txt|doc|docx|xlsx';
				$config['max_size'] = '50000';						
				$this->load->library('upload', $config);
				
				if(!$this->upload->do_upload())
				{
					echo $this->upload->display_errors();
				}
				else {
					$this->sandal_admin_model->jalankan_query_manual("insert into tbl_katalog (judul_file,nama_file,tgl_posting) values('".$nama."','".$nama_fl."','".$tgl_posting."')");
					echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/lihat_katalog'>";
				}
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}
	
	function insert_intermezzo()
	{
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$tgl = " %Y-%m-%d";
				$jam = "%h:%i:%a";
				$time = time();
				$judul = mysql_real_escape_string($this->input->post('judul'));
				$isi = mysql_real_escape_string($this->input->post('isi'));
				$tgl_posting = mdate($tgl,$time);
				$jam_posting = mdate($jam,$time);
				
				$acak=rand(00000000000,99999999999);
				$bersih=$_FILES['userfile']['name'];
				$nm=str_replace(" ","_","$bersih");
				$pisah=explode(".",$nm);
				$nama_murni=$pisah[0];
				$ubah=$acak.$nama_murni; //tanpa ekstensi
				$config["file_name"]=$ubah; //dengan eekstensi
				$nama_fl=$acak.$nm; //simpan nama ini k database
				$config['upload_path'] = './asset/intermezzo/';
				$config['allowed_types'] = 'bmp|gif|jpg|jpeg|png';
				$config['max_size'] = '500';
				$config['max_width'] = '300';
				$config['max_height'] = '300';					
				$this->load->library('upload', $config);
			
				if(!$this->upload->do_upload())
				{
					echo $this->upload->display_errors();
				}
				else {
					$this->sandal_admin_model->jalankan_query_manual("insert into tbl_intermezzo (judul,isi_berita,tanggal,jam,gambar,dibaca) 
					values('".$judul."','".$isi."','".$tgl_posting."','".$jam_posting."','".$nama_fl."','1')");
					echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/lihat_semua_intermezzo'>";
				}
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}
	
	function insert_banner()
	{
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$tgl = " %Y-%m-%d";
				$jam = "%h:%i:%a";
				$time = time();
				$judul = mysql_real_escape_string($this->input->post('judul'));
				$deskripsi = mysql_real_escape_string($this->input->post('deskripsi'));
				$stts = mysql_real_escape_string($this->input->post('stts'));
				
				$acak=rand(00000000000,99999999999);
				$bersih=$_FILES['userfile']['name'];
				$nm=str_replace(" ","_","$bersih");
				$pisah=explode(".",$nm);
				$nama_murni=$pisah[0];
				$ubah=$acak.$nama_murni; //tanpa ekstensi
				$config["file_name"]=$ubah; //dengan eekstensi
				$nama_fl=$acak.$nm; //simpan nama ini k database
				$config['upload_path'] = './asset/banner/';
				$config['allowed_types'] = 'bmp|gif|jpg|jpeg|png';
				$config['max_size'] = '2000';
				$config['max_width'] = '680';
				$config['max_height'] = '200';					
				$this->load->library('upload', $config);
			
				if(!$this->upload->do_upload())
				{
					echo $this->upload->display_errors();
				}
				else {
					$this->sandal_admin_model->jalankan_query_manual("insert into tbl_banner (judul,deskripsi,gambar,stts) 
					values('".$judul."','".$deskripsi."','".$nama_fl."','".$stts."')");
					echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/set_banner'>";
				}
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}
	
	function insert_produk()
	{
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$kategori = mysql_real_escape_string($this->input->post('kategori'));
				$nama = mysql_real_escape_string($this->input->post('nama'));
				$harga = mysql_real_escape_string($this->input->post('harga'));
				$stok = mysql_real_escape_string($this->input->post('stok'));
				$dibeli = mysql_real_escape_string($this->input->post('dibeli'));
				$deskripsi = mysql_real_escape_string($this->input->post('deskripsi'));
				$tipe = mysql_real_escape_string($this->input->post('tipe'));
				$kd_maks = $this->input->post('digit');
				$kode = 'SDL'.$kd_maks;
				
				if ($_FILES['imagefile']['type'] == "image/jpeg"){
					$ori_src="asset/produk/imgoriginal/".strtolower( str_replace(' ','_',$_FILES['imagefile']['name']) );
					if(move_uploaded_file ($_FILES['imagefile']['tmp_name'],$ori_src))
					{
						chmod("$ori_src",0777);
					}else{
						echo "Gagal melakukan proses upload file.";
						exit;
					}

					$thumb_src="asset/produk/".strtolower( str_replace(' ','_',$_FILES['imagefile']['name']) );
					
					$n_width = 150;
					$n_height = 150;
				
					if(($_FILES['imagefile']['type']=="image/jpeg") || ($_FILES['imagefile']['type']=="image/png") ||($_FILES['imagefile']['type']=="image/gif"))
					{
						$im = @ImageCreateFromJPEG ($ori_src) or // Read JPEG Image
						$im = @ImageCreateFromPNG ($ori_src) or // or PNG Image
						$im = @ImageCreateFromGIF ($ori_src) or // or GIF Image
						$im = false; // If image is not JPEG, PNG, or GIF
						
						//$im=ImageCreateFromJPEG($ori_src); 
						$width=ImageSx($im);              // Original picture width is stored
						$height=ImageSy($im);             // Original picture height is stored
						if(($n_height==0) && ($n_width==0)) {
							$n_height = $height;
							$n_width = $width;
						}	
		
						if(!$im) {
							echo '<p>Gagal membuat thumnail</p>';
							exit;
						}
						else {				
							$newimage=@imagecreatetruecolor($n_width,$n_height);                 
							@imageCopyResized($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);
							@ImageJpeg($newimage,$thumb_src);
							chmod("$thumb_src",0777);
						}
					}
					$this->sandal_admin_model->jalankan_query_manual("insert into tbl_produk 
					(kode_produk,id_kategori,nama_produk,harga,stok,dibeli,gbr_kecil,gbr_besar,deskripsi,tipe_produk) 
					values('".$kode."','".$kategori."','".$nama."','".$harga."','".$stok."','".$dibeli."','".$_FILES['imagefile']['name']."'
					,'".$_FILES['imagefile']['name']."','".$deskripsi."','".$tipe."')");
					echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/lihat_produk'>";
				}
				else
				{
					echo "Hayooo,,,mau upload file apaan tuh...??? Upload yang berjenis gambar aja mas brow, gak usah macam-macam...!!! OKOK";
				}
				
				
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}


//====================Modul Hapus==================//


	function hapus_admin()
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
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$data["upd"] = $this->sandal_admin_model->hapus_konten($kode,"kode_spr_admn","tbl_spr_admn");
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/tambah_admin'>";
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}
	
	function hapus_testi()
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
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$data["upd"] = $this->sandal_admin_model->hapus_konten($kode,"id_testi","tbl_testimonial");
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/lihat_semua_testimonial'>";
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}
	
	function hapus_member()
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
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$data["upd"] = $this->sandal_admin_model->hapus_konten($kode,"kode_user","tbl_user");
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/lihat_semua_member'>";
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}
	
	function hapus_produk()
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
		$gb='';		
		if ($this->uri->segment(4) === FALSE)
		{
    			$gb='';
		}
		else
		{
    			$gb = $this->uri->segment(4);
		}
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$file_kcl = './asset/produk/'.$gb;
				$file_bsr = './asset/produk/imgoriginal/'.$gb;
				unlink($file_kcl);
				unlink($file_bsr);
				$data["upd"] = $this->sandal_admin_model->hapus_konten($kode,"kode_produk","tbl_produk");
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/lihat_produk'>";
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}
	
	function hapus_banner()
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
		$gb='';		
		if ($this->uri->segment(4) === FALSE)
		{
    			$gb='';
		}
		else
		{
    			$gb = $this->uri->segment(4);
		}
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$file = './asset/banner/'.$gb;
				unlink($file);
				$data["upd"] = $this->sandal_admin_model->hapus_konten($kode,"kode_banner","tbl_banner");
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/set_banner'>";
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}
	
	function hapus_kategori()
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
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$data["upd"] = $this->sandal_admin_model->hapus_konten($kode,"id_kategori","tbl_kategori");
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/lihat_kategori_produk'>";
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}
	
	function hapus_katalog()
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
		$nm='';		
		if ($this->uri->segment(4) === FALSE)
		{
    			$nm='';
		}
		else
		{
    			$nm = $this->uri->segment(4);
		}
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$file = './asset/download/'.$nm;
				$data["upd"] = $this->sandal_admin_model->hapus_konten($kode,"id_katalog","tbl_katalog");
				unlink($file);
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/lihat_katalog'>";
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}
	
	function hapus_intermezzo()
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
		$gb='';		
		if ($this->uri->segment(4) === FALSE)
		{
    			$gb='';
		}
		else
		{
    			$gb = $this->uri->segment(4);
		}
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$file = './asset/intermezzo/'.$gb;
				unlink($file);
				$data["upd"] = $this->sandal_admin_model->hapus_konten($kode,"id_berita","tbl_intermezzo");
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/lihat_semua_intermezzo'>";
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}
	
	
	
//=======================Modul Tambah======================//

	
	function tambah_produk()
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
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$data["digit_akhir"] = "";
	   			$data['scriptmce'] = $this->scripttiny_mce();
				$data["kat"] = $this->sandal_admin_model->tampil_semua_kategori();
				$q = $this->sandal_admin_model->jalankan_query_manual_select("select MAX(substring(kode_produk,4,6)) as akhir from tbl_produk");
				foreach($q->result() as $a)
				{
					if($a->akhir==NULL){
						$data["digit_akhir"] = "100001";
					}
					else{
						$data["digit_akhir"] = $a->akhir+1;
					}
				}
				$data["judul"] = "Tambah Produk - Harmonis Grosir Sandal Online";
				$this->load->view('admin/bg_top',$data);
				$this->load->view('admin/bg_tambah_produk',$data);
				$this->load->view('admin/bg_footer',$data);
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}
	
	function tambah_kategori_produk()
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
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
	   			$data['scriptmce'] = $this->scripttiny_mce();
				$data["kat"] = $this->sandal_admin_model->tampil_semua_kategori();
				$data["judul"] = "Tambah Kategori Produk - Harmonis Grosir Sandal Online";
				$this->load->view('admin/bg_top',$data);
				$this->load->view('admin/bg_tambah_kategori_produk',$data);
				$this->load->view('admin/bg_footer',$data);
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}
	
	function tambah_katalog()
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
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
	   			$data['scriptmce'] = $this->scripttiny_mce();
				$data["judul"] = "Tambah Katalog Produk - Harmonis Grosir Sandal Online";
				$this->load->view('admin/bg_top',$data);
				$this->load->view('admin/bg_tambah_katalog',$data);
				$this->load->view('admin/bg_footer',$data);
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}
	
	function tambah_intermezzo()
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
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
	   			$data['scriptmce'] = $this->scripttiny_mce();
				$data["judul"] = "Tambah Intermezzo - Harmonis Grosir Sandal Online";
				$this->load->view('admin/bg_top',$data);
				$this->load->view('admin/bg_tambah_intermezzo',$data);
				$this->load->view('admin/bg_footer',$data);
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}
	
	
	
//=======================Modul Edit======================//
	
	
	
	function edit_produk()
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
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
	   			$data['scriptmce'] = $this->scripttiny_mce();
				$data["ls"] = $this->sandal_admin_model->tampil_detail_produk($kode);
				$data["kat"] = $this->sandal_admin_model->tampil_semua_kategori();
				$data["judul"] = "Edit Produk - Harmonis Grosir Sandal Online";
				$this->load->view('admin/bg_top',$data);
				$this->load->view('admin/bg_edit_produk',$data);
				$this->load->view('admin/bg_footer',$data);
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}	
	
	function edit_banner()
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
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
	   			$data['scriptmce'] = $this->scripttiny_mce();
				$data["ls"] = $this->sandal_admin_model->tampil_detail_banner($kode);
				$data["judul"] = "Edit Banner - Harmonis Grosir Sandal Online";
				$this->load->view('admin/bg_top',$data);
				$this->load->view('admin/bg_edit_banner',$data);
				$this->load->view('admin/bg_footer',$data);
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}	
	
	
	function edit_kategori()
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
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
	   			$data['scriptmce'] = $this->scripttiny_mce();
				$data["ls"] = $this->sandal_admin_model->jalankan_query_manual_select("select * from tbl_kategori where id_kategori='$kode'");
				$data["kat"] = $this->sandal_admin_model->jalankan_query_manual_select("select * from tbl_kategori where id_kategori!='$kode'");
				$data["judul"] = "Edit Produk - Harmonis Grosir Sandal Online";
				$this->load->view('admin/bg_top',$data);
				$this->load->view('admin/bg_edit_kategori_produk',$data);
				$this->load->view('admin/bg_footer',$data);
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}	
	
	
	function edit_katalog()
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
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$data["kat"] = $this->sandal_admin_model->jalankan_query_manual_select("select * from tbl_katalog where id_katalog='$kode'");
				$data["judul"] = "Edit Katalog - Harmonis Grosir Sandal Online";
				$this->load->view('admin/bg_top',$data);
				$this->load->view('admin/bg_edit_katalog',$data);
				$this->load->view('admin/bg_footer',$data);
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}	
	
	
	function edit_member()
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
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
	   			$data['scriptmce'] = $this->scripttiny_mce();
				$data["kat"] = $this->sandal_admin_model->jalankan_query_manual_select("select * from tbl_user where kode_user='$kode'");
				$data["judul"] = "Edit Member - Harmonis Grosir Sandal Online";
				$this->load->view('admin/bg_top',$data);
				$this->load->view('admin/bg_edit_member',$data);
				$this->load->view('admin/bg_footer',$data);
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}	
	
	
	function edit_testi()
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
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
	   			$data['scriptmce'] = $this->scripttiny_mce();
				$data["kat"] = $this->sandal_admin_model->jalankan_query_manual_select("select * from tbl_testimonial where id_testi='$kode'");
				$data["judul"] = "Edit Testimonial - Harmonis Grosir Sandal Online";
				$this->load->view('admin/bg_top',$data);
				$this->load->view('admin/bg_edit_testi',$data);
				$this->load->view('admin/bg_footer',$data);
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}	
	
	
	function edit_intermezzo()
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
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
	   			$data['scriptmce'] = $this->scripttiny_mce();
				$data["kat"] = $this->sandal_admin_model->jalankan_query_manual_select("select * from tbl_intermezzo where id_berita='$kode'");
				$data["judul"] = "Edit Intermezzo - Harmonis Grosir Sandal Online";
				$this->load->view('admin/bg_top',$data);
				$this->load->view('admin/bg_edit_intermezzo',$data);
				$this->load->view('admin/bg_footer',$data);
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}
	
	
	
//=======================MODUL UPDATE===================================//


	function update_profil()
	{
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$usr = mysql_real_escape_string($this->input->post('username'));
				$nama = mysql_real_escape_string($this->input->post('nama'));
				$email = mysql_real_escape_string($this->input->post('email'));
				$alamat = mysql_real_escape_string($this->input->post('alamat'));
				$tgl = $this->input->post('tgl');
				$kd = $this->input->post('kd_usr');
				$q = "update tbl_spr_admn set username_admn='".$usr."', nama_admn='".$nama."', email='".$email."', alamat='".$alamat."', tgl_lahir='".$tgl."' where kode_spr_admn = 
				'".$kd."'";
				$data["upd"] = $this->sandal_admin_model->jalankan_query_manual($q);
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/set_akun'>";
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}

	function update_kategori()
	{
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$id = $this->input->post('id');
				$nama = mysql_real_escape_string($this->input->post('nama'));
				$prnt = $this->input->post('prnt');
				$lvl = $this->input->post('lvl');
				$q = "update tbl_kategori set nama_kategori='".$nama."', kode_level='".$lvl."', kode_parent='".$prnt."' where id_kategori = 
				'".$id."'";
				$data["upd"] = $this->sandal_admin_model->jalankan_query_manual($q);
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/lihat_kategori_produk'>";
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}
	
	function update_pass()
	{
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
			$datapesan['username'] = mysql_real_escape_string($this->input->post('username'));
			$datapesan['passlama'] = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($this->input->post('passlama'),ENT_QUOTES))));
			$datapesan['passbaru'] = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($this->input->post('passbaru'),ENT_QUOTES))));
			$datapesan['ulangi'] = mysql_real_escape_string($this->input->post('ulangi'));
			$bersih = md5($datapesan['passbaru']);

				if($datapesan['passlama']=="" && $datapesan['passbaru']=="" && $datapesan['ulangi']=="")
				{
					echo "Field belum lengkap. Mohon diisi dengan selengkap-lengkapnya.";
				}
				else
				{
					$cek = $this->sandal_admin_model->data_login_admin($datapesan['username'],$datapesan['passlama']);
					if($datapesan['ulangi']==$datapesan['passbaru']){
						if(count($cek->result())>0){
							$q_update = "update tbl_spr_admn set pass_admn='".$bersih."' where kode_spr_admn='".$data["kd"]."'";
							$this->sandal_admin_model->jalankan_query_manual($q_update);
							echo "Berhasil memperbaharui data profil anda.";
							?>
								<script>
								alert('Berhasil memperbaharui data profil anda.');
								</script>
							<?php
							echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/set_akun'>";
						}
						else{
							echo "Password Lama Salah. Gagal memperbaharui data password anda.";
							?>
								<script>
								alert('Password Lama Salah. Gagal memperbaharui data password anda.');
								</script>
							<?php
							echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/set_akun'>";
						}
					}
					else{
						echo "Password Tidak Sama/Sinkron. Gagal memperbaharui data password anda.";
						?>
							<script>
							alert('Password Tidak Sama/Sinkron. Gagal memperbaharui data password anda.');
							</script>
						<?php
						echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/set_akun'>";
						
					}
				}
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}

	function update_katalog()
	{
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$nama = mysql_real_escape_string($this->input->post('nama'));
				$id = $this->input->post('id');
				$fl = $this->input->post('nm_fl');
				
				if(empty($_FILES['userfile']['name']))
				{
					$this->sandal_admin_model->jalankan_query_manual("update tbl_katalog set judul_file='".$nama."' where id_katalog='".$id."'");
					echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/lihat_katalog'>";
				}
				else
				{
					$acak=rand(00000000000,99999999999);
					$bersih=$_FILES['userfile']['name'];
					
					$ext = end(explode('.', $bersih));
					$ext = substr(strrchr($bersih, '.'), 1);
					$ext = substr($bersih, strrpos($bersih, '.') + 1);
					$ext = preg_replace('/^.*\.([^.]+)$/D', '$1', $bersih);
					$exts = split("[/\\.]", $bersih);
					$n = count($exts)-1;
					$ext = $exts[$n];
					
					$nama_fl = $acak.'.'.$ext;
					
					$config["file_name"]=$acak;
					$config['upload_path'] = './asset/download/';
					$config['allowed_types'] = 'pdf|xls|zip|jpg|jpeg|png|txt|doc|docx|xlsx';
					$config['max_size'] = '50000';						
					$this->load->library('upload', $config);
				
					if(!$this->upload->do_upload())
					{
						echo $this->upload->display_errors();
						echo $config['upload_path'];
					}
					else {
						$file = './asset/download/'.$fl;
						unlink($file);
						$this->sandal_admin_model->jalankan_query_manual("update tbl_katalog set judul_file='".$nama."',nama_file='".$nama_fl."' 
						where id_katalog='".$id."'");
						echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/lihat_katalog'>";
					}
				}
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}

	function update_member()
	{
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$datapesan['nama'] = mysql_real_escape_string($this->input->post('nama'));
				$datapesan['username'] = mysql_real_escape_string($this->input->post('username'));
				$datapesan['email'] = mysql_real_escape_string($this->input->post('email'));
				$datapesan['alamat'] = mysql_real_escape_string($this->input->post('alamat'));
				$datapesan['telpon'] = mysql_real_escape_string($this->input->post('telpon'));
				$datapesan['propinsi'] = mysql_real_escape_string($this->input->post('propinsi'));
				$datapesan['kota'] = mysql_real_escape_string($this->input->post('kota'));
				$datapesan['kodepos'] = mysql_real_escape_string($this->input->post('kodepos'));
				$datapesan['pass'] = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($this->input->post('pass'),ENT_QUOTES))));
				$bersih = md5($datapesan['pass']);
				$tgl = $this->input->post('tgl');
				$bln = $this->input->post('bln');
				$thn = $this->input->post('thn');
				$datapesan['tgl_lahir'] = $tgl.'-'.$bln.'-'.$thn;
				
				if(empty($datapesan['pass']))
				{
					$q = "update tbl_user set username_user='".$datapesan['username']."', nama='".$datapesan['nama']."',email='".$datapesan['email']."',alamat='".$datapesan['alamat']."',telpon='".$datapesan['telpon']."',propinsi='".$datapesan['propinsi']."',kota='".$datapesan['kota']."',tgl_lahir='".$datapesan['tgl_lahir']."',kode_pos='".$datapesan['kodepos']."' where kode_user='".$pecah[2]."'";
				
					$data["upd"] = $this->sandal_admin_model->jalankan_query_manual($q);
					echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/lihat_semua_member'>";
				}
				else
				{
					$q = "update tbl_user set username_user='".$datapesan['username']."',pass_user='".$bersih."', nama='".$datapesan['nama']."',email='".$datapesan['email']."',alamat='".$datapesan['alamat']."',telpon='".$datapesan['telpon']."',propinsi='".$datapesan['propinsi']."',kota='".$datapesan['kota']."',tgl_lahir='".$datapesan['tgl_lahir']."',kode_pos='".$datapesan['kodepos']."' where kode_user='".$pecah[2]."'";
				
					$data["upd"] = $this->sandal_admin_model->jalankan_query_manual($q);
					echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/lihat_semua_member'>";
				}
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}

	function update_testi()
	{
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$id = $this->input->post('id');
				$nama = mysql_real_escape_string($this->input->post('nama'));
				$email = mysql_real_escape_string($this->input->post('email'));
				$pesan = mysql_real_escape_string($this->input->post('pesan'));
				$status = $this->input->post('stts');
				$waktu = mysql_real_escape_string($this->input->post('waktu'));
				$q = "update tbl_testimonial set nama='".$nama."', email='".$email."', pesan='".$pesan."', status='".$status."', waktu='".$waktu."' 
				where id_testi = '".$id."'";
				$data["upd"] = $this->sandal_admin_model->jalankan_query_manual($q);
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/lihat_semua_testimonial'>";
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}

	function update_intermezzo()
	{
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$judul = mysql_real_escape_string($this->input->post('judul'));
				$isi = mysql_real_escape_string($this->input->post('isi'));
				$gbr = $this->input->post('gbr');
				$id = $this->input->post('id');
				
				
				if(empty($_FILES['userfile']['name']))
				{
					$this->sandal_admin_model->jalankan_query_manual("update tbl_intermezzo set judul='".$judul."',isi_berita='".$isi."' where 
					id_berita='".$id."'");
					echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/lihat_semua_intermezzo'>";
				}
				else
				{
					$acak=rand(00000000000,99999999999);
					$bersih=$_FILES['userfile']['name'];
					$nm=str_replace(" ","_","$bersih");
					$pisah=explode(".",$nm);
					$nama_murni=$pisah[0];
					$ubah=$acak.$nama_murni; //tanpa ekstensi
					$config["file_name"]=$ubah; //dengan eekstensi
					$nama_fl=$acak.$nm; //simpan nama ini k database
					$config['upload_path'] = './asset/intermezzo/';
					$config['allowed_types'] = 'bmp|gif|jpg|jpeg|png';
					$config['max_size'] = '500';
					$config['max_width'] = '300';
					$config['max_height'] = '300';					
					$this->load->library('upload', $config);
				
					if(!$this->upload->do_upload())
					{
						echo $this->upload->display_errors();
					}
					else {
						$file = './asset/intermezzo/'.$gbr;
						unlink($file);
						$this->sandal_admin_model->jalankan_query_manual("update tbl_intermezzo set judul='".$judul."', isi_berita='".$isi."', 
						gambar='".$nama_fl."' where id_berita='".$id."'");
						echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/lihat_semua_intermezzo'>";
					}
				}
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}

	function update_banner()
	{
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$judul = mysql_real_escape_string($this->input->post('judul'));
				$deskripsi = mysql_real_escape_string($this->input->post('deskripsi'));
				$stts = mysql_real_escape_string($this->input->post('stts'));
				$gbr = $this->input->post('gbr');
				$id = $this->input->post('id');
				
				
				if(empty($_FILES['userfile']['name']))
				{
					$this->sandal_admin_model->jalankan_query_manual("update tbl_banner set judul='".$judul."',deskripsi='".$deskripsi."',stts='".$stts."' where 
					kode_banner='".$id."'");
					echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/set_banner'>";
				}
				else
				{
					$acak=rand(00000000000,99999999999);
					$bersih=$_FILES['userfile']['name'];
					$nm=str_replace(" ","_","$bersih");
					$pisah=explode(".",$nm);
					$nama_murni=$pisah[0];
					$ubah=$acak.$nama_murni; //tanpa ekstensi
					$config["file_name"]=$ubah; //dengan eekstensi
					$nama_fl=$acak.$nm; //simpan nama ini k database
					$config['upload_path'] = './asset/banner/';
					$config['allowed_types'] = 'bmp|gif|jpg|jpeg|png';
					$config['max_size'] = '2000';
					$config['max_width'] = '680';
					$config['max_height'] = '200';					
					$this->load->library('upload', $config);
				
					if(!$this->upload->do_upload())
					{
						echo $this->upload->display_errors();
					}
					else {
						$file = './asset/banner/'.$gbr;
						unlink($file);
						$this->sandal_admin_model->jalankan_query_manual("update tbl_banner set judul='".$judul."',deskripsi='".$deskripsi."',stts='".$stts."', 
						gambar='".$nama_fl."' where kode_banner='".$id."'");
						echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/set_banner'>";
					}
				}
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}

	function update_produk()
	{
		$session=isset($_SESSION['admin_grosir_sandal']) ? $_SESSION['admin_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["username"]=$pecah[0];
			$data["nama"]=$pecah[1];
			$data["kd"]=$pecah[2];
			$data["lvl"]=$pecah[3];
			
			if($data["lvl"]=="spradmn")
			{
				$kategori = mysql_real_escape_string($this->input->post('kategori'));
				$nama = mysql_real_escape_string($this->input->post('nama'));
				$harga = mysql_real_escape_string($this->input->post('harga'));
				$stok = mysql_real_escape_string($this->input->post('stok'));
				$dibeli = mysql_real_escape_string($this->input->post('dibeli'));
				$deskripsi = mysql_real_escape_string($this->input->post('deskripsi'));
				$tipe = mysql_real_escape_string($this->input->post('tipe'));
				$kode = $this->input->post('id');
				$gbr = $this->input->post('gbr');
				
				if(empty($_FILES['imagefile']['name']))
				{
					$this->sandal_admin_model->jalankan_query_manual("update tbl_produk set id_kategori='".$kategori."', nama_produk='".$nama."', harga='".$harga."', 
					stok='".$stok."', dibeli='".$dibeli."', deskripsi='".$deskripsi."', tipe_produk='".$tipe."' where kode_produk='".$kode."'");;
					echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/lihat_produk'>";
				}
				else
				{
					if ($_FILES['imagefile']['type'] == "image/jpeg"){
						$ori_src="asset/produk/imgoriginal/".strtolower( str_replace(' ','_',$_FILES['imagefile']['name']) );
						if(move_uploaded_file ($_FILES['imagefile']['tmp_name'],$ori_src))
						{
							chmod("$ori_src",0777);
						}else{
							echo "Gagal melakukan proses upload file.";
							exit;
						}
	
						$thumb_src="asset/produk/".strtolower( str_replace(' ','_',$_FILES['imagefile']['name']) );
						
						$n_width = 150;
						$n_height = 150;
					
						if(($_FILES['imagefile']['type']=="image/jpeg") || ($_FILES['imagefile']['type']=="image/png") ||($_FILES['imagefile']['type']=="image/gif"))
						{
							$im = @ImageCreateFromJPEG ($ori_src) or // Read JPEG Image
							$im = @ImageCreateFromPNG ($ori_src) or // or PNG Image
							$im = @ImageCreateFromGIF ($ori_src) or // or GIF Image
							$im = false; // If image is not JPEG, PNG, or GIF
							
							//$im=ImageCreateFromJPEG($ori_src); 
							$width=ImageSx($im);              // Original picture width is stored
							$height=ImageSy($im);             // Original picture height is stored
							if(($n_height==0) && ($n_width==0)) {
								$n_height = $height;
								$n_width = $width;
							}	
			
							if(!$im) {
								echo '<p>Gagal membuat thumnail</p>';
								exit;
							}
							else {				
								$newimage=@imagecreatetruecolor($n_width,$n_height);                 
								@imageCopyResized($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);
								@ImageJpeg($newimage,$thumb_src);
								chmod("$thumb_src",0777);
							}
						}
						$this->sandal_admin_model->jalankan_query_manual("update tbl_produk set id_kategori='".$kategori."', nama_produk='".$nama."', harga='".$harga."', 
						stok='".$stok."', dibeli='".$dibeli."', gbr_kecil='".$_FILES['imagefile']['name']."', gbr_besar='".$_FILES['imagefile']['name']."', 
						deskripsi='".$deskripsi."', tipe_produk='".$tipe."' where kode_produk='".$kode."'");
						$file_kcl = './asset/produk/'.$gbr;
						$file_bsr = './asset/produk/imgoriginal/'.$gbr;
						unlink($file_kcl);
						unlink($file_bsr);
						echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/lihat_produk'>";
					}
					else
					{
						echo "Hayooo,,,mau upload file apaan tuh...??? Upload yang berjenis gambar aja mas brow, gak usah macam-macam...!!! OKOK";
					}
				}
				
			}
		}
		else{
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
	}



//==================Login============================//


	function aksilogin()
	{
		$username = mysql_real_escape_string($this->input->post('username'));
		$pwd = mysql_real_escape_string($this->input->post('password'));
		$hasil = $this->sandal_admin_model->data_login_admin($username,$pwd);
		
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
			echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
		}
		else
		{
			if (!ctype_alnum($username) OR !ctype_alnum($pwd)){
				?>
				<script type="text/javascript">
				alert("Protected....!!!");			
				</script>
				<?php
				echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
			}
			else{
				if (count($hasil->result_array())>0){
					$sql_hapus  = "delete FROM captcha";
					$query = $this->db->query($sql_hapus);
					foreach($hasil->result() as $items){
						$session_username=$items->username_admn."|".$items->nama_admn."|".$items->kode_spr_admn."|".$items->lvl;
					}
					$_SESSION['admin_grosir_sandal']=$session_username;
					echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot'>";
				}
				else{
					?>
					<script type="text/javascript">
					alert("Username atau Password Yang Anda Masukkan Salah ..!!!");			
					</script>
					<?php
					echo "<meta http-equiv='refresh' content='0; url=".base_url()."aksesroot/login'>";
				}
			}
		}
	}
	
//====================Tiny MCE===============================//

//Function TinyMce------------------------------------------------------------------
		private function scripttiny_mce() {
		return '
		<!-- TinyMCE -->
		<script type="text/javascript" src="'.base_url().'jscripts/tiny_mce/tiny_mce_src.js"></script>
		<script type="text/javascript">
		tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example content CSS (should be your site CSS)
		content_css : "'.base_url().'system/application/views/themes/css/BrightSide.css",

		// Drop lists for link/image/media/template dialogs
		//"'.base_url().'media/lists/image_list.js"
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "'.base_url().'index.php/adminweb/image_list/",
		media_external_list_url : "lists/media_list.js",

		// Style formats
		style_formats : [
			{title : \'Bold text\', inline : \'b\'},
			{title : \'Red text\', inline : \'span\', styles : {color : \'#ff0000\'}},
			{title : \'Red header\', block : \'h1\', styles : {color : \'#ff0000\'}},
			{title : \'Example 1\', inline : \'span\', classes : \'example1\'},
			{title : \'Example 2\', inline : \'span\', classes : \'example2\'},
			{title : \'Table styles\'},
			{title : \'Table row 1\', selector : \'tr\', classes : \'tablerow1\'}
		],

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>';	
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
