<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Intermezzo extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		session_start();
	}
	
	function index()
	{
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."intermezzo/cari'>";
	}

	function cari()
	{
		$data['menu'] = $this->sandal_model->menu_kategori('0','0');
		$data['judul'] = "Intermezzo - Tips dan Trik - Grosir Sandal Online, Toko Sandal Online Termurah dan Terlengkap di Indonesia - Harmonis Grosir Sandal";
		$data['slide_atas'] = $this->sandal_model->tampil_slide_produk(10);
		$data['slide_laris'] = $this->sandal_model->tampil_slide_produk_terlaris_kiri(5);
		$data['slide_baru'] = $this->sandal_model->tampil_produk(5);
		$data['slide_rekomendasi'] = $this->sandal_model->tampil_slide_produk(6);
		$data['intermezzo'] = $this->sandal_model->tampil_semua_berita(5,0);
		$data['testimonial'] = $this->sandal_model->tampil_testimonial(10,0);
		$data['banner'] = $this->sandal_model->tampil_banner();
		
		$session=isset($_SESSION['username_grosir_sandal']) ? $_SESSION['username_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["nama"]=$pecah[1];
		}
		
		$page=$this->uri->segment(3);
      	$limit=5;
		if(!$page):
		$offset = 0;
		else:
		$offset = $page;
		endif;	
		
		$data['berita'] = $this->sandal_model->tampil_semua_berita($limit,$offset);
		$tot_hal = $this->sandal_model->hitung_isi_1tabel('tbl_intermezzo','');
		
		$config['base_url'] = base_url() . 'intermezzo/cari/';
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
		$this->load->view('web/bg_intermezzo');
		$this->load->view('web/bg_right');
		$this->load->view('web/bg_bottom');
	}

	function baca()
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
		$p_kode = explode("-",$kode);
		$data['detail'] = $this->sandal_model->tampil_detail_berita($p_kode[0]);
		$judul = "";
		$kd_kategori = "";
		foreach($data['detail']->result() as $dp)
		{
			$c = array (' ');
    		$d = array ('-','/','\\',',','.','#',':',';','\'','"','[',']','{','}',')','(','|','`','~','!','@','%','$','^','&','*','=','?','+');
			$s = strtolower(str_replace($d,"",$dp->judul));
			$data['link'] = strtolower(str_replace($c, '-', $s));
			$data['baca'] = $dp->judul;
			$data['id'] = $dp->id_berita;
		}
		$data['menu'] = $this->sandal_model->menu_kategori('0','0');
		$data['judul'] = $data['baca']."- Grosir Sandal Online, Toko Sandal Online Termurah dan Terlengkap di Indonesia - Harmonis Grosir Sandal";
		$data['slide_atas'] = $this->sandal_model->tampil_slide_produk(10);
		$data['slide_laris'] = $this->sandal_model->tampil_slide_produk_terlaris_kiri(5);
		$data['slide_baru'] = $this->sandal_model->tampil_produk(5);
		$data['slide_rekomendasi'] = $this->sandal_model->tampil_slide_produk(6);
		$data['slide_produk_sejenis'] = $this->sandal_model->tampil_produk_sejenis($kd_kategori,$p_kode[0],6);
		$data['intermezzo'] = $this->sandal_model->tampil_semua_berita(5,0);
		$data['banner'] = $this->sandal_model->tampil_banner();
		
		$session=isset($_SESSION['username_grosir_sandal']) ? $_SESSION['username_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["nama"]=$pecah[1];
		}
		
		$this->sandal_model->update_counter_berita($p_kode[0]);
		$data['intermezzo_acak'] = $this->sandal_model->tampil_berita_lain(5);
		$data['testimonial'] = $this->sandal_model->tampil_testimonial(10,0);
		$this->load->view('web/bg_top',$data);
		$this->load->view('web/bg_left',$data);
		$this->load->view('web/bg_baca_intermezzo');
		$this->load->view('web/bg_right');
		$this->load->view('web/bg_bottom');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
