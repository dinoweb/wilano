Ext.define('Admin.view.BaseTreePanel', {
    extend: 'Ext.TreePanel',
    
    autoRender: true,
	closable: true,
	rootVisible: false,
	displayField: 'uniqueName',
	useArrows: true
});
