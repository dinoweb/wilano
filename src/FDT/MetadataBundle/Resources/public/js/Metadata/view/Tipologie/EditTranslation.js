Ext.define('Metadata.view.Tipologie.EditTranslation', {
    extend: 'Ext.form.FieldSet',
    alias: 'widget.tipologieEditTranslation',
    
    title: 'Traduzioni',
    xtype:'form',
	collapsible: true,
	autoScroll: false,
	defaults: {autoHeight:true, bodyStyle:'padding:5px'},
	anchor: '100%',
	initComponent: function() {

	    this.callParent(arguments);
        this.getTranslationForm();
	    
	},
	
	getTranslationForm: function ()
    {
      this.getLanguagesStore().each(this.buildField, this);
        
        
    },
    
    buildField: function (Language)
    {
        var lang = Language.get('value');
        var LangName = Language.get('name');
        var Panel = Ext.create('Ext.form.Panel', {
                    title: Language.get('name'),
                    defaults: {
                                labelAlign: 'left'
                            },
        			border: 1,
            		items:[
            		        {
                                xtype: 'textfield',
                                name : lang+'-name',
                                fieldLabel: 'Name ',
                                allowBlank: false,
                                anchor:'100%'
                            }
                          ]
                });
                
        this.add (Panel);
        
    },
    
    getLanguagesStore: function ()
    {
        
        var storeLanguages = Ext.data.StoreManager.lookup('Admin.store.Languages');
        return storeLanguages;
        
    }
	
});
