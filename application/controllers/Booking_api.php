<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking_api extends CI_Controller {

	function index() {
		$this->load->view('api_view');
	}

	function action() {
		if ($this->input->post('data_action')) {
			$data_action = $this->input->post('data_action');

			// delete the record after user confirmation
			if ($data_action == "Delete") {
				$api_url = "http://localhost/codeigniter-api/api/delete";

				$form_data = array(
					'id'		=>	$this->input->post('user_id')
				);

				$client = curl_init($api_url);
				curl_setopt($client, CURLOPT_POST, true);
				curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
				curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
				$response = curl_exec($client);
				curl_close($client);
				echo $response;
			}

			// edit the one that we are using for fetch_single
			if ($data_action == "Edit") {
				$api_url = "http://localhost/codeigniter-api/api/update";

				$form_data = array(
					'first_name'		=>	$this->input->post('first_name'),
					'last_name'			=>	$this->input->post('last_name'),
					'id'				=>	$this->input->post('user_id')
				);

				$client = curl_init($api_url);
				curl_setopt($client, CURLOPT_POST, true);
				curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
				curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
				$response = curl_exec($client);
				curl_close($client);
				echo $response;
			}

			// fetch single (for the record we are editing)
			if ($data_action == "fetch_single") {
				$api_url = "http://localhost/codeigniter-api/api/fetch_single";

				$form_data = array(
					'id'		=>	$this->input->post('user_id')
				);

				$client = curl_init($api_url);
				curl_setopt($client, CURLOPT_POST, true);
				curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
				curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
				$response = curl_exec($client);
				curl_close($client);
				echo $response;
			}
			
			// Insert new record
			if ($data_action == "Insert") {
				$api_url = "http://localhost/codeigniter-api/api/insert";
			
				$form_data = array(
					'first_name'		=>	$this->input->post('first_name'),
					'last_name'			=>	$this->input->post('last_name')
				);

				$client = curl_init($api_url);
				curl_setopt($client, CURLOPT_POST, true);
				curl_setopt($client, CURLOPT_POSTFIELDS, $form_data);
				curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
				$response = curl_exec($client);
				curl_close($client);
				echo $response;
			}

			// fetch all data
			if ($data_action == "fetch_all") {
				$api_url = "http://localhost/codeigniter-api/api";

				$client = curl_init($api_url);
				curl_setopt($client, CURLOPT_RETURNTRANSFER, true);
				$response = curl_exec($client);
				curl_close($client);
				$result = json_decode($response);
				$output = '';
				if (count($result) > 0) {
					foreach($result as $row) {
						$output .= '
						<tr>
							<td>'.$row->first_name.'</td>
							<td>'.$row->last_name.'</td>
							<td><butto type="button" name="edit" class="btn btn-warning btn-xs edit" id="'.$row->id.'">Edit</button></td>
							<td><button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row->id.'">Delete</button></td>
						</tr>
						';
					}
				}
				else {
					$output .= '
					<tr>
						<td colspan="4" align="center">No Data Found</td>
					</tr>
					';
				}
				echo $output;
			}
		}
	}
}

?>