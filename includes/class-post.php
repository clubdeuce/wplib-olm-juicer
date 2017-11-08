<?php
namespace Clubdeuce\WPLib\Components\Juicer;

/**
 * Class Post
 * @package Clubdeuce\WPLib\Components\Juicer
 *
 * @property Post_Model $model
 * @property Post_View  $view
 * @mixin    Post_Model
 * @mixin    Post_View
 * @method   string     image()
 * @method   string     the_image_url()
 * @method   string     the_timestamp()
 * @method   string     the_message()
 * @method   Post_View  view()
 */
class Post extends \WPLib_Item_Base {

}