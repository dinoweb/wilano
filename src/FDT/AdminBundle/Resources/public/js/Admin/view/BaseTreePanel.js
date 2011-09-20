Ext.define('Admin.view.BaseTreePanel', {
    extend: 'Ext.TreePanel',
    
    autoRender: true,
	closable: true,
	rootVisible: false,
	displayField: 'uniqueName',
	useArrows: true,
	columns:[
	    {xtype: 'treecolumn', text: 'Tipologia', flex: 2, sortable: false, dataIndex: 'uniqueName'},
	    {text: 'Attivo', flex: 1, sortable: false, dataIndex: 'isActive'},
	    {text: 'Privato', flex: 1, sortable: false, dataIndex: 'isPrivate'},
	    {text: 'Configurabile', flex: 1, sortable: false, dataIndex: 'isConfigurable'},
	    {text: 'Ha Periodo', flex: 1, sortable: false, dataIndex: 'hasPeriod'}
	    
	]
});
