Ext.define('Test.store.Palla',
{
    extend: 'Ext.data.Store',
    autoLoad: true,
    model: 'Test.model.Palla',
	proxy:
	{
            type:'ajax',            
            url:'getPalla',
            reader: {
            			type: 'json',
            			root: 'bundles'
                    }
    }
});