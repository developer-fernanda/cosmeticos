<?php do_action('fluentform_global_menu'); ?>
<div class="ff_addon_wrapper ff_block">
    <div class="ff_addon_header">
        <img style="width: 100px; height: 100px;" src="<?php echo $logo; ?>"/>
        <h1>Making Email Deliverability Easy and Fast for Your WordPress</h1>
        <p>
            <a target="_blank" href="https://wordpress.org/plugins/fluent-smtp/" rel="nofollow">FluentSMTP</a> is the ultimate WP Mail Plugin that connects with your Email Service Provider natively and makes
            sure your emails are delivered 💯.
            Our goal is to send your WordPress emails delivery fast, secure, and make sure your WordPress emails reach
            the email inbox.
            Made by Fluent Forms team for you.
        </p>
        <?php if (!$is_installed): ?>
            <div class="ff_addon_btn_wrapper">
                <button class="ff_addon_btn intstall_fluentsmtp">Install and Activate FluentSMTP Plugin</button>
                <p style="display: none;" class="ff_addon_installing">Installing FluentSMTP Plugin. Please wait...</p>
            </div>
        <?php else: ?>
        <h3>FluentSMTP plugin has been activated and running</h3>
        <br />
        <a href="<?php echo $setup_url; ?>" class="ff_addon_btn">View FluentSMTP Settings</a>
        <?php endif; ?>

    </div>
    <?php if (!$is_installed): ?>
        <div class="ff_addon_body">
            <img class="ff_addon_banner" src="<?php echo $banner_image; ?>"/>
        </div>
        <div class="ff_addon_feature_card ff_block_box">
            <div class="ff_addon_header_ff">FluentSMTP - The ultimate SMTP & Email Service Connection Plugin for
                WordPress
            </div>
            <div class="ff_addon_body">
                <p>
                    For FluentCRM users, we built a well-optimized SMTP/Amazon SES plugin. It will help you manage all
                    your
                    WordPress website emails, including FluentCRM emails. <a target="_blank" rel="noopener"
                                                                             href="https://fluentsmtp.com/">Learn more
                        about
                        FluentSMTP Plugin</a>.
                </p>
                <div class="ff_addon_features">
                    <div class="ff_block_half">
                        <h3>Dedicated API and SMTP connections</h3>
                        <ul>
                            <li>Amazon SES</li>
                            <li>Mailgun</li>
                            <li>SendGrid</li>
                            <li>SendInBlue</li>
                            <li>PepiPost</li>
                            <li>SparkPost</li>
                            <li>+ Any SMTP Provider</li>
                        </ul>
                    </div>
                    <div class="ff_block_half">
                        <h3>Features of Fluent SMTP Plugin</h3>
                        <ul>
                            <li>Optimized API connection with Mail Service Providers</li>
                            <li>Email Logging for better visibility</li>
                            <li>Email Routing based on the sender email address</li>
                            <li>Real-Time Email Delivery</li>
                            <li>Resend Any Emails</li>
                            <li>In Details Reporting</li>
                            <li>Super fast UI powered by VueJS</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="ff_addon_footer text-center">
                <button class="ff_addon_btn ff_invert intstall_fluentsmtp">Install and Activate FluentSMTP Plugin</button>
                <p style="display: none;" class="ff_addon_installing">Installing FluentSMTP Plugin. Please wait...</p>
            </div>
        </div>
    <?php endif; ?>
</div>
