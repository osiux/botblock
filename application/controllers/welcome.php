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

			$this->data['users'] = $this->input->post('users', '');
			$this->data['report'] = $this->input->post('report', 0);

			if ($this->input->post('send')) {
				$captcha_check = recaptcha_check_answer(config_item('recaptcha_private_key'), $this->input->ip_address(), $this->input->post('recaptcha_challenge_field'), $this->input->post('recaptcha_response_field'));

				if (empty($this->data['users'])) {
					$error[] = 'Debes escribir al menos un usuario.';
				}

				if (!$captcha_check->is_valid) {
					$error[] = 'Captcha incorrecto.';
				}

				if(count($error) == 0) {
					$this->view = 'welcome/end';

					$this->data['result'] = array();
					$users = $this->_get_users_from_list($this->data['users']);

					foreach ($users as $user) {
						$code = $this->tmhOAuth->request('POST', $this->tmhOAuth->url('1/report_spam'), array('screen_name' => $user));

						if ($code == 200) {
							$this->data['result'][$user] = true;
						}else{
							$this->data['result'][$user] = false;
						}
					}
				}else{
					$this->data['error'] = $error;
				}
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