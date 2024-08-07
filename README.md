# wpessential-sidebars
WPEssential Sidebars helping in registry of sidebars in WordPress.

`composer require wpessential-sidebars`

Add the menu to WordPress registry

```php
use WPEssential\Library\Sidebars;


$sidebar = Sidebars::make();
$sidebar->add([
    'main-sidebar'   => [
        'name'          => esc_html__( 'WPEssential: Main Sidebar', 'wpessential' ),
        'id'            => 'sidebar-1',
        'description'   => esc_html__( 'Widgets in this area will be shown on all posts and pages.', 'wpessential' ),
        'before_widget' => '<div id="%1$s" class="wpe-widget widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="wpe-widget-title">',
        'after_title'   => '</h2>',
    ]
]);
$sidebar->init();
```

Remove the images from WordPress registry

```php
use WPEssential\Library\Sidebars;

$sidebar = Sidebars::make();
$sidebar->remove('main-sidebar');
$sidebar->init();
```
