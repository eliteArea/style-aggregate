<?php  if( !defined('BASEPATH')) exit('No direct script access allowed');

class Aggregate
{

  //private $ci;
  private $afregation , $CI , $source , $destionation , $root , $readstyle , $filename;

  public  function __construct()
  {
    $this->CI =& get_instance();

    $this->agregation = $this->CI->config->item('aggregate');
    $this->source = $this->CI->config->item('stylepath');

    $this->public_folder = $this->CI->config->item('public_html');

    $tmpstyledest = $this->CI->config->item('style_destionation');

    // root folder pointer;
    $this->root = BASEPATH . "../";

    // create destination path
    $this->destination = $this->root . '/' . $this->public_folder . '/' . $tmpstyledest;
    $this->readstyle = '/' . $tmpstyledest;
    //$this->filename = 'style.css';


    if ( ! is_writable( $this->destination )) {
     show_error("File '{$this->readstyle}' not writable please change permission on folder!");
     exit();
    }

    if( file_exists($this->destination))
    {
      $this->filename = $this->setconfig();
    }
    else
    {
      $this->filename = 'unknown';
      if( $this->agregation ) {
        show_error("style_destionation '{$tmpstyledest}' doesn't exist!!!");
        exit();
      }
    }


    if( empty( $this->source ) )
    {
      show_error("config stylepath missing in style-aggregate");
      exit();
    }

    $this->loader();

  } // constructor

  public function clearAgregate()
  {
    $clearConfig = "";
    $settings = $this->destination . '/style.config';
    if( file_exists( $settings ))
    {
      $clearConfig = $this->getSettings( $settings );
    }
    $clearStyle = $this->destination . '/' . $clearConfig;

    if( file_exists($clearStyle))
    {
      unlink( $clearStyle ); //delete css file
    }
    unlink( $settings ); // delete config file

  }//clear agregate

  private function loader()
  {
    $style = "";
    if( $this->agregation ) // aggregation on
    {
      $destination = $this->destination . "/" . $this->filename;

      if( ! file_exists( $destination ) )
      {
        $this -> buildCompress( $this->source , $destination );
      }

      $tmp = $this->readstyle . '/'. $this->filename;
      $style = "<link rel='stylesheet' type='text/css' href='{$tmp}' />";
    }
    else //aggregation off
    {

      $settings = $this->destination . '/style.config';
      if( file_exists($settings)){
        $this->clearAgregate();
      }

      foreach( $this->source as $key => $val )
      {
        if( is_numeric( $key ))
        {
          $style .= "<link rel='stylesheet' type='text/css' href='/{$val}' />";
        }
      }
    }

    define('STYLE', $style);

  }//loader

  private function compress( $buffer )
  {
    $tmp = "";
    // remove comment
    $tmp = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!' , '', $buffer);
    // remove tabs , spaces , newlines , etc.
    $tmp = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '),'',$tmp );
    return $tmp;
  }//compress

  private function buildCompress( $style , $destination )
  {
    $buffer = "";

    foreach( $style as &$value)
    {
      if( file_exists($value))
      {
        $buffer .= file_get_contents( $value , true );
      }
    }
    $compresion = $this -> compress($buffer);
    file_put_contents( $destination , $compresion );

  }//buildCompress

  private function setconfig()
  {

    $styleconfig = $this->destination . '/style.config';

    if( file_exists($styleconfig))
    {
      //$confwrite = file_get_contents( $styleconfig , true );
      $confwrite = $this->getSettings( $styleconfig );
    } else {
      $confwrite = "style{$this->setHashe()}z.css";
      file_put_contents( $styleconfig , $confwrite );
    }

    return $confwrite;

  }//setconfig

  private function setHashe()
  {
    $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $randstring = '';
    $limit = 8;
    for ($i = 0; $i < 5; $i++)
    {
      $randstring .= $characters[rand(0, strlen($characters))];
    }
    return $randstring;
  } // setHash

  private function getSettings( $file ){
    return file_get_contents( $file , true );
  }

} // end aggregate