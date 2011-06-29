Ext.define('Parties.store.Menu',
{
    extend: 'Ext.data.TreeStore',
    autoLoad: true,
    model: 'Admin.model.Menu',
    rootVisible: false,
    root: 
	{
	   expanded: true,
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