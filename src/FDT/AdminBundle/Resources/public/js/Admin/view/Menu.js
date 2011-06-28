Ext.define('Admin.view.Menu',
{
    extend: 'Ext.panel.Panel',
    alias: 'widget.mainMenu',
    
    
    requires:
    [
        'Ext.layout.container.Accordion'
    ],
    
    layout: 'accordion',    
    layoutConfig: {
						animate: true,
						activeOnTop: false,
						titleCollapse: true,
						sequence: false,
						activeItem: 0
					
					},
	region: 'west',
    split : false,
    border: true,
    bodyBorder: false,
    margins: '2 0 2 2',
    cmargins: '2 0 2 2',
    width: 150,
    collapsible: true,
    autoscroll: true,
    title: 'Menu'
    

});