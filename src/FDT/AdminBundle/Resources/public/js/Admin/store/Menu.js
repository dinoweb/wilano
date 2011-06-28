Ext.define('Admin.store.Menu',
{
    extend: 'Ext.data.TreeStore',
    autoLoad: true,
    model: 'Admin.model.Menu',
    root: 
	{
	expanded: false,
	nodeType:'async'
	},
	proxy:
	{
            type:'ajax',            
            url:'getMenu',
            reader: {
            			type: 'json'
                    }
    }
});