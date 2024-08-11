<?php

namespace App\controllers;

class BookingController extends BaseController
{
	public function index()
	{
		$guest = new \App\models\Guest();
		$guests = $guest->all();
		
		$customer = new \App\models\Customer();
		$customers = $customer->all();
		
		$this->view('booking/index', [ 'guests' => $guests, 'customers' => $customers ]);
	}
	
	public function create()
	{
		$this->view('booking/create');
	}
	
	public function store()
	{
		$guest = new \App\models\Guest();
		$guest->name = $_POST['name'];
		$guest->save();
		
		$customer = new \App\models\Customer();
		$customer->name = $_POST['name'];
		$customer->save();
		
		header('Location: /booking');
	}
	
	public function edit($id)
	{
		$guest = new \App\models\Guest();
		$guest = $guest->find($id);
		
		$customer = new \App\models\Customer();
		$customer = $customer->find($id);
		
		$this->view('booking/edit', [ 'guest' => $guest, 'customer' => $customer ]);
	}
	
	public function update($id)
	{
		$guest = new \App\models\Guest();
		$guest = $guest->find($id);
		$guest->name = $_POST['name'];
		$guest->save();
		
		$customer = new \App\models\Customer();
		$customer = $customer->find($id);
		$customer->name = $_POST['name'];
		$customer->save();
		
		header('Location: /booking');
	}
	
	public function destroy($id)
	{
		$guest = new \App\models\Guest();
		$guest = $guest->find($id);
		$guest->delete();
		
		$customer = new \App\models\Customer();
		$customer = $customer->find($id);
		$customer->delete();
		
		header('Location: /booking');
	}
	
}