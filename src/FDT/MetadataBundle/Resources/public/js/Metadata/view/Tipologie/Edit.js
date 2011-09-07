Ext.define('Metadata.view.Tipologie.Edit', {
    extend: 'Ext.window.Window',
    alias : 'widget.tipologieEdit',
    
    config: {
        tipologia: null
    },

    autoShow: true,
    titleCollapse: true,
    autoScroll:true,
    constrain: true,
    shadow: false,
    autoDestroy: true,
    collapsible: true,
    modal: true,
    defaults: {autoHeight:false, bodyStyle:'padding:5px'},
    initComponent: function() {
        
        this.items = [{
                        xtype: 'form',
                        items: [
                                {
                                    xtype:'tabpanel',
            						activeTab: 0,
            						minTabWidth: 115,
            						enableTabScroll: true,
            						autoScroll: false,
                					defaults: {autoHeight:true, bodyStyle:'padding:10px'},
                					deferredRender: false,
                					anchor: '100%',
                					border: 1,
                					items: [{
                					             title: 'Dati Generali',
                					             xtype: 'form',
            									 border:false,
                								 labelAlign: 'left',
                								 items:[
    								 
                								        {
                                                            xtype: 'textfield',
                                                            name : 'uniqueName',
                                                            fieldLabel: 'UniqueName',
                                                            allowBlank: false,
                                                            anchor:'100%'
                                                        },
                
                                                        {
                                                            xtype: 'textfield',
                                                            name : 'uniqueSlug',
                                                            fieldLabel: 'UniqueSlug',
                                                            allowBlank: false,
                                                            anchor:'100%'
                                                        },
                
                                                        {
                                                            xtype:'combo',
                                                            autoSelect: true,
                                                            forceSelection: true,
                                                            typeAhead: true,
                                                            queryMode: 'local',
                                    					    store: 'Admin.store.SiNo',
                                    						fieldLabel: 'IsActive',
                                    						displayField:'name',
                                    						valueField:'value',
                                    						hiddenName: 'isActive',
                                    						name: 'isActive',
                                    						selectOnFocus:true,
                                    						allowBlank: false,
                                    						anchor:'40%'
                                                        },
                                                        {
                                                            xtype:'combo',
                                                            autoSelect: true,
                                                            forceSelection: true,
                                                            typeAhead: true,
                                                            queryMode: 'local',
                                    					    store: 'Admin.store.SiNo',
                                    						fieldLabel: 'IsPrivate',
                                    						displayField:'name',
                                    						valueField:'value',
                                    						hiddenName: 'isPrivate',
                                    						name: 'isPrivate',
                                    						selectOnFocus:true,
                                    						allowBlank: false,
                                    						anchor:'40%'
                                                        },
                                                        {
                                                            xtype:'combo',
                                                            autoSelect: true,
                                                            forceSelection: true,
                                                            typeAhead: true,
                                                            queryMode: 'local',
                                    					    store: 'Admin.store.SiNo',
                                    						fieldLabel: 'IsConfigurable',
                                    						displayField:'name',
                                    						valueField:'value',
                                    						hiddenName: 'isConfigurable',
                                    						name: 'isConfigurable',
                                    						selectOnFocus:true,
                                    						allowBlank: false,
                                    						anchor:'40%'
                                                        },
                                                        {
                                                            xtype:'combo',
                                                            autoSelect: true,
                                                            forceSelection: true,
                                                            typeAhead: true,
                                                            queryMode: 'local',
                                    					    store: 'Admin.store.SiNo',
                                    						fieldLabel: 'HasPeriod',
                                    						displayField:'name',
                                    						valueField:'value',
                                    						hiddenName: 'hasPeriod',
                                    						name: 'hasPeriod',
                                    						selectOnFocus:true,
                                    						allowBlank: false,
                                    						anchor:'40%'
                                    					}
    								    
    								       
                								       ]//CHIUSURA CAMPI DATI GENERALI
    					                					       
            					            },
                                
                        					{
                				                xtype: 'tipologieEditTranslation'
                				            }]//CHIUSURA DATI GENERALI
                        
                                   }]                       
                      }];

        this.buttons = [
            {
                text: 'Save',
                action: 'save'
            },
            {
                text: 'Cancel',
                scope: this,
                handler: this.destroy
            }
        ];

        this.callParent(arguments);
    }
});