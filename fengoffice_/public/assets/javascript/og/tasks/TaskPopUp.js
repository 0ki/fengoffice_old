og.TaskPopUp = function(action) {
    var html_option  = "<div style='width:100%; margin: 10px; padding: 10px;'>";
        html_option += "<div>" + lang('apply changes to') + "</div>";
        html_option += "<div><input type='radio' name='type_related' value='only' onclick='selectRelated(this.value)' checked/>" + lang('only this task') + "</div>";
        html_option += "<div><input type='radio' name='type_related' value='news' onclick='selectRelated(this.value)'/>" + lang('this task alone and all to come forward') + "</div>";
        html_option += "<div><input type='radio' name='type_related' value='all' onclick='selectRelated(this.value)'/>" + lang('all tasks related') + "</div>";
        html_option += "<div><input type='hidden' name='action_related' id='action_related' value='" + action + "'/></div>";
        html_option += "</div>";
    og.TaskPopUp.superclass.constructor.call(this, {
                y: 220,
                width: 350,
                height: 230,
                id: 'task-related',
                layout: 'border',
                modal: true,
                resizable: false,
                closeAction: 'close',
                border: false,
                buttons: [{
                        text: lang('accept'),
                        handler: this.accept,
                        scope: this
                }],
                items: [{
                        region: 'center',
                        layout: 'fit',
                        html: html_option
                }]
        });
}