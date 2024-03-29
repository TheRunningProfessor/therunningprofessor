<?php

$loggedin_account_label_visibility = blocksy_akg(
	'loggedin_account_label_visibility',
	$atts,
	[
		'desktop' => true,
		'tablet' => true,
		'mobile' => true,
	]
);

// Logged in
$link = get_edit_profile_url();
$account_link = blocksy_akg('account_link', $atts, 'profile');

if ($account_link === 'dashboard') {
	$link = admin_url();
}

if ($account_link === 'logout') {
	$link = wp_logout_url(blocksy_current_url());
}

if ($account_link === 'custom') {
	$link = blocksy_akg('account_custom_page', $atts, '');
}

if ($account_link === 'woocommerce_account' && class_exists('WooCommerce')) {
	$link = get_permalink(get_option('woocommerce_myaccount_page_id'));
}

// Media
$media_html = '';
$loggedin_media = blocksy_akg('loggedin_media', $atts, 'avatar');

if ($loggedin_media === 'avatar') {
	$avatar_size = intval(
		blocksy_expand_responsive_value(
			blocksy_akg('accountHeaderAvatarSize', $atts, 18)
		)['desktop']
	);

	$media_html = blocksy_simple_image(
		get_avatar_url(
			$current_user_id,
			[
				'size' => $avatar_size * 2
			]
		),
		[
			'img_atts' => [
				'width' => $avatar_size,
				'height' => $avatar_size
			]
		]
	);
}

if ($loggedin_media === 'icon') {
	$media_html = $icon[
		blocksy_akg('account_loggedin_icon', $atts, 'type-1')
	];
}

// Label
$loggedin_label = blocksy_akg('loggedin_label', $atts, __('My Account', 'blc'));

if (blocksy_akg('loggedin_text', $atts, 'label') === 'username') {
	$user = wp_get_current_user();
	$loggedin_label = $user->display_name;
}

$loggedin_label_position = blocksy_expand_responsive_value(
	blocksy_akg('loggedin_label_position', $atts, 'right')
);

$attr['data-state'] = 'in';

if (! empty($media_html)) {
	$attr['data-label'] = $loggedin_label_position[$device];
}

$attr['href'] = apply_filters('wpml_permalink', $link);
$attr['aria-label'] = $loggedin_label;

echo '<a ' . blocksy_attr_to_html($attr) . '>';

if (! empty($loggedin_label) && blocksy_some_device(
	$loggedin_account_label_visibility
)) {
	echo '<span class="' . trim('ct-label ' . blocksy_visibility_classes(
		$loggedin_account_label_visibility
	)) . '">';
	echo $loggedin_label;
	echo '</span>';
}

echo $media_html;

echo '</a>';
