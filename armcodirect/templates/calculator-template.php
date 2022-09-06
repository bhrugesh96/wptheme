<?php
/**
 * Template Name: Calculator Template
 *
 * @package Armcodirect
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$bg_pattern  = get_field( 'background_pattern' );
$subtitle    = get_field( 'subtitle' );
$page_title  = get_field( 'title' );
$description = get_field( 'description' );

if ( ! empty( $subtitle ) || ! empty( $page_title ) || ! empty( $description ) ) {
	?>
	<section class="header-strip-block calculate-header <?php echo esc_attr( $bg_pattern ); ?>">
		<div class="container">
			<div class="row">
				<div class="col-xxl-6 col-lg-7 col-12">
					<?php
					if ( ! empty( $subtitle ) ) {
						?>
						<span class="subtitle text-blue text-uppercase">
							<?php
								echo esc_html( $subtitle );
							?>
						</span>
						<?php
					}
					if ( ! empty( $page_title ) ) {
						?>
						<h2 class="title h-1"><?php echo esc_html( $page_title ); ?></h2>
						<?php
					}
					if ( ! empty( $description ) ) {
						?>
						<div class="description"><?php echo sprintf( '%s', $description );//phpcs:ignore ?></div>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</section>
	<?php
}
?>
<section class="calculator-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-lg-7 col-12 px-xxl-0 px-sm-5"><!-- Calculator STEP 1 -->
				<div class="calculator-step-1">
					<?php
					if ( get_field( 'calculator_1_title' ) ) {
						?>
						<h3 class="calculate-1-title"><?php the_field( 'calculator_1_title' ); ?></h3>
						<?php
					}
					the_field( 'calculator_1_desc' );

					if ( have_rows( 'calculator_1_form' ) ) :
						?>
						<form class="product-calculator calculator-wrap">
							<?php
							while ( have_rows( 'calculator_1_form' ) ) :
								the_row();
								?>
								<div class="field-wrapper field-<?php the_sub_field( 'calculator_section_id' ); ?>">
									<label for="<?php the_sub_field( 'calculator_section_id' ); ?>">
										<h5 class="label-title text-blue"><?php the_sub_field( 'calculator_input_title' ); ?></h5>
										<p class="label-desc"><?php the_sub_field( 'calculator_input_desc' ); ?></p>
										<?php
										$tooltip_show = get_sub_field( 'calculator_tooltip_show' );
										$tooltip_text = get_sub_field( 'calculator_tooltip_text' );
										if ( 'show' === $tooltip_show && $tooltip_text ) :
											?>
											<div class="calculator-tooltip">
												<div class="tooltip-icon"></div>
												<div class="tooltip-text">
													<div class="text-wrapper">
														<?php echo sprintf( '%s', $tooltip_text );// phpcs:ignore ?>
													</div>
												</div>
											</div>
											<?php
										endif;
										?>
									</label>
									<?php
									if ( 'number' === get_sub_field( 'calculator_input_type' ) ) :

										$default_value = ( 'runs' === get_sub_field( 'calculator_section_id' ) ) ? 1 : '';
										?>
										<div class="calculator-input-wrap">
											<span class="input-wrapper <?php the_sub_field( 'calculator_section_id' ); ?>">
												<input <?php if ( get_sub_field( 'calculator_input_type' ) === 'number' ) : ?>pattern="[0-9]*" <?php endif;//phpcs:ignore ?> type="<?php the_sub_field( 'calculator_input_type' ); ?>" value="<?php echo $default_value; ?>" placeholder="<?php echo esc_html__( 'Enter amount...', 'armcodirect' ); ?>" name="<?php the_sub_field( 'calculator_section_id' ); ?>" id="<?php the_sub_field( 'calculator_section_id' ); ?>"/>
											</span>
											<?php
											if ( have_rows( 'calculator_section_icons' ) ) :
												?>
												<div class="img-wrapper">
													<?php
													while ( have_rows( 'calculator_section_icons' ) ) :
														the_row();
														$icon = get_sub_field( 'calculator_section_icons_image' );
														if ( ! empty( $icon ) ) {
															?>
															<img src="<?php echo esc_url( $icon['url'] ); ?>" width="1" height="1" alt="<?php echo esc_attr( $icon['alt'] ); ?>"<?php if ( get_sub_field( 'calculator_section_icons_id' ) ) : ?> <?php endif; ?> class="no-resize <?php the_sub_field( 'calculator_section_icons_id' );// phpcs:ignore ?> <?php the_sub_field( 'calculator_section_icons_default' ); ?>"/>
															<?php
														}
													endwhile;
													?>
												</div>
												<?php
											endif;
											?>
										</div>
										<?php
									elseif ( 'dropdown' === get_sub_field( 'calculator_input_type' ) ) :
										$field_id = get_sub_field( 'calculator_section_id' );
										if ( have_rows( 'calculator_dropdown_options' ) ) :
											?>
											<div class="calculator-input-wrap">
												<div class="select-wrapper">
													<select name="<?php echo esc_attr( $field_id ); ?>" id="<?php echo esc_attr( $field_id ); ?>">
														<?php
														while ( have_rows( 'calculator_dropdown_options' ) ) :
															the_row();
															?>
															<option value="<?php the_sub_field( 'calculator_dropdown_id' ); ?>"><?php the_sub_field( 'calculator_dropdown_text' ); ?></option>
															<?php
														endwhile;
														?>
													</select>
												</div>
												<?php
												if ( have_rows( 'calculator_section_icons' ) ) :
													?>
													<div class="img-wrapper">
														<?php
														while ( have_rows( 'calculator_section_icons' ) ) :
															the_row();
															$icon = get_sub_field( 'calculator_section_icons_image' );
															if ( ! empty( $icon ) ) {
																?>
																<img src="<?php echo esc_url( $icon['url'] ); ?>" width="1" height="1" alt="<?php echo esc_attr( $icon['alt'] ); ?>"<?php if ( get_sub_field( 'calculator_section_icons_id' ) ) : ?> <?php endif; ?> class="no-resize <?php the_sub_field( 'calculator_section_icons_id' );// phpcs:ignore ?> <?php the_sub_field( 'calculator_section_icons_default' ); ?>"/>
																<?php
															}
														endwhile;
														?>
													</div>
													<?php
												endif;
												?>
											</div>
											<?php
										endif;
									elseif ( 'tab' === get_sub_field( 'calculator_input_type' ) ) :
										$field_id = get_sub_field( 'calculator_section_id' );
										if ( have_rows( 'calculator_tab_options' ) ) :
											?>
											<div class="calculator-options d-flex">
												<?php
												$i = 1;
												while ( have_rows( 'calculator_tab_options' ) ) :
													the_row();
													$checked = ( 1 === $i ) ? ' checked' : '';
													?>
													<span class="position-relative me-lg-4 me-sm-2 me-0">
														<input type="radio" class="tab-radio-input" name="<?php echo $field_id; ?>" value="<?php the_sub_field( 'calculator_tab_text' ); ?>" data-id="<?php the_sub_field( 'calculator_tab_id' ); ?>"<?php echo $checked;//phpcs:ignore ?>>
														<span class="option"><?php the_sub_field( 'calculator_tab_text' ); ?></span>
														<?php
														if ( 'yes' === get_sub_field( 'popup' ) && get_sub_field( 'popup_text' ) ) {
															?>
															<button type="button" class="popup-text" data-bs-toggle="modal" data-bs-target="#exampleModal">What is this?</button>
															<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
																<div class="modal-dialog modal-dialog-centered">
																	<div class="modal-content">
																		<div class="modal-body">
																			<?php the_sub_field( 'popup_text' ); ?>
																		</div>
																		<div class="modal-footer">
																			<button type="button" class="close-btn" data-bs-dismiss="modal">Close</button>
																		</div>
																	</div>
																</div>
															</div>
															<?php
														}
														?>
													</span>
													<?php
													$i++;
												endwhile;
												?>
											</div>
											<div class="calculator-input-wrap">
												<div class="calculator-tabs-input-wrap">
													<?php
													$k = 1;
													while ( have_rows( 'calculator_tab_options' ) ) :
														the_row();
														$active_class = ( 1 === $k ) ? ' default' : ' invisible';
														if ( get_sub_field( 'calculator_input_id' ) ) {
															?>
															<div class="tabs-input <?php the_sub_field( 'calculator_tab_id' ); ?><?php echo esc_attr( $active_class ); ?>">
																<?php
																if ( get_sub_field( 'calculator_input_description' ) ) {
																	?>
																	<p class="label-desc"><?php the_sub_field( 'calculator_input_description' ); ?></p>
																	<?php
																}
																?>
																<span class="input-wrapper <?php echo esc_attr( $field_id ); ?>">
																	<input type="number" pattern="[0-9]*" value="" placeholder="<?php echo esc_html__( 'Enter amount...', 'armcodirect' ); ?>" name="<?php the_sub_field( 'calculator_input_id' ); ?>" id="<?php the_sub_field( 'calculator_input_id' ); ?>"/>
																</span>
															</div>
															<?php
														}
														$k++;
													endwhile;
													?>
												</div>
												<?php
												if ( have_rows( 'calculator_section_icons' ) ) :
													?>
													<div class="img-wrapper">
														<?php
														while ( have_rows( 'calculator_section_icons' ) ) :
															the_row();
															$icon = get_sub_field( 'calculator_section_icons_image' );
															if ( ! empty( $icon ) ) {
																?>
																<img src="<?php echo esc_url( $icon['url'] ); ?>" width="1" height="1" alt="<?php echo esc_attr( $icon['alt'] ); ?>"<?php if ( get_sub_field( 'calculator_section_icons_id' ) ) : ?> <?php endif; ?> class="no-resize <?php the_sub_field( 'calculator_section_icons_id' );// phpcs:ignore ?> <?php the_sub_field( 'calculator_section_icons_default' ); ?>"/>
																<?php
															}
														endwhile;
														?>
													</div>
													<?php
												endif;
												?>
											</div>
											<?php
										endif;
									elseif ( 'tab-dropdown' === get_sub_field( 'calculator_input_type' ) ) :
										$field_id = get_sub_field( 'calculator_section_id' );
										?>
										<div class="calculator-input-wrap">
											<?php
											if ( have_rows( 'calculator_dropdown_options' ) ) :
												?>
												<div class="select-wrapper">
													<select name="<?php echo esc_attr( $field_id ); ?>" id="<?php echo esc_attr( $field_id ); ?>">
														<?php
														while ( have_rows( 'calculator_dropdown_options' ) ) :
															the_row();
															?>
															<option value="<?php the_sub_field( 'calculator_dropdown_id' ); ?>"><?php the_sub_field( 'calculator_dropdown_text' ); ?></option>
															<?php
														endwhile;
														?>
													</select>
												</div>
												<?php
											endif;
											if ( have_rows( 'calculator_section_icons' ) ) :
												?>
												<div class="img-wrapper">
													<?php
													while ( have_rows( 'calculator_section_icons' ) ) :
														the_row();
														$icon = get_sub_field( 'calculator_section_icons_image' );
														if ( ! empty( $icon ) ) {
															?>
															<img src="<?php echo esc_url( $icon['url'] ); ?>" width="1" height="1" alt="<?php echo esc_attr( $icon['alt'] ); ?>"<?php if ( get_sub_field( 'calculator_section_icons_id' ) ) : ?> <?php endif; ?> class="no-resize <?php the_sub_field( 'calculator_section_icons_id' );// phpcs:ignore ?> <?php the_sub_field( 'calculator_section_icons_default' ); ?>"/>
															<?php
														}
													endwhile;
													?>
												</div>
												<?php
											endif;
											?>
										</div>
										<?php
										if ( have_rows( 'calculator_tab_options' ) ) :
											?>
											<div class="calculator-options d-flex">
												<?php
												$i = 1;
												while ( have_rows( 'calculator_tab_options' ) ) :
													the_row();
													$checked = ( 1 === $i ) ? ' checked' : '';
													?>
													<span class="position-relative me-lg-4 me-sm-2 me-0">
														<input type="radio" class="tab-radio-input" name="<?php echo $field_id; ?>" value="<?php the_sub_field( 'calculator_tab_text' ); ?>" id="<?php the_sub_field( 'calculator_tab_id' ); ?>"<?php echo $checked; ?>>
														<span class="option"><?php the_sub_field( 'calculator_tab_text' ); ?></span>
														<?php
														if ( 'yes' === get_sub_field( 'popup' ) &&  get_sub_field( 'popup_text' ) ) {
															?>
															<button type="button" class="popup-text" data-bs-toggle="modal" data-bs-target="#exampleModal">What is this?</button>
															<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
																<div class="modal-dialog modal-dialog-centered">
																	<div class="modal-content">
																		<div class="modal-body">
																			<?php the_sub_field( 'popup_text' ); ?>
																		</div>
																		<div class="modal-footer">
																			<button type="button" class="close-btn" data-bs-dismiss="modal">Close</button>
																		</div>
																	</div>
																</div>
															</div>
															<?php
														}
														?>
													</span>
													<?php
													$i++;
												endwhile;
												?>
											</div>
											<?php
										endif;
									elseif ( 'tab-dropdown-input' === get_sub_field( 'calculator_input_type' ) ) :
										$field_id = get_sub_field( 'calculator_section_id' );
										?>
										<div class="calculator-input-wrap">
											<?php
											if ( have_rows( 'calculator_dropdown_options2' ) ) :
												?>
												<div class="select-wrapper">
													<select name="<?php echo esc_attr( $field_id ); ?>" id="<?php echo esc_attr( $field_id ); ?>">
														<?php
														while ( have_rows( 'calculator_dropdown_options2' ) ) :
															the_row();
															?>
															<option value="<?php the_sub_field( 'calculator_dropdown_id' ); ?>"><?php the_sub_field( 'calculator_dropdown_text' ); ?></option>
															<?php
														endwhile;
														?>
													</select>
												</div>
												<?php
											endif;
											?>
										</div>
										<?php
										if ( have_rows( 'calculator_dropdown_options2' ) ) :
											?>
											<div class="calculator-options d-flex">
												<?php
												while ( have_rows( 'calculator_dropdown_options2' ) ) :
													the_row();
													$calculator_dropdown_id = get_sub_field( 'calculator_dropdown_id' );
													if ( have_rows( 'calculator_tab_options2' ) ) :
														while ( have_rows( 'calculator_tab_options2' ) ) :
															the_row();
															?>
															<span class="position-relative me-lg-4 me-sm-2 me-0">
																<input type="radio" class="tab-radio-input" name="<?php echo $field_id; ?>" value="<?php the_sub_field( 'calculator_tab_text' ); ?>" id="<?php the_sub_field( 'calculator_tab_id' ); ?>-<?php echo $calculator_dropdown_id; ?>-input" data-id="<?php the_sub_field( 'calculator_tab_id' ); ?>-<?php echo $calculator_dropdown_id; ?>-input">
																<span class="option"><?php the_sub_field( 'calculator_tab_text' ); ?></span>
															</span>
															<?php
														endwhile;
													endif;
												endwhile;
												?>
											</div>
											<div class="calculator-input-wrap dropdown-input">
												<div class="calculator-tabs-input-wrap">
													<?php
													while ( have_rows( 'calculator_dropdown_options2' ) ) :
														the_row();
														$calculator_dropdown_id = get_sub_field( 'calculator_dropdown_id' );
														if ( have_rows( 'calculator_tab_options2' ) ) :
															while ( have_rows( 'calculator_tab_options2' ) ) :
																the_row();
																if ( get_sub_field( 'calculator_input_id' ) ) {
																	?>
																	<div class="tabs-input <?php the_sub_field( 'calculator_tab_id' ); ?>-<?php echo $calculator_dropdown_id; ?>-input invisible">
																		<?php
																		if ( get_sub_field( 'calculator_input_description' ) ) {
																			?>
																			<p class="label-desc"><?php the_sub_field( 'calculator_input_description' ); ?></p>
																			<?php
																		}
																		?>
																		<span class="input-wrapper">
																			<input type="number" pattern="[0-9]*" value="" placeholder="<?php echo esc_html__( 'Enter amount...', 'armcodirect' ); ?>" name="<?php echo $calculator_dropdown_id; ?>-<?php the_sub_field( 'calculator_input_id' ); ?>">
																		</span>
																	</div>
																	<?php
																}
															endwhile;
														endif;
													endwhile;
													?>
												</div>
												<?php
												if ( have_rows( 'calculator_section_icons' ) ) :
													?>
													<div class="img-wrapper">
														<?php
														while ( have_rows( 'calculator_section_icons' ) ) :
															the_row();
															$icon = get_sub_field( 'calculator_section_icons_image' );
															if ( ! empty( $icon ) ) {
																?>
																<img src="<?php echo esc_url( $icon['url'] ); ?>" width="1" height="1" alt="<?php echo esc_attr( $icon['alt'] ); ?>"<?php if ( get_sub_field( 'calculator_section_icons_id' ) ) : ?> <?php endif; ?> class="image-js no-resize <?php the_sub_field( 'calculator_section_icons_id' );// phpcs:ignore ?> <?php the_sub_field( 'calculator_section_icons_default' ); ?>"/>
																<?php
															}
														endwhile;
														?>
													</div>
													<?php
												endif;
												?>
											</div>
											<?php
										endif;
									endif;
									?>
								</div>
								<?php
							endwhile;
							?>
							<div class="field-wrapper field-fixings">
								<label for="fixings">
									<div class="calculator-label">
										<h5 class="label-title text-blue">
											<?php echo esc_html__( 'Post Type', 'armcodirect' ); ?>
											<span class="required">*</span>
										</h5>
										<p class="label-desc"><?php echo esc_html__( 'Do you require handrails?', 'armcodirect' ); ?></p>
										<div class="calculator-options d-flex">
											<span class="position-relative me-lg-4 me-sm-2 me-0">
												<input type="radio" name="handrails-type" value="no" id="handrails-no-radio" checked>
												<span class="option"><?php echo esc_html__( 'No', 'armcodirect' ); ?></span>
											</span>
											<span class="position-relative">
												<input type="radio" name="handrails-type" value="yes" id="handrails-yes-radio">
												<span class="option"><?php echo esc_html__( 'Yes', 'armcodirect' ); ?></span>
											</span>
										</div>
										<p class="label-desc"><?php echo esc_html__( 'Select either bolt down or dig in posts.', 'armcodirect' ); ?></p>
									</div>
									<div class="calculator-options d-flex">
										<span class="position-relative me-lg-4 me-sm-2 me-0">
											<input type="radio" name="fixing-type" value="boltdown" id="boltdown-radio" checked>
											<span class="option"><?php echo esc_html__( 'Bolt Down', 'armcodirect' ); ?></span>
										</span>
										<span class="position-relative">
											<input type="radio" name="fixing-type" value="digin" id="digin-radio">
											<span class="option"><?php echo esc_html__( 'Dig In', 'armcodirect' ); ?></span>
										</span>
									</div>
									<div class="calculator-tooltip">
										<div class="tooltip-icon"></div>
										<div class="tooltip-text">
											<div class="text-wrapper">
												<p><?php echo esc_html__( 'Z posts are designed to collapse on impact making them ideal for fast moving vehicles. RSJ posts are designed to protect against larger and slower moving vehicles as they take the brunt of the impact instead of collapsing.' ); ?></p>
											</div>
										</div>
									</div>
								</label>
								<p>Select your size</p>
								<div class="calculator-input-wrap">
									<div class="select-wrapper fixings-bolt">
										<select name="fixings" id="fixings-bolt">
											<option value="Bolt Down (760mm)"><?php echo esc_html__( 'Bolt Down (760mm)', 'armcodirect' ); ?></option>
											<option value="Bolt Down (560mm)"><?php echo esc_html__( 'Bolt Down (560mm - Not Suitable For Double Beam)', 'armcodirect' ); ?></option>
											<option value="Bolt Down (610mm)"><?php echo esc_html__( 'Bolt Down (610mm)', 'armcodirect' ); ?></option>
											<option value="Bolt Down (1100mm)"><?php echo esc_html__( 'Bolt Down (1100mm)', 'armcodirect' ); ?></option>
											<option value="Bolt Down (760mm + Handrail Ext.)"><?php echo esc_html__( 'Bolt Down (760mm + Handrail Ext.)', 'armcodirect' ); ?></option>
										</select>
									</div>
									<div class="select-wrapper fixings-dig" style="display: none;">
										<select name="fixings" id="fixings-dig">
											<option value="Dig In (1200mm)"><?php echo esc_html__( 'Dig In (1200mm - Not Suitable For Double Beam)', 'armcodirect' ); ?></option>
											<option value="Dig In (1500mm)"><?php echo esc_html__( 'Dig In (1500mm)', 'armcodirect' ); ?></option>
											<option value="Dig In (1800mm)"><?php echo esc_html__( 'Dig In (1800mm)', 'armcodirect' ); ?></option>
											<option value="Dig In (1500mm + Handrail Ext.)"><?php echo esc_html__( 'Dig In (1500mm + Handrail Ext.)', 'armcodirect' ); ?></option>
										</select>
									</div>
								</div>
							</div>
							<div class="field-wrapper field-barrier-finish">
								<label for="barrier-finish">
									<h5 class="label-title text-blue">
										<?php echo esc_html__( 'Galvanised Finish', 'armcodirect' ); ?>
										<span class="required">*</span>
									</h5>
									<p class="label-desc"><?php echo esc_html__( 'Do you require powder coating?', 'armcodirect' ); ?></p>
									<div class="calculator-options d-flex">
										<span class="position-relative me-lg-4 me-sm-2 me-0">
											<input type="radio" name="finish-type" value="no" id="finish-no-radio" checked>
											<span class="option"><?php echo esc_html__( 'No', 'armcodirect' ); ?></span>
										</span>
										<span class="position-relative">
											<input type="radio" name="finish-type" value="yes" id="finish-yes-radio">
											<span class="option"><?php echo esc_html__( 'Yes', 'armcodirect' ); ?></span>
										</span>
									</div>
									<div class="calculator-options checkbox-options finish-type-wrap d-none">
										<p class="label-desc"><?php echo esc_html__( 'Please select which section requires a powder coating finish.', 'armcodirect' ); ?></p>
										<div class="d-flex">
											<span class="position-relative me-2 mb-2">
												<input type="checkbox" name="Beams-Finishing" id="Beams-Finishing">
												<span class="option"><?php echo esc_html__( 'Beams', 'armcodirect' ); ?></span>
											</span>
											<span class="position-relative me-2 mb-2">
												<input type="checkbox" name="Posts-Finishing" id="Posts-Finishing">
												<span class="option"><?php echo esc_html__( 'Posts', 'armcodirect' ); ?></span>
											</span>
											<span class="position-relative me-2 mb-2">
												<input type="checkbox" name="Accessories-Finishing" id="Accessories-Finishing">
												<span class="option"><?php echo esc_html__( 'End Protection', 'armcodirect' ); ?></span>
											</span>
											<span class="position-relative">
												<input type="checkbox" name="All-Finishing" id="All-Finishing">
												<span class="option"><?php echo esc_html__( 'All', 'armcodirect' ); ?></span>
											</span>
										</div>
									</div>
									<div class="calculator-tooltip">
										<div class="tooltip-icon"></div>
										<div class="tooltip-text">
											<div class="text-wrapper">
												<p><?php echo esc_html__( 'The default finish is galvanised, however, powder coating RAL 1007 yellow is available to select below.' ); ?></p>
											</div>
										</div>
									</div>
								</label>
							</div>
						</form>
						<?php
					endif;
					?>
				</div>
				<?php
				$calculator_shortcode_id = get_field( 'calculator_shortcode_form' );
				if ( ! empty( $calculator_shortcode_id ) ) {
					?>
					<h3 id="title-section" class="calculate-1-title">Submit your details</h3>
					<div id="calculator-step-3" class="calculator-step-3">
						<div class="calculator-wrap">
							<?php
							$calculator_shortcode_shortcode = '[contact-form-7 id="' . $calculator_shortcode_id . '"]';
							echo do_shortcode( $calculator_shortcode_shortcode );
							?>
						</div>
					</div>
					<?php
				}
				?>
			</div>
			<div class="col-lg-5 col-12 mt-4 mt-lg-0">
				<div class="step-wrapper sidebar-block">
					<!-- Calculator STEP 2 -->
					<div class="calculator-step-2">
						<?php
						if ( get_field( 'calculator_2_title' ) ) {
							?>
							<h2><?php the_field( 'calculator_2_title' ); ?></h2>
							<?php
						}
						the_field( 'calculator_2_desc' );
						?>
						<form class="results calculator-wrap">
							<input type="hidden" name="old-end-protection" id="old-end-protection" value="0">
							<?php
							$post_results          = get_field( 'calculator_posts' );
							$beam_results          = get_field( 'calculator_beams' );
							$post_bolts_results    = get_field( 'calculator_post_bolts' );
							$lap_bolts_results     = get_field( 'calculator_lap_bolts' );
							$floor_anchors_results = get_field( 'calculator_floor_anchors' );
							?>
							<div class="row align-items-center mb-2">
								<div class="col-4"><strong class="form-title"><?php echo $post_results['calculator_posts_title']; //phpcs:ignore ?></strong></div>
								<div class="col-8 form-input-wrapper text-end"><input type="text" value="0" id="posts" name="posts-amount"/></div>
							</div>
							<div class="row align-items-center">
								<div class="col-4"><strong class="form-title"><?php echo $beam_results['calculator_beams_title']; //phpcs:ignore ?></strong></div>
								<div class="col-8 form-input-wrapper text-end"><input type="text" value="0" id="beams" name="beams-amount"/></div>
							</div>
							<table class="my-3">
								<tr class="d-none">
									<th><?php echo esc_html__( 'Post Type', 'armcodirect' ); ?></th>
									<td><input disabled type="text" value="0" id="post-type" /></td>
								</tr>
								<tr class="d-none">
									<th><?php echo esc_html__( 'Post Type', 'armcodirect' ); ?></th>
									<td><input disabled type="text" value="0" id="post-fixing" /></td>
								</tr>
								<tr class="d-none">
									<th><?php echo esc_html__( 'Handrails', 'armcodirect' ); ?></th>
									<td><input disabled type="text" value="0" id="handrails" /></td>
								</tr>
								<tr class="d-none">
									<th><?php echo esc_html__( 'Beam Type', 'armcodirect' ); ?></th>
									<td><input disabled type="text" value="0" id="beam-type" /></td>
								</tr>
								<tr>
									<th><?php echo $post_bolts_results['calculator_post_bolts_title']; //phpcs:ignore ?></th>
									<td><input disabled type="text" value="0" id="post-bolts" /></td>
								</tr>
								<tr>
									<th><?php echo $lap_bolts_results['calculator_lap_bolts_title']; //phpcs:ignore ?></th>
									<td><input disabled type="text" value="0" id="lap-bolts"/></td>
								</tr>
								<tr>
									<th><?php echo $floor_anchors_results['calculator_floor_anchors_title']; //phpcs:ignore ?></th>
									<td><input disabled type="text" value="2" id="no-of-ends" /></td>
								</tr>
								<tr class="d-none">
									<th><?php echo esc_html__( 'End Protection', 'armcodirect' ); ?></th>
									<td><input disabled type="text" value="No Protection" name="end-protection" id="end-protection" /></td>
								</tr>
								<tr class="d-none">
									<th><?php echo esc_html__( 'Finish', 'armcodirect' ); ?></th>
									<td><input disabled type="text" value="0" id="barrier-finish" /></td>
								</tr>
								<tr>
									<th><?php echo esc_html__( 'Changes in Direction', 'armcodirect' ); ?></th>
									<td><input disabled type="text" value="0" id="total-direction" /></td>
								</tr>
								<tr class="d-none">
									<th><?php echo esc_html__( '90 Degree', 'armcodirect' ); ?></th>
									<td><input disabled type="text" value="0" id="90-barrier-corners" /></td>
								</tr>
								<tr class="d-none">
									<th><?php echo esc_html__( '135 Degree', 'armcodirect' ); ?></th>
									<td><input disabled type="text" value="0" id="135-barrier-corners" /></td>
								</tr>
								<tr class="d-none">
									<th><?php echo esc_html__( 'Flexible', 'armcodirect' ); ?></th>
									<td><input disabled type="text" value="0" id="flexible-barrier-corners" /></td>
								</tr>
								<tr class="d-none">
									<th><?php echo esc_html__( 'Total Corners', 'armcodirect' ); ?></th>
									<td><input disabled type="text" value="0" id="total-corners" /></td>
								</tr>
							</table>
							<div class="cta-wrapper">
								<a href="#calculator-step-3" title="<?php echo esc_attr__( 'Get A Quick Quote', 'armcodirect' ); ?>" class="calculator-2-button btn yellow-strip-btn"><?php echo esc_html__( 'Get A Quick Quote', 'armcodirect' ); ?></a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<div class="scroll-to-calculator-summary">
	<span class="arrow">Scroll</span>
</div>
