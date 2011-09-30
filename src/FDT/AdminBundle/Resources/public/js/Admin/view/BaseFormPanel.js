Ext.define('Admin.view.BaseFormPanel', {
    extend: 'Ext.form.Panel',
    
    autoRender: true,
    autoScroll: true,
    deferredRender: false,
    anchor: '100%',
    bodyPadding: 5,
    margin: 2,
    border: true,
    defaults: { // defaults are applied to items, not the container
        textfield: 'textfield',
        labelAlign: 'left',
        labelPad: 3,
        allowBlank: false,
        anchor:'100%',
        autoHeight:true,
        bodyStyle:'padding:10px',
        enableKeyEvents:true,
        listeners:{
            specialKey: function(field, el)
            {
                if(el.getKey() == Ext.EventObject.ENTER)
                {
                    Ext.getCmp('buttonSave').fireEvent('click', Ext.getCmp('buttonSave'));
            }
        }
  }
        
        
        
    },
    focusFirstField: function (selectText)
    {
        var fields = this.getForm().getFields();
        fields = fields.filter ('xtype', 'textfield');
        fields.getAt(0).focus();
        if (selectText)
        {
           fields.getAt(0).selectText(); 
        }
        
    }
});