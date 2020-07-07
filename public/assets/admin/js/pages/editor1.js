
    $(function() {
        // CKEditor Standard
        $('textarea#ckeditor_standard').ckeditor({
            height: '150px',
            toolbar: [{
                    name: 'document',
                    items: ['Source', '-', 'NewPage', 'Preview', '-', 'Templates']
                }, // Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
                ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo'], // Defines toolbar group without name.
                {
                    name: 'basicstyles',
                    items: ['Bold', 'Italic']
                }
            ]
        });

        // CKEditor Full
        $('textarea#ckeditor_full').ckeditor({
            height: '200px'
        });

        // The "instanceCreated" event is fired for every editor instance created.
        CKEDITOR.on('instanceCreated', function(event) {
            var editor = event.editor,
                element = editor.element;

            // Customize editors for headers and tag list.
            // These editors don't need features like smileys, templates, iframes etc.
            if (element.is('h1', 'h2', 'h3') || element.getAttribute('id') == 'taglist') {
                // Customize the editor configurations on "configLoaded" event,
                // which is fired after the configuration file loading and
                // execution. This makes it possible to change the
                // configurations before the editor initialization takes place.
                editor.on('configLoaded', function() {

                    // Remove unnecessary plugins to make the editor simpler.
                    editor.config.removePlugins = 'colorbutton,find,flash,font,' +
                        'forms,iframe,image,newpage,removeformat,' +
                        'smiley,specialchar,stylescombo,templates';

                    // Rearrange the layout of the toolbar.
                    editor.config.toolbarGroups = [{
                    	filebrowserBrowseUrl: '../../vendors/ckeditor/kcfinder/browse.php?type=files',
						filebrowserImageBrowseUrl: '../../vendors/ckeditor/kcfinder/browse.php?type=images',
						filebrowserFlashBrowseUrl: '../../vendors/ckeditor/kcfinder/browse.php?type=flash',
						filebrowserUploadUrl: '../../vendors/ckeditor/kcfinder/upload.php?type=files',
						filebrowserImageUploadUrl: '../../vendors/ckeditor/kcfinder/upload.php?type=images',
						filebrowserFlashUploadUrl: '../../vendors/ckeditor/kcfinder/upload.php?type=flash'
                    },{
                        name: 'editing',
                        groups: ['basicstyles', 'links']
                    }, {
                        name: 'undo'
                    }, {
                        name: 'clipboard',
                        groups: ['selection', 'clipboard']
                    }, {
                        name: 'about'
                    }];
                });
            }
        });
        // TinyMCE Basic
        tinymce.init({
            selector: "#tinymce_basic",
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste"
            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
        });

        // TinyMCE Full
        tinymce.init({
            selector: "#tinymce_full",
            file_browser_callback :  function (field_name, url, type, win) {

			    // alert("Field_Name: " + field_name + "nURL: " + url + "nType: " + type + "nWin: " + win); // debug/testing
			
			    /* If you work with sessions in PHP and your client doesn't accept cookies you might need to carry
			       the session name and session ID in the request string (can look like this: "?PHPSESSID=88p0n70s9dsknra96qhuk6etm5").
			       These lines of code extract the necessary parameters and add them back to the filebrowser URL again. */
			
			    var cmsURL = window.location.toString();    // script URL - use an absolute path!
			    if (cmsURL.indexOf("?") < 0) {
			        //add the type as the only query parameter
			        cmsURL = cmsURL + "?type=" + type;
			    }
			    else {
			        //add the type as an additional query parameter
			        // (PHP session ID is now included if there is one at all)
			        cmsURL = cmsURL + "&type=" + type;
			    }
			
			    tinyMCE.activeEditor.windowManager.open({
			        file : cmsURL,
			        title : 'My File Browser',
			        width : 420,  // Your dimensions may differ - toy around with them!
			        height : 400,
			        resizable : "yes",
			        inline : "yes",  // This parameter only has an effect if you use the inlinepopups plugin!
			        close_previous : "no"
			    }, {
			        window : win,
			        input : field_name
			    });
			    return false;
			  },
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor"
            ],
            toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
            toolbar2: "print preview media | forecolor backcolor emoticons",
            image_advtab: true,
            templates: [{
                title: 'Test template 1',
                content: 'Test 1'
            }, {
                title: 'Test template 2',
                content: 'Test 2'
            }]
        });
        
        
       
    });
    
    
