<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 *  définition d'un ensemble de fonctions d'aide pour raccourcir l'insertion de divers éléments
 *  grace à ces fonctions il suffit de donner le nom de l'élément à inserer et la fonction renvoit 
 *  l'adresse complète de l'element
 *
 */

/*
 *  @param nom d'un fichier css
 *  @return adresse complete du css
 */
if ( ! function_exists('css_url'))
{
	function css_url($nom)
	{
		return base_url() . 'assets/css/' . $nom . '.css';
	}
}

/*
 *  @param nom d'un fichier javascript
 *  @return adresse complete du javascript
 */
if ( ! function_exists('js_url'))
{
	function js_url($nom)
	{
		return base_url() . 'assets/javascript/' . $nom . '.js'; 
	}
}

/*
 *  @param nom d'une image
 *  @return adresse complete de l'image
 */
if ( ! function_exists('img_url'))
{
	function img_url($nom)
	{
		return base_url() . 'assets/img/' . $nom;
	}
}

/*
 *  @param nom d'une image
 *  @return balise HTML permettant d'inserer l'image
 */
if ( ! function_exists('img'))
{
	function img($nom, $alt = '')
	{
		return '<img src="' . img_url($nom) . '" alt="' . $alt . '" />';
	}
}

/*
 *  @return fichier css de base
 */
if ( ! function_exists('bootcss_url'))
{
	function bootcss_url()
	{
		return base_url() . 'assets/css/bootstrap.min.css';
	}
}

/*
 *  @return fichier js de base
 */
if ( ! function_exists('bootjs_url'))
{
	function bootjs_url()
	{
		return base_url() . 'assets/js/bootstrap.min.js';
	}
}

/*
 *  @return fichier php de la bibliothèque mpdf
 */
if ( ! function_exists('mpdf_url'))
{
	function mpdf_url() {
		return base_url . 'application/libraries/mpdf/mpdf.php';
	}
}

