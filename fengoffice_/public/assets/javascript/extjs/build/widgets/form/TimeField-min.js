/*
 * Ext JS Library 2.0.1
 * Copyright(c) 2006-2007, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */

Ext.form.TimeField=Ext.extend(Ext.form.ComboBox,{minValue:null,maxValue:null,minText:"The time in this field must be equal to or after {0}",maxText:"The time in this field must be equal to or before {0}",invalidText:"{0} is not a valid time",format:"g:i A",altFormats:"g:ia|g:iA|g:i a|g:i A|h:i|g:i|H:i|ga|ha|gA|h a|g a|g A|gi|hi|gia|hia|g|H",increment:15,mode:"local",triggerAction:"all",typeAhead:false,initComponent:function(){Ext.form.TimeField.superclass.initComponent.call(this);if(typeof this.minValue=="string"){this.minValue=this.parseDate(this.minValue)}if(typeof this.maxValue=="string"){this.maxValue=this.parseDate(this.maxValue)}if(!this.store){var B=this.parseDate(this.minValue);if(!B){B=new Date().clearTime()}var A=this.parseDate(this.maxValue);if(!A){A=new Date().clearTime().add("mi",(24*60)-1)}var C=[];while(B<=A){C.push([B.dateFormat(this.format)]);B=B.add("mi",this.increment)}this.store=new Ext.data.SimpleStore({fields:["text"],data:C});this.displayField="text"}},getValue:function(){var A=Ext.form.TimeField.superclass.getValue.call(this);return this.formatDate(this.parseDate(A))||""},setValue:function(A){Ext.form.TimeField.superclass.setValue.call(this,this.formatDate(this.parseDate(A)))},validateValue:Ext.form.DateField.prototype.validateValue,parseDate:Ext.form.DateField.prototype.parseDate,formatDate:Ext.form.DateField.prototype.formatDate,beforeBlur:function(){var A=this.parseDate(this.getRawValue());if(A){this.setValue(A.dateFormat(this.format))}}});Ext.reg("timefield",Ext.form.TimeField);