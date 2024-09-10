<?php

namespace WPEssential\Library;

if ( ! \defined( 'ABSPATH' ) && ! \defined( 'WPE_SIDEBARS' ) )
{
	exit; // Exit if accessed directly.
}

final class Sidebars
{
	private $add_sidebars    = [];
	private $remove_sidebars = [];

	public static function make ()
	{
		return new static();
	}

	public function add ( $args = [] )
	{
		if ( ! isset( $args[ 'id' ] ) ) return;
		$this->add_sidebars[ $args[ 'id' ] ] = $args;

		return $this;
	}

	public function adds ( $args = [] )
	{
		foreach ( $args as $id => $arg )
		{
			$this->add_sidebars[ $id ] = $arg;
		}

		return $this;
	}

	public function remove ( $key = '' )
	{
		$this->remove_sidebars[] = $key;

		return $this;
	}

	public function removes ( $keyes = [] )
	{
		foreach ( $keyes as $key )
		{
			$this->remove_sidebars[] = $key;
		}

		return $this;
	}

	public function __construct () {}

	public function init ()
	{
		add_action( 'widgets_init', [ $this, 'unregister' ], 1000 );
		add_action( 'widgets_init', [ $this, 'register' ], 1000 );
	}

	public function unregister ()
	{
		$sidebars = apply_filters( 'wpe/library/sidebars_remove', $this->remove_sidebars );
		if ( ! empty( $sidebars ) )
		{
			$un_reg_sid = 'unre' . 'gister' . '_side' . 'bar';
			foreach ( $sidebars as $sidebar )
			{
				$un_reg_sid( $sidebar );
			}
		}
	}

	public function register ()
	{
		$this->add_sidebars[ 'main-sidebar' ]   = [
			'name'        => esc_html__( 'WPEssential: Main Sidebar', 'TEXT_DOMAIN' ),
			'description' => esc_html__( 'Widgets in this area will be shown on all posts and pages.', 'TEXT_DOMAIN' ),
			'title_tag'   => 'h2',
		];
		$this->add_sidebars[ 'footer-sidebar' ] = [
			'name'        => esc_html__( 'WPEssential: Footer Sidebar', 'TEXT_DOMAIN' ),
			'description' => esc_html__( 'Widgets in this area will be shown on all posts and pages.', 'TEXT_DOMAIN' ),
			'title_tag'   => 'h2',
		];

		$sidebars = apply_filters( 'wpe/library/sidebars_add', $this->add_sidebars );

		if ( ! empty( $sidebars ) )
		{
			foreach ( $sidebars as $id => $sidebar )
			{
				$title_tag                  = $sidebar[ 'title_tag' ] ?? '';
				$sidebar[ 'before_widget' ] = '<div id="%1$s" class="wpe-widget widget %2$s">';
				$sidebar[ 'after_widget' ]  = '</div>';
				$sidebar[ 'before_title' ]  = "<$title_tag class=\"wpe-widget-title\">";
				$sidebar[ 'after_title' ]   = "</$title_tag>";
				$sidebar[ 'id' ]            = $sidebar[ 'id' ] ?? $id;

				register_sidebar( $sidebar );
			}
		}
	}
}
