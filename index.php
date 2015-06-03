<?php
require 'vendor/autoload.php';

use Symfony\Bridge\Twig\Extension\FormExtension;
use Symfony\Bridge\Twig\Extension\TranslationExtension;
use Symfony\Bridge\Twig\Form\TwigRenderer;
use Symfony\Bridge\Twig\Form\TwigRendererEngine;
use Symfony\Component\Form\Forms;
use Symfony\Component\Translation\Translator;
//use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;

// config
define('DEFAULT_FORM_THEME', 'form_div_layout.html.twig');
define('VENDOR_DIR', realpath(__DIR__ . '/vendor'));
define('VIEWS_DIR', realpath(__DIR__ . '/'));
define('VENDOR_FORM_DIR', VENDOR_DIR . '/symfony/form/Symfony/Component/Form');
define('VENDOR_TWIG_BRIDGE_DIR', VENDOR_DIR . '/symfony/twig-bridge/Resources/views/Form');

$formFactory = Forms::createFormFactoryBuilder()
    //->addExtension(new HttpFoundationExtension())
    ->getFormFactory();

$form = $formFactory->createBuilder('form')
    ->add('title', 'text', array())
    ->add('name', 'text', array())
    ->getForm();

$twig = new Twig_Environment(new Twig_Loader_Filesystem(array(
    VIEWS_DIR,
    VENDOR_TWIG_BRIDGE_DIR,
)));
$formEngine = new TwigRendererEngine(array(DEFAULT_FORM_THEME));
$formEngine->setEnvironment($twig);
$twig->addExtension(new TranslationExtension(new Translator('en')));
$twig->addExtension(new FormExtension(new TwigRenderer($formEngine)));

echo $twig->render('index.html.twig', array(
    'form' => $form->createView(),
));

if (isset($_POST)) {
    print_r($_POST);
}
