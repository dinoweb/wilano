Ext.define('Admin.view.Viewport', {
    extend: 'Ext.container.Viewport',
    alias: 'widget.mainViewport',
    

    requires:
    [
        'Admin.view.Menu',
        'Ext.layout.container.Border'
    ],
    
	layout: 'border',

	items: [
				{
					xtype:'tabpanel',
					itemId: 'mainPanel',
			   		resizeTabs: true,
					enableTabScroll: true,
					region: 'center',
					minTabWidth: 115,
					tabWidth: 200,
					activeTab:0,
					deferredRender: false,
					margins: '0 2 2 2',
					cmargins: '0 0 0 0',
					autoTabs: true,
					autoDestroy: true,
					border:true,
					items: [{
								title: 'Dashboard',
								margins: '0 0 0 0',
								closable: false,
								border: false        												
							}]
			
				},
				{
			   		xtype: 'mainMenu'
			   	    
				}
	]
});
