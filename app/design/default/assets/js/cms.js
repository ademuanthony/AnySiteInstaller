/**
 * Created by Tony on 6/29/2015.
 */

// Uncomment the following code to test the "Timeout Loading Method".
    // CKEDITOR.loadFullCoreTimeout = 5;

window.onload = function() {
    // Listen to the double click event.
    if ( window.addEventListener )
        document.body.addEventListener( 'dblclick', onDoubleClick, false );
    else if ( window.attachEvent )
        document.body.attachEvent( 'ondblclick', onDoubleClick );

};

function onDoubleClick( ev ) {
    // Get the element which fired the event. This is not necessarily the
    // element to which the event has been attached.
    var element = ev.target || ev.srcElement;

    // Find out the div that holds this element.
    var name;

    do {
        element = element.parentNode;
    }
    while ( element && ( name = element.nodeName.toLowerCase() ) &&
    ( name != 'div' || element.className.indexOf( 'editable' ) == -1 ) && name != 'body' );

    if ( name == 'div' && element.className.indexOf( 'editable' ) != -1 )
        replaceDiv( element );
}

var editor;

function replaceDiv( div ) {
    if ( editor )
        editor.destroy();

    editor = CKEDITOR.replace( div );
    prepareSubmitter(div);
}

function prepareSubmitter(div){
    console.log(jQuery(div));
    var jDiv = jQuery(div);
    $('#html_editor_id').val(jDiv.attr('data-cms-id'));
    $('#html_editor_key').val(jDiv.attr('data-cms-key'));
    jQuery('div.cms-submitter').show();
}
function hideEditor(){
    if(editor && (editor != undefined)) {
        editor.destroy();
        editor = null;
        jQuery('div.cms-submitter').hide();
    }
}
jQuery('.raw_editable').dblclick(function(){
    hideEditor();
    $('#raw_editor_id').val($(this).attr('data-cms-id'));
    $('#raw_editor_key').val($(this).attr('data-cms-key'));
    $('#raw_editor_body').val($(this).text().trim());
    jQuery('#raw_content_editor').modal('show');
});

jQuery('#html_editor_btn_cancel').click(function () {
    hideEditor();
});

jQuery('#html_editor_btn_save').click(function () {
    $('#html_editor_body').val(encodeURIComponent(editor.getData()));
    hideEditor();
    return true;
});