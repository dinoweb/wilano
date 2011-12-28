Ext.define('Admin.view.BaseRelationsWindow', {
    extend: 'Ext.window.Window',    
        
    autoShow: true,
    titleCollapse: true,
    autoScroll:true,
    shadow: false,
    autoDestroy: true,
    collapsible: true,
    modal: false,
    layout: 'border',
    border: false,
    defaults: {autoHeight:true},
    initComponent: function() {

        this.buttons = [
            {
                text: 'Close',
                scope: this,
                handler: this.destroy
            }
        ];

        this.callParent(arguments);
    },
    items: [
				{
					xtype:'tabpanel',
					id: 'relatedPanel',
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
					border:true
				}
	]
});