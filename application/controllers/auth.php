<?php
class Auth extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->disable_template = true;
    }

    public function index()
    {
        if ($this->user) {
            redirect('/');
        }

        $callback = site_url('/');

        $params = array(
            'oauth_callback'    => $callback
        );

        $code = $this->tmhOAuth->request('POST', $this->tmhOAuth->url('oauth/request_token', ''), $params);

        if ($code == 200) {
            $oauth = $this->tmhOAuth->extract_params($this->tmhOAuth->response['response']);
            $this->session->set_userdata('oauth', $oauth);

            $authurl = $this->tmhOAuth->url("oauth/authenticate", '') .  "?oauth_token=" . $oauth['oauth_token'];

            redirect($authurl);
        }

        redirect('/');
    }

    public function logout()
    {
        if (!$this->user) {
            redirect('/');
        }

        $this->session->sess_destroy();

        redirect('/');
    }
}