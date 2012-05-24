<?php
class Template {
	public $template_data = array();
	public $use_template  = '';

	/**
	 * Set variable for using in the template
	 */
	public function set($name, $value)
	{
		$this->template_data[$name] = $value;
	}

	/**
	 * Unset variable for using in the template
	 */
	public function delete($name)
	{
		if (isset($this->template_data[$name])) {
			unset($this->template_data[$name]);
		}
	}

	/**
	 * Set template name
	 */
	public function set_template($name)
	{
		$this->use_template = $name;
	}

	/**
	 * Load view
	 */
	public function load($view = '' , $view_data = array(), $template = '', $return = FALSE)
	{
		$this->CI =& get_instance();

		if (empty($template)) {
			$template = config_item('template_master');
		}

		if (!empty($this->use_template)) {
			$template = $this->use_template;
		}

		$this->set(config_item('data_container'), $this->CI->load->view($view, array_merge($view_data, array ('template' => $this->template_data)), true));
		return $this->CI->load->view(config_item('template_folder') . '/' . $template, $this->template_data, $return);
	}
}