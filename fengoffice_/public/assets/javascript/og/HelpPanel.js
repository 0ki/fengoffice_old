og.HelpPanel = function(config) {
	og.HelpPanel.superclass.constructor.call(this, Ext.apply(config, {
		defaultContent: {
			type: 'url',
			data: 'help/index.html'
		},
		active: true,
		listeners: {
			'expand': {
				fn: function() {
					alert('pepe');
					if (!this.contentLoaded)
						this.loadContentUrl();
				},
				scope: this
			}
		}
	}));
};

Ext.extend(og.HelpPanel, og.ContentPanel, {
	workspaceChanged: function() {
	}
});