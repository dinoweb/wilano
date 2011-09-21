Ext.define('Admin.store.BaseTreeStore',
{
    extend: 'Ext.data.TreeStore',    
    autoLoad: false,
    autoSync: true,
    root: 
	{
	   text: "Metadata",
	   expanded: false
	},
	proxy:
	{
            type:'ajax',            
            reader: {
			    type: 'json'
            },
            writer: {
                type: 'json',
            }
    }   

});