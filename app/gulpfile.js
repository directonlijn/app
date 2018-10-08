// var elixir = require('laravel-elixir');
//
// /*
//  |--------------------------------------------------------------------------
//  | Elixir Asset Management
//  |--------------------------------------------------------------------------
//  |
//  | Elixir provides a clean, fluent API for defining some basic Gulp tasks
//  | for your Laravel application. By default, we are compiling the Sass
//  | file for our application, as well as publishing vendor resources.
//  |
//  */
//
// elixir(function(mix) {
//     mix.sass('app.scss');
// });

var gulp = require('gulp'),
    debug = require('gulp-debug'),
    concat = require('gulp-concat'),
    uglify = require('gulp-uglifyjs'),
    watch = require('gulp-watch'),
    sass = require('gulp-sass'),
    minimist = require('minimist'),
    livereload = require('gulp-livereload');

// Arguments
var knownOptions = {
    string: 'domain',
    string: 'markt'
};

// Create variable from cli
var options = minimist(process.argv.slice(2), knownOptions);
var markt = (typeof options.markt != 'undefined') ? options.markt : '';
var domain = (typeof options.domain != 'undefined') ? options.domain : '';

gulp.task('concat-js', function () {
    var file_list = VENDOR_COMPONENTS.concat(PROJECT_COMPONENTS);
	return  gulp.src("resources/views/domains/"+domain+"/"+folder+"/scripts/**/*.js")
        .pipe(concat('all.js'))
	 	.pipe(debug())
       	.pipe(uglify('all.js'))
        .on('error', swallowError)
        .pipe(gulp.dest("public/campaigns/"+folder+"/script/"));
});

gulp.task('watch-scss', function () {
    livereload.listen();
    gulp.watch("resources/views/domains/"+domain+"/style/**/*.scss", ['compile-scss']);
});

gulp.task('compile-scss', function () {
    return gulp.src("resources/views/domains/"+domain+"/style/main.scss")
            .pipe(debug())
            .pipe(sass({ outputStyle: 'compressed' }).on('error', swallowError))
            .pipe(debug())
            .pipe(concat('all.css'))
            .pipe(debug())
            .pipe(gulp.dest("../public_html/"+domain+"/style/"))
            .pipe(debug())
            .pipe(livereload());
});

function swallowError(error) {
    // If you want details of the error in the console
    console.log(error.toString())
    this.emit('end')
}