
# CoreAdmin
The admin page for the web is built with Laravel framework 

## Installation

Via Composer

``` bash
$ composer require phobrv/coreadmin
```

## Usage

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Note
Package use AdminLTE  Bootstrap Admin Dashboard Template (v2.4.13)
### CSS 

    mix.styles([
    'resources/assets/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css',
    'resources/assets/adminlte/bower_components/font-awesome/css/font-awesome.min.css',
    'resources/assets/adminlte/bower_components/Ionicons/css/ionicons.min.css',
    'resources/assets/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css',
    'resources/assets/adminlte/dist/css/AdminLTE.min.css',
    'resources/assets/adminlte/dist/css/skins/_all-skins.min.css',
    'resources/assets/adminlte/plugins/iCheck/square/blue.css',
    'resources/assets/adminlte/bower_components/select2/dist/css/select2.css',
    'resources/assets/adminlte/bower_components/morris.js/morris.css',
    'resources/css/admin.css',
    ], 'public/css/admin.css').version();


### JS

    mix.combine([
    'resources/assets/adminlte/bower_components/jquery/dist/jquery.min.js',
    'resources/assets/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js',
    'resources/assets/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js',
    'resources/assets/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js',
    'resources/assets/adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js',
    'resources/assets/adminlte/bower_components/fastclick/lib/fastclick.js',
    'resources/assets/adminlte/dist/js/adminlte.min.js',
    'resources/assets/adminlte/dist/js/demo.js',
    'resources/assets/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js',
    'resources/assets/adminlte/bower_components/select2/dist/js/select2.js',
    'resources/assets/ckeditor/ckeditor.js',
    'resources/assets/ckeditor/config.js',
    'resources/assets/adminlte/bower_components/raphael/raphael.min.js',
    'resources/assets/adminlte/bower_components/morris.js/morris.min.js',
    'public/vendor/laravel-filemanager/js/stand-alone-button.js',  
    ], 'public/js/admin.js')
    .options({
       processCssUrls: false
     }); 


