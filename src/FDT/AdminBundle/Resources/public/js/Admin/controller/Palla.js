Ext.define('Test.controller.Palla',
{
    extend: 'Ext.app.Controller',
    
    
    stores:
    [
        'Test.store.Palla'
    ],
    
    models:
    [
    	'Test.model.Palla'
    ],
        
    init: function()
    {
        console.info('Inizializzato palla');
    },
    
    cazzo : function ()
    {
    
        console.info('Chiamato metodo cazzo del controller palla');
    
    },
    
    launch : function ()
    {
	 
	 	console.log (Ext.Loader.getPath ('Test'));
	 		 	
	 	
        //var store = this.getStore('Bundles');	 
	 
    } 
    
});