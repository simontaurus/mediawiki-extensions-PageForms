<?php

/**
 * @author Simon Stier
 * @file
 * @ingroup PageForms
 */

/**
 * @ingroup PageForms
 */

class PFDateTimeFlatPicker extends PFFormInput {

	public static function getName(): string {
		return 'datetimeflatpicker';
	}

	/**
	 * @param string $input_number The number of the input in the form.
	 * @param string $cur_value The current value of the input field.
	 * @param string $input_name The name of the input.
	 * @param bool $disabled Is this input disabled?
	 * @param array $other_args An associative array of other parameters that were present in the
	 *  input definition.
	 */
	public function __construct( $input_number, $cur_value, $input_name, $disabled, array $other_args ) {
		//if ( $cur_value != '' ) {
		//	list( $year, $month, $day, $time ) = PFDateInput::parseDate( $cur_value, true );
		//	$cur_value = sprintf( '%04d-%02d-%02dT%sZ', $year, $month, $day, $time );
		//}
		parent::__construct( $input_number, $cur_value, $input_name, $disabled, $other_args );
    
		$this->addJsInitFunctionData( 'PF_DTFP_init', $this->setupJsInitAttribs() );
	}
  
  	/**
	 * Set up JS attributes
	 *
	 * @return string[]
	 */
	protected function setupJsInitAttribs() {

		// set min time if valid, else use default
		if ( array_key_exists( 'mintime', $this->mOtherArgs ) ) {
			$minTime = trim( $this->mOtherArgs['mintime'] );
		} else {
			$minTime = '';
		}

		// set max time if valid, else use default
		if ( array_key_exists( 'maxtime', $this->mOtherArgs ) ) {
			$maxTime = trim( $this->mOtherArgs['maxtime'] );
		} else {
			$maxTime = '';
		}

		// set interval if valid, else use default
		if ( array_key_exists( 'interval', $this->mOtherArgs )
			&& preg_match( '/^\d+$/', trim( $this->mOtherArgs['interval'] ) ) == 1 ) {
			$interval = trim( $this->mOtherArgs['interval'] );
		} else {
			$interval = '5';
		}
		
		// set max time if valid, else use default
		if ( array_key_exists( 'format', $this->mOtherArgs ) ) {
			$format = trim( $this->mOtherArgs['format'] );
		} else {
			$format = 'Y-m-d H:i';
		}

		// build JS code from attributes array
		$jsattribs = [
			'minTime'   => $minTime,
			'maxTime'   => $maxTime,
			'interval'  => $interval,
			'format'    => $format,
			'currValue' => $this->mCurrentValue,
			'disabled'  => $this->mIsDisabled
		];

		return $jsattribs;
	}

	/**
	 * Returns the HTML code to be included in the output page for this input.
	 *
	 * Ideally this HTML code should provide a basic functionality even if the
	 * browser is not JavaScript capable. I.e. even without JavaScript the user
	 * should be able to input values.
	 * @return string
	 */
	public function getHtmlText(): string {
		$name = $this->mInputName;
		$id = 'input_' . $this->mInputNumber;
		$value = $this->mCurrentValue;
		$class = array_key_exists( 'class', $this->mOtherArgs ) ? 'createboxInput pfFlatPicker ' . $this->mOtherArgs['class'] : 'pfFlatPicker';
    
		$text = "<input id='{$id}' name='{$name}' class='{$class}' type='text' placeholder='Select Date..' value='{$value}' >";

		$wrapperClass = 'pfFlatPickerWrapper';
		if ( isset( $this->mOtherArgs[ 'mandatory' ] ) ) {
			$wrapperClass .= ' mandatory';
		}

		return Html::rawElement( 'div', [ 'class' => $wrapperClass ], $text );
	}

	/**
	 * Returns the set of SMW property types which this input can
	 * handle, but for which it isn't the default input.
	 * @return string[]
	 */
	public static function getOtherPropTypesHandled() {
		return [ '_str', '_dat' ];
	}

	/**
	 * Returns the set of parameters for this form input.
	 * @return array[]
	 */
	public static function getParameters() {
		$params = array_merge(
			parent::getParameters()
		);

		$params['mintime'] = [
			'name' => 'mintime',
			'type' => 'string',
			'description' => wfMessage( 'pageforms-timepicker-mintime' )->text(),
		];
		$params['maxtime'] = [
			'name' => 'maxtime',
			'type' => 'string',
			'description' => wfMessage( 'pageforms-timepicker-maxtime' )->text(),
		];
		$params['interval'] = [
			'name' => 'interval',
			'type' => 'int',
			'description' => wfMessage( 'pageforms-timepicker-interval' )->text(),
		];

		return $params;
	}

	/**
	 * Returns the names of the resource modules this input type uses.
	 *
	 * Returns the names of the modules as an array or - if there is only one
	 * module - as a string.
	 *
	 * @return null|string|array
	 */
	public function getResourceModuleNames() {
		return [ 'ext.pageforms.datetimeflatpicker' ];
	}

}
