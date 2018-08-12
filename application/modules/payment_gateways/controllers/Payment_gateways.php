<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 
 
 
 
 
 
 
 
 
 
 

use Omnipay\Omnipay;

class Payment_gateways extends Front_Controller {
	protected $order_id;
	protected $amount;
	//--------------------------------------------------------------------	
	public function __construct()
	{	
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('payment_gateways_model', null, true);
		
		$this->load->model('transactions/transactions_model');
		$this->transactions_model->skip_validation(true);	
		$this->order_id = $this->session->userdata('transaction_id');
		$this->amount = $this->session->userdata('amount');
	}
	
	/*----------------------------------------------------*/
	/*	PayPal Payment Gateway
	 /*----------------------------------------------------*/
	/**
	 * PayPal Payment Gateway
	 * @param float $amount
	 */
	public function paypal() {
		// get payment gateway information from database
		$paypal = $this->payment_gateways_model->select('settings')->find_by('name', 'PayPal');
		//Retrieve settings from database
		$settings = unserialize($paypal->settings);
		$amount = $this->currencyConversion($this->order_id, $settings['currency'], $this->amount);
	
		$testmode = false;
		if ($settings['testmode'] == 1) {
			$testmode = true;
		}
		$gateway = Omnipay::create('PayPal_Express');
		$gateway->setUsername($settings['api_username']);
		$gateway->setPassword($settings['api_password']);
		$gateway->setSignature($settings['api_signature']);
		$gateway->setTestMode($testmode);
		try {
			$response = $gateway->purchase(
					['cancelUrl'=> site_url('payment_gateways/transaction_cancelled'),
							'returnUrl'=> site_url('payment_gateways/paypalCompletePurchase'),
							'amount' => $amount,
							'description' => lang('label_order_id') . ': ' .$this->order_id,
							'currency' => $settings['currency']]
					)->send();
	
					if ($response->isSuccessful()) {
						// payment was successful: update database
						$reference = $response->getTransactionReference();  // TODO; Check the reference/id with your database
						echo "Transaction '" . $response->getTransactionId() . "' succeeded!";
					} elseif ($response->isRedirect()) {
						// redirect to offsite payment gateway
						$response->redirect();
						//return "Error " .$response->getCode() . ': ' . $response->getMessage();
					}
					else {
						// payment failed: display message to customer
						echo $response->getMessage();
					}
		} catch (Exception $e) {
			// internal error, log exception and display a generic message to the customer
			Template::set_message(lang('msg_payment_processing_error'), 'error');
			Template::redirect('/members');
		}
	
	}
	
	/**
	 * PayPal Complete Purchase Method
	 * @return boolean
	 */
	public function paypalCompletePurchase() {
		/**
		 * completePurchase: completePurchase() part is required when Payment Method returns to your returnUrl.
		 * Else payment is not considered successful.
		 * Retrieve settings from database
		 */
		$paypal = $this->payment_gateways_model->select('settings')->find_by('name', 'PayPal');
		$settings = unserialize($paypal->settings);
		$testmode = false;
		if ($settings['testmode'] == 1) {
			$testmode = true;
		}
		$gateway = Omnipay::create('PayPal_Express');
		$gateway->setUsername($settings['api_username']);
		$gateway->setPassword($settings['api_password']);
		$gateway->setSignature($settings['api_signature']);
		$gateway->setTestMode($testmode);
		$response = $gateway->completePurchase(array(
				'token' => $this->input->get('token'),
				'PayerID' => $this->input->get('PayerID'),
				'amount' => floatval($this->amount),
				'description' => lang('label_order_id') . ': ' .$this->order_id,
				'currency' => $settings['currency'],
		))->send();
	
		$paypalResponse = $response->getData(); // this is the raw response object
	
		if ( ! $response->isSuccessful()) {
			Template::set_message ( $response->getMessage(), 'error' );
			$this->transaction_cancelled($response->getTransactionReference(), $this->input->get('PayerID'), $paypalResponse);
		}
			
		if(isset($paypalResponse['PAYMENTINFO_0_ACK']) && $paypalResponse['PAYMENTINFO_0_ACK'] === 'Success') {
			// Response
			$this->transaction_confirmed($response->getTransactionReference(), $this->input->get('PayerID'), $paypalResponse);
		} else {
			Template::set_message ( lang('transaction_cancelled'), 'error' );
			$this->transaction_cancelled($response->getTransactionReference(), $this->input->get('PayerID'), $paypalResponse);
		}
	}
	
	/**
	 * Update transaction table after successful payment
	 */
	public function transaction_confirmed($transaction_id = null, $payer_id = null, $payment_details = array()) {
		$this->load->model('listings/listings_model');
		if($this->session->userdata('transaction_id')) {
			$data['transaction_id'] = $transaction_id;
			$data['payer_id'] = $payer_id;
			$data['payment_details'] = serialize($payment_details);
			$data['ip_address'] = $this->input->ip_address();
			$data['status'] = 1;
			$this->db->where('id', $this->session->userdata('transaction_id'));
			$this->db->update('transactions', $data);
			$this->session->unset_userdata('transaction_id');
			if($this->session->userdata('claimed_listing_id')) {				
				$listing_data['user_id'] = $this->session->userdata('user_id');
				$listing_data['claimed'] = 1;
				$this->db->where('id', $this->session->userdata('claimed_listing_id'));
				$this->db->update('listings', $listing_data);
				$this->session->unset_userdata('claimed_listing_id');
			}
			
			// Listing Package Information Update
			if($this->session->userdata('inserted_listing_id')) {
				$listing_data['featured'] = 1;
				$listing_data['expires_on'] = $this->session->userdata('package_duration');
				$this->db->where('id', $this->session->userdata('inserted_listing_id'));
				$this->db->update('listings', $listing_data);
				$this->session->unset_userdata('inserted_listing_id');
				$this->session->unset_userdata('package_duration');
			}
			
			Template::set_message ( lang('transaction_successful'), 'success' );
		}
		$this->session->unset_userdata('transaction_id');
		redirect('members');
	}
	
	/**
	 * Update transaction table after payment cancelled
	 */
	public function transaction_cancelled($transaction_id = null, $payer_id = null, $payment_details = array()) {
		if($transaction_id != null) {
			$data['transaction_id'] = $transaction_id;
		}
		if($payer_id != null) {
			$data['payer_id'] = $payer_id;
		}
		if(!empty($payment_details)) {
			$data['payment_details'] = serialize($payment_details);
		}
		$data['ip_address'] = $this->input->ip_address();
		$data['status'] = 2;
		$this->db->where('id', $this->session->userdata('transaction_id'));
		$this->db->update('transactions', $data);
		Template::set_message ( lang('transaction_cancelled'), 'error' );
		$this->session->unset_userdata('transaction_id');
		redirect('members');
	}
	
	/**
	 * Convert Currency
	 * @param string $to - Converted To
	 * @param decimal $amount - Amount on which conversion will be applied
	 */
	private function currencyConversion($order_id, $to, $amount) {
		if(settings_item('site.currency_code') != $to) {
			$this->load->library('CurrencyConverter');
			$this->CurrencyConverter = new CurrencyConverter();
			$amount =  $this->CurrencyConverter->convert(settings_item('site.currency_code'), $to, $amount, 1, 1);
				
			// Update Orders Currency Code and Value for Order Reports Section
			$currency_value = $this->CurrencyConverter->convert(settings_item('site.currency_code'), $to, 1.00, 1, 1);
			$this->db->where(array('id' => $this->order_id));
			$this->db->update($this->db->dbprefix . 'transactions', array('currency_code' => $to, 'currency_value' => floatval($currency_value)));
				
			return floatval($amount);
		} else {
			return floatval($amount);
		}
	}
	
}
