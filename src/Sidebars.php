<?php

namespace WPEssential\Library;

if ( ! \defined( 'ABSPATH' ) && ! \defined( 'WPE_REG_SIDEBARS' ) )
{
	exit; // Exit if accessed directly.
}

final class Sidebars
{
	private $add_sidebars    = [];
	private $remove_sidebars = [];

	public static function make ()
	{
		return new self();
	}

	public function add ( $args = [] )
	{
		$this->add_sidebars = array_push( $this->add_sidebars, $args );

		return $this;
	}

	public function adds ( $args = [] )
	{
		$this->add_sidebars = array_merge( $this->add_sidebars, $args );

		return $this;
	}

	public function remove ( $key = '' )
	{
		$this->remove_sidebars = array_push( $this->remove_sidebars, $key );

		return $this;
	}

	public function removes ( $keyes = [] )
	{
		$this->remove_sidebars = array_merge( $this->remove_sidebars, $keyes );

		return $this;
	}

	public function __construct () {}

	public function init ()
	{
		add_action( 'widgets_init', [ __CLASS__, 'unregister' ], 1000 );
		add_action( 'widgets_init', [ __CLASS__, 'register' ], 1000 );
	}

	private function unregister ()
	{
		$sidebars = apply_filters( 'wpe/library/sidebars_remove', array_merge( $this->remove_sidebars, [ '' ] ) );
		if ( ! empty( $sidebars ) )
		{
			$un_reg_sid = 'unre' . 'gister' . '_side' . 'bar';
			foreach ( $sidebars as $sidebar )
			{
				$un_reg_sid( $sidebar );
			}
		}
	}

	private function register ()
	{
		$sidebars = apply_filters(
			'wpe/library/sidebars_add',
			array_merge( $this->add_sidebars, [
				'main-sidebar'   => [
					'name'        => esc_html__( 'WPEssential: Main Sidebar', 'wpessential' ),
					'description' => esc_html__( 'Widgets in this area will be shown on all posts and pages.', 'wpessential' ),
					'title_tag'   => 'h2',
				],
				'footer-sidebar' => [
					'name'        => esc_html__( 'WPEssential: Footer Sidebar', 'wpessential' ),
					'description' => esc_html__( 'Widgets in this area will be shown on all posts and pages.', 'wpessential' ),
					'title_tag'   => 'h2',
				]
			] )
		);

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
