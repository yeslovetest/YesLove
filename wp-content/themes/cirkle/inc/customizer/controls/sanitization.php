<?php

if ( class_exists( 'WP_Customize_Control' ) ) {

    /* = Link Button
    ==========================================================*/
    if ( ! function_exists( 'rttheme_header_link_btn_enabled' ) ) {
        function rttheme_header_link_btn_enabled() {
            $page_banner = get_theme_mod('header_link');
            if (empty($page_banner)) {
                return false;
            }
            return true;
        }
    }

	/* = Page Layout
    ==========================================================*/
	/**
     * Check is Enabled Header Button
     */
    if ( ! function_exists( 'rttheme_is_header_banner_enabled' ) ) {
        function rttheme_is_header_banner_enabled() {
            $page_banner = get_theme_mod('cirkle_has_banner');
            if (empty($page_banner)) {
                return false;
            }
            return true;
        }
    }

	/**
     * Check is selected banner background type is image
     */
    if ( ! function_exists( 'rttheme_banner_bgimg_type_condition' ) ) {
        function rttheme_banner_bgimg_type_condition() {
            $BgType = get_theme_mod('page_banner_bg_type');
            if ( $BgType === 'bgimg' ) {
                return true;
            }
            return false;
        }
    }
    /**
     * Check is selected banner background type is color
     */
    if ( ! function_exists( 'rttheme_banner_bgcolor_type_condition' ) ) {
        function rttheme_banner_bgcolor_type_condition() {
            $checkbox_value = get_theme_mod( 'page_banner', false );
            $select_value   = get_theme_mod( 'page_banner_bg_type', 'bgcolor' );
            if ( !empty( $checkbox_value ) && $select_value == 'bgcolor' ) {
                return true;
            }
            return false;
        }
    }

    /* = Single Page Layout
    ==========================================================*/
    /**
     * Check is Enabled Header Button
     */
    if ( ! function_exists( 'rttheme_is_single_post_banner_enabled' ) ) {
        function rttheme_is_single_post_banner_enabled() {
            $page_banner = get_theme_mod('single_post_banner');
            if (empty($page_banner)) {
                return false;
            }
            return true;
        }
    }

	/**
     * Check is selected banner background type is image
     */
    if ( ! function_exists( 'rttheme_single_banner_bgimg_type_condition' ) ) {
        function rttheme_single_banner_bgimg_type_condition() {
            $BgType = get_theme_mod('single_post_banner_bg_type');
            if ( $BgType === 'bgimg' ) {
                return true;
            }
            return false;
        }
    }
    /**
     * Check is selected banner background type is color
     */
    if ( ! function_exists( 'rttheme_single_banner_bgcolor_type_condition' ) ) {
        function rttheme_single_banner_bgcolor_type_condition() {
            $select_value = get_theme_mod( 'single_post_banner', false );
            $select_bg_value = get_theme_mod( 'single_post_banner_bg_type', 'bgcolor' );
            if ( !empty( $select_value ) && $select_bg_value == 'bgcolor' ) {
                return true;
            }
            return false;
        }
    }

    /* = Blog Columns
    ==========================================================*/
    if ( ! function_exists( 'rttheme_blog_cols_condition' ) ) {
        function rttheme_blog_cols_condition() {
             $blog_style = get_theme_mod( 'blog_style');
            if ( $blog_style == 2 ) {
                return true;
            } else {
                return false;
            }
        }
    }

    /* = Blog Details Page Related Post
    ==========================================================*/
    if ( ! function_exists( 'rttheme_related_post_enabled' ) ) {
        function rttheme_related_post_enabled() {
            $related_post = get_theme_mod('related_post');
            if (empty($related_post)) {
                return false;
            }
            return true;
        }
    }


    /* = Footer Enable
    ==========================================================*/
    if ( ! function_exists( 'rttheme_is_footer1_enabled' ) ) {
        function rttheme_is_footer1_enabled() {
            $footer_style = get_theme_mod( 'footer_style', '1' );
            if ( $footer_style == 1 || $footer_style == 1 ) {
                return true;
            } elseif ( $footer_style2 == 2 ) {
            	return true;
            }
            return false;
        }
    }



    /**
     * Footer 1 Condition
     */
    if ( ! function_exists( 'rttheme_footer1_bg_condition' ) ) {
        function rttheme_footer1_bg_condition() {
             $footer_style = get_theme_mod( 'footer_style');
            if ( $footer_style == 1 ) {
                return true;
            } else {
            	return false;
            }
        }
    }


    /**
     * Footer 2 Condition
     */
    if ( ! function_exists( 'rttheme_footer2_bg_condition' ) ) {
        function rttheme_footer2_bg_condition() {
             $footer_style = get_theme_mod( 'footer_style');
            if ( $footer_style == 2 ) {
                return true;
            } else {
            	return false;
            }
        }
    }
    /**
     * Footer 3 Condition
     */
    if ( ! function_exists( 'rttheme_footer3_bg_condition' ) ) {
        function rttheme_footer3_bg_condition() {
             $footer_style = get_theme_mod( 'footer_style');
            if ( $footer_style == 3 ) {
                return true;
            } else {
            	return false;
            }
        }
    }


	/**
	 * URL sanitization
	 *
	 * @param  string	Input to be sanitized (either a string containing a single url or multiple, separated by commas)
	 * @return string	Sanitized input
	 */
	if ( ! function_exists( 'rttheme_url_sanitization' ) ) {
		function rttheme_url_sanitization( $input ) {
			if ( strpos( $input, ',' ) !== false) {
				$input = explode( ',', $input );
			}
			if ( is_array( $input ) ) {
				foreach ($input as $key => $value) {
					$input[$key] = esc_url_raw( $value );
				}
				$input = implode( ',', $input );
			}
			else {
				$input = esc_url_raw( $input );
			}
			return $input;
		}
	}

	/**
	 * Switch sanitization
	 *
	 * @param  string		Switch value
	 * @return integer	Sanitized value
	 */

	if ( ! function_exists( 'rttheme_switch_sanitization' ) ) {
		function rttheme_switch_sanitization( $input ) {
			if ( true === $input ) {
				return 1;
			} else {
				return 0;
			}
		}
	}

	/**
	 * Radio Button and Select sanitization
	 *
	 * @param  string		Radio Button value
	 * @return integer	Sanitized value
	 */
	if ( ! function_exists( 'rttheme_radio_sanitization' ) ) {
		function rttheme_radio_sanitization( $input, $setting ) {
			//get the list of possible radio box or select options
         $choices = $setting->manager->get_control( $setting->id )->choices;

			if ( array_key_exists( $input, $choices ) ) {
				return $input;
			} else {
				return $setting->default;
			}
		}
	}

	/**
	 * Integer sanitization
	 *
	 * @param  string		Input value to check
	 * @return integer	Returned integer value
	 */

	if ( ! function_exists( 'rttheme_sanitize_integer' ) ) {
		function rttheme_sanitize_integer( $input ) {
			return (int) $input;
		}
	}

	/**
	 * Text sanitization
	 *
	 * @param  string	Input to be sanitized (either a string containing a single string or multiple, separated by commas)
	 * @return string	Sanitized input
	 */
	if ( ! function_exists( 'rttheme_text_sanitization' ) ) {
		function rttheme_text_sanitization( $input ) {
			if ( strpos( $input, ',' ) !== false) {
				$input = explode( ',', $input );
			}
			if( is_array( $input ) ) {
				foreach ( $input as $key => $value ) {
					$input[$key] = sanitize_text_field( $value );
				}
				$input = implode( ',', $input );
			}
			else {
				$input = sanitize_text_field( $input );
			}
			return $input;
		}
	}

    /**
     * Google Font sanitization
     *
     * @param  string	JSON string to be sanitized
     * @return string	Sanitized input
     */

    if ( ! function_exists( 'rttheme_google_font_sanitization' ) ) {
        function rttheme_google_font_sanitization( $input ) {
            $val =  json_decode( $input, true );
            if( is_array( $val ) ) {
                foreach ( $val as $key => $value ) {
                    $val[$key] = sanitize_text_field( $value );
                }
                $input = json_encode( $val );
            }
            else {
                $input = json_encode( sanitize_text_field( $val ) );
            }
            return $input;
        }
    }

	/**
	 * Array sanitization
	 *
	 * @param  array	Input to be sanitized
	 * @return array	Sanitized input
	 */
	if ( ! function_exists( 'rttheme_array_sanitization' ) ) {
		function rttheme_array_sanitization( $input ) {
			if( is_array( $input ) ) {
				foreach ( $input as $key => $value ) {
					$input[$key] = sanitize_text_field( $value );
				}
			}
			else {
				$input = '';
			}
			return $input;
		}
	}

	/**
	 * Alpha Color (Hex & RGBa) sanitization
	 *
	 * @param  string	Input to be sanitized
	 * @return string	Sanitized input
	 */
	if ( ! function_exists( 'rttheme_hex_rgba_sanitization' ) ) {
		function rttheme_hex_rgba_sanitization( $input, $setting ) {
			if ( empty( $input ) || is_array( $input ) ) {
				return $setting->default;
			}

			if ( false === strpos( $input, 'rgba' ) ) {
				// If string doesn't start with 'rgba' then santize as hex color
				$input = sanitize_hex_color( $input );
			} else {
				// Sanitize as RGBa color
				$input = str_replace( ' ', '', $input );
				sscanf( $input, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
				$input = 'rgba(' . rttheme_in_range( $red, 0, 255 ) . ',' . rttheme_in_range( $green, 0, 255 ) . ',' . rttheme_in_range( $blue, 0, 255 ) . ',' . rttheme_in_range( $alpha, 0, 1 ) . ')';
			}
			return $input;
		}
	}

	/**
	 * Only allow values between a certain minimum & maxmium range
	 *
	 * @param  number	Input to be sanitized
	 * @return number	Sanitized input
	 */
	if ( ! function_exists( 'rttheme_in_range' ) ) {
		function rttheme_in_range( $input, $min, $max ){
			if ( $input < $min ) {
				$input = $min;
			}
			if ( $input > $max ) {
				$input = $max;
			}
		    return $input;
		}
	}

	/**
	 * Date Time sanitization
	 *
	 * @param  string	Date/Time string to be sanitized
	 * @return string	Sanitized input
	 */

	if ( ! function_exists( 'rttheme_date_time_sanitization' ) ) {
		function rttheme_date_time_sanitization( $input, $setting ) {
			$datetimeformat = 'Y-m-d';
			if ( $setting->manager->get_control( $setting->id )->include_time ) {
				$datetimeformat = 'Y-m-d H:i:s';
			}
			$date = DateTime::createFromFormat( $datetimeformat, $input );
			if ( $date === false ) {
				$date = DateTime::createFromFormat( $datetimeformat, $setting->default );
			}
			return $date->format( $datetimeformat );
		}
	}

	/**
	 * Slider sanitization
	 *
	 * @param  string	Slider value to be sanitized
	 * @return string	Sanitized input
	 */
	if ( ! function_exists( 'rttheme_range_sanitization' ) ) {
		function rttheme_range_sanitization( $input, $setting ) {
			$attrs = $setting->manager->get_control( $setting->id )->input_attrs;

			$min = ( isset( $attrs['min'] ) ? $attrs['min'] : $input );
			$max = ( isset( $attrs['max'] ) ? $attrs['max'] : $input );
			$step = ( isset( $attrs['step'] ) ? $attrs['step'] : 1 );

			$number = floor( $input / $attrs['step'] ) * $attrs['step'];

			return rttheme_in_range( $number, $min, $max );
		}
	}

}
