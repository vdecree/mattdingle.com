(function() { 
    var url = document.getElementById('hidden_url').value;

    // Creates a new plugin class and a custom listbox
    tinymce.PluginManager.add( 'onehalf' , function( editor ){
        editor.addButton('onehalf', {
            type: 'listbox',
            text: 'Shortcodes',
            tooltip: 'Shortcodes builder',
            fixedWidth: true,
            onselect: function(e) {
                switch(this.value()) {
                    case 'gmaps':
                        var tb = tb_show('', url + '/shortcodes/shortcodes_google_maps.php?TB_iframe=true')
                    break;
                    case 'vimeo':
                        var vimeo = prompt('Video', 'Enter video ID (eg. 46106724)');
                        window.parent.send_to_editor("[vimeo]" + vimeo + "[/vimeo]<br/>");   
                    break;
                    case 'icon_group':
                        window.parent.send_to_editor("[icon_group][/icon_group]");   
                    break;
                    case 'breadcrumbs':
                        window.parent.send_to_editor("[breadcrumbs /]");   
                    break;
                    case 'youtube':
                        var vimeo = prompt('Video', 'Enter video ID (eg. IG0wyXUcqZI)');
                        window.parent.send_to_editor("[youtube]" + vimeo + "[/youtube]<br/>");   
                    break;
                    case 'button':
                        var tb = tb_show('', url + '/shortcodes/shortcodes_button.php?TB_iframe=true');
                    break;
                    case 'custom-button':
                        var tb = tb_show('', url + '/shortcodes/shortcodes_custom_button.php?TB_iframe=true');
                    break;
                    case 'contact_success':
                        var tb = tb_show('', url + '/shortcodes/shortcodes_contact_success.php?TB_iframe=true');
                    break;
                    case 'quote_blog':
                        var tb = tb_show('', url + '/shortcodes/shortcodes_quote_blog.php?TB_iframe=true');
                    break;
                    case 'icon':
                        var tb = tb_show('', url + '/shortcodes/shortcodes_icon.php?TB_iframe=true'); 
                    break;
                    case 'columns':
                        var tb = tb_show('', url + '/shortcodes/shortcodes_columns.php?TB_iframe=true'); 
                    break;

                    case 'progress':
                        var tb = tb_show('', url + '/shortcodes/shortcodes_progress.php?TB_iframe=true'); 
                    break;

                    case 'person':
                        var tb = tb_show('', url + '/shortcodes/shortcodes_person.php?TB_iframe=true'); 
                    break;
                    case 'mark':
                        window.parent.send_to_editor('[mark style="primary"]Text[/mark]');
                    break;

                    case 'tooltip':
                        window.parent.send_to_editor('[tooltip text="Tooltip text" position="top"]Text[/tooltip]');
                    break;
                    case 'table':
                        window.parent.send_to_editor('[table][table_row][table_cell heading="true"]Text[/table_cell][/table_row][/table]');
                    break;
                    case 'popover':
                        window.parent.send_to_editor('[popover name="popover-1" text="Link text" style="link"]Inner Text[/popover]');
                    break;
                    case 'carousel':
                        window.parent.send_to_editor('[carousel background="carousel_back.png" full_width="true"]<br/>[carousel_slide][/carousel_slide]<br/>[carousel_slide][/carousel_slide]<br/>[carousel_slide][/carousel_slide]<br/>[/carousel]');
                    break;
                    case 'heading':
                        window.parent.send_to_editor('[heading]Text[/heading]');
                    break;
                    case 'posts':
                        window.parent.send_to_editor('[posts columns="5" orderby="date" order="DESC"]5[/posts]');
                    break;
                    case 'featured_posts':
                        window.parent.send_to_editor('[featured_posts theme="dark" columns="5" orderby="date" order="DESC"]5[/featured_posts]');
                    break;
                    case 'faq':
                        window.parent.send_to_editor('[faq][faq_item question="Lorem ipsum dolor."]Lorem ipsum doloum eros vulputate placerat sed non enim. Pellentesque eget.[/faq_item][/faq]');
                    break;

                    case 'code':
                        window.parent.send_to_editor('[code]HTML code[/code]');
                    break;
                    case 'alert':
                        var tb = tb_show('', url + '/shortcodes/shortcodes_alert.php?TB_iframe=true'); 
                    break;

                    case 'custom_buttom':
                        var tb = tb_show('', url + '/shortcodes/shortcodes_custom_button.php?TB_iframe=true'); 
                    break;

                    case 'list':
                        var tb = tb_show('', url + '/shortcodes/shortcodes_list.php?TB_iframe=true'); 
                    break;

                    case 'error_404':
                        var tb = tb_show('', url + '/shortcodes/error_404.php?TB_iframe=true'); 
                    break;

                    case 'blog': var tb = tb_show('', url + '/shortcodes/blog.php?TB_iframe=true'); break;
                    case 'box': var tb = tb_show('', url + '/shortcodes/box.php?TB_iframe=true'); break;
                    case 'color': var tb = tb_show('', url + '/shortcodes/color.php?TB_iframe=true'); break;
                    case 'team': var tb = tb_show('', url + '/shortcodes/team.php?TB_iframe=true'); break;
                    case 'logos':
                        window.parent.send_to_editor('[logos][logo alt="Logo 1" href="#"]http://astudio.si/preview/move/images/testing_images/logo-1.png[/logo][logo alt="Logo 2" href="#"]http://astudio.si/preview/move/images/testing_images/logo-2.png[/logo][/logos]');
                    break;
                    case 'statement': var tb = tb_show('', url + '/shortcodes/shortcodes_statement.php?TB_iframe=true'); break;
                }
            },
            values: [
                {text: 'Blog', value: 'blog'},
                {text: 'Box', value: 'box'},
                {text: 'Button', value: 'button'},
                {text: 'Color', value: 'color'},
                {text: 'Contact form', value: 'contact_success'},
                {text: 'Team', value: 'team'},
                {text: 'Logos', value: 'logos'},
                {text: 'Google maps', value: 'gmaps'},  
                {text: 'Youtube video', value: 'youtube'},
                {text: 'Breadcrumbs', value: 'breadcrumbs'},     
                {text: 'Vimeo video', value: 'vimeo'},   
                {text: 'Quote', value: 'quote_blog'},
                {text: 'Icon', value: 'icon'},
                {text: 'Icon group', value: 'icon_group'},
                {text: 'Column layout', value: 'columns'},
                {text: 'Progress bar', value: 'progress'},
                {text: 'Heading', value: 'heading'},
                {text: 'Statement', value: 'statement'},
                {text: 'Error 404', value: 'error_404'},
            ]
        });
    });
    
    tinymce.init({
        plugins: 'onehalf',
        toolbar: 'styleselect '
    });
})();