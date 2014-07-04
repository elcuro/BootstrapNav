<?php 
App::uses('AppHelper', 'View/Helper');

/**
 * BootstrapNavHelper
 *
 * @package Croogo 1.5
 * @author jjancuska@gmail.com
 **/
class BootstrapNavHelper extends AppHelper {

/**
 * Used helpers
 *
 * @var array
 **/
	public $helpers = array('Html', 'Menu.Menus');

/**
 * Generate tree menu
 *
 * @return void
 **/
	public function nestedLinks($links, $options, $depth = 0) {

		$defaults = array(
			'mainClass' => 'nav nav-pills',
			'mainRole' => 'menulist',
			'subClass' => 'dropdown-menu',
			'subRole' => 'menu'
		);
		$options = Hash::merge($defaults, $options);

		$items = '';
		foreach($links as $link) {
			$hasChildren = !empty($link['children']);
			if (strstr($link['Link']['link'], 'controller:')) {
				$link['Link']['link'] = $this->Menus->linkStringToArray($link['Link']['link']);
			}
			$content = $this->Html->link($link['Link']['title'], $link['Link']['link'], array(
				'class' => (($hasChildren) ? ' dropdown-toggle' : '') . $link['Link']['class'] . '-link',
				'data-toggle' => ($hasChildren) ? 'dropdown' : '',
				'data-target' => '#',
				'target' => $link['Link']['target'],
				'rel' => $link['Link']['rel'],
				'title' => (empty($link['Link']['description'])) ? $link['Link']['title'] : $link['Link']['description']
			)); 
			
			if ($hasChildren) {
				$content .= $this->nestedLinks($link['children'], $options, $depth + 1);
			}	

			$liClass = array(
				($hasChildren) ? 'dropdown' : 'no-children',
				$link['Link']['class']
			);
			if (!empty($this->_View->request->params['locale'])) {
				$currentUrl = substr($this->_View->request->url, strlen($this->_View->request->params['locale'] . '/'));
			} else {
				$currentUrl = $this->_View->request->url;
			}
			if (Router::url($link['Link']['link']) == Router::url('/' . $currentUrl)) {
				$liClass[] = 'active';
			}				

			$items .= $this->Html->tag('li', $content, array(
				'class' => implode(' ', $liClass),
				'id' => 'link-' . $link['Link']['id']
			));
		}
		$attrs = array(
			'class' => ($depth == 0) ? $options['mainClass'] : $options['subClass'],
			'role' => ($depth == 0) ? $options['mainRole'] : $options['subRole']
		);
		return $this->Html->tag($options['tag'], $items, $attrs);
	}	
} // END class BootstrapNavHelper extends AppHelper

 ?>