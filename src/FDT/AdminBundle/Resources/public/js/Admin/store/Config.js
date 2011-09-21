Ext.define('Admin.store.Config',
{
    extend: 'Ext.data.Store',
    
    autoLoad: false,
	model: 'Admin.model.Config',
	proxy:
	{
        type: 'ajax',
        url: 'getConfig'
    }
});