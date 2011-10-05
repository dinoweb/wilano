Ext.define('Admin.store.BaseTreeStore',
{
    extend: 'Ext.data.TreeStore',    
    autoLoad: false,
    autoSync: false,
    root: 
	{
	   text: "Metadata",
	   expanded: false
	},
	proxy:
	{
            type:'rest',            
            reader: {
			    type: 'json'
            },
            writer: {
                type: 'json',
            }
    }   

});