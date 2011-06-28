Ext.define('Admin.store.Paths',
{
    extend: 'Ext.data.Store',
    model: 'Admin.model.Paths',
    storeId: 'bundlesStore',
	proxy:
	{
            type:'ajax',
            async : false,            
            url:'getBundlesConfig',
            reader: {
            			type: 'json',
            			root: 'paths'
                    }
    }
});