<?php
/**
 * Created by PhpStorm.
 * User: petereussen
 * Date: 13/02/15
 * Time: 15:21
 */

namespace Woppe\Wordpress\Theme;

use Exception;
use Woppe\Wordpress\WordpressException;

class InvalidTemplateException extends WordPressException
{
	public function __construct( $message = "", $code = 0, Exception $previous = null )
	{
		$message = sprintf("View not found: %s",$message);
		parent::__construct( $message, $code, $previous ); // TODO: Change the autogenerated stub
	}

}