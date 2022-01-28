<?php

/**
 * HTML email instructions.
 *
 * @package Pix_For_WooCommerce
 * @version 1.3.4
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

$upload = wp_upload_dir();
$uploadPath = $upload['basedir'] . '/pix-para-woocommerce/';
$uploadUrl = $upload['baseurl'] . '/pix-para-woocommerce/';
$uploaded = false;

if (!file_exists($uploadPath)) {
	wp_mkdir_p($uploadPath);
}

if (isset($image) && !empty($image)) {
	$data = substr($image, strpos($image, ',') + 1);
	$data = str_replace(' ', '+', $data);
	$decodedData = base64_decode($data);
	$imageName = uniqid() . '.png';
	$file = $uploadPath . $imageName;
	$uploaded = file_put_contents($file, $decodedData);
}
?>
<p>
	Caso tenha perdido o link para pagamento, ou fechado antes da conclusão, você pode encontrá-lo na sua conta,
	<a href="<?php echo esc_url(get_permalink(get_option('woocommerce_myaccount_page_id'))); ?>" title="Minha conta">clicando aqui</a>.
	<?php echo wptexturize($instructions); ?>
</p>

<div style="margin: 36px auto;">
	<?php if ($uploaded) : ?>
		<h3 style="font-size: 18px;">Pague com o QR Code abaixo</h3>
		<img style="display: table; background-color: #FFF" src="<?php echo esc_url($uploadUrl . $imageName); ?>" alt="QR Code" />
		<br>
	<?php endif; ?>
	<h3 style="font-size: 18px;">Pague copiando e colando o código Pix abaixo</h3>
	<p class="wcpix-p" style="font-size: 14px;margin-bottom:0"><?php echo wp_kses_post($link); ?></p>
</div>