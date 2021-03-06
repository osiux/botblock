<?php
class Welcome extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->library('recaptcha');
	}

	public function index()
  	{
		if ($this->user) {
			$error = array();

			$this->data['users'] = request_var('users', '', true);
			$this->data['report'] = request_var('report', 0);

			if ($this->input->post('recaptcha_challenge_field')) {
        		$captcha_check = recaptcha_check_answer(config_item('recaptcha_private_key'), $this->input->ip_address(), request_var('recaptcha_challenge_field', ''), request_var('recaptcha_response_field', ''));

				if (empty($this->data['users'])) {
					$error[] = 'Debes escribir al menos un usuario.';
				}

				if (!$captcha_check->is_valid) {
					$error[] = 'Captcha incorrecto.';
				}else{
					$this->session->set_userdata('is_valid', true);
				}

				if(count($error) == 0) {
					$this->data['userlist'] = $this->_get_users_from_list($this->data['users']);

					/*foreach ($users as $user) {
						$code = $this->tmhOAuth->request('POST', $this->tmhOAuth->url('1/report_spam'), array('screen_name' => $user));

						$response = json_decode($this->tmhOAuth->response['response']);
						if ($code == 200) {
							$this->data['result'][$user] = true;
			              	$result[$user] = true;
			            }elseif ($code == 403) {
			            	$error[] = 'Twitter no te deja reportar mas cuentas por el momento :(';
	              			break;
			            }else{
							$this->data['result'][$user] = false;
			              	$result[$user] = false;

			              	if ($response->errors == 'You are over the limit for spam reports.') {
			              		$error[] = 'Twitter no te deja reportar mas cuentas por el momento :(';
		              			break;
			              	}
			            }
          			}
          			$this->session->set_userdata('result', $result);*/
				}

				$this->data['errors'] = $error;
      		}
		}
	}

	public function end()
	{
		//
	}

	public function report()
	{
		$this->data['is_valid'] = $this->session->userdata('is_valid');
		if ($this->session->userdata('is_valid')) {
			$user = request_var('user', '');
			$last = request_var('last', false);

			$code = $this->tmhOAuth->request('POST', $this->tmhOAuth->url('1/report_spam'), array('screen_name' => $user));

			$this->data['user'] = $user;
			$response = json_decode($this->tmhOAuth->response['response']);
			if ($code == 200) {
				$this->data['result'] = true;
				if ($last) {
					//$this->session->unset_userdata('is_valid');
				}
			}else{
				$this->data['errors'] = 'Twitter no te deja reportar mas cuentas por el momento :(';
				$this->session->unset_userdata('is_valid');
			}
		}
	}

	public function _get_users_from_list($data)
	{
		$users = array();
		$lists = array();

		$lines = explode(PHP_EOL, $data);
		$lines = array_map('trim', $lines);

		foreach ($lines as $line) {
			if (preg_match('#^@?([a-z0-9_]+)$#i', $line, $match)) {
				$users[] = $match[1];
			}

			if (preg_match('@https?://twitter\.com/(#!/)?([a-z0-9_]+)/?$@i', $line, $match)) {
				$users[] = $match[2];
			}

			if (preg_match('#^@?(([a-z0-9_]+)/(.*))$#i', $line, $match)) {
				$lists[] = $match[1];
			}

			if (preg_match('@https?://twitter\.com/(#!/)?(([a-z0-9_]+)/(.*))/?$@i', $line, $match)) {
				$lists[] = $match[2];
			}
		}

		foreach ($lists as $list) {
			list($list_owner, $list_slug) = explode('/', $list);

			$cachename = 'botblock.list.' . $list_owner . '.' . $list_slug;

			if (!$list_users = $this->cache->get($cachename)) {
				$list_users = array();
				$cursor = -1;
				do {
					$code = $this->tmhOAuth->request('GET', $this->tmhOAuth->url('1/lists/members'), array('slug' => $list_slug, 'owner_screen_name' => $list_owner, 'include_entities' => 0, 'skip_status' => 1, 'cursor' => $cursor));

					if ($code == 200) {
						$resp = json_decode($this->tmhOAuth->response['response']);

						foreach ($resp->users as $user) {
							$list_users[] = $user->screen_name;
						}

						$cursor = $resp->next_cursor;
					}else{
						$cursor = 0;
					}
				}while ($cursor != 0);

				$this->cache->save($cachename, $list_users, 86400);
			}

			$users = array_merge($users, $list_users);
		}

		$users = array_unique($users);

		return $users;
	}
}