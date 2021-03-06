<?php
/*
 * @author: petereussen
 * @package: wordpress-extensions
 */

namespace Woppe\Wordpress\Theme\Feature;


use Woppe\Wordpress\Mail\MailWrapper;

/**
 * Add HTML Mail support
 *
 * <code>
 * add_theme_support('woppe-html-mail','templates/custom/mailtemplate');
 * </code>
 * 
 * @package Woppe\Wordpress\Theme\Feature
 */
class HtmlMailFeature implements FeatureInterface
{
    protected $mailWrapper;
    protected $template = false;

    public function register($options = [])
    {
        $this->mailWrapper = new MailWrapper();

        if ( isset($options['template'])) {
            $this->template = $options['template'];
        } elseif ( isset($options[0])) {
            $this->template = $options[0];
        }

        if ( $this->template ) {
            add_filter('formatted_mail_template',[$this,'setMailtemplate']);
        }
    }

    public function setMailTemplate($template)
    {
        if ( !empty($this->template)) {
            $template = $this->template;
        }

        return $template;
    }

}