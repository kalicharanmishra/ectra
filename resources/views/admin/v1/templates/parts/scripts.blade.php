<script src="{{ asset('thrill/v1/vendors/js/vendors.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('thrill/v1/vendors/js/forms/toggle/switchery.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('thrill/v1/js/scripts/forms/switch.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('thrill/v1/js/scripts/tables/datatables/datatable-advanced.min.js') }}" type="text/javascript">

</script>

<script src="{{ asset('thrill/v1/js/scripts/forms/switch.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('thrill/v1/vendors/js/extensions/sweetalert2.all.js') }}" type="text/javascript"></script>

<script src="{{ asset('thrill/v1/vendors/js/extensions/toastr.min.js') }}" type="text/javascript"></script>

</script>

<script src="{{ asset('thrill/v1/js/scripts/extensions/toastr.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('thrill/v1/js/core/app-menu.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('thrill/v1/js/core/app.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('thrill/v1/js/scripts/customizer.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('thrill/v1/vendors/js/jquery.sharrre.js') }}" type="text/javascript"></script>

<script src="{{ asset('thrill/v1/js/scripts/extensions/sweet-alerts.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('thrill/v1/js/scripts/extensions/sweet-alerts.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('thrill/v1/js/scripts/forms/validation/form-validation.js') }}" type="text/javascript">

</script>

<script src="{{ asset('thrill/v1/vendors/js/tables/datatable/datatables.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('thrill/v1/js/scripts/tables/datatables-extensions/datatables-sources.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('thrill/v1/js/scripts/forms/select/select2.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('thrill/v1/js/custom.js') }}" type="text/javascript"></script>

<script src="https://www.jqueryscript.net/demo/Bootstrap-4-Tag-Input-Plugin-jQuery/tagsinput.js" type="text/javascript"> </script>

<script type="text/javascript" src="https://www.jqueryscript.net/demo/jQuery-Plugin-For-Custom-Tags-Input-Select-Box-selectize-js/selectize.js"></script>

<script>

				$('#tag').selectize({

					maxItems: 6

				});

				</script> 

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js">





</script>


<script>

    (function($) {

        'use strict';

        $(function() {

            if ($('.username').length) {

                $.fn.editable.defaults.mode = 'inline';

                $.fn.editableform.buttons =

                    '<button type="submit" class="btn btn-primary btn-sm editable-submit">' +

                    '<i class="fa fa-fw fa-check"></i>' +

                    '</button>' +

                    '<button type="button" class="btn btn-warning btn-sm editable-cancel">' +

                    '<i class="fa fa-fw fa-times"></i>' +

                    '</button>';

                $('.username').editable({

                    type: 'text',

                    pk: 1,

                    name: 'username',

                    url: '/post',

                    title: 'Enter username'

                });



            }

        });

    })(jQuery);

</script>

<script type="text/javascript" src="https://hybridplus.in/vendor/ckeditor/ckeditor.js"></script>

<script>

       

            var editor =  CKEDITOR.replace('description', { 

               extraPlugins: 'autogrow,embed,uicolor,menubutton,colordialog,dialog,dialogui,panelbutton,floatpanel,panel,button,simplebutton,colorbutton',

              removePlugins: 'resize,widget,embedbase,embed',

              embed_provider : '//ckeditor.iframe.ly/api/oembed?url={url}&callback={callback}',

              enterMode: CKEDITOR.ENTER_BR,

              

             

              filebrowserImageUploadUrl : "/upload/image?_token=BuSolHsKphuW9sIIXeemSxu6WZJuV3fLFk772PWg",

          filebrowserUploadMethod: 'xhr'

        

    

              // Remove the redundant buttons from toolbar groups defined above.

            //   removeButtons: 'Subscript,Superscript,Anchor,Styles,Specialchar',

            });

            var editor2 =  CKEDITOR.replace('description2', { 

               extraPlugins: 'autogrow,embed,uicolor,menubutton,colordialog,dialog,dialogui,panelbutton,floatpanel,panel,button,simplebutton,colorbutton',

              removePlugins: 'resize,widget,embedbase,embed',

              embed_provider : '//ckeditor.iframe.ly/api/oembed?url={url}&callback={callback}',

              enterMode: CKEDITOR.ENTER_BR,

              

             

              filebrowserImageUploadUrl : "/upload/image?_token=BuSolHsKphuW9sIIXeemSxu6WZJuV3fLFk772PWg",

          filebrowserUploadMethod: 'xhr'

        

    

              // Remove the redundant buttons from toolbar groups defined above.

            //   removeButtons: 'Subscript,Superscript,Anchor,Styles,Specialchar',

            });

            



</script>