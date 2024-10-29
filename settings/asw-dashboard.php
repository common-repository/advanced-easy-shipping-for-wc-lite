<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div id="tab-dashboard" class="aes-section aes-tab aes-tab--dashboard aes-tab--active">
	<div class="postbox">
		<h2>
			<?php
			_e( 'License &amp; Account Settings', 'advanced-easy-shipping-for-woocommerce' )
			?>
		</h2>
		<table class="form-table" role="presentation">
			<tbody>
			<tr>
				<th scope="row">
					<?php
					echo sprintf(
						'%s <span class="aes-subtitle">%s</span>',
						__( 'License &amp; Billing', 'advanced-easy-shipping-for-woocommerce' ),
						__( 'Activate or sync your license, cancel your subscription, print invoices, and manage your account information.', 'advanced-easy-shipping-for-woocommerce' )
					);
					?>
				</th>
				<td>
					<?php
					$fs            = freemius( 8790 );
					$has_paid_plan = $fs->apply_filters( 'has_paid_plan_account', $fs->has_paid_plan() );
					$license       = $fs->_get_license();
					$is_premium    = $fs->is_premium();
					if ( $license && $has_paid_plan ) {
						?>
						<a href="<?php echo $this->idm_dynamic_url( 'asw-main-account', '', '', '', '', '' ); ?>" class="button button-secondary" target="_blank">
							<?php
							_e( 'Manage Licence & Billing', 'advanced-easy-shipping-for-woocommerce' )
							?>
						</a>
						<?php
					} else {
						?>
						<a href="https://checkout.freemius.com/mode/dialog/plugin/8790/plan/14731/" class="button idomit-buy-now idomit-button idomit-button--small" data-plugin-id="8790" data-plan-id="14731" data-public-key="pk_2a55465e285686f167dda32ce0750" data-type="premium">
							<?php
							_e( 'Buy Premium', 'advanced-easy-shipping-for-woocommerce' )
							?>
						</a>
						<?php
					}
					?>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e( 'Your Account ', 'advanced-easy-shipping-for-woocommerce' ); ?>
					<span class="aes-subtitle">
						<?php _e( 'Manage all of your idomit plugins, supscriptions, renewals, and more.', 'advanced-easy-shipping-for-woocommerce' ); ?></span>
				</th>
				<td>
					<a href="https://store.idomit.com/account/?utm_source=idomit&amp;utm_medium=Plugin&amp;utm_campaign=idomit-advanceshipping&amp;utm_content=account-link" class="button button-secondary" target="_blank"><?php _e( 'Manage Your Account', 'advanced-easy-shipping-for-woocommerce' ); ?></a>
				</td>
			</tr>
			</tbody>
		</table>
		<h2>
			<?php
			_e( 'Support', 'advanced-easy-shipping-for-woocommerce' )
			?>
		</h2>
		<table class="form-table" role="presentation">
			<tbody>
			<tr>
				<th scope="row">
					<?php
					echo sprintf(
						'%s <span class="aes-subtitle">%s</span>',
						__( 'Support', 'advanced-easy-shipping-for-woocommerce' ),
						__( 'Get Prompt support.', 'advanced-easy-shipping-for-woocommerce' )
					);
					?>
				</th>
				<td>
					<a href="https://store.idomit.com/support/" class="button button-secondary" target="_blank">
						<?php
						_e( 'Submit Ticket', 'advanced-easy-shipping-for-woocommerce' )
						?>
					</a>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<?php
					echo sprintf(
						'%s <span class="aes-subtitle">%s</span>',
						__( 'Documentation', 'advanced-easy-shipping-for-woocommerce' ),
						__( 'Read the plugin documentation.', 'advanced-easy-shipping-for-woocommerce' )
					);
					?>
				</th>
				<td>
					<a href="https://store.idomit.com/product/advanced-easy-shipping-for-woocommerce/" class="button button-secondary" target="_blank">
						<?php
						_e( 'Read Documentation', 'advanced-easy-shipping-for-woocommerce' )
						?>
					</a>
				</td>
			</tr>
			<tr>
				<th scope="row">
					<?php _e( 'Review', 'advanced-easy-shipping-for-woocommerce' ); ?>
					<span class="aes-subtitle"><?php _e( 'It would mean a lot to us if you would quickly give our plugin a 5-star rating. Your Review is very important to us as it helps us to grow more!', 'advanced-easy-shipping-for-woocommerce' ); ?></span>
				</th>
				<td>
					<ul>
						<a href="https://wordpress.org/support/plugin/advanced-easy-shipping-for-wc-lite/?rate=5#new-post" target="__blank" class="button"><?php _e( 'Yes you deserve it!', 'advanced-easy-shipping-for-woocommerce' ); ?></span></a>
					</ul>
				</td>
			</tr>
			</tbody>
		</table>
	</div>
</div>