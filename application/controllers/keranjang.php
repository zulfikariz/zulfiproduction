<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Keranjang extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		session_start();
	}

	function index()
	{
		$data['menu'] = $this->sandal_model->menu_kategori('0','0');
		$data['judul'] = "Keranjang Belanja - Grosir Sandal Online, Toko Sandal Online Termurah dan Terlengkap di Indonesia - Harmonis Grosir Sandal";
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
		
		$this->load->view('web/bg_top',$data);
		$this->load->view('web/bg_left',$data);
		$this->load->view('web/bg_keranjang_belanja');
		$this->load->view('web/bg_right');
		$this->load->view('web/bg_bottom');
	}

	function tambah_barang()
	{
		$data = array(
			'id'      => $this->input->post('kode_produk'),
			'qty'     => $this->input->post('banyak'),
		       'price'   => $this->input->post('harga'),
			'name'    => $this->input->post('nama_produk'));
		$this->cart->insert($data);
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."keranjang/'>";
	}
	
	
	function update_keranjang()
	{
		$total = $this->cart->total_items();
		$item = $this->input->post('rowid');
		$qty = $this->input->post('qty');
		for($i=0;$i < $total;$i++)
		{
			$data = array(
			'rowid' => $item[$i],
			'qty'   => $qty[$i]);
			$this->cart->update($data);
		}
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."keranjang/'>";
	}

	function hapus_keranjang($kode)
	{
		$id='';		
		if ($this->uri->segment(3) === FALSE)
		{
    			$id='';
		}
		else
		{
    			$id = $this->uri->segment(3);
		}
		$data = array(
			'rowid' => $kode,
			'qty'   => 0);
			$this->cart->update($data);
		echo "<meta http-equiv='refresh' content='0; url=".base_url()."keranjang/'>";
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
