Ext.define('Parties.store.Menu',
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
            url:'parties/getMenu',
            reader: {
            			type: 'json'
                    }
    }
});