process.env.DISABLE_NOTIFIER = true;

const elixir = require('laravel-elixir');


/*var elixir = require('laravel-elixir');
var BrowserSync = require('laravel-elixir-browsersync2');

elixir(function(mix) {
	BrowserSync.init();
	mix.BrowserSync(
	{
		proxy 			: "homestead.app",
        logPrefix		: "Laravel Eixir BrowserSync",
        logConnections	: false,
        reloadOnRestart : false,
        notify 			: false
	});
});*/

/*elixir((mix) => {
	mix.webpack('design.js')
});*/

/*elixir((mix) => {
    mix.sass('main.sass')
       .webpack(['app.js','design.js','folders.js','../libs/mmenu/jquery.mmenu.all.js'])
       .browserSync({
       		proxy:'localhost:8000',
       		notify:false
   		});
});*/

elixir((mix) =>{
  mix.sass('main.sass')
    .scripts(['scripts.min.js','common.js','journal.js','search.js','design.js','folders.js','library.js','library_design.js','../libs/mmenu/jquery.mmenu.all.js'])
    .browserSync({
      proxy:'localhost:8000',
      notify:false
    });
});



//require('laravel-elixir-vue-2');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

/*elixir(mix => {
    mix.webpack('app.js');
});*/

/*elixir(function(mix){
	mix.sass(['main.sass','search.sass'])
	.browserSync();
});*/
