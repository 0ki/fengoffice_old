og.HelpPanel = function(config) {
	og.HelpPanel.superclass.constructor.call(this, Ext.apply(config, {
		defaultContent: {
			type: 'url',
			data: 'help/index.html'
		},
		active: true
	}));
};

Ext.extend(og.HelpPanel, og.ContentPanel, {
	workspaceChanged: function() {
	}
});