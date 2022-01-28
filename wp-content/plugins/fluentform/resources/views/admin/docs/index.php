<?php do_action('fluentform_global_menu'); ?>
<div class="ff_form_wrap">
    <div class="ff_form_wrap_area">
        <h2><?php _e('Help & Documentation', 'fluentform'); ?></h2>
        <div class="ff_documentaion_wrapper">
            <?php do_action('fluentform_before_documentation_wrapper'); ?>

            <div class="ff_doc_top_blocks">
                <div class="ff_block block_1_3">
                    <div class="ff_block_box text-center">
                        <img src="<?php echo $icon_path_url; ?>img/support.png"/>
                        <h3>Need Expert Support?</h3>
                        <p>Our EXPERTS would like to assist you for your query and any customization.</p>
                        <p><a target="_blank" class="button button-primary"
                              href="https://wpmanageninja.com/support-tickets/">Contact
                                Support</a></p>
                    </div>
                </div>
                <div class="ff_block block_1_3">
                    <div class="ff_block_box text-center">
                        <img src="<?php echo $icon_path_url; ?>img/fb_group.png"/>
                        <h3>Join our facebook community</h3>
                        <p>We have a strong community where we discuss ideas and help each other.</p>
                        <p><a target="_blank" class="button button-primary"
                              href="https://www.facebook.com/groups/fluentforms/">
                                Join Facebook Group</a></p>
                    </div>
                </div>
                <div class="ff_block block_1_3">
                    <div class="ff_block_box text-center">
                        <img src="<?php echo $icon_path_url; ?>img/bug.png"/>
                        <h3>Found a Bug?</h3>
                        <p>Please report us and we promise we will fix that as soon as humanly possible</p>
                        <p><a target="_blank" class="button button-primary"
                              href="https://github.com/fluentform/fluentform/issues">Report Bug on Github</a></p>
                    </div>
                </div>
            </div>
            <div class="ff_doc_top_blocks">
                <div class="ff_block block_2_3">
                    <div class="ff_block_box text-center">
                        <h2>Fluent Forms Video Tutorials</h2>
                        <div class="videoWrapper">
                            <iframe width="1280" height="720" src="https://www.youtube.com/embed/M_r-4Ernjj0?list=PLXpD0vT4thWG7KlcCpGWDSs0t6Wvs7xIJ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>

                <div class="ff_block block_1_3">
                    <div class="ff_block_box text-center">
                        <img src="<?php echo $icon_path_url; ?>img/love.png"/>
                        <h3>Love this Plugin?</h3>
                        <p>Please write a review in wp.org plugin repository. We appreciate it!</p>
                        <p><a target="_blank" class="button button-primary"
                              href="https://wordpress.org/support/plugin/fluentform/reviews/#new-post">Write Review</a>
                        </p>
                    </div>
                    <div style="margin-top: 20px;" class="ff_block_box">
                        <h3>User Guides</h3>
                        <p>Please check the following <b>Tutorials and Documentations</b> for getting started with
                            Fluent Form</p>
                        <ul>
                            <?php foreach ($user_guides as $user_guide): ?>
                                <li><a target="_blank"
                                       href="<?php echo $user_guide['link']; ?>"><?php echo $user_guide['title']; ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <?php do_action('fluentform_after_documentation_wrapper') ?>

        </div>
    </div>
</div>
		