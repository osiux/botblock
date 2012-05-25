<?php
class MY_Controller extends CI_Controller
{
    public $user;
    public $view = '';
    public $data = array();
    public $disable_template = false;

    public function __construct()
    {
        parent::__construct();

        $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));

        $this->user = false;

        $this->tmhOAuth = new tmhOAuth(array(
            'consumer_key'    => config_item('twitter_consumer_key'),
            'consumer_secret' => config_item('twitter_consumer_secret'),
        ));

        if ($session = $this->session->userdata('access_token')) {
            $this->tmhOAuth->config['user_token'] = $session['oauth_token'];
            $this->tmhOAuth->config['user_secret'] = $session['oauth_token_secret'];

            $code = $this->tmhOAuth->request('GET', $this->tmhOAuth->url('1/account/verify_credentials'));
            if ($code == 200) {
                $this->user = json_decode($this->tmhOAuth->response['response']);
            }else{
                $this->session->sess_destroy();

                redirect('/');
            }
        }elseif (isset($_REQUEST['oauth_verifier'])) {
            $session = $this->session->userdata('oauth');

            $this->tmhOAuth->config['user_token'] = $session['oauth_token'];
            $this->tmhOAuth->config['user_secret'] = $session['oauth_token_secret'];

            $code = $this->tmhOAuth->request('POST', $this->tmhOAuth->url('oauth/access_token', ''), array(
                'oauth_verifier' => $_REQUEST['oauth_verifier']
            ));

            if ($code == 200) {
                $this->session->set_userdata('access_token', $this->tmhOAuth->extract_params($this->tmhOAuth->response['response']));
                $this->session->unset_userdata('oauth');
                redirect('/');
            }
        }

        $this->template->set('user', $this->user);
    }

    public function _output()
    {
        if (empty($this->view)) {
            $this->view = $this->router->fetch_directory() . $this->router->fetch_class() . '/' . $this->router->fetch_method();
        }

        if ($this->disable_template || $this->input->is_ajax_request()) {
            $this->output->set_content_type('application/json');
            unset($this->data['template']);
            $this->output->set_output(json_encode($this->data));
        }else{
            $this->template->load($this->view, $this->data);
        }

        echo $this->output->get_output();
    }
}

function outputError($tmhOAuth) {
  echo 'Error: ' . $tmhOAuth->response['response'] . PHP_EOL;
  tmhUtilities::pr($tmhOAuth);
}