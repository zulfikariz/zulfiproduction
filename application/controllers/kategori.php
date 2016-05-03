<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kategori extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		session_start();
	}

	function index()
	{
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."'>";
	}

	function produk()
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
		
		$ubh_kode = str_replace("-",",",$kode);
		
		$page=$this->uri->segment(4);
      	$limit=15;
		if(!$page):
		$offset = 0;
		else:
		$offset = $page;
		endif;	
		
		$data['kategori'] = $this->sandal_model->tampil_produk_per_kategori($ubh_kode,$offset,$limit);
		$tot_hal = $this->sandal_model->hitung_isi_1tabel('tbl_produk','where id_kategori in ('.$ubh_kode.')');
		$desk_kat = $this->sandal_model->hitung_isi_1tabel('tbl_kategori','where id_kategori='.$p_kode[0].'');
		
		$config['base_url'] = base_url() . 'kategori/produk/'.$kode;
        	$config['total_rows'] = $tot_hal->num_rows();
        	$config['per_page'] = $limit;
			$config['uri_segment'] = 4;
	    	$config['first_link'] = 'Awal';
			$config['last_link'] = 'Akhir';
			$config['next_link'] = 'Selanjutnya';
			$config['prev_link'] = 'Sebelumnya';
       		$this->pagination->initialize($config);
		$data["paginator"] =$this->pagination->create_links();
		
		$judul = "";
		$data['link'] = "";
		foreach($desk_kat->result() as $dp)
		{
			$judul = 'Kategori '.$dp->nama_kategori;
			$data['link'] = $kode;
			$data['nama_kategori'] = $dp->nama_kategori;
		}
		$data['menu'] = $this->sandal_model->menu_kategori('0','0');
		$data['judul'] = $judul."- Grosir Sandal Online, Toko Sandal Online Termurah dan Terlengkap di Indonesia - Harmonis Grosir Sandal";
		$data['slide_atas'] = $this->sandal_model->tampil_slide_produk(10);
		$data['slide_laris'] = $this->sandal_model->tampil_slide_produk_terlaris_kiri(5);
		$data['slide_baru'] = $this->sandal_model->tampil_produk(5);
		$data['intermezzo'] = $this->sandal_model->tampil_semua_berita(5,0);
		$data['testimonial'] = $this->sandal_model->tampil_testimonial(10,0);
		$data['banner'] = $this->sandal_model->tampil_banner();
		
		$session=isset($_SESSION['username_grosir_sandal']) ? $_SESSION['username_grosir_sandal']:'';
		if($session!=""){
			$pecah=explode("|",$session);
			$data["nama"]=$pecah[1];
		}
		
		$this->load->view('web/bg_top',$data);
		$this->load->view('web/bg_left',$data);
		$this->load->view('web/bg_kategori');
		$this->load->view('web/bg_right');
		$this->load->view('web/bg_bottom');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
