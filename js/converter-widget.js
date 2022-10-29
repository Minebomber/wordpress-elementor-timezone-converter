class TimezoneConverterWidgetHandler extends elementorModules.frontend.handlers.Base {
    getDefaultSettings() {
        return {
            selectors: {
				data: '.tz-converter__data',
				datetime: '.tz-converter__to-datetime',
                zone: '.tz-converter__to-zone',
            },
        };
    }

    getDefaultElements() {
        const selectors = this.getSettings( 'selectors' );
        return {
			$data: this.$element.find( selectors.data ),
            $datetime: this.$element.find( selectors.datetime ),
            $zone: this.$element.find( selectors.zone ),
        };
    }

    bindEvents() {
        this.elements.$zone.on( 'change', this.onZoneChange.bind( this ) );
    }

    onZoneChange( event ) {
		const FROM = new Date(this.elements.$data.val());
		const zone = this.elements.$zone.val();
		const converted = FROM.toLocaleString('en-US', {
			timeZone: zone,
			dateStyle: 'medium',
			timeStyle: 'long'
		});
        this.elements.$datetime.text(converted);
   }
}

jQuery( window ).on( 'elementor/frontend/init', () => {
   const addHandler = ( $element ) => {
       elementorFrontend.elementsHandler.addHandler( TimezoneConverterWidgetHandler, {
           $element,
       } );
   };
   elementorFrontend.hooks.addAction( 'frontend/element_ready/tz-converter.default', addHandler );
} );
