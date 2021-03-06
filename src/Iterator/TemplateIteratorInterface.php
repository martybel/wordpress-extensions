<?php
/*
 * @author: petereussen
 * @package: darionwm
 */

namespace Woppe\Wordpress\Iterator;

/**
 * Interface all iterators that could be used as a template iterator should comply with
 *
 * @package Woppe\Wordpress\Iterator
 */
interface TemplateIteratorInterface
{
  /**
   * For each Entry in the iterator, apply a template
   *
   * @param $template
   * @param string $variation
   * @return void
   */
  public function apply($template,$variation = '');

  /**
   * For each entry in the iterator, call a function
   *
   * @param $callable
   * @param array $args
   * @return void
   */
  public function each($callable,$args = []);
}