<?php


class Product extends CI_Controller
{
    public function index()
    {
        $userId = $this->session->userdata("userId");

        if (empty($userId)) {
            return redirect("login");
        }

        $products = $this->db->get('product')->result();
        $this->load->view('products/add_product', ['products' => $products]);
    }

    public function create()
    {
        $input_data = [
            'name' => $this->input->post('name'),
            'buy_price' => $this->input->post('buyPrice'),
            'retail_price' => $this->input->post('retailPrice'),
            'whole_price' => $this->input->post('wholePrice'),
            'quantity' => $this->input->post('quantity'),
            'inventory' => $this->input->post('quantity'),
            'stock_limit' => $this->input->post('stockLimit'),
        ];
        $this->db->insert('product', $input_data);
        $this->session->set_flashdata('create_product_success', 'Product added successfully!');
        redirect('Product/index');
    }

    public function edit($id)
    {
        if (!$this->session->userdata("userId")) {
            return redirect("login");
        }
        $product = $this->db->get_where('product', ['id' => $id])->row();
        $this->load->view('products/edit_product', ['product' => $product]);

    }


    public function update()
    {
        $input_data = [
            'id' => $this->input->post('id'),
            'name' => $this->input->post('name'),
            'buyPrice' => $this->input->post('buyPrice'),
            'retailPrice' => $this->input->post('retailPrice'),
            'wholePrice' => $this->input->post('wholePrice'),
        ];

        $this->db->replace('product', $input_data);

        $this->session->set_flashdata('update_product_success', 'Product updated successfully!');
        redirect('Product/index');
    }


    public function delete($id)
    {
        $this->db->delete('product', ['id' => $id]);
        $this->session->set_flashdata('delete_product_success', 'Product deleted successfully!');
        redirect('Product/index');
    }
}