# WPEssential Sidebars
Help to register the sidebars in WordPress.

`composer require wpessential-sidebars`

Add the single sidebar to WordPress registry

```php
$sidebar = \WPEssential\Library\Sidebars::make();
$sidebar->add([
	'id'		=>'main-sidebar',
        'name'          => esc_html__( 'WPEssential: Main Sidebar', 'wpessential' ),
        'description'   => esc_html__( 'Widgets in this area will be shown on all posts and pages.', 'wpessential' ),
        'title_tag' 	=> 'h2'
]);
$sidebar->init();
```

Add the multiple sidebars to WordPress registry

```php
$sidebar = \WPEssential\Library\Sidebars::make();
$sidebar->adds([
    	'main-sidebar'   => [
        'name'          => esc_html__( 'WPEssential: Main Sidebar', 'wpessential' ),
        'description'   => esc_html__( 'Widgets in this area will be shown on all posts and pages.', 'wpessential' ),
        'title_tag' 	=> 'h2'
    ]
]);
$sidebar->init();
```

Remove the single sidebar from WordPress registry

```php
$sidebar = \WPEssential\Library\Sidebars::make();
$sidebar->remove('main-sidebar');
$sidebar->init();
```

Remove the multiple sidebars from WordPress registry

```php
$sidebar = \WPEssential\Library\Sidebars::make();
$sidebar->removes(['main-sidebar']);
$sidebar->init();
```
