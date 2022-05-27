/**
 * Javascript code to be used with input type datetimeflatpicker.
 *
 * @author Simon Stier
 *
 */

/**
 * Initializes a datetimeflatpicker input
 * Test: https://jsfiddle.net/v8u4ts3q/
 *
 * @param {string} inputID the id of the input to initialize
 * @param {Object} params the parameter object for the datetimeflatpicker, contains
 *		currValue: (String) the current value (format: ISO time string)
 *		minTime: (String) the minimum datatime to be shown (format: ISO time string)
 *		maxTime: (String) the maximum datatime to be shown (format: ISO time string)
 *		interval: (String) the interval between selectable times in minutes
 *		format: (String) display format string 
 */
window.PF_DTFP_init = function( inputID, params ) { // minTime, maxTime, interval, format

	var value = "";
	if (params.currValue === "now") value = new Date();
	else if (params.currValue !== "") value = new Date(params.currValue);
						      				      
	var minDate = "";
	if (params.minTime !== "") minDate = new Date(params.minTime);
	var maxDate = "";
	if (params.maxTime !== "") maxDate = new Date(params.maxTime);
	
	var format = params.format;
	if (format === "") format = "Y-m-d H:i";
	
	var increment = params.interval;
	if (increment === "") increment = 5;
	
	var time_24hr = true;
	if (params.time_24hr === "false") time_24hr = false;

	flatpickr("#" + inputID, {
			defaultDate: value,
			enableTime: true,
			time_24hr: time_24hr,
			dateFormat: format,
		  	minDate: minDate,
  			manDate: maxDate,
  			minuteIncrement: increment,
			onChange: function(selectedDates) {
				var selectedDate = new Date(selectedDates[0]).toISOString();
				console.log(selectedDate);
	  	}
	});

};
