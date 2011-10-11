Ext.define('Admin.store.BaseStore',
{
    extend: 'Ext.data.Store',    
    autoLoad: true,
    autoSync: false,
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